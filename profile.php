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

$user_InformationRow = mysqli_fetch_array($userInfo);
$profileViewFirstName = $user_InformationRow['first_name'];
$profileViewLastName = $user_InformationRow['last_name'];
$profileViewEmail = $user_InformationRow['email'];
$profileViewPhone = $user_InformationRow['contact_no'];
$profileViewUserID = $user_InformationRow['user_id'];
$profileViewRank = $user_InformationRow['rank'];

//profile view user id added to session for loading panel content data with ajax 
$_SESSION['profile_view_userID'] = $profileViewUserID;

$challengeCreated = mysqli_query($db_handle, "SELECT COUNT(challenge_id) FROM challenges WHERE user_id = $profileViewUserID AND (challenge_type = 1 OR challenge_type = 3) AND (challenge_status !=3 AND challenge_status !=7);");
$counter = mysqli_fetch_assoc($challengeCreated);
$totalChallengeCreated = $counter["COUNT(challenge_id)"];

$articleCreated = mysqli_query($db_handle, "SELECT COUNT(challenge_id) FROM challenges WHERE user_id = $profileViewUserID AND challenge_type = 7 AND (challenge_status !=3 AND challenge_status !=7);");
$counter1 = mysqli_fetch_assoc($articleCreated);
$totalarticleCreated = $counter1["COUNT(challenge_id)"];

