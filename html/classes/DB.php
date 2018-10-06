<?php
class DB
{
    private static $instance = null;
    private $pdo,$query,$error="",$results,$count=0;
    private function __construct()
    {
        try
        {
            $dsn = "mysql:host=".Config::get("mysql/host").";dbname=".Config::get("mysql/db").";port=".Config::get("mysql/port");
            $this->pdo = new PDO($dsn,Config::get("mysql/username"),Config::get("mysql/password"));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    private function refresh()
    {
        $this->error = "";
        $this->count = 0;
    }

    public static function createQuestionMarks($num)
    {
        $res="";
        for($i=1; $i<=$num; $i++)
        if ($res=="")
        {
            $res.="?";
        }
        else $res.=",?";
        return $res;
    }

    private function addError($str)
    {
        if (!$this->error)
        {
            $this->error.=$str;
        }
        else $this->error.="<br>$str";
    }

    public function getError()
    {
        return $this->error;
    }

    public function count()
    {
        return $this->count;
    }

    public function prepare($str)
    {
        try{
            return $this->pdo->prepare($str);
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

    public function queryPS($ps, $params=array(), $fetch_type=PDO::FETCH_ASSOC)
    {
        $this->refresh();
        try{
            $ps->execute($params);
            $this->results = $ps->fetchAll($fetch_type);
            $this->count = count($this->results);
            return true;
        }
        catch (PDOException $e)
        {
            $this->addError($e->getMessage());
            return false;
        }
    }

    public function queryUpdate($str,$params=array())
    {
        $this->refresh();
        try{
            $this->query = $this->pdo->prepare($str);
            $this->query->execute($params);
            return true;
        }
        catch (PDOException $e)
        {
            $this->addError($e->getMessage());
            return false;
        }
    }
    public function query($str,$params=array(),$fetch_type=PDO::FETCH_ASSOC)
    {
        $this->refresh();
        try{
            $this->query = $this->pdo->prepare($str);
            $this->query->execute($params);
            $this->results = $this->query->fetchAll($fetch_type);
            $this->count = count($this->results);
            return true;
        }
        catch (PDOException $e)
        {
            $this->addError($e->getMessage());
            return false;
        }
    }

    public function select($table, $cond, $values=array() ,$fields=array("*"), $limit=0, $offset=0)
    {
        $str_field = $fields[0];
        $cnt = count($fields);
        for ($i=1; $i<$cnt; $i++)
        {
            $str_field.=", $fields[$i]";
        }
        $str = "SELECT $str_field FROM $table";
        if ($cond) $str.= " WHERE $cond";
        if ($limit) $str.= " LIMIT $limit";
        if ($offset) $str.= " OFFSET $offset";
        return $this->query($str,$values);
    }

    public function update($table, $cond, $cond_values, $data)
    {
        $sql = "UPDATE $table";
        $str_data = "";
        $data_values = array();
        foreach($data as $key=>$val)
        {
            if (!$str_data) $str_data .="$key = ?";
            else $str_data .=", $key = ?";
            array_push($data_values, $val);
        }
        if ($str_data) $sql.=" SET $str_data";
        if ($cond) $sql.=" WHERE $cond";

        return $this->queryUpdate($sql,array_merge($data_values, $cond_values));
    }

    public function insert($table, $data)
    {
        $keys = array_keys($data);
        $str_keys = implode("`,`",$keys);
        $str_values = "";
        $params = array();
        foreach ($data as $value)
        {
            if (empty($str_values)) $str_values.="?";
            else $str_values.=",?";
            array_push($params,$value);
        }
        $str="INSERT INTO $table(`$str_keys`) VALUES($str_values)";
        return $this->queryUpdate($str,$params);
    }

    public function txQuery($str,$params=array(),$fetch_type=PDO::FETCH_ASSOC)
    {
        $this->refresh();
        $this->query = $this->pdo->prepare($str);
        $this->query->execute($params);
        $this->results = $this->query->fetchAll($fetch_type);
        $this->count = count($this->results);
    }

    public function txQueryUpdate($str,$params=array(),$fetch_type=PDO::FETCH_ASSOC)
    {
        $this->refresh();
        $this->query = $this->pdo->prepare($str);
        $this->query->execute($params);
    }

    public function txExecute($str,$params=array())
    {
        $this->refresh();
        $this->query = $this->pdo->prepare($str);
        $this->query->execute($params);
    }
    public function txExecutePS($ps,$params=array())
    {
        $ps->execute($params);
    }

    public function txPrepare($str)
    {
        return $this->pdo->prepare($str);
    }

    public function txSelect($table, $cond, $values=array() ,$fields=array("*"))
    {
        $str_field = $fields[0];
        $cnt = count($fields);
        for ($i=1; $i<$cnt; $i++)
        {
            $str_field.=", $fields[$i]";
        }
        $str = "SELECT $str_field FROM $table";
        if ($cond) $str.= " WHERE $cond";
        return $this->txQuery($str,$values);
    }

    public function txInsert($table, $data)
    {
        $keys = array_keys($data);
        $str_keys = implode("`,`",$keys);
        $str_values = "";
        $params = array();
        foreach ($data as $value)
        {
            if (empty($str_values)) $str_values.="?";
            else $str_values.=",?";
            array_push($params,$value);
        }

        $str="INSERT INTO $table(`$str_keys`) VALUES($str_values)";
        $this->txExecute($str,$params);
    }

    public function txUpdate($table)
    {

    }

    public function getFirstItem()
    {
        if ($this->count())
        {
            return $this->results[0];
        }
        else
        {
            return false;
        }
    }

    public function getResults()
    {
        return $this->results;
    }

    public function getLastID()
    {
        return $this->pdo->lastInsertId();
    }

    public function txBegin()
    {
        $this->pdo->beginTransaction();
    }


    public function txCommit()
    {
        $this->pdo->commit();
    }

    public function txRollBack()
    {
        $this->pdo->rollBack();
    }

}