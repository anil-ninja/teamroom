function edit_content(ID, type) {
	if ( ID != null){
		$("#challenge_"+ID).hide();
		$("#challenge_ti_"+ID).hide();
		$("#challenge_title_"+ID).show();
		$("#challenge_stmt_"+ID).show();
		$("#doneedit_"+ID).show();
		$("#pic_file_"+ID).show();
		$("#challenge_pic_"+ID).show();
		$("#challenge_file_"+ID).show();
		$("#challenge_video_"+ID).show();
		$("#url_video_"+ID).show();
		$("#challenge_stmt_p_"+ID).show();
		$("#doneediting_"+ID).show();
		}
		else { return false; }
} ;
function editproject(ID) {
	if ( ID != null){
		$("#project_"+ID).hide();
		$("#project_ti_"+ID).hide();
		$("#project_title_"+ID).show();
		$("#project_stmt_"+ID).show();
		$("#project_doneedit_"+ID).show();
		$("#project_pic_file_"+ID).show();
		$("#project_pic_"+ID).show();
		$("#project_file_"+ID).show();
		$("#project_video_"+ID).show();
		$("#project_url_video_"+ID).show();
		$("#project_stmt_p_"+ID).show();
		$("#doneediting_project_"+ID).show();
		}
		else { return false; }
} ;
function upload_pic_file(ID) {
	if ( ID != null){
		$("#challenge_"+ID).hide();
		$("#challenge_ti_"+ID).show();
		$("#_fileChallenge_"+ID).show();
		$("#pic_file_save_"+ID).show();
		$("#challenge_title_"+ID).hide();
		$("#challenge_stmt_"+ID).hide();
		$("#doneedit_"+ID).hide();
		$("#pic_file_"+ID).hide();
		$("#challenge_pic_"+ID).hide();
		$("#challenge_file_"+ID).hide();
		$("#challenge_video_"+ID).hide();
		$("#url_video_"+ID).hide();
		$("#challenge_stmt_p_"+ID).hide();
		$("#doneediting_"+ID).hide();
		}
		else { return false; }
} ;
function upload_pic_file_project(ID) {
	if ( ID != null){
		$("#project_"+ID).hide();
		$("#project_ti_"+ID).show();
		$("#project_fileChallenge_"+ID).show();
		$("#pic_file_project_"+ID).show();
		$("#project_title_"+ID).hide();
		$("#project_stmt_"+ID).hide();
		$("#project_doneedit_"+ID).hide();
		$("#project_pic_file_"+ID).hide();
		$("#project_pic_"+ID).hide();
		$("#project_file_"+ID).hide();
		$("#project_video_"+ID).hide();
		$("#project_url_video_"+ID).hide();
		$("#project_stmt_p_"+ID).hide();
		$("#doneediting_project_"+ID).hide();
		}
		else { return false; }
} ;		
function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};
function url_domain(data) {
  var a = document.createElement('a');
         a.href = data;

  return a.hostname;
}
function getVedioId(str) {
    return str.split('v=')[1];
}
function replaceAll(find, replace, str) {
	if(str == null)
		str = "";
	return str.replace(new RegExp(find, 'g'), replace);
}
function refineVedioId(str){
	if(str.indexOf('&') === -1){
		return str;
		}
		return str.split('&')[0];
}
function saveedited(ID)  {				
		var title = convertSpecialChar($("#challenge_title_"+ID).val());
		var project = convertSpecialChar($("#challenge_stmt_"+ID).val());
		var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+'&title='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title)))));
		$("#project_"+ID).html('<img src="load.gif" />'); // Loading image
		if(replaceAll('\\s', '',project) == ""){
			bootstrap_alert(".alert_placeholder", "Statement can not be empty", 5000,"alert-warning");
			return false ;
		}
		else if (replaceAll('\\s', '',title) == ""){
			bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			return false ;
		}
		else {
			$.ajax({
				type: "POST",
				url: "ajax/edit_cha_stmt.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(html){
					$("#challenge_"+ID).html(replaceAll('<s>','  ',replaceAll('\n',' <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',project))))));
					$("#challenge_ti_"+ID).html(replaceAll('<s>','  ',replaceAll('\n',' <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',title))))));
				}
			});
		}
	$(".editbox").hide();
	$(".text").show(); 
} ;
function saveeditedproject(ID)  {				
		var title = convertSpecialChar($("#project_title_"+ID).val());
		var project = convertSpecialChar($("#project_stmt_"+ID).val());
		var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+'&title='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title)))));
		if(replaceAll('\\s', '',project) == ""){
			bootstrap_alert(".alert_placeholder", "Statement can not be empty", 5000,"alert-warning");
			return false ;
		}
		else if (replaceAll('\\s', '',title) == ""){
			bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			return false ;
		}
		else {
			$.ajax({
				type: "POST",
				url: "ajax/edit_pro_stmt.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					$("#project_"+ID).html(replaceAll('<s>','  ',replaceAll('\n',' <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',project))))));
					$("#project_ti_"+ID).html(replaceAll('<s>','  ',replaceAll('\n',' <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',title))))));
					$("#projectTitle_"+ID).html(replaceAll('<s>','  ',replaceAll('\n',' <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',title))))));
				}
			});
		}
	$(".editbox").hide();
	$(".text").show(); 
} ;
function saveeditedchallenge(ID)  {				
		var title = convertSpecialChar($("#challenge_title_"+ID).val());
		var project = convertSpecialChar($("#challenge_stmt_p_"+ID).val());
		var challenge = $("#url_video_"+ID).val();
		if (replaceAll('\\s', '',challenge) != "") {
			var domain = url_domain(challenge);
			//alert(domain);
			if (domain == "www.youtube.com"){
				var linkId = refineVedioId(getVedioId(challenge));
				//alert(linkId);
				challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
				challenge = challenge.concat(linkId);
				challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
				var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+'&title='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title))))) + '&video='+ challenge ;
			}
			else {
				var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+'&title='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title)))));
				//bootstrap_alert(".alert_placeholder", "Add You-tube Url Only", 5000,"alert-warning");
				//return false ;
			}
		}
		else {
			var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+'&title='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title)))));
		}
		$("#project_"+ID).html('<img src="load.gif" />'); // Loading image
		if(replaceAll('\\s', '',project) == ""){
			bootstrap_alert(".alert_placeholder", "Statement can not be empty", 5000,"alert-warning");
			return false ;
			}
		else if (replaceAll('\\s', '',title) == ""){
			bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			return false ;
		}
		else {
			$.ajax({
				type: "POST",
				url: "ajax/edit_cha_stmt.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					//alert (result) ;
					$("#challenge_"+ID).html(replaceAll('<s>','  ',replaceAll('\n','  <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',result))))));
					$("#challenge_ti_"+ID).html(replaceAll('<s>','  ',replaceAll('\n','  <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',title))))));
					$("#url_video_"+ID).val('');
				}
			});
		}
	$(".editbox").hide();
	$(".text").show(); 
} ;
function saveeditedpro(ID)  {				
		var title = convertSpecialChar($("#project_title_"+ID).val());
		var project = convertSpecialChar($("#project_stmt_p_"+ID).val());
		var challenge = $("#project_url_video_"+ID).val();
		if (replaceAll('\\s', '',challenge) != "") {
			var domain = url_domain(challenge);
			//alert(domain);
			if (domain == "www.youtube.com"){
				var linkId = refineVedioId(getVedioId(challenge));
				//alert(linkId);
				challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
				challenge = challenge.concat(linkId);
				challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
				var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+'&title='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title))))) + '&video='+ challenge ;
			}
			else {
				var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+'&title='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title)))));
				//bootstrap_alert(".alert_placeholder", "Add You-tube Url Only", 5000,"alert-warning");
				//return false ;
			}
		}
		else {
			var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+'&title='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title)))));
		}
		$("#project_"+ID).html('<img src="load.gif" />'); // Loading image
		if(replaceAll('\\s', '',project) == ""){
			bootstrap_alert(".alert_placeholder", "Statement can not be empty", 5000,"alert-warning");
			return false ;
		}
		else if (replaceAll('\\s', '',title) == ""){
			bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			return false ;
		}
		else {
			$.ajax({
				type: "POST",
				url: "ajax/edit_pro_stmt.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					//alert (result) ;
					$("#project_"+ID).html(replaceAll('<s>','  ',replaceAll('\n',' <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',result))))));
					$("#project_ti_"+ID).html(replaceAll('<s>','  ',replaceAll('\n',' <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',title))))));
					$("#projectTitle_"+ID).html(replaceAll('<s>','  ',replaceAll('\n',' <br/> ',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',title))))));
					$("#project_url_video_"+ID).val('');
				}
			});
		}
	$(".editbox").hide();
	$(".text").show(); 
} ;
function save_pic_file(ID) {
	var _filech = document.getElementById("_fileChallenge_"+ID);
	var dataString = 'id='+ID ;
	if(_filech.files.length === 0){
		bootstrap_alert(".alert_placeholder", "Please upload Something", 5000,"alert-warning");
		return false ;
	}
	else {
		uploadFile(_filech,"challengePic",String(dataString),"ajax/update_chalange.php",ID);
	}
}
function save_pic_file_project(ID) {
	var _filech = document.getElementById("project_fileChallenge_"+ID);
	var dataString = 'id='+ID ;
	if(_filech.files.length === 0){
		bootstrap_alert(".alert_placeholder", "Please upload Something", 5000,"alert-warning");
		return false ;
	}
	else {
		uploadFile(_filech,"projectPic",String(dataString),"ajax/update_project.php",ID);
	}
}
function uploadFile(_file,typeOfPic,data1,url1,ID){
	var _progress = document.getElementById('_progress');
	
	if(_file.files.length === 0){
		if(typeOfPic == "profilepic") {
			bootstrap_alert(".alert_placeholder", "Please upload a pic", 5000,"alert-warning");
		}
		else {
			submitCreateArticle("",data1,url1,ID);
		}
		return false ;
	} 
	else if (_file.files['0'].size > 2015000) {
		bootstrap_alert(".alert_placeholder", "File size is too large", 5000,"alert-warning");
		//setTimeout(function(){ location.reload(); } , 10000) ;
		return false ;
	}
	else {
		var data = new FormData();
		data.append('file', _file.files[0]);

		var request = new XMLHttpRequest();
		var responceTx = "";
		request.onreadystatechange = function(){
			if(request.readyState == 4){
				responceTx = request.response;
				submitCreateArticle(responceTx,data1,url1,ID);
				//alert(responceTx);
				//alert(request.response);
				//return request.response;
				}
			};
		}

		request.upload.addEventListener('progress', function(e){
        _progress.style.width = Math.ceil(e.loaded/e.total) * 100 + '%';
		}, false);
		
		request.open('POST', 'ajax/upload_file.php?typeOfPic='+typeOfPic);
		request.send(data);
		//alert(request.response);
		//alert(responceTx);
		//return responceTx;	
	}
	function submitCreateArticle(ilink,data,url,ID){
		//alert(ilink) ;
		if (ilink != "") {
		var res = ilink.split(".");
		//alert (res['1']);
			if ((res['1'] == "jpg") || (res['1'] == "jpeg") || (res['1'] == "png") || (res['1'] == "gif")){
				var imgTx = "<img src=\""+ilink+"\" style=\"max-width: 100%;\" onError=\"this.src=\"img/default.gif\"\" />";
			}
			else {
				var imgTx = ilink ;
			}
			var dataString = data + '&img='+ imgTx ;
		}
		else {
			var	dataString =  data ;
		}
		if (ilink != "" && imgTx.length < 30) { 
			bootstrap_alert(".alert_placeholder", imgTx, 5000,"alert-warning");
			//setTimeout(function(){ location.reload(); } , 10000) ;
		}
		else {
			$.ajax({
				type: "POST",
				url: url,
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					$("#challenge_"+ID).html(replaceAll('<s>','  ',replaceAll(' <br/> ','\n',replaceAll('<r>',"'",replaceAll('<a>','&',replaceAll('<an>','+',result))))));
					$("#_fileChallenge_"+ID).val('');
				}
			});
			$(".editbox").hide();
			$(".text").show();
		}  
	}
function convertSpecialChar(str){
	return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
}
			// Edit input box click action
			$(".editbox").mouseup(function(){
			return false
			});

			// Outside click action
			//$(document).mouseup(function(){
			//$(".editbox").hide();
			//$(".text").show();
			//});
