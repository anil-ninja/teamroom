function replaceAll(find, replace, str) {
	if(str == null)
		str = "";
	return str.replace(new RegExp(find, 'g'), replace);
}

function url_domain(data) {
  var    a      = document.createElement('a');
         a.href = data;
  return a.hostname;
}

function getVedioId(str) {
    return str.split('v=')[1];
}

function refineVedioId(str){
	if(str.indexOf('&') === -1){
		return str;
	}
	return str.split('&')[0];
}

function getnextchal (clas, int) {
	$('#panel-cont').append("<div class='loading'><center><img src='img/loading.gif' /></center><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>");
	var numItems = $('div.'+clas).length;
	if (numItems < 3) {
		var dataString = 'chal=6' ;
		$.ajax({
			type: "POST",
			url: "ajax/get_next.php",
			async: false ,
			data: dataString,
			cache: false,
			success: function(result){
				var notice = result.split("<") ;
				if (notice['0'] == 'no data') {
					$('.loading').remove();
					var data = document.getElementById("appendloading") ;
					if(data == null) {
						$('#panel-cont').append("<div id='appendloading'><br/><br/><center style='font-size:24px;'> Whooo... You have read all Posts </center></div>");
					}
				}
				else {
					$('#panel-cont').append(result);
					$('.loading').remove();
					showclass(int) ;
					var numItem = $('div.'+clas).length;
					if (numItem < 3) {
						getnextchal(clas, int) ;
					}
				}
			}
		});
	}
}

function showclass(int) {
	switch(int){
		case 1:
			$(".articlesch").show(100);
			$(".openchalhide").show(100);
			$(".idea").show(100);
			$(".film").show(100);
			$(".challenge").show(100);
			$(".pict").show(100);
			break;
			
		case 2:
			$(".articlesch").hide(100);
			$(".openchalhide").hide(100);
			$(".idea").hide(100);
			$(".film").hide(100);
			$(".challenge").show(100);
			$(".pict").hide(100);
			break;
			
		case 3:
			$(".challenge").hide(100);
			$(".openchalhide").hide(100);
			$(".idea").hide(100);
			$(".film").hide(100);
			$(".articlesch").show(100);
			$(".pict").hide(100);
			break;
			
		case 4:
			$(".challenge").hide(100);
			$(".openchalhide").show(100);
			$(".idea").hide(100);
			$(".film").hide(100);
			$(".articlesch").hide(100);
			$(".pict").hide(100);
			break;
			
		case 5:
			$(".challenge").hide(100);
			$(".openchalhide").hide(100);
			$(".idea").hide(100);
			$(".film").show(100);
			$(".articlesch").hide(100);
			$(".pict").hide(100);
			break;
			
		case 6:
			$(".challenge").hide(100);
			$(".openchalhide").hide(100);
			$(".film").hide(100);
			$(".articlesch").hide(100);
			$(".idea").show(100);
			$(".pict").hide(100);
			break;
			
		case 7:
			$(".challenge").hide(100);
			$(".openchalhide").hide(100);
			$(".film").hide(100);
			$(".articlesch").hide(100);
			$(".idea").hide(100);
			$(".pict").show(100);
			break;
	}
}

