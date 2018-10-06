<?php
include "core/init_backend.php";
header("Content-Type: text/event-stream");
header('Cache-Control: no-cache');
$ids=$_GET["ids"];

if ($ids)
{
    $range="";
    foreach ($ids as $id)
    {
        if ($range) $range.=",?";
        else $range.="?";
    }

    $db = DB::getInstance();

    $ps = $db->prepare("SELECT `id`, `test_num`, `status`, `errors`, `time`, `mem` FROM subs WHERE id in ($range)");
    if (!$ps) endStream();

    function getStatus()
    {
        global $db, $ps, $ids;
        if ($db->queryPS($ps,$ids))
        {
            return $db->getResults();
        }
        else return false;
    }

    function send()
    {
        ob_flush();
        flush();
    }

    function endStream()
    {
        echo "event: end\n";
        echo "data: Stream has ended";
        echo "\n\n";
        send();
        die();
    }

    while (true)
    {
        $res = getStatus();
        if (!$res) endStream();
        $json_res = json_encode($res);
        echo "event: update\n";
        echo "data: $json_res";
        echo "\n\n";
        send();
        $allFinished = true;
        foreach ($res as $sub)
        if ($sub["status"]<100)
        {
            $allFinished = false;
            break;
        }
        if ($allFinished) endStream();
        usleep(400000);
    }
}
else
{
    endStream();
}
