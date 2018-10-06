<?php
include_once "core/init.php";
if ($cuser && InputGet::existField("id"))
{
    $sub_id = InputGet::get("id");
    $sub = Submission::getSubmissionById($sub_id);
    if ($sub && $cuser && $cuser->canView($sub))
    {
        echo $sub->getCode();
    }
    else
        echo "You don't have the right to access this submission";
}