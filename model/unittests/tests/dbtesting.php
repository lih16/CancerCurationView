<?php

class Db
{
    private static $instance = null;

    /*
     *Accept a $model instance in the constructor, so the  dependencies can be injected from the outside
    */
    private function __construct()
    {
    }

    /**
    * Empty clone magic method to prevent duplication.
    */
    private function __clone()
    {
    }

    /*
     * @return singleton instance for mysql connection
     *
     * @throws PDO exceptionclass [description]
     *
     * @access public
     * @static
     * @see Db::getInstance,
    */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $hostname = DB_HOST;
            $username = DB_NAME;
            $password = DB_PASS;
            $db_name = DB_USER;
            try {
                self::$instance = new PDO("mysql:host=$hostname;dbname=$db_name", $username, $password);
            } catch (PDOException $e) {
                write_log($e->getMessage());
            }
        }
        return self::$instance;
    }
}
