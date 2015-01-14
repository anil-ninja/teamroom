<?php
include_once 'lib/db_connect.php';
include_once 'html_comp/start_time.php';
include_once 'functions/profile_page_function.php';
include_once 'functions/delete_comment.php';
include_once 'functions/image_resize.php';
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
        <meta name="author" content="Anil">
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body>
		   <?php include_once 'html_comp/navbar_homepage.php'; ?>
		   <div class= '' style='margin-top: 60px;'></div>
		   <?php
		   $skilldata = "" ;
		   $aboutdata = "" ;
		   $userdata = "" ;
		   $_SESSION['last_users'] = 5 ;
		   $allusers = mysqli_query($db_handle, "SELECT Distinct user_id FROM user_skills WHERE skill_id = '$skill_id' ORDER BY user_id DESC limit 0, 5 ;") ;
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
				  $skilldata .= "<span class='btn-success'>
                                    <a href='ninjaSkills.php?skill_id=".$usersSkillid."' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".$usersSkillname."</a>&nbsp
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
        	echo "<div class='panel panel-default' style='margin-left:150px;margin-right:100px;'>
					<div class='container' style='height:auto;'>
					<div class='span2'>
						<img src='uploads/profilePictures/$usersUsername.jpg'  style='width:150px; height:150px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
					</div>
					<div class='span3'>
						<div style ='text-align:justify;' id='appendskill'>
							".$userdata."<br/><i class='icon-screenshot'></i>Skills &nbsp;: &nbsp;".$skilldata."
						</div>
					</div>
					<div class='span4'>".$aboutdata."</div>
				  </div>
				  </div><br/>" ;
			$skilldata = "" ;
		   $aboutdata = "" ;
		   $userdata = "" ;	  
			}
		echo "<div id='nextusers'></div>";			
		if(isset($_SESSION['user_id'])) {
    		include_once 'html_comp/friends.php';
    	}
    include_once 'html_comp/signup.php' ;
	include_once 'lib/html_inc_footers.php';
	include_once 'html_comp/login_signup_modal.php';
    include_once 'html_comp/insert_time.php';
    ?>
<div class='footer'>
		<a href='www.dpower4.com' target = '_blank' ><b>Powered By: </b> Dpower4</a>
		 <p>Making World a Better Place, because Heritage is what we pass on to the Next Generation.</p>
</div>
    <script>
    $(window).scroll(function(event) {
		if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
			event.preventDefault();
			var skill = <?php echo $skill_id ; ?> ;
			var dataString = 'users=5' + '&skill_id=' + skill ;
			$.ajax({
				type: "POST",
				url: "ajax/nextSkilledusers.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					$('#nextusers').append(result);
				}
			});
		}
	});
    
    </script>		  
	</body>
</html>	
