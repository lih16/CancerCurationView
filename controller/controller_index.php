<?php
//index Controller;

/**
 * Importing global class for model_base and Controller_base'.
 */
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
      * login.php is the initial login page
      */
        include VIEW_PATH . 'login.php';
    }
}
