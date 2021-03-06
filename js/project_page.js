function bootstrap_alert(elem, message, timeout,type) {
	$(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
	if (timeout || timeout === 0) {
		setTimeout(function() { 
			$(elem).show().html('');
		}, timeout);    
	}
}

function showpanel(){
	$('#indexproject').show();
	$('#aboutproject').hide();
}

function hidepanel(){
	$('#indexproject').hide();
	$('#aboutproject').show();
}

function convertSpecialChar(str){
	return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
}	
	
function create_challange_pb_pr(){
	$("#create_challange_pb_pr").attr('disabled','disabled');
	var ID = $("#ProjectIDValue").val() ;
	var challenge = convertSpecialChar($("#challangepr").val()) ;
	var challenge_title = convertSpecialChar($("#challange_title").val()) ;
	var type = $("#type").val();
	// Returns successful data submission message when the entered information is stored in database.
	var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',challenge))))) + 
	'&challenge_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',challenge_title)))))
	 + '&type='+ type + '&project_id=' + ID ;//+ '&opentime='+ (opentime+='') + '&challange_eta='+ (challange_eta+='') ;
	//alert(dataString);
	if(replaceAll('\\s', '',challenge)==''){
		bootstrap_alert(".alert_placeholder", "Challenge can not be empty", 5000,"alert-warning");
		$("#create_challange_pb_pr").removeAttr('disabled');
		return false ;
	}
	else if(replaceAll('\\s', '',challenge_title)==''){
		bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
		$("#create_challange_pb_pr").removeAttr('disabled');
		return false ;
	}
	else {
		//file upload
	var _file = document.getElementById('_fileChallengepr');
	//alert(uploadFile(_file,"articlePic"));
	uploadFile1(_file,"projectchalPic",String(dataString),"ajax/submit_chalange_project.php");
	}
}
	
function create_notes(){
	$("#create_notes").attr('disabled','disabled');
	var ID = $("#ProjectIDValue").val() ;
	var notes = convertSpecialChar($("#notestmt").val()) ;
	var notes_title = convertSpecialChar($("#notes_title").val()) ;
	// Returns successful data submission message when the entered information is stored in database.
	var dataString = 'notes='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',notes))))) + 
					'&notes_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',notes_title))))) + '&project_id=' + ID ;
	//alert(dataString);
	if(replaceAll('\\s', '',notes)==''){
		bootstrap_alert(".alert_placeholder", "Notes can not be empty", 5000,"alert-warning");
		$("#create_notes").removeAttr('disabled');
		return false ;
	}
	else if(replaceAll('\\s', '',notes_title) =='') {
		bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
		$("#create_notes").removeAttr('disabled');
		return false ;
	}
	else {
		//file upload
	var _file = document.getElementById('_fileNotes');
	//alert(uploadFile(_file,"articlePic"));
	uploadFile1(_file,"projectnotesPic",String(dataString),"ajax/submit_notes.php");
	}
}

function create_issue(){
	$("#create_issue").attr('disabled','disabled');
	var ID = $("#ProjectIDValue").val() ;
	var notes = convertSpecialChar($("#issuestmt").val()) ;
	var notes_title = convertSpecialChar($("#issue_title").val()) ;
	// Returns successful data submission message when the entered information is stored in database.
	var dataString = 'notes='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',notes))))) + 
					'&notes_title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',notes_title))))) + '&project_id=' + ID ;
	//alert(dataString);
	if(replaceAll('\\s', '',notes)==''){
		bootstrap_alert(".alert_placeholder", "Issue can not be empty", 5000,"alert-warning");
		$("#create_issue").removeAttr('disabled');
		return false ;
	}
	else if(replaceAll('\\s', '',notes_title) =='') {
		bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
		$("#create_issue").removeAttr('disabled');
		return false ;
	}
	else {
		//file upload
	var _file = document.getElementById('_fileIssue');
	//alert(uploadFile(_file,"articlePic"));
	uploadFile1(_file,"projectissuePic",String(dataString),"ajax/submit_issues.php");
	}
}

