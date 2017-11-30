<div class="homebox">


	<div id="compare" style="display:none;"></div>
	 <!--<h3>Find a Tumor Gene Mutation for Drug</h3>-->
        <form name="DiseaseContentSearch" id="DiseaseContentSearch">
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
<table align=center border=1 cellpadding="8">
	<style>
	table.steelBlueCols {
  border: 4px solid #555555;
  background-color: #555555;
  width: 400px;
  text-align: center;
  border-collapse: collapse;
}
table.steelBlueCols td, table.steelBlueCols th {
  border: 1px solid #555555;
  padding: 5px 10px;
}
table.steelBlueCols tbody td {
  font-size: 12px;
  font-weight: bold;
  color: #FFFFFF;
}
table.steelBlueCols td:nth-child(even) {
  background: #398AA4;
}
table.steelBlueCols thead {
  background: #398AA4;
  border-bottom: 10px solid #398AA4;
}
table.steelBlueCols thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: left;
  border-left: 2px solid #398AA4;
}
table.steelBlueCols thead th:first-child {
  border-left: none;
}

table.steelBlueCols tfoot td {
  font-size: 13px;
}
table.steelBlueCols tfoot .links {
  text-align: right;
}
table.steelBlueCols tfoot .links a{
  display: inline-block;
  background: #FFFFFF;
  color: #398AA4;
  padding: 2px 8px;
  border-radius: 5px;
}
	</style>
<thead>
<tr>
<th>Key </th>
<th>None: &#x25CB;</th>
<th>Narrative: &#x25D0; </th>
<th>Report-Style: &#x25D1;</th>
<th>Both &#x25CF;</th>
</tr>
</thead>
</table>
<br>
<button class="searchbutton"  onclick="narrative(event,'ll','33','44',0);">Narrative</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button class="searchbutton"  onclick="narrative(event,'ll','33','44',1);">Report-Style Narrative</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button class="searchbutton"  onclick="showAnnotation();return false;">Alteration Information</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="http://34.235.93.148/CancerCurationView/public/images/LevelsOfEvidence.pdf"   target="_blank" style="background-color: #8FBE00; border-radius: 5px 5px 5px 5px; color: white; font-family: Enriqueta,Arial,sans-serif; text-transform: uppercase; font-size: 16px; padding: 3px 10px;">OncoKB Guideline</a>
</form>
</div>
