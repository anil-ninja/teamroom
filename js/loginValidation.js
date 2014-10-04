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
