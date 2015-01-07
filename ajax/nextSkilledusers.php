<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['users']) {
    $user_id = $_SESSION['user_id'];
    $limit = $_SESSION['last_users'];
    $skill_id = $_POST['skill_id'];
    $a = (int)$limit ;
	$b = 5;
	$data = "";
	$skilldata = "" ;
	$aboutdata = "" ;
	$userdata = "" ;
	$iR = 0;
	$allusers = mysqli_query($db_handle, "SELECT Distinct user_id FROM user_skills WHERE skill_id = '$skill_id' ORDER BY user_id DESC LIMIT $a, $b ;") ;
   while( $allusersRow = mysqli_fetch_array($allusers)) {
	   $iR++;
	   $users_ids = $allusersRow['user_id'] ;
	   $userinfo = mysqli_query($db_handle, "SELECT * from user_info where user_id = '$users_ids' ;") ;
	   $userinfoRow = mysqli_fetch_array($userinfo) ;
	   $usersFirstname = $userinfoRow['first_name'] ;
	   $usersLastname = $userinfoRow['last_name'] ;
	   $usersUsername = $userinfoRow['username'] ;
	   $usersRank = $userinfoRow['rank'] ;
	   $usersEmail = $userinfoRow['email'] ;
	   $usersPhone = $userinfoRow['contact_no'] ;
	   $userdata .= " <span class='icon-user'></span>
					  <strong>
						<a href='profile.php?username=".$usersUsername."' >&nbsp".ucfirst($usersFirstname)." ".ucfirst($usersLastname)."</a>
					  </strong>&nbsp;
					  <i>(&nbsp;".$usersRank."&nbsp;)</i><br/>
					  <span class='icon-envelope' id='email' style='cursor: pointer'>&nbsp;&nbsp;".$usersEmail."</span>" ;
	  if($usersPhone != 1) {    
		  $userdata = $userdata . "<br/><span class='icon-phone' id='phone' style='cursor: pointer'>&nbsp;&nbsp;&nbsp;".$usersPhone."</span>";
	  }
	   $usersSkills = mysqli_query($db_handle, "SELECT b.skill_name, a.skill_id from user_skills as a join skill_names as b WHERE 
											a.user_id = '$users_ids' AND a.skill_id = b.skill_id ;");
	   while($usersSkillsRow = mysqli_fetch_array($usersSkills)) {
		  $usersSkillname = $usersSkillsRow['skill_name'] ;
		  $usersSkillid = $usersSkillsRow['skill_id'] ;
		  $skilldata .= "<span class='color tags' style='line-height: 2.1;background-color : #1ABC9C'>
							<a href='ninjaSkills.php?skill_id=".$usersSkillid."' >".$usersSkillname."</a>&nbsp
						 </span>&nbsp;";
	   }
	   $usersAbout = mysqli_query($db_handle, "SELECT * FROM about_users WHERE user_id = '$users_ids' ;") ;
	   $usersAboutRow = mysqli_fetch_array($usersAbout);
	   if (mysqli_num_rows($usersAbout) != 0) {
			$skilldata = $skilldata . "<br/><span class='icon-briefcase'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['organisation_name']."<br/>
									   <span class='icon-home'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['living_town'] ;
			$aboutdata .= "<span class='icon-comment'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['about_user'] ;
		}
		else {
			$aboutdata = $aboutdata ."<span class='icon-briefcase'></span>&nbsp;&nbsp;&nbsp;No Information Available<br/>
									  <span class='icon-home'></span>&nbsp;&nbsp;&nbsp;No Information Available<br/>
									  <span class='icon-comment'></span>&nbsp;&nbsp;&nbsp;No Information Available";
		}
	$data .="<div class='panel panel-primary' style='max-height : 150px ; margin-left:150px;margin-right:100px;'>
			<div class='container'>
			<div class='span2'>
				<img src='uploads/profilePictures/$usersUsername.jpg'  style='width:150px; height:150px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
			</div>
			<div class='span3'>
				<div style ='text-align:justify;' id='appendskill'>
					".$userdata."<br/><i class='icon-screenshot'></i>Skills &nbsp;:".$skilldata."
				</div>
			</div>
			<div class='span4'>".$aboutdata."</div>
		  </div>
		  </div><br/>" ;
	$skilldata = "" ;
   $aboutdata = "" ;
   $userdata = "" ;	  
	}
 if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['lastpanel'] = $a + $iR;
        
        echo $data ;
        $iR = 0;
    }
}
 else echo "Invalid parameters!";
mysqli_close($db_handle);
