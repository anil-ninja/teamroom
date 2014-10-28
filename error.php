<?php
include_once 'lib/db_connect.php';
if (isset($_POST['logout'])) {
    header('Location: ninjas.php');
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    session_destroy();
    exit;
}
?>
<html lang="en">
    <head>
        <title>not exists</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenges, Projects, Problem solving, problems">
        <meta name="author" content="Rajnish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenge, Project, Problem solving, problem">
        <meta name="author" content="Anil">
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
<?php 
    include_once 'html_comp/navbar_homepage.php'; 
?>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-6">
                <?php
                    $top_challenges = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.blob_id, a.challenge_title, a.challenge_creation, a.challenge_type, a.challenge_status, a.stmt, b.first_name, b.last_name, b.username from challenges as a join user_info as b 
                                        WHERE a.project_id = 0 AND a.challenge_type != 2 AND challenge_type != 5 AND blob_id = '0' AND challenge_status ='1' and a.user_id=b.user_id)
                                    UNION
                                        (SELECT DISTINCT a.challenge_id, a.blob_id, a.challenge_title, a.challenge_creation, a.challenge_type, a.challenge_status, c.stmt, b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
                                        WHERE a.project_id = 0 AND a.challenge_type != 2 AND challenge_type != 5 AND  challenge_status ='1' AND a.blob_id = c.blob_id and a.user_id=b.user_id ) ORDER BY challenge_creation DESC;");
                   while ($top_challengesRow = mysqli_fetch_array($top_challenges)) {
                       $challenge_type_id = $top_challengesRow['challenge_id'];
                       $challenge_type_title = $top_challengesRow['challenge_title'];
                       $challenge_type_stmt = str_replace("<s>", "&nbsp;", $top_challengesRow['stmt']) ;
                       $challenge_type_first = $top_challengesRow['first_name'];
                       $challenge_type_last = $top_challengesRow['last_name'];
                       $challenge_type_username = $top_challengesRow['username'];
                       $challenge_type_type = $top_challengesRow['challenge_type'];
                       $challenge_type_status = $top_challengesRow['challenge_status'];
                       $challenge_type_time = $top_challengesRow['challenge_creation'];
                       $time_display = date("j F, g:i a", strtotime($challenge_type_time));
                     echo "<div class='list-group'>";
                    if ($challenge_type_type == 1) {
                        if ($challenge_type_status == 1 || $challenge_type_status == 2 || $challenge_type_status == 4 || $challenge_type_status == 5) {
                            echo "
                                        <div class='list-group-item'>
                                            <div class='pull-left lh-fix'>     
                                                <span class='glyphicon glyphicon-question-sign'></span>
                                                <img src='uploads/profilePictures/$challenge_type_username.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                            </div>
                                            <div style='line-height: 24.50px;'>
                                                <span class='color strong'><a href ='profile.php?username=" . $challenge_type_username . "'>"
                                                    .ucfirst($challenge_type_first) . '&nbsp' . ucfirst($challenge_type_username) . " </a>
                                                </span><br> " . $time_display."
                                            </div>
                                        </div>";
                        } 
                    }
                else if ($challenge_type_type == 7) {
                    echo "
                            <div class='list-group-item' style='line-height: 24.50px;'>
                                <div class='pull-left lh-fix'>     
                                    <span class='glyphicon glyphicon-book'></span>
                                    <img src='uploads/profilePictures/$challenge_type_username.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                </div>
                                <span class='color strong'><a href ='profile.php?username=" . $challenge_type_username . "'>"
                                    . ucfirst($challenge_type_first) . '&nbsp' . ucfirst($challenge_type_last) . " </a></span>
                                <br> " . $time_display . "<br/>
                            </div>";
                }
            else if ($challenge_type_type == 4) {
                echo "
                        <div class='list-group-item' style='line-height: 16.50px;'></span>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-flash'>
                                <img src='uploads/profilePictures/$challenge_type_username.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>	

                            <span class='color strong'><a href ='profile.php?username=" . $challenge_type_username . "'>"
                                .ucfirst($challenge_type_first) . '&nbsp' . ucfirst($challenge_type_last) . " </a></span><br>" . $time_display . "<br/>
                            <p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>IDEA</b></p>
                        </div>";
            } 
            else if ($challenge_type_type == 3) {
                echo "
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'>
                            <img src='uploads/profilePictures/$challenge_type_username.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <span class='color strong'><a href ='profile.php?username=" . $challenge_type_username . "'>"
                            .ucfirst($challenge_type_first) . '&nbsp' . ucfirst($challenge_type_last) . " </a></span>&nbsp&nbsp&nbsp On : " . $time_display."
                    </div>" ;
            }
            echo "<div class='list-group-item'>
                    <p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>" 
                        .ucfirst($challenge_type_title) . "</b>
                    </p> <br/>" 
                        .$challenge_type_stmt." 
                    <br/>
                </div>
            </div>";
        }
    ?>
            </div>
            <div class="col-md-3">
           <?php 
                echo "<div class='bs-component'>
                        <font size='4'><h3 class='panel-title'><p>Projects</p></h3></font><hr>";
                $projects = mysqli_query($db_handle, "(SELECT DISTINCT project_id, project_title, LEFT(stmt, 100) as stmt FROM projects 
                                                        WHERE project_type = '1' AND blob_id = '0')  
                                                    UNION 
                                                    (SELECT DISTINCT a.project_id, a.project_title, LEFT(b.stmt, 100) as stmt FROM projects as a JOIN blobs as b 
                                                        WHERE a.blob_id = b.blob_id AND project_type= '1') ORDER BY rand() LIMIT 10 ;");
                while($projectsRow = mysqli_fetch_array($projects)) {
                    $project_title_display = $projectsRow['project_title'];
                    $project_title_stmt = str_replace("<s>", "&nbsp;", $projectsRow['stmt']) ;
                    echo "<p style='white-space: pre-line;height: 20px; font-size:14px;'><b>"
                    .$project_title_display."</b></p>"
                    .$project_title_stmt."....<br>";
                    }
                echo "<br><hr><font size='4'><h3 class='panel-title'><p>Top Users</p></h3></font><hr>";
                $top_users = mysqli_query($db_handle, "SELECT first_name, last_name, username FROM user_info ORDER BY rand() LIMIT 10 ;");
                while($top_usersRow = mysqli_fetch_array($top_users)) {
                    $top_user_first = $top_usersRow['first_name'];
                    $top_user_last = $top_usersRow['last_name'];
                    $top_user_username = $top_usersRow['username'];
                    echo "<p style='white-space: pre-line;height: 20px; font-size:14px;'><b>
                    <a href ='profile.php?username=" . $top_user_username . "'>".ucfirst($top_user_first)."&nbsp ".ucfirst($top_user_last)."</a></b></p><br>
                    ";
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
        <div class="modal fade" id="SignIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:auto; height:auto">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <div class="modal-title" id="myModalLabel"><p align="center"><font size="5" >Vade the Clan</font></p></div>

                        <div class='alert_placeholder'></div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon">Username</span>
                            <input type="text" class="form-control" id="username" placeholder="Enter email or username">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon">Password</span>
                            <input type="password" class="form-control" id="password" placeholder="Password">
                        </div><br/>
                        <button type="submit" class="btn btn-success" name="request" value='login' onclick="validateLogin1()">Log in</button> &nbsp;&nbsp;
                        <button class="btn btn-success" data-toggle='modal' data-target='#SignUp'>Sign Up</button>
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
