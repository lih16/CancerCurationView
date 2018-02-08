var gtissue;
var ggene;
var gmutation;
var greport = 0;
var gcurVername = 0;
$(document).ready(function () {
    addList();
    $("#tumorTypeselect").change(function () {
        var tissue = $("#tumorTypeselect option:selected").val();
        addcellList(tissue);
    });
    $("#geneselect").change(function () {
        var genename = $("#geneselect option:selected").val();
        var tissue = $("#tumorTypeselect option:selected").val();
        addMutationList(tissue, genename);
    });
    if (admin == 1) {
        $("#adminEditB").text("All Comments").hide();
        $("#adminSaveB").hide();
        $("#adminNewB").hide();
    } else {
        $("#adminEditB").text("Edit").hide();
        $("#adminSaveB").hide();
        $("#adminNewB").hide();
    }
});
/*
* Selects  narrative or report-style narrative value from databuse using the selected combination of tumor, gene, mutation
*
* @global greport checks if its regular narrative or report style
* @global gtissue gets the value of the selected tumor type
* @global ggene gets the value of the selected gene type
* @global gmutation gets the value of the selected mutation/alteration
* @var tmutation gets raw value of selected mutation ,  but needs to split to separate flag from mutation
* @var mutationFlagArray splits tmutation into array flag and mutation.  where gmutation will get the value of mutation
*
* @function narrative returns narrative value,  alerts user of order of selection.
**/
function narrative(e, tumor, gene, mutation, report) {

    e.preventDefault();

    greport = report;
    gtissue = $("#tumorTypeselect option:selected").text();
    ggene = $("#geneselect option:selected").text();
    tmutation = $("#mutationselect option:selected").text();//11/29/17 modify so the mutation and flag number can be split
    var mutationFlagArray = tmutation.split(' ');//splits mutation from flag
    gmutation = mutationFlagArray[0];// global variable

    if (gtissue.indexOf("select") > 0) {

        alert("please select Tumor  first");
        return false;

    }
    if (ggene.indexOf("select") > 0) {

        alert("please select gene name first");
        return false;

    }
    if (gmutation.indexOf("select") > 0) {

        alert("please select alteration first");
        return false;

    }
    $(editdiv).hide();
    startWorker();
    var ret = getnarrative("tissue");


}

