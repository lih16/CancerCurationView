<!DOCTYPE html>
<html>

<head>
  <title>Add Narrative - Cancer Alteration Viewer</title>
  <meta name="robots" content="noindex, nofollow">
  <link href="<?php echo CSS_PATH; ?>/register.css" rel="stylesheet" type="text/css">





  <body>
    <div class="container">
      <div class="main">
        <form class="form" method="post" action="../data_manager/submit">
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
