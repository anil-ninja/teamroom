<?php
include_once 'lib/db_connect.php';
include_once 'html_comp/start_time.php';
include_once 'functions/profile_page_function.php';
include_once 'functions/delete_comment.php';
$skill_id = $_GET['skill_id'];
$check = mysqli_query($db_handle, "SELECT * FROM skill_names WHERE skill_id = '$skill_id' ;") ;
if (mysqli_num_rows($check) == 0) {
    include_once 'error.php';
    exit;
}
else if (!isset($skill_id)) {
    include_once 'error.php';
    exit;
}
session_start();
$user_id = $_SESSION['user_id'] ;
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Skills</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenges, Projects, Problem solving, problems">
        <meta name="author" content="Rajnish">
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body>
		   <?php include_once 'html_comp/navbar_homepage.php'; 
		   $skilldata = "" ;
		   $aboutdata = "" ;
		   $userdata = "" ;
		   $allusers = mysqli_query($db_handle, "SELECT Distinct user_id FROM user_skills WHERE skill_id = '$skill_id' ;") ;
		   while( $allusersRow = mysqli_fetch_array($allusers)) {
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
                                    <a href='ninjaSkills.php?skill_id=".$usersSkillid."' >".$usersSkillname."</a>&nbsp";
                            if ((isset($_SESSION['user_id'])) && ($user_id == $users_ids)) {
                   $skilldata = $skilldata ."<a type='submit' class='btn-link badge' style='padding-left: 0px; padding-right: 0px;' id='remove_skill' 
											onclick='remove_skill(\"".$usersSkillid."\");' data-toggle='tooltip' data-placement='bottom' 
											data-original-title='Remove Skill'><i class='icon-remove'></i></a>";
                             }
                   $skilldata = $skilldata . "</span>&nbsp;";
			   }
			   $usersAbout = mysqli_query($db_handle, "SELECT * FROM about_users WHERE user_id = '$users_ids' ;") ;
               $usersAboutRow = mysqli_fetch_array($usersAbout);
               $aboutdata.= "<div class='panel panel-primary'>" ;
               if (mysqli_num_rows($usersAbout) != 0) {
					$aboutdata = $aboutdata . "<span class='icon-briefcase'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['organisation_name']."<br/>
											   <span class='icon-home'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['living_town']."<br/>
											   <span class='icon-comment'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['about_user'] ;
				}
        		else {
        			$aboutdata = $aboutdata ."<span class='icon-briefcase'></span>&nbsp;&nbsp;&nbsp;No Information Available<br/>
											  <span class='icon-home'></span>&nbsp;&nbsp;&nbsp;No Information Available<br/>
											  <span class='icon-comment'></span>&nbsp;&nbsp;&nbsp;No Information Available";
        		}
        		$aboutdata = $aboutdata ."</div>" ;
        	echo "<div class='row-fluid' style='max-height : 170px ;'>
					<div class='span2 offset1'>
						<img src='uploads/profilePictures/$usersUsername.jpg'  style='width:150px; height:150px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
					</div>
					<div class='span2'>
						<div class='panel panel-primary'>".$userdata."</div>
					</div>
					<div class='span2'>
						<div class='panel panel-primary'>
							<div style ='text-align:justify;' id='appendskill'><i class='icon-screenshot'></i>Skills &nbsp;:".$skilldata."</div>
						</div>
					</div>
					<div class='span4'>".$aboutdata."</div>
				  </div>" ;
			$skilldata = "" ;
		   $aboutdata = "" ;
		   $userdata = "" ;	  
			}		
		if(isset($_SESSION['user_id'])) {
    		include_once 'html_comp/friends.php';
    	}
    include_once 'html_comp/signup.php' ;
	include_once 'lib/html_inc_footers.php';
	include_once 'html_comp/login_signup_modal.php';
    include_once 'html_comp/insert_time.php';
    ?>		  
	</body>
</html>	
