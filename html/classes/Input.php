<?php

class Input
{
    public static function exist()
    {

        if (empty($_POST)  && empty($_GET))
            return false;
        return true;
    }

    public static function existField($field)
    {
        if (empty($_POST[$field])  && empty($_GET[$field]))
            return false;
        return true;
    }

    public static function get($field)
    {
        if (isset($_POST[$field]))
            return $_POST[$field];
        if (isset($_GET[$field]))
            return $_GET[$field];
        return false;
    }

}