function bootstrap_alert(elem, message, timeout,type) {
	$(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
	if (timeout || timeout === 0) {
		setTimeout(function() { 
			$(elem).show().html('');
		}, timeout);    
	}
};
		
function create_video(){
	$("#create_video").attr('disabled','disabled');
	var challenge = $("#videosub").val() ;
	var video_title = convertSpecialChar($("#video_title").val()) ;
	var videodes = convertSpecialChar($("#videodes").val()) ;
	var domain = url_domain(challenge);
	//alert(domain);
	if (domain == "www.youtube.com"){
		var linkId = refineVedioId(getVedioId(challenge));
		//alert(linkId);
		challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
		challenge = challenge.concat(linkId);
		challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
		if (replaceAll('\\s', '',challenge) == "") {
			bootstrap_alert(".alert_placeholder", "Please Enter url", 5000,"alert-warning");
			$("#create_video").removeAttr('disabled');
			return false ;
		}
		else if (replaceAll('\\s', '',video_title) == "") {
			bootstrap_alert(".alert_placeholder", "Please Enter Title", 5000,"alert-warning");
			$("#create_video").removeAttr('disabled');
			return false ;
		}
		else if (replaceAll('\\s', '',videodes) == "") {
			bootstrap_alert(".alert_placeholder", "Please Enter Description", 5000,"alert-warning");
			$("#create_video").removeAttr('disabled');
			return false ;
		}
		else {
			var dataString = 'video='+ challenge + '&title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',video_title)))))
			 + '&videodes='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',videodes))))) ;
			$.ajax({
				type: "POST",
				url: "ajax/add_video.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("|+") ;
					if(notice['0'] = "Video Posted Successfully !!!") {
						bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-success");
						$("#video_title").val("") ;
						$("#videosub").val("") ;
						$("#videodes").val("") ;
						$(".newPosts").prepend(notice['1']) ;
						$("#create_video").removeAttr('disabled');
						$(".editbox").hide() ;
						$("#remindervalue").hide() ;
						$("#textForm").show();
					}
					else{
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
						$("#create_video").removeAttr('disabled');
					}
				}
			});
		}
	}
	else {
		bootstrap_alert(".alert_placeholder", "Add You-Tube URL Only", 5000,"alert-warning") ;
		$("#create_video").removeAttr('disabled');
		return false ;
	}
}

function create_videopr(ID){
	$("#create_videopr").attr('disabled','disabled');
	var challenge = $("#videoprjt").val() ;
	var video_title = convertSpecialChar($("#video_titlepr").val()) ;
	var videodes = convertSpecialChar($("#videodespr").val()) ;
	var domain = url_domain(challenge);
	//alert(domain);
	if (domain == "www.youtube.com"){
		var linkId = refineVedioId(getVedioId(challenge));
		//alert(linkId);
		challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
		challenge = challenge.concat(linkId);
		challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
		if (replaceAll('\\s', '',challenge) == "") {
			bootstrap_alert(".alert_placeholder", "Please Enter url", 5000,"alert-warning");
			$("#create_videopr").removeAttr('disabled');
			return false ;
		}
		else if (replaceAll('\\s', '',video_title) == "") {
			bootstrap_alert(".alert_placeholder", "Please Enter Title", 5000,"alert-warning");
			$("#create_videopr").removeAttr('disabled');
			return false ;
		}
		else if (replaceAll('\\s', '',videodes) == "") {
			bootstrap_alert(".alert_placeholder", "Please Enter Description", 5000,"alert-warning");
			$("#create_videopr").removeAttr('disabled');
			return false ;
		}
		else {
			var dataString = 'videos='+ challenge + '&title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',video_title)))))
			 + '&videodes='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',videodes))))) + '&project_id=' + ID ;
			$.ajax({
				type: "POST",
				url: "ajax/add_video_pr.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("|+") ;
					if(notice['0'] = "Video Posted Successfully !!!") {
						bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-success");
						$("#video_titlepr").val("") ;
						$("#videoprjt").val("") ;
						$("#videodespr").val("") ;
						$(".newPosts").prepend(notice['1']) ;
						$("#create_videopr").removeAttr('disabled');
						$(".editbox").hide() ;
						$("#invitation").hide() ;
						$("#selecttext").show();
					}
					else{
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
						$("#create_videopr").removeAttr('disabled');
					}
				}
			});
		}
	}
	else {
		bootstrap_alert(".alert_placeholder", "Add You-Tube URL Only", 5000,"alert-warning");
		$("#create_videopr").removeAttr('disabled');
		return false ;
	}		
}

function convertSpecialChar(str){
	return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
}

function submit_ch(){
	$("#submit_ch").attr('disabled','disabled');
	var challenge = convertSpecialChar($("#challange").val()) ;
	var ID = $("#ProjectIDValue").val() ;
	var domain = url_domain(challenge);
	if (domain == "www.youtube.com"){
		var linkId = refineVedioId(getVedioId(challenge));
		//alert(linkId);
		challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
		challenge = challenge.concat(linkId);
		challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
	}
	var challenge_title = convertSpecialChar($("#challange_title").val()) ;			
	var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',challenge))))) + 
	'&challenge_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',challenge_title)))))  + '&project_id=' + ID ;
	if(replaceAll('\\s', '',challenge)==''){
		bootstrap_alert(".alert_placeholder", "Challenge can not be empty", 5000,"alert-warning");
		$("#submit_ch").removeAttr('disabled');
	}
	else if(replaceAll('\\s', '',challenge_title)==''){
		bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
		$("#submit_ch").removeAttr('disabled');
	}
	else {
			//file upload
		var _filech = document.getElementById('_fileChallenge');
		uploadFile1(_filech,"challengePic",String(dataString),"ajax/submit_chalange.php");
		console.log(submit_ch());
	}
}
    
