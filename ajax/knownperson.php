<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['id']) {
		$user_id = $_SESSION['user_id'] ;
		$knownid = $_POST['id'];
		$time = date("Y-m-d H:i:s") ;
		mysqli_query($db_handle, "INSERT INTO known_peoples (requesting_user_id, knowning_id, last_action_time) VALUES ('$user_id', '$knownid', '$time') ;") ;
		if(mysqli_error($db_handle)) { echo "Request Already Send"; }
			else { echo "Request send succesfully"; }
mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
