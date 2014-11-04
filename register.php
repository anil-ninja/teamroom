<?php 
session_start;
$email = $_GET['email'];
if (!isset($_SESSION['first_name'])) {
    
} else {
    header('Location: ninjas.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>register</title>
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
    <!-- Modal -->
    <div class="row">
    	<div class = "col-md-4"></div>	
        <div class = "col-md-4" style="width:auto; height:auto; margin-top:35px;">
            <div class="bs-component">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><font size="5" >Sign up for Collap</font></h4>
                            <div class="alert-placeholder"> </div>
                        </div>
                    <div class="modal-body">
                        <div class="inline-form" >
                            <div class="row">
                                <div class="col-md-6">					
                                    <input type="text" class="form-control" style="width: 100%" id="firstname" placeholder="First name" onkeyup="nospaces(this)"/>	
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" style="width: 100%" id="lastname" placeholder="Last name" onkeyup="nospaces(this)"/>					
                                </div>
                            </div>
                        </div>
                        <br/>	
                        <input type="text" class="form-control" value="<?= $_GET['email']; ?>" style="width: 100%" id="email" placeholder="Email" onkeyup="nospaces(this)"/>
                            <span id="status_email"></span>
                        <br/>					
                        <input type="text" class="form-control" style="width: 100%" id="usernameR" placeholder="user name" onkeyup="nospaces(this)"/> 
                            <span id="status"></span>
                        <br/>
                        <div class="inline-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="password" class="form-control" style="width: 100%" id="passwordR" placeholder="password"/>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" style="width: 100%" id="password2R" placeholder="Re-enter password"/><br/><br/>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary btn-lg" name = "request" value = "Sign up" onclick="validateSignupFormOnSubmit()">
                    </div>
                    </div>
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
        <script type="text/javascript" src="js/username_email_check.js"></script>
    </body>
</html>