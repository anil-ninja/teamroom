<?php
session_start();
$error = "";
include_once "controllers/login_controller.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta http-equiv="refresh" content="10" >
        <meta charset="utf-8">
	<title>TeamRoom</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Billing, Sharing, budget">
        <meta name="author" content="Anil">
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">
        
        
    </head>
    <body>
        <div class="row">  
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-inner">
                        <a class="btn-default" href="index.php"><h4>Ninjas</a>
                        <div class="span3 pull-right">
                            <ul class="list-inline">
                                <a class="btn-default" href="#">About</a>&nbsp;&nbsp;&nbsp;
                                <a class="btn-default" href="#">Contact</h4></a></ul> 
                        </div></div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class = "col-xs-3 col-ls-"></div>	
            <div class = "col-xs-3 col-ls-6" style="width:600px; height:500px">
                <div class="bs-component">
                    <div class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p align="center"><font size="5"  color="silver">Don't Punch Someone,
                                        <br/> Come to Ninjas and Kickasses</font></p>
                                </div>
                                <div class="modal-body">
                                    <form role="form" method="POST" class="form-horizontal" onsubmit="return validateLoginFormOnSubmit(this)">
                                        <br/>
                                        <div class="input-group">
                                            <span class="input-group-addon">Username</span>
                                            <input type="text" class="form-control" name="username" placeholder="Enter email or username">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Password</span>
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                        </div><br/>
                                        <button type="submit" class="btn btn-success" name="request" value='login'>Log in</button>
                                    </form></div>
                                <div class="modal-footer">
                                    <a data-toggle="modal" class="btn-default" data-target="#myModal" style="float: right; cursor:pointer;">Sign Up Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">New User Registration</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="POST" id="tablef" onsubmit="return validateSignupFormOnSubmit(this)">
                                <table>							
                                    <tr><div class="input-group" >
                                            <td>						
                                                <span class="input-group-addon">First Name</span>
                                            </td>
                                            <td>						
                                                <input type="text" class="form-control" name="firstname" placeholder="Enter your first name" onkeyup="nospaces(this)">
                                            </td>	
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="input-group" >
                                            <td>
                                                <span class="input-group-addon">Last Name</span>
                                            </td> 
                                            <td>	
                                                <input type="text" class="form-control" name="lastname" placeholder="Enter your last name" onkeyup="nospaces(this)">
                                            </td>
                                        </div>

                                    </tr>
                                    <tr>
                                        <div class="input-group" >
                                            <td>
                                                <span class="input-group-addon">Email ID</span>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="email" placeholder="Enter your Email" onkeyup="nospaces(this)" id="email"> <span id="status_email"></span>
                                            </td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="input-group" >
                                            <td>
                                                <span class="input-group-addon">Mobile No</span>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="phone" placeholder="Enter your Mobile Number" onkeyup="nospaces(this)">
                                            </td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="input-group" >
                                            <td>
                                                <span class="input-group-addon">Username</span>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="username" placeholder="Enter your user name" onkeyup="nospaces(this)" id="username"> <span id="status"></span>
                                            </td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="input-group" >
                                            <td>
                                                <span class="input-group-addon">Password </span>
                                            </td>
                                            <td>	
                                                <input type="password" class="form-control" name="password" placeholder="Enter your password">
                                            </td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="input-group" >
                                            <td>
                                                <span class="input-group-addon">re-enter Password</span>
                                            </td>
                                            <td>
                                                <input type="password" class="form-control" name="password2" placeholder="Enter your password">
                                            </td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="submit" class="btn btn-primary" name = "request" value = "Signup" >
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div class  ="modal-footer">
                            <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
            
<script type="text/javascript">
    document.getElementById("username").onblur = function() {

        var xmlhttp;

        var username=document.getElementById("username");
        if (username.value != ""){
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();

            } else {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    document.getElementById("status").innerHTML=xmlhttp.responseText;
            }
            };
            xmlhttp.open("GET","ajax/uname_availability.php?username="+encodeURIComponent(username.value),true);
            xmlhttp.send();
        }
    };
    document.getElementById("email").onblur = function() {

        var xmlhttp;

        var email=document.getElementById("email");
        if (email.value != ""){
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();

            } else {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    document.getElementById("status_email").innerHTML=xmlhttp.responseText;
            }
            };
            xmlhttp.open("GET","ajax/email_availability.php?email="+encodeURIComponent(email.value),true);
            xmlhttp.send();
        }
    };
</script>
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
