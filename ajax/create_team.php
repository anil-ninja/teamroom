<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if ($_POST['team']) {
	$email = $_POST['email'] ;
	$team = $_POST['team'] ;
	$user_id = $_SESSION['user_id'] ;
	$pro_id = $_SESSION['project_id'];
	$sql = mysqli_query($db_handle,"SELECT * FROM user_info where email='$email' ;") ;
	$data = mysqli_fetch_array($sql);
	$id = $data['user_id'] ;
	$username = $_SESSION['username'];
	$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$title = $inforow['project_title'] ;
	$type = $inforow['project_type'] ;
	$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and
										a.user_id != '$user_id' and a.user_id = b.user_id and a.member_status = '1' ;") ;
	while ($memrow = mysqli_fetch_array($members)){
		$emails = $memrow['email'] ;
		$mail = $memrow['username'] ;
		$body2 = "Hi, ".$mail." \n \n ".$username." Create Team IN Project (".$title."). View at \n
http://collap.com/project.php?project_id=".$pro_id ;
		collapMail($emails, " Team  Created ", $body2);
		} 
	mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, team_owner, project_id) VALUES 
								('$id', '$team', '0', '$pro_id'),
								('$user_id','$team', '$user_id', '$pro_id');");
	events($db_handle,$user_id,"11",$pro_id) ;
	involve_in($db_handle,$user_id,"11",$pro_id) ;						
     if(mysqli_error($db_handle)) { echo "Failed to Create Team!"; }
	else { echo "Team Created Successfully !!!"; }    
 mysqli_close($db_handle);
}
else echo "Invalid parameters!";
?>
