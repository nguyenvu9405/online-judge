<?php

class ErrorMessages
{
    public static function getDBMsg()
    {
        return "There is some problems with the database. It would be helpful if you can inform the admins about this by using the email address in Contact Us page. Thank you.";
    }

    public static function getSocketMsg()
    {
        return "The judge is not working properly at the moment. It would be helpful if you can inform the admins about this by using the email address in Contact Us page. Thank you.";
    }

    public static function getFileUploadMsg()
    {
        return "There is some error in uploading a file now. It would be helpful if you can inform the admins about this so they can fix this as soon as possible. Thank you. ";
    }
    public static function getFormError()
    {
        return "Please correct the errors";
    }

}