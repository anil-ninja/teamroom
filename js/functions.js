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
		var dataString = 'id='+ ID + '&case=8';
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
function add_member(PID, name) {
	var email = $("#email_add_member").val() ;
    var dataString = 'email='+ email + '&id='+ PID + '&name='+ name + '&case=1';
    if (email == "") {
         bootstrap_alert(".alert_placeholder", "Email can't be empty", 5000,"alert-success");
         }
         else {
			 $.ajax({
				type: "POST",
				url: "ajax/email.php",
				data: 'email='+ email,
				cache: false,
				success: function(result){
					if (result == "true") {
						$.ajax({
							type: "POST",
							url: "ajax/add_member_team.php",
							data: dataString,
							cache: false,
							success: function(result){
								var notice = result.split("+") ;
								if(notice['0'] == 'Member Added succesfully!'){
									bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-success");
									$('.team-member').append(notice['1']);
									$("#email_add_member").val("") ;
									}
									else {
										bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-warning");
										}
								}
							});
						}
						else {
							bootstrap_alert(".alert_placeholder", "Please Enter Valid Email-ID", 5000,"alert-warning");
							$("#invitemember").removeAttr('disabled');
							return false ;							
							}
					}
				});
		}
}
function loadteampanel(team) {
	var dataString = 'team=' + team ;
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
		var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',project))))
						+ '&case=' + type ;
		if(project == ""){
			return false ;
			}
				else {
					$.ajax({
						type: "POST",
						url: "ajax/submit_comment.php",
						data: dataString,
						cache: false,
						success: function(result){
							var notice = result.split("+") ;
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
			var dataString = 'id='+ ID + '&case=' + type ;
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
			var dataString = 'id='+ ID + '&case=' + type ;
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
		   bootbox.confirm("Really Join This Project !!!", function(result) {
		if(result){
			var dataString = 'id='+ ID + '&case=4';
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
	if (uid == '') {
		var nied = 1 ;
		}
		else {
			var nied = parseInt(parseInt(uid)+1) ;
			}
	var dataString = 'id='+ Id + '&case=' + type ;
			$.ajax({
				type: "POST",
				url: "ajax/likes.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					if(result == 'Posted successfully') {
						$("#likes_"+Id).val(nied+='') ;
					}
					else if(result == 'Please Log In First') {
						test() ;
					}
					else {
						bootstrap_alert(".alert_placeholder",result, 3000,"alert-warning");
					}
				}
			});
	}
function dislike(Id, type) {
	var uid = $("#dislikes_"+Id).val() ;
	if (uid == '') {
		var nied = 1 ;
		}
		else {
			var nied = parseInt(parseInt(uid)+1) ;
			}
	var dataString = 'id='+ Id + '&case=' + type ;
			$.ajax({
				type: "POST",
				url: "ajax/likes.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result == 'Posted successfully') {
						$("#dislikes_"+Id).val(nied+='') ;
					}
					else if(result == 'Please Log In First') {
						test() ;
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
	if(reminder==''){
		bootstrap_alert(".alert_placeholder", "Reminder can not be empty", 5000,"alert-warning");
		return false;
	}
	else if (eventtime == "") {
		bootstrap_alert(".alert_placeholder", "Please Select Date and Time ", 5000,"alert-warning");
		return false;
		}
	 else {
	var dataString = 'reminder='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',reminder)))) + '&eventtime='+ eventtime + '&self='+ self ;
	$.ajax({
		type: "POST",
		url: "ajax/submit_reminder.php",
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
