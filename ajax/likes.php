<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if(isset($_POST['id'])){
	$user_id = $_SESSION['user_id'];
	$id = $_POST['id'];
	$case = $_POST['case'];
	//events($db_handle,$user_id,"3",$id);
    //involve_in($db_handle,$user_id,"3",$id);	
	mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '$case');") ;
	if(mysqli_error($db_handle)) { echo mysqli_error($db_handle); }
	else { echo "Posted successfully"; }
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
