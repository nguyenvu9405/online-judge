<?php
class Config
{
    public static $settings = array(
        "mysql"=>array(
            "host"=>"127.0.0.1",
            "port"=>"3306",
            "username"=>"root",
            "password"=>"32199400",
            "db"=>"oj"
        ),
        "remember"=>array(
            "cookie_name"=>"hash",
            "cookie_expiry"=> 604800
        ),
        "session"=>array(
            "session_name"=>"user"
        )
    );
    public static function get($path=null)
    {
        if (!$path) return false;
        $chains = explode("/",$path);
        $res = self::$settings;
        foreach ($chains as $key)
        if (isset($key))
        {
            $res = $res[$key];
        }
        else return false;
        return $res;
    }
}