<!DOCTYPE html>
<html>

<head>
  <title>Add Narrative - Cancer Alteration Viewer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>




  <body>
    <div class="container">
      <div class="form-group">
        <form class="form" method="post" action="../data_manager/submit">
          <h2> Cancer Alteration Viewer Data Management</h2>
          <label>Cancer :</label><input type="text" name="cancer" id="cancer">
          <label>Gene :</label><input type="text" name="gene" id="gene">
          <label>Alteration :</label><input type="text" name="alteration" id="alteration">
          <button type="submit" name="addNarrative" id="addNarrative" value="addNarrative">Submit Pre-Narrative</button>
          <button type="upload" name="uploadNarrative" id="uploadNarrative" value="uploadNarrative">Upload</button>
          <button type="preview" name="previewNarrative" id="previewNarrative" value="previewNarrative">Preview</button>
        </form>
      </div>
</body>
</html>
