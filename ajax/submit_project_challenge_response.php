<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['challenge_of_pr_resp']){
	$user_id = $_SESSION['user_id'];
	$pro_id = $_SESSION['project_id'] ;
	$notes = $_POST['challenge_of_pr_resp'] ;
	$ch_id = $_POST['challenge_of_project_id'] ;
       mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) VALUES ('$user_id', '$ch_id', '$notes') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Comment!"; }
	else { echo "Comment posted succesfully!"; }
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
