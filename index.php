<?php
include_once 'lib/db_connect.php';
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
    <meta name="description" content="Collap is a powerful online platform which enables you to take a dig at problems, big or small, and collaborate with like minded people to make the world a better place. Identify any problem you want solved and let the world know about it. Assemble your team and have a go at it. Interested Collapers can join your quest and contribute which ever way they can. Collap provides you a wide range of helpful tools which enable hassle-free collaboration. Create and manage projects and be in control with our Project Dashboard all through the process. Share ideas freely and come up with innovative solutions. Make your realm private and work on that secret project you’ve long been planning. Participate in projects and upgrade your Level. Earn a special place in Collap for each incremental step. Sharpen your skills while lending them to do good. Challenges to solve your technical problems and help change the world! . Meet people,  allows everybody to share their ideas, views, challenges and achievements with the like minded for mutual benefits. In this collap v1 release, we are going to limit to some functionality due to technically liabilities and available resources.">
    <meta name="keywords" content="Challenge, Project, Problem solving, problem, article, collaborate, collaboration, digitalCollaboration">
    <link href="styles/bootstrap.min.css" rel="stylesheet" />
    <link href="styles/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="css/preview.min.css" rel="stylesheet" />
    <link href='../../fonts.googleapis.com/css%3Ffamily=PT+Sans:400,700.css' rel='stylesheet' type='text/css'>
    <link href="styles/font-awesome.min.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:800italic,400' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Courgette' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="favicon.ico">

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
                <a class="brand" style="font-size:16pt; color: #fff; font-weight: bold; font-family: Courgette, cursive;" href="index.php">
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
                        <li><a href="index.php#panel1" data-toggle="tab" ><i class="icon-lock"></i>&nbsp;<span>Login</span></a></li>
                        <li class="active"><a href="index.php#panel2" data-toggle="tab" class="active "><i class="icon-user"></i>&nbsp;<span>Register</span></a></li>
                        <li><a href="index.php#panel3" data-toggle="tab"><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
                    <!--    <li><a href="index.html#panel4" data-toggle="tab"><i class="icon-envelope-alt"></i>&nbsp;<span>Contact Us</span></a></li> -->
                    </ul>
                    <div class="tab-content ">

                        <div class="tab-pane" id="panel1">
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
                                    <h4><i class="icon-expand-alt"></i>&nbsp;&nbsp; Social Profiles </h4>
                                    <div class="socials clearfix">
                                        <a href='https://www.facebook.com/pages/collapcom/739310236156746' class="icon-facebook facebook" target='_blank'></a>
                                        <a href='https://twitter.com/CollapCom' class="icon-twitter twitter" target='_blank'></a>
                                        <a href="https://plus.google.com/117170233233281087141" rel="publisher" class="icon-google-plus google-plus" target='_blank'></a>
                                        <a href='https://www.pinterest.com/collapcom/' class="icon-pinterest pinterest" target='_blank'></a>
                                        <a class="icon-linkedin linked-in"></a>
                                        <a href='https://github.com/collapcom' class="icon-github github" target='_blank'></a>
                                    </div>
                                </div>
                                <div class="span4">
                                    <h4><i class="icon-question"></i>&nbsp;&nbsp;Registration</h4>
                                    <div class="box">
                                        <p>
                                           Introducing a powerful online platform to collaborate with like minded people and change the world, 
                                           solving one problem at a time. 
                                         </p>
                                         <p>
                                           Collap offers a wide range of tools to identify a challenge and assemble your own team to collaborate and crack it.
                                            Here’s to the the joy of collaborative problem solving! 
                                        </p>
                                    </div>
                                    <div class="box">
                                        Don't Have An Account.<br />
                                        Click Here For <a href="index.php#panel2" data-toggle="tab">Free Register</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active" id="panel2">
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
									<input type="email" class="input-block-level" id="email" onkeyup="nospaces(this)" onblur="email_availability_check();"/>
									<span id="status_email"></span>

                                    <label>Username</label>
                                    <input type="text" class="input-block-level" id="usernameR" onkeyup="nospaces(this)" onblur="usernameCheck();"/>
                                    
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
                                    <label>You are here for</label>
                                    <input type="checkbox" data-toggle="button" class="btn btn-mini custom-checkbox" id ='typeCol' /> Collaboration &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" data-toggle="button" class="btn btn-mini custom-checkbox" id ='typeInv' /> Invester &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" data-toggle="button" class="btn btn-mini custom-checkbox" id ='typeFun' /> Fund Searcher <br/><br/>
                                    <label>
                                        <input type="checkbox" data-toggle="button" class="btn btn-mini custom-checkbox" id ='agree_tc' />

                                        &nbsp;&nbsp;&nbsp;I Aggree With 
                                        <a href="index.php#TabsModalTnC" data-toggle="modal">Terms &amp; Conditions</a>
                                    </label>
                                    <br />

                                    <a class=" btn " id = "request_reg" onclick="validateSignupFormOnSubmit()">Register Now&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>

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
                                           Introducing a powerful online platform to collaborate with like minded people and change the world, 
                                           solving one problem at a time. 
                                         </p>
                                         <p>
                                           Collap offers a wide range of tools to identify a challenge and assemble your own team to collaborate and crack it.
                                            Here’s to the the joy of collaborative problem solving! 
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
                                    required data-bv-emailaddress-message="The input is not a valid email address" onblur="email_forget();" />
                                    <span id="status_email_forget_password"></span>
                                <br />
                                    <br />
                                    <input type="submit" class=" btn" name="request_password" value = "Recover Password" />&nbsp;&nbsp;&nbsp;
                                </form>
                                </div>
                                <div class="span7">
                                    <h4><i class="icon-question"></i>&nbsp;&nbsp;Help</h4>
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
        </div><br/><br/><br/>
        <div class='row-fluid'>
			<div class='span10 offset1'>
			<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
				<ul class="nav nav-tabs">
                        <li class="active"><a href="#" data-toggle="tab" class="active ">About Collap :</a></li>
                    </ul>
                    <div class="tab-content">
						
						<div class="box">
						<p>Collap is a powerful online platform which enables you to take a dig at problems, big or small, and collaborate with like minded people to make the world a better place.</p>
						<p>Identify any problem you want solved and let the world know about it. Assemble your team and have a go at it. Interested Collapers can join your quest and contribute which ever way they can. 
