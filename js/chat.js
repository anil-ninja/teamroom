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
function convertSpecialChar(str){
		return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
	}
$("#changeremindervalue").click(function(){
      		//$("#create_video").attr('disabled','disabled');
			var reminder = convertSpecialChar($("#newremindervalue").val()) ;
			var date = $("#datepicker").val() ;
			var value = $("#datepickervalue").val() ;
			var userid = $("#valueuserid").val() ;
			var newuserid = $("#selfremind").val() ;
			//alert(newuserid + "," + userid) ;
			if(newuserid == userid) {
					if(reminder == "" && date != "") {
							var dataString = 'value='+ value + '&date='+ date + '&case=3' ;
						}
						else if (date == "" && reminder != "") {
							var dataString = 'value='+ value + '&reminder='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',reminder)))) + '&case=2' ;
							}
							else if(reminder == "" && date == "") {
								location.reload() ;
								return false ;
								}
								else {
									var dataString = 'value='+ value + '&date='+ date + '&reminder='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',reminder)))) + '&case=1' ;
									}
				}
				else {
					if(reminder == "" && date != "") {
							var dataString = 'value='+ value + '&date='+ date + '&case=6' + '&user='+ newuserid ;
						}
						else if (date == "" && reminder != "") {
							var dataString = 'value='+ value + '&reminder='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',reminder)))) + '&case=5' + '&user='+ newuserid ;
							}
							else if(reminder == "" && date == "") {
								var dataString = 'value='+ value + '&case=4' + '&user='+ newuserid ;
								}
								else {
									var dataString = 'value='+ value + '&date='+ date + '&reminder='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',reminder)))) + '&case=7' + '&user='+ newuserid ;
									}
					
					
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
  $("#SignUp").modal("show");
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
	$.ajax({
		type: "POST",
		url: "ajax/subscribe.php",
		data: dataString,
		cache: false,
		success: function(result){
			bootstrap_alert(".alert_placeholder", "Subscribed  Successfully", 5000,"alert-success");
		}
	});
}
function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};
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
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("+") ;
					var neid = parseInt(notice['1']) ;
					document.getElementById("allreminders").innerHTML = notice['0'];
					//$("#chatformdata").scrollTop($('#chatformdata').height()) ;
					$("#lastreminderid").val(neid+='') ;
				}
			});
	//setInterval(function(){ getnewreminder() },400000)();
}

function submittalk(event,chatboxtextarea) {
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = $(chatboxtextarea).val();
		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
	if(message==''){
		//bootstrap_alert(".alert_placeholder", "Enter Something", 5000,"alert-warning");
		return false;
	}
	 else {
		var dataString = 'talk='+ message ;
		$.ajax({
			type: "POST",
			url: "ajax/project_talks.php",
			data: dataString,
			cache: false,
			success: function(result){
				//alert(result);
				//bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
				if(result=='Posted succesfully!'){
					$(chatboxtextarea).val('');
					//getnewtalk() ;
				}
			}
		 });
	}	
}
};
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
function toggle() {
	$("#project_chat_form").toggle();
	$("#project_chat_data").toggle();
	}
