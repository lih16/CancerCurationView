var gtissue;
var ggene;
var gmutation;

var gcurVername=0;
$(document).ready(function() {
	addList();
    $("#tumorTypeselect").change(function() {
        var tissue = $("#tumorTypeselect option:selected").val();
        addcellList(tissue);
    });
    $("#geneselect").change(function() {
        var genename = $("#geneselect option:selected").val();
        var tissue = $("#tumorTypeselect option:selected").val();
        addMutationList(tissue, genename);

    });

	if(admin==1){
		$("#adminEditB").text("All Comments").hide();
	    $("#adminSaveB").hide();
		$("#adminNewB").hide();
	}
	else{

		$("#adminEditB").text("Edit").hide();
		$("#adminSaveB").hide();
		$("#adminNewB").hide();


	}

});

function narrative(e, tumor, gene, mutation) {

    e.preventDefault();

    gtissue   = $("#tumorTypeselect option:selected").text();

    ggene     = $("#geneselect option:selected").text();
    gmutation = $("#mutationselect option:selected").text();
	if(gtissue.indexOf("select")>0){

		alert("please select Tumor  first");
		return false;

	}
	if(ggene.indexOf("select")>0){

		alert("please select gene name first");
		return false;

	}
	if(gmutation.indexOf("select")>0){

		alert("please select mutation first");
		return false;

	}

	$(editdiv).hide();


    getnarrative("tissue");
	$("#adminModify").hide();
	if(admin==1){
		$("#adminEditB").text("All Comments").hide();
		$('#nardiv').attr('contenteditable','true');
		//$("#nardiv").css("background-color","white");
	    $("#adminSaveB").show();
		$("#adminNewB").show();
	}
	else{

		$("#adminEditB").text("Edit").hide();
		$("#adminSaveB").hide();
		$("#adminNewB").hide();


	}
	$("#nardiv").hide();
	loadnarrativeTable();
	$("#versionlist").show();
}

function getnarrative(tissue1) {

    $.ajax({
        type: 'POST',
        url: 'getnarrative',
        dataType: 'text',
        data: {
            cancer : gtissue,
			gene   : ggene,
			variant: gmutation
        },
        success: function(data1) {

			if(data1){
              $("#nardiv").html(data1);
			}
			else{
			  $("#nardiv").html("the narrative is coming soon.");
			}
            return false;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Parse error");
        }
    });
}

function addcellList(tissue) {
    $.ajax({
        type: 'POST',
        url: 'getgenes',
        dataType: 'text',
        data: {
            cancer: tissue
        },
        success: function(data1) {
            var celllineList = data1.split("\n");
            $("#geneselect").empty();
            var ddl = $("#geneselect");
            ddl.append("<option value='3'>Please select gene</option>");
            for (k = 0; k < celllineList.length; k++)
                ddl.append("<option value='" + celllineList[k] + "'>" + celllineList[k] + "</option>");
            return false;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Parse error");

        }
    });
}

function addMutationList(tissue, gene) {
    $.ajax({
        type: 'POST',
        url: 'getgenemutations',
        dataType: 'text',
        data: {
            cancer: tissue,
            gene: gene
        },
        success: function(data1) {
            var celllineList = data1.split("\n");
            $("#mutationselect").empty();
            var ddl = $("#mutationselect");
            ddl.append("<option value='1'>Please select mutation</option>");
            for (k = 0; k < celllineList.length; k++)
                ddl.append("<option value='" + celllineList[k] + "'>" + celllineList[k] + "</option>");
            return false;

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Parse error");

        }
    });

}



function addList() {
    $.ajax({
        type: 'POST',
        url: 'gettumor',
        dataType: 'text',
        success: function(data1) {
            var tissueList = data1.split("\n");
            $("#tumorTypeselect").empty();
            var ddl = $("#tumorTypeselect");
            ddl.append("<option value='2'>Please select tumor type</option>");
            for (k = 0; k < tissueList.length; k++)
                ddl.append("<option value='" + tissueList[k] + "'>" + tissueList[k] + "</option>");
            return false;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Parse error");
        }
    });


}

