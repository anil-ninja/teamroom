<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/image_resize.php';
include_once '../functions/collapMail.php';
if ($_POST['team']) {
	$userid = $_POST['userid'] ;
	$team = $_POST['team'] ;
	$email = $_POST['email'] ;
	$user_id = $_SESSION['user_id'] ;
	$pro_id = $_POST['project_id'] ;
	$username = $_SESSION['username'];
	$info =  mysqli_query($db_handle, "select * from projects where project_id = '$pro_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$title = $inforow['project_title'] ;
	$type = $inforow['project_type'] ;
	$userinfo = mysqli_query($db_handle, "select * from user_info where email = '$email' OR user_id = '$userid' ;") ;
	$userinfoRow = mysqli_fetch_array($userinfo) ;
	$newuserid = $userinfoRow['user_id'] ;
	$newuserfname = $userinfoRow['first_name'] ;
	$newuserlname = $userinfoRow['last_name'] ;
	$newusername = $userinfoRow['username'] ;
	$newuserrank = $userinfoRow['rank'] ;
	if($email == "") { 
		$check = mysqli_query($db_handle, "select * from teams projects where project_id = '$pro_id' and team_name = '$team' ;") ;
		if(mysqli_num_rows($check) != 0) {
			events($db_handle,$user_id,"15",$pro_id);
			involve_in($db_handle,$user_id,"15",$pro_id); 
			mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, project_id) VALUES ('$newuserid', '$team', '$pro_id');");
			$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where a.project_id = '$pro_id'
												and	a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
			while ($memrow = mysqli_fetch_array($members)){
				$emails = $memrow['email'] ;
				$mail = $memrow['username'] ;
				$userFirstName = $memrow['first_name'] ;
				$userLastName = $memrow['last_name'] ;
				$body2 = "<h2>Add Member in Team</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>A new member has been added in team ".$team.".</p>
<p>".$team." has a new member ".$uname." in project ".ucfirst($title)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
				collapMail($emails, "Member Added IN Team", $body2);
				}
			}
		else {
			mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, team_owner, project_id) VALUES ('$newuserid', '$team', '0', '$pro_id'), 
																											('$user_id','$team', '$user_id', '$pro_id');");
			events($db_handle,$user_id,"11",$pro_id) ;
			involve_in($db_handle,$user_id,"11",$pro_id) ;
			$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where a.project_id = '$pro_id' and
												a.user_id != '$user_id' and a.user_id = b.user_id and a.member_status = '1' ;") ;
			while ($memrow = mysqli_fetch_array($members)){
				$emails = $memrow['email'] ;
				$mail = $memrow['username'] ;
				$userFirstName = $memrow['first_name'] ;
				$userLastName = $memrow['last_name'] ;
				$body2 = "<h2>Create Team</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>A new team has been created in A project you are involved in.</p>
<p>".ucfirst($username)." has created a new team ".$team." in project ".ucfirst($title)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
				collapMail($emails, "Team  Created", $body2);
			} 						
		}
	}
	else { 
		mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, team_owner, project_id) VALUES ('$newuserid', '$team', '0', '$pro_id'), 
																										('$user_id','$team', '$user_id', '$pro_id');");
		events($db_handle,$user_id,"11",$pro_id) ;
		involve_in($db_handle,$user_id,"11",$pro_id) ;
		$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where a.project_id = '$pro_id' and
											a.user_id != '$user_id' and a.user_id = b.user_id and a.member_status = '1' ;") ;
		while ($memrow = mysqli_fetch_array($members)){
			$emails = $memrow['email'] ;
			$mail = $memrow['username'] ;
			$userFirstName = $memrow['first_name'] ;
			$userLastName = $memrow['last_name'] ;
			$body2 = "<h2>Create Team</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>A new team has been created in A project you are involved in.</p>
<p>".ucfirst($username)." has created a new team ".$team." in project ".ucfirst($title)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
				collapMail($emails, "Team  Created", $body2);
		}
	}
	$data = "<div class='span5' style=' margin:4px; background : rgb(240, 241, 242);'>
				<a type='submit' class='btn-link badge pull-right' id='remove_member' onclick='remove_member(\"".$pro_id."\", \"".$team."\", \"".$newuserid."\");' 
					data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Teammate'><span class='icon-remove'></span>
				</a>
				<a href ='profile.php?username=".$newusername."'>
				   <div class ='span2'>
					  <img src='".resize_image("uploads/profilePictures/$newusername.jpg", 30, 30, 2)."'  style='width:30px; height:30px;' onError=this.src='img/default.gif'>
				  </div>
				  <div class = 'span7' style='font-size:10px;'>
					  <span class='color pull-left' id='new_added'>".ucfirst($newuserfname)." ".ucfirst($newuserlname)."</span><br/>
					  <span style='font-size:10px;'>".$newuserrank."</span>
				  </div>
			   </a>
			</div>" ;
    if(mysqli_error($db_handle)) { echo "Failed to Create Team!"; }
	else { echo "Team Created Successfully !!!"."+".$data; }    
 mysqli_close($db_handle);
}
else echo "Invalid parameters!";
?>
