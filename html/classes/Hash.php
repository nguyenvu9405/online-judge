<?php

class Hash
{
    public static function password($pass)
    {
        return password_hash($pass,PASSWORD_BCRYPT);
    }
    public static function passwordVerify($pass,$hash)
    {
        return password_verify($pass,$hash);
    }
}