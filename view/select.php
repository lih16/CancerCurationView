<div class="homebox">
<div id="compare" style="display:none;"></div>
<!--<h3>Find a Tumor Gene Mutation for Drug
  <form name="DiseaseContentSearch" id="DiseaseContentSearch"> </h3>-->
<select class="lselect" id="tumorTypeselect">
  <option  value="1" selected>Tumor Type</option>
</select>
<br>
<br>
<select class="lselect" id="geneselect">
  <option value="1" selected>Genes</option>
</select>
<br>
<br>
<select class="lselect" id="mutationselect">
  <option value="1" selected>Alterations</option>
</select>
<br>
<br>
<div id="narrativeKey" style="display:none;" >
  <table class="key" align="center" border=1>
    <style>
      .key{
      border: 1px solid black;
      padding: 10px;
      }
      .key th{
      background-color: white;
      text-align:center;
      }
      .key td{
      background-color: white;
      border: 1px solid black;
      padding: 10px;
      margin: auto;
      }
      optgroup[label]{
  margin: 1em;
  background-color:fff;
  color:blue;
  border: 1px solid green;
}
optgroup option{
  margin: 1em;
  border: 1px solid orange;
  color:black;
}
    </style>
    <thead>
      <tr>
        <th colspan=4 >Narrative Key </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>No Narrative: &#x25CB; &#x25CB;</td>
        <td>Narrative: &#x25CF; &#x25CB; </td>
        <td>Report-Style Narrative: &#x25CB; &#x25CF;</td>
        <td>Both Narratives: &#x25CF; &#x25CF;</td>
      </tr>
    </tbody>
  </table>
</div>


<script>
  function showTable() {
      var x = document.getElementById("narrativeKey");
      if (x.style.display === "none") {
          x.style.display = "block";
      } else {
          x.style.display = "none";
      }
  }
</script>

<br>
<button class="searchbutton"  onclick="narrative(event,'ll','33','44',0);">Pre-Narrative</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button class="searchbutton"  onclick="narrative(event,'ll','33','44',1);">Report-Style Narrative</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button class="searchbutton"  onclick="showAnnotation();return false;">Alteration Information</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button class="searchbutton" onclick="showTable()">Narrative Key</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="http://34.235.93.148/CancerCurationView/public/images/LevelsOfEvidence.pdf"   target="_blank" style="background-color: #8FBE00; border-radius: 5px 5px 5px 5px; color: white; font-family: Enriqueta,Arial,sans-serif; text-transform: uppercase; font-size: 16px; padding: 3px 10px;">OncoKB Guideline</a>
</form>
</div>