/*
* Gets  narrative from the result of the @function narrative and displays it below
*
* If narrative is not in database than alert will be displayed.
*  Displays table below narrative which is dependent on if user is logged on as
* @var mutationFlagArray splits tmutation into array flag and mutation.  where gmutation will get the value of mutation
* @function narrative returns narrative value,  alerts user of order of selection.
**/
function getnarrative(tissue1) {

    $.ajax({
        async: false,
        type: 'POST',
        url: 'getnarrative',
        dataType: 'text',
        data: {

            cancer: gtissue,
            gene: ggene,
            variant: gmutation,
            report: greport
        },
        success: function (data1) {

            if ((data1 == "1") || (!data1)) {
                alert("There is no narrative yet");
                if (admin == 1) {
                    $("#adminEditB").text("All Comments").hide();
                    $('#nardiv').attr('contenteditable', 'true');
                    //$("#nardiv").css("background-color","white");
                    $("#adminSaveB").hide();
                    $("#adminNewB").hide();
                } else {

                    $("#adminEditB").text("Edit").hide();
                    $("#adminSaveB").hide();
                    $("#adminNewB").hide();


                }
                $("#versionlist").hide();
                $("#nardiv").hide();
                return false;

            }

            if (data1) {
                $("#nardiv").html(data1);
                // $("#nardiv").show();
                $("#adminModify").hide();
                if (admin == 1) {
                    $("#adminEditB").text("All Comments").hide();
                    $('#nardiv').attr('contenteditable', 'true');
                    //$("#nardiv").css("background-color","white");
                    $("#adminSaveB").show();
                    $("#adminNewB").show();
                } else {

                    $("#adminEditB").text("Edit").hide();
                    $("#adminSaveB").hide();
                    $("#adminNewB").hide();


                }
                $("#nardiv").show();
                loadnarrativeTable();
                $("#versionlist").show();
            }

            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("getNarrative Parse error");
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
        success: function (data1) {
            var celllineList = data1.split("\n");
            $("#geneselect").empty();
            var ddl = $("#geneselect");
            ddl.append("<option value='3'>Please select gene</option>");
            for (k = 0; k < celllineList.length; k++)
                ddl.append("<option value='" + celllineList[k] + "'>" + celllineList[k] + "</option>");
            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("AddCellList Parse error");

        }
    });
}

/*
*11/29/17
* function to add symbols to see which alterations have narrative or report narrative
*/
function notifyNarrativeTable(flagMutation) {
    var result = "notifyNarrativeTable parse error";
    var flagArray = flagMutation.split('#');
    if (flagArray.length != 3) {
        return result;
    }
    var mutation = flagArray[0];
    var flag = flagArray[1];
    switch (flag) {
        case '0':
            htmlflag = "\u25CB" + "\u25CB"//empty circle
            break;
        case '1':
            htmlflag = "\u25CF" + "\u25CB"  //half circle left
            break;
        case '2':
            htmlflag = "\u25CB" + "\u25CF" //half circle right
            break;
        case '3':
            htmlflag = "\u25CF" + "\u25CF" //full circle
            break;
        default:
            htmlflag = "\u25CB" //empty circle
    }
    result = mutation + " " + htmlflag;
    return result;
}
/*
*12/15/17
* function to generate html for optgroups
*/
function constructHtml(groupObj) {
    var constructHtml = "";
  $.each(groupObj, function(group, mutations) {

    constructHtml = constructHtml + "<optgroup label=\"" + group + "\">";

        for (var i = 0; i < mutations.length; i++) {
            var mutations_w = notifyNarrativeTable(mutations[i]);
             if (mutations_w == "constructHtml parse error"){
               continue;
             }
            constructHtml = constructHtml + "<option>";
            constructHtml = constructHtml + mutations_w;
            constructHtml = constructHtml + "</option>";
        }
        constructHtml = constructHtml + " </optgroup>";
    });
return constructHtml;
}
/*
*12/15/17
* function to generate html for optgroups
*/
function getGroups(alterations, regularEXP){
var groupObj = {};
  var regGroup = new RegExp(regularEXP, 'i');
for(var i=0; i < alterations.length;i++) {
   //var separated= notifyNarrativeTable(alterations[i]);
   var result2 =regGroup.exec(alterations[i]);

       if (result2 !== null) {
            if (groupObj[result2[1]] === undefined) {
                groupObj[result2[1]] = [];

            }
            groupObj[result2[1]].push(alterations[i]);
            console.log(alterations[i]);
       }
       else {
            groupObj[alterations[i]] = [alterations[i]];
       }

}
  return constructHtml(groupObj);

}
/*
*11/29/17
*  Adds mutation(alteratons) list  from database
*
*@function puts mutations into select drop down box
*/
function addMutationList(tissue, gene) {
    $.ajax({
        type: 'POST',
        url: 'getGeneMutations',
        dataType: 'text',
        data: {
            cancer: tissue,
            gene: gene
        },
        success: function (data1) {
            var celllineList = data1.split("\n");//this one we get all the mutation list
            $("#mutationselect").empty();// will render the select options
            var ddl = $("#mutationselect");

                    var groupselectHtml=getGroups(celllineList,/(?:p\.)([a-z|A-Z][1-9][0-9]*)(?:[[a-zA-Z]|\_|\>|\*)/);
                    ddl.append(groupselectHtml);

            return false;

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("addMutationList Parse error");

        }
    });

}
/*
*02/05/18
*  Adds tumor list  from database
*
*@function puts tumor-type into select drop down box
*/

function addList() {
    $.ajax({
        type: 'POST',
        url: 'gettumor',
        dataType: 'text',
        success: function (data1) {
            var tissueList = data1.split("\n");
            $("#tumorTypeselect").empty();
            var ddl = $("#tumorTypeselect");
            ddl.append("<option value='2'>Please select tumor type</option>");
            for (k = 0; k < tissueList.length; k++)
                ddl.append("<option value='" + tissueList[k] + "'>" + tissueList[k] + "</option>");
            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("addList Parse error");
        }
    });


}

/*
*02/05/18
*  IN EDIT MODE: lets user save comment
*
*@function saves text from box and puts into CVC_viewer_editor database
*/

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
            version: gcurVername,
            comment: comment,
            uid: uid,
            report: greport
        },
        success: function (data1) {
            //alert(data1);
            getAjaxMessage();
            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("save_comment_paragragh Parse error");
            return false;
        }
    });

}