Collap provides you a wide range of helpful tools which enable hassle-free collaboration. Create and manage projects and be in control with our Project Dashboard all through the process. Share ideas freely and come up with innovative solutions.</p>
						<p>Make your realm private and work on that secret project you’ve long been planning. 
Participate in projects and upgrade your Level. Earn a special place in Collap for each incremental step. Sharpen your skills while lending them to do good. </p>
						<p> Challenges to solve your technical problems and help change the world! . Meet people,  allows everybody to share their ideas, views, challenges and achievements with the like minded for mutual benefits. In this collap v1 release, we are going to limit to some functionality due to technically liabilities and available resources.</p>
					</div>
					</div>
				</div>
			</div>
        </div><br/><br/>
		<div class="row-fluid">
			<div class='span10 offset1'>
			<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
				<ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active icon-briefcase "> Top Projects</a></li>
                </ul>
                <div class="tab-content">
		<?php
		$projects = mysqli_query($db_handle, "(SELECT DISTINCT project_id, project_title, LEFT(stmt, 250) as stmt FROM projects 
													WHERE project_type = '1' AND blob_id = '0')  
												UNION 
												(SELECT DISTINCT a.project_id, a.project_title, LEFT(b.stmt, 250) as stmt FROM projects as a JOIN blobs as b 
													WHERE a.blob_id = b.blob_id AND project_type= '1' ) ORDER BY rand() LIMIT 4 ;");
			while($projectsRow = mysqli_fetch_array($projects)) {
				$project_id = $projectsRow['project_id'];
				$project_title_display = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $projectsRow['project_title'])));
				$project_title_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $projectsRow['stmt']))); 
			echo "<div class ='span3 box' style=' margin: 4px ;min-height: 200px;'>
					<a href='project.php?project_id=".$project_id."'>
						<div class='panel-heading'>
							<b><p style=' font-size:14px;word-wrap: break-word;color:#3B5998;'>".ucfirst($project_title_display)."</p></b>
						</div>
						<div class='panel-content'>
							<p style='word-wrap: break-word;'>".$project_title_stmt."....</p><br>
						</div>
					</a>
				</div>";
			}				
		?>
		</div></div></div></div><br/>
    
      
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

