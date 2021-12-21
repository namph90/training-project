<?php

require_once('models/validated/base_validated.php');

class UserValidated extends BaseValidated
{

    public static function name($name)
    {
        if (empty(trim($name))) {
            $_SESSION['errCreate']['name']['invaild'] = 'Name can not be blank';
        } elseif (strlen(trim($name)) < 6 || strlen(trim($name)) > 200) {
            $_SESSION['errCreate']['name']['invaild'] = 'Name must be between 6 and 200 characters';
        }
    }

    public static function password($pass)
    {
        if (empty(trim($pass))) {
            $_SESSION['errCreate']['password']['invaild'] = 'Password can not be blank';
        } elseif (strlen(trim($pass)) < 3 || strlen(trim($pass)) > 100) {
            $_SESSION['errCreate']['password']['invaild'] = 'Password must be between 3 and 100 characters';
        }
    }

    public static function image($file)
    {
        if (!isset($file)) {
            $_SESSION['errCreate']['image']['required'] = "Image can not be blank";
        } else {
            if ($file["size"] < 2048 || $file["size"] > 2097152) {
                $_SESSION['errCreate']['image']['invaild'] = "Your file must be between 2KB and 2MG";
            }
            if (!(strtoupper(substr($file['name'], -4)) == ".JPG"
                || strtoupper(substr($file['name'], -5)) == ".JPEG"
                || strtoupper(substr($file['name'], -4)) == ".PNG")) {
                $_SESSION['errCreate']['image']['invaild'] = "only JPG, JPEG, PNG & GIF files are allowed";
            }
        }
    }
}