function uploadFile1(_file,typeOfPic,data1,url1){
	var _progress = document.getElementById('_progress');	
	if(_file.files.length === 0){
		if(typeOfPic == "profilepic") {
			bootstrap_alert(".alert_placeholder", "Please upload a pic", 5000,"alert-warning");
		}
		else{
			submitCreateArticle1("",data1,url1);
		}
		return false ;
	}
	else if (_file.files['0'].size > 2015000) {
		bootstrap_alert(".alert_placeholder", "File size is too large", 5000,"alert-warning");
		$("#create_issue").removeAttr('disabled');
		$("#create_idea").removeAttr('disabled');
		$("#create_picture").removeAttr('disabled');
		$("#create_article").removeAttr('disabled');
		$("#submit_ch").removeAttr('disabled');
		$("#create_challange_pb_pr").removeAttr('disabled');
		$("#create_notes").removeAttr('disabled');
		$("#create_task").removeAttr('disabled');
		$("#create_project").removeAttr('disabled');
		$("#answerch").removeAttr('disabled');
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
				submitCreateArticle1(responceTx,data1,url1);
			}
		};
	}
	request.upload.addEventListener('progress', function(e){
		_progress.style.width = Math.ceil(e.loaded/e.total) * 100 + '%';
	}, false);	
	request.open('POST', 'ajax/upload_file.php?typeOfPic='+typeOfPic);
	request.send(data);
}

function submitCreateArticle1(ilink,data,url){
	if (ilink != "") {
		var res = ilink.split(".");
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
		$("#create_issue").removeAttr('disabled');
		$("#create_idea").removeAttr('disabled');
		$("#create_picture").removeAttr('disabled');
		$("#create_article").removeAttr('disabled');
		$("#submit_ch").removeAttr('disabled');
		$("#create_challange_pb_pr").removeAttr('disabled');
		$("#create_notes").removeAttr('disabled');
		$("#create_task").removeAttr('disabled');
		$("#create_project").removeAttr('disabled');
		$("#answerch").removeAttr('disabled');
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
				var notice = result.split("|+") ;
				if(notice['0'] == "Posted succesfully!") {
					bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-success");
					switch (parseInt(notice['1'])) {
						case 1:
							$("#ideaA").val("") ;
							$("#idea_titleA").val("") ;
							$("#_fileIdea").val("") ;
							$("#create_idea").removeAttr('disabled');
							$("#remindervalue").hide() ;
							$("#textForm").show();
							break;
							
						case 2:
							$("#picturech").val("") ;
							$("#picture_title").val("") ;
							$("#_filePhotos").val("") ;
							$("#create_picture").removeAttr('disabled');
							$("#remindervalue").hide() ;
							$("#textForm").show();
							break;
							
						case 3:
							$("#articlech").val("") ;
							$("#article_title").val("") ;
							$("#_fileArticle").val("") ;
							$("#create_article").removeAttr('disabled');
							$("#remindervalue").hide() ;
							$("#textForm").show();
							break;
							
						case 4:
							$("#challange").val("") ;
							$("#challange_title").val("") ;
							$("#_fileChallenge").val("") ;
							$("#submit_ch").removeAttr('disabled');
							$("#remindervalue").hide() ;
							$("#textForm").show();
							break;
						
						case 5:
							$("#challangepr").val("") ;
							$("#challange_title").val("") ;
							$("#_fileChallengepr").val("") ;
							$("#create_challange_pb_pr").removeAttr('disabled');
							$("#invitation").hide() ;
							$("#selecttext").show();
							break;
							
						case 6:
							$("#notestmt").val("") ;
							$("#notes_title").val("") ;
							$("#_fileNotes").val("") ;
							$("#create_notes").removeAttr('disabled');
							$("#invitation").hide() ;
							$("#selecttext").show();
							break;
							
						case 7:
							$("#emailtask").val("") ;
							$("#titletask").val("") ;
							$("#taskdetails").val("") ;
							$("#_fileTask").val("") ;
							$("#create_task").removeAttr('disabled');
							$("#invitation").hide() ;
							$("#selecttext").show();
							break;
						
						case 8:
							location.reload();
							break;
							
						case 9:
							$("#issue_title").val("") ;
							$("#issuestmt").val("") ;
							$("#_fileIssue").val("") ;
							$("#create_issue").removeAttr('disabled');
							$("#invitation").hide() ;
							$("#selecttext").show();
							break;
					}
					$(".newPosts").prepend(notice['2']) ;
					$(".editbox").hide() ;
				}
				else if(notice['0'] == "Answer Submitted succesfully!"){
					bootstrap_alert(".alert_placeholder", notice['0'], 55000,"alert-success");
					location.reload();
				}
				else if(notice['0'] == "Project created succesfully!"){
					bootstrap_alert(".alert_placeholder", notice['0'], 55000,"alert-success");
					location.reload();
				}
				else {
					bootstrap_alert(".alert_placeholder", notice['0'], 55000,"alert-warning");
					location.reload();
				}
			}
		});
		return false;
	} 
}

