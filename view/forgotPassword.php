<!DOCTYPE html>
<html>

<head>
  <title>Reset Password - Cancer Alteration Viewer</title>
  <meta name="robots" content="noindex, nofollow">
  <link href="<?php echo CSS_PATH; ?>/register.css" rel="stylesheet" type="text/css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#register").click(function() {

        var email = $("#email").val();

        if (email == '') {
          alert("Please provide email");
          return false;
        } else {
          $.post("resetPassword.php", {
            password1: password
          }, function(data) {
            if (data == 'You have Successfully reset your password.....') {
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
      <form class="form" method="post" action="../register/submit_forgot">
        <h2> Cancer Alteration Viewer Reset Password<i class="fa fa-lock fa-4x"></i></h2>
       <label>Email :</label>
        <input type="text" name="username" id="username">
        <button type="submit" name="register" id="register" value="Register">Reset Password</button>
      </form>
    </div>
</body>
</html>
