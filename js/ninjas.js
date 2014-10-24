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
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_chalange.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Challange posted succesfully!'){
						$("#challange").val("");
						$("#challange_title").val("");
						$("#open_time").val("");
						$("#open").val("");
						$("#c_eta").val("");
						$("#c_etab").val("");
						$("#c_etac").val("");
						$("#c_etad").val("");
					 location.reload();
					}
				}
			});
			}
      $("#submit_ch").removeAttr('disabled');
			return false;
		});
});
$(document).ready(function(){
    
		$("#create_article").click(function(){
      		$("#create_article").attr('disabled','disabled');
			var article = $("#article").val() ;
			var article_title = $("#article_title").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'article='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',article)) + '&article_title='+ article_title  ;
			//alert(dataString);
			if(article==''){
				bootstrap_alert(".alert_placeholder", "Article can not be empty", 5000,"alert-warning");
			}
			else if(article_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_article.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Article posted succesfully!'){
						$("#article").val("");
						$("#article_title").val("");
					location.reload();
					}
				}
			});
			}
      $("#create_article").removeAttr('disabled');
			return false;
		});
});

	$(document).ready(function(){
	$("#challegeForm").toggle();
  $("#challenge").click(function(){
  	$("#ArticleForm").hide(1500);
  	$("#PictureForm").hide(1500);
  	$("#IdeaForm").hide(3000);
  	$("#VideoForm").hide(1500);
    $("#challegeForm").toggle(3000);
  });

  $("#ArticleForm").toggle();
  $("#artical").click(function(){
  	$("#challegeForm").hide(1500);
  	$("#PictureForm").hide(1500);
  	$("#IdeaForm").hide(3000);
  	$("#VideoForm").hide(1500);
    $("#ArticleForm").toggle(3000);
  });
  $("#PictureForm").toggle();
  $("#picture").click(function(){
  	$("#challegeForm").hide(1500);
  	$("#PictureForm").toggle(1500);
  	$("#IdeaForm").hide(3000);
  	$("#VideoForm").hide(1500);
    $("#ArticleForm").hide(3000);
  });
  $("#VideoForm").toggle();
  $("#video").click(function(){
  	$("#challegeForm").hide(1500);
  	$("#PictureForm").hide(1500);
  	$("#IdeaForm").hide(3000);
  	$("#VideoForm").toggle(1500);
    $("#ArticleForm").hide(3000);
  });
  $("#IdeaForm").toggle();
  $("#idea").click(function(){
  	$("#challegeForm").hide(1500);
  	$("#PictureForm").hide(1500);
  	$("#VideoForm").hide(1500);
    $("#ArticleForm").hide(3000);
    $("#IdeaForm").toggle(3000);
  });
});	

	$(document).ready(function(){
	
  $("#pencil").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".articlesch").hide(1500);
  	$(".openchalhide").hide(1500);
  	$(".idea").hide(1500);
  	$(".VideoForm").hide(1500);
    $(".challenge").toggle(3000);
  });

  
  $("#globe").click(function(){
  	$(".challenge").hide(1500);
  	$(".openchalhide").hide(1500);
  	$(".idea").hide(3000);
  	$(".VideoForm").hide(1500);
    $(".articlesch").toggle(3000);
  });
  
  $("#ok").click(function(){
  	$(".challenge").hide(1500);
  	$(".openchalhide").toggle(1500);
  	$(".idea").hide(3000);
  	$(".VideoForm").hide(1500);
    $(".articlesch").hide(3000);
  });
  
  $("#film").click(function(){
  	$(".challenge").hide(1500);
  	$(".openchalhide").hide(1500);
  	$(".idea").hide(3000);
  	$(".VideoForm").toggle(1500);
    $(".articlesch").hide(3000);
  });
  
  $("#tree").click(function(){
  	$(".challenge").hide(1500);
  	$(".openchalhide").hide(1500);
  	$(".VideoForm").hide(1500);
    $(".articlesch").hide(3000);
    $(".idea").toggle(3000);
  });
});	
$(document).ready(function(){	
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
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_idea.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='IDEA posted succesfully!'){
						$("#ideaA").val("");
						$("#idea_titleA").val("");
					location.reload();
					}
				}
			});
			}
      $("#create_idea").removeAttr('disabled');
			return false;
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