$(document).ready(function(){	
	$("#answerch").click(function(){
		$("#answerch").attr('disabled','disabled');
		var answerchal = convertSpecialChar($("#answerchal").val()) ;
		var answercid = $("#answercid").val() ;
		var pid = $("#prcid").val() ;
		// Returns successful data submission message when the entered information is stored in database.
		if (replaceAll('\\s', '',answerchal) == ""){
			bootstrap_alert(".alert_placeholder", "Answer can not be empty", 5000,"alert-warning");
			$("#answerch").removeAttr('disabled');
			return false ;
		}
		else {
			var dataString = 'answer='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',answerchal)))))
							+ '&cid='+ answercid + '&case=' + pid  ;
			//alert(dataString);
			var _file = document.getElementById('_fileanswer');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile1(_file,"answerPic",String(dataString),"ajax/submit_answer.php");
		}
	});

	var $table = $('table.scroll'),
	$bodyCells = $table.find('tbody tr:first').children(),
    colWidth;

	// Adjust the width of thead cells when window resizes
	$(window).resize(function() {
		// Get the tbody columns width array
		colWidth = $bodyCells.map(function() {
			return $(this).width();
		}).get();

		// Set the width of thead columns
		$table.find('thead tr').children().each(function(i, v) {
			$(v).width(colWidth[i]);
		});    
	}).resize();
		
	$('.tree-toggle').click(function () {
		$(this).parent().children('ul.tree').toggle(200);
	});	
    
    $('#example').removeClass( 'display' ).addClass('table table-striped table-bordered');	
});

function replaceAll(find, replace, str) {
	if(str == null){
		str = "";
	}
	return str.replace(new RegExp(find, 'g'), replace);
}

function show_form(type, ID){
	var dataString = 'form_type=' + type + '&project_id=' + ID ;
	$.ajax({
		type: "POST",
		url: "ajax/forms.php",
		data: dataString,
		async: false ,
		cache: false,
		success: function(result){
			$("#selecttext").hide();
			$("#invitation").show() ;
			document.getElementById("invitation").innerHTML = result ;
		}
	});
}

function show_form_pro(type, title, ID) {
	var dataString = 'form_type=' + type ;
	$.ajax({
		type: "POST",
		url: "ajax/forms.php",
		data: dataString,
		async: false ,
		cache: false,
		success: function(result){
			$("#selecttext").hide();
			$("#invitation").show() ;
			document.getElementById("invitation").innerHTML = result ;
			var temp = title + "_" + ID ;
			var elf = $('#elfinder').elfinder({
				url : 'php/connector.php?project_fd='+temp  // connector URL (REQUIRED)
			   // lang: 'ru',             // language (OPTIONAL)
			}).elfinder('instance');
		}
	});
}

function elf(title, ID){
	$("#invitation").show() ;
	var temp = title + "_" + ID ;
    var elf = $('#elfinder').elfinder({
		url : 'php/connector.php?project_fd='+temp  // connector URL (REQUIRED)
       // lang: 'ru',             // language (OPTIONAL)
    }).elfinder('instance');
}

function show_form_h(type){
	var dataString = 'form_type=' + type ;
	$.ajax({
		type: "POST",
		url: "ajax/forms.php",
		data: dataString,
		async: false ,
		cache: false,
		success: function(result){
			$("#textForm").hide();
			$("#remindervalue").show() ;
			document.getElementById("remindervalue").innerHTML = result ;
		}
	});
}

$(document).ready(function(){
//allPanels
	$("#eye_open").click(function(){
		$(".sign").show(1000);
		$(".deciduous").show(1000);
		$(".pushpin").show(1000);
		$(".videofilm").show(1000);
		$(".flag").show(1000);
		$(".asterisk").show(1000);
	});
	$("#sign").click(function(){
		$(".pushpin").hide(1000);
		$(".deciduous").hide(1000);
		$(".videofilm").hide(1000);
		$(".asterisk").hide(1000);
		$(".flag").hide(1000);
		$(".sign").show(1000);
		$("#viewprchid").val(2);
		getnextprchal('sign',2) ;
	});
	$("#deciduous").click(function(){
		$(".sign").hide(1000);
		$(".pushpin").hide(1000);
		$(".videofilm").hide(1000);
		$(".asterisk").hide(1000);
		$(".flag").hide(1000);
		$(".deciduous").show(1000);
		$("#viewprchid").val(3);
		getnextprchal('deciduous',3) ;
	});
	$("#pushpin").click(function(){
		$(".sign").hide(1000);
		$(".deciduous").hide(1000);
		$(".asterisk").hide(1000);
		$(".videofilm").hide(1000);
		$(".flag").hide(1000);
		$(".pushpin").show(1000);
		$("#viewprchid").val(4);
		getnextprchal('pushpin',4) ;
	});
	$("#flag").click(function(){
		$(".sign").hide(1000);
		$(".flag").show(1000);
		$(".videofilm").hide(1000);
		$(".asterisk").hide(1000);
		$(".pushpin").hide(1000);
		$(".deciduous").hide(1000);
		$("#viewprchid").val(5);
		getnextprchal('flag',5) ;
	});
	$("#filmprj").click(function(){
		$(".sign").hide(1000);
		$(".flag").hide(1000);
		$(".videofilm").show(1000);
		$(".pushpin").hide(1000);
		$(".asterisk").hide(1000);
		$(".deciduous").hide(1000);
		$("#viewprchid").val(6);
		getnextprchal('videofilm',6) ;
	});
	$("#asterisk").click(function(){
		$(".sign").hide(1000);
		$(".flag").hide(1000);
		$(".videofilm").hide(1000);
		$(".pushpin").hide(1000);
		$(".asterisk").show(1000);
		$(".deciduous").hide(1000);
		$("#viewprchid").val(7);
		getnextprchal('asterisk',7) ;
	});
});	
	
