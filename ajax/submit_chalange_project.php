<?php
session_start();
include_once "../lib/db_connect.php";
include_once 'project.inc.php';
if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$pro_id = $_SESSION['project_id'] ;	
	$challange = htmlspecialchars(trim($_POST['challange']), ENT_QUOTES);
	$opentime = $_POST['opentime'] ;
	$challenge_title = $_POST['challenge_title'] ;
	$challange_eta = $_POST['challange_eta'] ; 
	$type = $_POST['type'] ;
if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$pro_id', '$challenge_title', '$challange', '$opentime', '$challange_eta', '$type') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO projects_blob (project_blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, challenge_blob_id, challenge_open_time, challenge_ETA, challenge_type) 
                                VALUES ('$user_id', '$pro_id', '$challenge_title', '$id', '$opentime', '$challange_eta', '$type');");
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
}

	mysqli_close($db_handle);
}
?>
