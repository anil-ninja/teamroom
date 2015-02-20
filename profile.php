<?php
include_once 'lib/db_connect.php';
include_once 'html_comp/start_time.php';
include_once 'functions/profile_page_function.php';
include_once 'functions/delete_comment.php';
include_once 'functions/image_resize.php';
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
        <div class='row-fluid' style='margin-top: 60px;'>
            <div id='tab7' class="span2 offset1">
				
                <?php
                 echo " <center>
                             <b>
                                <span id='first_name' style='font-size: 20px;'>&nbsp" 
                                    .ucfirst($profileViewFirstName)."
                                </span> 
                                <span id='last_name' style='font-size: 20px;'>".ucfirst($profileViewLastName)."
                                </span>
                            </b>
						</center>" ;
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
                    if (isset($_SESSION['user_id']) && $profileViewUserID == $_SESSION['user_id']) {
                        echo "<a class = 'btn-link' style='cursor: pointer;margin-left:72%;color: #333;' id='editprofile'>
                                <span class = 'icon-pencil'></span> Edit 
                            </a>";
                    }                    
                    echo "<div>
                          <img src='uploads/profilePictures/$UserName.jpg'  style='width:200px; height:200px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>"; 
                    if ((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
                        echo "<center>
                                <a id='demo4' data-toggle='modal' class = 'btn-link' style='position: relative; top: -5px; padding: 4px; color: #333; font-weight: 600;cursor: pointer; padding:4px 15px 4px 15px;' data-target='#uploadPicture'>
                                    <span class = 'icon-pencil'></span>Change Pic
                                </a>
                             </center>";
                           } 
                    echo "</div>"; 
                ?>
                <div class='alert_placeholder'></div>
                <div class="viewprofile">
                <?php
                    
                    echo " <span class='icon-user'>
                            </span>
                            <strong> 
                                <span id='first_name'>&nbsp" 
                                    .ucfirst($profileViewFirstName)."
                                </span> 
                                <span id='last_name'>".ucfirst($profileViewLastName)."
                                </span>
                            </strong>";
                            
                    echo "&nbsp;<i>(&nbsp;".$profileViewRank."&nbsp;)</i>
                          <br/>
                          <span class='icon-envelope' id='email_user' style='cursor: pointer'>&nbsp;&nbsp;" 
                            . $profileViewEmail . "
                          </span>" ;
                     if($profileViewPhone != 1) {    
                        echo "  <br/>
                                <span class='icon-phone' id='phone' style='cursor: pointer'>&nbsp;&nbsp;&nbsp;" 
                                    . $profileViewPhone . "  
                                </span>";
        			  }
        				  echo " <br/><div style ='word-wrap: break-word;' id='appendskill'><i class='icon-screenshot'></i>Skills &nbsp;:" ; 

                    $skill_display = mysqli_query($db_handle, "SELECT b.skill_name, a.skill_id from user_skills as a join skill_names as b WHERE a.user_id = '$profileViewUserID' AND a.skill_id = b.skill_id ;");
                    
                    if (mysqli_num_rows($skill_display) == 0) {
                            echo "      <span class='tags removeskl'>
                                            No Skill added
                                        </span>";
                    } 
                    else {
                        while ($skill_displayRow = mysqli_fetch_array($skill_display)) {
                            $skill_id = $skill_displayRow['skill_id'];
                            echo "<span class='skill_id_".$skill_id."'><span class='btn-success'>
                                            <a href='ninjaSkills.php?skill_id=".$skill_id."' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>
                                            &nbsp;&nbsp;".str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $skill_displayRow['skill_name']))))."
                                            </a>&nbsp";
                            if ((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
                                echo "      <a type='submit' class='btn-success' style='padding-left: 0px; padding-right: 0px;' id='remove_skill' onclick='remove_skill(\"".$skill_id."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Remove Skill'>
                                                <i class='icon-remove'></i>
                                            </a>";
                            }
                         echo "</span></span>&nbsp;";
                        }
					}
                        echo "</div><br/>";
                    if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) { 
                        echo " <a id='demo5' data-toggle='modal' class='btn-xs btn-primary ' data-target='#addskill' style='cursor:pointer;padding:3px 10px; margin-top: 5px;'>
                                  <i class='icon-plus'></i> Skill
                               </a><br/>";
        					}
					echo " <br/><div style ='word-wrap: break-word;' id='appendprofession'><i class='icon-screenshot'></i>Professions &nbsp;:" ; 

                    $profession_display = mysqli_query($db_handle, "SELECT b.p_name, a.p_id from user_profession as a join professsion_name as b WHERE a.user_id = '$profileViewUserID' AND a.p_id = b.p_id ;");
                    
                    if (mysqli_num_rows($profession_display) == 0) {
                            echo "      <span class='tags removepro'>
                                            No Profession
                                        </span> ";
                    } 
                    else {
                        while ($profession_displayRow = mysqli_fetch_array($profession_display)) {
                            $profession_id = $profession_displayRow['p_id'];
                            echo "<span class='profession_".$profession_id."'><span class='btn-success'>
                                            <a style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;
                                            ".str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $profession_displayRow['p_name']))))."
                                            </a>&nbsp";
                            if ((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
                                echo "      <a type='submit' class='btn-success' style='padding-left: 0px; padding-right: 0px;' id='remove_profession' onclick='remove_profession(\"".$profession_id."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Remove Profession'>
                                                <i class='icon-remove'></i>
                                            </a>";
                            }
                         echo "</span></span>&nbsp;";
                        }
					}
                        echo "</div><br/>";
                    if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) { 
                        echo " <a data-toggle='modal' class='btn-xs btn-primary ' data-target='#addprofession' style='cursor:pointer;padding:3px 10px; margin-top: 5px;'>
                                 <i class='icon-plus'></i> Profession
                               </a><br/>";
        			}
                     $aboutuser = mysqli_query($db_handle, "SELECT organisation_name, living_town, about_user FROM about_users WHERE user_id = '$profileViewUserID' ;") ;
                     $aboutuserRow = mysqli_fetch_array($aboutuser);
                     if (mysqli_num_rows($aboutuser) != 0) {
        				 echo "     <br/>
                                    <span class='icon-briefcase'>
                                    </span>&nbsp;&nbsp;&nbsp;"
        							.str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $aboutuserRow['organisation_name']))))."<br/>
        							<span class='icon-home'>
                                    </span>&nbsp;&nbsp;&nbsp;"
        							.str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $aboutuserRow['living_town']))))."
                                    <br/>
                                    <span class='icon-comment'>
                                    </span>&nbsp;&nbsp;&nbsp;"
        							.str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $aboutuserRow['about_user']))));
        			}
        			else {
        				if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
        					echo "   <br/>
                                    <span class='icon-briefcase'>
                                    </span>&nbsp;&nbsp;&nbsp;
                                    <a class = 'btn-primary' style='cursor: pointer; padding:4px 15px 4px 15px;' id='editprofile2' >
                                        <span class = 'icon-pencil'></span> Edit
                                    </a>
                                    <br/><br/>
        							<span class='icon-home'>
                                    </span>&nbsp;&nbsp;&nbsp;
                                    <a class = 'btn-primary' style='cursor: pointer; padding:4px 15px 4px 15px;' id='editprofile3'>
                                        <span class = 'icon-pencil'></span> Edit
                                    </a>
                                    <br/><br/>
        							<span class='icon-comment'>
                                    </span>&nbsp;&nbsp;&nbsp;
                                    <a class = 'btn-primary' style='cursor: pointer; padding:4px 15px 4px 15px;' id='editprofile4'>
                                       <span class = 'icon-pencil'></span> Edit
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
                        echo "     <br/> 
                                    <a data-toggle='modal' class='btn-xs btn-primary ' data-target='#addprofession' style='cursor:pointer;padding:3px 10px; margin-top: 5px;'>
                                        <i class='icon-plus'></i> Profession
                                    </a>
                                    <br/>";
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
    					  echo "<br/><a class='btn btn-primary' style='cursor:pointer;' onclick='editProfile(\"".$profileViewFirstName."\",\"".$profileViewLastName.
                                     "\",\"".$profileViewEmail."\",\"".$profileViewPhone."\")'>Change</a>";
                        }
                    ?>
                </div>
            </div>

            <div class="span6">
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
                                <i class='icon-lightbulb'> </i><span>Idea</span> 
                                <span class="badge">
                                    <?= $totalideaCreated ?>
                                </span>
                            </a>
                        </li>
                    </ul>
                <div class="tab-content" >
                    <div role="tabpanel" class="tab-pane fade in active" id="tabCreatedProjects">       
                        <?php created_projects($db_handle,$profileViewUserID); ?>
                        <div id='next_CP'>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tabJoinedProjects" >
                        <div id="joined_project_content">
                            
                        </div>
                        <div id='next_JnPr'>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tabArticles">
                        <div id="user_articles_content">
                            
                        </div>
                        <div id='next_user_article'>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tabChallanges">
                        <div id="user_challenges_content">
                            
                        </div>
                        <div id='next_user_chall'>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tabIdeas">
                        <div id="user_idea_content"></div>
                        <div id="user_next_idea"></div>
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
<?php
	include_once 'html_comp/signup.php' ; 
	include_once 'lib/html_inc_footers.php';
	include_once 'html_comp/check.php'; ?> 
