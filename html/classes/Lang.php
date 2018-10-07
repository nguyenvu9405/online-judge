<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/16/18
 * Time: 2:31 PM
 */

class Lang
{
    public static function getLangs()
    {
        $db = DB::getInstance();
        if ($db->query("SELECT * FROM langs"))
        {
            return $db->getResults();
        }
        else
            return false;
    }

    public static function getLangsOptions($selected=1)
    {
        $data = self::getLangs();
        $opts = "";
        foreach ($data as $lang)
        {
            if ($lang["id"]==$selected)
            {
                $opts.="<option selected value='{$lang['id']}' ace_mode='{$lang['ace_mode']}'>{$lang['name']}</option>";
            }
            else
                $opts.="<option value='{$lang['id']}' ace_mode='{$lang['ace_mode']}'>{$lang['name']}</option>";

        }
        return $opts;
    }
}
