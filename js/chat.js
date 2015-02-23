function getnewtalk() {	
	var uid = parseInt($("#lastprchatid").val()) ;
	var ID = $("#ProjectIDValue").val() ;
	var dataString = 'talks='+ uid  + '&project_id=' + ID ;
	$.ajax({
		type: "POST",
		url: "ajax/protalk.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			var notice = result.split("|+") ;
			var neid = parseInt(notice['1']) ;
			$('.newtalkspr').append(notice['0']);
			if (neid+='' != 0) {
				$("#lastprchatid").val(neid+='') ;
			}
		}
	});
}

function convertSpecialChar(str){
	return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
}

$("#changeremindervalue").click(function(){
	var reminder = convertSpecialChar($("#newremindervalue").val()) ;
	var date = $("#datepicker").val() ;
	var value = $("#datepickervalue").val() ;
	var userid = $("#valueuserid").val() ;
	var newuserid = $("#selfremind").val() ;
	if(newuserid == userid) {
		if(replaceAll('\\s', '',reminder) == "" && replaceAll('\\s', '',date) != "") {
			var dataString = 'value='+ value + '&date='+ date + '&case=3' ;
		}
		else if (replaceAll('\\s', '',date) == "" && replaceAll('\\s', '',reminder) != "") {
			var dataString = 'value='+ value + '&reminder='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',reminder)))) + '&case=2' ;
		}
		else if(replaceAll('\\s', '',reminder) == "" && replaceAll('\\s', '',date) == "") {
			location.reload() ;
			return false ;
		}
		else {
			var dataString = 'value='+ value + '&date='+ date + '&reminder='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',reminder))))) + '&case=1' ;
		}
	}
	else {
		if(replaceAll('\\s', '',reminder) == "" && replaceAll('\\s', '',date) != "") {
			var dataString = 'value='+ value + '&date='+ date + '&case=6' + '&user='+ newuserid ;
		}
		else if (replaceAll('\\s', '',date) == "" && replaceAll('\\s', '',reminder) != "") {
			var dataString = 'value='+ value + '&reminder='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',reminder)))) + '&case=5' + '&user='+ newuserid ;
		}
		else if(replaceAll('\\s', '',reminder) == "" && replaceAll('\\s', '',date) == "") {
			var dataString = 'value='+ value + '&case=4' + '&user='+ newuserid ;
		}
		else {
			var dataString = 'value='+ value + '&date='+ date + '&reminder='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',reminder))))) + '&case=7' + '&user='+ newuserid ;
		}
	}
	$.ajax({
		type: "POST",
		url: "ajax/change_reminder.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
			if(result = "Changed Successfully !!!") {
				location.reload() ;
				$("#datepicker").val("") ;
				$("#datepickervalue").val("") ;
				$("#newremindervalue").val("") ;
				$("#valueuserid").val("") ;
			}
		}
	});	
});

function test() {
  $("#signupwithoutlogin").modal("show");
};

function test2() {
  $("#signupwithoutlogin").modal("hide");
  $("#SignIn").modal("show");
};

function test3() {
  $("#SignIn").modal("show");
};

$(document).ready(function() {
    $('#subscriptionid').keydown(function(event) {
        if (event.keyCode == 13) {
            Subscribe();
            return false;
         }
    });
});

function Subscribe(){
	var reminder = $("#subscriptionid").val() ;
	var dataString = 'id=' + reminder ;
	if(replaceAll('\\s', '',reminder) = "") {
		bootstrap_alert(".alert_placeholder", "Enter valid Email-ID", 5000,"alert-warning");
		return false;	
	}
	else if (validateEmail(reminder)==false) {
        bootstrap_alert(".alert-placeholder", "Enter a valid email id", 5000,"alert-warning");       
    }
	else {
		$.ajax({
			type: "POST",
			url: "ajax/subscribe.php",
			async: false ,
			data: dataString,
			cache: false,
			success: function(result){
				bootstrap_alert(".alert_placeholder", "Subscribed  Successfully", 5000,"alert-success");
			}
		});
	}
}

function editreminder(id, uid) {
	$("#datepickervalue").val(id) ;
	$("#valueuserid").val(uid) ;	
	$("#changeremindervalues").modal("show");
}

function getallreminders() {	
	var dataString = 'reminder=true'  ;
	$.ajax({
		type: "POST",
		url: "ajax/reminders.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			var notice = result.split("|+") ;
			var neid = parseInt(notice['1']) ;
			document.getElementById("allreminders").innerHTML = notice['0'];
			//$("#chatformdata").scrollTop($('#chatformdata').height()) ;
			$("#lastreminderid").val(neid+='') ;
		}
	});
}

function submittalk(event,chatboxtextarea) {
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = convertSpecialChar($(chatboxtextarea).val());
		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
		if(replaceAll('\\s', '',message)==''){
			//bootstrap_alert(".alert_placeholder", "Enter Something", 5000,"alert-warning");
			return false;
		}
		else {
			var ID = $("#ProjectIDValue").val() ;
			var dataString = 'talk='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',message))))) + '&project_id=' + ID ;
			$.ajax({
				type: "POST",
				url: "ajax/project_talks.php",
				async: false ,
				data: dataString,
				cache: false,
				success: function(result){
					if(result=='Posted succesfully!'){
						$(chatboxtextarea).val('');
					}
				}
			});
		}	
	}
};

function projecttalk() {
	var ID = $("#ProjectIDValue").val() ;
	var dataString = 'prtalk=username' + '&project_id=' + ID ;
	$.ajax({
		type: "POST",
		url: "ajax/project_talk.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			var notice = result.split("|+") ;
			var neid = parseInt(notice['2']) ;
			document.getElementById("newtalks").innerHTML = notice['0'];
			document.getElementById("showtalkingform").innerHTML = notice['1'];
			$("#lastprchatid").val(neid+='') ;
		}
	});
	setInterval(function(){ getnewtalk(); },5000);
};
	
function toggle() {
	$("#project_chat_form").toggle();
	$("#project_chat_data").toggle();
}
