<?php
//namespace Controller;

use Lib\model_base;

use Lib\Controller_base;

class controller_index extends Controller_base
{
    //public $model;

    /**
     * Create the Controller model
     */
    public function __construct()
    {
      /**
       * Accept a $model instance in the constructor, so the  dependencies can be injected from the outside
       * Set the dependency in a class property, so it's easily accessible for later use of class methods.
       */
       
        //$this->model = new Login_Model();
    }


    public function action_index()
    {
      /**
      * Set views directories
      */
        include VIEW_PATH . 'login.php';
    }
}
