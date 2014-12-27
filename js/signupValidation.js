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
function validateSignupFormOnSubmit() {
	var reason = "";
	var firstname = $("#firstname").val() ;
	var lastname = $("#lastname").val() ;
	var email = $("#email").val() ;
	var phone = $("#phone").val() ;
	var username = $("#usernameR").val() ;
	//alert("user");
	var password = $("#passwordR").val() ;
	var password2 = $("#password2R").val() ;
	/* reason += validateFirstname(theForm.firstname);
	reason += validateEmail(theForm.email);
	reason += validateUsername(theForm.username);
	reason += validatePhone(theForm.phone);
	reason += validatePassword(theForm.password);
	reason += validatePassword2(theForm.password,theForm.password2);
	if (reason != "") {
	alert("Some fields need correction:\n" + reason);
	return false;
	}
	return true;*/
	var dataString = 'firstname='+ firstname + '&lastname='+ lastname + '&email='+ email + '&phone='+ phone + '&username='+ username +
	'&password='+ password + '&password2='+ password2 + '&request=Signup' ;
	if(password==password2){
		if(firstname==''){
			bootstrap_alert(".alert-placeholder", "firstname can not be empty", 5000,"alert-warning");
		}
		else if(email==''){
			bootstrap_alert(".alert-placeholder", "email can not be empty", 5000,"alert-warning");
		} 
		else if(phone==''){
			bootstrap_alert(".alert-placeholder", "phone can not be empty", 5000,"alert-warning");
		} 
		else if(username==''){
			bootstrap_alert(".alert-placeholder", "username can not be empty", 5000,"alert-warning");
		} 
		else if(password==''){
			bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
		} 
		else if(password.length <'6'){
			bootstrap_alert(".alert-placeholder", "password length should be atleast 6", 5000,"alert-warning");
		}
		else if(password2==''){
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
		else {
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
        } else {
            fld.style.background = 'White';
        }
        return error;  
    }
    function validateFirstname(fld) {
        var error = "";
        //cleanText = strInputCode.replace(/<\/?[^>]+(>|$)/g, "");
        //OriginalString.replace(/(<([^>]+)>)/ig,"");
        //html.replace(/<\/?(span|div|img|p...)\b[^<>]*>/g, "")
        //\W/;
		var illegalChars = /\W/; // allow letters, numbers, and underscores
		if (fld.value == "") {
            fld.style.border = "2px solid OrangeRed"; 
            error = "You didn't enter your first name.\n";
        }  else if (illegalChars.test(fld.value)) {
            fld.style.borderColor = 'Yellow'; 
            error = "Letters, numbers, and underscores allowed in first name.\n";
        } else {
            fld.style.background = 'White';
        }
        return error;
     }
    function validateEmail(fld) {
        var error="";
        var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
        var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;

        if (fld.value == "") {
            fld.style.border = "2px solid OrangeRed";
            error = "You didn't enter an email address.\n";
        } else if (!emailFilter.test(tfld)) {              //test email for illegal characters
            fld.style.background = 'Yellow';
            error = "Please enter a valid email address.\n";
        } else {
            fld.style.background = 'White';
        }
        return error;
    }
        function validatePhone(fld) {
        var error = "";
        var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    

        if (fld.value == "") {
                fld.style.border = "2px solid OrangeRed";
                error = "You didn't enter a phone number.\n";
            } else if (isNaN(parseInt(stripped))) {
                error = "The phone number contains illegal characters.\n";
                fld.style.border = "2px solid OrangeRed";

            } else if (!(stripped.length == 10)) {
                error = "The phone number is the wrong length. Make sure you included an 10 digits mobile number.\n";
                fld.style.border = "2px solid OrangeRed";
            }
            return error;
    }
    function validateUsername(fld) {
        var error = "";
        var illegalChars = /\W/; // allow letters, numbers, and underscores

        if (fld.value == "") {
            fld.style.border = "2px solid OrangeRed"; 
            error = "You didn't enter a username.\n";
        }  else if (illegalChars.test(fld.value)) {
            fld.style.borderColor = '#FF0000'; 
            error = "Letters, numbers, and underscores allowed in username.\n";
        } else {
            fld.style.background = 'White';
        }
        return error;
    }

    function validatePassword(fld) {
        var error = "";

        if (fld.value == "") {
            fld.style.border = "2px solid OrangeRed";
            error = "You didn't enter a password.\n";
        } else if ((fld.value.length < 5) || (fld.value.length > 15)) {
            error = "The password is must be atleast of 7 length. \n";
            fld.style.border = "2px solid OrangeRed";
        } else {
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
    function trim(s)
    {
        return s.replace(/^\s+|\s+$/, '');
    }
