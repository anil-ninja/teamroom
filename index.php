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
        <meta name="description" content="Challenge, Project, Problem solving, problem">
        <meta name="author" content="Anil">
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">

    </head>
    <body >
        <div class="navbar navbar-default navbar-fixed-top" >
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" style='font-size:16pt; color: #fff; font-weight: bold;' href="index.php">collap</a>
                    <div class="span3 pull-right">
                        <ul class="list-inline">
                            <li><p style='font-size:9pt; color:#fff;'>Powered By : </p></li>
                            <li><a class="btn-link" style='font-size:14pt; color: #fff; font-weight: bold;' href="http://dpower4.com/">Dpower4.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="background-image: url(img/collaboration.jpg); margin-top:-40px; height: 600px; max-width: 100%;">
            <div class = "col-xs-7 col-ls-8"></div>	
            <div class = "col-xs-2 col-ls-4" style="width:350px; height:500px; margin-top:50px;">
                <div class="bs-component">
                    <div class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                   
                                    <p align="center"><font size="5" >Vade the Clan</font></p>
                                </div>
                                <div class="modal-body">
                                     <div class="alert_placeholder"> </div>
                                    <br/>
                                    <div class="input-group">
                                        <span class="input-group-addon">Username</span>
                                        <input type="text" class="form-control" id="username" placeholder="Enter email or username">
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Password</span>
                                        <input type="password" class="form-control" id="password" placeholder="Password">
                                    </div><br/>
                                    <button type="submit" class="btn btn-success" name="request" value='login' onclick="validateLoginFormOnSubmit()">Log in</button>
                                </div>
                                <div class="modal-footer">
                                    <a data-toggle="modal" class="btn btn-primary" data-target="#myModal" style="float: right; cursor:pointer;">Join the Clan</a>
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
                            <h4 class="modal-title" id="myModalLabel"><font size="5" >Join the Clan</font></h4>
                            <div class="alert-placeholder"> </div>
                        </div>
                        <div class="modal-body">
                            <div class="inline-form">
								<div class="row">
									<div class="col-md-6">					
                                <input type="text" class="form-control" style="width: 100%" id="firstname" placeholder="First name" onkeyup="nospaces(this)"/>	
                                </div><div class="col-md-6">
                                <input type="text" class="form-control" style="width: 100%" id="lastname" placeholder="Last name" onkeyup="nospaces(this)"/>					
                            </div></div></div><br/>	
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
                            <input type="submit" class="btn btn-primary btn-lg" name = "request" value = "Join" onclick="validateSignupFormOnSubmit()">
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
					alert('Please, put Valid Username and Password');
				</script>";
                }
                if ($_GET['status'] == 0) {
                    echo "<script>
				alert('User registered successfully');
			</script>";
                }
                if ($_GET['status'] == 1) {
                    echo "<script>
				alert('Password do not match, Try again');
			</script>";
                }
                if ($_GET['status'] == 3) {
                    echo "<script>
				alert('User is already registered with this email, Please Sign In');
			</script>";
                }
                if ($_GET['status'] == 4) {
                    echo "<script>
				alert('User is already registered with this username, Please Sign In');
			</script>";
                }
            }
            ?>
    </body>
</html>
