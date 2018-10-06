<?php
include "../core/init.php";

class error_message
{
    public $message;
    public function __construct($msg)
    {
        $this->message = $msg;
    }
}

class upload_response
{
    public $uploaded, $fileName, $url, $error;
    public function __construct($uploaded, $fileName, $url, $error=null)
    {
        $this->uploaded = $uploaded;
        $this->fileName = $fileName;
        $this->url = $url;
        if ($error!=null) $this->error = $error;
    }
}


if ($cuser==null || !$cuser->canUpload())
{
    echo json_encode(new upload_response(0, "", "", new error_message("You dont have the right to upload the image")));
    die();
}

$type = Input::get("type");
if (Input::get("type")=="image")
{
    if ($_FILES["upload"]["error"]==UPLOAD_ERR_OK)
    {
        $target_dir = "userfiles/drag_images/";
        $target_file_name = uniqid(mt_rand(),true);
        $target_file = $target_dir.$target_file_name;
        $target_url = "/ckfinder/".$target_file;
        if (move_uploaded_file($_FILES["upload"]["tmp_name"],$target_file))
        {
            $msg = "";
            echo json_encode(new upload_response(1,$target_file_name,$target_url, new error_message($msg)));
        }
    }
    else
    {
        echo json_encode(new upload_response(0, "", "", new error_message("Couldn't upload the file")));
    }
}
die();
?>
<html>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="upload">
    <input type="submit" name="submit">
</form>

</body>
</html>
