<?php
session_start();
include_once 'html_comp/start_time.php';
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
        echo "<div class='jumbotron' style='margin-top: 60px; color: #2E1313;'>
                <p align='center'> Please check your Email, shortly you get an email, Go through your email and change your password<br>
                <br><a class='btn' href='index.php'>Go Back</a></p>
            </div>";
            //exit;
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
        echo "<div class='jumbotron' style='margin-top: 60px; color: #2E1313;'>
                <p align='center'> Please check your Email, shortly you get an email, Go through your email and change your password<br>
                <br><a class='btn' href='index.php'>Go Back</a></p>
            </div>";
            //exit;
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Welcome to collap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="p:domain_verify" content="c336f4706953c5ce54aa851d2d3da4b5"/>
    <link href="styles/bootstrap.min.css" rel="stylesheet" />
    <link href="styles/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="css/preview.min.css" rel="stylesheet" />
    <link href='../../fonts.googleapis.com/css%3Ffamily=PT+Sans:400,700.css' rel='stylesheet' type='text/css'>
    <link href="styles/font-awesome.min.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:800italic,400' rel='stylesheet' type='text/css'>


    <!--[if IE 7]>
        <link href="styles/font-awesome-ie7.min.css" rel="stylesheet" />
    <![endif]-->
    <!--[if IE 8]>
        <style type="text/css">
        .navbar-inner{
            filter:none;
        }
         </style>
        <![endif]-->
