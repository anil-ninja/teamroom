<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['profile']){
		$user_id = $_SESSION['user_id'] ;
		echo "Posted succesfully!"; 
}
	else echo "Invalid parameters!";
	mysqli_close($db_handle);
?>
