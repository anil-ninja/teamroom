<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    
} else {
    header('Location: ninjas.php');
}
//include_once "controllers/login_controller.php";
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
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">

    </head>
    <body >
    <div class="navbar navbar-default navbar-fixed-top">
        <div>
            <div class="col-md-2 navbar-header">
                 <a class="brand" style='font-size:16pt; color: #fff; font-weight: bold;' href="index.php">
                 <img src ='img/collap.gif' style="width:70px;">collap</a>
            </div>
            <div class="span3 pull-right">
                <ul class="list-inline">
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
                    <div class="modal">
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
                                        <input type="password" class="form-control" id="password" placeholder="Password">
                                    </div><br/>
                                    <button type="submit" class="btn btn-success" name="request" value='login' onclick="validateLoginFormOnSubmit()"><font size="3" >Log in</font></button>
                                    <a data-toggle="modal" data-target="#forgetPassword" style="float: right; cursor:pointer;"><font size="3" >Forget Password</font></a>
                                </div>
                                <div class="modal-footer">
                                    <button data-toggle="modal" class="btn btn-primary" data-target="#myModal" style="float: right; cursor:pointer;"><font size="3" >Sign up for Collap</font></button>
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
                            <input type="submit" class="btn btn-primary btn-lg" name = "request" value = "Sign up" onclick="validateSignupFormOnSubmit()">
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
                            
                        </div>
                        <div class="modal-body inline-form">
                            <input type="Email" class="form-control" style="width: 100%" id="email_forget_password" placeholder="Enter Email" onkeyup="nospaces(this)"
                                   data-bv-emailaddress-message="The value is not a valid email address" />
                            <span id="status_email_forget_password"></span>
                            <br>
                            <button type="submit" class="btn-primary" name="request_password"><font size="3" >Send Link</font></button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modle-->

            <script src="js/jquery-1.js"></script>
            <script src="js/bootstrap.js"></script>

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

            <script src="js/jquery.js"></script>
            <script src="js/bootstrap.min.js"></script>

            <script type="text/javascript" src="js/signupValidation.js"></script>
            <script type="text/javascript" src="js/loginValidation.js"></script>

            <script type="text/javascript">
                function nospaces(t){
                    if(t.value.match(/\s/g)){
                        alert('Sorry, you are not allowed to enter any spaces');
                        t.value=t.value.replace(/\s/g,'');
                    }
                }
            </script>
            <!-----signup valiation ends -------------and login validation added here--->

            <script type="text/javascript" src="js/username_email_check.js"></script>
            
            <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 2) {
                    echo "<script> 
					alert('Invalid Username and Password');
				</script>";
                }
                if ($_GET['status'] == 0) {
                    echo "<script>
				alert('User registered successfully');
			</script>";
                }
                if ($_GET['status'] == 1) {
                    echo "<script>
				alert('Password don't match, Try again');
			</script>";
                }
                if ($_GET['status'] == 3) {
                    echo "<script>
				alert('Email ID already registered, Please Sign In');
			</script>";
                }
                if ($_GET['status'] == 4) {
                    echo "<script>
				alert('Username is already registered, Please Sign In');
			</script>";
                }
            }
            ?>
    </body>
</html>
