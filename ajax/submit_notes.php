<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['notes']){
	$user_id = $_SESSION['user_id'];
	$pro_id = $_SESSION['project_id'] ;
	$notes = $_POST['notes'] ;
	$notes_title = "Notes" ;
	$opentime = 1 ;
	$challange_eta = 1 ;
	$type = 6 ;
 if (strlen($notes) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, project_id, stmt, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$notes_title', '$pro_id', '$notes', '$opentime', '$challange_eta', '$type') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Notes!"; }
	else { echo "Notes posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO projects_blob (project_blob_id, stmt) 
                                VALUES (default, '$notes');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, project_id, challenge_blob_id, challenge_open_time, challenge_ETA, challenge_type) 
                                VALUES ('$user_id', '$notes_title', '$pro_id', '$id', '$opentime', '$challange_eta', '$type');");
	 if(mysqli_error($db_handle)) { echo "Failed to Post Notes!"; }
	else { echo "Notes posted succesfully!"; }
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
