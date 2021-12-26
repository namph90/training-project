<?php

class DB
{
    private static $instance = NULl;
    private static $hostname = 'localhost';
    private static $dbname = 'm_users';
    private static $username = 'root';
    private static $password = '';

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:hostname='.self::$hostname.';dbname='.self::$dbname,self::$username,self::$password);
                self::$instance->exec("set names utf8");
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
        }
        return self::$instance;
    }
}