$ideaCreated = mysqli_query($db_handle, "SELECT COUNT(challenge_id) FROM challenges WHERE user_id = $profileViewUserID AND challenge_type = 4 AND (challenge_status !=3 AND challenge_status !=7);");
$counter2 = mysqli_fetch_assoc($ideaCreated);
$totalideaCreated = $counter2["COUNT(challenge_id)"];

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
        <link rel="stylesheet" href="css/profile_page_style.css">
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body style="background:#F0F1F2;">
        <?php include_once 'html_comp/navbar_homepage.php'; ?>
         
        <div class="media-body" style="padding-top: 60px;">
            <div class="col-md-1"> </div>
            <div class="col-md-2">
        <?php
            if (isset($_SESSION['user_id']) && $profileViewUserID == $_SESSION['user_id']) {
                echo "<a class = 'btn btn-default btn-xs' id='editprofile' style='cursor: pointer; margin-left: 170px;'>Edit</a>";
            }
            echo "<br/><img src='uploads/profilePictures/$UserName.jpg'  style='width:200px; height:200px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>"; 
            if ((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
                echo "<a data-toggle='modal' class = 'btn btn-default btn-xs'style='cursor: pointer' data-target='#uploadPicture'>Change Pic</a>";
                   } 
            ?>
            <div class='alert_placeholder'></div>
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
				  echo "<br/><span><br/><span class='glyphicon glyphicon-screenshot'></span>&nbsp;&nbsp;Skills &nbsp;:" ; 
				  }
            $skill_display = mysqli_query($db_handle, "SELECT b.skill_name from user_skills as a join skill_names as b WHERE a.user_id = '$profileViewUserID' AND a.skill_id = b.skill_id ;");
            if (mysqli_num_rows($skill_display) == 0) {
                    echo " <span class='tags'>No Skill added</span>";
            } 
            else {
                while ($skill_displayRow = mysqli_fetch_array($skill_display)) {
                    echo " <span class='tags' style='line-height: 2.1;'>".$skill_displayRow['skill_name']."</span>&nbsp;";
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
							<input type='text' id='newphoneno' class='form-control' value='".$profileViewPhone."'/>" ;
                   if($aboutuserRow['organisation_name'] != "") {
                              echo "<input type='text' id='companyname' class='form-control' value='".$aboutuserRow['organisation_name']."'/>" ;
						  }
						  else { echo "<input type='text' id='companyname' class='form-control' placeholder='Organisation Name'/>" ; }
					if($aboutuserRow['living_town'] != "") {
                             echo "<input type='text' id='livingtown' class='form-control' value = '".$aboutuserRow['living_town']."'/>" ;
						 }
						 else { echo "<input type='text' id='livingtown' class='form-control' placeholder='Current Living Town'/>" ; }
					if($aboutuserRow['about_user'] != "") {
						  echo "<textarea row='3' id='aboutuser' class='form-control' placeholder='About Yourself'>".$aboutuserRow['about_user']."</textarea>" ;
					  }
					  else { echo "<textarea row='3' id='aboutuser' class='form-control' placeholder='About Yourself'></textarea>" ; }
					  echo "<br/><a class='btn-success btn-sm' style='cursor:pointer;' onclick='editProfile(\"".$profileViewFirstName."\",\"".$profileViewLastName.
                                 "\",\"".$profileViewEmail."\",\"".$profileViewPhone."\")'>Change</a>";
                    }
                    ?>
        </div>
                </div>
          <div class="col-md-6">
            <div>
              <ul class="nav nav-tabs" role="tablist" style="font-size:14px; margin-bottom: 0px;">
                  <li role="presentation" class="active" id="created_project">
                      <a href="#tabCreatedProjects" role="tab" data-toggle="tab" style="padding: 15px 4px;">
                        Created Projects 
                        <span class="badge">
                            <?=$totalProjectCreated?>
                        </span>
                      </a>
                  </li>
                  <li role="presentation" id="joined_project">
                     <a href="#tabJoinedProjects" role="tab" data-toggle="tab">
                        Joined Projects 
                        <span class="badge">
                            <?=$projectsJoined?>
                        </span>
                     </a>
                  </li>
                  <li role="presentation" id="user_articles">
                    <a href="#tabArticles" role="tab" data-toggle="tab">
                        Articles 
                        <span class="badge">
                            <?= $totalarticleCreated?>
                        </span>
                    </a>
                  </li>
                  <li role="presentation" id="user_challenges">
                    <a href="#tabChallanges" role="tab" data-toggle="tab">
                        Challenges 
                        <span class="badge">
                            <?= $totalChallengeCreated?>
                        </span>
                    </a>
                    </li>
                  <li role="presentation" id="user_idea">
                    <a href="#tabIdeas" role="tab" data-toggle="tab">
                        Ideas 
                        <span class="badge">
                            <?= $totalideaCreated?>
                        </span>
                    </a>
                  </li>
              </ul>
            </div>
            <div class="tab-content" >
                <div role="tabpanel" class="row tab-pane active" id="tabCreatedProjects">       
                    <?php created_projects($db_handle,$profileViewUserID); ?>
                    <div id='next_CP'>
                    </div>
            </div>
            <div role="tabpanel" class="row tab-pane" id="tabJoinedProjects" >
                <div id="joined_project_content"></div>
                <div id='next_JnPr'>
                </div>
            </div>
            <div role="tabpanel" class="row tab-pane" id="tabArticles">
                <div id="user_articles_content"></div>
                <div id='next_user_article'>
                </div>
            </div>
            <div role="tabpanel" class="row tab-pane" id="tabChallanges">
                <div id="user_challenges_content"></div>
                    <div id='next_user_chall'>
                    </div>
                </div>
            <div role="tabpanel" class="row tab-pane" id="tabIdeas">
                <div id="user_idea_content"></div>
                <div id="user_next_idea"></div>
            </div>
            </div>
        </div> 
                <div class ="col-md-2">
                    <?php include_once 'html_comp/known.php' ?>
                    <?php 
						if(isset($_SESSION['user_id'])) {
							include_once 'html_comp/friends.php';
							}
					  ?>
                </div>
                </div>
                <?php include_once 'html_comp/signup.php' ; ?>        
<div id="InfoBox"></div>
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
        <?php include_once 'lib/html_inc_footers.php'; ?>
        <script>
$(".editprofile").hide();
$(".viewprofile").show();
$("#editprofile").click(function(){
	$(".viewprofile").toggle();
	$(".editprofile").toggle();
});
</script>
        	<script>
        $(window).scroll(function(event) {
            if ($(window).scrollTop() == ($(document).height() - $(window).height()) && $('#created_project')) {
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
        <?php include_once 'html_comp/login_signup_modal.php'; ?>
    </body>
</html>
