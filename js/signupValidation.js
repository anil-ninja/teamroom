function bootstrap_alert(elem, message, timeout,type) {
	$(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; right: 20%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
	if (timeout || timeout === 0) {
		setTimeout(function() { 
			$(elem).show().html('');
		}, timeout);    
	}
};

$(document).ready(function() {
    $('#password2R').keydown(function(event) {
        if (event.keyCode == 13) {
            validateSignupFormOnSubmit();
            return false;
         }
    });
});

function nospaces(t){
	if(t.value.match(/\s/g)){
		bootstrap_alert(".alert_placeholder", 'Sorry, you are not allowed to enter any spaces', 5000,"alert-success");
		t.value=t.value.replace(/\s/g,'');
	}
}

function trim(s){
	return s.replace(/^\s+|\s+$/, '');
}

function checkForm() {
	if (document.getElementById('password_1').value == document.getElementById('password_2').value) {
		return true;
	}
	else {
		alert("Passwords don't match");
		return false;
	}
}

function email_availability_check() {
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
};

function validatePath(path) {
	if (path.match("^[a-zA-Z0-9.]*$")) {
		return "true" ;
	}
	else {
		return false;
	}
} 
function validateEmpty(fld) {
	var error = "";
	if (fld.value.length == 0) {
		fld.style.background = 'Yellow'; 
		error = "The required field has not been filled in.\n"
	} 
	else {
		fld.style.background = 'White';
	}
	return error;  
}

function validateFirstname(fld) {
	var error = "";
	var illegalChars = /\W/; // allow letters, numbers, and underscores
	if (fld.value == "") {
		fld.style.border = "2px solid OrangeRed"; 
		error = "You didn't enter your first name.\n";
	}  
	else if (illegalChars.test(fld.value)) {
		fld.style.borderColor = 'Yellow'; 
		error = "Letters, numbers, and underscores allowed in first name.\n";
	} 
	else {
		fld.style.background = 'White';
	}
	return error;
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
function validatePhone(fld) {
	var error = "";
	var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    
	if (fld.value == "") {
		fld.style.border = "2px solid OrangeRed";
		error = "You didn't enter a phone number.\n";
	} 
	else if (isNaN(parseInt(stripped))) {
		error = "The phone number contains illegal characters.\n";
		fld.style.border = "2px solid OrangeRed";
	} 
	else if (!(stripped.length == 10)) {
		error = "The phone number is the wrong length. Make sure you included an 10 digits mobile number.\n";
		fld.style.border = "2px solid OrangeRed";
	}
	return error;
}
    
function validateSignupFormOnSubmit() {
	var reason = "";
	var firstname = $("#firstname").val() ;
	var lastname = $("#lastname").val() ;
	var email = $("#email").val() ;
	//var phone = $("#phone").val() ;
	var username = replaceAll('[.]', '', $("#usernameR").val()) ;
	var password = $("#passwordR").val() ;
	var password2 = $("#password2R").val() ;
    var term_n_cond = document.getElementById("agree_tc").checked;
    var typeA = document.getElementById("typeCol").checked;
    var typeB = document.getElementById("typeInv").checked;
    var typeC = document.getElementById("typeFun").checked;
    var amount = $("#investment").val() ;
	if(password==password2){
		if(replaceAll('\\s', '',firstname)==''){
			bootstrap_alert(".alert-placeholder", "firstname can not be empty", 5000,"alert-warning");
		}
		else if(replaceAll('\\s', '',email)==''){
			bootstrap_alert(".alert-placeholder", "email can not be empty", 5000,"alert-warning");
		}
        else if (validateEmail(email)==false) {
            bootstrap_alert(".alert-placeholder", "Enter a valid email id", 5000,"alert-warning");       
        } 
		else if(replaceAll('\\s', '',username)==''){
			bootstrap_alert(".alert-placeholder", "username can not be empty", 5000,"alert-warning");
		}
        else if(username.length <'6'){
            bootstrap_alert(".alert-placeholder", "username length be atleast 6", 5000,"alert-warning");
        } 
		else if(replaceAll('\\s', '',password)==''){
			bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
		} 
		else if(password.length <'6'){
			bootstrap_alert(".alert-placeholder", "password length should be atleast 6", 5000,"alert-warning");
		}
		else if(replaceAll('\\s', '',password2)==''){
			bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
		}
		else if(validatePath(firstname) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters are not allowed <br/> Only Alphabets and Numbers are allowed", 5000,"alert-warning");
		}
		else if(validatePath(username) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters are not allowed <br/> Only Alphabets and Numbers are allowed", 5000,"alert-warning");
		}
		else if(validatePath(lastname) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters are not allowed <br/> Only Alphabets and Numbers are allowed", 5000,"alert-warning");
		} 
        else if(term_n_cond==false){
            bootstrap_alert(".alert-placeholder", "You have not accepted term and conditions", 5000,"alert-warning");
        }
        else if((typeA==false) && (typeB==false) && (typeC==false)){
            bootstrap_alert(".alert-placeholder", "You have not told why you are here", 5000,"alert-warning");
        }
        else if((typeB==true)&& (replaceAll('\\s', '',amount)=='')) {
			bootstrap_alert(".alert_placeholder", "Amount can not be empty", 5000,"alert-warning");
			return false;
		} 
		else {
			if((typeA==false) && (typeB==false)){
				var type = "fundsearcher";
			}
			else if((typeA==false) && (typeC==false)){
				var type = "invester";
			}
			else if((typeB==false) && (typeC==false)){
				var type = "collaborater";
			}
			else if(typeB==false){
				var type = "collaboraterFundsearcher";
			}
			else if(typeA==false){
				var type = "fundsearcherInvester";
			}
			else if(typeC==false){
				var type = "collaboraterInvester";
			}
			else {
				var type = "collaboraterinvesterfundsearcher";
			}
			var dataString = 'firstname='+ firstname + '&lastname='+ lastname + '&email='+ email  + '&username='+ username + '&password='+ password + 
							'&password2='+ password2 + '&type=' + type + '&term_n_cond=' + term_n_cond + '&amount=' + amount + '&request=Signup' ;
			$.ajax({
				type: "POST",
				url: "controllers/login_controller.php",
				data: dataString,
				cache: false,
				success: function(result){
					if(result){
						bootstrap_alert(".alert-placeholder", result, 5000,"alert-warning");
					} 
					else {
						location.reload();
					}		
				} 
			});
		}
	}		
	else bootstrap_alert(".alert-placeholder", "Password Not Match! Try Again", 5000,"alert-warning");
}
function replaceAll(find, replace, str) {
	if(str == null) {
		str = "";
	}
	return str.replace(new RegExp(find, 'g'), replace);
}

function validateUsername(fld) {
	var error = "";
	var illegalChars = /\W/; // allow letters, numbers, and underscores
	if (fld.value == "") {
		fld.style.border = "2px solid OrangeRed"; 
		error = "You didn't enter a username.\n";
	}  
	else if (illegalChars.test(fld.value)) {
		fld.style.borderColor = '#FF0000'; 
		error = "Letters, numbers, and underscores allowed in username.\n";
	} 
	else {
		fld.style.background = 'White';
	}
	return error;
}

function validatePassword(fld) {
	var error = "";
	if (fld.value == "") {
		fld.style.border = "2px solid OrangeRed";
		error = "You didn't enter a password.\n";
	} 
	else if ((fld.value.length < 5) || (fld.value.length > 15)) {
		error = "The password is must be atleast of 7 length. \n";
		fld.style.border = "2px solid OrangeRed";
	} 
	else {
		fld.style.background = 'White';
	}
	return error;
}

function validatePassword2(fld,fld2) {
	var error = "";
	if (fld2.value == "") {
		fld2.style.border = "2px solid OrangeRed";
		error = "You didn't verify password.\n";
	} 
	else if (fld.value != fld2.value) {
		fld.style.border = "2px solid OrangeRed";
		fld2.style.border = "2px solid OrangeRed";
		error = "Password not match, try again.\n";
	}
	else {
		fld.style.background = 'White';
	}
	return error;
}
  
function trim(s){
	return s.replace(/^\s+|\s+$/, '');
}
