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

    $(window).scroll(function(event) {
		
    if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
         event.preventDefault();
		var dataString = 'chal=10' ;
			  $.ajax({
				type: "POST",
				url: "ajax/get_next.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					$('#panel-cont').append(result);
					}
				
			});
		
	}
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
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',challenge)) + '&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + 
			'&challange_eta='+ (challange_eta+='') + '&challtype='+ challtype;
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
		alert(ilink) ;
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
					
      //$("#create_article").removeAttr('disabled');
			//return false;
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
			var dataString = 'article='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',article)) + '&article_title='+ article_title  ;
			//alert(dataString);
			
			//file upload
			var _file = document.getElementById('_fileArticle');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"articlePic",String(dataString),"ajax/submit_article.php");
		
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
			var dataString = 'project_title='+ project_title + '&project_stmt='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',project_stmt)) + 
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
			var dataString = 'idea='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',idea)) + '&idea_title='+ idea_title  ;
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
			var dataString = 'picturech='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',picturech)) + '&picture_title='+ picture_title  ;
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
});


$(document).ready(function(){
    
		$("#create_task").click(function(){
      		$("#create_task").attr('disabled','disabled');
			var email = $("#email").val() ;
			var title = $("#title").val() ;
			var id = $("#project_id").val() ;
			var taskdetails = $("#taskdetails").val() ;
			var eta = parseInt($("#c_eta").val());
			var etab = parseInt($("#c_etab").val());
			var etac = parseInt($("#c_etac").val());
			var etad = parseInt($("#c_etad").val());
			var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'taskdetails='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',taskdetails)) + '&title='+ title + '&email='+ email + '&id='+ id +
			'&challange_eta='+ (challange_eta+='') ;
			//alert(dataString);
			if(email==''){
				bootstrap_alert(".alert_placeholder", "Email can not be empty", 5000,"alert-warning");
			}
			else if(title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else if(taskdetails==''){
				bootstrap_alert(".alert_placeholder", "Task Details can not be empty", 5000,"alert-warning");
			}
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_task.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Task assigned succesfully!'){
						$("#email").val("");
						$("#title").val("");
						$("#taskdetails").val("");
						$("#c_eta").val("");
						$("#c_etab").val("");
						$("#c_etac").val("");
						$("#c_etad").val("");
					 location.reload();
					}
				}
			});
			}
      $("#create_task").removeAttr('disabled');
			return false;
		});
});
