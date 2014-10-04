<?php
session_start();
include_once "../lib/db_connect.php";
include_once 'project.inc.php';
if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$pro_id = $_SESSION['project_id'] ;
	$challange = $_POST['challange'] ;
	$opentime = $_POST['opentime'] ;
	$challange_eta = $_POST['challange_eta'] ;
	$type = $_POST['type'] ;
if($type==2) {
	mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$pro_id', '$challange', '$opentime', '$challange_eta', '$type') ; ") ;
	if(mysqli_error($db_handle)){ echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
} else {
	mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge, challenge_open_time, challenge_ETA) 
                                    VALUES ('$user_id', '$challange', '$opentime', '$challange_eta') ; ") ;
	if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
}	mysqli_close($db_handle);
}
?>
