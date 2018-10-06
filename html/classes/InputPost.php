<?php

class InputPost
{
    public static function exist()
    {
        if (empty($_POST))
            return false;
        return true;
    }

    public static function existField($field)
    {
        if (empty($_POST[$field]))
            return false;
        return true;
    }

    public static function get($field)
    {
        if (isset($_POST[$field]))
            return $_POST[$field];
        return false;
    }
}