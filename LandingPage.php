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
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>collap</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenge, Project, Problem solving, problem, article, collaborate, collaboration">
        <meta name="author" content="Anil">
        <meta name="google-site-verification" content="T9t0-1XNcBUnzXn72xeFMde2N8j7v7IjT0gHy2jweq4" />
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
        <link href="css/landing-page.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="css/css.css" rel="stylesheet" type="text/css">
    </head>
<body >
    <!-- Navigation -->
    <div class="navbar navbar-default navbar-fixed-top">
        <div>
            <div class="col-md-2 navbar-header">
                 <a class="brand" style='font-size:16pt; color: #fff; font-weight: bold;' href="index.php">
                 <img src ='img/collap.gif' style="width:70px;">collap</a>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-2 navbar-header">
                <a data-toggle="modal" class="btn btn-primary" data-target="#signIn" style="float: right; cursor:pointer;">Sign In</a>
            </div>
            <!-- <div class="span3 pull-right">
                <ul class="list-inline" style='padding-top: 10px;'>
                    <li><p style='font-size:9pt; color:#fff;'>Powered By : </p></li>
                    <li><a class="btn-link" style='font-size:12pt; color: #fff; font-weight: bold;' href="http://dpower4.com/" target="_blank">Dpower4.com</a></li>
                </ul>
            </div> -->
        </div>
    </div>
    <!-- Header -->
    <div style="background-image: url(img/collaboration.jpg);">
    <div class="intro-header" >
        <div class="container">
            <div class="row">
                <div class = "col-md-7"></div> 
                <div class="col-md-5">
                <div class="col-md-3"></div>
                    <div class = "col-md-9" style="margin-top:50px;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               <h1 class='panel-title' style="font-size:21px; text-align:center;">Let's Collaborate!!</h1>
                                <div class="alert-placeholder"> </div>
                            </div>
                            <div class="panel-body">
                                <div class="inline-form">
                                    <div class="row">
                                        <div class="col-md-6" style="padding-left:0px">                  
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
                                        <div class="col-md-6" style="padding-left:0px">
                                    <input type="password" class="form-control" style="width: 100%" id="passwordR" placeholder="password"/>
                                    </div><div class="col-md-6">
                                    <input type="password" class="form-control" style="width: 100%" id="password2R" placeholder="Re-enter password"/><br/><br/>
                                </div></div></div>
                                <input type="submit" class="btn btn-primary btn-lg" id = "request" value = "Sign up" onclick="validateSignupFormOnSubmit()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
    <!-- /.intro-header -->
</div>
    <!-- Page Content -->

    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Collap.com<br></h2>
                    <p class="lead"><a target="_blank" href="http://dpower4.com/">dpower4.com</a> presents collap, a very powerfull collaboration tool that fits need of one and all.</p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="Landing%20Page%20-%20Start%20Bootstrap%20Theme_files/ipad.png" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

    <div class="content-section-b">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">3D Device Mockups<br>by PSDCovers</h2>
                    <p class="lead">Turn your 2D designs into high quality, 3D product shots in seconds using free Photoshop actions by <a target="_blank" href="http://www.psdcovers.com/">PSDCovers</a>! Visit their website to download some of their awesome, free photoshop actions!</p>
                </div>
                <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                    <img class="img-responsive" src="Landing%20Page%20-%20Start%20Bootstrap%20Theme_files/dog.png" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-b -->

    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Google Web Fonts and<br>Font Awesome Icons</h2>
                    <p class="lead">This template features the 'Lato' font, part of the <a target="_blank" href="http://www.google.com/fonts">Google Web Font library</a>, as well as <a target="_blank" href="http://fontawesome.io/">icons from Font Awesome</a>.</p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="Landing%20Page%20-%20Start%20Bootstrap%20Theme_files/phones.png" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

    <div class="banner">

        <div class="container">

            <div class="row">
                <div class="col-lg-6">
                    <h2>Connect to Start Bootstrap:</h2>
                </div>
                <div class="col-lg-6">
                    <ul class="list-inline banner-social-buttons">
                        <li>
                            <a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                        </li>
                        <li>
                            <a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.banner -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li>
                            <a href="#home">Home</a>
                        </li>
                        <li class="footer-menu-divider">⋅</li>
                        <li>
                            <a href="#about">About</a>
                        </li>
                        <li class="footer-menu-divider">⋅</li>
                        <li>
                            <a href="#services">Services</a>
                        </li>
                        <li class="footer-menu-divider">⋅</li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">Copyright © Your Company 2014. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="Landing%20Page%20-%20Start%20Bootstrap%20Theme_files/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="Landing%20Page%20-%20Start%20Bootstrap%20Theme_files/bootstrap.js"></script>




</body>
<?php mysqli_close($db_handle); ?>
</html>
