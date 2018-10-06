<?php

class InputGet
{
    public static function exist()
    {
        if (empty($_GET))
            return false;
        return true;
    }

    public static function existField($field='')
    {
        if (empty($_GET[$field]))
            return false;
        return true;
    }

    public static function get($field)
    {
        if (isset($_GET[$field]))
            return $_GET[$field];
        return false;
    }
}
?>