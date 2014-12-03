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
function getnextchal (clas, int) {
	$('#panel-cont').append("<div class='loading'><center><img src='img/loading.gif' /></center><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>");
	var numItems = $('div.'+clas).length;
	if (numItems < 3 || clas == 'all') {
	var dataString = 'chal=10' ;
			  $.ajax({
				type: "POST",
				url: "ajax/get_next.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					$('#panel-cont').append(result);
					showclass(int);
					$('.loading').remove();
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
			break;
			
		case 2:
			$(".articlesch").hide(100);
			$(".openchalhide").hide(100);
			$(".idea").hide(100);
			$(".film").hide(100);
			$(".challenge").show(100);
			break;
			
		case 3:
			$(".challenge").hide(100);
			$(".openchalhide").hide(100);
			$(".idea").hide(100);
			$(".film").hide(100);
			$(".articlesch").show(100);
			break;
			
		case 4:
			$(".challenge").hide(100);
			$(".openchalhide").show(100);
			$(".idea").hide(100);
			$(".film").hide(100);
			$(".articlesch").hide(100);
			break;
			
		case 5:
			$(".challenge").hide(100);
			$(".openchalhide").hide(100);
			$(".idea").hide(100);
			$(".film").show(100);
			$(".articlesch").hide(100);
			break;
			
		case 6:
			$(".challenge").hide(100);
			$(".openchalhide").hide(100);
			$(".film").hide(100);
			$(".articlesch").hide(100);
			$(".idea").show(100);
			break;
		}
	}
function refineVedioId(str){
	if(str.indexOf('&') === -1){
		return str;
		}
		return str.split('&')[0];
}

function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};

	$(document).ready(function(){
		
		$("#create_video").click(function(){
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
			if (challenge == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter url", 5000,"alert-warning");
				$("#create_video").removeAttr('disabled');
				return false ;
			}
			else if (video_title == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Title", 5000,"alert-warning");
				$("#create_video").removeAttr('disabled');
				return false ;
			}
			else if (videodes == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Description", 5000,"alert-warning");
				$("#create_video").removeAttr('disabled');
				return false ;
			}
			else {
				var dataString = 'video='+ challenge + '&title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',video_title))))
				 + '&videodes='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',videodes)))) ;
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
							$("#create_video").removeAttr('disabled');
							}
					}
				  });
				}
				$("#create_video").removeAttr('disabled');	
			}
			else {
				bootstrap_alert(".alert_placeholder", "Add You-Tube URL Only", 5000,"alert-warning");
				$("#create_video").removeAttr('disabled');
				return false ;
				}
		});

		$("#create_videopr").click(function(){
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
			if (challenge == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter url", 5000,"alert-warning");
				$("#create_videopr").removeAttr('disabled');
				return false ;
			}
			else if (video_title == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Title", 5000,"alert-warning");
				$("#create_videopr").removeAttr('disabled');
				return false ;
			}
			else if (videodes == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Description", 5000,"alert-warning");
				$("#create_videopr").removeAttr('disabled');
				return false ;
			}
			else {
				var dataString = 'videos='+ challenge + '&title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',video_title))))
				 + '&videodes='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',videodes)))) ;
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
							$("#create_videopr").removeAttr('disabled');
							}
					}
				  });
				}
				$("#create_videopr").removeAttr('disabled');
			}
			else {
				bootstrap_alert(".alert_placeholder", "Add You-Tube URL Only", 5000,"alert-warning");
				$("#create_videopr").removeAttr('disabled');
				return false ;
				}		
		});
	function convertSpecialChar(str){
		return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
	}
		$("#submit_ch").click(function(){
      		$("#submit_ch").attr('disabled','disabled');
			var challenge = convertSpecialChar($("#challange").val()) ;
			var domain = url_domain(challenge);
			//alert(domain);
			if (domain == "www.youtube.com"){
				var linkId = refineVedioId(getVedioId(challenge));
				//alert(linkId);
				challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
				challenge = challenge.concat(linkId);
				challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
			}
			//alert(challenge);
			var challenge_title = convertSpecialChar($("#challange_title").val()) ;			
			//var type = document.getElementById("Chall_type").checked;
			//alert(type) ;
			//if (type) {
			//if(!confirm("Challenge will be open always and there will be no ETA"))
				//return false;
			//var challtype = '2' ;
			//}
			// else {
				// var challtype = '1' ;
				//}
			//var open_time = parseInt($("#open_time").val());
			//var open = parseInt($("#open").val());
			//var opentime = parseInt(open_time*60+open) ;
			//var eta = parseInt($("#c_eta").val());
			//var etab = parseInt($("#c_etab").val());
			//var etac = parseInt($("#c_etac").val());
			//var etad = parseInt($("#c_etad").val());
			//var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ; 
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',challenge)))) + 
			'&challenge_title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',challenge_title)))) ;// + '&opentime='+ (opentime+='') + '&challange_eta='+ (challange_eta+='') + '&challtype='+ challtype;
			//alert(dataString);
			if(challenge==''){
				bootstrap_alert(".alert_placeholder", "Challenge can not be empty", 5000,"alert-warning");
				$("#submit_ch").removeAttr('disabled');
			}
			else if(challenge_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
				$("#submit_ch").removeAttr('disabled');
			}
			else {
					//file upload
				var _filech = document.getElementById('_fileChallenge');
				uploadFile(_filech,"challengePic",String(dataString),"ajax/submit_chalange.php");
			}
		});
    
    function uploadFile(_file,typeOfPic,data1,url1){
		var _progress = document.getElementById('_progress');
		
		if(_file.files.length === 0){
			if(typeOfPic == "profilepic") {
				bootstrap_alert(".alert_placeholder", "Please upload a pic", 5000,"alert-warning");
				}
				  else{
						submitCreateArticle("",data1,url1);
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
				submitCreateArticle(responceTx,data1,url1);
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
	function submitCreateArticle(ilink,data,url){
		//alert(ilink) ;
		if (ilink != "") {
		var res = ilink.split(".");
		//alert (res['1']);
			if ((res['1'] == "jpg") || (res['1'] == "jpeg") || (res['1'] == "png") || (res['1'] == "gif")){
				var imgTx = "<img onError=\"this.src=\"img/default.gif\"\" src=\""+ilink+"\" style=\"max-width: 100%;\" />";
			}
				else {
					var imgTx = ilink ;
					}
			if (imgTx.length < 30) { alert(imgTx); }
		var dataString = data + '&img='+ imgTx ;
		//alert(dataString) ;
		}
			else {
				var	dataString =  data ;
				//alert(dataString) ;			
				}
			$.ajax({
				type: "POST",
				url: url,
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
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
	} ;
		$("#create_article").click(function(){
      		$("#create_article").attr('disabled','disabled');
			var article = convertSpecialChar($("#articlech").val()) ;
			var article_title = convertSpecialChar($("#article_title").val()) ;
			if(article==''){
				bootstrap_alert(".alert_placeholder", "Article can not be empty", 5000,"alert-warning");
				$("#create_article").removeAttr('disabled');
				return false;
			}
			else if(article_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
				$("#create_article").removeAttr('disabled');
				return false;
			} else {
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'article='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',article)))) + 
			'&article_title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',article_title))))  ;
			//alert(dataString);
			
			//file upload
			var _file = document.getElementById('_fileArticle');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"articlePic",String(dataString),"ajax/submit_article.php");
		
			}
		});
		
		$("#upload_image").click(function(){
      		//$("#upload_image").attr('disabled','disabled');
      		var profile = "profilepic" ;
      		var dataString = 'profile='+ profile ;
			var _file = document.getElementById('_fileprofilepic');
			//alert(_file + "bhschjsdhsbd");
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"profilepic",String(dataString),"ajax/change_profile.php");
		});
		
		$("#remind").click(function(){
			$("#remind").attr('disabled','disabled');
			var reminder = convertSpecialChar($("#reminder").val()) ;
			var self = $("#self").val() ;
			var eventtime = $("#datepick").val() ;
			if(reminder==''){
				bootstrap_alert(".alert_placeholder", "Reminder can not be empty", 5000,"alert-warning");
				$("#remind").removeAttr('disabled');
				return false;
			}
			else if (eventtime == "") {
				bootstrap_alert(".alert_placeholder", "Please Select Date and Time ", 5000,"alert-warning");
				$("#remind").removeAttr('disabled');
				return false;
				}
			 else {
			var dataString = 'reminder='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',reminder)))) + '&eventtime='+ eventtime + '&self='+ self ;
			$.ajax({
				type: "POST",
				url: "ajax/submit_reminder.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result=='Reminder Set succesfully!'){
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
						$("#reminder").val("") ;
						$("#self").val("") ;
						$("#datepick").val("") ;
					location.reload();
					}
					else {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
						$("#remind").removeAttr('disabled');
						return false;
						}
				}
			 });
			}	
			$("#remind").removeAttr('disabled');
				return false;
		});
			
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
			var dataString = 'project_title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',project_title)))) + '&project_stmt='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',project_stmt)))) + 
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
			uploadFile(_file,"projectPic",String(dataString),"ajax/submit_project.php");
			}
		});
		
		$('.tree-toggle').click(function () {
		$(this).parent().children('ul.tree').toggle(200);
		});	
	
		//to hide all the form
		$("#challegeForm").toggle();
  		$("#ArticleForm").toggle();
  		$("#PictureForm").toggle();
  		$("#VideoForm").toggle();
  		$("#IdeaForm").toggle();

  		//selecting perticular one
  		$("#challenge").click(function(){
  			$("#ArticleForm").hide(1500);
  			$("#PictureForm").hide(1500);
  			$("#selecttext").hide(1500);
  			$("#IdeaForm").hide(3000);
  			$("#VideoForm").hide(1500);
    		$("#challegeForm").show(3000);
  		});
 		
  		$("#artical").click(function(){
  			$("#challegeForm").hide(1500);
  			$("#PictureForm").hide(1500);
  			$("#selecttext").hide(1500);
  			$("#IdeaForm").hide(3000);
  			$("#VideoForm").hide(1500);
    		$("#ArticleForm").show(3000);
  		});
  
		$("#picture").click(function(){
  			$("#challegeForm").hide(1500);
  			$("#PictureForm").show(1500);
  			$("#IdeaForm").hide(3000);
  			$("#selecttext").hide(1500);
  			$("#VideoForm").hide(1500);
    		$("#ArticleForm").hide(3000);
  		});
  
  		$("#video").click(function(){
  			$("#challegeForm").hide(1500);
  			$("#PictureForm").hide(1500);
  			$("#selecttext").hide(1500);
  			$("#IdeaForm").hide(3000);
  			$("#VideoForm").show(1500);
    		$("#ArticleForm").hide(3000);
  		});
  
  		$("#idea").click(function(){
		  	$("#challegeForm").hide(1500);
		  	$("#PictureForm").hide(1500);
		  	$("#selecttext").hide(1500);
		  	$("#VideoForm").hide(1500);
		    $("#ArticleForm").hide(3000);
		    $("#IdeaForm").show(3000);
  		});

		//allPanels
		$("#allPanels").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".articlesch").show(100);
  	$(".openchalhide").show(100);
  	$(".idea").show(100);
  	$(".film").show(100);
    $(".challenge").show(100);
  });

