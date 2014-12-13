<?php
session_start();
if (isset($_SESSION['first_name'])) {  
    header('Location: ninjas.php');
}
if (isset($_POST['request_password']) && $_POST['email_forget_password']) {
    include_once 'lib/db_connect.php';
    include_once 'functions/collapMail.php';
    $email_req = $_POST['email_forget_password'];
    $user_id_access_aid = mysqli_query($db_handle, "SELECT user_id FROM user_info WHERE email= '$email_req' ;");
    
    $user_id_access_aidRow = mysqli_fetch_array($user_id_access_aid);
    $user_id_access = $user_id_access_aidRow['user_id'];
    
    $already_sent_mail = mysqli_query($db_handle, "SELECT id, status, hash_key FROM user_access_aid WHERE user_id= '$user_id_access' AND status = '0';");
    $already_hash_set = mysqli_num_rows($already_sent_mail);
    if ($already_hash_set == 1) {
        $already_sent_mailRow = mysqli_fetch_array($already_sent_mail);
        $already_hash = $already_sent_mailRow['hash_key'];
        $already_id = $already_sent_mailRow['id'];
        $already_hash_key = $already_hash.".".$already_id;
        $body = "http://collap.com/forgetPassword.php?hash_key=$already_hash_key";
        collapMail($email_req, "Update password", $body);
        echo "<div class='jumbotron'>
                <p align='center'> Please check your Email, shortly you get an email, Go through your email and change your password<br>
                <a href='index.php'><br>Go Back</a></p>
            </div>";
    }
    else {
        $hash_key = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
        mysqli_query($db_handle, "INSERT INTO user_access_aid (user_id, hash_key) VALUES ('$user_id_access', '$hash_key');");

        $id_access_id = mysqli_insert_id($db_handle);
        $hash_key = $hash_key.".".$id_access_id;
        $body = "http://collap.com/forgetPassword.php?hash_key=$hash_key";

        collapMail($email_req, "Update password", $body);
        if(mysqli_error($db_handle)){
            header('location: #');
        } 
        else {
        echo "<div class='jumbotron'>
                <p align='center'> Please check your Email, shortly you get an email, Go through your email and change your password<br>
                <a href='index.php'><br>Go Back</a></p>
            </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>collap</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenge, Project, Problem solving, problem, article, collaborate, collaboration">
        <meta name="author" content="Anil">
		<meta name="google-site-verification" content="T9t0-1XNcBUnzXn72xeFMde2N8j7v7IjT0gHy2jweq4" />
		<?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body >
    <div class="navbar navbar-default navbar-fixed-top">
        <div>
            <div class="col-md-2 navbar-header">
                 <a class="brand" style='font-size:16pt; color: #fff; font-weight: bold;' href="index.php">
                 <img src ='img/collap.gif' style="width:70px;">collap</a>
            </div>
            <div class="span3 pull-right">
                <ul class="list-inline" style='padding-top: 10px;'>
                    <li><p style='font-size:9pt; color:#fff;'>Powered By : </p></li>
                    <li><a class="btn-link" style='font-size:12pt; color: #fff; font-weight: bold;' href="http://dpower4.com/" target="_blank">Dpower4.com</a></li>
                </ul>
            </div>
        </div>
    </div>
        <div class="row" style="background-image: url(img/collaboration.jpg); margin-top:0px; margin-left:0px; height: 600px; width: 100%;">
            <div class = "col-xs-7 col-ls-8"></div>	
            <div class = "col-xs-2 col-ls-4" style="width:350px; height:500px; margin-top:50px;">
                <div class="bs-component">
                    <div class="modal" style="width: 380px;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                   
                                    <p align="center"><font size="5" >Let's Collaborate!!</font></p>
                                </div>
                                <div class="modal-body">
                                     <div class="alert_placeholder"> </div>
                                    <br/>
                                    <div class="input-group">
                                        <span class="input-group-addon">Username</span>
                                        <input type="text" class="form-control" id="username" placeholder="Email or Username">
                                    </div>
                                    <br/>
                                    <div class="input-group">
                                        <span class="input-group-addon">Password&nbsp;</span>
                                        <input type="password" class="form-control" id="passwordlogin" placeholder="Password">
                                    </div><br/>
                                    <button type="submit" class="btn btn-success" id="request" value='login' onclick="validateLoginFormOnSubmit()"><font size="3" >Log in</font></button>
                                    <a data-toggle="modal" data-target="#forgetPassword" style="float: right; font-size:11pt; padding-top: 5px ; cursor:pointer;">Forgot Password</a>
                                </div>
                                <div class="modal-footer">
                                    <button data-toggle="modal" class="btn btn-primary" data-target="#myModal" style="float: right; cursor:pointer;"><font size="3" >Sign up</font></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="width:370px; height:auto">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel"><font size="5" >Sign up for Collap</font></h4>
                            <div class="alert-placeholder"> </div>
                        </div>
                        <div class="modal-body">
                            <div class="inline-form">
                                <div class="row">
                                    <div class="col-md-6">					
                                        <input type="text" class="form-control" style="width: 100%" id="firstname" placeholder="First name" onkeyup="nospaces(this)"/>	
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" style="width: 100%" id="lastname" placeholder="Last name" onkeyup="nospaces(this)"/>					
                                    </div>
                                </div>
                            </div><br/>	
                                 <input type="text" class="form-control" style="width: 100%" id="email" placeholder="Email" onkeyup="nospaces(this)"/>
                                  <span id="status_email"></span>
                                    <br/>					
                            <input type="text" class="form-control" style="width: 100%" id="usernameR" placeholder="user name" onkeyup="nospaces(this)"/> <span id="status"></span>
                           <br/>
                           <div class="inline-form">
							   <div class="row">
									<div class="col-md-6">
                             	<input type="password" class="form-control" style="width: 100%" id="passwordR" placeholder="password"/>
								</div><div class="col-md-6">
								<input type="password" class="form-control" style="width: 100%" id="password2R" placeholder="Re-enter password"/><br/><br/>
							</div></div></div>
                            <input type="submit" class="btn btn-primary btn-lg" id = "request" value = "Sign up" onclick="validateSignupFormOnSubmit()">
                        </div>
                    </div>
                </div>
            </div>
            <!--end modle-->
            <!-- Modal -->
            <div class="modal fade" id="forgetPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="width:370px; height:auto">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel"><font size="4" >Get Your password</font></h4>
                            <div class="alert_placeholder_nospace"> </div>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="html5Form"  class="form-horizontal">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email_forget_password" id="email_forget" placeholder="Enter Email" onkeyup="nospaces(this)"
                                    required data-bv-emailaddress-message="The input is not a valid email address" />
                                    <span id="status_email_forget_password"></span>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary" name="request_password"><font size="3" >Submit</font></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modle-->
            <?php include_once 'lib/html_inc_footers.php'; ?>
            <script type="text/javascript">
window.onload = function(){
  var text_input = document.getElementById ('username');
  text_input.focus ();
  text_input.select ();
}
</script>
            <script type="text/javascript">
                function checkForm() {
                    if (document.getElementById('password_1').value == document.getElementById('password_2').value) {
                        return true;
                    }
                    else {
                        alert("Passwords don't match");
                        return false;
                    }
                }
            </script>
            <script type="text/javascript">
                function nospaces(t){
                    if(t.value.match(/\s/g)){
                        bootstrap_alert(".alert_placeholder_nospace", "Sorry, you are not allowed to enter any spaces", 5000,"alert-warning");
                        t.value=t.value.replace(/\s/g,'');
                    }
                }
            </script>
    </body>
</html>
