<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';

if($_POST['videos']){
	$user_id = $_SESSION['user_id'];	
	$challangetext = $_POST['videos'];
	$pro_id = $_SESSION['project_id'] ;	
	$challenge_title = $_POST['title'] ;
	$videodes = $_POST['videodes'] ;
	$challange = $challangetext."<br/> ".$videodes ;
	$username = $_SESSION['username'];
	$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$title = $inforow['project_title'] ;
	$type = $inforow['project_type'] ;
	$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id';");
    if(mysqli_num_rows($member_project) != 0) {
			if($type == 2) {
				$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and
													a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
				while ($memrow = mysqli_fetch_array($members)){
					$emails = $memrow['email'] ;
					$mail = $memrow['username'] ;
					$body2 = "http://collap.com/profile.php?username=".$mail ;
					collapMail($emails, $username." Add Video IN Project ".$title, $body2);
					} 
				}									
			if (strlen($challange) < 1000) {
				mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type) 
											VALUES ('$user_id', '$pro_id', '$challenge_title', '$challange', '1', '1', '8') ; ") ;
					$idp = mysqli_insert_id($db_handle);
				involve_in($db_handle,$user_id,"10",$idp);
				events($db_handle,$user_id,"10",$idp); 
				if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
				else { echo "Video Posted Successfully !!!"; }
			}
			else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
										VALUES (default, '$challange');");
				
				$id = mysqli_insert_id($db_handle);
				mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type) 
										VALUES ('$user_id', '$pro_id', '$challenge_title', '$id', '1', '1', ' ', '8');");
			   $idp = mysqli_insert_id($db_handle);
			  involve_in($db_handle,$user_id,"10",$idp);
			  events($db_handle,$user_id,"10",$idp); 
			 if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
			else { echo "Video Posted Successfully !!!"; }
			}
		}
else echo "Please Join Project First!";
mysqli_close($db_handle);
}
else echo "Invalid parameters!";	
?>
