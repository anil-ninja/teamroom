<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['update']){
	$user_id = $_SESSION['user_id'];
	$time = date("Y-m-d H:i:s") ;
	$_SESSION['last_login'] = $time ;
	mysqli_query($db_handle, " UPDATE user_info SET last_login = '$time' WHERE user_id = '$id' ;") ;
	if(mysqli_error($db_handle)) { echo "Failed to Update"; }
	else { echo "Updated Successfully"; }
	mysqli_close($db_handle);
}	
else echo "Invalid parameters!";
?>
