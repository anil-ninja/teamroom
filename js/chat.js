function chatform(userid , username){
	$("#chatform").show();
	$("#chatformdata").show();
	$("#chatformin").show();
	$("#talkFormproject").hide();
	$("#chatformdata").scrollTop($('#chatformdata').height()) ;
	//var username = $("#friendname").val() ;
	//var userid = parseInt($("#friendid").val()) ;
	//alert (userid) ;
	var dataString = 'name='+ username + '&fid='+ userid ;
	$.ajax({
		type: "POST",
		url: "ajax/chatting.php",
		data: dataString,
		cache: false,
		success: function(result){
			var notice = result.split("+") ;
			var neid = parseInt(notice['2']) ;
			document.getElementById("showchatting").innerHTML = notice['0'];
			document.getElementById("showchattingform").innerHTML = notice['1'];
			//document.getElementById("lastchatid").innerHTML = neid+='';
			$("#lastchatid").val(neid+='') ;
		}
	});
	setInterval(function(){ getnewmessages(userid , username) },3000)();
};
function getnewtalk() {	
	var uid = parseInt($("#lastprchatid").val()) ;
	var dataString = 'talks='+ uid  ;
			$.ajax({
				type: "POST",
				url: "ajax/protalk.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					var notice = result.split("+") ;
					var neid = parseInt(notice['1']) ;
					//alert(neid) ;
					$('.newtalkspr').append(notice['0']);
					//$("#chatformdata").scrollTop($('#chatformdata').height()) ;
					if (neid+='' != 0) {
							$("#lastprchatid").val(neid+='') ;
						}
				}
			});
}
function getnewreminder() {	
	var uid = parseInt($("#lastreminderid").val()) ;
	//alert(uid) ;
	var dataString = 'reminders='+ uid  ;
			$.ajax({
				type: "POST",
				url: "ajax/newreminders.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					var notice = result.split("+") ;
					var neid = parseInt(notice['1']) ;
					//alert(neid) ;
					$('.newreminders').append(notice['0']);
					//$("#chatformdata").scrollTop($('#chatformdata').height()) ;
					if (neid+='' != "0") {
							$("#lastreminderid").val(neid+='') ;
						}
				}
			});
}
$("#changeremindervalue").click(function(){
      		//$("#create_video").attr('disabled','disabled');
			var reminder = $("#newremindervalue").val() ;
			var date = $("#datepicker").val() ;
			var value = $("#datepickervalue").val() ;
			//alert(value) ;
			if(reminder == "") {
					var dataString = 'value='+ value + '&date='+ date + '&case=3' ;
				}
				else if (date == "") {
					var dataString = 'value='+ value + '&reminder='+ reminder + '&case=2' ;
					}
					else if(reminder == "" || date == "") {
						location.reload() ;
						return false ;
						}
						else {
							var dataString = 'value='+ value + '&date='+ date + '&reminder='+ reminder + '&case=1' ;
							}
			$.ajax({
				type: "POST",
				url: "ajax/change_reminder.php",
				data: dataString,
				cache: false,
				success: function(result){
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result = "Changed Successfully !!!") {
						location.reload() ;
						$("#datepicker").val("") ;
						$("#datepickervalue").val("") ;
						$("#newremindervalue").val("") ;
						}
					}
				  });	
		});
function editreminder(id) {
	$("#datepickervalue").val(id) ;
	$("#changeremindervalues").modal("show");
	$("#challegeForm").hide();
	$("#PictureForm").hide();
	$("#selecttext").hide();
	$("#VideoForm").hide();
	$("#ArticleForm").hide();
	$("#IdeaForm").hide();
}
function getallreminders() {	
	var dataString = 'reminder=true'  ;
			$.ajax({
				type: "POST",
				url: "ajax/reminders.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					var notice = result.split("+") ;
					var neid = parseInt(notice['1']) ;
					//alert(neid) ;
					document.getElementById("allreminders").innerHTML = notice['0'];
					//$("#chatformdata").scrollTop($('#chatformdata').height()) ;
					$("#lastreminderid").val(neid+='') ;
				}
			});
	setInterval(function(){ getnewreminder() },400000)();
}
function closechat() {
	$("#chatform").hide();
	$("#chatformdata").hide();
	$("#chatformin").hide();
	$("#talkFormproject").show();
} ;
function submittalk() {
	var pr_resptalk = $("#pr_resptalk").val() ;
	if(pr_resptalk==''){
		bootstrap_alert(".alert_placeholder", "Enter Something", 5000,"alert-warning");
		return false;
	}
	 else {
		var dataString = 'talk='+ pr_resptalk ;
		$.ajax({
			type: "POST",
			url: "ajax/project_talks.php",
			data: dataString,
			cache: false,
			success: function(result){
				//alert(result);
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
				if(result=='Posted succesfully!'){
					$("#pr_resptalk").val("") ;
					getnewtalk() ;
				}
			}
		 });
	}	
};
$(document).ready(function() {
    $('#chattalk').keydown(function(event) {
        if (event.keyCode == 13) {
            newchat(userid , username);
            return false;
         }
    });
});
$(document).ready(function() {
    $('#pr_resptalk').keydown(function(event) {
        if (event.keyCode == 13) {
            submittalk() ;
            return false;
         }
    });
});  
function newchat(userid , username) {
	//var uid = parseInt($("#friendid").val()) ;
	var chat = $("#chattalk").val() ;
	var dataString = 'friendid='+ userid + '&message='+ chat ;
	if (chat == "") {
		alert('enter something') ;
		}
		else {
			$.ajax({
				type: "POST",
				url: "ajax/submitchat.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					if (result == "Posted Successfully!") {
						$("#chattalk").val("") ;
						getnewmessages(userid , username) ;
					}
				}
			});
		}
} ;
function closetalk() {
	$("#talkprForm").hide();
	$("#talkformdata").hide();
	$("#talkformin").hide();
}
function projecttalk() {
	var username = 'name' ;
	var dataString = 'prtalk='+ username ;
	$.ajax({
		type: "POST",
		url: "ajax/project_talk.php",
		data: dataString,
		cache: false,
		success: function(result){
			var notice = result.split("+") ;
			var neid = parseInt(notice['2']) ;
			document.getElementById("newtalks").innerHTML = notice['0'];
			document.getElementById("showtalkingform").innerHTML = notice['1'];
			//document.getElementById("lastchatid").innerHTML = neid+='';
			$("#lastprchatid").val(neid+='') ;
		}
	});
	setInterval(function(){ getnewtalk() },3000)();
};	
function getnewmessages(userid , username) {
	var uid = parseInt($("#lastchatid").val()) ;
	//alert(uid) ;
	//var username = $("#friendname").val() ;
	//var userid = parseInt($("#friendid").val()) ;
	//alert(userid) ;
	var dataString = 'getnew='+ uid + '&name='+ username + '&fid='+ userid;
			$.ajax({
				type: "POST",
				url: "ajax/getnewmessages.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					var notice = result.split("+") ;
					var neid = parseInt(notice['1']) ;
					//alert(neid) ;
					$('.newmassages').append(notice['0']);
					//$("#chatformdata").scrollTop($('#chatformdata').height()) ;
					if (neid+='' != 0) {
							$("#lastchatid").val(neid+='') ;
						}
				}
			}); 
		}
