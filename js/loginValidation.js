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
    var username = $("#username").val() ;
    var password = $("#passwordlogin").val() ;
    //accept_challenge
    //reason += validateUsername(username);
    //reason += validatePassword(password);

    //if (reason != "") {
        //bootstrap_alert(".alert_placeholder", "Oops, Username is empty!", 5000,"alert-warning");
        //alert("Some fields need correction:\n" + reason);
        //return false;
    //}
    var dataString = 'username='+ username + '&password='+ password + '&request=login' ;
    // AJAX Code To Submit Form.
    //alert(dataString);
    $.ajax({
        type: "POST",
        url: "controllers/login_controller.php",
        data: dataString,
        cache: false,
        success: function(result){
            
           // bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
            if(result){
                                bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
               
            } else {
                //$("#accept_challenge").click() ;
                location.reload();
                
            }
        }
    });
//return true;
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
//$("#accept_challenge").click() ;
//alert(document.cookie);
//alert(getCookie("loginRrq"));
if(getCookie("loginRrq")=="true"){
    //alert(document.cookie);
    document.cookie="loginRrq=;";
    $("#accept_challenge").click() ;
}
function validateLogin1(){
    document.cookie="loginRrq=true;";
    validateLoginFormOnSubmit();
    

}
function validateEmpty(fld) {
    var error = "";

    if (fld.value.length == 0) {
        $("#username").style.background = 'Yellow'; 
        error = "The required field has not been filled in.\n"
    } else {
        $("#username").style.background = 'White';
    }
    return error;  
}

function validateUsername(fld) {
    var error = "";

    if (fld.value == "") {
        $("#username").style.border = "2px solid OrangeRed"; 
        error = "You didn't enter a username.\n";
    } else {
        $("#username").style.background = 'White';
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
