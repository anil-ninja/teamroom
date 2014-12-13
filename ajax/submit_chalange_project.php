<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';

if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$pro_id = $_SESSION['project_id'] ;	
	$challangetext = $_POST['challange'];
	$opentime = 1;//$_POST['opentime'] ;
	$challenge_title = $_POST['challenge_title'] ;
	$challange_eta = 999999 ;//$_POST['challange_eta'] ; 
	$image = $_POST['img'] ;
	if (strlen($image) < 30 ) {
			$challange = $challangetext ;
		}
		else {
			$challange = $image."<br/> ".$challangetext ;
			}
		$type = $_POST['type'] ;
	$username = $_SESSION['username'];
	$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
    if(mysqli_num_rows($member_project) != 0) {
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
			collapMail($emails, $username." Create Challenge IN Project ".$title, $body2);
			} 
		if (strlen($challange) < 1000) {
			mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type) 
											VALUES ('$user_id', '$pro_id', '$challenge_title', '$challange', '$opentime', '$challange_eta', '$type') ; ") ;
			$idp = mysqli_insert_id($db_handle);
			involve_in($db_handle,$user_id,"10",$idp); 
			events($db_handle,$user_id,"10",$idp);
			if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
			else { echo "Posted succesfully!"; }
			}
			 else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$challange');");
				$id = mysqli_insert_id($db_handle);
				mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, stmt, blob_id, challenge_open_time, challenge_ETA, challenge_type) 
									VALUES ('$user_id', '$pro_id', '$challenge_title', ' ', '$id', '$opentime', '$challange_eta', '$type');");
				$idp = mysqli_insert_id($db_handle);
				involve_in($db_handle,$user_id,"10",$idp); 
				events($db_handle,$user_id,"10",$idp);
				if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
				else { echo "Posted succesfully!"; }
				}
		}
		else echo "Please Join Project First!";
		mysqli_close($db_handle);
	}
	else echo "Invalid parameters!";
?>
