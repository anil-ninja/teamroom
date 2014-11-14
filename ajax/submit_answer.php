<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['answer']){
		$user_id = $_SESSION['user_id'] ;
		$pro_id = $_POST['cid'] ;
		$notestext = $_POST['answer'] ;
		$image = $_POST['img'] ;
		$notes = $image."<br/> ".$notestext ;
		$a = date("Y-m-d H:i:s") ;
		involve_in($db_handle,$user_id,"5",$pro_id); 
       events($db_handle,$user_id,"5",$pro_id);
		mysqli_query($db_handle,"UPDATE challenges SET challenge_status='4' WHERE challenge_id = $pro_id ; ") ;
		mysqli_query($db_handle,"UPDATE challenge_ownership SET status='2', time='$a' WHERE challenge_id = $pro_id and user_id = '$user_id'; ") ;
	 if (strlen($notes) < 1000) {
        mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, status) VALUES ('$user_id', '$pro_id', '$notes', '2'); ") ;
		if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
		else { echo "Posted succesfully!"; }
	}
	else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$notes_title');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, blob_id, stmt, status) VALUES ('$user_id', '$pro_id', '$id', '$notes', '2');");
		if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
		else { echo "Posted succesfully!"; }
}
	
}	
	else echo "Invalid parameters!";
	mysqli_close($db_handle);
?>
