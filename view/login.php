<!DOCTYPE html>
<html>
<head>
<title>Cancer Alteration Viewer</title>
<link href="<?php echo CSS_PATH; ?>/login.css" rel="stylesheet" type="text/css">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>


  <body>

    <h1>Sign In the Cancer Alteration Viewer</h1>

<div >
  <div >
    <div >
	<form action="../login/login" method="post">
      <div class="form">
        <input type="text" name="username" id="username"  class="zocial-dribbble" placeholder="Enter your email" />
        <input type="password" name="password" id="password"  placeholder="Password" />
        <select name="role" id="role" placeholder="Reviewer">
	<option value="2" selected>Pathologist/Editor</option>
	<option value="1"  >Administrator</option>
  <option value="3"  >Data Manager</option>


	</select>
	<input name="submit" type="submit" value="Login" />
  <span>Please register here if you need new account<a href="../register/register"> Here </a></span>

	</form>
      </div>
    </div>
  </div>
</div>
    <script type="text/javascript" language="javascript" src="../../jquery/jquery-1.7.2.min.js"></script>
    <script>

	</script>



  </body>
</html>
