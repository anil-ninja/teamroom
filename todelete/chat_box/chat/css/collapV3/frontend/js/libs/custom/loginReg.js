function nospaces(t){
	if(t.value.match(/\s/g)){
		bootstrap_alert(".alert_placeholder", 'Sorry, you are not allowed to enter any spaces', 5000,"alert-success");
		t.value=t.value.replace(/\s/g,'');
	}
}
function bootstrap_alert(elem, message, timeout,type) {
	$(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; right: 20%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
	if (timeout || timeout === 0) {
		setTimeout(function() { 
			$(elem).show().html('');
		}, timeout);    
	}
}
function emailCheck() {
	var xmlhttp;
	var email=document.getElementById("email");
	if (email.value != ""){
		if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		} 
		else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("status_email").innerHTML=xmlhttp.responseText;
			}
		};
		xmlhttp.open("GET","ajax/email_availability.php?email="+encodeURIComponent(email.value),true);
		xmlhttp.send();
	}
}
function aboutinvest(){
	$(".totalcapital").toggle();
}
function usernameCheck() {
	var xmlhttp;
	var username=document.getElementById("usernameR");
	if (username.value != ""){
		if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		} 
		else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("status").innerHTML=xmlhttp.responseText;
			}
		};
		xmlhttp.open("GET","ajax/uname_availability.php?username="+encodeURIComponent(username.value),true);
		xmlhttp.send();
	}
}
function trim(s){
	return s.replace(/^\s+|\s+$/, '');
}
function validateEmail(fld) {
	var error="";
	var tfld = trim(fld);                        // value of field with whitespace trimmed off
	var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
	if (!emailFilter.test(tfld)) {              //test email for illegal characters
		//fld.style.background = 'Yellow';
		//error = "Please enter a valid email address.\n";
	} 
	else {
		//fld.style.background = 'White';
		return true;
	}
	return false;
}
function validatePath(path) {
	if(path == "" || path == null || path == undefined){
		return false ;
	}
	else {
		var filter = /^[a-zA-Z0-9.]*$/ ;
		if (filter.test(path)) {
			return true ;
		}
		else {
			return false;
		}
	}
}
function validateUsername(path) {
	if(path == "" || path == null || path == undefined){
		return false ;
	}
	else {
		var filter = /^[A-Za-z0-9\.\-@#$_]*$/ ;
		if (filter.test(path)) {
			return true ;
		}
		else {
			return false;
		}
	}
}
function replaceAll(find, replace, str) {
	return str.replace(new RegExp(find, 'g'), replace);
}
function IsNumeric(e) {
	var specialKeys = new Array();
	specialKeys.push(8); //Backspace
    var keyCode = e.which ? e.which : e.keyCode
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}