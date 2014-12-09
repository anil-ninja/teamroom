<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if ($_POST['id']) {
	$user_id = $_SESSION['user_id'] ;
	$knownid = $_POST['id'];
	$pro_id = $_SESSION['project_id'] ;
	$case = $_POST['case'];
	$time = date("Y-m-d H:i:s") ;
	switch($case) {
		case 1:
			mysqli_query($db_handle, "INSERT INTO known_peoples (requesting_user_id, knowning_id, last_action_time) VALUES ('$user_id', '$knownid', '$time') ;") ;
			if(mysqli_error($db_handle)) { echo "Request Already Send"; }
			else { echo "Request send succesfully"; }
			mysqli_close($db_handle);
			exit ;
			break ;
		case 2:
			events($db_handle,$user_id,"4",$knownid);
			involve_in($db_handle,$user_id,"4",$knownid);
			mysqli_query($db_handle,"UPDATE challenges SET challenge_status='2' WHERE challenge_id = '$knownid' ; ") ;
			mysqli_query($db_handle,"INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)
									VALUES ('$user_id', '$knownid', '1');") ;
			echo "Challenge Accepted succesfully";
			exit ;
			break ;
		case 3:
			events($db_handle,$user_id,"6",$knownid);
			involve_in($db_handle,$user_id,"6",$knownid);
			mysqli_query($db_handle,"UPDATE challenges SET challenge_status='5' WHERE challenge_id = '$knownid' ; ") ;
			echo "Challenge Closed succesfully";
			exit ;
			break ;
		case 4:
			$username = $_SESSION['username'];
			$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$knownid' ;") ;
			$inforow = mysqli_fetch_array($info) ;
			$title = $inforow['project_title'] ;
			$type = $inforow['project_type'] ;
			if($type == 2) {
				$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where a.project_id = '$knownid' and
													a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
				while ($memrow = mysqli_fetch_array($members)){
					$emails = $memrow['email'] ;
					$mail = $memrow['username'] ;
					$body2 = "http://collap.com/profile.php?username=".$mail ;
					collapMail($emails, $username." Joined IN Project ".$title, $body2);
					} 
				}
			events($db_handle,$user_id,"13",$knownid);
			involve_in($db_handle,$user_id,"13",$knownid);
			mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$user_id', '$knownid', 'defaultteam') ;") ;
			echo "Joined succesfully";
			exit ;
			break ;
		case 5:
			$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1' ;");
			if(mysqli_num_rows($member_project) != 0) {
				$username = $_SESSION['username'];
				$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
				$inforow = mysqli_fetch_array($info) ;
				$title = $inforow['project_title'] ;
				$type = $inforow['project_type'] ;
				$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where
													a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
				while ($memrow = mysqli_fetch_array($members)){
					$emails = $memrow['email'] ;
					$mail = $memrow['username'] ;
					$body2 = "http://collap.com/profile.php?username=".$mail ;
					collapMail($emails, $username." Accepted Challenge IN Project ".$title, $body2);
					} 
				events($db_handle,$user_id,"4",$knownid);
				involve_in($db_handle,$user_id,"4",$knownid);
				mysqli_query($db_handle,"UPDATE challenges SET challenge_status='2' WHERE challenge_id = '$knownid' ; ") ;
				mysqli_query($db_handle,"INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)
										VALUES ('$user_id', '$knownid', '1');") ;
				echo "Challenge Accepted succesfully";
				}
				else {echo "Please Join Project First!"; }
			exit ;
			break ;
		case 6:
			$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1' ;");
			if(mysqli_num_rows($member_project) != 0) {
				$username = $_SESSION['username'];
				$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
				$inforow = mysqli_fetch_array($info) ;
				$title = $inforow['project_title'] ;
				$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where
													a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
				while ($memrow = mysqli_fetch_array($members)){
					$emails = $memrow['email'] ;
					$mail = $memrow['username'] ;
					$body2 = "http://collap.com/profile.php?username=".$mail ;
					collapMail($emails, $username." Closed Challenge IN Project ".$title, $body2);
					} 
				events($db_handle,$user_id,"6",$knownid);
				involve_in($db_handle,$user_id,"6",$knownid);
				mysqli_query($db_handle,"UPDATE challenges SET challenge_status='5' WHERE challenge_id = '$knownid' ; ") ;
				echo "Challenge Closed succesfully";
				}
				else {echo "Please Join Project First!"; }
			exit ;
			break ;
		case 7:
			mysqli_query($db_handle, "update known_peoples set status='2', last_action_time='$time' where id='$knownid' and knowning_id='$user_id' ;") ; 
			if(mysqli_error($db_handle)) { echo "Sorry Try again!"; }
			else { echo "Request Accepted succesfully!"; }
			mysqli_close($db_handle);
			exit ;
			break ;
		case 8:
			mysqli_query($db_handle, "update known_peoples set status='3', last_action_time='$time' where id='$knownid' and knowning_id='$user_id' ;") ; 
			if(mysqli_error($db_handle)) { echo "Sorry Try again!" ; }
			else { echo "Request Deleted succesfully!"; }
			mysqli_close($db_handle);
			exit ;
			break ;
	}
} 
else echo "Invalid parameters!";
?>
