<?php

abstract class BaseValidated
{
    abstract public function name($name);

    abstract public function password($pass);

    public function email($data, $email)
    {
        if (empty(trim($email))) {
            $_SESSION['errCreate']['email']['invaild'] = 'Email can not be blank';
        } elseif (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errCreate']['email']['invaild'] = 'Invalid email format';
        } elseif ($data) {
            $_SESSION['errCreate']['email']['invaild'] = 'Email exist';
        }
    }

    public function password_confirm($pass, $password_confirm)
    {
        if (!isset($_SESSION['errCreate']['password'])) {
            if (empty(trim($password_confirm))) {
                $_SESSION['errCreate']['confirmation_pwd']['required'] = 'Password Verify can not be blank';
            } elseif (strlen(trim($password_confirm)) != strlen($pass)) {
                $_SESSION['errCreate']['confirmation_pwd']['invaild'] = 'Password verify does not match';
            }
        }
    }

    abstract public function image($file);
}