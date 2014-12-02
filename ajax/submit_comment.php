<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if(isset($_POST['id'])){
	$user_id = $_SESSION['user_id'];
	$id = $_POST['id'];
	$stmt=$_POST['projectsmt'];
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
	if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
	else { echo "Posted succesfully!"; }
} 
elseif (isset($_POST['project_id'])) {
    echo "hfdjfdfdfdvfdjg fgdf dg fgd fd fd";
	$user_id = $_SESSION['user_id'];
	$pr_cm_id = $_POST['project_id'];
	$resp_stmt= $_POST['comment_project'];
	events($db_handle,$user_id,"3",$pr_cm_id);
    involve_in($db_handle,$user_id,"3",$pr_cm_id);
    echo "INSERT INTO response_project (user_id, project_id, stmt) VALUES ('$user_id', '$pr_cm_id', '$resp_stmt');";
	if (strlen($resp_stmt)<1000) {	
            mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt) VALUES ('$user_id', '$pr_cm_id', '$resp_stmt');") ;
        }
        else {
            mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$resp_stmt');");
            $idb = mysqli_insert_id($db_handle);
            mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt, blob_id) VALUES ('$user_id', '$pr_cm_id', ' ', '$idb');") ;
        }
	if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
	else { echo "Posted succesfully!"; }
} 
else echo "Invalid parameters!";
mysqli_close($db_handle);
?>