<!--Upload image Modal starts here -->
<div class='footer'>
		<a href='www.dpower4.com' target = '_blank' ><b>Powered By: </b> Dpower4</a>
		 <p>Making World a Better Place, because Heritage is what we pass on to the Next Generation.</p>
</div>
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
                            <a href="#" class=" btn btn-primary" onclick="upload_image()"  value="Change">Upload&nbsp; <i class="icon-chevron-sign-right"></i></a>
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
							<?php 
							$skill_display = mysqli_query($db_handle, "SELECT b.skill_name, a.skill_id from user_skills as a join skill_names as b WHERE a.user_id = '$profileViewUserID' AND a.skill_id = b.skill_id ;");
							echo "<div class='skillmodal' style ='text-align:justify;'><label>Your Skills</label>";
							if (mysqli_num_rows($skill_display) == 0) {
								echo "<span class='tags removeskl'> No Skill added </span>";
							} 
							else {
								while ($skill_displayRow = mysqli_fetch_array($skill_display)) {
									$skill_id = $skill_displayRow['skill_id'];
									echo "<span class='skill_id_".$skill_id."'><span class='btn-success' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $skill_displayRow['skill_name']))))."&nbsp
											  <a type='submit' class='btn-success' style='padding-left: 0px; padding-right: 0px;' id='remove_skill' onclick='remove_skill(\"".$skill_id."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Remove Skill'>
													<i class='icon-remove'></i>
											  </a>
										  </span></span>&nbsp;";
								}
							}
							echo "</div>";
							?>
							<label>Add Skills</label><br/>
                            <label>Select Skill</label> 
                            <select class="inline-form" id = "skills" >
                                <option value='0' selected>Default (none)</option>
                                <?php
                                    $m = mysqli_query($db_handle, "select * from skill_names where 1 = 1 ;") ;
                                    while ($n = mysqli_fetch_array($m)) {
                                        $id = $n['skill_id'] ;
                                        $sn = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $n['skill_name'])))) ;
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
<div id="addprofession" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span4 offset2">
            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-plus"></i>&nbsp;<span>Add Professions</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <div class="row-fluid">
                            <h4>Select Profession or add new </h4>
							<?php 
							$profession_display = mysqli_query($db_handle, "SELECT b.p_name, a.p_id from user_profession as a join professsion_name as b WHERE a.user_id = '$profileViewUserID' AND a.p_id = b.p_id ;");
							echo "<div class='professionmodal' style ='text-align:justify;'><label>Your Professions</label>";
							if (mysqli_num_rows($profession_display) == 0) {
								echo "<span class='tags removepro'> No Profession Added </span> ";
							}
							else {
								while ($profession_displayRow = mysqli_fetch_array($profession_display)) {
									$profession_id = $profession_displayRow['p_id'];
										echo "<span class='profession_".$profession_id."'><span class='btn-success' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $profession_displayRow['p_name']))))."&nbsp
											  <a type='submit' class='btn-success' style='padding-left: 0px; padding-right: 0px;' id='remove_profession' onclick='remove_profession(\"".$profession_id."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Remove Profession'>
													<i class='icon-remove'></i>
											  </a>
										  </span></span>&nbsp;";
								}
							}
							echo "</div>";
							?>
							<label>Add Professions</label><br/>
                            <label>Select Profession</label> 
                            <select class="inline-form" id = "Professions" >
                                <option value='0' selected>Default (none)</option>
                                <?php
                                    $Professions = mysqli_query($db_handle, "select * from professsion_name where 1 = 1 ;") ;
                                    while ($ProfessionsRow = mysqli_fetch_array($Professions)) {
                                        $Pid = $ProfessionsRow['p_id'] ;
                                        $Pname = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $ProfessionsRow['p_name'])))) ;
                                        echo "<option value='" . $Pid . "' >" . $Pname . "</option>";
                                    }
                                ?>
                            </select>
                            
                            <label>Enter your Profession</label>
                            <input type="text" class="input-block-level" id="insertprofession" placeholder="Enter your Profession"/>
                            <a href="#" class=" btn btn-primary" id="addprofessions" >Add&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
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
                    onLoaddata();
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
