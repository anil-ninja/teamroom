<?php
    include_once 'controllers/login_controller.php';
    include_once 'lib/login_signup.php';
    include_once 'functions/delete_comment.php';
    include_once 'lib/db_connect.php';
    session_start();
    $challengeSearchID = $_GET['challenge_id'];
    
    if(isset($_POST['own_chl_response'])) {
        $user_id = $_SESSION['user_id'];
        $own_challenge_id_comment = $_POST['own_challen_id'] ;
        $own_ch_response = $_POST['own_ch_response'] ;
        if (strlen($own_ch_response)>1) {
            if (strlen($own_ch_response)<1000) {	
                mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) 
                                    VALUES ('$user_id', '$own_challenge_id_comment', '$own_ch_response');") ;
                header('Location: #');
            }
            else { 
                mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                    VALUES (default, '$own_ch_response');");
                $id = mysqli_insert_id($db_handle);
                mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, blob_id) 
                                    VALUES ('$user_id', '$own_challenge_id_comment', ' ', '$id');") ;
                header('Location: #');
            }
        } 
    }
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Challenges Open</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenges, Projects, Problem solving, problems">
        <meta name="author" content="Rajnish">
        <script src="js/ninjas.js" type="text/javascript"></script>
        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <style>
            body {
                padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
            }             
        </style>

        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
            <link rel="stylesheet" href="css/bootswatch.css">
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery.js"> </script>
        <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery.autosize.js"></script>
        <script src="js/delete_comment_challenge.js" type="text/javascript"> </script>

    </head>
    <body>
        <?php include_once 'html_comp/navbar_homepage.php'; ?>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-lg-6">
                <?php                               
                $open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.*, b.first_name, b.last_name, b.username from challenges as a join user_info as b 
                                        WHERE (a.challenge_type = '1' OR a.challenge_type = '4' OR a.challenge_type = '6') AND blob_id = '0' and a.user_id = b.user_id AND a.challenge_id='$challengeSearchID')
                                    UNION
                                        (SELECT DISTINCT a.user_id, a.project_id, a.challenge_id, a.blob_id, a.challenge_title, a.challenge_open_time, a.challenge_creation, a.challenge_ETA, a.challenge_type, a.challenge_status, c.stmt, b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
                                        WHERE (a.challenge_type = '1' OR a.challenge_type = '4' OR a.challenge_type = '6') and a.blob_id = c.blob_id and a.user_id = b.user_id AND a.challenge_id='$challengeSearchID');");
                $emptySearch = mysqli_num_rows($open_chalange);
                if ($emptySearch == 0) {
                    echo "no match found";
                }
            while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
		$chelange = str_replace("<s>","&nbsp;",$open_chalangerow['stmt']) ;
		$ETA = $open_chalangerow['challenge_ETA'] ;
		$ch_title = $open_chalangerow['challenge_title'] ;
		$frstname = $open_chalangerow['first_name'] ;
		$lstname = $open_chalangerow['last_name'] ;
                $username_ch_ninjas = $open_chalangerow['username'];
		$chelangeid = $open_chalangerow['challenge_id'] ;
		$times = $open_chalangerow['challenge_creation'] ;
		$timeopen = $open_chalangerow['challenge_open_time'] ;
                $challenge_status = $open_chalangerow['challenge_status'];
		$eta = $ETA*60 ;
		$day = floor($eta/(24*60*60)) ;
		$daysec = $eta%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
		$remaining_time = $day." Days :".$hour." Hours :".$minute." Min" ;
		$starttimestr = (string) $times ;
		$open = $timeopen*60 ;
        $initialtime = strtotime($starttimestr) ;
		$totaltime = $initialtime+$eta+$open ;
		$completiontime = time() ;
            $owned_or_not = mysqli_query($db_handle, "SELECT a.user_id, a.comp_ch_ETA, a.ownership_creation, b.first_name, b.last_name, b.username 
                                                      FROM challenge_ownership as a JOIN user_info as b 
                                                      WHERE a.challenge_id = '$challengeSearchID' and a.user_id = b.user_id;");
            while ($owned_or_notRow = mysqli_fetch_array($owned_or_not)) {
                $owned_f_name = $owned_or_notRow['first_name'];
                $owned_l_name = $owned_or_notRow['last_name'];
                $owned_username = $owned_or_notRow['username'];
                $own_created = $owned_or_notRow['ownership_creation'];
            }
          if ($completiontime > $totaltime) { 
            $remaining_time_own = "Closed" ; 
            }
            else {	
                $remainingtime = ($totaltime-$completiontime) ;
                $day = floor($remainingtime/(24*60*60)) ;
                $daysec = $remainingtime%(24*60*60) ;
                $hour = floor($daysec/(60*60)) ;
                $hoursec = $daysec%(60*60) ;
                $minute = floor($hoursec/60) ;
                $remaining_time_own = "Remaining Time : ".$day." Days :".$hour." Hours :".$minute." Min " ;
            }
            echo "<div class='list-group'>
                    <div class='list-group-item'>" ;
                        if(isset($_SESSION['user_id'])) {
                            $userID = $_SESSION['user_id'];
                            dropDown_challenge($db_handle, $chelangeid, $userID, $remaining_time_own);
                        }
            switch ($challenge_status) {
                case 1:
                    echo "Created by &nbsp
                        <span class='color strong' style= 'color :lightblue;'>
                            <a href ='profile.php?username=".$username_ch_ninjas."'>" 
                                . ucfirst($frstname). '&nbsp'. ucfirst($lstname). " 
                            </a>
                        </span>";
                    break;
                case 2:
                    echo "Owned by &nbsp
                        <span class='color strong' style= 'color :lightblue;'>
                            <a href ='profile.php?username=".$owned_username."'>"
                                ."$owned_f_name". "&nbsp".$owned_l_name."
                            </a>
                        </span>&nbsp on &nbsp".$own_created;
            }
            
            if(isset($_SESSION['user_id'])) {
                include_once 'ninjas.inc.php';
                echo "<form method='POST' class='inline-form pull-right'>
                        <input type='hidden' name='id' value='".$chelangeid."'/>
                        <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'>
                    </form>";
            }
            else {
                echo"<a data-toggle='modal' data-target='#SignIn'>
                        <button class='btn btn-primary btn-sm pull-right'>Accept</button>
                    </a>";
            }
            echo "<br><br></div>";
            echo "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :lightblue;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
            $chelange. "<br/><br/>";
            $commenter = mysqli_query ($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                                JOIN user_info as b WHERE a.challenge_id = $challengeSearchID AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                            UNION
                                                (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                                JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$challengeSearchID' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
            
            while($commenterRow = mysqli_fetch_array($commenter)) {
                $comment_id = $commenterRow['response_ch_id'];
                $challenge_ID = $commenterRow['challenge_id'];
                $username_comment_ninjas = $commenterRow['username'];
                    echo "<div id='commentscontainer'>
                            <div class='comments clearfix'>
                                <div class='pull-left lh-fix'>
                                    <img src='img/default.gif'>
                                </div>
                                <div class='comment-text'>
                                    <span class='pull-left color strong'>&nbsp<a href ='profile.php?username=".$username_comment_ninjas."'>".ucfirst($commenterRow['first_name'])." ". ucfirst($commenterRow['last_name']) ."</a></span>
                                    &nbsp&nbsp&nbsp".$commenterRow['stmt'] ."";
                if(isset($_SESSION['user_id'])) {
                    $userID = $_SESSION['user_id'];		
                    dropDown_delete_comment_challenge($db_handle, $comment_id, $userID);
                }
                echo "</div></div></div>";
            }
            echo "<div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='img/default.gif'>
                </div>
                <div class='comment-text'>";
                    if(isset($_SESSION['user_id'])) {
                        $userID = $_SESSION['user_id'];
                        echo "<form action='' method='POST' class='inline-form'>
                                <input type='hidden' value='".$chelangeid."' name='own_challen_id' />
                                <input type='text' STYLE='border: 1px solid #bdc7d8; width: auto; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                            </form>";
                    }
                   echo "</div>
                </div>";
        echo " </div> </div> ";    
        }
    ?>
    </div>
</div>
            
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

<div class="row">
    <ul class="list-inline">
        <li>Posted by: Dpower4</li>
        <li>Copyright @ 2014</li>
    </ul>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="SignIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
                                    <button type="submit" class="btn btn-success" name="request" value='login' onclick="validateLoginFormOnSubmit()">Log in</button>
        
            </div>
        
            <div class  ="modal-footer">
                <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--end modle-->
<!-- Modal -->
<div class="modal fade" id="SignUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:auto; height:auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">New User Registration</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="tablef" onsubmit="return validateSignupFormOnSubmit(this)">
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
        if ($_GET['status'] == 0) {
            echo "<script>
                        alert('User registered successfully');
                </script>";
        }
        if ($_GET['status'] == 2) {
            echo "<script> 
                    alert('Please, put Valid Username and Password');
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
