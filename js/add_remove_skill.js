function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};
$(document).ready(function(){
	$("#addskills").click(function(){
		$("#addskills").attr('disabled','disabled');
		var insert = $("#insert").val() ;
		var skills = $("#skills").val() ;
		var dataString = "";
		if ((skills == '0' && replaceAll('\\s', '',insert) =='')||(skills != '0' && replaceAll('\\s', '',insert) !='')) {
			 bootstrap_alert(".alert_placeholder", "Please ,Enter one Value!!!!", 5000,"alert-warning");
			 $("#addskills").removeAttr('disabled');
			 return false;
		}
		if (skills != '0') {
			var dataString = 'case=2' + '&skills='+ skills ;
		}
		else {
			var dataString = 'case=1' + '&insert='+ insert  ;
			}
		$.ajax({
			type: "POST",
			url: "ajax/change_profile.php",																																														
			data: dataString,
			cache: false,
			success: function(result){
				var notice = result.split("+") ;
				if(notice['0']=='Skill added succesfully!') {
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					$("#skills").val("");
					$("#insert").val("");
					$("#appendskill").append(notice['1']) ;
					$(".skillmodal").append(notice['1']) ;
					bootstrap_alert(".alert_placeholder", "Add more skills", 10000,"alert-info");
				}      
				else {
				 	bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
				}
			}
		});
	 $("#addskills").removeAttr('disabled');
		 //return false;
	});
});


function remove_skill(skill_id){
	bootbox.confirm("Do u really want to Remove this skill?", function(result) {
		if(result){
			var dataString = 'case=3' + '&skill_id=' + skill_id;
			$.ajax({
				type: "POST",
				url: "ajax/change_profile.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result=='Skill Removed succesfully!') {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
						location.reload();
					}
					else {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
					}
				}
			});
		 }
	});
}


$(document).ready(function(){
	$('#joined_project').click(function(){
		$('#joined_project_content').load('ajax/profile_page_ajax/joined_projects.php');		
		$(window).scroll(function(event) {
			if (($(window).scrollTop() == ($(document).height() - $(window).height())) && $('#joined_project')) {
				event.preventDefault();
				var dataString = 'next_JnPr=3' ;
				$.ajax({
					type: "POST",
					url: "ajax/profile_page_ajax/get_next_joined_projects.php",
					data: dataString,
					cache: false,
					success: function(result){
						$('#joined_project_content').append(result);
					}
				});	
			}
		});
	});
	$('#user_articles').click(function(){
		$('#user_articles_content').load('ajax/profile_page_ajax/user_articles.php');
		
		$(window).scroll(function(event) {
			if (($(window).scrollTop() == ($(document).height() - $(window).height())) && $('#user_articles')) {
				event.preventDefault();
				var dataString = 'last_article=3';
				$.ajax({
					type: "POST",
					url: "ajax/profile_page_ajax/get_next_user_articles.php",
					data: dataString,
					cache: false,
					success: function(result){
						//alert(result) ;
						$('#user_articles_content').append(result);
					}
				});	
			}
		});
	});
	$('#user_challenges').click(function(){
		$('#user_challenges_content').load('ajax/profile_page_ajax/user_challenges.php');
		$(window).scroll(function(event) {
			if ($(window).scrollTop() == ($(document).height() - $(window).height()) && $('#user_challenges')) {
				event.preventDefault();
				var dataString = 'next=5' ;
				$.ajax({
					type: "POST",
					url: "ajax/profile_page_ajax/get_next_user_challenges.php",
					data: dataString,
					cache: false,
					success: function(result){
						//alert(result) ;
						$('#next_user_chall').append(result);
					}
				});	
			}
		});
	});

	$('#user_idea').click(function(){
		$('#user_idea_content').load('ajax/profile_page_ajax/user_idea.php');
		
		$(window).scroll(function(event) {
			if ($(window).scrollTop() == ($(document).height() - $(window).height())  && $('#user_idea')) {
				event.preventDefault();
				var dataString = 'user_next_idea=5' ;
				$.ajax({
					type: "POST",
					url: "ajax/profile_page_ajax/get_next_user_ideas.php",
					data: dataString,
					cache: false,
					success: function(result){
						$('#user_next_idea').append(result);
					}
				});	
			}
		});
	});
}) ;
function editProfile(fname, lname, email, phone) {
	//alert (fname + "," + lname + "," + email + "," + phone);
	var newfname = $("#newfirstname").val() ;
	var newlname = $("#newlastname").val() ;
	var newphone = $("#newphoneno").val() ;
	var about = $("#aboutuser").val() ;
	var townname = $("#livingtown").val() ;
	var comp = $("#companyname").val() ;
	if (replaceAll('\\s', '',newfname) == "") {
		bootstrap_alert(".alert_placeholder", "Invalid Request", 5000,"alert-warning");
		$("#newfirstname").val(fname) ;
		return false ;
	}
	else if ((replaceAll('\\s', '',newlname) == "") && (replaceAll('\\s', '',newphone) == "") && (replaceAll('\\s', '',about) == "") && (replaceAll('\\s', '',townname) == "") && (replaceAll('\\s', '',comp) == "")) {
		bootstrap_alert(".alert_placeholder", "Invalid Request", 5000,"alert-warning");
		return false ;
	}
	else if ((newfname == fname) && (newlname == lname) && (newphone == phone) && (replaceAll('\\s', '',about) == "") && (replaceAll('\\s', '',townname) == "") && (replaceAll('\\s', '',comp) == "")) {
		bootstrap_alert(".alert_placeholder", "Invalid Request", 5000,"alert-warning");
		return false ;
	}
	else {
		var dataString = 'case=4' + '&fname='+ newfname + '&lname='+ newlname + '&email='+ email + '&phone='+ newphone + '&about='+ about 
						+ '&townname='+ townname + '&comp='+ comp ;
		$.ajax ({ 
			type: "POST",
			url: "ajax/change_profile.php",
			data: dataString,
			cache: false,
			success: function(result){
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
				if(result=='Updated successfuly'){
					location.reload();
				}
			}
		});
	}
}
function form_profile(type){
	var dataString = 'form_type=' + type ;
	$.ajax({
		type: "POST",
		url: "ajax/forms.php",
		data: dataString,
		async: false ,
		cache: false,
		success: function(result){
			if(type == 7){
				document.getElementById("user_challenges_content").innerHTML = result ;
			}
			else if(type == 8){
				document.getElementById("user_articles_content").innerHTML = result ;
			}
			else { document.getElementById("user_idea_content").innerHTML = result ; }
		}
	});
}
function upload_image(){
	var dataString = 'case=5' ;
	var _file = document.getElementById('_fileprofilepic');
	uploadFile1(_file,"profilepic",String(dataString),"ajax/change_profile.php");
}