function save_comment_paragrah(pid, comment) {
    $.ajax({
        type: 'POST',
        url: 'savecomment',
        dataType: 'text',
        data: {
            cancer: gtissue,
            gene: ggene,
            mutation: gmutation,
            pid: pid,
            comment: comment,
            uid: uid
        },
        success: function(data1) {
            return false;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Parse error");
            return false;
        }
    });

}
var gstatus=0;
function modifycomment(e, id, index, status) {
    e.preventDefault();
	if (status ==3){
		$(id).closest('p').find('textarea').hide();
		return false;

	}
    if (gstatus == 0) {
        $(id).closest('p').find('textarea').show();
		$(id).closest('p').find('textarea').val('');
		$(id).text("save");
		gstatus=1;
        return false;;
    } else if (gstatus == 1) { //save the narrative to the database.

        var comment = $(id).closest('p').find('textarea').val();
		if (!$.trim(comment)) {
           alert("Please input your comment;");
		   return false;
       }
	    $(id).text("comment");
		gstatus=0;
        $(id).closest('p').find('textarea').hide();
        $(id).closest('p').find('textarea').empty();
        save_comment_paragrah(index, comment);
        return false;
    }


}
var curdiv = "#nardiv";
/*function adminmodify(e, cancertype, gene, mutation) {
    var mtext = "";
    var html = "";
    var clone = curdivclone.clone();
    clone.find("p").each(function(index) {
        index = index + 1;
        var cindex = "paragraph " + index + ":\r\n";
        mtext = mtext + cindex + $(this).text() + "\r\n" + "\r\n";

    });
    $(curdiv).find("p").each(function(index) {
        index = index + 1;
        html = html + "paragraph " + index + ":<span class=\"notin\" style=\"color:red\"> test partpard</span><br><hr>";
    });
    var text1 = "<div contenteditable=\"true\">" + mtext + "</div>";
    $("#adminModify").html(text1 + "<div style=\"border-style: dotted;border-width: 2px;\">" + html + "</div>");
    $(curdiv).html(curdivclone.html());
    $(curdiv).hide();

}*/
var editdiv="#editoriv";
function modifyparagraph(e, cancertype, gene, mutation) {
	   if($(editdiv).is(':visible'))
       {
           return false;
       }
        $(editdiv).show();

		$(editdiv).html($(curdiv).html());

        $(editdiv).find("p").each(function(index) {
            index = index + 1;
            var divarea = "<div class=\"divcomment\" >sdafasdfsadf</div>";
            var textaread = "<textarea  style=\"display:none;\"></textarea>";
            var mbutton = "<button class=\"notin\" onclick=\"modifycomment(event,this," + index + ",0)\">Comment</button>";
            //var sbutton = "<button class=\"notin\" onclick=\"modifycomment(event,this," + index + ",3)\">Cancel</button>";
            var cindex = "<span class=\"notin\" style=\"color:blue\">" + index + ":</span>";
			if(admin==2){
				$(this).html(cindex + " "  + $(this).html() +  divarea+ "  <br> " +mbutton  + "  <br> " + textaread);
				$("#versionlist").show();
				loadnarrativeTable();
			}
			else{

				$(this).html(cindex + " "  + $(this).html() +  divarea);
				$("#versionlist").show();
				loadnarrativeTable();

			}
        });
        updateMsg();
}
function render(id,data){
	var html="<ul>";
   $.each(data, function(i, item) {
    var colori=colorCode[item.uid];


    html=html+"<li><span style=\"color:"+colori+"\">"+item.uid+": "+item.date_edit+": "+item.comment+"</span></li>";


  });
  html=html+"</ul>";
  id.html(html);
}
var colorCode={};
var colorArray=[];
var num_colors=100;
;

/* generates a value while allowing the customization of the minimum and maximum values*/
function randomVal(min, max) {
  return Math.floor(Math.random() * (max - min) + 1) + min;
}

/* TO CUSTOMIZE

In the generate() function below, change the numbers in randomVal(); min to max

EX to only generate colors from green to blue, change the first set to (120, 240)
*/
function makeColor(colorNum, colors){
    if (colors < 1) colors = 1; // defaults to one color - avoid divide by zero
    return colorNum * (360 / colors) % 360;
}


for (var i = 0; i < num_colors; i += 1) {
   /* color = "color: hsl(" + i * 10 + ", 50%, 50%)";
	//colorNum * (360 / colors) % 360) + ",100%,50%
	h=Math.floor(Math.random() * num_colors) * (360 / num_colors) % 360 ;//* (360 / num_colors) % 360;//randomVal(0, 360);
	s=1.0;//randomVal(30, 95);
	l=0.5;//randomVal(30, 80);

	var rgb=hslToRgb(h, s, l);
	var hex=rgbToHex(rgb[0], rgb[1], rgb[2]);
	alert(hex);
	*/
	var color = "hsl( " + makeColor(i, num_colors) + ", 100%, 50% )";
	//alert(color);
	colorArray.push(color);
}