var gstatus = 0;
/*
*02/05/18
*  IN EDIT MODE: lets modify comment or narrative text
*
*@function is used in modifyparagraph to update narratives in admin mode
*/
function modifycomment(e, id, index, status) {
    e.preventDefault();
    if (status == 3) {
        $(id).closest('p').find('textarea').hide();
        return false;

    }
    if (!$(id).closest('p').find('textarea').is(':visible')) {
        $(id).closest('p').find('textarea').show();
        $(id).closest('p').find('textarea').val('');
        $(id).text("save");
        gstatus = 1;
        return false;
        ;
    } else { //save the narrative to the database.

        var comment = $(id).closest('p').find('textarea').val();
        if (!$.trim(comment)) {
            alert("Please input your comment;");
            return false;
        }
        $(id).text("comment");
        gstatus = 0;
        $(id).closest('p').find('textarea').hide();
        $(id).closest('p').find('textarea').empty();
        save_comment_paragrah(index, comment);
        return false;
    }


}

var curdiv = "#nardiv";

var editdiv = "#editoriv";
/*
*02/05/18
*  IN EDIT MODE: lets user  modify text area
*
*@function is used in generateHtml to update narratives in admin mode
*/
function modifyparagraph(e, cancertype, gene, mutation) {
    if ($(editdiv).is(':visible')) {
        return false;
    }

    $(editdiv).show();

    $(editdiv).html($("#nardiv").html());

    $(editdiv).find("p").each(function (index) {
        index = index + 1;
        var divarea = "<div class=\"divcomment\" >sdafasdfsadf</div>";
        var textaread = "<textarea  style=\"display:none;\"></textarea>";
        var mbutton = "<button class=\"notin\" onclick=\"modifycomment(event,this," + index + ",0)\">Comment</button>";
        //var sbutton = "<button class=\"notin\" onclick=\"modifycomment(event,this," + index + ",3)\">Cancel</button>";
        var cindex = "<span class=\"notin\" style=\"color:blue\">" + index + ":</span>";
        if (admin == 2) {
            $(this).html(cindex + " " + $(this).html() + divarea + "  <br> " + mbutton + "  <br> " + textaread);
            $("#versionlist").show();
            loadnarrativeTable();
        } else {

            $(this).html(cindex + " " + $(this).html() + divarea);
            $("#versionlist").show();
            loadnarrativeTable();

        }
    });
    updateMsg();
}

/*
*02/05/18
*  IN EDIT MODE and ADMIN MODE: lets users to current comments
*
*@function is used in adminModify and save_comment_paragrah to see current comments
*/
function getAjaxMessage() {
    $.ajax({
        type: 'GET',
        url: 'getcomment',
        dataType: 'json',
        data: {
            cancer: gtissue,
            gene: ggene,
            mutation: gmutation,
            version: gcurVername,
            report: greport
        },
        success: function (data1) {
            //document.getElementById("result").innerHTML = event.data;
            //alert(event.data);
            var commentObj = {};
            colorCode = {};
            var cols = ["#8FBE00", "#834DD9", "#1A4F92", "#CF3348", "#FF3D7F", "#24253A", "#031634", "#036564", "#05EE4C", "#7AB317", "#0B2E59", "#00B4FF"]; //["#00FF00","#FF0000","#0000FF","#CE1836","#009989","#8853E2","#537DE2","#651366","#00A0B0","#88C100","#FFB414","#5A5A5A"];
            //var colorCode={}; var colorArray=[]; var num_colors=100;
            var uidindex = 0;
            var objarray = data1; //jQuery.parseJSON( event.data );
            for (var i = 0; i < objarray.length; i++) {
                var item = objarray[i];
                ////style=\"color:"+colori+"\"
                //colori=cols[item.paragraph_id];
                if (typeof colorCode[item.uid] === "undefined") {
                    colorCode[item.uid] = uidindex;
                    uidindex = uidindex + 1;

                }
                colori = cols[colorCode[item.uid]];
                if (typeof commentObj[item.paragraph_id] === "undefined") {
                    commentObj[item.paragraph_id] = "<li><span style=\"color:" + colori + "\">" + item.uid + ": " + item.date_edit + ": " + item.comment + "</span></li>";
                } else {
                    commentObj[item.paragraph_id] = commentObj[item.paragraph_id] + "<li><span style=\"color:" + colori + "\">" + item.uid + ": " + item.date_edit + ": " + item.comment + "</span></li>";
                }
                //alert(commentObj[item.paragraph_id]);

            }
            addMessage(commentObj);

            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

            return false;
        }
    });


}
/*
*02/05/18
*  Need for  EDIT MODE and ADMIN:
*
*@function is used in getAjaxMessage to add a comment
*/
function addMessage(obj) {
    //alert(obj);
    //alert( $(editdiv));
    //alert($("#editoriv").html());
    $(editdiv).find("p").each(function (index) {
        index = index + 1;
        id = $(this).find('.divcomment');
        //alert(index+id);
        //alert(obj[index]);
        if (typeof obj[index] === "undefined") {
            $(id).html("");
        } else {
            $(id).html("<ul>" + obj[index] + "</ul>");
        }


    });

}

