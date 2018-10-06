<?php
require_once "../core/init.php";

function response($uploaded, $filename, $url, $msg)
{
    $res = array(
        "uploaded"=>$uploaded,
        "fileName"=>$filename,
        "url"=>$url,
        "error"=>array(
                "message"=> $msg
        )
    );
    return json_encode($res);
}

if ($cuser && $cuser->canUpload())
{
    if ($_FILES["upload"]["error"]==UPLOAD_ERR_OK)
    {
        $target_dir = "storage_drag/";
        $target_file_name = uniqid(mt_rand(),true);
        $target_file = $target_dir.$target_file_name;
        $target_url = "/uploader/".$target_file;
        if (move_uploaded_file($_FILES["upload"]["tmp_name"],$target_file))
        {
            $msg = "";
            echo response(1,$target_file_name,$target_url, "Image Uploaded !");
        }
    }
    else
        echo response(0,"","", "Couldnt upload the image !");
}
else
{
    echo response(0,"","","You dont have the right to upload image !");
}
?>
<html>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="upload">
    <input type="submit" name="submit">
</form>

</body>
</html>
