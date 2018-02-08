<?php
//namespace Controller;

use Lib\model_base;

use Lib\Controller_base;

class controller_register extends Controller_base
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
       $this->model = new Register_Model();
    }

    public function action_register()
    {
      /**
       *  register.php is the registration page for a new user account
    */
            include VIEW_PATH . 'register.php';
    }
    public function action_submit()
      {
        /**
         * Submit registration for creating a new account.  will go to either success, failure  page or login page
          *@param $reslt calls the getRegister() function of model class and store the return value of this function into the result variable.
         */
          $reslt = $this->model->getRegister(); //
          if ($reslt == 1){

              include VIEW_PATH . 'reg_failure.php';

          } else if($reslt == 2) {
              include VIEW_PATH . 'successLogin.php';

          }else{
            include VIEW_PATH . 'login.php';
          }

    }

        public function action_forgot()
        {
          /**
          * Resetting PASSWORD if user has forgotten
          * forgotPassword.php is a page where user can enter registered email
          */
                include VIEW_PATH . 'forgotPassword.php';
        }
        public function action_submit_forgot()
          {
            /**
            * Resetting PASSWORD if user has forgotten
            * forgotPassword.php is a page where user can enter registered email
            * @param $result calls the getUserPass() function of model class and store the return value of this function into the result variable.
            */
              $result = $this->model->getUserPass();

              if ($result == 1){

                    include VIEW_PATH . 'forgotPassword.php';

              } else if($result == 2) {
                    include VIEW_PATH . 'login.php';
                  //include VIEW_PATH . 'successReset.php';

              }else{
                echo $result;
                //include VIEW_PATH . 'login.php';
              }

        }

            public function action_update()
            {
              /**
               * updating PASSWORD if user wants to change password
              * updatePassword.php is a page where user can enter registered email and existing password and create a new password
            */
                    include VIEW_PATH . 'updatePassword.php';
            }
            public function action_submit_update()
              {
                /**
                 * Submitting the updated password
                  *@param $result calls the updateUser() function of model class and store the return value of this function into the result variable.
                  * Redirects to successfull update  and failure to update pages depending on user input
                 */
                  $result = $this->model->updateUser(); //
                  if ($result == 1){

                      include VIEW_PATH . 'updateFailure.php';

                  } else if($result == 2) {
                      include VIEW_PATH . 'successUpdate.php';

                  }else{
                      echo $result;
                    //include VIEW_PATH . 'login.php';
                  }

            }


}