/*
*02/05/18
*  IN EDIT MODE and ADMIN:
*
*@function is used in modifyparagraph function is unclear
*/
function updateMsg() {
    //  addMessage();
    //if(admin==2)
    // setTimeout('updateMsg()', 1400);
}

/*
*02/05/18
*  Used in ADMIN MODE:
*
*@function is used in adminModify to make text editable
*/
function generateHtml(htmlcontent) {
    var mtext = "";
    var html = "";
    if (htmlcontent != 2) {
        //alert(htmlcontent);
        mtext = htmlcontent;
    } else {
        /*var clone = $(curdiv).clone();
        clone.find("p").each(function(index) {
            index = index + 1;
            var cindex = "paragraph " + index + ":<br>";
            mtext = mtext + cindex + $(this).text() + "<br>" + "<br>";
        });*/
        mtext = $(curdiv).html();
    }
    $("#nardiv").html(mtext);
    $("#nardiv").show();
    modifyparagraph();

}

/*
*02/05/18
*  Used in ADMIN MODE: for text editing
*
*@function is used in addnarButton to make text editable
*/
function adminmodify(e, stu, id) {


    e.preventDefault();
    changeColor();
    $(id).css('color', 'red');
    $(id).text("Current Version");

    if (stu == 2) {

        generateHtml(2);

    } else {
        var myhtml = $(id).closest('td').find('.hidediv').html();
        //alert(myhtml);
        generateHtml(myhtml);
        //alert($(id).closest('tr').find('td').eq(1).html());
        gcurVername = $(id).closest('tr').find('td').eq(1).html();

    }
    //alert(gcurVername);
    // getComment();

    getAjaxMessage();
    //if(admin==2)
    // $("#nardiv").hide();
    return false;
}


/*
*02/05/18
*  Used in all modes: Shows list of narratives with different versions
*
*@function is used in saveNarrative, getNarrative, and modifyparagraph to generate narrative menu
*/
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
        "fnDrawCallback": function (oSettings) {
            addnarButton();
            return false;

        },
        "ajax": {
            "url": "getnarrativeList?gene=" + ggene + "&cancer=" + gtissue + "&variant=" + gmutation + "&report=" + greport,
            "type": "GET"

        }
    });
    if (n == 1)
        table.fnDraw();
    return false;


}

/*
*02/05/18
*  Used in Admin Mode: Changes colors of selection from blue to red
*
*@function is used in adminmodify to make modify button blue
*/
function changeColor() {
    $('#narrativelist > tbody tr').each(function (index, value) {
        var objcount = $(this).find('td').eq(0);
        objcount.find('a').css('color', 'blue');
        if (admin == 2)
            objcount.find('a').text("view");
        else
            objcount.find('a').text("modify");


    });

}


