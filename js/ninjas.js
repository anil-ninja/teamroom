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
			var challenge = $("#video").val() ;
			var domain = url_domain(challenge);
			//alert(domain);
			if (domain == "www.youtube.com"){
				var linkId = refineVedioId(getVedioId(challenge));
				//alert(linkId);
				challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
				challenge = challenge.concat(linkId);
				challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
			}
			
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'video='+ challenge ;
				
		
		});

		$("#submit_ch").click(function(){
      		$("#submit_ch").attr('disabled','disabled');
			var challenge = $("#challange").val() ;
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
			var challenge_title = $("#challange_title").val() ;			
			var type = document.getElementById("Chall_type").checked;
			//alert(type) ;
			if (type) {
			if(!confirm("Challenge will be open always and there will be no ETA"))
				return false;
			var challtype = '2' ;
			}
			 else {
				 var challtype = '1' ;
				}
			var open_time = parseInt($("#open_time").val());
			var open = parseInt($("#open").val());
			var opentime = parseInt(open_time*60+open) ;
			var eta = parseInt($("#c_eta").val());
			var etab = parseInt($("#c_etab").val());
			var etac = parseInt($("#c_etac").val());
			var etad = parseInt($("#c_etad").val());
			var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',challenge)))) + 
			'&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + '&challange_eta='+ (challange_eta+='') + '&challtype='+ challtype;
			//alert(dataString);
			if(challenge==''){
				bootstrap_alert(".alert_placeholder", "Challenge can not be empty", 5000,"alert-warning");
			}
			else if(challenge_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
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
				submitCreateArticle("",data1,url1);
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
		var imgTx = "<img src=\""+ilink+"\" style=\"max-width: 100%;\" />";
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
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Posted succesfully!'){
					location.reload();
					}
				}
			}); 
	}
		
		$("#create_article").click(function(){
      		$("#create_article").attr('disabled','disabled');
			var article = $("#articlech").val() ;
			var article_title = $("#article_title").val() ;
			if(article==''){
				bootstrap_alert(".alert_placeholder", "Article can not be empty", 5000,"alert-warning");
				return false;
			}
			else if(article_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
				return false;
			} else {
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'article='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',article)))) + '&article_title='+ article_title  ;
			//alert(dataString);
			
			//file upload
			var _file = document.getElementById('_fileArticle');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"articlePic",String(dataString),"ajax/submit_article.php");
		
	}
		});
		
		$("#remind").click(function(){
			var reminder = $("#reminder").val() ;
			var self = $("#self").val() ;
			var month = parseInt($("#month").val());
			var date = parseInt($("#date").val());
			var hour = parseInt($("#hour").val());
			var minute = parseInt($("#minute").val());
			var eventtime = parseInt((((month*30+date)*24+hour)*60+minute)*60) ;
			if(reminder==''){
				bootstrap_alert(".alert_placeholder", "Reminder can not be empty", 5000,"alert-warning");
				return false;
			}
			else if (month == '0' && date == '0' && hour == '0' && minute == '0') {
				bootstrap_alert(".alert_placeholder", "Please Select Date and Time ", 5000,"alert-warning");
				return false;
				}
			 else {
			var dataString = 'reminder='+ reminder + '&eventtime='+ eventtime + '&self='+ self ;
			$.ajax({
				type: "POST",
				url: "ajax/submit_reminder.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Reminder Set succesfully!'){
						$("#reminder").val("") ;
						$("#self").val("") ;
						$("#month").val("") ;
						$("#date").val("") ;
						$("#hour").val("") ;
						$("#minute").val("") ;
					location.reload();
					}
				}
			 });
			}	
		});
			
		$("#create_project").click(function(){
			$("#create_project").attr('disabled','disabled');
			var project_title = $("#project_title").val() ;
			var project_stmt = $("#project_stmt").val();
			var type = $("#type").val();
			var eta = parseInt($("#eta").val());
			var etab = parseInt($("#etab").val());
			var etac = parseInt($("#etac").val());
			var etad = parseInt($("#etad").val());
			var project_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'project_title='+ project_title + '&project_stmt='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',project_stmt)))) + 
			'&project_eta='+ (project_eta+='') + '&type='+ type ;
			//alert(dataString);
			if(project_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else if(project_stmt==''){
				bootstrap_alert(".alert_placeholder", "Project can not be empty", 5000,"alert-warning");
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
  			$("#IdeaForm").hide(3000);
  			$("#VideoForm").hide(1500);
    		$("#challegeForm").show(3000);
  		});
 		
  		$("#artical").click(function(){
  			$("#challegeForm").hide(1500);
  			$("#PictureForm").hide(1500);
  			$("#IdeaForm").hide(3000);
  			$("#VideoForm").hide(1500);
    		$("#ArticleForm").show(3000);
  		});
  
		$("#picture").click(function(){
  			$("#challegeForm").hide(1500);
  			$("#PictureForm").show(1500);
  			$("#IdeaForm").hide(3000);
  			$("#VideoForm").hide(1500);
    		$("#ArticleForm").hide(3000);
  		});
  
  		$("#video").click(function(){
  			$("#challegeForm").hide(1500);
  			$("#PictureForm").hide(1500);
  			$("#IdeaForm").hide(3000);
  			$("#VideoForm").show(1500);
    		$("#ArticleForm").hide(3000);
  		});
  
  		$("#idea").click(function(){
		  	$("#challegeForm").hide(1500);
		  	$("#PictureForm").hide(1500);
		  	$("#VideoForm").hide(1500);
		    $("#ArticleForm").hide(3000);
		    $("#IdeaForm").show(3000);
  		});

		//allPanels
		$("#allPanels").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".articlesch").show(1000);
  	$(".openchalhide").show(1000);
  	$(".idea").show(1000);
  	$(".VideoForm").show(1000);
    $(".challenge").show(1000);
  });

