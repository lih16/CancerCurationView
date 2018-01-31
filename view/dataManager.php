<!DOCTYPE html>
<html>

<head>
  <title>Add Narrative - Cancer Alteration Viewer</title>
  <meta name="robots" content="noindex, nofollow">
  <link href="<?php echo CSS_PATH; ?>/register.css" rel="stylesheet" type="text/css">

  <!-- Include JS File Here -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <script>
      $(document).ready(function() {
        $("#datamanager").click(function() {
          var cancer = $("#cancer").val();
          var gene = $("#gene").val();
          var alteration = $("#alteration").val();
          var curator = $("#curator").val();
          if (cancer == '' || gene == '' || alteration == '' || curator == '') {
            alert("Please fill all fields...!!!!!!");
            return false;
          } else {
            $.post("data_menu.php", {
              cancer1: cancer,
              gene1: gene,
              alteration1: alteration
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
        <form class="form" method="post" action="../dataManager/submit">
          <h2> Cancer Alteration Viewer Data Management</h2>
          <label>Cancer :</label>
          <input type="text" name="cancer" id="cancer">
          <label>Gene :</label>
          <input type="text" name="gene" id="gene">
          <label>Alteration :</label>
          <input type="text" name="alteration" id="alteration">
          <label>Curator :</label>
          <input type="text" name="curator" id="curator">
          <button type="submit" name="addNarrative" id="addNarrative" value="addNarrative">Add Narrative</button>
        </form>
      </div>
</body>
</html>
