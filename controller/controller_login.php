<?php
//namespace Controller;

use Lib\model_base;

use Lib\Controller_base;

class controller_login extends Controller_base
{
  /**
   * Create the Controller model
   *  @param  $model Designate a place to hold class dependencies
   */
    public $model;
    public function __construct()
    {
      /**
       * Accept a $model instance in the constructor, so the  dependencies can be injected from the outside
       * Set the dependency in a class property, so it's easily accessible for later use of class methods.
       * @param $this means "this instance of class A"
        * $this->model means "this instance of class Login_Model $model property
       */
        $this->model = new Login_Model();
    }

    public function action_login()
    {
      /**
       * Set the dependency in a class property, so it's easily accessible for later use of class methods.
        *@param $reslt calls the getlogin() function of model class and store the return value of this function into the reslt variable.
       */
        $reslt = $this->model->getlogin(); //
        switch($reslt){
          // case 1 equals
          case 1 : header("location: ../home/browse");
          break;
          case 2 : header("location: ../home/browse");
          break;
          case 3 : header("location: ../home/browse");
          break;
          case 4: header("location: ../data_manager/browse");//include VIEW_PATH . 'addAlteration.php' ; //'addAlteration.php' 'data_menu.php'
          break;
          default: include VIEW_PATH . 'login.php';

        }
        /*if ($reslt == 'login') {
            header("location: ../home/browse");
        } else {
            include VIEW_PATH . 'login.php';
        }*/
    }

    public function action_logout()
    {
      /**
       * Set the dependency in a class property, so it's easily accessible for later use of class methods.
        *session_destroy Destroys all sessions
        *header include VIEW_PATH . '../index/index';
       */
        session_start();
        if (session_destroy()) {
            header("location: ../index/index");
        }
    }
}
