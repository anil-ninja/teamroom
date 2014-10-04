<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$challange = $_POST['challange'] ;
	$opentime = $_POST['opentime'] ;
	$challange_eta = $_POST['challange_eta'] ;
	mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge, challenge_open_time, challenge_ETA) 
                                    VALUES ('$user_id', '$challange', '$opentime', '$challange_eta') ; ") ;
	
	if(mysqli_error($db_handle)) echo "Failed to Post Challange!";
	else echo "Challange posted succesfully!";
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
