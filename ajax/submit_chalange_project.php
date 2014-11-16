<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';

//echo "i am not working before post";
if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$pro_id = $_SESSION['project_id'] ;	
	$challangetext = $_POST['challange'];
	$opentime = $_POST['opentime'] ;
	$challenge_title = $_POST['challenge_title'] ;
	$challange_eta = $_POST['challange_eta'] ; 
	$image = $_POST['img'] ;
	if (strlen($image) < 30 ) {
		$challange = $challangetext ;
	}
	else {
		$challange = $image."<br/> ".$challangetext ;
		}
	$type = $_POST['type'] ;
	
	//echo "i am not working POST";
if (strlen($challange) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$pro_id', '$challenge_title', '$challange', '$opentime', '$challange_eta', '$type') ; ") ;
     $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"10",$idp); 
       events($db_handle,$user_id,"10",$idp);
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, challenge_type) 
                                VALUES ('$user_id', '$pro_id', '$challenge_title', '$id', '$opentime', '$challange_eta', '$type');");
        $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"10",$idp); 
       events($db_handle,$user_id,"10",$idp);
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Challange posted succesfully!"; }
}

	mysqli_close($db_handle);
}
?>
