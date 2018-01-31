<!DOCTYPE html>
<html>
<head>
  <title>Add Narrative - Cancer Alteration Viewer</title>
  <meta name="robots" content="noindex, nofollow">
  <link href="<?php echo CSS_PATH; ?>/register.css" rel="stylesheet" type="text/css">
<style >
#menu{background:#464646;color:#eee;height:35px;}
#menu ul,#menu li{margin:0;padding:0;list-style:none}
#menu ul{height:35px}
#menu li{float:left;display:inline;position:relative;font:bold 13px Arial;}
#menu li a{color:#ccc}
#menu a{display:block;line-height:35px;padding:0 14px;text-decoration:none;color:#333;}
#menu li:hover > a,#menu li a:hover{color:#fff}
#menu input{display:none;margin:0 0;padding:0 0;width:80px;height:35px;opacity:0;cursor:pointer}
#menu label{font:bold 30px Arial;display:none;width:35px;height:36px;line-height:36px;text-align:center}
#menu label span{font-size:13px;position:absolute;left:35px}
#menu ul.menus{height:auto;overflow:hidden;width:180px;background:#fff;position:absolute;z-index:99;display:none;border:1px solid #ccc;border-top:none;color:#333}
#menu ul.menus a{color:#333}
#menu ul.menus li{display:block;width:100%;font:12px Arial;text-transform:none;}
#menu li:hover ul.menus{display:block}
#menu a.prett,#menu a.trigger2{padding:0 27px 0 14px}
#menu li:hover > a.prett,#menu a.prett:hover{background:#fff;color:#333}
#menu a.prett::after{content:"";width:0;height:0;border-width:6px 5px;border-style:solid;border-color:#eee transparent transparent transparent;position:absolute;top:15px;right:9px}
#menu ul.menus a:hover{background:#BABABA;}
#menu a.trigger2::after{content:"";width:0;height:0;border-width:5px 6px;border-style:solid;border-color:transparent transparent transparent #eee ;position:absolute;top:13px;right:9px}

@media screen and (max-width: 600px){
#menu{position:relative}
#menu ul{background:#838383;position:absolute;top:100%;right:0;left:0;z-index:3;height:auto;display:none;}
#menu ul.menus{width:100%;position:static;border:none}
#menu li{display:block;float:none;width:auto;text-align:left}
#menu li a{color:#fff}
#menu li a:hover{color:#333}
#menu li:hover{background:#BABABA;color:#333;}
#menu li:hover > a.prett,#menu a.prett:hover{background:#BABABA;color:#333;}
#menu ul.menus a{background:#BABABA;}
#menu ul.menus a:hover{background:#fff;}
#menu input,#menu label{position:absolute;top:0;left:0;display:block}
#menu input{z-index:4}
#menu input:checked + label{color:white}
#menu input:checked ~ ul{display:block}
}
</style>
<nav id='menu'>

<input type='checkbox'/>
<label>&#8801;<span>Navigation</span></label>

<li><a href='addNarrative.php'>Add Pre-Narrative</a></li>
<li class="hover"><a href="addReportStyle.php"  onclick="showpending();return false;">Add Report-Style Narrative</a></li>
<li><a href="addNofOne.php" >Add N-of-One</a></li>
<li><a href="addAlteration.php" >Add new Alteration</a></li>
<li align= "right" ><a href="#" >Logout</a></li>
<li>
<div class="search">
  <span class="fa fa-search" onclick="alert('a');"></span>
  <input placeholder="Search term">
</div>
</li>
</ul>
</nav>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#register").click(function() {
        var cancer = $("#cancer").val();
        var gene = $("#gene").val();
        var alteration = $("#alteration").val();
        var oncotree = $("#oncotreeCode").val();
        if (cancer == '' || gene == '' || alteration == '' || oncotree == '') {
          alert("Please fill all fields...!!!!!!");
          return false;
        } else {
          $.post("data_menu.php", {
            cancer1: cancer,
            gene1: gene,
            alteration1: alteration
            oncotree1: oncotree
          }, function(data) {
            if (data == 'Narrative has been successfully added') {
              $("form")[0].reset();
            }
            //alert(data);
          });
        }
      });
    });
  </script>


<body>
  <div class="container">
    <div class="main">
      <form class="form" method="post" action="../data_manager/submit_alteration">
        <h2> Cancer Alteration Viewer Data Management</h2>
        <label>Cancer :</label>
        <input type="text" name="cancer" id="cancer">
        <label>Gene :</label>
        <input type="text" name="gene" id="gene">
        <label>Alteration :</label>
        <input type="text" name="alteration" id="alteration">
        <label>Oncotree :</label>
        <input type="text" name="oncotreeCode" id="oncotreeCode">
        <button type="submit" name="addAlteration" id="addAlteration" value="addAlteration">Add Alteration</button>
      </form>
    </div>
</body>
</html>
