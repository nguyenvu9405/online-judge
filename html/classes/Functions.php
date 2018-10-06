<?php
class Functions
{
    public static function escape($str)
    {
        return htmlentities($str,ENT_QUOTES,'UTF-8');
    }
    public static function endWith($str, $suf)
    {
        $len = strlen($suf);
        if (substr($str,-$len)===$suf) return true;
        return false;
    }
    public static function getURLPage($vars, $page)
    {
        $page=max($page,1);
        $vars["page"]=$page;
        return http_build_query($vars);
    }
}