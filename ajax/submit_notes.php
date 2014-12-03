<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['notes']){
	$user_id = $_SESSION['user_id'] ;
	$pro_id = $_SESSION['project_id'] ;
	$notestext = $_POST['notes'] ;
	$image = $_POST['img'] ;
	$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id';");
    if(mysqli_num_rows($member_project) != 0) {
	if (strlen($image) < 30 ) {
		$notes = $notestext ;
	}
	else {
		$notes = $image."<br/> ".$notestext ;
		}
	$notes_title = $_POST['notes_title'] ;
 if (strlen($notes) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, project_id, stmt, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$notes_title', '$pro_id', '$notes', '1', '1', '6') ; ") ;
      $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"10",$idp); 
       events($db_handle,$user_id,"10",$idp);
    if(mysqli_error($db_handle)) { echo "Failed to Post Notes!"; }
	else { echo "Posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$notes');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, project_id, blob_id, challenge_open_time, challenge_ETA, challenge_type) 
                                VALUES ('$user_id', '$notes_title', '$pro_id', '$id', '1', '1', '6');");
      $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"10",$idp); 
       events($db_handle,$user_id,"10",$idp);
	 if(mysqli_error($db_handle)) { echo "Failed to Post Notes!"; }
	else { echo "Posted succesfully!"; }
}
	mysqli_close($db_handle);
}
else echo "Please Join Project First!";
} 
else echo "Invalid parameters!";
?>
