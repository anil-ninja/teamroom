function replaceAll(find, replace, str) {
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
	var dataString = 'chal=10' ;
		$.ajax({
				type: "POST",
				url: "ajax/get_next.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					$('#panel-cont').append(result);
					$('.loading').remove();
					showclass(int) ;
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
			if (challenge == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter url", 5000,"alert-warning");
				return false ;
			}
			else if (video_title == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Title", 5000,"alert-warning");
				return false ;
			}
			else if (videodes == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Description", 5000,"alert-warning");
				return false ;
			}
			else {
				var dataString = 'video='+ challenge + '&title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',video_title))))
				 + '&videodes='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',videodes)))) ;
			$.ajax({
				type: "POST",
				url: "ajax/add_video.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result = "Video Posted Successfully !!!") {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
						location.reload() ;
						$("#video_title").val("") ;
						$("#video").val("") ;
						}
						else{
							bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
							}
					}
				  });
				}
			}
			else {
				bootstrap_alert(".alert_placeholder", "Add You-Tube URL Only", 5000,"alert-warning") ;
				return false ;
				}
		}

		function create_videopr(){
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
			if (challenge == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter url", 5000,"alert-warning");
				return false ;
			}
			else if (video_title == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Title", 5000,"alert-warning");
				return false ;
			}
			else if (videodes == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Description", 5000,"alert-warning");
				return false ;
			}
			else {
				var dataString = 'videos='+ challenge + '&title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',video_title))))
				 + '&videodes='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',videodes)))) ;
			$.ajax({
				type: "POST",
				url: "ajax/add_video_pr.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result = "Video Posted Successfully !!!") {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
						location.reload() ;
						$("#video_title").val("") ;
						$("#video").val("") ;
						}
						else{
							bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
							}
					}
				  });
				}
			}
			else {
				bootstrap_alert(".alert_placeholder", "Add You-Tube URL Only", 5000,"alert-warning");
				return false ;
				}		
		}
	function convertSpecialChar(str){
		return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
	}
		function submit_ch(){
			
			var challenge = convertSpecialChar($("#challange").val()) ;
			var domain = url_domain(challenge);
			if (domain == "www.youtube.com"){
				var linkId = refineVedioId(getVedioId(challenge));
				//alert(linkId);
				challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
				challenge = challenge.concat(linkId);
				challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
			}
			var challenge_title = convertSpecialChar($("#challange_title").val()) ;			
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',challenge)))) + 
			'&challenge_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',challenge_title)))) ;
			if(challenge==''){
				bootstrap_alert(".alert_placeholder", "Challenge can not be empty", 5000,"alert-warning");
			}
			else if(challenge_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else {
					//file upload
				var _filech = document.getElementById('_fileChallenge');
				uploadFile1(_filech,"challengePic",String(dataString),"ajax/submit_chalange.php");
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
		} else {

		var data = new FormData();
		data.append('file', _file.files[0]);

		var request = new XMLHttpRequest();
		var responceTx = "";
		request.onreadystatechange = function(){
			if(request.readyState == 4){
				responceTx = request.response;
				submitCreateArticle1(responceTx,data1,url1);
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
	function submitCreateArticle1(ilink,data,url){
		if (ilink != "") {
			var res = ilink.split(".");
			if ((res['1'] == "jpg") || (res['1'] == "jpeg") || (res['1'] == "png") || (res['1'] == "gif")){
				var imgTx = "<img src=\""+ilink+"\" style=\"max-width: 100%;\" onError=\"this.src=\"img/default.gif\"\" />";
			}
			else {
				var imgTx = ilink ;
			}
			if (imgTx.length < 30) { bootstrap_alert(".alert_placeholder", imgTx, 5000,"alert-warning"); }
			var dataString = data + '&img='+ imgTx ;
		}
		else {
			var	dataString =  data ;
		}
		$.ajax({
			type: "POST",
			url: url,
			async: false ,
			data: dataString,
			cache: false,
			success: function(result){
				if(result=='Posted succesfully!'){
					bootstrap_alert(".alert_placeholder", result, 55000,"alert-success");
					location.reload();
				}
				else {
					bootstrap_alert(".alert_placeholder", result, 55000,"alert-warning");
					location.reload();
				}
			}
		});
		return false; 
	}
		function create_article(){
			var article = convertSpecialChar($("#articlech").val()) ;
			var article_title = convertSpecialChar($("#article_title").val()) ;
			if(article==''){
				bootstrap_alert(".alert_placeholder", "Article can not be empty", 5000,"alert-warning");
				return false;
			}
			else if(article_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
				return false;
			} else {
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'article='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',article)))) + 
			'&article_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',article_title))))  ;
			//alert(dataString);
			
			//file upload
			var _file = document.getElementById('_fileArticle');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile1(_file,"articlePic",String(dataString),"ajax/submit_article.php");
		
			}
		}
			
		$("#create_project").click(function(){
			$("#create_project").attr('disabled','disabled');
			var project_title = convertSpecialChar($("#project_title").val()) ;
			var project_stmt = convertSpecialChar($("#project_stmt").val());
			var type = $("#type").val();
			//var eta = parseInt($("#eta").val());
			//var etab = parseInt($("#etab").val());
			//var etac = parseInt($("#etac").val());
			//var etad = parseInt($("#etad").val());
			//var project_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'project_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',project_title)))) + '&project_stmt='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',project_stmt)))) + 
			'&type='+ type ;//+ '&project_eta='+ (project_eta+='')  ;
			//alert(dataString);
			if(project_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
				$("#create_project").removeAttr('disabled');
			}
			else if(project_stmt==''){
				bootstrap_alert(".alert_placeholder", "Project can not be empty", 5000,"alert-warning");
				$("#create_project").removeAttr('disabled');
			}
			else {
				//file upload
			var _file = document.getElementById('_fileProject');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile1(_file,"projectPic",String(dataString),"ajax/submit_project.php");
			}
		});
		
		$('.tree-toggle').click(function () {
		$(this).parent().children('ul.tree').toggle(200);
		});	
		//allPanels
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
	
		function create_idea(){
			var idea = convertSpecialChar($("#ideaA").val()) ;
			var idea_title = convertSpecialChar($("#idea_titleA").val()) ;		
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'idea='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',idea)))) + '&idea_title='+ 
			replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',idea_title))))  ;
			//alert(dataString);
			if(idea == ''){
				bootstrap_alert(".alert_placeholder", "Idea can not be empty", 5000,"alert-warning");
			}
			else if(idea_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else { 
				//file upload
			var _file = document.getElementById('_fileIdea');
			uploadFile1(_file,"ideaPic",String(dataString),"ajax/submit_idea.php");
			}
		}
	
		function create_picture(){
			var picturech = convertSpecialChar($("#picturech").val()) ;
			var picture_title = convertSpecialChar($("#picture_title").val()) ;			
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'picturech='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',picturech)))) 
			+ '&picture_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',picture_title))))  ;
			//alert(dataString);
			if(picturech == ''){
				bootstrap_alert(".alert_placeholder", "Details can not be empty", 5000,"alert-warning");
			}
			else if(picture_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else {
				//file upload
				var _file = document.getElementById('_filePhotos');
				if(_file.files.length === 0){
					bootstrap_alert(".alert_placeholder", "Please upload a Photo", 5000,"alert-warning");
					}
					else {
						uploadFile1(_file,"photoPic",String(dataString),"ajax/submit_photo.php");
						}
			}
		}
    
		function create_task(){
			var team = $("#teamtask").val() ;
			var users = $("#userstask").val() ;
			var email = $("#emailtask").val() ;
			if((team == '0' && users =='0' && email =="")||(team != '0' && users !='0' && email !="")||(team != '0' && users !='0' && email =="")
			||(team != '0' && users =='0' && email !="")||(team == '0' && users !='0' && email !="")) {
				bootstrap_alert(".alert_placeholder", "Please select one value", 5000,"alert-warning");
				return false ;
			}
			if (email != "") {
			$.ajax({
				type: "POST",
				url: "ajax/email.php",
				data: 'email='+ email,
				cache: false,
				success: function(result){
					//alert(result);
					if (result == 'true') {
							var title = convertSpecialChar($("#titletask").val()) ;
							var taskdetails = convertSpecialChar($("#taskdetails").val()) ;
							//var eta = parseInt($("#c_eta").val());
							//var etab = parseInt($("#c_etab").val());
							//var etac = parseInt($("#c_etac").val());
							//var etad = parseInt($("#c_etad").val());
							//var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
							// Returns successful data submission message when the entered information is stored in database.
							var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',taskdetails))))
							 + '&email='+ email + '&title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',title)))) + '&team='+ team + '&users='+ users ;//+ '&challange_eta='+ (challange_eta+='') ;
							//alert(dataString);
							if(title==''){
								bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
								return false ;
							}
							else if(taskdetails==''){
								bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
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
								return false ;
						}
						else {
							var modal = "<h4>Hi, It looks like s/he is not here Lets intivite her/him</h4><div class\='input-group'><span class\='input-group-addon'>His/Her First Name</span><input type='text' class\='form-control' id='fnameteam' placeholder='His First Name'></div> <br/> <div class\='input-group'><span class\='input-group-addon'>His/Her Second Name</span><input type='text' class\='form-control' id='snameteam' placeholder='His Second Name'></div> <br/> <div class\='input-group'><span class\='input-group-addon'>His/Her Email ID</span><input type='text' class\='form-control' id='teamemail' placeholder='Enter Email-ID' /></div><br><br><input type='submit' class\='btn btn-success' id='invite'  value='Invite Him/Her' /> <br/> ";
							//bootstrap_alert(".alert_placeholder", modal, 600000,"alert-info");
							$("#invitation").show().html(modal);
							return false ;
							}
						}
				  });
				}
			else {
				var title = convertSpecialChar($("#titletask").val()) ;
				var taskdetails = convertSpecialChar($("#taskdetails").val()) ;
				//var eta = parseInt($("#c_eta").val());
				//var etab = parseInt($("#c_etab").val());
				//var etac = parseInt($("#c_etac").val());
				//var etad = parseInt($("#c_etad").val());
				//var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
				// Returns successful data submission message when the entered information is stored in database.
				var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>   ',replaceAll("'",'<r>',replaceAll('&','<a>',taskdetails))))
				 + '&title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',title)))) + '&team='+ team + '&users='+ users ;//+ '&challange_eta='+ (challange_eta+='') ;
				//alert(dataString);
				if(title==''){
					bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
								return false ;
				}
				else if(taskdetails==''){
					bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
								return false ;
				}
				else {
					//file upload
					var _file = document.getElementById('_fileTask');
					uploadFile1(_file,"taskPic",String(dataString),"ajax/submit_task.php");
				}
			}			
		}
		
		function create_team(){
			var team = $("#team_name_A").val() ;
			var email = $("#email_team").val() ;
			if(team =="") {
				bootstrap_alert(".alert_placeholder", "Please Enter Team Name", 5000,"alert-warning");
								return false ;
			}
			else if (email == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Email_id", 5000,"alert-warning");
				return false ;
			}
			else {
			$.ajax({
				type: "POST",
				url: "ajax/email.php",
				data: 'email='+ email,
				cache: false,
				success: function(result){
					//alert(result);
					if (result == 'true') {
							var dataString = 'team='+ team + '&email='+ email ;
							$.ajax({
								type: "POST",
								url: "ajax/create_team.php",
								data: dataString,
								cache: false,
								success: function(result){
								if(result = "Team Created Successfully !!!") {
									bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
									location.reload() ;
									$("#team_name_A").val("") ;
									$("#email_team").val("") ;
									}
									else{
										bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
										}
								}				
							}) ;
						}
						else if (result == 'same') {
							bootstrap_alert(".alert_placeholder","Please enter Friends email-id Not Yours !!!" , 5000,"alert-warning");
							return false ;
						}
						else {
							var modal = "<h4>Hi, It looks like s/he is not here Lets intivite her/him</h4>" +
										"<div class\='input-group'><span class\='input-group-addon'>His/Her First Name</span>" +
										"<input type='text' class\='form-control' id='fnameteam' placeholder='His First Name'></div> <br/> " +
										"<div class\='input-group'><span class\='input-group-addon'>His/Her Second Name</span>" +
										"<input type='text' class\='form-control' id='snameteam' placeholder='His Second Name'></div> <br/> " + 
										"<div class\='input-group'><span class\='input-group-addon'>His/Her Email ID</span>" +
										"<input type='text' class\='form-control' id='teamemail' placeholder='Enter Email-ID' /></div><br><br>" +
										"<input type='submit' class\='btn btn-success' onclick ='invitememberpr()' value='Invite Him/Her' /> <br/> ";
							//bootstrap_alert(".alert_placeholder", modal, 600000,"alert-info");
							$("#invitation").show().html(modal);
							return false ;
							}
						}
				  });
				}	
		}	
	function invitememberpr(){
			var fname = $("#fnameteam").val() ;
			var sname = $("#snameteam").val() ;
			var email = $("#teamemail").val() ;
			if(fname =="") {
				bootstrap_alert(".alert_placeholder", "Please Enter First Name", 5000,"alert-warning");
				return false ;
			}
			else if (sname == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Second Name", 5000,"alert-warning");
				return false ;
			}
			else if (email == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Email-ID", 5000,"alert-warning");
				return false ;
			}
			else {
			$.ajax({
				type: "POST",
				url: "ajax/email.php",
				data: 'email='+ email,
				cache: false,
				success: function(result){
					if (result == 'false') {
							var dataString = 'fname='+ fname + '&sname='+ sname + '&email='+ email ;
							$.ajax({
								type: "POST",
								url: "ajax/send_invitation.php",
								data: dataString,
								cache: false,
								success: function(result){
									bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
								if(result = "Invitation Send Successfully !!!") {
									location.reload() ;
									$("#fnameteam").val("") ;
									$("#snameteam").val("") ;
									$("#teamemail").val("") ;
									}
								}				
							});
						}
						else {
							bootstrap_alert(".alert_placeholder", "Please Enter Valid Email-ID", 5000,"alert-warning");
							return false ;							
							}
					}
				});
			}
		}
	
