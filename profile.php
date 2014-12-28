<?php
include_once 'lib/db_connect.php';
include_once 'html_comp/start_time.php';
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
    <body>
        <?php include_once 'html_comp/navbar_homepage.php'; ?>
    <div class="">     
        <div class='row-fluid'>

            <div id='tab7' class="span2 offset1">
				
                <?php
                 echo " 	<center>
                             <b>
                                <span id='first_name' style='font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold,Calibri,sans-serif;'>&nbsp" 
                                    .ucfirst($profileViewFirstName)."
                                </span> 
                                <span id='last_name' style='font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold,Calibri,sans-serif;'>".ucfirst($profileViewLastName)."
                                </span>
                            
                            </b>
								</center>
                            
                           "
                            
                            ;
                            
                   
                
                    
                    echo "<br/>
                          <img src='uploads/profilePictures/$UserName.jpg'  style='width:200px; height:200px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>"; 
                    if ((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
                        echo "<center><a id='demo4' data-toggle='modal' class = 'btn btn-link btn-xs'style='cursor: pointer' data-target='#uploadPicture'>
                                Change Pic
                              </a></center>";
                           } 
                    if ((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] != $profileViewUserID)) {
        				$user_id = $_SESSION['user_id'] ;
        				$check = mysqli_query($db_handle, "SELECT user_id FROM user_info where user_id NOT IN (SELECT a.user_id FROM user_info as a join 
        												(SELECT DISTINCT b.user_id FROM teams as a join teams as b where a.user_id = '$user_id' and b.user_id = '$profileViewUserID' and
        												a.team_name = b.team_name ) as b where a.user_id = b.user_id) and user_id NOT IN (select a.user_id 
        												FROM user_info as a join known_peoples as b where b.requesting_user_id = '$user_id' and b.knowning_id = '$profileViewUserID' and
        												a.user_id = b.knowning_id and b.status != '4' and b.status != '3')
        												and user_id NOT IN (select a.user_id FROM user_info as a join known_peoples as b
        												where b.knowning_id = '$user_id' and b.requesting_user_id = '$profileViewUserID' and a.user_id = b.requesting_user_id and b.status = '2') ;") ;
        				while ($checkRow = mysqli_fetch_array($check)) {
        					$checkid = $checkRow['user_id'] ;
							if($profileViewUserID == $checkid) {
								echo "<input type = 'submit' class = 'btn btn-success' onclick='knownperson(".$profileViewUserID.")' value = 'Link'/>";
							}
        				}
                    } 
                ?>
                <div class='alert_placeholder'></div>
                <div class="viewprofile">
                <?php
                    if (isset($_SESSION['user_id']) && $profileViewUserID == $_SESSION['user_id']) {
                        echo "<a class = 'btn btn-link btm-lg' id='editprofile' style='cursor: pointer; margin-left: 170px;'>
								<span class = 'icon-pencil'></span>
							</a>";
                    }
                    echo "  
                            <span class='icon-user'>
                            </span>
                            <strong> 
                                <span id='first_name'>&nbsp" 
                                    .ucfirst($profileViewFirstName)."
                                </span> 
                                <span id='last_name'>".ucfirst($profileViewLastName)."
                                </span>
                            </strong>";
                            
                    echo "&nbsp;<i>(".$profileViewRank.")</i>
                          <br/>
                          <span class='icon-envelope' id='email' style='cursor: pointer'>&nbsp;" 
                            . $profileViewEmail . "
                          </span>" ;
                     if($profileViewPhone != 1) {    
                        echo "  <br/>
                                <span class='icon-earphone' id='phone' style='cursor: pointer'>&nbsp;" 
                                    . $profileViewPhone . "
                                    <br/>
                                </span>
                                <br/>
                                
                                    <br/>
                                    <span class='icon-screenshot'>
                                    </span>
                                    &nbsp;&nbsp;&nbsp;Skills:";
        			  }
        			  else {
        				  echo "    <br/>
                                    <span>
                                        <br/>
                                        <span class='icon-screenshot'>
                                        </span>&nbsp;&nbsp;Skills &nbsp;:" ; 
        				  }

                    $skill_display = mysqli_query($db_handle, "SELECT b.skill_name from user_skills as a join skill_names as b WHERE a.user_id = '$profileViewUserID' AND a.skill_id = b.skill_id ;");
                    
                    if (mysqli_num_rows($skill_display) == 0) {
                            echo "      <span class='tags'>
                                            No Skill added
                                        </span>";
                    } 
                    else {
                        while ($skill_displayRow = mysqli_fetch_array($skill_display)) {
                            echo "      <span class='tags' style='line-height: 2.1;'>"
                                            .$skill_displayRow['skill_name']."
                                        </span>&nbsp;";
                        }
                    }
                    echo "              <br/>
                                    </span>";
                    if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) { 
                        echo "      <br/>
                                    <a id='demo5' data-toggle='modal' class='btn-xs btn-primary ' data-target='#addskill' style='cursor:pointer;'>
                                        <i class='icon-plus'></i> Skill
                                    </a>
                                    <br/>";
        					}
                     $aboutuser = mysqli_query($db_handle, "SELECT organisation_name, living_town, about_user FROM about_users WHERE user_id = '$profileViewUserID' ;") ;
                     $aboutuserRow = mysqli_fetch_array($aboutuser);
                     if (mysqli_num_rows($aboutuser) != 0) {
        				 echo "     <br/>
                                    <span class='icon-briefcase'>
                                    </span>&nbsp;&nbsp;&nbsp;"
        							.$aboutuserRow['organisation_name']."<br/>
        							<span class='icon-home'>
                                    </span>&nbsp;&nbsp;&nbsp;"
        							.$aboutuserRow['living_town']."
                                    <br/>
                                    <span class='icon-comment'>
                                    </span>&nbsp;&nbsp;&nbsp;"
        							.$aboutuserRow['about_user'];
        			}
        			else {
        				if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
        					echo "   <br/>
                                    <span class='icon-briefcase'>
                                    </span>&nbsp;&nbsp;&nbsp;
                                    <a class = 'btn btn-default btn-xs' id='editprofile2' style='cursor: pointer;'>
                                        Edit
                                    </a>
                                    <br/>
        							<span class='icon-home'>
                                    </span>&nbsp;&nbsp;&nbsp;
                                    <a class = 'btn btn-default btn-xs' id='editprofile3' style='cursor: pointer;'>
                                        Edit
                                    </a>
                                    <br/>
        							<span class='icon-comment'>
                                    </span>&nbsp;&nbsp;&nbsp;
                                    <a class = 'btn btn-default btn-xs' id='editprofile4' style='cursor: pointer;'>
                                        Edit
                                    </a>";
        					}
        					else {
        						echo "<br/>
                                    <span class='icon-briefcase'>
                                    </span>&nbsp;&nbsp;&nbsp;No Information Available
                                    <br/>
        							<span class='icon-home'>
                                    </span>&nbsp;&nbsp;&nbsp;No Information Available
                                    <br/>
        							<span class='icon-comment'>
                                    </span>&nbsp;&nbsp;&nbsp;No Information Available";
        						}
        				}
                ?>
                </div>
                <div class="editprofile">
                    <?php    
                    if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) { 
                        echo "<br/><hr/><a data-toggle='modal' class='btn-xs btn-primary ' data-target='#addskill' style='cursor:pointer;'>
                                <i class='icon-plus'></i> Skill
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

            <div class="span6">
                <div id='demo6' class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                    <ul class="nav nav-tabs" style="padding: 0;">
                        <li class="active">
                            <a href="#tabCreatedProjects" data-toggle="tab" class="active " id="created_project" style="padding: 10px 5px;">
                                <i class='icon-star'> </i> <span>Created Projects</span> 
                                <span class="badge">
                                    <?= $totalProjectCreated ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tabJoinedProjects" data-toggle="tab" id="joined_project" style="padding: 10px 5px;">
                                <i class='icon-star-empty'> </i> <span>Joined Projects</span> 
                                <span class="badge">
                                    <?= $projectsJoined ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tabArticles" data-toggle="tab" id="user_articles" style="padding: 10px 5px;">
                                <i class='icon-book'> </i><span>Articles</span> 
                                <span class="badge">
                                    <?= $totalarticleCreated ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tabChallanges" data-toggle="tab" id="user_challenges" style="padding: 10px 5px;">
                                <i class='icon-question-sign'> </i><span>Challenges</span> 
                                <span class="badge">
                                    <?= $totalChallengeCreated ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tabIdeas" data-toggle="tab" id="user_idea" style="padding: 10px 5px;">
                                <i class='icon-magnet'> </i><span>Idea</span> 
                                <span class="badge">
                                    <?= $totalideaCreated ?>
                                </span>
                            </a>
                        </li>
                    </ul>
                <div class="tab-content" >
                    <div role="tabpanel" class="row tab-pane active" id="tabCreatedProjects">       
                        <?php created_projects($db_handle,$profileViewUserID); ?>
                        <div id='next_CP'>
                        </div>
                    </div>
                    <div role="tabpanel" class="row tab-pane" id="tabJoinedProjects" >
                        <div id="joined_project_content">
                            
                        </div>
                        <div id='next_JnPr'>
                        </div>
                    </div>
                    <div role="tabpanel" class="row tab-pane" id="tabArticles">
                        <div id="user_articles_content">
                            
                        </div>
                        <div id='next_user_article'>
                        </div>
                    </div>
                    <div role="tabpanel" class="row tab-pane" id="tabChallanges">
                        <div id="user_challenges_content">
                            
                        </div>
                        <div id='next_user_chall'>
                        </div>
                    </div>
                    <div role="tabpanel" class="row tab-pane" id="tabIdeas">
                        <div id="user_idea_content"></div>
                        <div id="user_next_idea"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id='tab9' class ="span2">
           <?php include_once 'html_comp/known.php'; ?>
        </div>
    </div>
    <?php 
		if(isset($_SESSION['user_id'])) {
    		include_once 'html_comp/friends.php';
    	}
    ?>
</div>      
              <?php include_once 'html_comp/signup.php' ;
			include_once 'lib/html_inc_footers.php'; 
			include_once 'html_comp/check.php'; ?> 
<!--Upload image Modal starts here -->

<div id="uploadPicture" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span4 offset2">

            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-picture"></i>&nbsp;<span>Add Picture</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <div class="row-fluid">
                            <h4><i class="icon-"></i>&nbsp;&nbsp;Upload new picture</h4>
                            
                            <label>Upload File</label>
                            <input type="file" id="_fileprofilepic"/>
                            
                            <br/><br/>
                            <a href="#" class=" btn btn-primary" id="upload_image"  value="Change">Upload&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
    <div id="addskill" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span4 offset2">
            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-plus"></i>&nbsp;<span>Add Skills</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <div class="row-fluid">
                            <h4>Select skill or add new skill</h4>

                            <label>Select Skill</label> 
                            <select class="inline-form" id = "skills" >
                                <option value='0' selected>Default (none)</option>
                                <?php
                                    $m = mysqli_query($db_handle, "select * from skill_names where 1 = 1 ;") ;
                                    while ($n = mysqli_fetch_array($m)) {
                                        $id = $n['skill_id'] ;
                                        $sn = $n['skill_name'] ;
                                        echo "<option value='" . $id . "' >" . $sn . "</option>";
                                    }
                                ?>
                            </select>
                            
                            <label>Enter your Skill</label>
                            <input type="text" class="input-block-level" id="insert" placeholder="Enter your Skill"/>
                            <a href="#" class=" btn btn-primary" id = "addskills">Add&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var width = window.screen.availWidth;
if(width < 800) {
	$('#tab7').hide();
	$('#tab9').hide();
	$("body").append("<div id='navtab'><div class='nav-btntab'><p class='icon-chevron-right'></p></div><div id='new'></div></div>");
	$("#new").html($("#tab7").html() + $("#tab9").html());
} ;
</script>
<script>
$(function() {
	$('#navtab').stop().animate({'margin-left':'-170px'},1000);

function toggleDivs() {
    var $inner = $("#navtab");
    if ($inner.css("margin-left") == "-170px") {
        $inner.animate({'margin-left': '0'});
		$(".nav-btntab").html('<p class="icon-chevron-left"></p><p class="icon-comment"></p>')
    }
    else {
        $inner.animate({'margin-left': "-170px"}); 
		$(".nav-btntab").html('<p class="icon-chevron-right"></p><p class="icon-comment"></p>')
    }
}
$(".nav-btntab").bind("click", function(){
    toggleDivs();
});

});
</script>       
        <!--<div id="InfoBox"></div>-->
<script>
	$(document).ready(function(){
		$(".editbox").hide();
		$(".text").show();			
		$(".editprofile").hide();
		$(".viewprofile").show();
		$("#editprofile").click(function(){
			$(".viewprofile").toggle();
			$(".editprofile").toggle();
		});
		$("#editprofile2").click(function(){
			$(".viewprofile").toggle();
			$(".editprofile").toggle();
		});
		$("#editprofile3").click(function(){
			$(".viewprofile").toggle();
			$(".editprofile").toggle();
		});
		$("#editprofile4").click(function(){
			$(".viewprofile").toggle();
			$(".editprofile").toggle();
		});
	}) ;
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
        <?php 
            include_once 'html_comp/login_signup_modal.php';
            include_once 'html_comp/insert_time.php'; 
        ?>
    </body>
</html>
