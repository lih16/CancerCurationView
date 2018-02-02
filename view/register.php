<?php
$connection = mysql_connect("ec2-34-234-146-130.compute-1.amazonaws.com", "wangj27", "snoopy"); // Establishing connection with server..
$db = mysql_select_db("kb_CancerVariant_Curation", $connection); // Selecting Database.


$name=$_POST['name1']; // Fetching Values from URL.
$email=$_POST['email1'];
$password= sha1($_POST['password1']); // Password Encryption, If you like you can also leave sha1.
$password= $_POST['password1'];
/*$email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitizing email(Remove unexpected symbol like <,>,?,#,!, etc.)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
echo "Invalid Email.......";
}else{
$result = mysql_query("SELECT * FROM registration WHERE email='$email'");
*/
$result = mysql_query("SELECT * FROM CVC_User WHERE email='$email'");
$data = mysql_num_rows($result);
if (($data)==0) {
    $query = mysql_query("insert into CVC_User(name, email, password) values ('$name', '$email', '$password')"); // Insert query
    if ($query) {
        echo "You have Successfully Registered.....";
        echo "<a href='index.php'>login</as>";
    } else {
        echo "Error....!!";
    }
} else {
    echo "This email is already registered, Please try another email...";
}
//}
mysql_close($connection);
