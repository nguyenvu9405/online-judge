<?php

class User
{
    private $user_data,$err;

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function setData($data)
    {
        $this->user_data = $data;
    }

    public function getId()
    {
        return $this->user_data["id"];
    }

    public function getUsername()
    {
        return $this->user_data["username"];
    }

    public function getPassword()
    {
        return $this->user_data["password"];
    }

    public function getName()
    {
        return $this->user_data["name"];
    }

    public function getEmail()
    {
        return $this->user_data["email"];
    }

    public function getDOB()
    {
        return $this->user_data["dob"];
    }

    public function getWorkPlace()
    {
        return $this->user_data["workplace"];
    }

    public function getLatestLangId()
    {
        return $this->user_data["lang_id"];
    }

    public static function getUserByUsername($username)
    {
        $db = DB::getInstance();
        if ($db->select("users","username=?",array($username)))
        {
            $data = $db->getFirstItem();
            if ($data)
                return new User($data);
            else return false;
        }
        else
            return false;
    }

    public static function getCurrentUser()
    {
        if (Session::exist("user_id"))
        {
            $user_id = Session::get("user_id");
            $db = DB::getInstance();
            if ($db->select("users","id=?",array($user_id)))
            {
                $data = $db->getFirstItem();
                return new User($data);
            }
            else
                return false;
        }
        else
            return false;
    }

    public static function login($username,$password)
    {
        $db = DB::getInstance();
        if ($db->select("users","username=?",array($username)))
        {
            $data = $db->getFirstItem();
            if ($data)
            {
                if (Hash::passwordVerify($password,$data["password"]))
                {
                    $user = new User($data);
                    $user->setLoggedIn();
                    return array(
                        "user"=>$user
                    );
                }
                else
                {
                    return array(
                        "err"=>array(
                            "password"=>"Wrong password"
                        )
                    );
                }
            }
            else
            {
                return array(
                    "err"=>array(
                        "username"=>"Wrong username"
                    )
                );
            }
        }
        else
        {
            die("Server cannot connect to database");
        }
    }


    public function register()
    {
        $db = DB::getInstance();

        if ($db->insert("users",$this->user_data))
        {
            return true;
        }
        else return false;
    }

    public function updateInfoUser($data)
    {
        $db = DB::getInstance();
        if ($db->update("users","id = ?",array($this->getId()), $data))
        {
            return true;
        }
        else return false;

    }

    public function setLoggedIn($status=true)
    {
        Session::set("user_id",$this->user_data["id"]);
    }

    public function setLoggedOut()
    {
        Session::delete("user_id");
    }

    public function canUpload()
    {
        if ($this->user_data["group_num"] >0 )
        {
            return true;
        }
        else return false;
    }

    public function canEditProblem($prob)
    {
        if ($this->isAdmin())
            return true;
        if ($this->getId()==$prob->getUploaderId())
            return true;
        return false;
    }

    public function canView($sub)
    {
        if ($this->isAdmin())
            return true;
        if ($this->getId()==$sub->getSubmitter()->getId())
            return true;
        if ($this->getId()==$sub->getProblem()->getUploaderId())
            return true;
        return false;
    }

    public function isAdmin()
    {
        if ($this->user_data["group_num"]==2)
            return true;
        return false;
    }

    public function getUser($conds,$params)
    {
        $db = DB::getInstance();
        if ($db->query("SELECT * 
                            FROM users 
                            WHERE $conds LIMIT 1",
            $params))
        {
            $user = new User($db->getFirstItem());
            return $user;
        }
        else return false;
    }

}