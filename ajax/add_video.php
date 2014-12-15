<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';

//echo "i am not working before post";
if($_POST['video']){
	$user_id = $_SESSION['user_id'];	
	$challangetext = $_POST['video'] ;
	$challenge_title = $_POST['title'] ;
	$videodes = $_POST['videodes'] ;
	$challange = $challangetext."<br/> ".$videodes ;
	$time = date("Y-m-d H:i:s") ;
	if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, last_update) 
                                    VALUES ('$user_id', '$challenge_title', '$challange', '1', '999999', '8', '$time') ; ") ;
			$idp = mysqli_insert_id($db_handle);
		involve_in($db_handle,$user_id,"1",$idp); 
		if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
		else { echo "Video Posted Successfully !!!"; }
	}
	else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type, last_update) 
                                VALUES ('$user_id', '$challenge_title', '$id', '1', '999999', ' ', '8', '$time');");
       $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"1",$idp); 
	 if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
	else { echo "Video Posted Successfully !!!"; }
	}
mysqli_close($db_handle);
}
else echo "Invalid parameters!";
	
?>