function create_team(){
	$("#create_team").attr('disabled','disabled');
	var team = $("#team_name_A").val() ;
	var email = $("#email_team").val() ;
	var ID = $("#ProjectIDValue").val() ;
	var newteam = document.getElementById("myteamname").innerHTML ;
	if(replaceAll('\\s', '',newteam) ==""){
		if(replaceAll('\\s', '',team) =="") {
			bootstrap_alert(".alert_placeholder", "Please Enter Team Name", 5000,"alert-warning");
			$("#create_team").removeAttr('disabled');
			return false ;
		}
		else if (replaceAll('\\s', '',email) == "") {
			bootstrap_alert(".alert_placeholder", "Please Enter Email_id", 5000,"alert-warning");
			$("#create_team").removeAttr('disabled');
			return false ;
		}
		else {
			submitTeam(team, email, ID) ;
		}
	}
	else {
		if(replaceAll('\\s', '',email) == "") {
			var dataString = 'team='+ newteam + '&project_id=' + ID ;
			$.ajax({
				type: "POST",
				url: "ajax/create_team_new.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("|+") ;
					if(notice['0'] == "Team Created Successfully !!!") {
						bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-success");
						$("#team_name_A").val("") ;
						$("#email_team").val("") ;
						$("#create_team").removeAttr('disabled');
						var data = "<div class\='span4' style\=' margin:4px; background : rgb(240, 241, 242);'>" +
									"<a class\='btn-link' onclick\='loadteampanel(\"" + ID + "\",\"" + team + "\")'>" + 
									team + "</a></div>" ;
						$("#ProjectTeams").append(data);
						$(".TeamName").hide();
						$("#team_name_A").show();
						document.getElementById("myteamname").innerHTML = "" ;
						$(".TeamMembers").empty();
						$("#AddTeam").modal("hide");
					}
					else{
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
						$("#create_team").removeAttr('disabled');
					}
				}				
			}) ;
		}
		else {
			submitTeam(newteam, email, ID) ;
		}
	}	
}

