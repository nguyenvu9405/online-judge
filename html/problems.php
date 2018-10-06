<?php
include "core/init.php";
include "head.php";

if (InputGet::existField("code"))
{
    include "problem.php";
}
else
{
    include "problems_table.php";
}

?>
