<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if ($_POST['id']) {
	$user_id = $_SESSION['user_id'] ;
	$knownid = $_POST['id'];
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
			events($db_handle,$user_id,"13",$knownid);
			involve_in($db_handle,$user_id,"13",$knownid);
			mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$user_id', '$knownid', 'defaultteam') ;") ;
			echo "Joined succesfully";
			exit ;
			break ;
	}
} 
else echo "Invalid parameters!";
?>
