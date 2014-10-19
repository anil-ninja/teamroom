<?php 
include_once 'lib/db_connect.php';
$UserName = $_GET['username'] ;
session_start();

$userInfo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE username = '$UserName';");
$userInfoRows = mysqli_num_rows($userInfo);

if($userInfoRows == 0) {
    include_once 'html_comp/error.html';
    exit;
}

$user_InformationRow =  mysqli_fetch_array($userInfo);
$profileViewFirstName = $user_InformationRow['first_name'];
$profileViewLastName = $user_InformationRow['last_name'];
$profileViewEmail= $user_InformationRow['email'];
$profileViewPhone = $user_InformationRow['contact_no'];
$profileViewUserID = $user_InformationRow['user_id'];

$challengeCreated = mysqli_query($db_handle, "SELECT COUNT(challenge_id) FROM challenges WHERE user_id = $profileViewUserID;");
$counter=mysqli_fetch_assoc($challengeCreated); 
$totalChallengeCreated=$counter["COUNT(challenge_id)"];

$challengeProgress = mysqli_query($db_handle, "SELECT COUNT(status) FROM challenge_ownership WHERE status = 1 and user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeProgress);
$totaLChallengeProgress = $counter["COUNT(status)"];

$challengeCompleted = mysqli_query($db_handle, "SELECT COUNT(status) FROM challenge_ownership WHERE status = 2 and user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeCompleted);
$totalChallengeCompleted= $counter["COUNT(status)"];

$projectCreated = mysqli_query($db_handle, "SELECT COUNT(project_id) FROM projects WHERE user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($projectCreated);
$totalProjectCreated= $counter["COUNT(project_id)"];

$projectCompleted = mysqli_query($db_handle, "SELECT COUNT(project_id) FROM projects WHERE user_id = $profileViewUserID and project_type = '2';");
$counter = mysqli_fetch_assoc($projectCompleted);
$totalProjectCompleted= $counter["COUNT(project_id)"];

?>
<!DOCTYPE html>
<html lang="en">
   <head>
        <meta charset="utf-8">
        <title>profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">    
body
{
    font-family: 'Lato', 'sans-serif';
    }
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

    <script src="jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/bootswatch.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <?php    include_once 'html_comp/navbar_homepage.php'; ?>
    <script type="text/javascript" src="scripts/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/jquery.wallform.js"></script>
	<div class="row">
            <div class="col-md-offset-1 col-md-8 col-lg-8">
                <div class="well profile">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-8">
                            <?php
                                echo "<h2><strong>".ucfirst($profileViewFirstName). " ".ucfirst($profileViewLastName)."</strong></h2>
                                        <p><strong>Email-Id: </strong>".$profileViewEmail."</p>
                                        <p><strong>Contact: </strong>".$profileViewPhone."</p>
                                        <p><strong>Skills: </strong>
                                            <span class='tags'>html5</span> 
                                            <span class='tags'>css3</span>
                                            <span class='tags'>jquery</span>
                                            <span class='tags'>bootstrap3</span>
                                        </p>" ;
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
                       $userProjects = mysqli_query ($db_handle, ("SELECT * FROM user_info as a join 
                                                            (SELECT DISTINCT b.user_id FROM teams as a join
                                                            teams as b where a.user_id = '$profileViewUserID' and
                                                            a.team_name = b.team_name and b.user_id != '$profileViewUserID')
                                                            as b where a.user_id=b.user_id;"));
               
                        while ($userProjectsRow = mysqli_fetch_array($userProjects))  {
                            $friendFirstName = $userProjectsRow['first_name'];
                            $friendLastName = $userProjectsRow['last_name'];
                            $usernameFriends = $userProjectsRow['username'];
                            echo "<a href ='profile.php?username=".$usernameFriends."'>
                                        ".ucfirst($friendFirstName)." ".ucfirst($friendLastName)."
                                   <br></a>";
                        }
                    ?>
                </div>                 
            </div>
           </div>
           <div class="row">
            <div class="col-md-offset-1 col-md-10 col-lg-10">
                <div class="well profile">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-8">
							 <div class="col-xs-12 divider text-center">
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong> <?php echo $totalChallengeCreated; ?> </strong></h2>                    
                        <p><small>challenges</small></p>
                        Created fewhrh hehwhr jdqcr yucr hwyufgryf wwvuygfygf q vydgygd qygeuhn qyugcyurgf jhqhfgyugryf ewjhfgyuwrgf jhgyuqgvgyduw
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
               </div>
              </div>
         </div>
      </div>          
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
</body>
</html>
