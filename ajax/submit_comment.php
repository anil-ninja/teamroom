<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['id']){
	$user_id = $_SESSION['user_id'];
	$id = $_POST['id'];
	$stmt=$_POST['projectsmt'];
	$case = $_POST['case'];
	if ($case == 1) {
		events($db_handle,$user_id,"3",$id);
		involve_in($db_handle,$user_id,"3",$id);
		if (strlen($stmt)<1000) {	
			mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) VALUES ('$user_id', '$id', '$stmt');") ;
			}
			else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$stmt');");
				$ida = mysqli_insert_id($db_handle);
				mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, blob_id) VALUES ('$user_id', '$id', ' ', '$ida');") ;
				}
		}
		else {
			events($db_handle,$user_id,"14",$id);
			involve_in($db_handle,$user_id,"14",$id);
			if (strlen($resp_stmt)<1000) {
				mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt) VALUES ('$user_id', '$id', '$stmt');") ;
				}
				else {
					mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$stmt');");
					$idb = mysqli_insert_id($db_handle);
					mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt, blob_id) VALUES ('$user_id', '$id', ' ', '$idb');") ;
					}
			}
	if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
	else { echo "Posted succesfully!"; }
	}
else echo "Invalid parameters!";
mysqli_close($db_handle);
?>
