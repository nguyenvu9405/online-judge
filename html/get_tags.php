<?php
include_once "core/init_backend.php";
if (InputGet::existField("keyword"))
{
    $key = InputGet::get("keyword");
    echo json_encode(Tags::getTagsByKeyword($key));
}
else echo json_encode(array());