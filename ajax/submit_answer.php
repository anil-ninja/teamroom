<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if($_POST['answer']){
		$user_id = $_SESSION['user_id'] ;
		$pro_id = $_POST['pid'] ;
		$ch_id = $_POST['cid'] ;
		$case = $_POST['case'] ;
		$notestext = $_POST['answer'] ;
		$image = $_POST['img'] ;
		if($case == 2) {
			$username = $_SESSION['username'];
			$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
			$inforow = mysqli_fetch_array($info) ;
			$title = $inforow['project_title'] ;
			$type = $inforow['project_type'] ;
			if($type == 2) {
				$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and
													a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
				while ($memrow = mysqli_fetch_array($members)){
					$emails = $memrow['email'] ;
					$mail = $memrow['username'] ;
					$body2 = "http://collap.com/profile.php?username=".$mail ;
					collapMail($emails, $username." Create Challenge IN Project ".$title, $body2);
					} 
				}
			}
		if (strlen($image) < 30 ) {
		$notes = $notestext ;
		}
		else {
			$notes = $image."<br/> ".$notestext ;
			}
		$a = date("Y-m-d H:i:s") ;
		involve_in($db_handle,$user_id,"5",$ch_id); 
       events($db_handle,$user_id,"5",$ch_id);
		mysqli_query($db_handle,"UPDATE challenges SET challenge_status='4' WHERE challenge_id = $ch_id ; ") ;
		mysqli_query($db_handle,"UPDATE challenge_ownership SET status='2', time='$a' WHERE challenge_id = $pro_id and user_id = '$user_id'; ") ;
	 if (strlen($notes) < 1000) {
        mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, status) VALUES ('$user_id', '$ch_id', '$notes', '2'); ") ;
	//echo "test";	
        if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
		else { echo "Posted succesfully!"; }
	}
	else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$notes_title');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, blob_id, stmt, status) VALUES ('$user_id', '$ch_id', '$id', '$notes', '2');");
		if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
		else { echo "Posted succesfully!"; }
}
}	
	else echo "Invalid parameters!";
	mysqli_close($db_handle);
?>
