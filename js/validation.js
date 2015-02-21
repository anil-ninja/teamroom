function validateSignupFormOnSubmit(theForm) {
	var reason = "";

	reason += validateFirstname(theForm.firstname);
	reason += validateEmail(theForm.email);
	reason += validateUsername(theForm.username);
	reason += validatePhone(theForm.phone);
	reason += validatePassword(theForm.password);
	reason += validatePassword2(theForm.password,theForm.password2);
	if (reason != "") {
		alert("Some fields need correction:\n" + reason);
		return false;
	}
	return true;
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

	if (fld.value == "") {
		fld.style.border = "2px solid OrangeRed";
		error = "You didn't enter your first name.\n";
	}
	else {
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
function trim(s){
	return s.replace(/^\s+|\s+$/, '');
}

function nospaces(t){

	if(t.value.match(/\s/g)){

	alert('Sorry, you are not allowed to enter any spaces');

	t.value=t.value.replace(/\s/g,'');

	}

}


function validateLoginFormOnSubmit(theForm) {
                    var reason = "";
                    reason += validateUsername(theForm.username);
                    reason += validatePassword(theForm.password);
                
                    if (reason != "") {
                        alert("Some fields need correction:\n" + reason);
                        return false;
                    }
                    return true;
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
           
                function validateUsername(fld) {
                    var error = "";
                
                    if (fld.value == "") {
                        fld.style.border = "2px solid OrangeRed"; 
                        error = "You didn't enter a username.\n";
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
                    } else {
                        fld.style.background = 'White';
                    }
                    return error;
                }
