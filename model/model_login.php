<?php

use Lib\model_base;

class Login_Model extends model_base
{
    public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
    {
        parent::__construct(null, null, null);
    }

    /* 02/5/18
    * opening homepage
    * User can login as Pathologist/editor, admin or data manager.
    * Function checks username, password and role and redirects to chosen page depending on role
    */
    public function getlogin()
    {
        session_start(); // Starting Session

        $error = ''; // Variable To Store Error Message
        if (isset($_POST['submit'])) {
            $this->db = Db::getInstance();
            if (empty($_POST['username']) || empty($_POST['password'])) {
                //$error = "Username or Password is invalid";
                return 'invalid user';
            } else {
                // Define $username and $password
                $user = $_POST['username'];
                $pass = $_POST['password'];//
                $role = $_POST['role'];//
                $query = "select Name FROM CVC_User where Email='" . $user . "' and Password='" . $pass . "' and (Role=" . $role . " or Role=3)";

                $stmt = $this->db->prepare($query);
                try {
                    $stmt->execute();
                } catch (PDOException $e) {
                    //write_log($e->getMessage());
                    echo $e->getMessage();
                }
                $rows = $stmt->fetchAll();
                $num_rows = count($rows);

                if ($num_rows == 1) {

                    $_SESSION['uname'] = $rows[0][0];

                    $_SESSION['username'] = $user;
                    $_SESSION['role'] = $role;


                    return $role;

                } else {
                    return 'invalid user';

                }

            }
        }
    }
}
