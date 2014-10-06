<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$challange = $_POST['challange'] ;
	$opentime = $_POST['opentime'] ;
	$challenge_title = $_POST['challenge_title'] ;
	$challange_eta = $_POST['challange_eta'] ;
 if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, challenge, challenge_open_time, challenge_ETA) 
                                    VALUES ('$user_id', '$challenge_title', '$challange', '$opentime', '$challange_eta') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO projects_blob (project_blob_id, project_stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, challenge_blob_id, challenge_open_time, challenge_ETA) 
                                VALUES ('$user_id', '$challenge_title', '$id', '$opentime', '$challange_eta');");
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
