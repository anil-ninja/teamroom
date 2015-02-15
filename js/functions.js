function convertSpecialChar(str){
	return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
}
function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};
function onLoaddata(){
	$(".editbox").hide();
	$(".text").show();
}
function knownperson(ID){
	bootbox.confirm("Really Know this Person !!!", function(result) {
	if(result){
		var dataString = 'id='+ ID + '&case=1';
		$.ajax({
			type: "POST",
			url: "ajax/knownperson.php",
			data: dataString,
			cache: false,
			success: function(result){
				if(result=='Request send succesfully'){
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
				}
				else {
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
				}
			}
		 });
		}
	});
} ;
function requestaccept(ID) {
	bootbox.confirm("Do You Know this Person !!!", function(result) {
	if(result){
		var dataString = 'id='+ ID + '&case=7';
		$.ajax({
			type: "POST",
			url: "ajax/knownperson.php",
			data: dataString,
			cache: false,
			success: function(result){
				if(result=='Request Accepted succesfully!'){
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					}
					else {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
					}
				}
			});
		}
	});
}
function requestdelete(ID) {
	bootbox.confirm("Delete Request !!!", function(result) {
	if(result){
		var dataString = 'id=' + ID + '&case=8';
		$.ajax({
			type: "POST",
			url: "ajax/knownperson.php",
			data: dataString,
			cache: false,
			success: function(result){
				if(result=='Request Deleted succesfully!'){
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					}
					else {
						bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
						}
				}
			});
		}
	});
}
function add_member() {
	$("#add_member").attr('disabled','disabled');
	var email = $("#email_add_member").val() ;
	var PID = $("#ProjectIDValue").val() ;
	var name = document.getElementById("teamname").innerHTML ;
	var data = document.getElementById("TeamMembers").innerHTML ;
    var dataString = 'email='+ email + '&id='+ PID + '&name='+ name + '&case=1';
    if (replaceAll('\\s', '',email) == "") {
		if (data == ""){
			bootstrap_alert(".alert_placeholder", "Email can't be empty", 5000,"alert-success");
			$("#add_member").removeAttr('disabled');
		}
		else {
			$("#add_member").removeAttr('disabled');
			document.getElementById("TeamMembers").innerHTML = "" ;
			$("#AddMember").modal("hide");
			return false ;
		}
    }
    else {
		$.ajax({
			type: "POST",
			url: "ajax/email.php",
			async: false ,
			data: 'email='+ email,
			cache: false,
			success: function(result){
				if (result == "true") {
					$.ajax({
						type: "POST",
						url: "ajax/add_member_team.php",
						async: false ,
						data: dataString,
						cache: false,
						success: function(result){
							var notice = result.split("|+") ;
							if(notice['0'] == 'Member Added succesfully!'){
								bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-success");
								$('.team-member').append(notice['1']);
								$("#email_add_member").val("") ;
								$("#add_member").removeAttr('disabled');
								document.getElementById("TeamMembers").innerHTML = "" ;
								$("#AddMember").modal("hide");
							}
							else {
								bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-warning");
								$("#add_member").removeAttr('disabled');
							}
						}
					});
				}
				else {
					bootstrap_alert(".alert_placeholder", "Please Enter Valid Email-ID", 5000,"alert-warning");
					$("#add_member").removeAttr('disabled');
					return false ;							
				}
			}
		});
	}
}
function AddTeamMember(userid){
	$("#add_member").attr('disabled','disabled');
	var ID = $("#ProjectIDValue").val() ;
	var newteam = document.getElementById("teamname").innerHTML ;
	var dataString = 'team='+ newteam + '&userid='+ userid + '&project_id=' + ID ;
	$.ajax({
		type: "POST",
		url: "ajax/add_member_new.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			var notice = result.split("|+") ;
			if(notice['0'] == "Added") {
				bootstrap_alert(".alert_placeholder", "Member Addad", 5000,"alert-success");
				$("#member_"+userid).hide();
				$(".TeamMembers").append(notice['1']);
				$(".team-member").append(notice['1']);
				$("#add_member").removeAttr('disabled');						
			}
			else if(notice['0'] == "Updated") {
				bootstrap_alert(".alert_placeholder", "Member Addad", 5000,"alert-success");
				$("#member_"+userid).hide();
				$(".TeamMembers").append(notice['1']);
				$("#add_member").removeAttr('disabled');						
			}
			else {
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
				$("#add_member").removeAttr('disabled');
			}
		}				
	});
}
function add_Team_Member(team) {
	document.getElementById("teamname").innerHTML = team ;
	$.ajax({
		type: "POST",
		url: "ajax/project_join.php",
		async: false ,
		data: "type=3",
		cache: false,
		success: function(result){
			var data = $(".membersAddModal").html() ;
			if(replaceAll('\\s', '',data) == "") {
				$(".membersAddModal").append(result);
			}
			else {
				$(".membersAddModal")[0].innerHTML = "" ;
				$(".membersAddModal").append(result);
			}
		}
	});
	$("#AddMember").modal("show");
}
function add_New_Team() {
	$.ajax({
		type: "POST",
		url: "ajax/project_join.php",
		async: false ,
		data: "type=4",
		cache: false,
		success: function(result){
			var data = $(".teamAddModal").html() ;
			if(replaceAll('\\s', '',data) == "") {
				$(".teamAddModal").append(result);
			}
			else {
				//data[0].innerHTML = '';
				$(".teamAddModal")[0].innerHTML = "" ;
				$(".teamAddModal").append(result);
			}
		}
	});
	$("#AddTeam").modal("show");
}
function loadteampanel(ID, team) { add_New_Team
	var dataString = 'team=' + team + '&project_id=' + ID ;
	$.ajax({
		type: "POST",
		url: "ajax/team_panel_load.php",
		data: dataString,
		async: false ,
		cache: false,
		success: function(result){
			document.getElementById("teams_project_content").innerHTML = result;
		}
	});
} 
function remove_member(PID, name, Uid){
	bootbox.confirm("Do u really want to Remove this member?", function(result) {
		if(result){
			var dataString = 'email=' + Uid + '&id='+ PID + '&name='+ name + '&case=2';
			$.ajax({
				type: "POST",
				url: "ajax/add_member_team.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result=='Member Removed succesfully!') {
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
function comment(ID, type) {				
	var project = convertSpecialChar($("#own_ch_response_"+ID).val());
	var IDPr = $("#ProjectIDValue").val() ;
	var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',project)))))
					+ '&case=' + type + '&project_id=' + IDPr ;
	if(replaceAll('\\s', '',project) == ""){
		return false ;
	}
	else {
		$.ajax({
			type: "POST",
			url: "ajax/submit_comment.php",
			async: false ,
			data: dataString,
			cache: false,
			success: function(result){
				var notice = result.split("|+") ;
				if(notice['1']== 'Posted succesfully!'){
					$("#own_ch_response_"+ID).val('') ;
					$('.comments_'+ID).append(notice['0']);
				}
			}
		});
	}
} ;
function accept_pub(ID, type){
	bootbox.confirm("Really Accept Challenge !!!", function(result) {
		if(result){
			var IDPr = $("#ProjectIDValue").val() ;
			var dataString = 'id='+ ID + '&case=' + type + '&project_id=' + IDPr ;
			$.ajax({
				type: "POST",
				url: "ajax/knownperson.php",
				data: dataString,
				cache: false,
				success: function(result){
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					location.reload() ;
				}
			});
		}
	});
} ;
function closechal(ID, type){
	bootbox.confirm("Really Close Challenge !!!", function(result) {
		if(result){
			var IDPr = $("#ProjectIDValue").val() ;
			var dataString = 'id='+ ID + '&case=' + type + '&project_id=' + IDPr ;
			$.ajax({
				type: "POST",
				url: "ajax/knownperson.php",
				data: dataString,
				cache: false,
				success: function(result){
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					location.reload() ;
				}
			});
		}
	});
} ;
function joinproject(ID){
	$("#joinproject").attr('disabled','disabled');
	var dataString = 'id='+ ID + '&case=4';
	$.ajax({
		type: "POST",
		url: "ajax/knownperson.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
			$(".joinproject").remove();
			//location.reload() ;
		}
	});
}
function answersubmit(chelangeid, type){
	bootbox.confirm("Completed Challenge !!!", function(result) {
		if(result){
			$("#answercid").val(chelangeid) ;
			$("#prcid").val(type) ;
			$("#answerForm").modal("show");
		}
	});
} ;
function like(Id, type) {
	var uid = $("#likes_"+Id).val() ;
	var IDPr = $("#ProjectIDValue").val() ;
	if (replaceAll('\\s', '',uid) == '') {
		var nied = 1 ;
	}
	else {
		var nied = parseInt(parseInt(uid)+1) ;
	}
	var dataString = 'id='+ Id + '&case=' + type + '&project_id=' + IDPr ;
	$.ajax({
		type: "POST",
		url: "ajax/likes.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			//alert(result) ;
			if(result == 'Posted successfully') {
				$("#likes_"+Id).val(nied+='') ;
			}
			else if(result == 'Please Log In First') {
				test3() ;
			}
			else {
				bootstrap_alert(".alert_placeholder",result, 3000,"alert-warning");
			}
		}
	});
}
function dislike(Id, type) {
	var uid = $("#dislikes_"+Id).val() ;
	var IDPr = $("#ProjectIDValue").val() ;
	if (replaceAll('\\s', '',uid) == '') {
		var nied = 1 ;
	}
	else {
		var nied = parseInt(parseInt(uid)+1) ;
	}
	var dataString = 'id='+ Id + '&case=' + type + '&project_id=' + IDPr ;
	$.ajax({
		type: "POST",
		url: "ajax/likes.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			if(result == 'Posted successfully') {
				$("#dislikes_"+Id).val(nied+='') ;
			}
			else if(result == 'Please Log In First') {
				test3() ;
			}
			else {
				bootstrap_alert(".alert_placeholder", "Already Disliked", 3000,"alert-warning");
			}
		}
	});
}
function replaceAll(find, replace, str) {
	return str.replace(new RegExp(find, 'g'), replace);
}
function set_remind() {
	var reminder = convertSpecialChar($("#reminder_message").val()) ;
	var self = $("#self_remind").val() ;
	var eventtime = $("#datepick").val() ;
	if(replaceAll('\\s', '',reminder)==''){
		bootstrap_alert(".alert_placeholder", "Reminder can not be empty", 5000,"alert-warning");
		return false;
	}
	else if (replaceAll('\\s', '',eventtime) == "") {
		bootstrap_alert(".alert_placeholder", "Please Select Date and Time ", 5000,"alert-warning");
		return false;
		}
	else {
		var dataString = 'reminder='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',reminder))))) + '&eventtime='+ eventtime + '&self='+ self ;
		$.ajax({
			type: "POST",
			url: "ajax/submit_reminder.php",
			async: false ,
			data: dataString,
			cache: false,
			success: function(result){
				if(result=='Reminder Set succesfully!'){
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					$("#reminder_message").val("") ;
					$("#self_remind").val("") ;
					$("#datepick").val("") ;
					location.reload();
				}
				else {
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
					return false;
				}
			}
		});
	}	
}
function invest() {
	$("#invest").attr('disabled','disabled');
	var amount = $("#fund_amount").val() ;
	var IDPr = $("#ProjectIDValue").val() ;
	if(replaceAll('\\s', '',amount)==''){
		bootstrap_alert(".alert_placeholder", "Amount can not be empty", 5000,"alert-warning");
		return false;
	}
	else {
		var dataString = 'amount='+ amount + '&pro_id='+ IDPr ;
		$.ajax({
			type: "POST",
			url: "ajax/fund_info.php",
			async: false ,
			data: dataString,
			cache: false,
			success: function(result){
				if(result=='Sucessfull!'){
					bootstrap_alert(".alert_placeholder", "We will follow up you soon", 5000,"alert-success");
					setTimeout(function() { location.reload(); }, 3000);
				}
				else {
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
					return false;
				}
			}
		});
	}
}
function projectToJoin(){
	$.ajax({
		type: "POST",
		url: "ajax/project_join.php",
		async: false ,
		data: "type=1",
		cache: false,
		success: function(result){
			var data = $(".insertprojects").html() ;
			//alert(data);
			if(replaceAll('\\s', '',data) == "") {
				$(".insertprojects").append(result);
			}
		}
	});
	$("#joinProject").modal("show");
}
function TypeProject() {
	$("#TypeProject").attr('disabled','disabled');
	var value = convertSpecialChar($("#newproject_value").val());
	var fund = convertSpecialChar($("#newproject_fundneed").val());
	var type = $("#newtype").val();
	var typeA = document.getElementById("newfundProject").checked;
	var IDPr = $("#ProjectIDValue").val() ;
	if (type == '0') {
		bootstrap_alert(".alert_placeholder", "Please select Project type", 5000,"alert-warning");
		$("#TypeProject").removeAttr('disabled');
	}
	else if(typeA != false){
		if(replaceAll('\\s', '',value) == "") {
			bootstrap_alert(".alert_placeholder", "Value can not be empty", 5000,"alert-warning");
			$("#TypeProject").removeAttr('disabled');
		}
		else if(replaceAll('\\s', '',fund) == "") {
			bootstrap_alert(".alert_placeholder", "Fund can not be empty", 5000,"alert-warning");
			$("#TypeProject").removeAttr('disabled');
		}
		else {
			var dataString = 'type=5' + '&pro_id=' + IDPr + '&prjtype='+ type + '&value='+ value + '&fund='+ fund ;
			changetype(dataString);
		}
	}
	else {
		var dataString = 'type=5' + '&pro_id=' + IDPr + '&prjtype='+ type + '&value='+ value + '&fund='+ fund ;
		changetype(dataString);
	}
}
function changetype(dataString) {
	$.ajax({
		type: "POST",
		url: "ajax/project_join.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			if(result == 'Changed successfully') {
				bootstrap_alert(".alert_placeholder",result, 3000,"alert-success");
				location.reload();
			}
			else {
				bootstrap_alert(".alert_placeholder",result, 3000,"alert-warning");
			}
		}
	});
}
function projectjoin(ID){
	var dataString = 'type=2'+ '&pro_id='+ ID ;
	$.ajax({
		type: "POST",
		url: "ajax/project_join.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			if(result== 'Joined succesfully!'){
				$('#poject_'+ID).remove();
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
			}
			else {
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
			}
		}
	});
} 
function create_link() {
	$("#create_link").attr('disabled','disabled');
	var challenge = $("#sharedlink").val() ;
	if(replaceAll('\\s', '',challenge) == ""){
		bootstrap_alert(".alert_placeholder", "Link can not be empty", 5000,"alert-warning");
		$("#create_link").removeAttr('disabled');
		return false;
	}
	else {
		$('#remindervalue').append("<div class='loading'><center><img src='img/loading.gif' /></center><br/></div>");
		$('#invitation').append("<div class='loading'><center><img src='img/loading.gif' /></center><br/></div>");
		getUrlData(challenge);
	}
};
