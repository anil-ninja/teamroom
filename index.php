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
    <title>Tabbed Forms And Tab Controls Live Preview</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<?php /*
	<div class="navbar navbar-default navbar-fixed-top">
        <div class="row">
            <div class="col-md-2 navbar-header">
                 <a class="brand" style='font-size:16pt; color: #fff; font-weight: bold;' href="index.php">
                 <img src ='img/collap.gif' style="width:70px;">collap</a>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-2 navbar-header pull-right" style="padding-top: 5px;">
                
                    <a class='btn btn-default' style="font-size: 14px;" href="#tabSignIn" role="tab" data-toggle="tab">Sign In</a>
                 
            </div>
        </div>
<!--subnavbar added here -->
        <div class='nav navbar-inverse'>
            <div class='col-md-offset-3 col-md-9 col-lg-9'>
                <div class='list-inline' style='background:#3BD78C;'>
                </div>
            </div>
        </div>
<!--subnavbar ends here -->
    </div>
<!----navigation ends -->
*/?>

    <div class="navbar navbar-default navbar-fixed-top" >
        <div class="navbar-inner" >
            <div class="container" >
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" style="font-size:16pt; color: #fff; font-weight: bold; font-family: 'Open Sans', sans-serif;" href="index.php">
                 <img src ='img/collap.gif' style="width:35px;">collap</a>
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
                
                <a href="index.html#panel1" data-toggle="tab" class=" btn pull-right active">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                
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
                <h4>Collaborate Grow and help Society</h4>
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="index.html#panel1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Login</span></a></li>
                        <li><a href="index.html#panel2" data-toggle="tab"><i class="icon-user"></i>&nbsp;<span>Register</span></a></li>
                        <li><a href="index.html#panel3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                    <!--    <li><a href="index.html#panel4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li> -->
                    </ul>
                    <div class="tab-content ">
                        <div class="tab-pane active" id="panel1">
                            <div class="row-fluid">
                                <div class="span5">
                                    <h4><i class="icon-user"></i>&nbsp;&nbsp; Login Here</h4>

                                    <label>Username</label>
                                    <input type="text" class="input-block-level" id="username" placeholder="Email or Username"/>
                                    <label>Password<a href="index11.php#panel3" data-toggle="tab" class="pull-right"><i class="icon-question-sign"></i>&nbsp;Forgot Password</a> </label>
                                    <input type="password" class="input-block-level" id="passwordlogin" placeholder="Password"/>
                                    <label>
                                        <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                        &nbsp;&nbsp;&nbsp;Remember Me
                                    </label>
                                    <br />

                                    <a class=" btn " id="request" value='login' onclick="validateLoginFormOnSubmit()">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
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
                                        Click Here For <a href="index.html#panel2" data-toggle="tab">Free Register</a>
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
									<input type="text" class="input-block-level" id="email" onkeyup="nospaces(this)"/>
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
                                        <button type="button" data-toggle="button" class="btn btn-mini custom-checkbox active"><i class="icon-ok"></i></button>
                                        &nbsp;&nbsp;&nbsp;I Aggree With 
                                        <a href="index.html#TabsModalTnC" data-toggle="modal">Terms &amp; Conditions</a>
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
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel.
                                        </p>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit fusce vel sapien elit in.
                                        </p>
                                    </div>
                                    <div class="box">
                                        Already Have An Account.<br />
                                        Click Here For <a href="index.html#panel1" data-toggle="tab">Login</a>
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
                    </div>
                </div>
            </div>
        </div>
        <div id="TabsModalTnC" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="row-fluid">
                <div class="span10 offset1">

                    <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="index.html#panel6-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Terms &amp; Conditions</span></a></li>
                            
                            <li><a href="index.html#close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                        </ul>
                        <div class="tab-content ">
                            
                            <h2>Statement of Rights and Responsibilities</h2>
                            <p>
                            This Statement of Rights and Responsibilities ("Statement," "Terms," or "SRR") derives from the Collap.com Principles, and is our terms of service that governs our relationship with users and others who interact with Collap. By using or accessing Collap, you agree to this Statement, as updated from time to time in accordance with Section 14 below. Additionally, you will find resources at the end of this document that help you understand how Collap works.
                            Privacy: Your privacy is very important to us. We designed our Data Use Policy to make important disclosures about how you can use Collap to share with others and how we collect and can use your content and information.
                            Sharing Your Content and Information: You own all of the content and information you post on Collap, and you can control how it is shared through your privacy and application settings. In addition:
                            For content that is covered by intellectual property rights, like photos and videos (IP content), you specifically give us the following permission, subject to your privacy and application settings: you grant us a non-exclusive, transferable, sub-licensable, royalty-free, worldwide license to use any IP content that you post on or in connection with Collap (IP License). This IP License ends when you delete your IP content or your account unless your content has been shared with others, and they have not deleted it.
                            When you delete IP content, it is deleted in a manner similar to emptying the recycle bin on a computer. However, you understand that removed content may persist in backup copies for a reasonable period of time (but will not be available to others).
                            When you use an application, the application may ask for your permission to access your content and information as well as content and information that others have shared with you.  We require applications to respect your privacy, and your agreement with that application will control how the application can use, store, and transfer that content and information.  (To learn more about Platform, including how you can control what information other people may share with applications, read our Data Use Policy and Platform Page.)
                            When you publish content or information using the Public setting, it means that you are allowing everyone, including people off of Collap, to access and use that information, and to associate it with you (i.e., your name and profile picture).
                            We always appreciate your feedback or other suggestions about Collap, but you understand that we may use them without any obligation to compensate you for them (just as you have no obligation to offer them).
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b>Safety</b></span>
                            <p>
                            We do our best to keep Collap safe, but we cannot guarantee it. We need your help to keep Collap safe, which includes the following commitments by you:
                            You will not post unauthorized commercial communications (such as spam) on Collap.
                            You will not collect users' content or information, or otherwise access Collap, using automated means (such as harvesting bots, robots, spiders, or scrapers) without our prior permission.
                            You will not engage in unlawful multi-level marketing, such as a pyramid scheme, on Collap.
                            You will not upload viruses or other malicious code.
                            You will not solicit login information or access an account belonging to someone else.
                            You will not bully, intimidate, or harass any user.
                            You will not post content that: is hate speech, threatening, or pornographic; incites violence; or contains nudity or graphic or gratuitous violence.
                            You will not develop or operate a third-party application containing alcohol-related, dating or other mature content (including advertisements) without appropriate age-based restrictions.
                            You will follow our Promotions Guidelines and all applicable laws if you publicize or offer any contest, giveaway, or sweepstakes (“promotion”) on Collap.
                            You will not use Collap to do anything unlawful, misleading, malicious, or discriminatory.
                            You will not do anything that could disable, overburden, or impair the proper working or appearance of Collap, such as a denial of service attack or interference with page rendering or other Collap functionality.
                            You will not facilitate or encourage any violations of this Statement or our policies.
                            </p>
                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Registration and Account Security</b></span></p>
                            <p>
                            Collap users provide their real names and information, and we need your help to keep it that way. Here are some commitments you make to us relating to registering and maintaining the security of your account:
                            You will not provide any false personal information on Collap, or create an account for anyone other than yourself without permission.
                            You will not create more than one personal account.
                            If we disable your account, you will not create another one without our permission.
                            You will not use your personal timeline primarily for your own commercial gain, and will use a Collap Page for such purposes.
                            You will not use Collap if you are under 13.
                            You will not use Collap if you are a convicted sex offender.
                            You will keep your contact information accurate and up-to-date.
                            You will not share your password (or in the case of developers, your secret key), let anyone else access your account, or do anything else that might jeopardize the security of your account.
                            You will not transfer your account (including any Page or application you administer) to anyone without first getting our written permission.
                            If you select a username or similar identifier for your account or Page, we reserve the right to remove or reclaim it if we believe it is appropriate (such as when a trademark owner complains about a username that does not closely relate to a user's actual name).
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Protecting Other People's Rights</b></span></p>

                            <p>
                            We respect other people's rights, and expect you to do the same.
                            You will not post content or take any action on Collap that infringes or violates someone else's rights or otherwise violates the law.
                            We can remove any content or information you post on Collap if we believe that it violates this Statement or our policies.
                            We provide you with tools to help you protect your intellectual property rights. To learn more, visit our How to Report Claims of Intellectual Property Infringement page.
                            If we remove your content for infringing someone else's copyright, and you believe we removed it by mistake, we will provide you with an opportunity to appeal.
                            If you repeatedly infringe other people's intellectual property rights, we will disable your account when appropriate.
                            You will not use our copyrights or trademarks (including Collap, the Collap and F Logos, FB, Face, Poke, Book and Wall), or any confusingly similar marks, except as expressly permitted by our Brand Usage Guidelines or with our prior written permission.
                            If you collect information from users, you will: obtain their consent, make it clear you (and not Collap) are the one collecting their information, and post a privacy policy explaining what information you collect and how you will use it.
                            You will not post anyone's identification documents or sensitive financial information on Collap.
                            You will not tag users or send email invitations to non-users without their consent. Collap offers social reporting tools to enable users to provide feedback about tagging.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Mobile and Other Devices</b></span></p>

                            <p>
                            We currently provide our mobile services for free, but please be aware that your carrier's normal rates and fees, such as text messaging and data charges, will still apply.
                            In the event you change or deactivate your mobile telephone number, you will update your account information on Collap within 48 hours to ensure that your messages are not sent to the person who acquires your old number.
                            You provide consent and all rights necessary to enable users to sync (including through an application) their devices with any information that is visible to them on Collap.

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Payments</b></span></p>

                            <p>
                            If you make a payment on Collap or use Collap Credits, you agree to our Payments Terms.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Special Provisions Applicable to Social Plugins</b></span></p>

                            <p>
                            If you include our Social Plugins, such as the Share or Like buttons on your website, the following additional terms apply to you:
                            We give you permission to use Collap's Social Plugins so that users can post links or content from your website on Collap.
                            You give us permission to use and allow others to use such links and content on Collap.
                            You will not place a Social Plugin on any page containing content that would violate this Statement if posted on Collap.
                            </p>
                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Special Provisions Applicable to Developers/Operators of Applications and Websites</b></span></p>

                            <p>
                            If you are a developer or operator of a Platform application or website, the following additional terms apply to you:
                            You are responsible for your application and its content and all uses you make of Platform. This includes ensuring your application or use of Platform meets our Collap Platform Policies and our Advertising Guidelines.
                            Your access to and use of data you receive from Collap, will be limited as follows:
                            You will only request data you need to operate your application.
                            You will have a privacy policy that tells users what user data you are going to use and how you will use, display, share, or transfer that data and you will include your privacy policy URL in the Developer Application.
                            You will not use, display, share, or transfer a user’s data in a manner inconsistent with your privacy policy.
                            You will delete all data you receive from us concerning a user if the user asks you to do so, and will provide a mechanism for users to make such a request.
                            You will not include data you receive from us concerning a user in any advertising creative.
                            You will not directly or indirectly transfer any data you receive from us to (or use such data in connection with) any ad network, ad exchange, data broker, or other advertising related toolset, even if a user consents to that transfer or use.
                            You will not sell user data.  If you are acquired by or merge with a third party, you can continue to use user data within your application, but you cannot transfer user data outside of your application. 
                            We can require you to delete user data if you use it in a way that we determine is inconsistent with users’ expectations.
                            We can limit your access to data.
                            You will comply with all other restrictions contained in our Collap Platform Policies.
                            You will not give us information that you independently collect from a user or a user's content without that user's consent.
                            You will make it easy for users to remove or disconnect from your application.
                            You will make it easy for users to contact you. We can also share your email address with users and others claiming that you have infringed or otherwise violated their rights.
                            You will provide customer support for your application.
                            You will not show third party ads or web search boxes on www.Collap.com.
                            We give you all rights necessary to use the code, APIs, data, and tools you receive from us.
                            You will not sell, transfer, or sublicense our code, APIs, or tools to anyone.
                            You will not misrepresent your relationship with Collap to others.
                            You may use the logos we make available to developers or issue a press release or other public statement so long as you follow our Collap Platform Policies.
                            We can issue a press release describing our relationship with you.
                            You will comply with all applicable laws. In particular you will (if applicable):
                            have a policy for removing infringing content and terminating repeat infringers that complies with the Digital Millennium Copyright Act.
                            comply with the Video Privacy Protection Act (VPPA), and obtain any opt-in consent necessary from users so that user data subject to the VPPA may be shared on Collap.  You represent that any disclosure to us will not be incidental to the ordinary course of your business.
                            We do not guarantee that Platform will always be free.
                            You give us all rights necessary to enable your application to work with Collap, including the right to incorporate content and information you provide to us into streams, timelines, and user action stories.
                            You give us the right to link to or frame your application, and place content, including ads, around your application.
                            We can analyze your application, content, and data for any purpose, including commercial (such as for targeting the delivery of advertisements and indexing content for search).
                            To ensure your application is safe for users, we can audit it.
                            We can create applications that offer similar features and services to, or otherwise compete with, your application.
                             </p>

                             <p style="text-align: justify;"><span style="color: #993300;"><b>
                            About Advertisements and Other Commercial Content Served or Enhanced by Collap</b></span></p>

                            <p>
                            Our goal is to deliver advertising and other commercial or sponsored content that is valuable to our users and advertisers. In order to help us do that, you agree to the following:
                            You give us permission to use your name, profile picture, content, and information in connection with commercial, sponsored, or related content (such as a brand you like) served or enhanced by us. This means, for example, that you permit a business or other entity to pay us to display your name and/or profile picture with your content or information, without any compensation to you. If you have selected a specific audience for your content or information, we will respect your choice when we use it.
                            We do not give your content or information to advertisers without your consent.
                            You understand that we may not always identify paid services and communications as such.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Special Provisions Applicable to Advertisers</b></span></p>

                            <p>
                            You can target your desired audience by buying ads on Collap or our publisher network. The following additional terms apply to you if you place an order through our online advertising portal (Order):
                            When you place an Order, you will tell us the type of advertising you want to buy, the amount you want to spend, and your bid. If we accept your Order, we will deliver your ads as inventory becomes available. When serving your ad, we do our best to deliver the ads to the audience you specify, although we cannot guarantee in every instance that your ad will reach its intended target.
                            In instances where we believe doing so will enhance the effectiveness of your advertising campaign, we may broaden the targeting criteria you specify.
                            You will pay for your Orders in accordance with our Payments Terms. The amount you owe will be calculated based on our tracking mechanisms.
                            Your ads will comply with our Advertising Guidelines.
                            We will determine the size, placement, and positioning of your ads.
                            We do not guarantee the activity that your ads will receive, such as the number of clicks your ads will get.
                            We cannot control how clicks are generated on your ads. We have systems that attempt to detect and filter certain click activity, but we are not responsible for click fraud, technological issues, or other potentially invalid click activity that may affect the cost of running ads.
                            You can cancel your Order at any time through our online portal, but it may take up to 24 hours before the ad stops running.  You are responsible for paying for all ads that run.
                            Our license to run your ad will end when we have completed your Order. You understand, however, that if users have interacted with your ad, your ad may remain until the users delete it.
                            We can use your ads and related content and information for marketing or promotional purposes.
                            You will not issue any press release or make public statements about your relationship with Collap without our prior written permission.
                            We may reject or remove any ad for any reason.
                            If you are placing ads on someone else's behalf, you must have permission to place those ads, including the following:
                            You warrant that you have the legal authority to bind the advertiser to this Statement.
                            You agree that if the advertiser you represent violates this Statement, we may hold you responsible for that violation.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Special Provisions Applicable to Pages</b></span></p>

                            <p>
                            If you create or administer a Page on Collap, or run a promotion or an offer from your Page, you agree to our Pages Terms.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Special Provisions Applicable to Software</b></span></p>

                            <p>
                            If you download or use our software, such as a stand-alone software product, an app, or a browser plugin, you agree that from time to time, the software may download and install upgrades, updates and additional features from us in order to improve, enhance, and further develop the software.
                            You will not modify, create derivative works of, decompile, or otherwise attempt to extract source code from us, unless you are expressly permitted to do so under an open source license, or we give you express written permission.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b>
                            Amendments</b></span></p>

                            <p>
                            Unless we make a change for legal or administrative reasons, or to correct an inaccurate statement, we will provide you with seven (7) days notice (for example, by posting the change on the Collap Site Governance Page) and an opportunity to comment on changes to this Statement.  You can also visit our Collap Site Governance Page and "like" the Page to get updates about changes to this Statement.
                            If we make changes to policies referenced in or incorporated by this Statement, we may provide notice on the Site Governance Page.
                            Your continued use of Collap following changes to our terms constitutes your acceptance of our amended terms.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Termination</b></span></p>

                            <p>
                            If you violate the letter or spirit of this Statement, or otherwise create risk or possible legal exposure for us, we can stop providing all or part of Collap to you. We will notify you by email or at the next time you attempt to access your account. You may also delete your account or disable your application at any time. In all such cases, this Statement shall terminate, but the following provisions will still apply: 2.2, 2.4, 3-5, 8.2, 9.1-9.3, 9.9, 9.10, 9.13, 9.15, 9.18, 10.3, 11.2, 11.5, 11.6, 11.9, 11.12, 11.13, and 15-19.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b> 
                            Disputes</b></span></p>

                            <p>
                            You will resolve any claim, cause of action or dispute (claim) you have with us arising out of or relating to this Statement or Collap exclusively in the U.S. District Court for the Northern District of California or a state court located in San Mateo County, and you agree to submit to the personal jurisdiction of such courts for the purpose of litigating all such claims. The laws of the State of California will govern this Statement, as well as any claim that might arise between you and us, without regard to conflict of law provisions.
                            If anyone brings a claim against us related to your actions, content or information on Collap, you will indemnify and hold us harmless from and against all damages, losses, and expenses of any kind (including reasonable legal fees and costs) related to such claim. Although we provide rules for user conduct, we do not control or direct users' actions on Collap and are not responsible for the content or information users transmit or share on Collap. We are not responsible for any offensive, inappropriate, obscene, unlawful or otherwise objectionable content or information you may encounter on Collap. We are not responsible for the conduct, whether online or offline, or any user of Collap.
                            WE TRY TO KEEP Collap UP, BUG-FREE, AND SAFE, BUT YOU USE IT AT YOUR OWN RISK. WE ARE PROVIDING Collap AS IS WITHOUT ANY EXPRESS OR IMPLIED WARRANTIES INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT. WE DO NOT GUARANTEE THAT Collap WILL ALWAYS BE SAFE, SECURE OR ERROR-FREE OR THAT Collap WILL ALWAYS FUNCTION WITHOUT DISRUPTIONS, DELAYS OR IMPERFECTIONS. Collap IS NOT RESPONSIBLE FOR THE ACTIONS, CONTENT, INFORMATION, OR DATA OF THIRD PARTIES, AND YOU RELEASE US, OUR DIRECTORS, OFFICERS, EMPLOYEES, AND AGENTS FROM ANY CLAIMS AND DAMAGES, KNOWN AND UNKNOWN, ARISING OUT OF OR IN ANY WAY CONNECTED WITH ANY CLAIM YOU HAVE AGAINST ANY SUCH THIRD PARTIES. IF YOU ARE A CALIFORNIA RESIDENT, YOU WAIVE CALIFORNIA CIVIL CODE §1542, WHICH SAYS: A GENERAL RELEASE DOES NOT EXTEND TO CLAIMS WHICH THE CREDITOR DOES NOT KNOW OR SUSPECT TO EXIST IN HIS FAVOR AT THE TIME OF EXECUTING THE RELEASE, WHICH IF KNOWN BY HIM MUST HAVE MATERIALLY AFFECTED HIS SETTLEMENT WITH THE DEBTOR. WE WILL NOT BE LIABLE TO YOU FOR ANY LOST PROFITS OR OTHER CONSEQUENTIAL, SPECIAL, INDIRECT, OR INCIDENTAL DAMAGES ARISING OUT OF OR IN CONNECTION WITH THIS STATEMENT OR Collap, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. OUR AGGREGATE LIABILITY ARISING OUT OF THIS STATEMENT OR Collap WILL NOT EXCEED THE GREATER OF ONE HUNDRED DOLLARS ($100) OR THE AMOUNT YOU HAVE PAID US IN THE PAST TWELVE MONTHS. APPLICABLE LAW MAY NOT ALLOW THE LIMITATION OR EXCLUSION OF LIABILITY OR INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE ABOVE LIMITATION OR EXCLUSION MAY NOT APPLY TO YOU. IN SUCH CASES, Collap'S LIABILITY WILL BE LIMITED TO THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW.
                            </p>
                            <p>
                            Special Provisions Applicable to Users Outside the United States
                            We strive to create a global community with consistent standards for everyone, but we also strive to respect local laws. The following provisions apply to users and non-users who interact with Collap outside the United States:
                            You consent to having your personal data transferred to and processed in the United States.
                            If you are located in a country embargoed by the United States, or are on the U.S. Treasury Department's list of Specially Designated Nationals you will not engage in commercial activities on Collap (such as advertising or payments) or operate a Platform application or website. You will not use Collap if you are prohibited from receiving products, services, or software originating from the United States.
                            Certain specific terms that apply only for German users are available here.
                            </p>

                            <p style="text-align: justify;"><span style="color: #993300;"><b>
                            Definitions</b></span></p>

                            <p>
                            By "Collap" we mean the features and services we make available, including through (a) our website at www.Collap.com and any other Collap branded or co-branded websites (including sub-domains, international versions, widgets, and mobile versions); (b) our Platform; (c) social plugins such as the Like button, the Share button and other similar offerings and (d) other media, software (such as a toolbar), devices, or networks now existing or later developed.
                            By "Platform" we mean a set of APIs and services (such as content) that enable others, including application developers and website operators, to retrieve data from Collap or provide data to us.
                            By "information" we mean facts and other information about you, including actions taken by users and non-users who interact with Collap.
                            By "content" we mean anything you or other users post on Collap that would not be included in the definition of information.
                            By "data" or "user data" or "user's data" we mean any data, including a user's content or information that you or third parties can retrieve from Collap or provide to Collap through Platform.
                            By "post" we mean post on Collap or otherwise make available by using Collap.
                            By "use" we mean use, run, copy, publicly perform or display, distribute, modify, translate, and create derivative works of.
                            By "active registered user" we mean a user who has logged into Collap at least once in the previous 30 days.
                            By "application" we mean any application or website that uses or accesses Platform, as well as anything else that receives or has received data from us.  If you no longer access Platform but have not deleted all data from us, the term application will apply until you delete the data.
                            </p>
                            <p>
                            If you are a resident of or have your principal place of business in the US or Canada, this Statement is an agreement between you and Collap, Inc.  Otherwise, this Statement is an agreement between you and Collap Ireland Limited.  References to “us,” “we,” and “our” mean either Collap, Inc. or Collap Ireland Limited, as appropriate.
                            This Statement makes up the entire agreement between the parties regarding Collap, and supersedes any prior agreements.
                            If any portion of this Statement is found to be unenforceable, the remaining portion will remain in full force and effect.
                            If we fail to enforce any of this Statement, it will not be considered a waiver.
                            Any amendment to or waiver of this Statement must be made in writing and signed by us.
                            You will not transfer any of your rights or obligations under this Statement to anyone else without our consent.
                            All of our rights and obligations under this Statement are freely assignable by us in connection with a merger, acquisition, or sale of assets, or by operation of law or otherwise.
                            Nothing in this Statement shall prevent us from complying with the law.
                            This Statement does not confer any third party beneficiary rights.
                            We reserve all rights not expressly granted to you.
                            You will comply with all applicable laws when using or accessing Collap.
                            </p>

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

</body>
</html>
