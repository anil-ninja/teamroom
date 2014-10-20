<?php
include_once 'lib/db_connect.php';
$UserName = $_GET['username'];
session_start();
$userInfo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE username = '$UserName';");
$userInfoRows = mysqli_num_rows($userInfo);

if ($userInfoRows == 0) {
    include_once 'html_comp/error.html';
    exit;
}
if (isset($_POST['logout'])) {
    header('Location: profile.php?username='."$UserName");
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    session_destroy();
    exit;
}
$user_InformationRow = mysqli_fetch_array($userInfo);
$profileViewFirstName = $user_InformationRow['first_name'];
$profileViewLastName = $user_InformationRow['last_name'];
$profileViewEmail = $user_InformationRow['email'];
$profileViewPhone = $user_InformationRow['contact_no'];
$profileViewUserID = $user_InformationRow['user_id'];

$challengeCreated = mysqli_query($db_handle, "SELECT COUNT(challenge_id) FROM challenges WHERE user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeCreated);
$totalChallengeCreated = $counter["COUNT(challenge_id)"];

$challengeProgress = mysqli_query($db_handle, "SELECT COUNT(status) FROM challenge_ownership WHERE status = 1 and user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeProgress);
$totaLChallengeProgress = $counter["COUNT(status)"];

$challengeCompleted = mysqli_query($db_handle, "SELECT COUNT(status) FROM challenge_ownership WHERE status = 2 and user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeCompleted);
$totalChallengeCompleted = $counter["COUNT(status)"];

$projectCreated = mysqli_query($db_handle, "SELECT COUNT(project_id) FROM projects WHERE user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($projectCreated);
$totalProjectCreated = $counter["COUNT(project_id)"];

$projectCompleted = mysqli_query($db_handle, "SELECT COUNT(project_id) FROM projects WHERE user_id = $profileViewUserID and project_type = '2';");
$counter = mysqli_fetch_assoc($projectCompleted);
$totalProjectCompleted = $counter["COUNT(project_id)"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>profile</title>
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
       
        <style type="text/css">    

            .profile 
            {
                min-height: 355px;
                display: inline-block;
            }
            figcaption.ratings
            {
                margin-top:20px;
            }
            figcaption.ratings a
            {
                color:#f1c40f;
                font-size:11px;
            }
            figcaption.ratings a:hover
            {
                color:#f39c12;
                text-decoration:none;
            }
            .divider 
            {
                border-top:1px solid rgba(0,0,0,0.1);
            }
            .emphasis 
            {
                border-top: 4px solid transparent;
            }
            .emphasis:hover 
            {
                border-top: 4px solid #1abc9c;
            }
            .emphasis h2
            {
                margin-bottom:0;
            }
            span.tags 
            {
                background: #1abc9c;
                border-radius: 2px;
                color: #f5f5f5;
                font-weight: bold;
                padding: 2px 4px;
            }
            .dropdown-menu 
            {
                background-color: #34495e;    
                box-shadow: none;
                -webkit-box-shadow: none;
                width: 250px;
                margin-left: -125px;
                left: 50%;
            }
            .dropdown-menu .divider 
            {
                background:none;    
            }
            .dropdown-menu>li>a
            {
                color:#f5f5f5;
            }
            .dropup .dropdown-menu 
            {
                margin-bottom:10px;
            }
            .dropup .dropdown-menu:before 
            {
                content: "";
                border-top: 10px solid #34495e;
                border-right: 10px solid transparent;
                border-left: 10px solid transparent;
                position: absolute;
                bottom: -10px;
                left: 50%;
                margin-left: -10px;
                z-index: 10;
            }
        </style>

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
	<script src="js/ninjas.js" type="text/javascript"></script>
    </head>

    <body>

        <?php include_once 'html_comp/navbar_homepage.php'; ?>
    
        <div class="row">
            <div class="col-md-offset-1 col-md-8 col-lg-8">
                <div class="well profile">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-8">
                            <?php
                            echo "<h2><strong>" . ucfirst($profileViewFirstName) . " " . ucfirst($profileViewLastName) . "</strong></h2>
                                        <p><strong>Email-Id: </strong>" . $profileViewEmail . "</p>
                                        <p><strong>Contact: </strong>" . $profileViewPhone . "</p>
                                        <p><strong>Skills: </strong>
                                            <span class='tags'>html5</span> 
                                            <span class='tags'>css3</span>
                                            <span class='tags'>jquery</span>
                                            <span class='tags'>bootstrap3</span>
                                        </p>";
                            ?>
                        </div>             
                        <div class="col-xs-12 col-sm-4 text-center">
                            <figure>
                                <?php echo "<img src='uploads/profilePictures/$UserName.jpg'  alt='' class='img-circle img-responsive'>"; ?>
                                <figcaption class="ratings">
                                    <p>Ratings
                                        <a href="#">
                                            <span class="fa fa-star"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-star"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-star"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-star"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-star-o"></span>
                                        </a> 
                                    </p>
                                </figcaption>
                            </figure>
                        </div>
                    </div>            
                    <div class="col-xs-12 divider text-center">
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong> <?php echo $totalChallengeCreated; ?> </strong></h2>                    
                            <p><small>challenges</small></p>
                            <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Created </button>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong> <?php echo $totalChallengeCompleted; ?> </strong></h2>                    
                            <p><small>challenges</small></p>
                            <button class="btn btn-success btn-block"><span class="glyphicon glyphicon-ok"></span> Completed </button>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong><?php echo $totaLChallengeProgress; ?> </strong></h2>                    
                            <p><small>challenges</small></p>
                            <button class="btn btn-success btn-block"><span class="glyphicon glyphicon-fire"></span> In-progress </button>
                        </div>
                    </div>
                    <div class="col-xs-12 divider text-center">
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong><?php echo $totalProjectCreated; ?></strong></h2>                    
                            <p><small>projects</small></p>
                            <button class="btn btn-info btn-block"><span class="fa fa-plus-circle"></span> Created </button>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong><?php echo $totalProjectCompleted; ?> </strong></h2>                    
                            <p><small>projects</small></p>
                            <button class="btn btn-info btn-block"><span class="glyphicon glyphicon-ok"></span> Completed </button>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong> 0 </strong></h2>                    
                            <p><small>projects</small></p>
                            <button class="btn btn-info btn-block"><span class="glyphicon glyphicon-fire"></span> In-progress </button>
                        </div>
                    </div>
                </div>
                
            </div>
        
            <div class="col-lg-3">
                <div class="well profile">
                    <p>  In-contact with Friends </p>
                    <?php
                    $userProjects = mysqli_query($db_handle, ("SELECT * FROM user_info as a join 
                                                            (SELECT DISTINCT b.user_id FROM teams as a join
                                                            teams as b where a.user_id = '$profileViewUserID' and
                                                            a.team_name = b.team_name and b.user_id != '$profileViewUserID')
                                                            as b where a.user_id=b.user_id;"));

                    while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
                        $friendFirstName = $userProjectsRow['first_name'];
                        $friendLastName = $userProjectsRow['last_name'];
                        $usernameFriends = $userProjectsRow['username'];
                        echo "<a href ='profile.php?username=" . $usernameFriends . "'>
                                        " . ucfirst($friendFirstName) . " " . ucfirst($friendLastName) . "
                                   <br></a>";
                    }
                    ?>
                </div>                 
            </div>
        </div>
        
        
        <div class="row">
            <div class="col-md-offset-1 col-md-8 col-lg-8">
                <div class="well profile">
                    <div class="col-xm-12">
                        <div class="col-xs-12 col-sm-12">
                            <div class="col-xs-12 divider text-center">
                                <div class="col-xs-12 col-sm-4 emphasis">
                                    <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Challenges Completed </button>
                                    <?php
                                        $title_ch_comp = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.challenge_creation, c.user_id, b.first_name, b.last_name, b.username
                                                                                    FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE c.user_id = '$profileViewUserID' AND a.challenge_type = '5'
                                                                                    AND a.user_id = b.user_id AND a.challenge_id = c.challenge_id;");
                                        $not_any_comp = mysqli_num_rows($title_ch_comp);
                                        if ($not_any_comp == 0) {
                                            echo "<br> You have not completed any challenge till now.";
                                        }
                                        while ($title_ch_compRow = mysqli_fetch_array($title_ch_comp)) {
                                            $title = $title_ch_compRow['challenge_title'];
                                            $time = $title_ch_compRow['challenge_creation'];
                                            $eta = $title_ch_compRow['challenge_ETA'];
                                            $fname = $title_ch_compRow['first_name'];
                                            $lname = $title_ch_compRow['last_name'];
                                            $ch_comp_ID_open_page = $title_ch_compRow['challenge_id'];
                                            $day = floor($eta / (24 * 60));
                                            $daysec = $eta % (24 * 60);
                                            $hour = floor($daysec / (60));
                                            $minute = $daysec % (60);
                                            $remaining_time = $day . " Days :" . $hour . " Hours :" . $minute . " Min";
                                            $starttimestr = (string) $time;
                                            $initialtime = strtotime($starttimestr);
                                            $totaltime = $initialtime + ($eta * 60);
                                            $completiontime = time();
                                            if ($completiontime > $totaltime) {
                                                $remaining_time_own = "Closed";
                                            } 
                                            else {
                                                $remainingtime = ($totaltime - $completiontime);
                                                $day = floor($remainingtime / (24 * 60 * 60));
                                                $daysec = $remainingtime % (24 * 60 * 60);
                                                $hour = floor($daysec / (60 * 60));
                                                $hoursec = $daysec % (60 * 60);
                                                $minute = floor($hoursec / 60);
                                                $remaining_time_own = "Remaining Time : " . $day . " Days :" . $hour . " Hours :" . $minute . " Min ";
                                            }
                                            echo "<style='white-space: pre-line;'><b><a href ='challengesOpen.php?challenge_id=" . $ch_comp_ID_open_page . "'>" . ucfirst($title) . "</a></b><br/>" . $remaining_time_own . "<br></style>";
                                        }
                                    ?>
                                </div>
                                <div class="col-xs-12 col-sm-4 emphasis">
                                    <button class="btn btn-success btn-block"><span class="glyphicon glyphicon-ok"></span>Challenges Owned</button>
                                    <?php
                                        $title_ch_owned = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.challenge_creation, c.user_id, b.first_name, b.last_name, b.username
                                                                                    FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE c.user_id = '$profileViewUserID' AND (a.challenge_type = '1' OR a.challenge_type = '2') 
                                                                                    and a.challenge_status = '2' AND a.user_id = b.user_id AND a.challenge_id = c.challenge_id ;");
                                        $not_any_owned = mysqli_num_rows($title_ch_owned);
                                        if ($not_any_owned == 0) {
                                            echo "<br> You have not Owned any challenge till now.";
                                        }
                                        while ($title_ch_ownedRow = mysqli_fetch_array($title_ch_owned)) {
                                            $title = $title_ch_ownedRow['challenge_title'];
                                            $time = $title_ch_ownedRow['challenge_creation'];
                                            $eta = $title_ch_ownedRow['challenge_ETA'];
                                            $fname = $title_ch_ownedRow['first_name'];
                                            $lname = $title_ch_ownedRow['last_name'];
                                            $ch_owned_ID_open_page = $title_ch_ownedRow['challenge_id'];
                                            $day = floor($eta / (24 * 60));
                                            $daysec = $eta % (24 * 60);
                                            $hour = floor($daysec / (60));
                                            $minute = $daysec % (60);
                                            $remaining_time = $day . " Days :" . $hour . " Hours :" . $minute . " Min";
                                            $starttimestr = (string) $time;
                                            $initialtime = strtotime($starttimestr);
                                            $totaltime = $initialtime + ($eta * 60);
                                            $completiontime = time();
                                            if ($completiontime > $totaltime) {
                                                $remaining_time_own = "Closed";
                                            } 
                                            else {
                                                $remainingtime = ($totaltime - $completiontime);
                                                $day = floor($remainingtime / (24 * 60 * 60));
                                                $daysec = $remainingtime % (24 * 60 * 60);
                                                $hour = floor($daysec / (60 * 60));
                                                $hoursec = $daysec % (60 * 60);
                                                $minute = floor($hoursec / 60);
                                                $remaining_time_own = "Remaining Time : " . $day . " Days :" . $hour . " Hours :" . $minute . " Min ";
                                            }
                                            $tooltip = "Assigned By : " . ucfirst($fname) . " " . ucfirst($lname) . " On " . $time . " ETA given : " . $remaining_time . " " . $remaining_time_own;
                                            echo "<p align='center'><button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                        			data-placement='bottom' data-original-title='" . $tooltip . "' style='white-space: pre-line;'> </button><b><a href ='challengesOpen.php?challenge_id=" . $ch_owned_ID_open_page . "'>" . ucfirst($title) . "</a></b><br/><p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>" . $remaining_time_own . "</p></p><hr/>";
                                        }
                                    ?>                                    
                                </div>
                                <div class="col-xs-12 col-sm-4 emphasis">
                                    <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span>Challenges Created</button>
                                    <?php
                                        $title_ch_created = mysqli_query($db_handle, "SELECT DISTINCT challenge_id, challenge_status, challenge_title, user_id, challenge_ETA, challenge_creation from challenges where
                                                                                        user_id = '$profileViewUserID' ORDER BY challenge_creation DESC ;");
                                        $not_any_created = mysqli_num_rows($title_ch_created);
                                        if ($not_any_created == 0) {
                                            echo "<br> You have not Created any challenge till now.";
                                        }
                                        while ($title_ch_createdRow = mysqli_fetch_array($title_ch_created)) {
                                            $ch_title = $title_ch_createdRow['challenge_title'];
                                            $status = $title_ch_createdRow['challenge_status'];
                                            $ch_created_ID_open_page = $title_ch_createdRow['challenge_id'];
                                            echo "<style='white-space: pre-line;'><b><a href ='challengesOpen.php?challenge_id=" . $ch_created_ID_open_page . "'>" . ucfirst($ch_title) . "</a></b><br></style>";
                                        }
                                    ?>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>          
            
              <!-- Modal -->
        <div class="modal fade" id="SignIn" style="z-index: 2000;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:auto; height:auto">
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
                        <?php 
                            if (isset($_POST['login_comment'])) {
                                echo 'Sign In for your comment!!!';
                            }
                        ?> 
                        </div>
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
        <div class="modal fade" id="SignUp" style="z-index: 9000;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                
                <div class="modal-content" style="width:390px; height:500px">
                   
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                         
                        <h4 class="modal-title" id="myModalLabel">New User Registration</h4>
                    </div>
                    <div class="modal-body">
                            <div class="inline-form">					
                                <input type="text" class="inline-form" id="firstname" placeholder="First name" onkeyup="nospaces(this)"/>	
                                <input type="text" class="inline-form" id="lastname" placeholder="Last name" onkeyup="nospaces(this)"/>					
                            </div><br/>	
                            <div class="inline-form">				
                                <input type="text" class="inline-form" id="email" placeholder="Email" onkeyup="nospaces(this)" /> <span id="status_email"></span>
                                <input type="text" class="inline-form" id="phone" placeholder="Mobile Number" onkeyup="nospaces(this)"/>
                            </div><br/>					
                            <input type="text" class="form-control" id="usernameR" placeholder="user name" onkeyup="nospaces(this)"/> <span id="status"></span>
                            <input type="password" class="form-control" id="passwordR" placeholder="password"/>
                            <input type="password" class="form-control" id="password2R" placeholder="Re-enter password"/><br/><br/>

                            <input type="submit" class="btn btn-primary" name = "request" value = "Signup" onclick="validateSignupFormOnSubmit()">
                    </div>
                    <div class  ="modal-footer">
                        <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
        <script>
            startTime();
            function getDateTime() {
                var now     = new Date(); 
                var year    = now.getFullYear();
                var month   = now.getMonth()+1; 
                var day     = now.getDate();
                var hour    = now.getHours();
                var minute  = now.getMinutes();
                var second  = now.getSeconds(); 
                if(month.toString().length == 1) {
                    var month = '0'+month;
                }
                if(day.toString().length == 1) {
                    var day = '0'+day;
                }   
                if(hour.toString().length == 1) {
                    var hour = '0'+hour;
                }
                if(minute.toString().length == 1) {
                    var minute = '0'+minute;
                }
                if(second.toString().length == 1) {
                    var second = '0'+second;
                }   
                var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;   
                return dateTime;
            }

            function startTime() {
                document.getElementById('demo').innerHTML = String(getDateTime());
                t = setTimeout(function () {
                    startTime()
                }, 500);
            }
        </script>
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
        <script type="text/javascript">
            document.getElementById("usernameR").onblur = function() {

                var xmlhttp;

                var username=document.getElementById("usernameR");
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
    </body>
</html>
