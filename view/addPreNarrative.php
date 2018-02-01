<!DOCTYPE html>
<html>

<head>
  <title>Add Narrative - Cancer Alteration Viewer</title>
  <meta name="robots" content="noindex, nofollow">
  <link href="<?php echo CSS_PATH; ?>/dataManager.css" rel="stylesheet" type="text/css">





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
          <button type="submit" name="addNarrative" id="addNarrative" value="addNarrative">Submit Pre-Narrative</button>
          <button type="upload" name="uploadNarrative" id="uploadNarrative" value="uploadNarrative">Upload</button>
          <button type="preview" name="previewNarrative" id="previewNarrative" value="previewNarrative">Preview</button>
        </form>
      </div>
</body>
</html>
