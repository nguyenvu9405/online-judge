<?php
/*include "../core/init.php";

$funcNum = Input::get("CKEditorFuncNum");
$CKEditor = Input::get("CKEditor");
$langCode = Input::get("langCode");
$type = Input::get("type");

if ($type == "image")
{
    if ($_FILES["upload"]["error"]==UPLOAD_ERR_OK)
    {
        $target_dir = "storage/";
        $target_file_name = $_FILES["upload"]["name"];
        $target_file = $target_dir.$target_file_name;
        $cnt = 0;
        while (file_exists($target_file)===true)
        {
            $cnt++;
            $target_file_name = "($cnt){$_FILES["upload"]["name"]}";
            $target_file = $target_dir.$target_file_name;
        }
        $target_url = "/uploader/".$target_file;
        if (move_uploaded_file($_FILES["upload"]["tmp_name"],$target_file))
        {
            $msg = "Uploaded succesfully !";
            if ($cnt!=0) $msg = "The file name is already exist, so it was changed to $target_file_name";
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$target_url', '$msg');</script>";
        }
    }
}
*/?>
