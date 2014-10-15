<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['notes']){
	$user_id = $_SESSION['user_id'];
	$notes = $_POST['notes'] ;
	$ch_id = $_POST['id'] ;
	if (strlen($notes) < 1000) {
       mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) VALUES ('$user_id', '$ch_id', '$notes') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Comment!"; }
	//else { echo "Comment posted succesfully!"; }
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
 if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA) 
                                    VALUES ('$user_id', '$challenge_title', '$challange', '$opentime', '$challange_eta') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA) 
                                VALUES ('$user_id', '$challenge_title', '$id', '$opentime', '$challange_eta');");
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
}
	mysqli_close($db_handle);