/*
*02/05/18
*  Used in all modes:  used for showing different narrative versions
*
*@function is used in loadnarrativeTable to order narrative by newest first
*/
function addnarButton() {
    var rowCount = $('#narrativelist >tbody tr').length;
    var colCount = $('#narrativelist > tbody').children('tr:first').find('td').length;
    //$(editdiv).hide();
    //$("#adminModify").show();
    //alert(rowCount+":"+colCount);
    if ((rowCount == 1) && (colCount == 1)) {
        gcurVername = 0;
        var aver = "First Version";
        //gcurVername=aver;
        if (admin == 2) {
            aver = "The modification from admin is coming!";
        }
        var buttonHtml = "<a href=\"#\" onclick=\"adminmodify(event,2,this);\">" + aver + "</a>";
        $('#narrativelist > tbody tr').each(function (index, value) {
            var objcount = $(this).find('td').eq(0);
            //var hidedivHtml="<div class=\"hidediv\">"+objcount.html()+"</div><a href=\"#\" onclick=\"adminmodify(event, 1,this);return false;\">modify</a>";

            objcount.html(buttonHtml);
        });

    } else {
        //gcurVername=1;
        $('#narrativelist > tbody tr').each(function (index, value) {
            var objcount = $(this).find('td').eq(0);

            var name = "modify";
            var color = "blue";
            if (admin == 2) {
                name = "view";

            }

            if (gcurVername == $(this).find('td').eq(1).html()) {
                name = "Current Version";
                color = "red"
            }

            var hidedivHtml = "<div class=\"hidediv\">" + objcount.html() + "</div><a href=\"#\" style=\"color:" + color + "\" onclick=\"adminmodify(event, 1,this);return false;\">" + name + "</a>";

            objcount.html(hidedivHtml);
        });
    }
}

/*
*02/05/18
*  Used in admin mode:  used for saving narrative versions
*
*@function is used in closeNewVdialog and adminSave
* select narrative version or create new version
*/
function saveNarrative(e, saveOrnot) {
    var mynarrative = $('#nardiv').html();
    //alert(saveOrnot+":"+mynarrative);
    var version;
    if (saveOrnot == 0) {

        if ($("#newvInput").val().length === 0) {
            alert("Please select your current version first!");
            return false;

        } else {
            version = $("#newvInput").val();
        }
    } else {

        version = gcurVername;
        // alert(version);
    }
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveNarrative',
        dataType: 'text',
        data: {
            cancer: gtissue,
            gene: ggene,
            mutation: gmutation,
            narrative: mynarrative,
            ver_name: version,
            saveormodify: saveOrnot,
            report: greport
        },
        success: function (data1) {

            loadnarrativeTable();
            //alert("Your narrative has been stored successfully!");
            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("saveNarrative Parse error");
            return false;
        }
    });


}

/*
*02/05/18
*  Used in admin modes:  open dialog menu to save new version
*
*@function is narrative.php to open a new dialog window where user can save new version
*/
function adminNewVersion(e, cancer, gene, mutation) {
    e.preventDefault();
    openDialog();
    return false;


}

/*
*02/05/18
*  Used in admin modes:  close open dialog window
*
*@function is modeldialog.php to close a  dialog window and save the narrative
*/
function closeNewVdialog(e, saveOrnot) {
    $("#newvDialog").dialog("close");
    if (saveOrnot == 0) {
        saveNarrative(e, 0);

    }
}
/*
*02/05/18
*  Used in admin modes:  open dialog menu to save new version
*
*@function is adminNewVersion and adminsave to open a new dialog window where user can save new version
* adds date to end of version number
*/
function openDialog() {
    var dt = new Date();
    var time = "version_" + dt.getFullYear() + "_" + (dt.getMonth() + 1) + "_" + dt.getDate() + "_" + dt.getHours() + "_" + dt.getMinutes() + "_" + dt.getSeconds();
    $("#newvInput").val(time);
    //
    $("#newvDialog").dialog({
        autoOpen: true,
        hide: "puff",
        show: "slide",
        height: 200
    });
}

/*
*02/05/18
*  Used in admin modes:  open dialog menu to save new version
*
*@function is narrative.php to open a new dialog window where user can save new version
*/
function adminSave(e, cancertype, gene, mutation) {
    //alert(gcurVername);

    if (gcurVername == 0) {
        openDialog();
    } else {
        saveNarrative(e, 1);
    }

}

/*
*02/05/18
*  Used in all modes:  open new page to show Annotation
*
*@function when alteration information page is clicked it will open new page with alteration information
*/
function showAnnotation() {
    //alert("aavv");
    gtissue = $("#tumorTypeselect option:selected").text();
    ggene = $("#geneselect option:selected").text();
    tmutation = $("#mutationselect option:selected").text();//11/29/17 modify so the mutation and flag number can be split
    var mutationFlagArray = tmutation.split(' ');//splits mutation from flag
    gmutation = mutationFlagArray[0];// global variable
    var url = "https://lih16.u.hpc.mssm.edu/pipeline/js/cancerVariantCuration/CancerVarCuation_forViewer.php?cancer=" + gtissue + "&gene=" + ggene + "&mutation=" + gmutation;
    window.open(url, 'window name', 'window settings')
}