/**
 * Converts an HSL color value to RGB. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
 * Assumes h, s, and l are contained in the set [0, 1] and
 * returns r, g, and b in the set [0, 255].
 *
 * @param   {number}  h       The hue
 * @param   {number}  s       The saturation
 * @param   {number}  l       The lightness
 * @return  {Array}           The RGB representation
 */
function hslToRgb(h, s, l){
    var r, g, b;

    if(s == 0){
        r = g = b = l; // achromatic
    }else{
        var hue2rgb = function hue2rgb(p, q, t){
            if(t < 0) t += 1;
            if(t > 1) t -= 1;
            if(t < 1/6) return p + (q - p) * 6 * t;
            if(t < 1/2) return q;
            if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
            return p;
        }

        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        var p = 2 * l - q;
        r = hue2rgb(p, q, h + 1/3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1/3);
    }

    return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
}



function rgbToHex(r, g, b) {
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
}
/////////////////////
function getmessage(pid, id) {
	$.ajax({
        type: 'POST',
        url: 'getcomment',
        dataType: 'json',
        data: {
            cancer: gtissue,
            gene: ggene,
            mutation: gmutation,
            pid: pid,
        },
        success: function(data1) {
			var i=0;
			var uid1;
			$.each(data1, function(key1, value1) {
				//

				colorCode[value1.uid]=colorArray[key1];


           });
            render(id,data1);
            return false;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {

            return false;
        }
    });


}

function addMessage() {
    $(editdiv).find("p").each(function(index) {
        index = index + 1;
        id = $(this).find('.divcomment');
        getmessage(index, id);
    });

}
function updateMsg() {
    addMessage();
	if(admin==2)
    setTimeout('updateMsg()', 800);
}
function generateHtml(htmlcontent){
	var mtext = "";
    var html = "";
	if(htmlcontent!=2){
		//alert(htmlcontent);
		mtext=htmlcontent;
	}
	else{
		/*var clone = $(curdiv).clone();
		clone.find("p").each(function(index) {
			index = index + 1;
			var cindex = "paragraph " + index + ":<br>";
			mtext = mtext + cindex + $(this).text() + "<br>" + "<br>";

		});*/
		mtext=$(curdiv).html();
	}
	$("#nardiv").html(mtext);
	$("#nardiv").show();
	modifyparagraph();

   /* $(editdiv).find("p").each(function(index) {
          index = index + 1;

          html = html + "paragraph " + index + ":<span class=\"notin\" style=\"color:red\">" + $(this).find('.divcomment').html() + "</span><br><hr>";

     });
	 var label="Modify the narrative ";
	 if(admin==2){
		 label="Modification of  the narrative ";
	 }
	 var editablediv="<div id=\"mynarrative\" style=\"border-style: dashed ;background-color: yellow; border-color:green;border-width: 2px;\" contenteditable=\"true\">";
	 if(admin==2){
		 editablediv="<div id=\"mynarrative\" style=\"border-style: dashed ; background-color: yellow;border-color:green;border-width: 2px;\" >";
	 }
     var text1 = "<h1>"+label+"</h1>"+ editablediv+ mtext + "</div><hr>";
	 //alert(text1);
     $("#adminModify").html(text1 + "<div style=\"border-style: dotted;border-width: 2px;\">" + html + "</div>");*/
     //$(curdiv).html(curdivclone.html());
     //$(curdiv).hide();

}
function adminmodify(e, stu,id) {


	 e.preventDefault();
	 changeColor();
	 $(id).css('color','red');
	 $(id).text("Current Version");

	 if(stu==2){

		 generateHtml(2);

	 }
	 else{
	   var myhtml=$(id).closest('td').find('.hidediv').html();
	   //alert(myhtml);
       generateHtml(myhtml);
	   //alert($(id).closest('tr').find('td').eq(1).html());
	   gcurVername=$(id).closest('tr').find('td').eq(1).html();

	 }
	 return false;
}
function getnarrativeList() {

    $.ajax({
        type: 'POST',
        url: 'getnarrativeList',
        dataType: 'json',
        data: {
            cancer: gtissue,
            gene: ggene,
            mutation: gmutation

        },
        success: function(data1) {
            return false;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Parse error");
            return false;
        }
    });


}

function loadnarrativeTable() {
    var newUrl = "getnarrativeList";
    var n = 0;
    if ($.fn.DataTable.isDataTable("#narrativelist")) {
        $("#narrativelist").dataTable().fnDestroy();
        n = 1;
    }
     var table = $('#narrativelist').dataTable({
        "processing": true,
        "serverSide": true,
        "fnDrawCallback": function(oSettings) {
            addnarButton();
			return false;

        },
        "ajax": {
            "url": "getnarrativeList?gene="+ggene+"&cancer="+gtissue+"&variant="+gmutation+"&order=date_admin",
            "type": "GET"

        }
    });
    if (n == 1)
        table.fnDraw();
    return false;


}
function changeColor(){
	$('#narrativelist > tbody tr').each(function(index, value) {
		var objcount = $(this).find('td').eq(0);
		objcount.find('a').css('color','blue');
		objcount.find('a').text("Modify");

	});

}

function addnarButton() {
    var rowCount = $('#narrativelist >tbody tr').length;
	var colCount = $('#narrativelist > tbody').children('tr:first').find('td').length;
	 //$(editdiv).hide();
		//$("#adminModify").show();
	//alert(rowCount+":"+colCount);
	if((rowCount==1)&&(colCount==1)){
		gcurVername=0;
		var aver="Original Version";
		//gcurVername=aver;
		if(admin==2){
			aver="The Modification from the admin is coming!";
		}
		var buttonHtml="<a href=\"#\" >"+aver+"</a>";
		$('#narrativelist > tbody tr').each(function(index, value) {
			var objcount = $(this).find('td').eq(0);
			//var hidedivHtml="<div class=\"hidediv\">"+objcount.html()+"</div><a href=\"#\" onclick=\"adminmodify(event, 1,this);return false;\">modify</a>";

			objcount.html(buttonHtml);
		});

	}
	else{
		//gcurVername=1;
		$('#narrativelist > tbody tr').each(function(index, value) {
			var objcount = $(this).find('td').eq(0);

	  var name="Modify";
	  var color="blue";
	  if(admin==2){
		  name="View";

	  }

	 if(gcurVername==$(this).find('td').eq(1).html()){
		 name=gcurVername;
		 color="red"
	 }

			var hidedivHtml="<div class=\"hidediv\">"+objcount.html()+"</div><a href=\"#\" style=\"color:"+color+"\" onclick=\"adminmodify(event, 1,this);return false;\">"+name+"</a>";

			objcount.html(hidedivHtml);
		});
	}
}
//gcurVername
function saveNarrative(e,saveOrnot) {
	    var mynarrative=$('#nardiv').html();
		//alert(saveOrnot+":"+mynarrative);
		var version;
		if(saveOrnot==0){

		   if( $("#newvInput").val().length === 0 ){
			   alert("Please select your current version first!");
			   return false;

		   }
		   else{
			   version=$("#newvInput").val();
		   }
		}
		else{

			version=gcurVername;
			// alert(version);
		}
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'saveNarrative',
            dataType: 'text',
            data: {
                cancer:   gtissue,
                gene:     ggene,
                mutation: gmutation,
				narrative:mynarrative,
				ver_name: version,
				saveormodify:saveOrnot
            },
            success: function(data1) {

				loadnarrativeTable();
				//alert("Your narrative has been stored successfully!");
                return false;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Parse error");
                return false;
            }
        });


 }

function adminNewVersion(e, cancer, gene, mutation) {
	e.preventDefault();
    openDialog();
    return false;


}

function closeNewVdialog(e, saveOrnot) {
	$("#newvDialog").dialog("close");
    if (saveOrnot == 0) {
		saveNarrative(e,0);

    }
}
function  openDialog()
{
    var dt = new Date();
    var time = "version_" + dt.getFullYear() +"_"+(dt.getMonth()+1) +"_"+dt.getDate() +"_"+dt.getHours() + "_" + dt.getMinutes() + "_" + dt.getSeconds();
    $("#newvInput").val(time);
    //
    $("#newvDialog").dialog({
        autoOpen: true,
        hide: "puff",
        show: "slide",
        height: 200
    });
}
function adminSave(e, cancertype, gene, mutation) {
	//alert(gcurVername);
	if(gcurVername==0){
		openDialog();
	}
	else{
		saveNarrative(e,1);
	}

}
