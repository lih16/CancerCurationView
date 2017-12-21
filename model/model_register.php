<?php

use Lib\model_base;

class Login_Model extends model_base
{
  public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
  {
      parent::__construct(null, null, null);
  }
  public function adduser($username,$pass,$verifynumber){
      //copy v$report = $_POST["report"];
      $this->db = Db::getInstance();
      if ($report == 1) {
          $stmt = $this->db->prepare("INSERT INTO CVC_User (UID, Name,Email,1,Password) VALUES (:cancer, :gene,:varaint,:pid,:uid,:date_edit,:comment,:version_name)");
      } else {
          $stmt = $this->db->prepare("INSERT INTO CVC_User (cancer, gene,varaint,1,uid,date_edit,comment,version_name) VALUES (:cancer, :gene,:varaint,:pid,:uid,:date_edit,:comment,:version_name)");
      }
      $stmt->bindParam(':UID', $email);
      $stmt->bindParam(':Name', $name);
      $stmt->bindParam(':Email', $email);
      $stmt->bindParam(':Role', $role);
      $stmt->bindParam(':Password', $password);

      $email = $_POST["email"];
      $name = $_POST["name"];
      $role = $_POST["1"];
      $password = $_POST["password"];

      try {
          $stmt->execute();
          return 2;
      } catch (PDOException $e) {
          //write_log($e->getMessage());
          echo $e->getMessage();
          return $e->getMessage();
      }

  }


  public function getRegister()
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

                  // header("location: profile.php"); // Redirecting To Other Page
                  return '1';//indicated that user alreaday exist;
                  //$_SESSION['login_user']=$username; // Initializing Session
                  // header("location: profile.php"); // Redirecting To Other Page
              } else {
                    return dduser($username,$pass,$verifynumber);
                  }
                  // successfully add uesr
                  //$error = "Username or Password is invalid";

              //mysql_close($connection); // Closing Connection
          }
      }

}
}
?>
