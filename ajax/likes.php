<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if(!isset($_SESSION['user_id'])) { echo "Please Log In First" ; }
else {
if(isset($_POST['id'])){
	$user_id = $_SESSION['user_id'];
	$id = $_POST['id'];
	$pro_id = $_SESSION['project_id'];
	$case = $_POST['case'];	
	$time = date("Y-m-d H:i:s") ;
    if($case == 1){
		mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '1');") ;
		mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$id' ; ") ;
		events($db_handle,$user_id,"16",$id);
		involve_in($db_handle,$user_id,"16",$id);
		if(mysqli_error($db_handle)) { echo mysqli_error($db_handle); }
		else { echo "Posted successfully"; }
		}
		else if($case == 2){
			mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '2');") ;
			mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$id' ; ") ;
			events($db_handle,$user_id,"17",$id);
			involve_in($db_handle,$user_id,"17",$id);
			if(mysqli_error($db_handle)) { echo mysqli_error($db_handle); }
			else { echo "Posted successfully"; }
			}
			else {
				$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1' ;");
				if(mysqli_num_rows($member_project) != 0) {
					$username = $_SESSION['username'];
					$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
					$inforow = mysqli_fetch_array($info) ;
					$title = $inforow['project_title'] ;
					$type = $inforow['project_type'] ;
					if($type == 2) {
						$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where
															a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
						while ($memrow = mysqli_fetch_array($members)){
							$emails = $memrow['email'] ;
							$mail = $memrow['username'] ;
							$body2 = "Hi, ".$mail." \n \n ".$username." Likes http://collap.com/challengesOpen.php?challenge_id=".$id."  \n \n IN Project (".$title."). View at \n
http://collap.com/project.php?project_id=".$pro_id ;
							collapMail($emails, "Like In Project ", $body2);
							} 
						}
				if($case == 3) {
					mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '1');") ;
					mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$id' ; ") ;
					events($db_handle,$user_id,"16",$id);
					involve_in($db_handle,$user_id,"16",$id);
					if(mysqli_error($db_handle)) { echo mysqli_error($db_handle); }
					else { echo "Posted successfully"; }
					}
					else {
						mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '2');") ;
						mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$challenge_id' ; ") ;
						events($db_handle,$user_id,"17",$id);
						involve_in($db_handle,$user_id,"17",$id);
						if(mysqli_error($db_handle)) { echo mysqli_error($db_handle); }
						else { echo "Posted successfully"; }
						}
					}	
					else {echo "Please Join Project First!"; }
				}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
}
?>
