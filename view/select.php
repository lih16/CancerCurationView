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



<table class="key" align=center border=1>
	<style>
	.key {
		 background-color: #ffffff;
		  border: 1px solid black;
			padding: 2px;
	}
	</style>
<thead>
<tr>
<th colspan=4>Key for indentifying which alterations have a narrative </th>
  </tr>
</thead>
<tbody>
  <tr>
<td>None: &#x25CB;</td>
<td>Narrative: &#x25D0; </td>
<td>Report-Style: &#x25D1;</td>
<td>Both: &#x25CF;</td>
    </tr>
</tbody>
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