function create_article(){
	$("#create_article").attr('disabled','disabled');
	var article = convertSpecialChar($("#articlech").val()) ;
	var article_title = convertSpecialChar($("#article_title").val()) ;
	if(replaceAll('\\s', '',article)==''){
		bootstrap_alert(".alert_placeholder", "Article can not be empty", 5000,"alert-warning");
		$("#create_article").removeAttr('disabled');
		return false;
	}
	else if(replaceAll('\\s', '',article_title)==''){
		bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
		$("#create_article").removeAttr('disabled');
		return false;
	} 
	else {
		var dataString = 'article='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',article))))) + 
		'&article_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',article_title)))))  ;
		var _file = document.getElementById('_fileArticle');
		uploadFile1(_file,"articlePic",String(dataString),"ajax/submit_article.php");
	}
}

function projectinfo() {
	var type = $("#type").val();
	if (type == '2') {
		bootstrap_alert(".alert_placeholder", "Classified Project will not be searchable by Investers", 10000,"alert-warning");
		$(".aboutfunding").hide();
	}
	else {
		$(".aboutfunding").show();
	}
}	
	
$(document).ready(function() {
	$("#create_project").click(function(){
		$("#create_project").attr('disabled','disabled');
		var project_title = convertSpecialChar($("#project_title").val()) ;
		var project_stmt = convertSpecialChar($("#project_stmt").val());
		var value = convertSpecialChar($("#project_value").val());
		var fund = convertSpecialChar($("#project_fundneed").val());
		var type = $("#type").val();
		var typeA = document.getElementById("fundProject").checked;
		if(replaceAll('\\s', '',project_title)==''){
			bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			$("#create_project").removeAttr('disabled');
		}
		else if(replaceAll('\\s', '',project_stmt)==''){
			bootstrap_alert(".alert_placeholder", "Project can not be empty", 5000,"alert-warning");
			$("#create_project").removeAttr('disabled');
		}
		else if (type == '0') {
			bootstrap_alert(".alert_placeholder", "Please select Project type", 5000,"alert-warning");
			$("#create_project").removeAttr('disabled');
		}
		else if(typeA != false){
			if(replaceAll('\\s', '',value) == "") {
				bootstrap_alert(".alert_placeholder", "Value can not be empty", 5000,"alert-warning");
				$("#create_project").removeAttr('disabled');
			}
			else if(replaceAll('\\s', '',fund) == "") {
				bootstrap_alert(".alert_placeholder", "Fund can not be empty", 5000,"alert-warning");
				$("#create_project").removeAttr('disabled');
			}
			else {
				$("#project_title").val("");
				var dataString = 'project_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project_title))))) + '&project_stmt='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project_stmt))))) + 
				'&type='+ type + '&value='+ value + '&fund='+ fund ;
				var _file = document.getElementById('_fileProject');
				//alert(uploadFile(_file,"articlePic"));
				uploadFile1(_file,"projectPic",String(dataString),"ajax/submit_project.php");
			}
		}
		else {
			$("#project_title").val("");
			var dataString = 'project_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project_title))))) + '&project_stmt='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project_stmt))))) + 
				'&type='+ type + '&value='+ value + '&fund='+ fund ;
			var _file = document.getElementById('_fileProject');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile1(_file,"projectPic",String(dataString),"ajax/submit_project.php");
		}
	});
	
	$('.tree-toggle').click(function () {
		$(this).parent().children('ul.tree').toggle(200);
	});	
});

