<!DOCTYPE html>
<html>
<head>
 <style>
         .ui-widget-header,.ui-state-default, ui-button {
            background:#b9cd6d;
            border: 1px solid #b9cd6d;
            color: #FFFFFF;
            font-weight: bold;
         }
		 div.hidediv{
	display:none;
}
  </style>
<title>Cancer Curation Viewer</title>
<link href="<?php echo CSS_PATH; ?>/headmenu.css" rel="stylesheet" type="text/css">
 
 
 
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>/jquery.dataTables.css">
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="<?php echo JS_PATH;?>/jquery.dataTables.js" type="text/javascript" language="javascript" ></script>
	<?php
	session_start();
		if(!isset($_SESSION['username'])){
			header("location: ../login/login");
			exit();
		}

		$uid=$_SESSION['username'];
		$uname=$_SESSION['uname'];
		$role=$_SESSION['role'];
		
		echo "Welcome ".$uname.":<br>";
		
		?>
	
</head>

<body>

<div>

<button class="searchbutton" onclick="logout();return false;" style="float: right;">Log out</button>
   <h3 style="color: #594F4F; font-family: 'Droid serif', serif; font-size: 36px; font-weight: 400; font-style: italic; line-height: 44px; margin: 0 0 12px; text-align: center; ">
      Variant Curation Viewer
   </h3>
</div>
<script>
var uid="<?php echo $_SESSION['username'];?>";
var admin="<?php echo $_SESSION['role'];?>";
function logout(){
	window.location.href="../login/logout";
	
}
</script>
<script src="<?php echo JS_PATH;?>/app.js" type="text/javascript" language="javascript" ></script>
