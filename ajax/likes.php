<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if(isset($_POST['id'])){
	$user_id = $_SESSION['user_id'];
	$id = $_POST['id'];
	$pro_id = $_POST['pid'];
	$case = $_POST['case'];
	//events($db_handle,$user_id,"3",$id);
    //involve_in($db_handle,$user_id,"3",$id);	
    if($case == 1 || $case == 2){
		mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '$case');") ;
		if(mysqli_error($db_handle)) { echo mysqli_error($db_handle); }
		else { echo "Posted successfully"; }
		}
		else {
			$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pid' and user_id = '$user_id';");
			if(mysqli_num_rows($member_project) != 0) {
				$username = $_SESSION['username'];
				$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
				$inforow = mysqli_fetch_array($info) ;
				$title = $inforow['project_title'] ;
				$type = $inforow['project_type'] ;
				if($type == 2) {
					$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and
														a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
					while ($memrow = mysqli_fetch_array($members)){
						$emails = $memrow['email'] ;
						$mail = $memrow['username'] ;
						$body2 = "http://collap.com/profile.php?username=".$mail ;
						collapMail($emails, $username." Likes IN Project ".$title, $body2);
						} 
					}
				mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '$case');") ;
				if(mysqli_error($db_handle)) { echo mysqli_error($db_handle); }
				else { echo "Posted successfully"; }	
				}
				else {echo "Please Join Project First!"; }
			}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
