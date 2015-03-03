$(document).ready(function() {
	$("#addskills").click(function(){
		$("#addskills").attr('disabled','disabled');
		var insert = convertSpecialChar($("#insert").val()) ;
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
			var dataString = 'case=1' + '&insert='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',insert)))))  ;
		}
		$.ajax({
			type: "POST",
			url: "ajax/change_profile.php",																																														
			data: dataString,
			async: false ,
			cache: false,
			success: function(result){
				var notice = result.split("|+") ;
				if(notice['0']=='Skill added succesfully!') {
					$("#skills").val("0");
					$("#insert").val("");
					$("#appendskill").append(notice['1']) ;
					$(".skillmodal").append(notice['1']) ;
					$(".removeskl").remove() ;
					bootstrap_alert(".alert_placeholder", "Add more skills", 10000,"alert-info");
				}      
				else {
				 	bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
				}
			}
		});
		$("#addskills").removeAttr('disabled');
	});
	
	$("#addprofessions").click(function(){
		$("#addprofessions").attr('disabled','disabled');
		var insert = convertSpecialChar($("#insertprofession").val()) ;
		var skills = $("#Professions").val() ;
		var dataString = "";
		if ((skills == '0' && replaceAll('\\s', '',insert) =='')||(skills != '0' && replaceAll('\\s', '',insert) !='')) {
			 bootstrap_alert(".alert_placeholder", "Please ,Enter one Value!!!!", 5000,"alert-warning");
			 $("#addprofessions").removeAttr('disabled');
			 return false;
		}
		else {
			if (skills != '0') {
				var dataString = 'case=2' + '&skills='+ skills ;
			}
			else {
				var dataString = 'case=1' + '&insert='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',insert)))))  ;
			}
			$.ajax({
				type: "POST",
				url: "ajax/change_profession.php",																																														
				data: dataString,
				async: false ,
				cache: false,
				success: function(result){
					var notice = result.split("|+") ;
					if(notice['0']=='Profession added succesfully!') {
						$("#Professions").val("0");
						$("#insertprofession").val("");
						$("#appendprofession").append(notice['1']) ;
						$(".professionmodal").append(notice['1']) ;
						$(".removepro").remove() ;
						bootstrap_alert(".alert_placeholder", "Add more", 10000,"alert-info");
					}      
					else {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
					}
				}
			});
		}
		$("#addprofessions").removeAttr('disabled');
	}) ;
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
						$(".skill_id_"+skill_id).remove();
					}
					else {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
					}
				}
			});
		 }
	});
}
function remove_profession(skill_id){
	bootbox.confirm("Do u really want to Remove this Profession?", function(result) {
		if(result){
			var dataString = 'case=3' + '&skill_id=' + skill_id;
			$.ajax({
				type: "POST",
				url: "ajax/change_profession.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result=='Profession Removed succesfully!') {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
						//document.getElementById("professionmodal_"+skill_id).remove();
						$(".profession_"+skill_id).remove();
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
						onLoaddata() ;
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
						onLoaddata() ;
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
						onLoaddata() ;
					}
				});	
			}
		});
	});
}) ;

function editProfile(fname, lname, email, phone) {
	//alert (fname + "," + lname + "," + email + "," + phone);
	var newfname = convertSpecialChar($("#newfirstname").val()) ;
	var newlname = convertSpecialChar($("#newlastname").val()) ;
	var newphone = convertSpecialChar($("#newphoneno").val()) ;
	var about = convertSpecialChar($("#aboutuser").val()) ;
	var townname = convertSpecialChar($("#livingtown").val()) ;
	var comp = convertSpecialChar($("#companyname").val()) ;
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
		var dataString = 'case=4' + '&fname='+ newfname + '&lname='+ newlname + '&email='+ email + '&phone='+ newphone + '&about='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',about))))) 
						+ '&townname='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',townname))))) + '&comp='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',comp))))) ;
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