function IsNumeric(e) {
	var specialKeys = new Array();
	specialKeys.push(8); //Backspace
    var keyCode = e.which ? e.which : e.keyCode
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}
		
$(document).ready(function() {
	$("#allPanels").click(function(){
		$(".articlesch").show(100);
		$(".openchalhide").show(100);
		$(".idea").show(100);
		$(".film").show(100);
		$(".challenge").show(100);
		$(".pict").show(100);
	});

	$("#pencil").click(function(){
		$(".articlesch").hide(100);
		$(".openchalhide").hide(100);
		$(".idea").hide(100);
		$(".film").hide(100);
		$(".challenge").show(100);
		$(".pict").hide(100);
		$("#viewchid").val(2);
		getnextchal('challenge',2) ;
	});

	$("#globe").click(function(){
		$(".challenge").hide(100);
		$(".openchalhide").hide(100);
		$(".idea").hide(100);
		$(".film").hide(100);
		$(".articlesch").show(100);
		$(".pict").hide(100);
		$("#viewchid").val(3);
		getnextchal('articlesch', 3) ;
	});

	$("#okch").click(function(){
		$(".challenge").hide(100);
		$(".openchalhide").show(100);
		$(".idea").hide(100);
		$(".film").hide(100);
		$(".articlesch").hide(100);
		$(".pict").hide(100);
		$("#viewchid").val(4);
	getnextchal('openchalhide', 4) ;
	});
  
	$("#filmnin").click(function(){
		$(".challenge").hide(100);
		$(".openchalhide").hide(100);
		$(".idea").hide(100);
		$(".film").show(100);
		$(".articlesch").hide(100);
		$(".pict").hide(100);
		$("#viewchid").val(5) ;
		getnextchal('film', 5) ;
	});

	$("#tree").click(function(){
		$(".challenge").hide(100);
		$(".openchalhide").hide(100);
		$(".film").hide(100);
		$(".articlesch").hide(100);
		$(".idea").show(100);
		$(".pict").hide(100);
		$("#viewchid").val(6) ;
		getnextchal('idea', 6) ;
	});
  
	$("#picch").click(function(){
		$(".challenge").hide(100);
		$(".openchalhide").hide(100);
		$(".film").hide(100);
		$(".articlesch").hide(100);
		$(".idea").hide(100);
		$(".pict").show(100);
		$("#viewchid").val(7);
		getnextchal('pict', 7) ;
	});
});
	
function create_idea(){
	$("#create_idea").attr('disabled','disabled');
	var idea = convertSpecialChar($("#ideaA").val()) ;
	var idea_title = convertSpecialChar($("#idea_titleA").val()) ;		
	// Returns successful data submission message when the entered information is stored in database.
	var dataString = 'idea='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',idea))))) + '&idea_title='+ 
	replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',idea_title)))))  ;
	//alert(dataString);
	if(replaceAll('\\s', '',idea) == ''){
		bootstrap_alert(".alert_placeholder", "Idea can not be empty", 5000,"alert-warning");
		$("#create_idea").removeAttr('disabled');
	}
	else if(replaceAll('\\s', '',idea_title)==''){
		bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
		$("#create_idea").removeAttr('disabled');
	}
	else { 
		//file upload
		var _file = document.getElementById('_fileIdea');
		uploadFile1(_file,"ideaPic",String(dataString),"ajax/submit_idea.php");
	}
}
	
function create_picture(){
	$("#create_picture").attr('disabled','disabled');
	var picturech = convertSpecialChar($("#picturech").val()) ;
	var picture_title = convertSpecialChar($("#picture_title").val()) ;			
	// Returns successful data submission message when the entered information is stored in database.
	var dataString = 'picturech='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',picturech))))) 
	+ '&picture_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',picture_title)))))  ;
	//alert(dataString);
	if(replaceAll('\\s', '',picturech) == ''){
		bootstrap_alert(".alert_placeholder", "Details can not be empty", 5000,"alert-warning");
		$("#create_picture").removeAttr('disabled');
	}
	else if(replaceAll('\\s', '',picture_title)==''){
		bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
		$("#create_picture").removeAttr('disabled');
	}
	else {
		//file upload
		var _file = document.getElementById('_filePhotos');
		if(_file.files.length === 0){
			bootstrap_alert(".alert_placeholder", "Please upload a Photo", 5000,"alert-warning");
			$("#create_picture").removeAttr('disabled');
		}
		else {
			uploadFile1(_file,"photoPic",String(dataString),"ajax/submit_photo.php");
		}
	}
}
    
