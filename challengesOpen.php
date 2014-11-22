<?php 
    include_once 'challengesOpen.inc.php'; 

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php chOpen_title($challenge_page_title); ?></title>
        <meta name="author" content="">
        
        <!-- for Google -->
        <meta name="description" content="<?= $obj->getDiscription(); ?>" />
        <meta name="keywords" content="Challenges, Projects, Problem solving, problems" />
        <meta name="author" content="<?= $obj->first_name." ".$obj->last_name; ?>" />
        <meta name="copyright" content="true" />
        <meta name="application-name" content="Article" />

        <!-- for Facebook -->          
        <meta property="og:title" content="<?= $obj->challenge_title; ?>" />
        <meta property="og:type" content="article"/>
        <meta property="og:image" content="<?= $obj->url; ?>" />
        <meta property="og:url" content="<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>" />
        <meta property="og:description" content="<?= $obj->getDiscription(); ?>" />

        <!-- for Twitter -->          
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="<?= $obj->challenge_title; ?>" />
        <meta name="twitter:description" content="<?= $obj->getDiscription(); ?>" />
        <meta name="twitter:image" content="<?= $obj->url; ?>" />

        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">

        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery.js"> </script>
        <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery.autosize.js"></script>
        <!-- script fro challenge comment delete, it is common for all challenges comments.  -->
        <script src="js/delete_comment_challenge.js" type="text/javascript"> </script>

    </head>
    <body>
      <?php include_once 'html_comp/navbar_homepage.php'; ?>
       <div class=" media-body" style="padding-top: 5px;">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <?php
                
                    challenge_display($db_handle, $challengeSearchID);
                
                ?>
                <div class="panel">
                <?php 
                    echo "<div class='col-lg-4'>
                            <img src='uploads/profilePictures/$ch_username.jpg'  style='width:75%' onError=this.src='img/default.gif' class='img-circle img-responsive'>
                        </div>";
                    $about_author = mysqli_query($db_handle, "SELECT about_user FROM about_users WHERE user_id = $challengeSearch_user_ID;");
                    $no_data = mysqli_num_rows($about_author);
                    if ($no_data == 0){
                        echo "<div class='panel-body'>
                            <span class='color strong' style= 'color :lightblue;'>
                                    <a href ='profile.php?username=" . $ch_username . "'>"
                                    .ucfirst($challengeSearch_first) . '&nbsp' . ucfirst($challengeSearch_last) . " 
                                    </a>
                            </span><br>
                                No information is available about this user
                            </div>";
                    } else {
                        $about_authorRow = mysqli_fetch_array($about_author);
                        echo "<div class='panel-body'>
                                <span class='color strong' style= 'color :lightblue;'>
                                    <a href ='profile.php?username=" . $ch_username . "'>"
                                    .ucfirst($challengeSearch_first) . '&nbsp' . ucfirst($challengeSearch_last) . " 
                                    </a>
                            </span><br>";
                                    echo $about_authorRow['about_user'];
                        echo "</div>";
                    }
                ?>  
                    </div>
                </div>
        <div class="col-md-3">
           <?php 
                echo "<div class='bs-component'>
                        <font size='4'><h3 class='panel-title'><p> Explore more </p></h3></font><hr>";
                $challenge_user = mysqli_query($db_handle, "(SELECT DISTINCT challenge_id, challenge_title, LEFT(stmt, 100) as stmt FROM challenges 
                                                        WHERE challenge_type != '2' AND (challenge_status !='3' OR challenge_status != '7') AND challenge_id != $challengeSearchID AND blob_id = '0')  
                                                    UNION 
                                                    (SELECT DISTINCT a.challenge_id, a.challenge_title, LEFT(b.stmt, 100) as stmt FROM challenges as a JOIN blobs as b 
                                                        WHERE a.blob_id = b.blob_id AND challenge_type != '2' AND (challenge_status !='3' OR challenge_status != '7') AND challenge_id != $challengeSearchID) ORDER BY rand() LIMIT 10 ;");
                while($challenge_userRow = mysqli_fetch_array($challenge_user)) {
                    $challenge_user_chID = $challenge_userRow['challenge_id'];
                    $challenge_user_title = $challenge_userRow['challenge_title'];
                    $challenge_user_stmt = $stmt_task = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $challenge_userRow['stmt'])));
                    //echo $challenge_user_stmt;
                    echo "<p style='white-space: pre-line;height: 20px; font-size:14px;'><b>
                    <a href='challengesOpen.php?challenge_id=$challenge_user_chID'>".$challenge_user_title."</a></b><br></p>";
                    if (substr($challenge_user_stmt, 0, 4) == "<img") {
                        $arrayStmt = explode(">", $challenge_user_stmt);
                        echo $arrayStmt[1]."<br>";
                    } else {
                        echo $challenge_user_stmt."<br>";
                    }
                }
                echo "<br><hr><font size='4'><h3 class='panel-title'><p>Projects</p></h3></font><hr>";
                $projects = mysqli_query($db_handle, "(SELECT DISTINCT project_id, project_title, LEFT(stmt, 100) as stmt FROM projects 
                                                        WHERE project_type = '1' AND blob_id = '0')  
                                                    UNION 
                                                    (SELECT DISTINCT a.project_id, a.project_title, LEFT(b.stmt, 100) as stmt FROM projects as a JOIN blobs as b 
                                                        WHERE a.blob_id = b.blob_id AND project_type= '1') ORDER BY rand() LIMIT 3 ;");
                while($projectsRow = mysqli_fetch_array($projects)) {
                    $project_title_display = $projectsRow['project_title'];
                    $project_title_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $projectsRow['stmt']))); 
                echo "<p style='white-space: pre-line;height: 20px; font-size:14px;'><b>"
                    .$project_title_display."</b></p>"
                    .$project_title_stmt."<br>";
                }
            ?>
            
            </div>
    </div>
      
        
        <div class="col-md-6 pull-right">
            <ul class="list-inline">
                <li>Posted by: Dpower4</li>
                <li>Copyright @ 2014</li>
            </ul>
        </div>
        </div>
        
        <script>
            $('#SignUp').on('show', function() {
                $('#SignIn').css('opacity', .5);
                $('#SignIn').unbind();
            });
            $('#SignUp').on('hidden', function() {
                $('#SignIn').css('opacity', 1);
                $('#SignIn').removeData("SignIn").modal({});
            });
        </script>
        <!-- Modal -->
       <div class="modal fade" id="SignIn" style="z-index: 2000;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:350px; height:auto">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Collaborations</h4>
                        
                        <div class='alert_placeholder'></div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon">Username</span>
                            <input type="text" style="font-size:10pt" class="form-control" id="username" placeholder="Enter email or username">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon">Password</span>
                            <input type="password" style="font-size:10pt" class="form-control" id="passwordlogin" placeholder="Password">
                        </div><br/>
                        <button type="submit" class="btn btn-success" name="request" value='login' onclick="validateLoginFormOnSubmit()">Log in</button>
                        
                    </div>

						<div class  ="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end modle-->

        <!-- Modal -->
        <div class="modal fade" id="SignUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:370px; height:500px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Join the Clan</h4>
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
                                 <input type="text" class="form-control" style="width: 100%" id="email" placeholder="Email" onkeyup="nospaces(this)"/> <span id="status_email"></span>
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

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootswatch.js"></script>
        <script src="js/delete_comment_challenge.js" type="text/javascript"> </script>
        <script src="js/project.js"></script>
        <script src="js/date_time.js"></script>
        <script src="js/custom.js"></script>
        <script type="text/javascript" src="js/loginValidation.js"></script>
        <script type="text/javascript" src="js/signupValidation.js"></script>

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
                    alert('Sorry, you are not allowed to enter any spaces');
                    t.value=t.value.replace(/\s/g,'');
                }
            }
        </script>
        <script type="text/javascript" src="js/username_email_check.js"></script>
    </body>
</html>
