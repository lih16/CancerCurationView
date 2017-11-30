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
<br>



<table class="key" align="center" border=1>
	<style>
	.key  {

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
