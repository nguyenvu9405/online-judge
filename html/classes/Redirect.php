<?php

class Redirect
{

    public static function to($url=null)
    {
        if (empty($url) || $url=="/") header("Location: index.php",true,302);
        else
        {
            header("Location: $url",true, 302);
        }
        die();
    }

    public static function to404()
    {
        header("Location: /404",true, 302);
        die();
    }

    public static function back($default="/index.php")
    {
        if (Input::existField("rurl"))
        {
            Redirect::to(htmlspecialchars(Input::get("rurl")));
        }
        else Redirect::to($default);
    }

}