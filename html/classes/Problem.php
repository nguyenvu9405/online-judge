<?php

class Problem
{
    private $db;
    private $problem_data, $tags_data;
    private $uploader;
    private static $problems_folder = "problems-storage/";
    public function __construct($data,$tags=array())
    {
        $this->db = DB::getInstance();
        $this->setData($data);
        $this->setTags($tags);
        $this->uploader = new User(array(
            "id"=>$data["uploader_id"],
            "username"=>$data["username"]
        ));
    }

    public function setData($data)
    {
        $this->problem_data = $data;
    }

    public function getData()
    {
        return $this->problem_data;
    }


    public function getUploader()
    {
        return $this->uploader;
    }

    public function getId()
    {
        return $this->problem_data["id"];
    }

    public function getCode()
    {
        return $this->problem_data["code"];
    }

    public function getTitle()
    {
        return $this->problem_data["title"];
    }

    public function getDefinition()
    {
        return $this->problem_data["definition"];
    }

    public function getUploaderId()
    {
        return $this->problem_data["uploader_id"];
    }

    public function getTestcaseVer()
    {
        return $this->problem_data["testcases_ver"];
    }

    public function getTimeLimit()
    {
        return $this->problem_data["timelimit"];
    }

    public function getMemoryLimit()
    {
        return $this->problem_data["memorylimit"];
    }

    public function setTags($tags)
    {
        $this->tags_data = $tags;
    }

    public function getTestFolder()
    {
        return "tests_".$this->getTestcaseVer();
    }

    public function getInputName()
    {
        return $this->problem_data["input_name"];
    }

    public function getOutputName()
    {
        return $this->problem_data["output_name"];
    }

    public function getSolutionLink()
    {
        return $this->problem_data["sol_link"];
    }

    public function showSol()
    {
        if ($this->problem_data["show_sol"]=="1")
            return true;
        else
            return false;
    }

    public function add($zip)
    {
        if ($this->db)
        {
            try{

                $this->db->txBegin();
                $this->db->txInsert("problems",$this->getData());
                $this->problem_data["id"] = $this->db->getLastID();
                $str= "INSERT INTO tags_problems_map(`tag`,`problem_id`) VALUES(?,?)";
                foreach ($this->tags_data as $tag)
                {
                    $this->db->txExecute($str,array($tag,$this->problem_data["id"]));
                }
                $this->createDirectory($this->getTestFolder());
                $zip->extractTo($this->getDirectory($this->getTestFolder()));
                $this->db->txCommit();
            }
            catch(Exception $e){
                echo $e->getMessage();
                $this->db->txRollBack();
                return false;
            }
            return true;
        }
        else return false;
    }

    public function getProblemFolder()
    {
        return self::$problems_folder.$this->getId();
    }

    public function getDirectory($field="")
    {
        return $this->getProblemFolder()."/".$field;
    }

    public function createDirectory($field="")
    {
        mkdir($this->getDirectory($field),0777,true);
    }

    public static function selectProblems($cond="",$values=array(),$fields=array("*"),$limit=0,$offset=0)
    {
        $db = DB::getInstance();
        global $cuser;
        $str="";
        if ($cuser)
        {
            $str="SELECT problems.date, problems.code, problems.title, results.status  
                  FROM problems 
                  LEFT JOIN  results ON problems.id=results.problem_id AND results.user_id={$cuser->getId()}
                  ORDER BY problems.id 
                  LIMIT $limit OFFSET $offset                  
              ";
        }
        else
        {
            $str="SELECT problems.date, problems.code, problems.title
                  FROM problems       
                  ORDER BY problems.id         
                  LIMIT $limit OFFSET $offset
              ";
        }
        if ($db->query($str))
        {
            return $db->getResults();
        }
        else return false;
    }

