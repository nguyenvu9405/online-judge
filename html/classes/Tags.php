<?php
/**
 * Created by PhpStorm.
 * User: rain
 * Date: 08/02/18
 * Time: 11:17
 */

class Tags
{

    public static function getTagsByKeyword($key)
    {
        $db = DB::getInstance();
        if ($db->query("SELECT tag FROM tags_problems_map WHERE tag LIKE ?",array("%$key%")))
        {
            return $db->getResults();
        }
        else return false;
    }

    public static function getTagOptionsByKeyword($key)
    {
        $rows = self::getTagsByKeyword($key);
        if ($rows)
        {
            $str="";
            foreach($rows as $row)
            {
                $str.="<option value='{$row["tag"]}'/>";
            }
            return $str;
        }
        else return false;
    }
}