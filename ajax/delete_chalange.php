<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if(isset($_SESSION['user_id'])) { $user_id = $_SESSION['user_id']; }
else { header ('location:../index.php'); }

if ($_POST['id']) {
	$knownid = $_POST['id'];
	$pro_id = $_POST['project_id'] ;
	$case = $_POST['type'];
	$time = date("Y-m-d H:i:s") ;
	$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1' ;");
	
	switch($case) {
		case 1:
			mysqli_query($db_handle, "UPDATE response_challenge SET status = '3' WHERE response_ch_id = '$knownid' and user_id = '$user_id' ;") ;
			if(mysqli_error($db_handle)) { echo "Failed to delete!"; } 
			else { echo "Deleted succesfully!"; }
			exit ;
			break ;
			
		case 2:
			mysqli_query($db_handle, "UPDATE response_project SET status = '3' WHERE response_pr_id = '$knownid' and user_id = '$user_id' ;") ;
			if(mysqli_error($db_handle)) { echo "Failed to delete!"; } 
			else { echo "Deleted succesfully!"; }
			exit ;
			break ;
			
		case 4:
			mysqli_query($db_handle, "UPDATE projects SET project_type = '3' WHERE project_id = '$knownid' and user_id = '$user_id';") ;
			if(mysqli_error($db_handle)) { echo "Failed to delete Project!"; }
			else { 
				echo "Deleted succesfully!"; 
				unset($_SESSION['project_id']);
				}
			exit ;
			break ;
		
		case 3:
			mysqli_query($db_handle, "UPDATE challenges SET challenge_status = '3' WHERE challenge_id = '$knownid' and user_id = '$user_id';") ;
			if(mysqli_error($db_handle)) { echo "Failed to delete!"; }
			else { echo "Deleted succesfully!"; }
			exit ;
			break ;
			
		case 5:
			mysqli_query($db_handle, "UPDATE challenges SET challenge_status = '7' WHERE challenge_id = '$knownid' ;") ;
			events($db_handle,$user_id,"38",$knownid) ;
			involve_in($db_handle,$user_id,"38",$knownid) ;
			if(mysqli_error($db_handle)) { echo "Failed to Spam!"; }
			else { echo "Spammed succesfully!"; }
			exit ;
			break ;
			
		case 6:
			mysqli_query($db_handle, "UPDATE response_challenge SET status = '4' WHERE response_ch_id = '$knownid' ;") ;
			if(mysqli_error($db_handle)) { echo "Failed to Spam!"; }
			else { echo "Spammed succesfully!"; }
			exit ;
			break ;
		
		case 7:
			if(mysqli_num_rows($member_project) != 0) {
				mysqli_query($db_handle, "UPDATE projects SET project_type = '4' WHERE project_id = '$pro_id';") ;
				if(mysqli_error($db_handle)) { echo "Failed to Spam!"; } 
				else { echo "Spammed succesfully!"; }
				}
				else {echo "Please Join Project First!"; }
			exit ;
			break ;
			
		case 8:
			if(mysqli_num_rows($member_project) != 0) {	
				mysqli_query($db_handle, "UPDATE response_project SET status = '4' WHERE response_pr_id = '$knownid' ;") ;
				if(mysqli_error($db_handle)) { echo "Failed to Spam!"; }
				else { echo "Spammed succesfully!"; }
				}
				else {echo "Please Join Project First!"; }		
			exit ;
			break ;
			
		case 9:
			if(mysqli_num_rows($member_project) != 0) {	
				mysqli_query($db_handle, "UPDATE challenges SET challenge_status = '7' WHERE challenge_id = '$knownid' ;") ;
				events($db_handle,$user_id,"7",$knownid) ;
				involve_in($db_handle,$user_id,"7",$knownid) ;
				if(mysqli_error($db_handle)) { echo "Failed to Spam!"; }
				else { echo "Spammed succesfully!"; }
				}
				else {echo "Please Join Project First!"; }		
			exit ;
			break ;
			
		case 10:
			if(mysqli_num_rows($member_project) != 0) {
				mysqli_query($db_handle, "UPDATE response_challenge SET status = '4' WHERE response_ch_id = '$knownid' ;") ;
				if(mysqli_error($db_handle)) { echo "Failed to Spam!"; }
				else { echo "Spammed succesfully!"; }
				}
				else {echo "Please Join Project First!"; }
			exit ;
			break ;
		}
	}
	else echo "Access Denied";
mysqli_close($db_handle);
?>
