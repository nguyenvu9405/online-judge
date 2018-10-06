<?php
class Submission
{
    private $db;
    private $sub_data;
    private $prob, $user;
    private static $submissionsFolder = "submissions/";
    private static $fileName = array(
        "submission"=>"submission.cpp"
    );

    public function __construct($data)
    {
        $this->db = DB::getInstance();
        $this->setData($data);
        $this->prob = new Problem(array(
            "id"=>$data["problem_id"],  //problems.code, problems.uploader_id, problems.title
            "code"=>$data["code"],
            "title"=>$data["title"],
            "uploader_id"=>$data["uploader_id"]
        ));
        $this->user = new User(array(
            "id"=>$data["user_id"],
            "name"=>$data["name"],
            "username"=>$data["username"]
        ));
    }

    public function setData($data)
    {
        $this->sub_data = $data;
    }

    public function setField($field, $value)
    {
        $this->sub_data[$field] = $value;
    }

    public function getProblem()
    {
        return $this->prob;
    }

    public function getSubmitter()
    {
        return $this->user;
    }

    public function getId()
    {
        return $this->sub_data["id"];
    }

    public function getStatus()
    {
        return $this->sub_data["status"];
    }

    public function getError()
    {
        return $this->sub_data["errors"];
    }

    public function getTestNum()
    {
        return $this->sub_data["test_num"];
    }

    public function getLang()
    {
        return $this->sub_data["lang_name"];
    }

    public function getTime()
    {
        return $this->sub_data["time"];
    }

    public function getMemory()
    {
        return $this->sub_data["mem"];
    }

    public function getTimeInSecs()
    {
        return sprintf('%0.2f',$this->getTime()/1000);
    }

    public function getMemInMb()
    {
        return intdiv($this->getMemory(),1024);
    }


    public function getSubmissionFolder()
    {
        return self::$submissionsFolder.$this->sub_data["id"];
    }

    public function createDirectory()
    {
        if (!is_dir($this->getSubmissionFolder()))
            return mkdir($this->getSubmissionFolder(),0777,true);
        else return true;
    }

    public function getRelativePath($field)
    {
        return $this->getSubmissionFolder()."/".self::$fileName[$field];
    }

    public function insertToDB()
    {
        if ($this->db)
        {
            $this->db->insert("subs",$this->sub_data);
            $this->sub_data["id"]= $this->db->getLastID();
            return $this->sub_data["id"];
        }
        else return false;
    }

    public function pasteCode($code)
    {
        $file = fopen($this->getRelativePath("submission"),"w");
        if ($file)
            return fwrite($file, $code,4000);
        else
            return false;
    }

    public function judgeCode($code)
    {
        $db = DB::getInstance();
        global $cuser;
        try{
            $db->txBegin();
            if ($this->sub_data["lang_id"]!=$cuser->getLatestLangId())
                $db->txExecute("UPDATE users SET `lang_id`=? WHERE `id`=?", array($this->sub_data["lang_id"], $cuser->getId()));
            $db->txInsert("subs",$this->sub_data);
            $this->sub_data["id"] = $db->getLastID();
            if ($this->createDirectory() && $this->pasteCode($code))
            {
                $socket = socket_create(AF_INET, SOCK_STREAM,getprotobyname("tcp"));
                if (socket_connect($socket,"127.0.0.1",1111))
                {
                    socket_write($socket,"{$this->sub_data["id"]} {$this->sub_data["problem_id"]} {$this->sub_data["user_id"]} {$this->sub_data["lang_id"]}\n");
                    $db->txCommit();
                    socket_close($socket);
                    Session::flash("sub_id",$this->sub_data["id"]);
                    return true;
                }
                else
                {
                    $db->txRollBack();
                    Session::flashErrorMsg(ErrorMessages::getSocketMsg());
                    return false;
                }

            }
            else {
                $db->txRollBack();
                Session::flashErrorMsg("ok");
                return false;
            }

        }
        catch (PDOException $e){
            $db->txRollBack();
            Session::flashErrorMsg(ErrorMessages::getDBMsg());
            return false;
        }
        finally
        {
            if ($socket) socket_close($socket);
        }
    }

    public function judge()
    {
        $db = DB::getInstance();
        global $cuser;
        try{
            $db->txBegin();
            if ($this->sub_data["lang_id"]!=$cuser->getLatestLangId())
                $db->txExecute("UPDATE users SET `lang_id`=? WHERE `id`=?", array($this->sub_data["lang_id"], $cuser->getId()));
            $db->txInsert("subs",$this->sub_data);
            $this->sub_data["id"] = $db->getLastID();
            if ($this->createDirectory() && move_uploaded_file($_FILES["submission"]["tmp_name"], $this->getRelativePath("submission")))
            {
                $socket = socket_create(AF_INET, SOCK_STREAM,getprotobyname("tcp"));
                if (socket_connect($socket,"127.0.0.1",1111))
                {
                    socket_write($socket,"{$this->sub_data["id"]} {$this->sub_data["problem_id"]} {$this->sub_data["user_id"]} {$this->sub_data["lang_id"]}\n");
                    $db->txCommit();
                    socket_close($socket);
                    Session::flash("sub_id",$this->sub_data["id"]);
                    return true;
                }
                else
                {
                    $db->txRollBack();
                    Session::flashErrorMsg(ErrorMessages::getSocketMsg());
                    return false;
                }

            }
            else {
                $db->txRollBack();
                Session::flashErrorMsg(ErrorMessages::getFileUploadMsg());
                return false;
            }

        }
        catch (PDOException $e){
            $db->txRollBack();
            Session::flashErrorMsg(ErrorMessages::getDBMsg());
            return false;
        }
        finally
        {
            if ($socket) socket_close($socket);
        }
    }