function validateSignupFormOnSubmit() {
	var reason = "";
	var firstname = $("#firstname").val() ;
	var lastname = $("#lastname").val() ;
	var email = $("#email").val() ;
	//var phone = $("#phone").val() ;
	var username = $("#usernameR").val() ;
	var password = $("#passwordR").val() ;
	var password2 = $("#password2R").val() ;
    var term_n_cond = document.getElementById("agree_tc").checked;
	var typeA = document.getElementById("typeCol").checked;
    var typeB = document.getElementById("typeInv").checked;
    var typeC = document.getElementById("typeFun").checked;
	if(password==password2){
		if(replaceAll('\\s', '',firstname)==''){
			bootstrap_alert(".alert-placeholder", "firstname can not be empty", 5000,"alert-warning");
		}
		else if(replaceAll('\\s', '',email)==''){
			bootstrap_alert(".alert-placeholder", "email can not be empty", 5000,"alert-warning");
		}
        else if (validateEmail(email)==false) {
            
                bootstrap_alert(".alert-placeholder", "Enter a valid email id", 5000,"alert-warning");       
            
            //email_availability_check();
        } 
		/*else if(replaceAll('\\s', '',phone)==''){
			bootstrap_alert(".alert-placeholder", "phone can not be empty", 5000,"alert-warning");
		} */
		else if(replaceAll('\\s', '',username)==''){
			bootstrap_alert(".alert-placeholder", "username can not be empty", 5000,"alert-warning");
		}
        else if(username.length <'6'){
            bootstrap_alert(".alert-placeholder", "username length be atleast 6", 5000,"alert-warning");
        } 
		else if(replaceAll('\\s', '',password)==''){
			bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
		} 
		else if(password.length <'6'){
			bootstrap_alert(".alert-placeholder", "password length should be atleast 6", 5000,"alert-warning");
		}
		else if(replaceAll('\\s', '',password2)==''){
			bootstrap_alert(".alert-placeholder", "password can not be empty", 5000,"alert-warning");
		}
		else if(validatePath(firstname) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters and Spaces are not allowed <br/> Only Alphabets and Numbers are allowed in First Name", 5000,"alert-warning");
		}
		else if(validatePath(username) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters and Spaces are not allowed <br/> Only Alphabets and Numbers are allowed in Username", 5000,"alert-warning");
		}
		else if(validatePath(lastname) !== 'true'){
			bootstrap_alert(".alert-placeholder", "Special Characters and Spaces are not allowed <br/> Only Alphabets and Numbers are allowed in Last Name", 5000,"alert-warning");
		} 
        else if(term_n_cond==false){
            bootstrap_alert(".alert-placeholder", "You have not accepted term and conditions", 5000,"alert-warning");
        }
        else if((typeA==false) && (typeB==false) && (typeC==false)){
            bootstrap_alert(".alert-placeholder", "You have not told why you are here", 5000,"alert-warning");
        } 
		else {
			if((typeA==false) && (typeB==false)){
				var type = "fundsearcher";
			}
			else if((typeA==false) && (typeC==false)){
				var type = "invester";
			}
			else if((typeB==false) && (typeC==false)){
				var type = "collaborater";
			}
			else if(typeB==false){
				var type = "collaboraterFundsearcher";
			}
			else if(typeA==false){
				var type = "fundsearcherInvester";
			}
			else if(typeC==false){
				var type = "collaboraterInvester";
			}
			else {
				var type = "collaboraterinvesterfundsearcher";
			}
			var dataString = 'firstname='+ firstname + '&lastname='+ lastname + '&email='+ email  + '&username='+ username + '&password='+ password + 
							'&password2='+ password2 + '&type=' + type + '&term_n_cond=' + term_n_cond + '&request=Signup' ;
			$.ajax({
				type: "POST",
				url: "controllers/login_controller.php",
				data: dataString,
				async: false ,
				cache: false,
				success: function(result){
					if(result){
						bootstrap_alert(".alert-placeholder", result, 5000,"alert-warning");
					} 
					else {
						location.reload();
					}		
				} 
			});
		}
	}		
	else bootstrap_alert(".alert-placeholder", "Password Not Match! Try Again", 5000,"alert-warning");
}
function replaceAll(find, replace, str) {
	return str.replace(new RegExp(find, 'g'), replace);
}
    </script>
    

    <script type="text/javascript" src="js/username_email_check.js"></script>
    <script type="text/javascript" src="js/signupValidation.js"></script>
    <script type="text/javascript" src="js/loginValidation.js"></script>
<?php include_once 'html_comp/terms_and_condition_modal.php' ;
		include_once 'html_comp/insert_time.php' ; ?>
</body>
</html>
