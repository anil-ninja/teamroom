<?php
include_once 'lib/db_connect.php';
include_once 'functions/profile_page_function.php';
include_once 'functions/delete_comment.php';
$UserName = $_GET['username'];
session_start();
$userInfo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE username = '$UserName';");
$userInfoRows = mysqli_num_rows($userInfo);

if ($userInfoRows == 0) {
    include_once 'error.php';
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
$profileViewRank = $user_InformationRow['rank'];

//profile view user id added to session for loading panel content data with ajax 
$_SESSION['profile_view_userID'] = $profileViewUserID;

$challengeCreated = mysqli_query($db_handle, "SELECT COUNT(challenge_id) FROM challenges WHERE user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeCreated);
$totalChallengeCreated = $counter["COUNT(challenge_id)"];

$challengeProgress = mysqli_query($db_handle, "SELECT COUNT(status) FROM challenge_ownership WHERE status = 1 and user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeProgress);
$totaLChallengeProgress = $counter["COUNT(status)"];

$challengeCompleted = mysqli_query($db_handle, "SELECT COUNT(status) FROM challenge_ownership WHERE status = 2 and user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeCompleted);
$totalChallengeCompleted = $counter["COUNT(status)"];

$projectCreated = mysqli_query($db_handle, "SELECT COUNT(project_id) FROM projects WHERE user_id = $profileViewUserID AND project_type=1;");
$counter = mysqli_fetch_assoc($projectCreated);
$totalProjectCreated = $counter["COUNT(project_id)"];

$projectJoined = mysqli_query($db_handle, "SELECT count(project_id) FROM projects WHERE projects.project_id IN( SELECT teams.project_id from teams where teams.user_id = $profileViewUserID)AND projects.user_id != $profileViewUserID and projects.project_type = 1;");
$counter = mysqli_fetch_assoc($projectJoined);
$projectsJoined = $counter["count(project_id)"];

$projectProgress = mysqli_query($db_handle, "SELECT COUNT(project_id) FROM projects WHERE project_id IN (SELECT DISTINCT project_id FROM teams WHERE user_id = $profileViewUserID) and project_type != '3' and project_type != '5';");
$counter = mysqli_fetch_assoc($projectProgress);
$totalprojectProgress = $counter["COUNT(project_id)"];

include_once 'models/profile.php';
$obj = new profile($UserName);
//echo $obj->first_name."hi";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title><?= $profileViewFirstName." ".$profileViewLastName; ?></title>

        <link rel="stylesheet" href="css/profile_page_style.css">

        <meta name="author" content="Anil">
        <!-- for Google -->
        <meta name="keywords" content="Challenges, Projects, Problem solving, problems" />
        <meta name="author" content="<?= $obj->first_name." ".$obj->last_name; ?>" />
        <meta name="copyright" content="true" />
        <meta name="application-name" content="Article" />

        <!-- for Facebook -->          
        <meta property="og:image" content="<?= $obj->getImage(); ?>" />
        <meta property="og:url" content="" />
        
        <!-- for Twitter -->          
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:image" content="<?= $obj->getImage(); ?>" />
        
        
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
	<script type="text/javascript" src="js/signupValidation.js"></script>
	<script type="text/javascript" src="js/loginValidation.js"></script>

  <!-- chat box -->
  
  <link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
  <link type="text/css" rel="stylesheet" media="all" href="css/screen.css" />

  <!--[if lte IE 7]>
  <link type="text/css" rel="stylesheet" media="all" href="css/screen_ie.css" />
  <![endif]-->

  <!-- end chat box-->

    </head>
    <body style="background:#F0F1F2;">
        <?php include_once 'html_comp/navbar_homepage.php'; ?>
         
        <div class="media-body" style="padding-top: 60px;">
            <div class="col-md-3">
        <?php
            if (isset($_SESSION['user_id']) && $profileViewUserID == $_SESSION['user_id']) {
                echo "<a class = 'btn btn-default btn-xs' id='editprofile' style='cursor: pointer; margin-left: 250px;'>Edit</a>";
            }
            echo "<br/><img src='uploads/profilePictures/$UserName.jpg'  style='width:250px; height:250px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>"; 
            if ((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
                echo "<a data-toggle='modal' class = 'btn btn-default btn-xs'style='cursor: pointer' data-target='#uploadPicture'>Change Pic</a>
                    <div class='alert_placeholder'> </div>";
                   } 
            ?>
            
            <div class="viewprofile">
            <?php
            
            echo "<br/><hr/><span class='glyphicon glyphicon-user'></span><strong> <span id='first_name'>&nbsp" 
                        .ucfirst($profileViewFirstName)."</span> <span id='last_name'>".ucfirst($profileViewLastName)."</span></strong>";
                    
            echo "&nbsp;(".$profileViewRank.")</span>
                  <br/><span class='glyphicon glyphicon-envelope' id='email' style='cursor: pointer'>&nbsp;" . $profileViewEmail . "</span>" ;
             if($profileViewPhone != 1) {    
                echo "<br/><span class='glyphicon glyphicon-earphone' id='phone' style='cursor: pointer'>&nbsp;" . $profileViewPhone . "<br/></span>
                  <br/><span><br/><span class='glyphicon glyphicon-screenshot'></span>&nbsp;&nbsp;&nbsp;Skills:";
			  }
			  else {
				  echo "<br/><span><br/><span class='glyphicon glyphicon-screenshot'></span>&nbsp;&nbsp;&nbsp;Skills:" ; 
				  }
            $skill_display = mysqli_query($db_handle, "SELECT b.skill_name from user_skills as a join skill_names as b WHERE a.user_id = $profileViewUserID AND a.skill_id = b.skill_id ;");
            if (mysqli_num_rows($skill_display) == 0) {
                    echo " <span class='tags'>No Skill added</span> ";
            } 
            else {
                while ($skill_displayRow = mysqli_fetch_array($skill_display)) {
                    echo " <span class='tags'>".$skill_displayRow['skill_name']."</span> ";
                }
            }
            echo "<br/></span>";
            if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) { 
                echo "<br/><a data-toggle='modal' class='btn-xs btn-primary ' data-target='#addskill' style='cursor:pointer;'>
                           <i class='glyphicon glyphicon-plus'></i> Skill
                        </a><br/>";
					}
             $aboutuser = mysqli_query($db_handle, "SELECT organisation_name, living_town, about_user FROM about_users WHERE user_id = '$profileViewUserID' ;") ;
             $aboutuserRow = mysqli_fetch_array($aboutuser);
             echo "<br/><span class='glyphicon glyphicon-stats'></span>&nbsp;&nbsp;&nbsp;"
                        .$aboutuserRow['organisation_name']."<br/>
                        <span class='glyphicon glyphicon-home'></span>&nbsp;&nbsp;&nbsp;"
                        .$aboutuserRow['living_town']."<br/><span class='glyphicon glyphicon-comment'></span>&nbsp;&nbsp;&nbsp;"
                        .$aboutuserRow['about_user'];
             ?>
             </div>
             <div class="editprofile">
                <?php    
                if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) { 
                    echo "<br/><hr/><a data-toggle='modal' class='btn-xs btn-primary ' data-target='#addskill' style='cursor:pointer;'>
                            <i class='glyphicon glyphicon-plus'></i> Skill
                            </a><br/>";
                    echo "<input type='text' id='newfirstname' class='form-control' value='".$profileViewFirstName."'/>
                                            <input type='text' id='newlastname' class='form-control' value='".$profileViewLastName."'/>
                                            <input type='text' id='newemailid' class='form-control' value='".$profileViewEmail."'/>
                                            <input type='text' id='newphoneno' class='form-control' value='".$profileViewPhone."'/>
                                            <input type='text' id='companyname' class='form-control' placeholder='Organisation Name'/>
                                            <input type='text' id='livingtown' class='form-control' placeholder='Current Living Town'/>
                                            <textarea row='3' id='aboutuser' class='form-control' placeholder='About Yourself'></textarea><br/>
                                            <a class='btn-success btn-sm' onclick='editProfile(\"".$profileViewFirstName."\",\"".$profileViewLastName.
                                            "\",\"".$profileViewEmail."\",\"".$profileViewPhone."\")'>Change</a>";
                    }
                    ?>
        </div>
                </div>
                <div class='alert_placeholder'></div>
          <div class="col-md-7">
            <div>
              <ul class="nav nav-tabs" role="tablist" style="font-size:15px">
                  <li role="presentation" class="active">
                    <a href="#tabCreatedProjects" role="tab" data-toggle="tab">Created Projects (<?= $totalProjectCreated?>)</a></li>
                  <li role="presentation" id="joined_project">
                     <a href="#tabJoinedProjects" role="tab" data-toggle="tab">Joined Projects (<?= $projectsJoined?>)</a></li>
                  <li role="presentation" id="user_articles">
                    <a href="#tabArticles" role="tab" data-toggle="tab">Articles</a></li>
                  <li role="presentation" id="user_challenges">
                    <a href="#tabChallanges" role="tab" data-toggle="tab">Challenges</a>
                    </li>
                  <li role="presentation" id="user_idea">
                    <a href="#tabIdeas" role="tab" data-toggle="tab">Ideas</a></li>
              </ul>
            </div>
            <div class="tab-content" >
                <div role="tabpanel" class="row tab-pane active" id="tabCreatedProjects">       
                    <?php created_projects($db_handle,$profileViewUserID); ?>
                    <div id='next_CP'>
                        <p id='home-ch'></p>
                        <p id='home'></p>
                    </div>
            </div>
            <div role="tabpanel" class="row tab-pane" id="tabJoinedProjects" >
                <div id="joined_project_content"></div>
            </div>
            <div role="tabpanel" class="row tab-pane" id="tabArticles">
                <div id="user_articles_content"></div>
                <div id='next_user_article'>
                        <p id='home-ch'></p>
                        <p id='home'></p>
                    </div>
            </div>
            <div role="tabpanel" class="row tab-pane" id="tabChallanges">
                <div id="user_challenges_content"></div>
                    <div id='next_user_chall'>
                        <p id='home-ch'></p>
                        <p id='home'></p>
                    </div>
                </div>
            <div role="tabpanel" class="row tab-pane" id="tabIdeas">
                <div id="user_idea_content"></div>
            </div>
            </div>
        </div> 
                <div class ="col-md-2">
                    <?php include_once 'html_comp/known.php' ?>
                </div>
                </div>
                <?php include_once 'html_comp/signup.php' ; ?>
        <script type="text/javascript" src="js/jquery-latest.min.js"></script>
        <script language="javascript">
            $(document).ready(function(){
                $('#joined_project').click(function(){
                    $('#joined_project_content').load('ajax/profile_page_ajax/joined_projects.php');
                });
            })
            $(document).ready(function(){
                $('#user_articles').click(function(){
                    $('#user_articles_content').load('ajax/profile_page_ajax/user_articles.php');
                });
            })
            $(document).ready(function(){
                $('#user_challenges').click(function(){
                    $('#user_challenges_content').load('ajax/profile_page_ajax/user_challenges.php');
                });
            })
            $(document).ready(function(){
                $('#user_idea').click(function(){
                    $('#user_idea_content').load('ajax/profile_page_ajax/user_idea.php');
                });
            })
        </script>
           
<script>
$(".editprofile").hide();
$(".viewprofile").show();
$("#editprofile").click(function(){
	$(".viewprofile").toggle();
	$(".editprofile").toggle();
});
</script>
<div id="InfoBox"></div>
        <script src="js/add_remove_skill.js"> </script>
            <!---Modal --->
            <div class="modal fade" id="uploadPicture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:300px; height:auto">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
                        <div class='alert_placeholder'></div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <input class="btn btn-default btn-sm" type="file" id="_fileprofilepic" style ="width: auto;"><br>
                        </div>
                        <input class="btn btn-primary btn-sm" type="submit" id="upload_image"  value="Change"><br>
                    </div>
                </div>
            </div>
        </div>
            <!---End OF Modal --->
            <!---Modal --->
            <div class="modal fade" id="addskill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:300px; height:auto;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Add Skills</h4>
                        <div class='alert_placeholder'></div>
                    </div>
                    <div class="modal-body">
						Select Skill : &nbsp;&nbsp;&nbsp;&nbsp;
                        <select class="inline-form" id = "skills" >	
                            <option value='0' selected >Default (none)</option>
                            <?php
                            $m = mysqli_query($db_handle, "select * from skill_names where 1 = 1 ;") ;
                            while ($n = mysqli_fetch_array($m)) {
								$id = $n['skill_id'] ;
								$sn = $n['skill_name'] ;
                                echo "<option value='" . $id . "' >" . $sn . "</option>";
                            }
                            ?>
                        </select>
                        <br/><br/>OR<br/><br/>
                         Enter your Skill  &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='text' class="inline-form" id="insert" placeholder="Enter your Skill"/><br/><br/>
                        <input type="button" value="Add" class="btn btn-success" id="addskills"/>
                       
                        </div>
                     <div class="modal-footer">
                <button name="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
                </div>
            </div>
        </div>
        
        
        <script src="js/jquery.js"></script>
        <script src="js/ajaxupload-v1.2.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootswatch.js"></script>
        <script src="js/date_time.js"></script>
    <!--   <script src="js/uploadpic.js"></script> -->
        <script src="js/project.js"></script>
        <script src="js/chat.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/ninjas.js" type="text/javascript"></script>
        <script src="js/bootbox.js"></script>
       <script>
		   function editProfile(fname, lname, email, phone) {
			   //alert (fname + "," + lname + "," + email + "," + phone);
			   var newfname = $("#newfirstname").val() ;
			   var newlname = $("#newlastname").val() ;
			   var newemail = $("#newemailid").val() ;
			   var newphone = $("#newphoneno").val() ;
			   var about = $("#aboutuser").val() ;
			   var townname = $("#livingtown").val() ;
			   var comp = $("#companyname").val() ;
			   if ((newfname == fname) && (newlname == lname) && (newemail == email) && (newphone == phone) && (about == "") && (townname == "") && (comp == "")) {
				   //location.reload();
				   return false ;				   
				   }
				   else if (newfname == "" || newlname == "" || newemail == "" || newphone == "") {
					   bootstrap_alert(".alert_placeholder", "Invalid Request", 5000,"alert-warning");
					   return false ;
					   }
						else {
							var dataString = 'fname='+ newfname + '&lname='+ newlname + '&email='+ newemail + '&phone='+ newphone + '&about='+ about 
										+ '&townname='+ townname + '&comp='+ comp ;
							$.ajax ({ 
								type: "POST",
								url: "ajax/editNameProfile.php",
								data: dataString,
								cache: false,
								success: function(result){
									bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
									if(result=='Updated successfuly'){
										location.reload();
										//document.getElementById("first_name").innerHTML = edited_first;
										//document.getElementById("last_name").innerHTML = edited_last;
									}
								}
							});
						}
			};
        </script>
        	<script>
	$(window).scroll(function(event) {
            if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
                event.preventDefault();
                var dataString = 'next=5' ;
                $.ajax({
                    type: "POST",
                    url: "ajax/profile_page_ajax/get_next_user_challenges.php",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        //alert(result) ;
                        $('#next_user_chall').append(result);
                        }
                });	
            }
        });
        $(window).scroll(function(event) {
            if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
                event.preventDefault();
                var dataString = 'last_article=3';
                $.ajax({
                    type: "POST",
                    url: "ajax/profile_page_ajax/get_next_user_articles.php",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        //alert(result) ;
                        $('#next_user_article').append(result);
                        }
                });	
            }
        });
        $(window).scroll(function(event) {
            if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
                event.preventDefault();
                var dataString = 'next_CP=3' ;
                $.ajax({
                    type: "POST",
                    url: "ajax/profile_page_ajax/get_next_created_projects.php",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        $('#next_CP').append(result);
                        }
                });	
            }
        });
	</script>

        <script>
            function bootstrap_alert(elem, message, timeout,type) {
                $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; right: 20%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

                if (timeout || timeout === 0) {
                    setTimeout(function() { 
                    $(elem).show().html('');
                    }, timeout);    
                }
            };
        </script>
         <!----Login and Signup Modal included here ---->         
        <?php include_once 'html_comp/login_signup_modal.php'; ?>
         

        <!-- chat box -->
   <script type="text/javascript" src="js/chat_box.js"></script>
   <!-- end Chat box-->
    </body>
</html>