    public static function getSubmissionsNumber($vars=array())
    {
        $db = DB::getInstance();
        $conds="";
        $pars = array();
        if (!empty($vars["user"]))
        {
            $str="users.username=?"; $pars[]=$vars['user'];
            $conds="WHERE $str";
        }
        if (!empty($vars["code"]))
        {
            $str="problems.code=?"; $pars[]=$vars['code'];
            if (!empty($conds)) $conds.=" AND $str";
            else $conds="WHERE $str";
        }

        if ($db->query(
            "SELECT count(subs.id) as num
                 FROM subs 
                 LEFT JOIN problems ON subs.problem_id=problems.id 
                 LEFT JOIN users ON subs.user_id=users.id
                 $conds",
            $pars
        ))
        {
            return $db->getFirstItem()["num"];
        }
        else return false;
    }

    public static function getSubmissionById($id)
    {
        $db = DB::getInstance();
        $pars = array($id);
        if ($db->query("SELECT subs.id, subs.user_id, subs.status, subs.test_num, subs.errors, subs.time, subs.mem, users.name, users.username, problems.code, problems.uploader_id, problems.title, langs.name as lang_name                         
                            FROM subs
                            LEFT JOIN problems ON subs.problem_id=problems.id 
                            LEFT JOIN users ON subs.user_id=users.id 
                            LEFT JOIN langs ON subs.lang_id=langs.id 
                            WHERE subs.id=? LIMIT 1", $pars))
        {
            $res = $db->getFirstItem();
            if ($res)
                return new Submission($res);
            else
                return false;
        }
        else
            return false;
    }

    public static function selectSubmission($num,$offset,$vars=array())
    {

        $db = DB::getInstance();
        $num=intval($num);
        $offset = max(intval($offset),0);
        $conds = ""; $pars=array();
        if (!empty($vars["user"]))
        {
            $str="users.username=?"; $pars[]=$vars['user'];
            $conds="WHERE $str";
        }
        if (!empty($vars["code"]))
        {
            $str="problems.code=?"; $pars[]=$vars['code'];
            if ($conds) $conds.=" AND $str";
            else $conds="WHERE $str";
        }

        if ($db->query(
            "SELECT subs.id, subs.user_id, subs.status, subs.test_num, subs.errors, subs.time, subs.mem, users.name, users.username, problems.code, problems.uploader_id, problems.title, langs.name as lang_name                         
                 FROM subs
                 LEFT JOIN problems ON subs.problem_id=problems.id 
                 LEFT JOIN users ON subs.user_id=users.id 
                 LEFT JOIN langs ON subs.lang_id=langs.id 
                 $conds ORDER BY subs.id DESC LIMIT $num OFFSET $offset",
                 $pars
        ))
        {
            return $db->getResults();
        }
        else return false;
    }
    
    public static function getStatusMsg($status, $test_num, $error)
    {
        $long_msg="";
        $short_msg="";  
        if ($status<100)
        {
            switch ($status)
            {
                case 0:
                    $long_msg="Submiting";
                    $short_msg="";
                    break;
                case 1:
                    $long_msg="Compilling";
                    $short_msg="";
                    break;
                case 2:
                    $long_msg="Running on test $test_num";
                    $short_msg=$test_num;
                    break;  
            }
        }
        else if ($status<200)
        {
            switch ($status)
            {
                case 100:
                    $long_msg="Compile Error";
                    $short_msg="CE";
                    break; 
                case 101:
                    $long_msg="Time limit exceeded on test $test_num";
                    $short_msg="TLE-$test_num";
                    break;
                case 102:
                    $long_msg="Mem limit exceeded on test $test_num";
                    $short_msg="MLE-$test_num";
                    break;
                case 103:
                    $long_msg="Output limit exceeded on test $test_num";
                    $short_msg="OLE-$test_num";
                    break;
                case 197:
                    $long_msg="System error";
                    $short_msg="SysError";
                    break;
                case 198:
                    $long_msg="$error";
                    $short_msg="Error";
                    break;
                case 199:
                    $long_msg="Wrong answer on test $test_num";
                    $short_msg="WA-$test_num"; 
                    break;

            }
        }
        else if ($status==200)
        {
            $long_msg="Accepted";
            $short_msg="AC";
        }
        return "<span class='desktop-txt'>{$long_msg}</span>
                <span class='mobile-txt'>{$short_msg}</span>";
    }

    public function getStatusContent()
    {
        $status = $this->getStatus();
        $test_num = $this->getTestNum();
        $error = $this->getError();
        $msg = self::getStatusMsg($status, $test_num, $error);
        
        if ($status<100)
        {
            return "<span class='processing' id='result_{$this->getId()}'>$msg</span>";
        }        
        else if ($status<200)
        {
            return "<span class='error'>$msg</span>";
        }
        else if ($status==200)
        {
            return "<span class='accepted'>$msg</span>";
        }
    }

    public function getCode()
    {
        $sub_id = intval($this->getId());
        $path = "submissions/$sub_id/submission.cpp";
        $code_file=fopen($path,"r");
        $str = fread($code_file,filesize($path));
        fclose($code_file);
        return $str;
    }



}