$("#pencil").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".articlesch").hide(100);
  	$(".openchalhide").hide(100);
  	$(".idea").hide(100);
  	$(".film").hide(100);
    $(".challenge").show(100);
    getnextchal('challenge',2) ;
  });

  $("#globe").click(function(){
  	$(".challenge").hide(100);
  	$(".openchalhide").hide(100);
  	$(".idea").hide(100);
  	$(".film").hide(100);
    $(".articlesch").show(100);
    getnextchal('articlesch', 3) ;
  });
  
  $("#okch").click(function(){
  	$(".challenge").hide(100);
  	$(".openchalhide").show(100);
  	$(".idea").hide(100);
  	$(".film").hide(100);
    $(".articlesch").hide(100);
    getnextchal('openchalhide', 4) ;
  });
  
  $("#filmnin").click(function(){
  	$(".challenge").hide(100);
  	$(".openchalhide").hide(100);
  	$(".idea").hide(100);
  	$(".film").show(100);
    $(".articlesch").hide(100);
    getnextchal('film', 5) ;
  });
  
  $("#tree").click(function(){
  	$(".challenge").hide(100);
  	$(".openchalhide").hide(100);
  	$(".film").hide(100);
    $(".articlesch").hide(100);
    $(".idea").show(100);
    getnextchal('idea', 6) ;
  });
	
		$("#create_idea").click(function(){
      		$("#create_idea").attr('disabled','disabled');
			var idea = convertSpecialChar($("#ideaA").val()) ;
			var idea_title = convertSpecialChar($("#idea_titleA").val()) ;		
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'idea='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',idea)))) + '&idea_title='+ 
			replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',idea_title))))  ;
			//alert(dataString);
			if(idea == ''){
				bootstrap_alert(".alert_placeholder", "Idea can not be empty", 5000,"alert-warning");
				$("#create_idea").removeAttr('disabled');
			}
			else if(idea_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
				$("#create_idea").removeAttr('disabled');
			}
			else { 
				//file upload
			var _file = document.getElementById('_fileIdea');
			uploadFile(_file,"ideaPic",String(dataString),"ajax/submit_idea.php");
			}
		});
	
		$("#create_picture").click(function(){
      		$("#create_picture").attr('disabled','disabled');
			var picturech = convertSpecialChar($("#picturech").val()) ;
			var picture_title = convertSpecialChar($("#picture_title").val()) ;			
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'picturech='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',picturech)))) 
			+ '&picture_title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',picture_title))))  ;
			//alert(dataString);
			if(picturech == ''){
				bootstrap_alert(".alert_placeholder", "Details can not be empty", 5000,"alert-warning");
				$("#create_picture").removeAttr('disabled');
			}
			else if(picture_title==''){
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
						uploadFile(_file,"photoPic",String(dataString),"ajax/submit_photo.php");
						}
			}
		});
    
		$("#create_task").click(function(){
			$("#create_task").attr('disabled','disabled');
			var team = $("#teamtask").val() ;
			var users = $("#userstask").val() ;
			var email = $("#emailtask").val() ;
			if((team == '0' && users =='0' && email =="")||(team != '0' && users !='0' && email !="")||(team != '0' && users !='0' && email =="")
			||(team != '0' && users =='0' && email !="")||(team == '0' && users !='0' && email !="")) {
				bootstrap_alert(".alert_placeholder", "Please select one value", 5000,"alert-warning");
				$("#create_task").removeAttr('disabled');
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
							var title = convertSpecialChar($("#title").val()) ;
							var taskdetails = convertSpecialChar($("#taskdetails").val()) ;
							//var eta = parseInt($("#c_eta").val());
							//var etab = parseInt($("#c_etab").val());
							//var etac = parseInt($("#c_etac").val());
							//var etad = parseInt($("#c_etad").val());
							//var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
							// Returns successful data submission message when the entered information is stored in database.
							var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',taskdetails))))
							 + '&email='+ email + '&title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',title)))) + '&team='+ team + '&users='+ users ;//+ '&challange_eta='+ (challange_eta+='') ;
							//alert(dataString);
							if(title==''){
								bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
								$("#create_task").removeAttr('disabled');
								return false ;
							}
							else if(taskdetails==''){
								bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
								$("#create_task").removeAttr('disabled');
								return false ;
							}
							else {
								//file upload
								var _file = document.getElementById('_fileTask');
								uploadFile(_file,"taskPic",String(dataString),"ajax/submit_task.php");
							}				
					}
					else if (result == 'same') {
							bootstrap_alert(".alert_placeholder","Please enter Friends email-id Not Yours !!!" , 5000,"alert-warning");
							$("#create_task").removeAttr('disabled');
								return false ;
						}
						else {
							var modal = "<h4>Hi, It looks like s/he is not here Lets intivite her/him</h4><div class\='input-group'><span class\='input-group-addon'>His/Her First Name</span><input type='text' class\='form-control' id='fnameteam' placeholder='His First Name'></div><br/><div class\='input-group'><span class\='input-group-addon'>His/Her Second Name</span><input type='text' class\='form-control' id='snameteam' placeholder='His Second Name'></div><br/><div class\='input-group'><span class\='input-group-addon'>His/Her Email ID</span><input type='text' class\='form-control' id='teamemail' placeholder='Enter Email-ID' /></div><br><br><input type='submit' class\='btn btn-success' id='invite'  value='Invite Him/Her' /><br/>";
							//bootstrap_alert(".alert_placeholder", modal, 600000,"alert-info");
							$("#invitation").show().html(modal);
							$("#create_task").removeAttr('disabled');
							return false ;
							}
						}
				  });
				}
			else {
				var title = convertSpecialChar($("#title").val()) ;
				var taskdetails = convertSpecialChar($("#taskdetails").val()) ;
				//var eta = parseInt($("#c_eta").val());
				//var etab = parseInt($("#c_etab").val());
				//var etac = parseInt($("#c_etac").val());
				//var etad = parseInt($("#c_etad").val());
				//var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
				// Returns successful data submission message when the entered information is stored in database.
				var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',taskdetails))))
				 + '&title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',title)))) + '&team='+ team + '&users='+ users ;//+ '&challange_eta='+ (challange_eta+='') ;
				//alert(dataString);
				if(title==''){
					bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
					$("#create_task").removeAttr('disabled');
								return false ;
				}
				else if(taskdetails==''){
					bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
					$("#create_task").removeAttr('disabled');
								return false ;
				}
				else {
					//file upload
					var _file = document.getElementById('_fileTask');
					uploadFile(_file,"taskPic",String(dataString),"ajax/submit_task.php");
				}
			}			
		});
		
		$("#create_team").click(function(){
			$("#create_team").attr('disabled','disabled');
			var team = $("#team_name_A").val() ;
			var email = $("#email_team").val() ;
			if(team =="") {
				bootstrap_alert(".alert_placeholder", "Please Enter Team Name", 5000,"alert-warning");
				$("#create_team").removeAttr('disabled');
								return false ;
			}
			else if (email == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Email_id", 5000,"alert-warning");
				$("#create_team").removeAttr('disabled');
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
							$("#create_team").removeAttr('disabled');
							return false ;
						}
						else {
							var modal = "<h4>Hi, It looks like s/he is not here Lets intivite her/him</h4><div class\='input-group'><span class\='input-group-addon'>His/Her First Name</span><input type='text' class\='form-control' id='fnameteam' placeholder='His First Name'></div><br/><div class\='input-group'><span class\='input-group-addon'>His/Her Second Name</span><input type='text' class\='form-control' id='snameteam' placeholder='His Second Name'></div><br/><div class\='input-group'><span class\='input-group-addon'>His/Her Email ID</span><input type='text' class\='form-control' id='teamemail' placeholder='Enter Email-ID' /></div><br><br><input type='submit' class\='btn btn-success' id='invitemember'  value='Invite Him/Her' /><br/>";
							//bootstrap_alert(".alert_placeholder", modal, 600000,"alert-info");
							$("#invitation").show().html(modal);
							$("#create_team").removeAttr('disabled');
							return false ;
							}
						}
				  });
				}	
		});
	});

	$(document).ready(function(){		
		$("#invitemember").click(function(){
			$("#invitemember").attr('disabled','disabled');
			var fname = $("#fnameteam").val() ;
			var sname = $("#snameteam").val() ;
			var email = $("#teamemail").val() ;
			if(fname =="") {
				bootstrap_alert(".alert_placeholder", "Please Enter First Name", 5000,"alert-warning");
				$("#invitemember").removeAttr('disabled');
				return false ;
			}
			else if (sname == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Second Name", 5000,"alert-warning");
				$("#invitemember").removeAttr('disabled');
				return false ;
			}
			else if (email == "") {
				bootstrap_alert(".alert_placeholder", "Please Enter Email-ID", 5000,"alert-warning");
				$("#invitemember").removeAttr('disabled');
				return false ;
			}
			else {
			$.ajax({
				type: "POST",
				url: "ajax/email.php",
				data: 'email='+ email,
				cache: false,
				success: function(result){
					alert(result);
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
							$("#invitemember").removeAttr('disabled');
						}
						else {
							bootstrap_alert(".alert_placeholder", "Please Enter Valid Email-ID", 5000,"alert-warning");
							$("#invitemember").removeAttr('disabled');
							return false ;							
							}
					}
				});
			}
		});	
});
