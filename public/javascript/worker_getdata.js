
/*self.addEventListener('message', function(e) {
  self.postMessage(e.data);
}, false);*/ 

//simple XHR request in pure JavaScript
function load(url, callback) {
	var xhr;

	if(typeof XMLHttpRequest !== 'undefined') xhr = new XMLHttpRequest();
	else {
		var versions = ["MSXML2.XmlHttp.5.0", 
			 	"MSXML2.XmlHttp.4.0",
			 	"MSXML2.XmlHttp.3.0", 
			 	"MSXML2.XmlHttp.2.0",
			 	"Microsoft.XmlHttp"]

		for(var i = 0, len = versions.length; i < len; i++) {
		try {
			xhr = new ActiveXObject(versions[i]);
			break;
		}
			catch(e){}
		} // end for
	}
		
	xhr.onreadystatechange = ensureReadiness;
		
	function ensureReadiness() {
		if(xhr.readyState < 4) {
			return;
		}
			
		if(xhr.status !== 200) {
			return;
		}

		// all is well	
		if(xhr.readyState === 4) {
			callback(xhr);
		}			
	}
		
	xhr.open('GET', url, true);
	xhr.send('');
}
	
//and here is how you use it to load a json file with ajax

//onmessage = function(event) {
  /*var xhr = creatXMLHTTPRequest();
  xhr.open('GET', 'https://lih16.u.hpc.mssm.edu/testextern.php?aa=hahaer', true);
  xhr.send(null);
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      if (xhr.status == 200 || xhr.status ==0) {
         postMessage(xhr.responseText);
      } else {
         throw xhr.status + xhr.responseText;
      }
    } 
  }*/
//  load('https://lih16.u.hpc.mssm.edu/testextern.php', function(xhr) {	
//	var result = xhr.responseText;	
//	postMessage(xhr.responseText);
//});
//}

var i = 0;
var cancer="";
var gene="";
var mutation="";
var version="";

function timedCount(e) {
     i = i + 1;
     // https://lih16.u.hpc.mssm.edu/pipeline/js/CPTAC3_backup/Viewer/public/home/getComment?cancer=Colorectal&gene=KRAS&mutation=p.G12D
	 var url="https://lih16.u.hpc.mssm.edu/pipeline/js/CPTAC3_backup/Viewer/public/home/getComment?cancer="+cancer+"&gene="+gene+"&mutation="+mutation+"&version="+version;
	 //'https://lih16.u.hpc.mssm.edu/testextern.php?aa='+cancer+":"+gene+":"+mutation
	load(url, function(xhr) {	
	var result = xhr.responseText;	
	self.postMessage(result);
   // setTimeout("timedCount()",500);
});
}

self.addEventListener('message', function(e) {
	gene=e.data[1];
	cancer=e.data[0];
	mutation=e.data[2];
	version=e.data[3];
	timedCount();
	// load('https://lih16.u.hpc.mssm.edu/testextern.php?aa=pigu', function(xhr) {	
	//var result = xhr.responseText;	
	//self.postMessage(xhr.responseText);
});
//alert("asdf"+e.data);
  //self.postMessage(e.data);
//}, false);
