<?php

use Lib\model_base;

class Login_Model extends model_base
{  public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
  {
      parent::__construct(null, null, null);
  }

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
                  //$_SESSION['login_user']=$username; // Initializing Session
                  $_SESSION['uname'] = $rows[0][0];

                  $_SESSION['username'] = $user;
                  $_SESSION['role'] = $role;
                  // header("location: profile.php"); // Redirecting To Other Page
                  return 'login';
                  //$_SESSION['login_user']=$username; // Initializing Session
                  // header("location: profile.php"); // Redirecting To Other Page
              } else {
                  return 'invalid user';
                  //$error = "Username or Password is invalid";
              }
              //mysql_close($connection); // Closing Connection
          }
      }
  }

}
?>
