<?php 
session_start;
include_once 'lib/db_connect.php';
$email_id = $_GET['email_id'];

?>
<!DOCTYPE html>
<html lang="en">
<title>register</title>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/profile_page_style.css">
        
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	
	<link href="css/font-awesome.css" rel="stylesheet">
	<script src="js/jquery.js"> </script>
	<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery.autosize.js"></script>
    </head>

    <body>
    <?php include_once 'html_comp/navbar_homepage.php'; ?>

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
	                                </div><div class="col-md-6">
	                                <input type="text" class="form-control" style="width: 100%" id="lastname" placeholder="Last name" onkeyup="nospaces(this)"/>					
	                            </div></div></div><br/>	
	                                 <input type="email" method="get" class="form-control" value="<?= $_GET['email']; ?>" style="width: 100%" id="email" placeholder="Email" onkeyup="nospaces(this)"/>
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
    <?php 
    	session_close;
    ?>