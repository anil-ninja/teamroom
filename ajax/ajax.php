<?php
session_start();
include_once "../lib/db_connect.php";

$userID = $_SESSION['user_id'];

if(isset($_POST['commentID'])){
	$commentID = $_POST['commentID'];
	$sql = "DELETE FROM response_challenge WHERE response_ch_id = '$commentID' and user_id = '$userID';";
	mysqli_query($db_handle, $sql);

    if(mysqli_error($db_handle)) echo "Failed to delete Challange!"; 
	else echo "Deleted succesfully!"; 
} 
//else echo "Access Denied";
if(isset($_POST['comment_projectID'])){
	$ida = $_POST['comment_projectID'];
	$sql = "DELETE FROM response_project WHERE response_pr_id = '$ida' and user_id = '$userID';";
	mysqli_query($db_handle, $sql);
    if(mysqli_error($db_handle)) echo "Failed to delete Challange!"; 
	else echo "Deleted succesfully!"; 
} 

mysqli_close($db_handle);

?>
