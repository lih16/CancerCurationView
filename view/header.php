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
<title>Cancer Alteration Viewer</title>
<link href="<?php echo CSS_PATH; ?>/headmenu.css" rel="stylesheet" type="text/css">



	<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>/jquery.dataTables.css">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="<?php echo JS_PATH;?>/jquery.dataTables.js" type="text/javascript" language="javascript" ></script>
	<?php
    session_start();
        if (!isset($_SESSION['username'])) {
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

<button class="searchbutton" onclick="logout();return false;" style="float: right; margin:15px 5px">Log out</button> <a class="searchbutton" href="http://34.235.93.148/CancerCurationView/public/Cancer_curation_viewer_instruction.pdf" target="_blank" style="float: right; text-align: center;padding: 2px 3px 0px 3px;margin:15px 1px;border-radius: 5px 5px 5px 5px;">Help</a>
   <h3 style="color: #594F4F; font-family: 'Droid serif', serif; font-size: 36px; font-weight: 400; font-style: italic; line-height: 44px; margin: 0 0 12px; text-align: center; ">
      Cancer Alteration Viewer
   </h3>
</div>
<script>
var uid="<?php echo $_SESSION['username'];?>";
var admin="<?php echo $_SESSION['role'];?>";
var w;

function startWorker() {
  // alert("asdf");
    if(typeof(Worker) !== "undefined") {
        if(typeof(w) == "undefined") {
		    var path="<?php echo JS_PATH;?>"+"/worker_getdata.js";
			//alert(path);
            w = new Worker(path);
			//alert(w);

        }

    } else {
	    alert("aaaa");
        //document.getElementById("result").innerHTML = "Sorry! No Web Worker support.";
    }
}
function logout(){
	window.location.href="../login/logout";

}
</script>
<script src="<?php echo JS_PATH;?>/app.js" type="text/javascript" language="javascript" ></script>