function submitTeam(team,email, ID) {
	$.ajax({
		type: "POST",
		url: "ajax/email.php",
		async: false ,
		data: 'email='+ email,
		cache: false,
		success: function(result){
			//alert(result);
			if (result == 'true') {
				var dataString = 'team='+ team + '&email='+ email + '&project_id=' + ID ;
				$.ajax({
					type: "POST",
					url: "ajax/create_team_new.php",
					async: false ,
					data: dataString,
					cache: false,
					success: function(result){
						var notice = result.split("|+") ;
						if(notice['0'] == "Team Created Successfully !!!") {
							bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-success");
							$("#team_name_A").val("") ;
							$("#email_team").val("") ;
							$("#create_team").removeAttr('disabled');
							var data = "<div class\='span4' style\=' margin:4px; background : rgb(240, 241, 242);'>" +
										"<a class\='btn-link' onclick\='loadteampanel(\"" + team + "\")'>" + 
										team + "</a></div>" ;
							$("#ProjectTeams").append(data);
							$(".TeamName").hide();
							$("#team_name_A").show();
							document.getElementById("myteamname").innerHTML = "" ;
							$(".TeamMembers").empty();
							$("#AddTeam").modal("hide");
						}
						else{
							bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
							$("#create_team").removeAttr('disabled');
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
				var modal = "<h4>Hi, It looks like s/he is not here Lets intivite her/him</h4>" + "<table><tbody>" +
							"<tr><td><div class\='input-group'><span class\='input-group-addon'>His/Her First Name</span></td>" +
							"<td><input type='text' class='input-block-level' id='fnameteam' placeholder='His First Name'></div></td></tr> " +
							"<tr><td><div class\='input-group'><span class\='input-group-addon'>His/Her Second Name</span></td>" +
							"<td><input type='text' class='input-block-level' id='snameteam' placeholder='His Second Name'></div></td></tr> " + 
							"<tr><td><div class\='input-group'><span class\='input-group-addon'>His/Her Email ID</span></td>" +
							"<td><input type='text' class='input-block-level' id='teamemail' value=\'" + email + "\' /></div></td></tr></tbody></table>" +
							"<input type='submit' class\='btn btn-success' id='invitememberpr' onclick ='invitememberpr("+ team +","+ ID +")' value='Invite Him/Her' /> <br/> ";
					//bootstrap_alert(".alert_placeholder", modal, 600000,"alert-info");
				document.getElementById("create_team_modal").innerHTML =  modal;
				return false ;
			}
		}
   });
}

function invitememberpr(team, ID){
	$("#invitememberpr").attr('disabled','disabled');
	var fname = $("#fnameteam").val() ;
	var sname = $("#snameteam").val() ;
	var email = $("#teamemail").val() ;
	if(replaceAll('\\s', '',fname) =="") {
		bootstrap_alert(".alert_placeholder", "Please Enter First Name", 5000,"alert-warning");
		$("#invitememberpr").removeAttr('disabled');
		return false ;
	}
	else if (replaceAll('\\s', '',sname) == "") {
		bootstrap_alert(".alert_placeholder", "Please Enter Second Name", 5000,"alert-warning");
		$("#invitememberpr").removeAttr('disabled');
		return false ;
	}
	else if (replaceAll('\\s', '',email) == "") {
		bootstrap_alert(".alert_placeholder", "Please Enter Email-ID", 5000,"alert-warning");
		$("#invitememberpr").removeAttr('disabled');
		return false ;
	}
	else {
		$.ajax({
			type: "POST",
			url: "ajax/email.php",
			async: false ,
			data: 'email='+ email,
			cache: false,
			success: function(result){
				if (result == 'false') {
					var dataString = 'fname='+ fname + '&sname='+ sname + '&email='+ email + '&team=' + team + '&project_id=' + ID ;
					$.ajax({
						type: "POST",
						url: "ajax/send_invitation.php",
						async: false ,
						data: dataString,
						cache: false,
						success: function(result){
							bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
							if(result == "Invitation Send Successfully !!!") {
								$("#fnameteam").val("") ;
								$("#snameteam").val("") ;
								$("#teamemail").val("") ;
								location.reload();							
							}
						}	
					});
					$("#invitememberpr").removeAttr('disabled');
				}
				else {
					bootstrap_alert(".alert_placeholder", "Please Enter Valid Email-ID", 5000,"alert-warning");
					$("#invitememberpr").removeAttr('disabled');
					return false ;							
				}
			}
		});
	}
}

function CreateTeamMember(userid){
	$("#create_team").attr('disabled','disabled');
	var team = $("#team_name_A").val() ;
	var ID = $("#ProjectIDValue").val() ;
	if(replaceAll('\\s', '',team) == "") {
		var newteam = document.getElementById("myteamname").innerHTML ;
		if(replaceAll('\\s', '',newteam) ==""){
			bootstrap_alert(".alert_placeholder", "Please Enter Team Name", 5000,"alert-warning");
			$("#create_team").removeAttr('disabled');
			return false ;
		}
		else {
			var dataString = 'team='+ newteam + '&userid='+ userid + '&project_id=' + ID ;
			$.ajax({
				type: "POST",
				url: "ajax/create_team_new.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("|+") ;
					if(notice['0'] == "Team Created Successfully !!!") {
						bootstrap_alert(".alert_placeholder", "Member Addad", 5000,"alert-success");
						$("#username_"+userid).hide();
						$(".TeamMembers").append(notice['1']);
						$("#create_team").removeAttr('disabled');						
					}
					else{
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
						$("#create_team").removeAttr('disabled');
					}
				}				
			}) ;
		}
	}
	else {
		var dataString = 'team='+ team + '&userid='+ userid + '&project_id=' + ID ;
		$.ajax({
			type: "POST",
			url: "ajax/create_team_new.php",
			async: false ,
			data: dataString,
			cache: false,
			success: function(result){
				var notice = result.split("|+") ;
				if(notice['0'] = "Team Created Successfully !!!") {
					bootstrap_alert(".alert_placeholder", "Member Addad", 5000,"alert-success");
					$("#username_"+userid).hide();
					$(".TeamName").show();
					$("#team_name_A").hide();
					document.getElementById("myteamname").innerHTML = team ;
					$(".TeamMembers").append(notice['1']);
					$("#create_team").removeAttr('disabled');
					
				}
				else{
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
					$("#create_team").removeAttr('disabled');
				}
			}				
		}) ;
	} 
}
	
function invitememb(ID){
	$("#invitememb").attr('disabled','disabled');
	var fname = $("#fnameteam").val() ;
	var sname = $("#snameteam").val() ;
	var email = $("#teamemail").val() ;
	if(replaceAll('\\s', '',fname) =="") {
		bootstrap_alert(".alert_placeholder", "Please Enter First Name", 5000,"alert-warning");
		$("#invitememb").removeAttr('disabled');
		return false ;
	}
	else if (replaceAll('\\s', '',sname) == "") {
		bootstrap_alert(".alert_placeholder", "Please Enter Second Name", 5000,"alert-warning");
		$("#invitememb").removeAttr('disabled');
		return false ;
	}
	else if (replaceAll('\\s', '',email) == "") {
		bootstrap_alert(".alert_placeholder", "Please Enter Email-ID", 5000,"alert-warning");
		$("#invitememb").removeAttr('disabled');
		return false ;
	}
	else {
		$.ajax({
			type: "POST",
			url: "ajax/email.php",
			async: false ,
			data: 'email='+ email,
			cache: false,
			success: function(result){
				if (result == 'false') {
					var dataString = 'fname='+ fname + '&sname='+ sname + '&email='+ email + '&project_id=' + ID ;
					$.ajax({
						type: "POST",
						url: "ajax/send_invitation.php",
						async: false ,
						data: dataString,
						cache: false,
						success: function(result){
							bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
							if(result = "Invitation Send Successfully !!!") {
								$("#fnameteam").val("") ;
								$("#snameteam").val("") ;
								$("#teamemail").val("") ;
								location.reload();	
							}
						}				
					});
					$("#invitememb").removeAttr('disabled');
				}
				else {
					bootstrap_alert(".alert_placeholder", "Please Enter Valid Email-ID", 5000,"alert-warning");
					$("#invitememb").removeAttr('disabled');
					return false ;							
				}
			}
		});
	}
}

function getnextprchal(clas, int) {
	$('#prch').append("<div class='loading'><center><img src='img/loading.gif' /></center><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>");
	var numItems = $('div.'+clas).length;
	if (numItems < 3) {
		var ID = $("#ProjectIDValue").val() ;
		var dataString = 'proch=5' + '&project_id=' + ID ;
		$.ajax({
				type: "POST",
				url: "ajax/next_proch.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("<") ;
					if (notice['0'] == 'no data') {
						$('.loading').remove();
						var data = document.getElementById("appendloading") ;
						if(data == null) {
							$('#prch').append("<div id='appendloading'><br/><br/><center style='font-size:24px;'> Whooo... You have read all Posts </center></div>");
						}
					}
					else {
						$('#prch').append(result);
						$('.loading').remove();
						showprclass(int) ;
						var numItem = $('div.'+clas).length;
						if (numItem < 3) {
							getnextprchal(clas, int) ;
						}
					}
				}
			});
	}
}

function showprclass(int) {
	switch(int){
		case 1:
			$(".sign").show(1000);
			$(".deciduous").show(1000);
			$(".pushpin").show(1000);
			$(".videofilm").show(1000);
			$(".flag").show(1000);
			$(".asterisk").show(1000);
			break;
			
		case 2:
			$(".pushpin").hide(1000);
			$(".deciduous").hide(1000);
			$(".videofilm").hide(1000);
			$(".asterisk").hide(1000);
			$(".flag").hide(1000);
			$(".sign").show(1000);
			break;
			
		case 3:
			$(".pushpin").hide(1000);
			$(".deciduous").show(1000);
			$(".videofilm").hide(1000);
			$(".asterisk").hide(1000);
			$(".flag").hide(1000);
			$(".sign").hide(1000);
			break;
			
		case 4:
			$(".pushpin").show(1000);
			$(".deciduous").hide(1000);
			$(".videofilm").hide(1000);
			$(".asterisk").hide(1000);
			$(".flag").hide(1000);
			$(".sign").hide(1000);
			break;
			
		case 5:
			$(".pushpin").hide(1000);
			$(".deciduous").hide(1000);
			$(".videofilm").hide(1000);
			$(".asterisk").hide(1000);
			$(".flag").show(1000);
			$(".sign").hide(1000);
			break;
			
		case 6:
			$(".pushpin").hide(1000);
			$(".deciduous").hide(1000);
			$(".videofilm").show(1000);
			$(".asterisk").hide(1000);
			$(".flag").hide(1000);
			$(".sign").hide(1000);
			break;
			
		case 7:
			$(".pushpin").hide(1000);
			$(".deciduous").hide(1000);
			$(".videofilm").hide(1000);
			$(".asterisk").show(1000);
			$(".flag").hide(1000);
			$(".sign").hide(1000);
			break;
	}
}
