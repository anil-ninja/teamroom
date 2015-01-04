<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$challangetext = $_POST['challange'] ;
	//$opentime = $_POST['opentime'] ;
	//$chall = $_POST['challtype'] ;
	$challenge_title = $_POST['challenge_title'] ;
	$image = $_POST['img'] ;
	$challange_eta = 999999 ;//$_POST['challange_eta'] ;
	$time = date("Y-m-d H:i:s") ;
	if (strlen($image) < 30 ) {
		$challange = $challangetext ;
	}
	else {
		$challange = $image."<br/> ".$challangetext ;
		}
/*if ($chall == '1') {
 if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, last_update) 
                                    VALUES ('$user_id', '$challenge_title', '$challange', '$opentime', '$challange_eta', '$time') ; ") ;
      $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"1",$idp);
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, last_update) 
                                VALUES ('$user_id', '$challenge_title', '$id', '$opentime', '$challange_eta', ' ', '$time');");
	 $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"1",$idp);
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Posted succesfully!"; }
}
}
else { */
	if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, last_update) 
                                    VALUES ('$user_id', '$challenge_title', '$challange', '1', '$challange_eta', '3', '$time') ; ") ;
		$idp = mysqli_insert_id($db_handle);
		involve_in($db_handle,$user_id,"1",$idp);
		if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
		else { echo "Posted succesfully!"; }
		}
		 else {
			mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$challange');");        
			$id = mysqli_insert_id($db_handle);
			mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type, last_update) 
									VALUES ('$user_id', '$challenge_title', '$id', '1', '$challange_eta', ' ', '3', '$time');");
			$idp = mysqli_insert_id($db_handle);
			involve_in($db_handle,$user_id,"1",$idp);
			if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
			else { echo "Posted succesfully!"; }
			}
	mysqli_close($db_handle);
}	 
else echo "Invalid parameters!";
?>
