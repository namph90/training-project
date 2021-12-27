<?php

class DB
{
    private static $instance = NULl;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:hostname='.HOSTNAME.';dbname='.DBNAME,USERNAME,PASSWORD);
                self::$instance->exec("set names utf8");
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
        }
        return self::$instance;
    }
}