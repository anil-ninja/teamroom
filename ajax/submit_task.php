<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['email']){
	$user_id = $_SESSION['user_id'];
	$details = $_POST['taskdetails'] ;
	$id = $_POST['id'] ;
	$email = $_POST['email'] ;
	$assigned = mysqli_query($db_handle,"select user_id from user_info where email = '$email' ;") ;
	$assignedrow = mysqli_fetch_array($assigned) ;
	$owner = $assignedrow['user_id'] ;
	$title = $_POST['title'] ;
	$challange_eta = $_POST['challange_eta'] ;
 if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status) 
                                    VALUES ('$user_id', '$id', '$title', '$details', '1', '$challange_eta', '8', '2') ; ") ;
        $ida = mysqli_insert_id($db_handle);
       mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$ida', '$challange_eta', '5');") ;                            
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Task assigned succesfully!"; }
} 
else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$details');");
        
        $idb = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, challenge_type, challenge_status) 
                                VALUES ('$user_id', '$id', '$title', '$idb', '1', '$challange_eta', '8', '2');");
        $idc = mysqli_insert_id($db_handle);
       mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$idc', '$challange_eta', '5');") ;
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Task assigned succesfully!"; }
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