</head>
<body class=" ">
    <div class="alert_placeholder"></div>  <!-- alert for login -->
    <div class="alert-placeholder"></div>  <!-- alert for signup -->
    <div class="navbar navbar-default navbar-fixed-top" >
        <div class="navbar-inner" >
            <div class="container" >
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" style="font-size:16pt; color: #fff; font-weight: bold; font-family: 'Open Sans', sans-serif;" href="index.php">
                 <img src ='img/collap.gif' style="width:35px;"><i>collap</i>

                 </a>
                <div class="nav-collapse collapse navbar-responsive-collapse">
                    <?php
                    /*<ul class="nav">

                        <li class="dropdown">
                            <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">Layout<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="nav-header">Align</li>
                                <li><a href="index.html#demo-1">Top Align</a></li>
                                <li><a href="index.html#demo-2">Left Align</a></li>
                                <li><a href="index.html#demo-3">Right Align</a></li>
                                <li><a href="index.html#demo-4">Bottom Align</a></li>
                                <li><a href="index.html#demo-5">With Dropdown And Custom Content</a></li>
                                <li><a href="index.html#demo-6">Papper Stack</a></li>
                                <li><a href="index.html#demo-7">Tabs With Modal Popup</a></li>
                                <li><a href="index.html#demo-8">Features</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">Color Theme<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <li><a href="index.html#color" data-class=" " data-body="light">Light (Default)</a></li>
                                <li><a href="index.html#color" data-class="dark" data-body="">Dark</a></li>
                                <li><a href="index.html#color" data-class="dark dark-input" data-body="">Dark(Including Input)</a></li>
                                <li><a href="index.html#color" data-class="grey" data-color="">Grey </a></li>
                                <li><a href="index.html#color" data-class="grey dark-input" data-body="">Grey (Including Input)</a></li>


                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="index.html#s" class="dropdown-toggle" data-toggle="dropdown">BG Color<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="color-swatch">
                                    <div data-color="#c69c6d" title="Pale Worm Brown" data-class=""></div>
                                    <div data-color="#8c6239" title="Medium Warm Brown" data-class=""></div>
                                    <div data-color="#c7b299" title="Pale Cool Brown" data-class=""></div>
                                    <div data-color="rgb(102, 199, 235)" title="Pure Cyan" data-class=""></div>
                                    <div data-color="#00a651" title="Pure Green" data-class=""></div>
                                    <div data-color="#00a99d" title="Pure Green Cyan" data-class=""></div>
                                    <div data-color="#8dc63f" title="Pure Pea Green" data-class=""></div>
                                    <div data-color="rgb(241, 176, 72)" title="Orange" data-class=""></div>
                                    <div data-color="rgb(219, 124, 128)" title="Light Red" data-class=""></div>
                                    <div data-color="#A6A4CA" title="Light Violet" data-class=""></div>
                                    <div data-color="rgb(245,245,245)" title="Grey 5%" data-class="light"></div>
                                    <div data-color="rgb(215, 215, 215)" title="Grey 20%" data-class="light"></div>
                                    <div data-color="rgb(172, 172, 172)" title="Grey 40%" data-class=""></div>
                                    <div data-color="rgb(125, 125, 125)" title="Grey 60%" data-class=""></div>
                                    <div data-color="rgb(99, 99, 99)" title="Grey 70%" data-class=""></div>
                                    <div data-color="rgb(70, 70, 70)" title="Grey 80%" data-class=""></div>
                                    <div data-color="rgb(54, 54, 54)" title="Grey 85%" data-class=""></div>
                                    <div data-color="rgb(37, 37, 37)" title="Grey 90%" data-class=""></div>
                                    <!--div[data-color="#"]*15-->

                                </li>

                            </ul>

                        </li>
                        <li>
                            <a href="index.html#demo-6">Css3 Papper Stack</a>

                        </li>
                        <li style="padding-top: 8px; color: darkgray">
                            <label class="checkbox">
                                <a href="index.html#null" id="texture-check" data-toggle="button" class="btn btn-mini active"><i class="icon-ok"></i></a>
                                Background-Texture
                            </label>
                        </li>
                        <li></li>


                    </ul>
                    * */
                    ?>
                    <!--<a class='btn btn-default' style="font-size: 14px;" href="#tabSignIn" role="tab" data-toggle="tab">Sign In</a>-->
                
                <a href="index.php#panel1" data-toggle="tab" class=" btn pull-right active">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                
                </div>
                <!-- /.nav-collapse -->
            </div>
        </div>
        <!-- /navbar-inner -->
    </div>


    <div class="divider large visible-desktop"></div>
    <div class="divider  hidden-desktop"></div>

    <div class="container">



        <div class="row-fluid" id="demo-1">

            <div class="span10 offset1">
                <h4>Collaborate, Grow and help Society</h4>
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="index.php#panel1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Login</span></a></li>
                        <li><a href="index.php#panel2" data-toggle="tab"><i class="icon-user"></i>&nbsp;<span>Register</span></a></li>
                        <li><a href="index.php#panel3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                    <!--    <li><a href="index.html#panel4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li> -->
                    </ul>
                    <div class="tab-content ">

                        <div class="tab-pane active" id="panel1">
                            <div class="row-fluid">
                                <div class="span5">

                                    <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>
                                    
                                    <label>Username</label>
                                    <input type="text" class="input-block-level" id="username" placeholder="Email or Username"/>
                                    <label>Password </label>
                                    <input type="password" class="input-block-level" id="passwordlogin" placeholder="Password"/>
                                    <label>
                                    <!----    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                        &nbsp;&nbsp;&nbsp;Remember Me
                                    -->
                                        <a href="index.php#panel3" data-toggle="tab" class="pull-right"><i class="icon-question-sign"></i>&nbsp;Forgot Password</a>
                                    </label>
                                    <br />
                                    <a class=" btn " id="request" value='login' onclick="validateLoginFormOnSubmit()">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                </div>
                                <div class="span3">
                                    <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                    <div class="socials clearfix">
                                        <a href='https://www.facebook.com/pages/collapcom/739310236156746' class="icon-facebook facebook" target='_blank'></a>
                                        <a href='https://twitter.com/CollapCom' class="icon-twitter twitter" target='_blank'></a>
                                        <a href='https://plus.google.com/u/0/103215845490732646217/about' class="icon-google-plus google-plus" target='_blank'></a>
                                        <a href='https://www.pinterest.com/collapcom/' class="icon-pinterest pinterest" target='_blank'></a>
                                        <a class="icon-linkedin linked-in"></a>
                                        <a href='https://github.com/collapcom' class="icon-github github" target='_blank'></a>
                                    </div>
                                </div>
                                <div class="span4">
                                    <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
                                    <div class="box">
                                        <p>
                                            Collap.com provide set of features and functionality to registored user which help then in<br/>
                                            a. Project/Team management<br/>
                                            b. Give and Take Challenges/Idea<br/>
                                        </p>
                                        <p>
                                            Collap can be used by people in different domains. Collap is useful to Enterprinors, Prof., 
                                            students, Freelances and other organization or individuels.
                                        </p>
                                    </div>
                                    <div class="box">
                                        Don't Have An Account.<br />
                                        Click Here For <a href="index.php#panel2" data-toggle="tab">Free Register</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="panel2">
                            <div class="row-fluid">

                                <div class="span5">

                                    <h4><i class="icon-user"></i>&nbsp;&nbsp; Register Here</h4>

                                    <div>
                                        <div class='span6'>
        									<label>First Name</label>
                                            <input type="text" class="input-block-level" id="firstname" onkeyup="nospaces(this)"/>
                                        </div>
                                        <div class='span6'>
        									<label>Last Name</label>
        									<input type="text" class="input-block-level" id="lastname" onkeyup="nospaces(this)"/>                    
                                        </div>
                                    </div>

									<label>Email</label>
									<input type="email" class="input-block-level" id="email" onkeyup="nospaces(this)"/>
									<span id="status_email"></span>

                                    <label>Username</label>
                                    <input type="text" class="input-block-level" id="usernameR" onkeyup="nospaces(this)"/>
                                    
                                    <div>
                                        <div class='span6'>
                                            <label>Password </label>
                                            <input type="password" class="input-block-level" id="passwordR"/>
                                        </div>
                                        <div class='span6'>
                                            <label>Repeat Password</label>
                                            <input type="password" class="input-block-level" id="password2R"/>
                                        </div>
                                    </div>
                                    <label>
                                        <input type="checkbox" data-toggle="button" class="btn btn-mini custom-checkbox" id ='agree_tc' />

                                        &nbsp;&nbsp;&nbsp;I Aggree With 
                                        <a href="index.php#TabsModalTnC" data-toggle="modal">Terms &amp; Conditions</a>
                                    </label>
                                    <br />

                                    <a class=" btn " id = "request" onclick="validateSignupFormOnSubmit()">Register Now&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>

                                </div>
                                <div class="span3">
                                    <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                    <div class="socials clearfix">
                                        <a href='https://www.facebook.com/pages/collapcom/739310236156746' class="icon-facebook facebook" target='_blank'></a>
                                        <a href='https://twitter.com/CollapCom' target'_blank' class="icon-twitter twitter" target='_blank'></a>
                                        <a href='https://plus.google.com/u/0/' class="icon-google-plus google-plus" target='_blank'></a>
                                        <a class="icon-pinterest pinterest"></a>
                                        <a class="icon-linkedin linked-in"></a>
                                        <a class="icon-github github"></a>
                                    </div>
                                </div>
                                <div class="span4">
                                    <h4><i class="icon-question"></i>&nbsp;&nbsp;Login</h4>
                                    <div class="box">
                                        <p>
                                            Its your freedom to share ideas and connect with innovated, idealized minded person and help society to grow.
                                        </p>
                                        <p>
                                            Its good to be here, lets charge ourself.
                                        </p>
                                    </div>
                                    <div class="box">
                                        Already Have An Account.<br />
                                        Click Here For <a href="index.php#panel1" data-toggle="tab">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="panel3">
                            <div class="row-fluid">
                                <div class="span5">
                                    <h4><i class="icon-unlock"></i>&nbsp;&nbsp;Password Recovery</h4>
                                    <form method="POST">
                                    <label>Email</label>
                                    <input type="text" class="input-block-level" name="email_forget_password" id="email_forget" onkeyup="nospaces(this)"
                                    required data-bv-emailaddress-message="The input is not a valid email address" />
                                    <span id="status_email_forget_password"></span>

                                    <?php 
                                    /*
                                    <label>Security Question</label>
                                    <select class="input-block-level">
                                        <option disabled="disabled" selected="selected">---Select---</option>
                                        <option>Which Is Your First Mobile</option>
                                        <option>What Is Your Pet Name</option>
                                        <option>What Is Your Mother Name</option>
                                        <option>Which Is Your First Game</option>
                                    </select>
                                    <label>Answer</label>
                                    <input type="text" class="input-block-level" />
                                    
                                    
                                    */
                                    ?>
                                    <br />
                                    <br />
                                    <input type="submit" class=" btn" name="request_password" value = "Recover Password" />&nbsp;&nbsp;&nbsp;
                                </form>
                                </div>
                                <div class="span7">
                                    <h4><i class="icon-question"></i>&nbsp;&nbsp;Help</h4>
                                    <div class="box">
                                        <p>Getting Error With Password Recovery Click Here For <a href="index.php#">Support</a></p>
                                        <ul>
                                            
                                        </ul>
                                    </div>
                                    <div class="box">
                                        <ul>
                                            <li>Having repeated difficulty signing in?</li>
                                            <li>Clearing your browser's cache and cookies may help.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <?php 
    /*

   
                    <div id="panel4" class="tab-pane">
                        <div class="row-fluid">
                            <div class="span5">
                                <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                <label>Name</label>
                                <input type="text" value="" id="" class="input-block-level" />
                                <label>Email</label>
                                <input type="text" value="" id="Text1" class="input-block-level" />
                                <label>Mobile No</label>
                                <input type="text" value="" id="Text2" class="input-block-level" />
                                <label>Message</label>
                                <textarea class="input-block-level" rows="5"></textarea>
                                <a href="index.html#" class=" btn ">Send Message&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                <br class="visible-phone" />
                                <br class="visible-phone" />
                            </div>
                            <div class="span7">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Locate Us</h4>

                                        <div class="map"></div>

                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                        <address>
                                            <strong>Full Name</strong><br>
                                            <a href="mailto:#">first.last@example.com</a>
                                        </address>
                                    </div>
                                    <div class="span6">
                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Our Address</h4>

                                        <address>
                                            <strong>Twitter, Inc.</strong><br>
                                            795 Folsom Ave, Suite 600<br>
                                            San Francisco, CA 94107<br>
                                            <abbr title="Phone">P:</abbr>
                                            (123) 456-7890
                                        </address>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                                
                    <div class="divider bottom-preview"></div>
                    <div class="row-fluid" id="demo-2">
                        <div class="span10 offset1">
                            <h4>Responsive Tabbed Form Aligned Left</h4>
                            <div class="tabbable custom-tabs tabs-left tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="index.html#panel2-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Login Panel</span></a></li>
                                    <li><a href="index.html#panel2-2" data-toggle="tab"><i class="icon-user"></i>&nbsp;<span>Register Panel</span></a></li>
                                    <li><a href="index.html#panel2-3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                                    <li><a href="index.html#panel2-4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li>
                                </ul>
                                <div class="tab-content ">
                                    <div class="tab-pane active" id="panel2-1">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>

                                                <label>Username</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Password<a href="index.html#" class="pull-right"><i class="icon-question-sign"></i>&nbsp;Forgot Password</a> </label>
                                                <input type="password" class="input-block-level" />
                                                <label>
                                                    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                    &nbsp;&nbsp;&nbsp;Remember Me
                                                </label>
                                                <br />

                                                <a href="index.html#" class=" btn  ">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                            </div>
                                            <div class="span3">
                                                <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                <div class="socials clearfix">
                                                    <a class="icon-facebook facebook"></a>
                                                    <a class="icon-twitter twitter"></a>
                                                    <a class="icon-google-plus google-plus"></a>
                                                    <a class="icon-pinterest pinterest"></a>
                                                    <a class="icon-linkedin linked-in"></a>
                                                    <a class="icon-github github"></a>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
                                                <div class="box">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                    </p>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                    </p>
                                                </div>
                                                <div class="box">
                                                    Don't Have An Account.<br />
                                                    Click Here For <a href="index.html#panel2" data-toggle="tab">Free Register</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="panel2-2">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-user"></i>&nbsp;&nbsp; Register Here</h4>


                                                <label>Username</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Password </label>
                                                <input type="password" class="input-block-level" />
                                                <label>Repeat Password</label>
                                                <input type="password" class="input-block-level" />
                                                <label>
                                                    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                    &nbsp;&nbsp;&nbsp;I Aggree With <a href="index.html#">Terms &amp; Conditions</a>
                                                </label>
                                                <br />

                                                <a href="index.html#" class=" btn  ">Register Now&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>

                                            </div>
                                            <div class="span3">
                                                <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                <div class="socials clearfix">
                                                    <a class="icon-facebook facebook"></a>
                                                    <a class="icon-twitter twitter"></a>
                                                    <a class="icon-google-plus google-plus"></a>
                                                    <a class="icon-pinterest pinterest"></a>
                                                    <a class="icon-linkedin linked-in"></a>
                                                    <a class="icon-github github"></a>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Login</h4>
                                                <div class="box">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                    </p>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                    </p>
                                                </div>
                                                <div class="box">
                                                    Already Have An Account.<br />
                                                    Click Here For <a href="index.html#panel2" data-toggle="tab">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="panel2-3">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-unlock"></i>&nbsp;&nbsp;Password Recovery</h4>

                                                <label>Email</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Security Question</label>
                                                <select class="input-block-level">
                                                    <option disabled="disabled" selected="selected">---Select---</option>
                                                    <option>Which Is Your First Mobile</option>
                                                    <option>What Is Your Pet Name</option>
                                                    <option>What Is Your Mother Name</option>
                                                    <option>Which Is Your First Game</option>
                                                </select>
                                                <label>Answer</label>
                                                <input type="text" class="input-block-level" />
                                                <br />
                                                <br />
                                                <a href="index.html#" class=" btn  ">Recover Password&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                            </div>
                                            <div class="span7">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Help</h4>
                                                <div class="box">
                                                    <p>Getting Error With Password Recovery Click Here For <a href="index.html#">Support</a></p>
                                                    <ul>


                                                        <li>Vestibulum pharetra lectus montes lacus!</li>
                                                        <li>Iaculis lectus augue pulvinar taciti.</li>
                                                    </ul>

                                                </div>
                                                <div class="box">
                                                    <ul>
                                                        <li>Potenti facilisis felis sociis blandit euismod.</li>
                                                        <li>Odio mi hendrerit ad nostra.</li>
                                                        <li>Rutrum mi commodo molestie taciti.</li>
                                                        <li>Interdum ipsum ad risus conubia, porttitor.</li>
                                                        <li>Placerat litora, proin hac hendrerit ac volutpat.</li>
                                                        <li>Ornare, aliquam condimentum  habitasse.</li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div id="panel2-4" class="tab-pane">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                <label>Name</label>
                                                <input type="text" value="" id="Text3" class="input-block-level" />
                                                <label>Email</label>
                                                <input type="text" value="" id="Text4" class="input-block-level" />
                                                <label>Mobile No</label>
                                                <input type="text" value="" id="Text5" class="input-block-level" />
                                                <label>Message</label>
                                                <textarea class="input-block-level" rows="5"></textarea>
                                                <a href="index.html#" class=" btn ">Send Message&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                                <br class="visible-phone" />
                                                <br class="visible-phone" />
                                            </div>
                                            <div class="span7">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Locate Us</h4>

                                                        <div class="map"></div>

                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                        <address>
                                                            <strong>Full Name</strong><br>
                                                            <a href="mailto:#">first.last@example.com</a>
                                                        </address>
                                                    </div>
                                                    <div class="span6">
                                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Our Address</h4>

                                                        <address>
                                                            <strong>Twitter, Inc.</strong><br>
                                                            795 Folsom Ave, Suite 600<br>
                                                            San Francisco, CA 94107<br>
                                                            <abbr title="Phone">P:</abbr>
                                                            (123) 456-7890
                                                        </address>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="divider bottom-preview"></div>
                    <div class="row-fluid" id="demo-3">
                        <div class="span10 offset1">
                            <h4>Responsive Tabbed Form Aligned Right</h4>
                            <div class="tabbable custom-tabs tabs-right tabs-animated  flat flat-all hide-label-980 shadow  track-url auto-scroll">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="index.html#panel3-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Login Panel</span></a></li>
                                    <li><a href="index.html#panel3-2" data-toggle="tab"><i class="icon-user"></i>&nbsp;<span>Register Panel</span></a></li>
                                    <li><a href="index.html#panel3-3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                                    <li><a href="index.html#panel3-4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li>
                                </ul>
                                <div class="tab-content ">
                                    <div class="tab-pane active" id="panel3-1">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>

                                                <label>Username</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Password<a href="index.html#" class="pull-right"><i class="icon-question-sign"></i>&nbsp;Forgot Password</a> </label>
                                                <input type="password" class="input-block-level" />
                                                <label>
                                                    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                    &nbsp;&nbsp;&nbsp;Remember Me
                                                </label>
                                                <br />

                                                <a href="index.html#" class=" btn  ">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                            </div>
                                            <div class="span3">
                                                <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                <div class="socials clearfix">
                                                    <a class="icon-facebook facebook"></a>
                                                    <a class="icon-twitter twitter"></a>
                                                    <a class="icon-google-plus google-plus"></a>
                                                    <a class="icon-pinterest pinterest"></a>
                                                    <a class="icon-linkedin linked-in"></a>
                                                    <a class="icon-github github"></a>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
                                                <div class="box">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                    </p>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                    </p>
                                                </div>
                                                <div class="box">
                                                    Don't Have An Account.<br />
                                                    Click Here For <a href="index.html#panel2" data-toggle="tab">Free Register</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="panel3-2">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-user"></i>&nbsp;&nbsp; Register Here</h4>


                                                <label>Username</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Password </label>
                                                <input type="password" class="input-block-level" />
                                                <label>Repeat Password</label>
                                                <input type="password" class="input-block-level" />
                                                <label>
                                                    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                    &nbsp;&nbsp;&nbsp;I Aggree With <a href="index.html#">Terms &amp; Conditions</a>
                                                </label>
                                                <br />

                                                <a href="index.html#" class=" btn  ">Register Now&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>

                                            </div>
                                            <div class="span3">
                                                <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                <div class="socials clearfix">
                                                    <a class="icon-facebook facebook"></a>
                                                    <a class="icon-twitter twitter"></a>
                                                    <a class="icon-google-plus google-plus"></a>
                                                    <a class="icon-pinterest pinterest"></a>
                                                    <a class="icon-linkedin linked-in"></a>
                                                    <a class="icon-github github"></a>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Login</h4>
                                                <div class="box">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                    </p>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                    </p>
                                                </div>
                                                <div class="box">
                                                    Already Have An Account.<br />
                                                    Click Here For <a href="index.html#panel2" data-toggle="tab">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="panel3-3">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-unlock"></i>&nbsp;&nbsp;Password Recovery</h4>

                                                <label>Email</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Security Question</label>
                                                <select class="input-block-level">
                                                    <option disabled="disabled" selected="selected">---Select---</option>
                                                    <option>Which Is Your First Mobile</option>
                                                    <option>What Is Your Pet Name</option>
                                                    <option>What Is Your Mother Name</option>
                                                    <option>Which Is Your First Game</option>
                                                </select>
                                                <label>Answer</label>
                                                <input type="text" class="input-block-level" />
                                                <br />
                                                <br />
                                                <a href="index.html#" class=" btn  ">Recover Password&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                            </div>
                                            <div class="span7">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Help</h4>
                                                <div class="box">
                                                    <p>Getting Error With Password Recovery Click Here For <a href="index.html#">Support</a></p>
                                                    <ul>


                                                        <li>Vestibulum pharetra lectus montes lacus!</li>
                                                        <li>Iaculis lectus augue pulvinar taciti.</li>
                                                    </ul>

                                                </div>
                                                <div class="box">
                                                    <ul>
                                                        <li>Potenti facilisis felis sociis blandit euismod.</li>
                                                        <li>Odio mi hendrerit ad nostra.</li>
                                                        <li>Rutrum mi commodo molestie taciti.</li>
                                                        <li>Interdum ipsum ad risus conubia, porttitor.</li>
                                                        <li>Placerat litora, proin hac hendrerit ac volutpat.</li>
                                                        <li>Ornare, aliquam condimentum  habitasse.</li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div id="panel3-4" class="tab-pane">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                <label>Name</label>
                                                <input type="text" value="" id="Text6" class="input-block-level" />
                                                <label>Email</label>
                                                <input type="text" value="" id="Text7" class="input-block-level" />
                                                <label>Mobile No</label>
                                                <input type="text" value="" id="Text8" class="input-block-level" />
                                                <label>Message</label>
                                                <textarea class="input-block-level" rows="5"></textarea>
                                                <a href="index.html#" class=" btn ">Send Message&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                                <br class="visible-phone" />
                                                <br class="visible-phone" />
                                            </div>
                                            <div class="span7">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Locate Us</h4>

                                                        <div class="map"></div>

                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                        <address>
                                                            <strong>Full Name</strong><br>
                                                            <a href="mailto:#">first.last@example.com</a>
                                                        </address>
                                                    </div>
                                                    <div class="span6">
                                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Our Address</h4>

                                                        <address>
                                                            <strong>Twitter, Inc.</strong><br>
                                                            795 Folsom Ave, Suite 600<br>
                                                            San Francisco, CA 94107<br>
                                                            <abbr title="Phone">P:</abbr>
                                                            (123) 456-7890
                                                        </address>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="divider bottom-preview"></div>
                    <div class="row-fluid" id="demo-4">
                        <div class="span10 offset1">
                            <h4>Responsive Tabbed Form Aligned Bottom</h4>
                            <div class="tabbable custom-tabs tabs-below tabs-animated  flat flat-all hide-label-980 shadow  track-url auto-scroll">

                                <div class="tab-content ">
                                    <div class="tab-pane active" id="panel4-1">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>

                                                <label>Username</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Password<a href="index.html#" class="pull-right"><i class="icon-question-sign"></i>&nbsp;Forgot Password</a> </label>
                                                <input type="password" class="input-block-level" />
                                                <label>
                                                    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                    &nbsp;&nbsp;&nbsp;Remember Me
                                                </label>
                                                <br />

                                                <a href="index.html#" class=" btn  ">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                            </div>
                                            <div class="span3">
                                                <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                <div class="socials clearfix">
                                                    <a class="icon-facebook facebook"></a>
                                                    <a class="icon-twitter twitter"></a>
                                                    <a class="icon-google-plus google-plus"></a>
                                                    <a class="icon-pinterest pinterest"></a>
                                                    <a class="icon-linkedin linked-in"></a>
                                                    <a class="icon-github github"></a>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
                                                <div class="box">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                    </p>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                    </p>
                                                </div>
                                                <div class="box">
                                                    Don't Have An Account.<br />
                                                    Click Here For <a href="index.html#panel2" data-toggle="tab">Free Register</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="panel4-2">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-user"></i>&nbsp;&nbsp; Register Here</h4>


                                                <label>Username</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Password </label>
                                                <input type="password" class="input-block-level" />
                                                <label>Repeat Password</label>
                                                <input type="password" class="input-block-level" />
                                                <label>
                                                    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                    &nbsp;&nbsp;&nbsp;I Aggree With <a href="index.html#">Terms &amp; Conditions</a>
                                                </label>
                                                <br />

                                                <a href="index.html#" class=" btn  ">Register Now&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>

                                            </div>
                                            <div class="span3">
                                                <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                <div class="socials clearfix">
                                                    <a class="icon-facebook facebook"></a>
                                                    <a class="icon-twitter twitter"></a>
                                                    <a class="icon-google-plus google-plus"></a>
                                                    <a class="icon-pinterest pinterest"></a>
                                                    <a class="icon-linkedin linked-in"></a>
                                                    <a class="icon-github github"></a>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Login</h4>
                                                <div class="box">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                    </p>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                    </p>
                                                </div>
                                                <div class="box">
                                                    Already Have An Account.<br />
                                                    Click Here For <a href="index.html#panel2" data-toggle="tab">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="panel4-3">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-unlock"></i>&nbsp;&nbsp;Password Recovery</h4>

                                                <label>Email</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Security Question</label>
                                                <select class="input-block-level">
                                                    <option disabled="disabled" selected="selected">---Select---</option>
                                                    <option>Which Is Your First Mobile</option>
                                                    <option>What Is Your Pet Name</option>
                                                    <option>What Is Your Mother Name</option>
                                                    <option>Which Is Your First Game</option>
                                                </select>
                                                <label>Answer</label>
                                                <input type="text" class="input-block-level" />
                                                <br />
                                                <br />
                                                <a href="index.html#" class=" btn  ">Recover Password&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                            </div>
                                            <div class="span7">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Help</h4>
                                                <div class="box">
                                                    <p>Getting Error With Password Recovery Click Here For <a href="index.html#">Support</a></p>
                                                    <ul>


                                                        <li>Vestibulum pharetra lectus montes lacus!</li>
                                                        <li>Iaculis lectus augue pulvinar taciti.</li>
                                                    </ul>

                                                </div>
                                                <div class="box">
                                                    <ul>
                                                        <li>Potenti facilisis felis sociis blandit euismod.</li>
                                                        <li>Odio mi hendrerit ad nostra.</li>
                                                        <li>Rutrum mi commodo molestie taciti.</li>
                                                        <li>Interdum ipsum ad risus conubia, porttitor.</li>
                                                        <li>Placerat litora, proin hac hendrerit ac volutpat.</li>
                                                        <li>Ornare, aliquam condimentum  habitasse.</li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div id="panel4-4" class="tab-pane">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                <label>Name</label>
                                                <input type="text" value="" id="Text9" class="input-block-level" />
                                                <label>Email</label>
                                                <input type="text" value="" id="Text10" class="input-block-level" />
                                                <label>Mobile No</label>
                                                <input type="text" value="" id="Text11" class="input-block-level" />
                                                <label>Message</label>
                                                <textarea class="input-block-level" rows="5"></textarea>
                                                <a href="index.html#" class=" btn ">Send Message&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                                <br class="visible-phone" />
                                                <br class="visible-phone" />
                                            </div>
                                            <div class="span7">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Locate Us</h4>

                                                        <div class="map"></div>

                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                        <address>
                                                            <strong>Full Name</strong><br>
                                                            <a href="mailto:#">first.last@example.com</a>
                                                        </address>
                                                    </div>
                                                    <div class="span6">
                                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Our Address</h4>

                                                        <address>
                                                            <strong>Twitter, Inc.</strong><br>
                                                            795 Folsom Ave, Suite 600<br>
                                                            San Francisco, CA 94107<br>
                                                            <abbr title="Phone">P:</abbr>
                                                            (123) 456-7890
                                                        </address>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="index.html#panel4-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Login Panel</span></a></li>
                                    <li><a href="index.html#panel4-2" data-toggle="tab"><i class="icon-user"></i>&nbsp;<span>Register Panel</span></a></li>
                                    <li><a href="index.html#panel4-3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                                    <li><a href="index.html#panel4-4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="divider bottom-preview"></div>
                    <div id="demo-5" class="row-fluid">
                        <h4 class="clearfix text-center heading-4">Tabs With DropDown Tabs And Custom Content</h4>
                        <div class="row-fluid">
                            <div class="span6">

                                <div class="tabbable custom-tabs tabs-animated flat large shadow  track-url auto-scroll">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a class="active" href="index.html#panel5-1" data-toggle="tab">Panel 1</a></li>
                                        <li><a href="index.html#panel5-2" data-toggle="tab">Panel 2</a></li>
                                        <li><a href="index.html#panel5-3" data-toggle="tab">Panel 3</a></li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="index.html#"><i class="icon-angle-down"></i>Dropdown </a>
                                            <ul class="dropdown-menu">
                                                <li class="active"><a class="active" href="index.html#panel5-1" data-toggle="tab">Panel 1</a></li>
                                                <li><a href="index.html#panel5-2" data-toggle="tab">Panel 2</a></li>
                                                <li><a href="index.html#panel5-3" data-toggle="tab">Panel 3</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                    <div class="tab-content">
                                        <div id="panel5-1" class="tab-pane active">
                                            <ul>
                                                <li>Faith raatko face, arrow kobra kyle lantern gleeson atomic bennett scarecrow ragdoll pennyworth bartok prey jester master atom blue kane.</li>
                                                <li>Aquaman elongated rupert robin snake huntress pit kobra two kobra cain pennyworth faith hatter ivy batmobile hush tumbler selina oracle.</li>
                                                <li>Wing deadshot, crane abattoir supergirl batgirl lazarus maxie clench diamond lex green tumbler knight ghul supergirl joe grundy clayface jester.</li>
                                                <li>Hugo dick fairchild oswald zeus jester harlequin cain grayson canary batarang echo lucius supergirl falcone fright league thorne falcone shiva.</li>
                                                <li>Catwoman katana red manor joker superman carmine strange atomic diamond kane, kyle huntress clench thomas bane zucco outsider ali barrow.</li>
                                                <li>Joker young raatko lucius abbott thomas azrael hatter pit bennett red lazarus batmobile thomas quinn echo copperhead arrow canary quinn?</li>
                                            </ul>
                                        </div>

                                        <div class="tab-pane" id="panel5-2">
                                            <p>
                                                Convallis litora tempor maecenas rhoncus donec aliquet rutrum nullam bibendum ullamcorper dui maecenas fermentum aenean lacinia molestie augue risus sit.
                                            </p>
                                            <p>
                                                Senectus himenaeos pharetra, urna imperdiet ultrices sociosqu in proin convallis dolor habitasse eget consectetur senectus sagittis sociis orci suscipit mauris.
                                            </p>
                                            <p>
                                                Netus pharetra suspendisse nulla dui aliquet venenatis feugiat, odio rutrum massa hac mus vivamus laoreet semper primis rhoncus cras pellentesque.
                                            </p>
                                            <p>
                                                Velit feugiat montes arcu rutrum suspendisse et nam cras odio habitant donec sollicitudin viverra congue nascetur, mattis dolor eget est!
                                            </p>
                                            <p>
                                                Vestibulum vel mi augue odio platea primis vehicula, curabitur mattis nisl purus lacus imperdiet ac mollis suscipit vehicula aliquet diam.
                                            </p>

                                        </div>
                                        <div id="panel5-3" class="tab-pane">
                                            <p>
                                                Convallis tristique faucibus et pellentesque quis senectus posuere euismod curae;, rhoncus fermentum. Sed rhoncus commodo rhoncus. Dapibus vestibulum elementum placerat phasellus. Diam dolor, pulvinar ornare eleifend et. Mus hendrerit tortor metus dolor urna consectetur. Commodo nunc platea integer ridiculus quam lacinia facilisi dignissim elementum. Lorem bibendum primis at id fames tempor proin porttitor elementum risus pharetra. Per auctor, dictum a. Quam proin, molestie quam lorem montes primis. Lobortis euismod platea pharetra aliquam venenatis gravida potenti consectetur sapien arcu? Pharetra fames et duis interdum non posuere turpis donec in sollicitudin. Justo aenean, ligula class eleifend vestibulum nisl velit.
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <div class="divider visible-phone"></div>
                            </div>
                            <div class="span6">
                                <div class="tabbable custom-tabs tabs-animated flat large shadow  track-url auto-scroll">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="index.html#panel5-1-1" data-toggle="tab">Panel 1</a></li>
                                        <li><a href="index.html#panel5-1-2" data-toggle="tab">Panel 2</a></li>
                                        <li><a href="index.html#panel5-1-3" data-toggle="tab">Panel 3</a></li>

                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="index.html#"><i class="icon-angle-down"></i>Dropdown </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="index.html#panel5-1-1" data-toggle="tab">Panel 1</a></li>
                                                <li><a href="index.html#panel5-1-2" data-toggle="tab">Panel 2</a></li>
                                                <li><a href="index.html#panel5-1-3" data-toggle="tab">Panel 3</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="panel5-1-1">
                                            <p>
                                                Convallis litora tempor maecenas rhoncus donec aliquet rutrum nullam bibendum ullamcorper dui maecenas fermentum aenean lacinia molestie augue risus sit.
                                            </p>
                                            <p>
                                                Senectus himenaeos pharetra, urna imperdiet ultrices sociosqu in proin convallis dolor habitasse eget consectetur senectus sagittis sociis orci suscipit mauris.
                                            </p>
                                            <p>
                                                Netus pharetra suspendisse nulla dui aliquet venenatis feugiat, odio rutrum massa hac mus vivamus laoreet semper primis rhoncus cras pellentesque.
                                            </p>
                                            <p>
                                                Velit feugiat montes arcu rutrum suspendisse et nam cras odio habitant donec sollicitudin viverra congue nascetur, mattis dolor eget est!
                                            </p>
                                            <p>
                                                Vestibulum vel mi augue odio platea primis vehicula, curabitur mattis nisl purus lacus imperdiet ac mollis suscipit vehicula aliquet diam.
                                            </p>

                                        </div>
                                        <div id="panel5-1-2" class="tab-pane">

                                            <p>
                                                Vel est accumsan potenti pulvinar nisl primis augue. Cras, est vehicula nam elementum condimentum habitasse sollicitudin proin elementum urna magnis. Auctor imperdiet habitant mollis velit, euismod netus habitasse dolor primis dignissim lobortis vehicula. Blandit laoreet mollis curae; sollicitudin tempus urna vehicula pulvinar. Auctor habitasse aptent fringilla potenti pellentesque maecenas felis vehicula sapien! Sit dictum risus, congue consequat est vulputate taciti curae; morbi luctus blandit sem! Nam pellentesque feugiat dolor feugiat himenaeos vehicula cum. Congue lectus parturient mauris dapibus sociosqu venenatis.
                                            </p>
                                        </div>
                                        <div id="panel5-1-3" class="tab-pane">
                                            <ul>
                                                <li>Faith raatko face, arrow kobra kyle lantern gleeson atomic bennett scarecrow ragdoll pennyworth bartok prey jester master atom blue kane.</li>
                                                <li>Aquaman elongated rupert robin snake huntress pit kobra two kobra cain pennyworth faith hatter ivy batmobile hush tumbler selina oracle.</li>
                                                <li>Wing deadshot, crane abattoir supergirl batgirl lazarus maxie clench diamond lex green tumbler knight ghul supergirl joe grundy clayface jester.</li>
                                                <li>Hugo dick fairchild oswald zeus jester harlequin cain grayson canary batarang echo lucius supergirl falcone fright league thorne falcone shiva.</li>
                                                <li>Catwoman katana red manor joker superman carmine strange atomic diamond kane, kyle huntress clench thomas bane zucco outsider ali barrow.</li>
                                                <li>Joker young raatko lucius abbott thomas azrael hatter pit bennett red lazarus batmobile thomas quinn echo copperhead arrow canary quinn?</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="divider bottom-preview"></div>

                    <div class="row-fluid" id="demo-6">
                        <div class="span10 offset1">
                            <h4>Css3 Papper Stack Applied</h4>
                            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow papper-stack track-url auto-scroll">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="index.html#panel6-1-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Login Panel</span></a></li>
                                    <li><a href="index.html#panel6-1-2" data-toggle="tab"><i class="icon-user"></i>&nbsp;<span>Register Panel</span></a></li>
                                    <li><a href="index.html#panel6-1-3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                                    <li><a href="index.html#panel6-1-4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li>
                                </ul>
                                <div class="tab-content ">
                                    <div class="tab-pane active" id="panel6-1-1">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>

                                                <label>Username</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Password<a href="index.html#" class="pull-right"><i class="icon-question-sign"></i>&nbsp;Forgot Password</a> </label>
                                                <input type="password" class="input-block-level" />
                                                <label>
                                                    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                    &nbsp;&nbsp;&nbsp;Remember Me
                                                </label>
                                                <br />

                                                <a href="index.html#" class=" btn  ">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                            </div>
                                            <div class="span3">
                                                <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                <div class="socials clearfix">
                                                    <a class="icon-facebook facebook"></a>
                                                    <a class="icon-twitter twitter"></a>
                                                    <a class="icon-google-plus google-plus"></a>
                                                    <a class="icon-pinterest pinterest"></a>
                                                    <a class="icon-linkedin linked-in"></a>
                                                    <a class="icon-github github"></a>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
                                                <div class="box">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                    </p>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                    </p>
                                                </div>
                                                <div class="box">
                                                    Don't Have An Account.<br />
                                                    Click Here For <a href="index.html#panel2" data-toggle="tab">Free Register</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="panel6-1-2">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-user"></i>&nbsp;&nbsp; Register Here</h4>


                                                <label>Username</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Password </label>
                                                <input type="password" class="input-block-level" />
                                                <label>Repeat Password</label>
                                                <input type="password" class="input-block-level" />
                                                <label>
                                                    <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                    &nbsp;&nbsp;&nbsp;I Aggree With <a href="index.html#">Terms &amp; Conditions</a>
                                                </label>
                                                <br />

                                                <a href="index.html#" class=" btn  ">Register Now&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>

                                            </div>
                                            <div class="span3">
                                                <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                <div class="socials clearfix">
                                                    <a class="icon-facebook facebook"></a>
                                                    <a class="icon-twitter twitter"></a>
                                                    <a class="icon-google-plus google-plus"></a>
                                                    <a class="icon-pinterest pinterest"></a>
                                                    <a class="icon-linkedin linked-in"></a>
                                                    <a class="icon-github github"></a>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Login</h4>
                                                <div class="box">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                    </p>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                    </p>
                                                </div>
                                                <div class="box">
                                                    Already Have An Account.<br />
                                                    Click Here For <a href="index.html#panel2" data-toggle="tab">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="panel6-1-3">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-unlock"></i>&nbsp;&nbsp;Password Recovery</h4>

                                                <label>Email</label>
                                                <input type="text" class="input-block-level" />
                                                <label>Security Question</label>
                                                <select class="input-block-level">
                                                    <option disabled="disabled" selected="selected">---Select---</option>
                                                    <option>Which Is Your First Mobile</option>
                                                    <option>What Is Your Pet Name</option>
                                                    <option>What Is Your Mother Name</option>
                                                    <option>Which Is Your First Game</option>
                                                </select>
                                                <label>Answer</label>
                                                <input type="text" class="input-block-level" />
                                                <br />
                                                <br />
                                                <a href="index.html#" class=" btn  ">Recover Password&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                            </div>
                                            <div class="span7">
                                                <h4><i class="icon-question"></i>&nbsp;&nbsp;Help</h4>
                                                <div class="box">
                                                    <p>Getting Error With Password Recovery Click Here For <a href="index.html#">Support</a></p>
                                                    <ul>


                                                        <li>Vestibulum pharetra lectus montes lacus!</li>
                                                        <li>Iaculis lectus augue pulvinar taciti.</li>
                                                    </ul>

                                                </div>
                                                <div class="box">
                                                    <ul>
                                                        <li>Potenti facilisis felis sociis blandit euismod.</li>
                                                        <li>Odio mi hendrerit ad nostra.</li>
                                                        <li>Rutrum mi commodo molestie taciti.</li>
                                                        <li>Interdum ipsum ad risus conubia, porttitor.</li>
                                                        <li>Placerat litora, proin hac hendrerit ac volutpat.</li>
                                                        <li>Ornare, aliquam condimentum  habitasse.</li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div id="panel6-1-4" class="tab-pane">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                <label>Name</label>
                                                <input type="text" value="" id="Text15" class="input-block-level" />
                                                <label>Email</label>
                                                <input type="text" value="" id="Text16" class="input-block-level" />
                                                <label>Mobile No</label>
                                                <input type="text" value="" id="Text17" class="input-block-level" />
                                                <label>Message</label>
                                                <textarea class="input-block-level" rows="5"></textarea>
                                                <a href="index.html#" class=" btn ">Send Message&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                                <br class="visible-phone" />
                                                <br class="visible-phone" />
                                            </div>
                                            <div class="span7">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Locate Us</h4>

                                                        <div class="map"></div>

                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                        <address>
                                                            <strong>Full Name</strong><br>
                                                            <a href="mailto:#">first.last@example.com</a>
                                                        </address>
                                                    </div>
                                                    <div class="span6">
                                                        <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Our Address</h4>

                                                        <address>
                                                            <strong>Twitter, Inc.</strong><br>
                                                            795 Folsom Ave, Suite 600<br>
                                                            San Francisco, CA 94107<br>
                                                            <abbr title="Phone">P:</abbr>
                                                            (123) 456-7890
                                                        </address>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="divider bottom-preview"></div>
                    <div class="row-fluid text-center" id="demo-7">
                        <div class="span12">
                            <h4>Tabs Or Tabbed-Form  With Modal Popup</h4>

                            <a href="index.html#TabsModal" role="button" class="btn btn-large btn-inverse " data-toggle="modal">Click Here To Open</a>

                        </div>
                    </div>
                    <div id="TabsModal" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="row-fluid">
                            <div class="span10 offset1">

                                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="index.html#panel6-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Login Panel</span></a></li>
                                        <li><a href="index.html#panel6-2" data-toggle="tab"><i class="icon-user"></i>&nbsp;<span>Register Panel</span></a></li>
                                        <li><a href="index.html#panel6-3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                                        <li><a href="index.html#panel6-4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li>

                                        <li><a href="index.html#close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                                    </ul>
                                    <div class="tab-content ">
                                        <div class="tab-pane active" id="panel6-1">
                                            <div class="row-fluid">
                                                <div class="span5">
                                                    <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>

                                                    <label>Username</label>
                                                    <input type="text" class="input-block-level" />
                                                    <label>Password<a href="index.html#" class="pull-right"><i class="icon-question-sign"></i>&nbsp;Forgot Password</a> </label>
                                                    <input type="password" class="input-block-level" />
                                                    <label>
                                                        <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                        &nbsp;&nbsp;&nbsp;Remember Me
                                                    </label>
                                                    <br />

                                                    <a href="index.html#" class=" btn  ">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                                </div>
                                                <div class="span3">
                                                    <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                    <div class="socials clearfix">
                                                        <a class="icon-facebook facebook"></a>
                                                        <a class="icon-twitter twitter"></a>
                                                        <a class="icon-google-plus google-plus"></a>
                                                        <a class="icon-pinterest pinterest"></a>
                                                        <a class="icon-linkedin linked-in"></a>
                                                        <a class="icon-github github"></a>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
                                                    <div class="box">
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                        </p>
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                        </p>
                                                    </div>
                                                    <div class="box">
                                                        Don't Have An Account.<br />
                                                        Click Here For <a href="index.html#panel2" data-toggle="tab">Free Register</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="panel6-2">
                                            <div class="row-fluid">
                                                <div class="span5">
                                                    <h4><i class="icon-user"></i>&nbsp;&nbsp; Register Here</h4>


                                                    <label>Username</label>
                                                    <input type="text" class="input-block-level" />
                                                    <label>Password </label>
                                                    <input type="password" class="input-block-level" />
                                                    <label>Repeat Password</label>
                                                    <input type="password" class="input-block-level" />
                                                    <label>
                                                        <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                                        &nbsp;&nbsp;&nbsp;I Aggree With <a href="index.html#">Terms &amp; Conditions</a>
                                                    </label>
                                                    <br />

                                                    <a href="index.html#" class=" btn  ">Register Now&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>

                                                </div>
                                                <div class="span3">
                                                    <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp;Social</h4>
                                                    <div class="socials clearfix">
                                                        <a class="icon-facebook facebook"></a>
                                                        <a class="icon-twitter twitter"></a>
                                                        <a class="icon-google-plus google-plus"></a>
                                                        <a class="icon-pinterest pinterest"></a>
                                                        <a class="icon-linkedin linked-in"></a>
                                                        <a class="icon-github github"></a>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <h4><i class="icon-question"></i>&nbsp;&nbsp;Login</h4>
                                                    <div class="box">
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                                        </p>
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                                        </p>
                                                    </div>
                                                    <div class="box">
                                                        Already Have An Account.<br />
                                                        Click Here For <a href="index.html#panel2" data-toggle="tab">Login</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="panel6-3">
                                            <div class="row-fluid">
                                                <div class="span5">
                                                    <h4><i class="icon-unlock"></i>&nbsp;&nbsp;Password Recovery</h4>

                                                    <label>Email</label>
                                                    <input type="text" class="input-block-level" />
                                                    <label>Security Question</label>
                                                    <select class="input-block-level">
                                                        <option disabled="disabled" selected="selected">---Select---</option>
                                                        <option>Which Is Your First Mobile</option>
                                                        <option>What Is Your Pet Name</option>
                                                        <option>What Is Your Mother Name</option>
                                                        <option>Which Is Your First Game</option>
                                                    </select>
                                                    <label>Answer</label>
                                                    <input type="text" class="input-block-level" />
                                                    <br />
                                                    <br />
                                                    <a href="index.html#" class=" btn  ">Recover Password&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                                </div>
                                                <div class="span7">
                                                    <h4><i class="icon-question"></i>&nbsp;&nbsp;Help</h4>
                                                    <div class="box">
                                                        <p>Getting Error With Password Recovery Click Here For <a href="index.html#">Support</a></p>
                                                        <ul>


                                                            <li>Vestibulum pharetra lectus montes lacus!</li>
                                                            <li>Iaculis lectus augue pulvinar taciti.</li>
                                                        </ul>

                                                    </div>
                                                    <div class="box">
                                                        <ul>
                                                            <li>Potenti facilisis felis sociis blandit euismod.</li>
                                                            <li>Odio mi hendrerit ad nostra.</li>
                                                            <li>Rutrum mi commodo molestie taciti.</li>
                                                            <li>Interdum ipsum ad risus conubia, porttitor.</li>
                                                            <li>Placerat litora, proin hac hendrerit ac volutpat.</li>
                                                            <li>Ornare, aliquam condimentum  habitasse.</li>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div id="panel6-4" class="tab-pane">
                                            <div class="row-fluid">
                                                <div class="span5">
                                                    <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                    <label>Name</label>
                                                    <input type="text" value="" id="Text12" class="input-block-level" />
                                                    <label>Email</label>
                                                    <input type="text" value="" id="Text13" class="input-block-level" />
                                                    <label>Mobile No</label>
                                                    <input type="text" value="" id="Text14" class="input-block-level" />
                                                    <label>Message</label>
                                                    <textarea class="input-block-level" rows="5"></textarea>
                                                    <a href="index.html#" class=" btn ">Send Message&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                                    <br class="visible-phone" />
                                                    <br class="visible-phone" />
                                                </div>
                                                <div class="span7">
                                                    <div class="row-fluid">
                                                        <div class="span12">
                                                            <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Locate Us</h4>

                                                            <div class="map"></div>

                                                        </div>
                                                    </div>
                                                    <div class="row-fluid">
                                                        <div class="span6">
                                                            <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
                                                            <address>
                                                                <strong>Full Name</strong><br>
                                                                <a href="mailto:#">first.last@example.com</a>
                                                            </address>
                                                        </div>
                                                        <div class="span6">
                                                            <h4><i class="icon-location-arrow"></i>&nbsp;&nbsp;Our Address</h4>

                                                            <address>
                                                                <strong>Twitter, Inc.</strong><br>
                                                                795 Folsom Ave, Suite 600<br>
                                                                San Francisco, CA 94107<br>
                                                                <abbr title="Phone">P:</abbr>
                                                                (123) 456-7890
                                                            </address>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider bottom-preview"></div>
                    <div class="divider bottom-preview"></div>
                    <div id="demo-8" class="row-fluid">
                        <div class="span12 features">
                            <!--ul.unstyled.icons-ul>li.icon-li>i.icon-ok.icon-li-->
                            <div class="row-fluid">
                                <div class="span6">
                                    <h4>Features</h4>
                                    <!--div.tabbable.custom-tabs.shadow.-->
                                    <ul class="unstyled icons-ul">

                                        <li><i class="icon-chevron-sign-right icon-li"></i>Three Themes Included Light,BLack,Grey</li>
                                        <li><i class="icon-chevron-sign-right icon-li"></i>Responsive</li>
                                        <li><i class="icon-chevron-sign-right icon-li"></i>Also Works As A Modal Popup</li>
                                        <li><i class="icon-chevron-sign-right icon-li"></i>Dropdowns In Tabs</li>
                                        <li><i class="icon-chevron-sign-right icon-li"></i>Works With Any Type Of Content</li>
                                        <li><i class="icon-chevron-sign-right icon-li"></i>361 Icons To Choose From</li>
                                        <li><i class="icon-chevron-sign-right icon-li"></i>Can Be Targeted From Cross Site(Track Url Method)
                                            <a style="color:white" data-toggle="popover" title="Example" data-content="IF You Have A Tabs Control On Page, Default Is To Heighlight Tab With Active Class Applied , But With Track Url Method You Can Target Any Tab And It Just Got Highlighted ,Just Need To Include Panel Id In Url e.g=<b> http://www.yoursite.com/#panel4</b>"><i class="icon-question"></i></a>
                                            <a target="_blank" href="http://codefeed.in.iis2103.shared-servers.com/tabs/track-url-demo.html#panel2">Demo</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="span6">
                                    <div class="divider large"></div>
                                    <div class="divider large"></div>
                                    <a class="btn btn-large btn-inverse" href="https://wrapbootstrap.com/theme/tabs-control-tabbed-form-responsive-WB066F8J6">Go Back To WrapBootatrap MarketPlace</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="divider x-large"></div>
                    <div class="divider large"></div>

                </div>
*/
?>
         

    <script src="scripts/jquery-1.9.1.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/tabs-addon.js"></script>

    <script type="text/javascript">
        $(function ()
        {
            $("a[href^='#demo']").click(function (evt)
            {
                evt.preventDefault();
                var scroll_to = $($(this).attr("href")).offset().top;
                $("html,body").animate({ scrollTop: scroll_to - 80 }, 600);
            });
            $("a[href^='#bg']").click(function (evt)
            {
                evt.preventDefault();
                $("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-image", "url('bgs/" + $(this).data("file") + "')");
                console.log($(this).data("file"));


            });
            $("a[href^='#color']").click(function (evt)
            {
                evt.preventDefault();
                var elm = $(".tabbable");
                elm.removeClass("grey").removeClass("dark").removeClass("dark-input").addClass($(this).data("class"));
                if (elm.hasClass("dark dark-input"))
                {
                    $(".btn", elm).addClass("btn-inverse");
                }
                else
                {
                    $(".btn", elm).removeClass("btn-inverse");

                }

            });
            $(".color-swatch div").each(function ()
            {
                $(this).css("background-color", $(this).data("color"));
            });
            $(".color-swatch div").click(function (evt)
            {
                evt.stopPropagation();
                $("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-color", $(this).data("color"));
            });
            $("#texture-check").mouseup(function (evt)
            {
                evt.preventDefault();

                if (!$(this).hasClass("active"))
                {
                    $("body").css("background-image", "url(bgs/n1.png)");
                }
                else
                {
                    $("body").css("background-image", "none");
                }
            });

            $("a[href='#']").click(function (evt)
            {
                evt.preventDefault();

            });

            $("a[data-toggle='popover']").popover({
                trigger:"hover",html:true,placement:"top"
            });
        });

    </script>
    

    <script type="text/javascript" src="js/username_email_check.js"></script>
    <script type="text/javascript" src="js/signupValidation.js"></script>
    <script type="text/javascript" src="js/loginValidation.js"></script>
<?php include_once 'html_comp/terms_and_condition_modal.php'; ?>
</body>
</html>