    public static function getProblemsByTagsNumber($tags)
    {
        $db = DB::getInstance();
        $str = DB::createQuestionMarks(count($tags));
        if ($db->query("SELECT COUNT(DISTINCT problem_id) as num
                            FROM tags_problems_map                              
                            WHERE tag IN ($str)",$tags))
        {
            return $db->getFirstItem()["num"];
        }
        else return false;
    }

    public static function selectProblemsByTags($tags)
    {
        $db = DB::getInstance();
        $ranges = DB::createQuestionMarks(count($tags));
        global $cuser;
        $str = "";

        if ($cuser)
        {
            $str = "SELECT problems.date, problems.code, problems.title, ANY_VALUE(results.status) as status
                    FROM tags_problems_map 
                    LEFT JOIN problems ON tags_problems_map.problem_id=problems.id
                    LEFT JOIN results ON results.problem_id=problems.id AND results.user_id={$cuser->getId()} 
                    WHERE tag IN ($ranges) 
                    GROUP BY tags_problems_map.problem_id ORDER BY count(*) DESC";
        }
        else
        {
            $str = "SELECT problems.date, problems.code, problems.title
                    FROM tags_problems_map 
                    LEFT JOIN problems ON problem_id=problems.id 
                    WHERE tag IN ($ranges) 
                    GROUP BY problem_id ORDER BY count(*) DESC";
        }
        if ($db->query($str,$tags))
        {
            return $db->getResults();
        }
        else return false;
    }

    public static function getProblemsNumber()
    {
        $db = DB::getInstance();
        if ($db->query("SELECT count(id) as num FROM problems"))
        {
            return $db->getFirstItem()["num"];
        }
        else return false;
    }

    public static function selectProblem($cond="",$values=array())
    {
        $db = DB::getInstance();
        global $cuser;
        $str=0;
        if ($cuser)
        {
            $str = "SELECT problems.*, users.username, results.status 
                    FROM problems 
                    LEFT JOIN users ON problems.uploader_id=users.id 
                    LEFT JOIN results ON results.problem_id = problems.id AND results.user_id = {$cuser->getId()}
                    WHERE $cond LIMIT 1";
        }
        else
        {
            $str = "SELECT problems.*, users.username
                    FROM problems 
                    LEFT JOIN users ON problems.uploader_id=users.id 
                    WHERE $cond LIMIT 1";
        }

        if ($db->query($str,$values))
        {
            $result = $db->getFirstItem();
            if ($result)
                return new Problem($result);
            else
                return false;
        }
        else return false;
    }

    public static function selectProblemInfo($cond="",$values=array())
    {
        $db = DB::getInstance();
        if ($db->query("SELECT problems.id, problems.code, problems.title, problems.timelimit, problems.memorylimit, users.username, problems.date
                            FROM problems 
                            LEFT JOIN users ON problems.user_id=users.id 
                            WHERE $cond LIMIT 1",$values)
        )
        {
            return $db->getFirstItem();
        }
        else return false;
    }

    public static function selectTags($cond="",$values=array())
    {
        $db = DB::getInstance();
        if ($db->query("SELECT tag FROM tags_problems_map WHERE $cond LIMIT 5",$values))
        {
            return $db->getResults();
        }
        else return false;
    }


    public function updateDB($data)
    {
        $db = DB::getInstance();
        if ($db->update("problems","id = ?", array($this->getId()),$data))
        {

            return true;
        }
        else return false;
    }

    public function updateTagsDB($data)
    {
        $db = DB::getInstance();
        $in = DB::createQuestionMarks(count($data));

        try
        {
            $db->txBegin();
            $db->txQueryUpdate("DELETE FROM tags_problems_map WHERE problem_id= {$this->getId()} AND tag NOT IN ($in)", $data);
            $str= "INSERT IGNORE INTO tags_problems_map(`tag`,`problem_id`) VALUES(?,?)";
            $ps = $db->txPrepare($str);
            foreach ($data as $tag)
            {
                $db->txExecutePS($ps,array($tag,$this->problem_data["id"]));

            }
            $db->txCommit();
        }
        catch (PDOException $e)
        {
            $db->txRollBack();
            return false;
        }
        return true;

    }

    public function update($data)
    {
        foreach ($data as $key=>$val)
        {
            $this->problem_data[$key] = $val;
        }
    }

    public static function check_testcase_format($problem_data)
    {
        global $errs,$zip;
        $return_code = $zip->open($_FILES["testcases"]["tmp_name"]);
        if ($return_code===true) {
            for ($i = 0, $len = $zip->numFiles; $i < $len; $i++) {
                $name = $zip->getNameIndex($i);
                if (substr($name, -1, 1) == '/') {
                    if ($zip->locateName("$name" . $problem_data["input_name"]) === false) {
                        $errs["testcases"] = "Cannot find the input file in folder: " . $name;
                        return false;
                    }
                    if ($zip->locateName("$name" . $problem_data["output_name"]) === false) {
                        $errs["testcases"] = "Cannot find the output file in folder: " . $name;
                        return false;
                    }
                }
            }
        }
        else
        {
            switch ($return_code)
            {
                case ZipArchive::ER_NOZIP:
                    $errs["testcases"]="Its not a zip archive. Choose another file";
                    break;
                case ZipArchive::ER_OPEN:
                    $errs["testcases"]="Cannot open the file. Choose another file";
                    break;
                default:
                    $errs["testcases"]="Cannot open the file. Pleae try again";
            }
            return false;
        }
        return true;
    }


}