function create_task(){
	$("#create_task").attr('disabled','disabled');
	var team = $("#teamtask").val() ;
	var users = $("#userstask").val() ;
	var email = $("#emailtask").val() ;
	var ID = $("#ProjectIDValue").val() ;
	if((team == '0' && users =='0' && replaceAll('\\s', '',email) =="")||(team != '0' && users !='0' && replaceAll('\\s', '',email) !="")||(team != '0' && users !='0' && replaceAll('\\s', '',email) =="")
		||(team != '0' && users =='0' && replaceAll('\\s', '',email) !="")||(team == '0' && users !='0' && replaceAll('\\s', '',email) !="")) {
		bootstrap_alert(".alert_placeholder", "Please select one value", 5000,"alert-warning");
		$("#create_task").removeAttr('disabled');
		return false ;
	}
	if (replaceAll('\\s', '',email) != "") {
		$.ajax({
			type: "POST",
			url: "ajax/email.php",
			async: false ,
			data: 'email='+ email,
			cache: false,
			success: function(result){
			//alert(result);
				if (result == 'true') {
					var title = convertSpecialChar($("#titletask").val()) ;
					var taskdetails = convertSpecialChar($("#taskdetails").val()) ;
					var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',taskdetails)))))
									 + '&email='+ email + '&title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title))))) 
									 + '&team='+ team + '&users='+ users + '&project_id=' + ID ;//+ '&challange_eta='+ (challange_eta+='') ;
					if(replaceAll('\\s', '',title)==''){
						bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
						$("#create_task").removeAttr('disabled');
						return false ;
					}
					else if(replaceAll('\\s', '',taskdetails)==''){
						bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
						$("#create_task").removeAttr('disabled');
						return false ;
					}
					else {
						//file upload
						var _file = document.getElementById('_fileTask');
						uploadFile1(_file,"taskPic",String(dataString),"ajax/submit_task.php");
					}				
				}
				else if (result == 'same') {
					bootstrap_alert(".alert_placeholder","Please enter Friends email-id Not Yours !!!" , 5000,"alert-warning");
					$("#create_task").removeAttr('disabled');
					return false ;
				}
				else {
					var modal = "<h4>Hi, It looks like s/he is not here Lets intivite her/him</h4>" + "<table><tbody>" +
							"<tr><td><div class\='input-group'><span class\='input-group-addon'>His/Her First Name</span></td>" +
							"<td><input type='text' class='input-block-level' id='fnameteam' placeholder='His First Name'></div></td></tr> " +
							"<tr><td><div class\='input-group'><span class\='input-group-addon'>His/Her Second Name</span></td>" +
							"<td><input type='text' class='input-block-level' id='snameteam' placeholder='His Second Name'></div></td></tr> " + 
							"<tr><td><div class\='input-group'><span class\='input-group-addon'>His/Her Email ID</span></td>" +
							"<td><input type='text' class='input-block-level' id='teamemail' value=\'" + email + "\' /></div></td></tr></tbody></table>" +
							"<input type='submit' class\='btn btn-success' id='invitememb' onclick ='invitememb("+ ID +")' value='Invite Him/Her' /> <br/> ";
					$("#invitation").show().html(modal);
					return false ;
				}
			}
		});
	}
	else {
		var title = convertSpecialChar($("#titletask").val()) ;
		var taskdetails = convertSpecialChar($("#taskdetails").val()) ;
		var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>   ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',taskdetails)))))
						 + '&title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title))))) + '&team='+ team 
						 + '&users='+ users + '&project_id=' + ID ;
		if(replaceAll('\\s', '',title)==''){
			bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			$("#create_task").removeAttr('disabled');
			return false ;
		}
		else if(replaceAll('\\s', '',taskdetails)==''){
			bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
			$("#create_task").removeAttr('disabled');
			return false ;
		}
		else {
			//file upload
			var _file = document.getElementById('_fileTask');
			uploadFile1(_file,"taskPic",String(dataString),"ajax/submit_task.php");
		}
	}			
}
