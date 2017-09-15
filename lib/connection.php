<?php

  class Db {
    private static $instance = NULL;
	

    private function __construct() {}

    private function __clone() {}
  
    public static function getInstance() {
      if (!isset(self::$instance)) {
		$hostname=DB_HOST;
        $username=DB_NAME; 
        $password=DB_PASS; 
        $db_name=DB_USER; 
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		try{
			self::$instance = new PDO("mysql:host=$hostname;dbname=$db_name", $username, $password, $pdo_options);
		}
		catch(PDOException $e){
			write_log($e->getMessage());
			
		}
 	  }
	  return self::$instance;
    }
  }
 
?>