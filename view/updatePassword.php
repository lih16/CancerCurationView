<!DOCTYPE html>
<html>

<head>
  <title>Registration - Cancer Alteration Viewer</title>
  <meta name="robots" content="noindex, nofollow">
  <link href="<?php echo CSS_PATH; ?>/register.css" rel="stylesheet" type="text/css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#register").click(function() {

        var email = $("#email").val();
        var opassword = $("#opassword").val();
        var password = $("#password").val();
        var cpassword = $("#cpassword").val();
        if (opassword == '' || email == '' || password == '' || cpassword == '') {
          alert("Please fill all fields...!!!!!!");
          return false;
        } else if ((password.length) < 8) {
          alert("Password should atleast 8 character in length...!!!!!!");
          return false;
        } else if (!(password).match(cpassword)) {
          alert("Your passwords don't match. Try again?");
          return false;
        } else {
          $.post("updatePassword.php", {
            email1: email,
            opassword1: opassword,
            password1: password
          }, function(data) {
            if (data == 'You have Successfully Updated your password.....') {
              $("form")[0].reset();
            }
            //alert(data);
          });
        }
      });
    });
  </script>
</head>

<body>
  <div class="container">
    <div class="main">
      <form class="form" method="post" action="../register/submit_update">
        <h2> Cancer Alteration Viewer Update Password</h2>
       <label>Email :</label>
        <input type="text" name="username" id="username">
        <label>Current Password :</label>
        <input type="password" name="opassword" id="opassword">
        <label>New Password :</label>
        <input type="password" name="password" id="password">
        <label>Confirm New Password :</label>
        <input type="password" name="cpassword" id="cpassword">
          <input type="submit">Update Password</input>
      </form>
    </div>
</body>
</html>
