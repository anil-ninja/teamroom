//check for username already exists or not starts
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

function aboutinvest(){
	$(".totalcapital").toggle();
}
          
function email_forget() {
	var xmlhttp;
	var email_forget=document.getElementById("email_forget");
	if (email_forget.value != ""){
		if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		} 
		else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("status_email_forget_password").innerHTML=xmlhttp.responseText;
			}
		};
		xmlhttp.open("GET","ajax/email_exist_check_forget_password.php?email_forget="+encodeURIComponent(email_forget.value),true);
		xmlhttp.send();
	}
	if (result = "No user registered with this Email, <br>Please try again with different Email-id or Signup") {                    
	}
}
