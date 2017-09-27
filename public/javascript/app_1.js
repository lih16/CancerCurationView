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
	
    getnarrative("tissue");
	if(admin==1){
		$("#adminEditB").text("All Comments").show();
	    $("#adminSaveB").show();
		$("#adminNewB").show();
	}
	else{
		
		$("#adminEditB").text("Edit").show();
		$("#adminSaveB").hide();
		$("#adminNewB").hide();
		
		
	}
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
			  $("#nardiv").html("the narrative is comming soon.");
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

function modifycomment(e, id, index, status) {
    e.preventDefault();
    if (status == 0) {
        $(id).closest('p').find('textarea').show();
        return;
    } else if (status == 1) { //save the narrative to the database.
        $(id).closest('p').find('textarea').hide();
        var comment = $(id).closest('p').find('textarea').val();
        $(id).closest('p').find('textarea').empty();
        save_comment_paragrah(index, comment);
        return;
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
        //editdiv = $(curdiv).clone();
		$(editdiv).html($(curdiv).html());
		
        $(editdiv).find("p").each(function(index) {
            index = index + 1;
            var divarea = "<div class=\"divcomment\" >sdafasdfsadf</div>";
            var textaread = "<textarea  style=\"display:none;\"></textarea>";
            var mbutton = "<button class=\"notin\" onclick=\"modifycomment(event,this," + index + ",0)\">comment</button>";
            var sbutton = "<button class=\"notin\" onclick=\"modifycomment(event,this," + index + ",1)\">save</button>";
            var cindex = "<span class=\"notin\" style=\"color:blue\">" + index + ":</span>";
			if(admin==2){
				$(this).html(cindex + " "  + $(this).html() +  divarea+ "  <br> " +mbutton +"&nbsp;&nbsp;&nbsp;&nbsp;"+ sbutton + "  <br> " + textaread);
				//loadnarrativeTable();
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
        
    html=html+"<li><span style=\"color:blue\">"+item.uid+": "+item.date_edit+": "+item.comment+"</span></li>";
   
                
  });
  html=html+"</ul>";
  id.html(html);
}	
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
    setTimeout('updateMsg()', 400); 
}
function generateHtml(htmlcontent){
	var mtext = "";
    var html = "";
	if(htmlcontent){
		mtext=htmlcontent;
	}
	else{
		var clone = $(curdiv).clone();
		clone.find("p").each(function(index) {
			index = index + 1;
			var cindex = "paragraph " + index + ":<br>";
			mtext = mtext + cindex + $(this).text() + "<br>" + "<br>";

		});
	}

    $(editdiv).find("p").each(function(index) {
          index = index + 1;
		 
          html = html + "paragraph " + index + ":<span class=\"notin\" style=\"color:red\">" + $(this).find('.divcomment').html() + "</span><br><hr>";

     });
	 
     var text1 = "<div id=\"mynarrative\" contenteditable=\"true\">" + $(curdiv).html() + "</div>";
	 //alert(text1);
     $("#adminModify").html(text1 + "<div style=\"border-style: dotted;border-width: 2px;\">" + html + "</div>");
     //$(curdiv).html(curdivclone.html());
     //$(curdiv).hide();
	
}
function adminmodify(e, html,id) {
	
	 e.preventDefault();
	 changeColor();
	 $(id).css('color','red');
	 $(id).text("Current Version");
	 
	 if(html==null){
		 generateHtml();
		 
	 }
	 else{
	   var myhtml=$(id).closest('td').find('.hidediv').html();
       generateHtml(myhtml);
	  
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
            "url": "getnarrativeList?gene="+ggene+"&cancer="+gtissue+"&variant="+gmutation,
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
	if((rowCount==1)&&(colCount==1)){
		var buttonHtml="<a href=\"#\" onclick=\"adminmodify(event,null,this);\">First Version</a>";
		
		
	}
	else{
		$('#narrativelist > tbody tr').each(function(index, value) {
			var objcount = $(this).find('td').eq(0);
			var hidedivHtml="<div class=\"hidediv\">"+objcount.html()+"</div><a href=\"#\" onclick=\"adminmodify(event, 1,this);return false;\">modify</a>";
			
			objcount.html(hidedivHtml);
		});
	}
}
//gcurVername
function saveNarrative(e,saveOrnot) {
	    var mynarrative=$("#mynarrative").html();
		if(gcurVername==0){
		   
		   if( $("#newvInput").val().length === 0 ){
			   alert("Please select your current version first!");
			   return false;
			   
		   }
		   else{
			   gcurVername=$("#newvInput").val();
		   }
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
				ver_name: gcurVername,
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
    var dt = new Date(Date.now());
    var time = "version_" + dt.getFullYear() +"_"+dt.getMonth() +"_"+dt.getDate() +"_"+dt.getHours() + "_" + dt.getMinutes() + "_" + dt.getSeconds();
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
	if(gcurVername==0){
		openDialog();
	}
	else{
		saveNarrative(e,0);
	}
 
}