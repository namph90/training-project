<?php

abstract class BaseValidated
{
    abstract public static function name($name);

    abstract public static function password($pass);

    public static function password_confirm($pass, $password_confirm)
    {
        if (!isset($_SESSION['errCreate']['password'])) {
            if (empty(trim($password_confirm))) {
                $_SESSION['errCreate']['confirmation_pwd']['required'] = 'Password Verify can not be blank';
            } elseif (strlen(trim($password_confirm)) != strlen($pass)) {
                $_SESSION['errCreate']['confirmation_pwd']['invaild'] = 'Password verify does not match';
            }
        }
    }

    public static function email($count, $email)
    {
        if (empty(trim($email))) {
            $_SESSION['errCreate']['email']['invaild'] = 'Email can not be blank';
        } elseif (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errCreate']['email']['invaild'] = 'Invalid email format';
        } elseif ($count > 0) {
            $_SESSION['errCreate']['email']['invaild'] = 'Email exist';
        }
    }

    abstract public static function image($file);
}