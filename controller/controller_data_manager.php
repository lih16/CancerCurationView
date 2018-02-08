<?php
//namespace Controller;

use Lib\model_base;

use Lib\Controller_base;

class controller_data_manager extends Controller_base
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
       $this->model = new Data_Manager_Model();
    }

    public function action_browse()
    {
        /**
        * Set views directories
        * data_menu.php is the menu bar 
        * addPreNarrative.php is the page for adding a new pre-narrative
        */

        include VIEW_PATH . 'data_menu.php';
       include VIEW_PATH . 'addPreNarrative.php';
      //  include VIEW_PATH . 'addAlteration.php';
      //  include VIEW_PATH . 'selectADD.php';

    }

    public function action_submit()
      {
        /**
         * Set the dependency in a class property, so it's easily accessible for later use of class methods.
          *@param $reslt calls the getPreNarrative() function of model class and store the return value of this function into the result variable.
         */
          $reslt = $this->model->getPreNarrative(); //
          if ($reslt == 1){

              include VIEW_PATH . 'PreNarrativeExists.php';// need to change to narrative exists and create file

          } else if($reslt == 2) {
              include VIEW_PATH . 'PreNarrativeSuccessAdded.php';

          }else{
            include VIEW_PATH . 'login.php';
          }

      }

}
