<?php

use Lib\model_base;

class Register_Model extends model_base
{
  public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
  {
      parent::__construct(null, null, null);
  }
  public function adduser($username,$pass,$name){
      //copy v$report = $_POST["report"];

      $this->db = Db::getInstance();

      $stmt = $this->db->prepare("INSERT INTO CVC_User (UID, Name,Email,Role,Password) VALUES (:UID, :Name,:Email,:Role,:Password)");

      $stmt->bindParam(':UID', $email);
      $stmt->bindParam(':Name', $uname);
      $stmt->bindParam(':Email', $email);
      $stmt->bindParam(':Role', $role);
      $stmt->bindParam(':Password', $password);

      $email = $username;
      $uname = $_POST["name"];
      $role = 2;
      $password = $pass;





      try {
          $stmt->execute();
          return 2;
      } catch (PDOException $e) {
          //write_log($e->getMessage());
          echo $e->getMessage();
          return 3;
      }
}
  public function getRegister()
  {
      session_start(); // Starting Session

      $error = ''; // Variable To Store Error Message
      if (isset($_POST['submit'])) {
          $this->db = Db::getInstance();
        {
              // Define $username and $password
              $user = $_POST['email'];
              $pass = $_POST['password'];//
              $query = "select Name FROM CVC_User where Email='" . $user . "'" ;

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
                  return 1;//indicated that user alreaday exist;
                  //$_SESSION['login_user']=$username; // Initializing Session
                  // header("location: profile.php"); // Redirecting To Other Page
              } else {
                    return $this->adduser($user,$pass);
                  }




      }

}
}
}
?>
