<?php

use Lib\model_base;

class Register_Model extends model_base
{
    public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
    {
        parent::__construct(null, null, null);
    }
    /*
    * function to register new user
    * create new user
    *
    */
    public function adduser($username, $pass, $name)
    {


        $this->db = Db::getInstance();

        $stmt = $this->db->prepare("INSERT INTO CVC_User (UID, Name,Email,Role,Password) VALUES (:UID, :Name,:Email,:Role,:Password)");

        $stmt->bindParam(':UID', $email);
        $stmt->bindParam(':Name', $uname);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':Role', $role);
        $stmt->bindParam(':Password', $password);

        $email    = $username;
        $uname    = $_POST["name"];
        $role     = 2;
        $password = $pass;

        try {
            $stmt->execute();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }

    /*
    * Gets data from register page login
    * create new user
    */
    public function getRegister()
    {
        //session_start(); // Starting Session

        $error = ''; // Variable To Store Error Message

        {
            $this->db = Db::getInstance(); {
                // Define $username and $password
                $user  = $_POST['email'];
                $pass  = $_POST['password']; //
                $query = "select Name FROM CVC_User where Email='" . $user . "'";

                $stmt = $this->db->prepare($query);
                try {
                    $stmt->execute();
                }
                catch (PDOException $e) {
                    //write_log($e->getMessage());
                    echo $e->getMessage();
                }
                $rows     = $stmt->fetchAll();
                $num_rows = count($rows);

                if ($num_rows == 1) {

                    // header("location: profile.php"); // Redirecting To Other Page
                    return 1; //indicated that user alreaday exist;
                    //$_SESSION['login_user']=$username; // Initializing Session
                    // header("location: profile.php"); // Redirecting To Other Page
                } else {
                    return $this->adduser($user, $pass);
                }
            }

        }
    }
    /*
    *function to reset user password
    * generates random password
    * emails password to user
    */

    public function resetuser($username, $pass)
    {

        $this->db = Db::getInstance();

        $stmt = $this->db->prepare("UPDATE  CVC_User SET Password =:Password WHERE UID= :UID");

        $stmt->bindParam(':UID', $username);
        $stmt->bindParam(':Password', $password);

        $username = $username;
        $password = $pass;

        $msg     = ("Your temporary password is: $pass \r\r\nClick on the update password link on the login page to change your password.");
        $headers = "From: cav-notifications@sema4genomics.com";
        $subject="CAV Password Reset";
        $from = 'CAV support';
        // send email
        $mail=mail($username, $subject,$msg,$headers);

        $fullmsg="From: $from\nTo: $username\nSubject: $subject\n$msg";
        exec("echo $fullmsg | /usr/sbin/sendmail -f cav-notifications@sema4genomics.com $username");

        if($mail)
        {
          echo "email sent";
        }
        else
        {
          echo "Failed to send email.";
        }



        try {
            $stmt->execute();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }

    /*
    * Gets username from forgot password page
    * and enters random password into database
    */
    public function getUserPass()
    {
      ini_set('display_errors',1);

        $error = ''; // Variable To Store Error Message
        //if (isset($_POST['submit']))
        {
            $this->db = Db::getInstance();
            {
                // Define $username and $password
                $user = $_POST['username'];
                $pass  = md5(uniqid($user, true)); //
                $query = "select Password FROM CVC_User where UID='" . $user . "'";

                $stmt = $this->db->prepare($query);
                try {
                    $stmt->execute();
                }
                catch (PDOException $e) {
                    //write_log($e->getMessage());
                    return $e->getMessage();
                }
                $rows     = $stmt->fetchAll();
                $num_rows = count($rows);

                if ($num_rows < 1) {
                   alert("Reset Password failed, email is not in database");
                    // header("location: profile.php"); // Redirecting To Other Page
                    return 1; //indicated that this username doesn't exist


                } else {
                    return $this->resetuser($user, $pass);

                }
            }
        }
    }

    /*
    * function to update user password
    * checks if password is correct
    * password needs to be 8 characters
    */
    public function updateUser()
    {
        $error = ''; // Variable To Store Error Message

            {
                $this->db = Db::getInstance();
                {
                    $user  = $_POST['username'];
                    $opass = $_POST['opassword']; //
                    $pass  = $_POST['password']; //
                    $query = "select Password FROM CVC_User where UID='" . $user . "' and Password='" . $opass . "'";

                    $stmt = $this->db->prepare($query);
                    try {
                        $stmt->execute();
                    }
                    catch (PDOException $e) {
                        //write_log($e->getMessage());
                        return $e->getMessage();
                    }
                    $rows     = $stmt->fetchAll();
                    $num_rows = count($rows);

                    if ($num_rows < 1) {


                        return 1; //indicated that user doesnt exist;

                    } else {
                        return $this->updatepassword($user, $pass);
                        $msg     = "Your password for the Cancer Alteration Viewer has been updated";
                        mail($user, "CAV Password Reset", $msg);
                        alert($user, "CAV Password Reset", $msg);
                    }
                }
            }
          }

    /*
    * Updates password
    * and sends user an email notifiying of the password change
    */
    public function updatepassword($user, $pass)
    {
        $this->db = Db::getInstance();
        $error = ''; // Variable To Store Error Message
        {
            $stmt = $this->db->prepare("UPDATE  CVC_User SET Password =:Password WHERE UID= :UID");
            $stmt->bindParam(':UID', $username);
            $stmt->bindParam(':Password', $password);

            $username    = $user;
            $password = $pass;

            $msg     = ("You have successfully updated your password. ");
            $headers = "From: cav-notifications@sema4genomics.com";
            $subject="CAV Password Updated";
            // send email
            $mail=mail($username, $subject,$msg, $headers);
            if($mail)
            {
              echo "Test email send.";
            }
            else
            {
              echo "Failed to send.";
            }
        }
        try {
            $stmt->execute();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }
}

?>
