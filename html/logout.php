<?php
include "core/init.php";
if ($cuser)
{
    $cuser->setLoggedOut();
    Session::flashPanel(array(1,"You have logged out successfully"));
    Redirect::back();
}
else
{
    Redirect::to("index.php");
}