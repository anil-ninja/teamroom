<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if($_POST['amount']){
	$user_id = $_SESSION['user_id'] ;
	$amount = $_POST['amount'] ;
	$pro_id = $_POST['pro_id'] ;
	mysqli_query($db_handle, "INSERT INTO investment_info (user_id, project_id, investment) VALUES ('$user_id', '$pro_id', '$amount') ;") ;
	mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$user_id', '$pro_id', 'defaultteam') ;" ) ;
	events($db_handle,$user_id,"17",$pro_id);
	involve_in($db_handle,$user_id,"17",$pro_id); 
	if(mysqli_error($db_handle)) { echo "Failed!!!!"; }
	else { echo "Sucessfull!"; }
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
