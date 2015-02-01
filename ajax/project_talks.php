<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';

if ($_POST['talk']) {
		$user_id = $_SESSION['user_id'] ;
		$pro_id = $_POST['project_id'];
		$pr_respon = $_POST['talk'] ;
		$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
    if(mysqli_num_rows($member_project) != 0) {
		events($db_handle,$user_id,"31",$pro_id) ;
		involve_in($db_handle,$user_id,"31",$pro_id) ;
		if (strlen($pr_respon) < 1000) {
			mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt, status) VALUES ('$user_id', '$pro_id', '$pr_respon', '5') ; ") ;
			if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
			else { echo "Posted succesfully!"; }
			} 
			else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$pr_respon');");
				$id = mysqli_insert_id($db_handle);
				mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, blob_id, stmt, status) VALUES ('$user_id', '$pro_id', '$id', ' ', '5') ; ") ;
				if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
				else { echo "Posted succesfully!"; }
				}
		mysqli_close($db_handle);
		}
		else echo "Please Join Project First!";
	} 
	else echo "Invalid parameters!";
?>
