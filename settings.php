<?php
session_start();
$user_id = $_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
	header("location: index.php") ;
}
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
	<title>change password</title>
    <meta name="author" content="Anil">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Challenge, Project, Problem solving, problem">
    <meta name="author" content="Anil">
    <?php include_once 'lib/htmt_inc_headers.php'; ?>
  </head>
  <body>
       <?php include_once 'html_comp/navbar_homepage.php'; ?>
       
       <div class="row-fluid" style='margin-top: 50px;'>
       <div class='alert-placeholder'></div>
       <div class="span2">
            <div>
              <ul class="nav nav-tabs" role="tablist" style="font-size:17px">
                  <li role="presentation">
                    <a href="#tabchangePassword" role="tab" data-toggle="tab">Change Password</a>
                  </li>
                  
              </ul>
            </div>
       </div>
            <div class="tab-content" >
              <div role="tabpanel" id="tabchangePassword" >
                  
            <div class="form-group">
                <div class="span5">
                    <input type="password" class="form-control" id="oldpassword" placeholder="Old password" /><br>
                    <input type="password" class="form-control" id="passwordnewchange1" placeholder="password" /><br>
                    <input type="password" class="form-control" id="passwordnewchange2" placeholder="Re-enter password"/><br/><br/>
                    <input type="submit" class="btn btn-primary btn-lg" id = "updatePassword" onclick="validateChangePassword();" value = "Update">
                </div>
            </div>
                </div>
              </div>
</div>
<div class='footer'>
		<a href='www.dpower4.com' target = '_blank' ><b>Powered By: </b> Dpower4</a>
		 <p>Making World a Better Place, because Heritage is what we pass on to the Next Generation.</p>
</div>  
    <script>
        function bootstrap_alert(elem, message, timeout,type) {
            $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; right: 20%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
            if (timeout || timeout === 0) {
                setTimeout(function() { 
                $(elem).show().html('');
                }, timeout);    
            }
            };
            $(document).ready(function() {
                $('#updatePassword').keydown(function(event) {
                    if (event.keyCode == 13) {
                        validateChangePassword();
                        return false;
                    }
                });
            });
            function validateChangePassword() {
                var reason = "";
                        var old_password = $("#oldpassword").val() ;
                        var password = $("#passwordnewchange1").val() ;
                        var password2 = $("#passwordnewchange2").val() ;
                var dataString = 'old_pass='+ old_password + '&new_pass1='+ password + '&new_pass2='+ password2;
                if(password==password2){
                        if(password==''){
                                bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
                        } else if(password.length <'6'){
                                bootstrap_alert(".alert-placeholder", "password length should be atleast 6", 5000,"alert-warning");
                        }else if(password2==''){
                                bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "ajax/change_password.php",
                                data: dataString,
                                cache: false,
                                success: function(result){
                                    if(result){
                                        bootstrap_alert(".alert-placeholder", result, 5000,"alert-success");
                                        location.reload();
                                    } 
                                    else {
                                        bootstrap_alert(".alert-placeholder", result, 5000,"alert-warning");
                                    }		
                                } 
                            });
                        }
                        }		
                    else bootstrap_alert(".alert-placeholder", "Password Not Match! Try Again", 5000,"alert-warning");
                }

    </script>
    <script src="js/jquery-1.js"></script>
    <script src="date.js"></script>
    <script src="js/bootstrap.js"></script>
   
   <script src="js/date_time.js"></script>
  </body>
</html>
<?php mysqli_close($db_handle); ?>
