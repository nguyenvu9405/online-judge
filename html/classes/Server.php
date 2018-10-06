<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/23/18
 * Time: 2:22 PM
 */

class Server
{
    public static function getRequestURI()
    {
        return $_SERVER["REQUEST_URI"];
    }
}