$("#pencil").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".articlesch").hide(1000);
  	$(".openchalhide").hide(1000);
  	$(".idea").hide(1000);
  	$(".VideoForm").hide(1000);
    $(".challenge").show(1000);
  });

  $("#pencil").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".articlesch").hide(1000);
  	$(".openchalhide").hide(1000);
  	$(".idea").hide(1000);
  	$(".VideoForm").hide(1000);
    $(".challenge").show(1000);
  });
 
  $("#globe").click(function(){
  	$(".challenge").hide(1000);
  	$(".openchalhide").hide(1000);
  	$(".idea").hide(1000);
  	$(".VideoForm").hide(1000);
    $(".articlesch").show(1000);
  });
  
  $("#ok").click(function(){
  	$(".challenge").hide(1000);
  	$(".openchalhide").show(1000);
  	$(".idea").hide(1000);
  	$(".VideoForm").hide(1000);
    $(".articlesch").hide(1000);
  });
  
  $("#film").click(function(){
  	$(".challenge").hide(1000);
  	$(".openchalhide").hide(1000);
  	$(".idea").hide(1000);
  	$(".VideoForm").show(1000);
    $(".articlesch").hide(1000);
  });
  
  $("#tree").click(function(){
  	$(".challenge").hide(1000);
  	$(".openchalhide").hide(1000);
  	$(".VideoForm").hide(1000);
    $(".articlesch").hide(1000);
    $(".idea").show(1000);
  });
	
		$("#create_idea").click(function(){
      		$("#create_idea").attr('disabled','disabled');
			var idea = $("#ideaA").val() ;
			var idea_title = $("#idea_titleA").val() ;		
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'idea='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',idea)))) + '&idea_title='+ idea_title  ;
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
			uploadFile(_file,"ideaPic",String(dataString),"ajax/submit_idea.php");
			}
		});
	
		$("#create_picture").click(function(){
      		$("#create_picture").attr('disabled','disabled');
			var picturech = $("#picturech").val() ;
			var picture_title = $("#picture_title").val() ;			
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'picturech='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',picturech)))) + '&picture_title='+ picture_title  ;
			//alert(dataString);
			if(picturech == ''){
				bootstrap_alert(".alert_placeholder", "Idea can not be empty", 5000,"alert-warning");
			}
			else if(picture_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else {
				//file upload
				var _file = document.getElementById('_filePhotos');
				uploadFile(_file,"photoPic",String(dataString),"ajax/submit_photo.php");
			}
		});
    
		$("#create_task").click(function(){
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
							var title = $("#title").val() ;
							var taskdetails = $("#taskdetails").val() ;
							var eta = parseInt($("#c_eta").val());
							var etab = parseInt($("#c_etab").val());
							var etac = parseInt($("#c_etac").val());
							var etad = parseInt($("#c_etad").val());
							var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
							// Returns successful data submission message when the entered information is stored in database.
							var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',taskdetails))))
							 + '&email='+ email + '&title='+ title + '&team='+ team + '&users='+ users + '&challange_eta='+ (challange_eta+='') ;
							//alert(dataString);
							if(title==''){
								bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
							}
							else if(taskdetails==''){
								bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
							}
							else {
								//file upload
								var _file = document.getElementById('_fileTask');
								uploadFile(_file,"taskPic",String(dataString),"ajax/submit_task.php");
							}				
					}
					else if (result == 'same') {
							bootstrap_alert(".alert_placeholder","Please enter Friends email-id Not Yours !!!" , 5000,"alert-warning");
							return false ;
						}
						else {
							var modal = "<h4>Hi, It looks like s/he is not here Lets intivite her/him</h4><div class\='input-group'><span class\='input-group-addon'>His/Her First Name</span><input type='text' class\='form-control' id='fnameteam' placeholder='His First Name'></div><br/><div class\='input-group'><span class\='input-group-addon'>His/Her Second Name</span><input type='text' class\='form-control' id='snameteam' placeholder='His Second Name'></div><br/><div class\='input-group'><span class\='input-group-addon'>His/Her Email ID</span><input type='text' class\='form-control' id='teamemail' placeholder='Enter Email-ID' /></div><br><br><input type='submit' class\='btn btn-success' id='invite'  value='Invite Him/Her' /><br/>";
							//bootstrap_alert(".alert_placeholder", modal, 600000,"alert-info");
							$("#invitation").show().html(modal);
							
							}
						}
				  });
				}
			else {
				var title = $("#title").val() ;
				var taskdetails = $("#taskdetails").val() ;
				var eta = parseInt($("#c_eta").val());
				var etab = parseInt($("#c_etab").val());
				var etac = parseInt($("#c_etac").val());
				var etad = parseInt($("#c_etad").val());
				var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
				// Returns successful data submission message when the entered information is stored in database.
				var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',taskdetails))))
				 + '&title='+ title + '&team='+ team + '&users='+ users + '&challange_eta='+ (challange_eta+='') ;
				//alert(dataString);
				if(title==''){
					bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
				}
				else if(taskdetails==''){
					bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
				}
				else {
					//file upload
					var _file = document.getElementById('_fileTask');
					uploadFile(_file,"taskPic",String(dataString),"ajax/submit_task.php");
				}
			}			
		});
		
		$("#create_team").click(function(){
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
									bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
								if(result = "Team Created Successfully !!!") {
									location.reload() ;
									$("#team_name_A").val("") ;
									$("#email_team").val("") ;
									}
								}				
							}) ;
						}
						else if (result == 'same') {
							bootstrap_alert(".alert_placeholder","Please enter Friends email-id Not Yours !!!" , 5000,"alert-warning");
							return false ;
						}
						else {
							var modal = "<h4>Hi, It looks like s/he is not here Lets intivite her/him</h4><div class\='input-group'><span class\='input-group-addon'>His/Her First Name</span><input type='text' class\='form-control' id='fnameteam' placeholder='His First Name'></div><br/><div class\='input-group'><span class\='input-group-addon'>His/Her Second Name</span><input type='text' class\='form-control' id='snameteam' placeholder='His Second Name'></div><br/><div class\='input-group'><span class\='input-group-addon'>His/Her Email ID</span><input type='text' class\='form-control' id='teamemail' placeholder='Enter Email-ID' /></div><br><br><input type='submit' class\='btn btn-success' id='invitemember'  value='Invite Him/Her' /><br/>";
							//bootstrap_alert(".alert_placeholder", modal, 600000,"alert-info");
							$("#invitation").show().html(modal);
							
							}
						}
				  });
				}	
		});
	});

	$(document).ready(function(){		
		$("#invitemember").click(function(){
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
						}
						else {
							bootstrap_alert(".alert_placeholder", "Please Enter Valid Email-ID", 5000,"alert-warning");
							return false ;							
							}
					}
				});
			}
		});	
});
