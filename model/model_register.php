<?php

use Lib\model_base;
require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
class Register_Model extends model_base
{
    public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
    {
        parent::__construct(null, null, null);
    }
    /* function to register new user
    * create new user
    *
    */
    public function adduser($username, $pass, $name)
    {
        //copy v$report = $_POST["report"];

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
    public function getRegister()
    {
        //session_start(); // Starting Session

        $error = ''; // Variable To Store Error Message
        //    if (isset($_POST['submit']))
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
    /* function to reset user password
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
        // send email
        $mail=mail($username, $subject,$msg);
        if($mail)
        {
          echo "Test email send.";
        }
        else
        {
          echo "Failed to send.";
        }


/*$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->Port       = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth   = true;
$mail->Username = 'osman.siddiqui@sema4genomics.com';

$mail->SetFrom('Osman.siddiqui@sema4genomics.com', 'FromEmail');
$mail->addAddress($username, 'ToEmail');
//$mail->SMTPDebug  = 3;
//$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";}; //$mail->Debugoutput = 'echo';
$mail->IsHTML(true);

$mail->Subject = 'CAV password Reset';
$mail->Body    =  ("Your temporary password is: $pass \r\r\nClick on the update password link on the login page to change your password.");


if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
} */
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
    public function getUser()
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

                    // header("location: profile.php"); // Redirecting To Other Page
                    return 1; //indicated that user alreaday exist;

                } else {
                    return $this->resetuser($user, $pass);

                }
            }
        }
    }

    /* function to update user password
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

                        // header("location: profile.php"); // Redirecting To Other Page
                        return 1; //indicated that user doesnt exist;

                    } else {
                        return $this->updatepassword($user, $pass);
                        $msg     = "Your password for the Cancer Alteration Viewer has been updated";
                        //$headers = "From: cav-notifications@sema4genomics.com";
                        // send email
                        mail($user, "CAV Password Reset", $msg);
                        alert($user, "CAV Password Reset", $msg);
                    }
                }
            }
          }

    public function updatepassword($username, $pass)
    {
        $this->db = Db::getInstance();
        $error = ''; // Variable To Store Error Message
        {
            $stmt = $this->db->prepare("UPDATE  CVC_User SET Password =:Password WHERE UID= :UID");
            $stmt->bindParam(':UID', $username);
            $stmt->bindParam(':Password', $password);

            $uname    = $_POST["name"];
            $password = $pass;

            $msg     = ("You have successfully updated your password. ");
            $headers = "From: cav-notifications@sema4genomics.com";
            $subject="CAV Password changed";
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
