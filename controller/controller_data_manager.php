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
        */

        //include VIEW_PATH . 'data_menu.php';
        include VIEW_PATH . 'addAlteration.php';

    }

    public function action_submit()
      {
        /**
         * Set the dependency in a class property, so it's easily accessible for later use of class methods.
          *@param $reslt calls the getlogin() function of model class and store the return value of this function into the result variable.
         */
          $reslt = $this->model->addNarrative(); //
          if ($reslt == 1){

              include VIEW_PATH . 'narrativeExists.php';

          } else if($reslt == 2) {
              include VIEW_PATH . 'previewNarrative.php';

          }else{
            include VIEW_PATH . 'login.php';
          }

    }
    /**
    *BELOW Is for Resetting PASSWORD functions
    */
        public function action_addAlteration()
        {
          /**
           * Set the dependency in a class property, so it's easily accessible for later use of class methods.
            *@param $reslt calls the getlogin() function of model class and store the return value of this function into the reslt variable.
        */
                include VIEW_PATH . 'addAlteration.php';
        }
        public function action_submit_alteration()
          {
            /**
             * Set the dependency in a class property, so it's easily accessible for later use of class methods.
              *@param $result calls the getlogin() function of model class and store the return value of this function into the result variable.
             */
              $result = $this->model->getAlteration();

              if ($result == 1){

                  include VIEW_PATH . 'alterationExists.php';
                  echo $result;

              } else if($result == 2) {
                  include VIEW_PATH . 'alterationSuccessAdded.php';
                  echo $result;

              }else{
                echo $result;
                //include VIEW_PATH . 'login.php';
              }

        }

}
