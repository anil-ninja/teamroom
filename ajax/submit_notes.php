<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';

if($_POST['notes']){
	$user_id = $_SESSION['user_id'] ;
	$pro_id = $_SESSION['project_id'] ;
	$notestext = $_POST['notes'] ;
	$image = $_POST['img'] ;
	$username = $_SESSION['username'];
	$time = date("Y-m-d H:i:s") ;
	$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$title = $inforow['project_title'] ;
	$type = $inforow['project_type'] ;
	$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and
										a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
	while ($memrow = mysqli_fetch_array($members)){
		$emails = $memrow['email'] ;
		$mail = $memrow['username'] ;
		$body2 = "http://collap.com/profile.php?username=".$mail ;
		collapMail($emails, $username." Create Note IN Project ".$title, $body2);
		} 
	if (strlen($image) < 30 ) {
		$notes = $notestext ;
	}
	else {
		$notes = $image."<br/> ".$notestext ;
		}
	$notes_title = $_POST['notes_title'] ;
 if (strlen($notes) < 1000) {
		mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, project_id, stmt, challenge_open_time, challenge_ETA, challenge_type, last_update) 
									VALUES ('$user_id', '$notes_title', '$pro_id', '$notes', '1', '1', '6', '$time') ; ") ;
	  $idp = mysqli_insert_id($db_handle);
	  involve_in($db_handle,$user_id,"10",$idp); 
	   events($db_handle,$user_id,"10",$idp);
	if(mysqli_error($db_handle)) { echo "Failed to Post Notes!"; }
	else { echo "Posted succesfully!"; }
	} 
	else {
		mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
								VALUES (default, '$notes');");
		
		$id = mysqli_insert_id($db_handle);
		mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, project_id, blob_id, challenge_open_time, challenge_ETA, challenge_type, last_update) 
								VALUES ('$user_id', '$notes_title', '$pro_id', '$id', '1', '1', '6', '$time');");
	  $idp = mysqli_insert_id($db_handle);
	  involve_in($db_handle,$user_id,"10",$idp); 
	   events($db_handle,$user_id,"10",$idp);
	 if(mysqli_error($db_handle)) { echo "Failed to Post Notes!"; }
	else { echo "Posted succesfully!"; }
	mysqli_close($db_handle);
	}
}
else echo "Invalid parameters!";
?>
