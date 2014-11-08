<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';

//echo "i am not working before post";
if($_POST['video']){
	$user_id = $_SESSION['user_id'];	
	$challangetext = $_POST['video'];
	$pro_id = $_POST['project_id'] ;
	$challenge_title = $_POST['title'] ;
	$videodes = $_POST['videodes'] ;
	$challange = $challangetext." ".$videodes ;
	if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, project_id, stmt, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$challenge_title', '$pro_id', '$challange', '1', '1', '8') ; ") ;
			$idp = mysqli_insert_id($db_handle);
		involve_in($db_handle,$user_id,"1",$idp); 
		if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
		else { echo "Video Posted Successfully !!!"; }
	}
	else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, project_id, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type) 
                                VALUES ('$user_id', '$challenge_title', '$pro_id', '$id', '1', '1', ' ', '8');");
       $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"1",$idp); 
	 if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
	else { echo "Video Posted Successfully !!!"; }
	}
mysqli_close($db_handle);
}
else echo "Invalid parameters!";
	
?>
