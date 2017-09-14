<?php
//namespace Controller;

use Lib\model_base;

use Lib\Controller_base;

class controller_index extends  Controller_base{
 //public $model;
 public function __construct() {  
     //$this->model = new Login_Model();
 } 
 
 public function action_index(){
  
 
     include VIEW_PATH . 'login.php';
  
  
 }
 
}

?>