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
					alert(result);
					if (result == 'false') {
						$.ajax({
							type: "POST",
							url: "ajax/add_member_team.php",
							data: dataString,
							cache: false,
							success: function(result){
								if(result=='Member Added succesfully!'){
									bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
									location.reload();
									}
									else {
										bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
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
 function remove_member(PID, name, Uid){
	bootbox.confirm("Do u really want to Remove this member?", function(result) {
		if(result){
			var dataString = 'email=' + Uid + '&id='+ PID + '&name='+ name + '&case=2';
			alert(dataString) ;
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
function comment(ID, type) {				
		var project = convertSpecialChar($("#own_ch_response_"+ID).val());
		//alert(ID) ;
		var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',project))))
						+ '&case=' + type ;
		//alert(dataString) ;
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
							//alert(notice['1']);
							if(notice['1']== 'Posted succesfully!'){
							$("#own_ch_response_"+ID).val('') ;
							$('.comments_'+ID).append(notice['0']);
							}
						}
					});
				}
} ;
function commentprch(ID, PID) {				
		var project = convertSpecialChar($("#own_ch_response_"+ID).val());
		//alert(ID) ;
		var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',project))))
							+ '&pid='+ PID + '&case=3';
		//alert(dataString) ;
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
							//alert(notice['1']);
							if(notice['1']== 'Posted succesfully!'){
							$("#own_ch_response_"+ID).val('') ;
							$('.comments_'+ID).append(notice['0']);
							}
						}
					});
				}
} ;
function accept_pub(ID){
	//alert(ID) ;
		   bootbox.confirm("Really Accept Challenge !!!", function(result) {
		if(result){
			var dataString = 'id='+ ID + '&case=2';
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
function accept_pubpr(ID, PID){
	//alert(ID) ;
		   bootbox.confirm("Really Accept Challenge !!!", function(result) {
		if(result){
			var dataString = 'id='+ ID + '&pid='+ PID + '&case=5';
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
function closechal(ID){
	//alert(ID) ;
		   bootbox.confirm("Really Close Challenge !!!", function(result) {
		if(result){
			var dataString = 'id='+ ID + '&case=3';
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
function closechalpr(ID, PID){
	//alert(ID) ;
		   bootbox.confirm("Really Close Challenge !!!", function(result) {
		if(result){
			var dataString = 'id='+ ID + '&pid='+ PID + '&case=6';
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
	//alert(ID) ;
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
function answersubmit(chelangeid){
	bootbox.confirm("Completed Challenge !!!", function(result) {
		if(result){
			$("#answercid").val(chelangeid) ;
			$("#answerForm").modal("show");
			}
		});
} ;
function answersubmitpr(chelangeid, PID){
	bootbox.confirm("Completed Challenge !!!", function(result) {
		if(result){
			$("#answercidpr").val(chelangeid) ;
			$("#prcid").val(PID) ;
			$("#answerFormpr").modal("show");
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
					else {
						bootstrap_alert(".alert_placeholder", "Already Liked", 3000,"alert-warning");
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
					else {
						bootstrap_alert(".alert_placeholder", "Already Liked", 3000,"alert-warning");
						}
				}
			});
	}
function likepr(Id, PID) {
	var uid = $("#likes_"+Id).val() ;
	if (uid == '') {
		var nied = 1 ;
		}
		else {
			var nied = parseInt(parseInt(uid)+1) ;
			}
	var dataString = 'id='+ Id + '&pid=' + PID + '&case=3';
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
					else {
						bootstrap_alert(".alert_placeholder", "Already Liked", 3000,"alert-warning");
						}
				}
			});
	}
function dislikepr(Id, PID) {
	var uid = $("#dislikes_"+Id).val() ;
	if (uid == '') {
		var nied = 1 ;
		}
		else {
			var nied = parseInt(parseInt(uid)+1) ;
			}
	var dataString = 'id='+ Id + '&pid=' + PID + '&case=4' ;
			$.ajax({
				type: "POST",
				url: "ajax/likes.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result == 'Posted successfully') {
						$("#dislikes_"+Id).val(nied+='') ;
					}
					else {
						bootstrap_alert(".alert_placeholder", "Already Liked", 3000,"alert-warning");
						}
				}
			});
	}
function replaceAll(find, replace, str) {
	return str.replace(new RegExp(find, 'g'), replace);
}
