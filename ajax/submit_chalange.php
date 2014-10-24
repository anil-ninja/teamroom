<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$challange = $_POST['challange'] ;
	$opentime = $_POST['opentime'] ;
	$chall = $_POST['challtype'] ;
	$challenge_title = $_POST['challenge_title'] ;
	$challange_eta = $_POST['challange_eta'] ;
if ($chall == '1') {
 if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA) 
                                    VALUES ('$user_id', '$challenge_title', '$challange', '$opentime', '$challange_eta') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt) 
                                VALUES ('$user_id', '$challenge_title', '$id', '$opentime', '$challange_eta', ' ');");
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
}
}
else {
	if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$challenge_title', '$challange', '1', '999999999', '3') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type) 
                                VALUES ('$user_id', '$challenge_title', '$id', '1', '999999999', ' ', '3');");
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
}
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
