<?php

use Lib\model_base;

class Login_Model extends model_base {
public function __construct($stable=NULL,$aColumns=NULL, $sIndexColumn=NULL){
    parent::__construct(NULL, NULL, NULL);
}
/*
session_start();

header("Content-type: text/plain");

$user=$_POST['user'];
$pass=$_POST['pass'];//
$role=$_POST['role'];//
$query="select Name FROM CVC_User where Email='".$user."' and Password='".$pass."' and (Role=".$role." or Role=3)";

$host="db1.mgmt.hpc.mssm.edu";
$uname="wangj27";
$pass="snoopy";
$database = "kb_CancerVariant_Curation";	
//my $opt_host="db";
//my $opt_user="lih16_a";
//my $opt_passwd="Gkhbwef45YU";
//my $opt_database="lih16_a";

$connection=mysql_connect($host,$uname,$pass); 

echo mysql_error();

//or die("Database Connection Failed");
$selectdb=mysql_select_db($database) or die("Database could not be selected");	
$result=mysql_select_db($database)
or die("database cannot be selected <br>");

	
// Fetch Record from Database

//echo $query."\n";
$sql 			= mysql_query($query);

 $rows = mysql_num_rows($sql);
 if($rows>0){
    while ($row = mysql_fetch_array($sql)) {
		 $_SESSION['uname'] = $row[0];
     echo $row[0];
   }
    $_SESSION['username'] = $user;
  
}
else
	echo "0";










*/
public function getlogin()


{
 	session_start(); // Starting Session
	
	$error=''; // Variable To Store Error Message
	if (isset($_POST['submit'])) 
	{
		$this->db = Db::getInstance();
		if (empty($_POST['username']) || empty($_POST['password'])) {
			//$error = "Username or Password is invalid";
			return 'invalid user';
		}
		else
		{
			// Define $username and $password
			$user=$_POST['username'];
			$pass=$_POST['password'];//
			$role=$_POST['role'];//
			$query="select Name FROM CVC_User where Email='".$user."' and Password='".$pass."' and (Role=".$role." or Role=3)";
			
			$stmt     = $this->db->prepare($query);
        try {
            $stmt->execute();
        }
        catch (PDOException $e) {
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