function bootstrap_alert(elem, message, timeout,type) {
	$(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; right: 20%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
	if (timeout || timeout === 0) {
		setTimeout(function() { 
			$(elem).show().html('');
		}, timeout);    
	}
};

$(document).ready(function() {
	$('#passwordlogin').keydown(function(event) {
		if (event.keyCode == 13) {
			validateLoginFormOnSubmit();
			return false;
		}
	});
});

function validateLoginFormOnSubmit() {
	var reason = "";
	var username = $("#username").val();
	var password = $("#passwordlogin").val() ;
	var dataString = 'username='+ replaceAll("[.]", "", username) + '&password='+ password + '&request=login' ;
	// AJAX Code To Submit Form.
	$.ajax({
		type: "POST",
		url: "controllers/login_controller.php",
		data: dataString,
		cache: false,
		success: function(result){
			if(result){
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
			} 
			else {
				location.reload();   
			}
		}
	});
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
	}
	return "";
}

if(getCookie("loginRrq")=="true"){
//alert(document.cookie);
	document.cookie="loginRrq=;";
	$("#accept_challenge").click() ;
}

function validateLogin1(){
	document.cookie="loginRrq=true;";
	validateLoginFormOnSubmit();
}

function updatelastlogin(){ 
	var dataString = 'update=true' + '&case=2' ;
	setInterval(function (){
		$.ajax({
			type: "POST",
			url: "ajax/updatetime.php",
			async: false ,
			data: dataString,
			cache: false,
		});
	},600000);
};

function updatetime() {
	var dataString = 'update=true' + '&case=1' ;
	$.ajax({
		type: "POST",
		url: "ajax/updatetime.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			if(result == "updated") {
				document.getElementById("countnotice").innerHTML = "" ;
			}
		}
	}); 
} ;
