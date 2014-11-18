<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';

if ($_POST['friendid']) {
		$user_id = $_SESSION['user_id'] ;
		$pro_id = $_POST['friendid'] ;
		$pr_respon = $_POST['message'] ;
		//echo $user_id."/".$pro_id ;
    	mysqli_query($db_handle,"INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$user_id', '$pro_id', '$pr_respon') ; ") ;
		if(mysqli_error($db_handle)) { echo mysqli_error($db_handle); }
		else { echo "Posted Successfully!"; }
mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
