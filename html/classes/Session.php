<?php
class Session
{
    public static function exist($key)
    {
        if (isset($_SESSION[$key])) return true;
        return false;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) return $_SESSION[$key];
        else return false;
    }

    public static function set($key,$value)
    {
        $_SESSION[$key]=$value;
    }

    public static function delete($key)
    {
        if (self::exist($key)) unset($_SESSION[$key]);
    }

    public static function setFlash($title,$content,$status=0)
    {
        self::set("flash",array($title,$content,$status));
        return false;
    }
    public static function getFlash()
    {
        if (self::exist("flash"))
        {
            $tmp = self::get("flash");
            self::delete("flash");
            return $tmp;
        }
        else return false;
    }

    public static function flashErrorMsg($txt=null)
    {
        if ($txt)
        {
            self::set("errormsg",$txt);
        }
        else
        {
            $tmp = self::get("errormsg");
            self::delete("errormsg");
            return $tmp;
        }
    }

    public static function flash($field,$txt=null)
    {
        if ($txt)
        {
            self::set($field,$txt);
        }
        else
        {
            $tmp = self::get($field);
            self::delete($field);
            return $tmp;
        }

    }


    public static function flashPanel($arr=null)
    {
        if ($arr)
        {
            self::set("flash_panel",$arr);
        }
        else
        {
            $tmp = self::get("flash_panel");
            self::delete("flash_panel");
            return $tmp;
        }
    }
}