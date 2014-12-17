<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if($_POST['answer']){
		$user_id = $_SESSION['user_id'] ;
		$username = $_SESSION['username'];
		$pro_id = $_SESSION['project_id'] ;
		$ch_id = $_POST['cid'] ;
		$ownerinfo = mysqli_query($db_handle,"select b.username, b.email from challenges as a join user_info as b where a.challenge_id = '$ch_id' and a.user_id = b.user_id ;") ;
		$ownerinforow = mysqli_fetch_array($ownerinfo) ;
		$owneremail = $ownerinforow['email'] ;
		$ownername = $ownerinforow['username'] ;
		$case = $_POST['case'] ;
		$notestext = $_POST['answer'] ;
		$image = $_POST['img'] ;
		if (strlen($image) < 30 ) {
		$notes = $notestext ;
		}
		else {
			$notes = $image."<br/> ".$notestext ;
			}
		$a = date("Y-m-d H:i:s") ;
		if($case == 1) {
			involve_in($db_handle,$user_id,"5",$ch_id); 
			events($db_handle,$user_id,"5",$ch_id);
			$body2 = "Hi, ".$ownername." \n \n ".$username." Submitted Answer to your Challenge. View at \n \n http://collap.com/challengesOpen.php?challenge_id=".$ch_id ;
			collapMail($owneremail, " Answer Submitted", $body2);
			mysqli_query($db_handle,"UPDATE challenges SET challenge_status='4', last_update='$a' WHERE challenge_id = $ch_id ; ") ;
			mysqli_query($db_handle,"UPDATE challenge_ownership SET status='2', time='$a' WHERE challenge_id = $ch_id and user_id = '$user_id'; ") ;
			if (strlen($notes) < 1000) {
				mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, status) VALUES ('$user_id', '$ch_id', '$notes', '2'); ") ;
				if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
				else { echo "Posted succesfully!"; }
				}
				else {
					mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$notes');");        
					$id = mysqli_insert_id($db_handle);
					mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, blob_id, stmt, status) VALUES ('$user_id', '$ch_id', '$id', ' ', '2');");
					if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
					else { echo "Posted succesfully!"; }
				}
			}
			else {
				$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1' ;");
				if(mysqli_num_rows($member_project) != 0) {
					$username = $_SESSION['username'];
					$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
					$inforow = mysqli_fetch_array($info) ;
					$title = $inforow['project_title'] ;
					$type = $inforow['project_type'] ;
					$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where 
														a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
					while ($memrow = mysqli_fetch_array($members)){
						$emails = $memrow['email'] ;
						$mail = $memrow['username'] ;
						$body2 = "Hi, ".$mail." \n \n ".$username." Submitted Answer http://collap.com/challengesOpen.php?challenge_id=".$ch_id."  \n \n IN Project (".$title."). View at \n
http://collap.com/project.php?project_id=".$pro_id ;
						collapMail($emails, " Answer Submitted", $body2);
						} 
					involve_in($db_handle,$user_id,"5",$ch_id); 
					events($db_handle,$user_id,"5",$ch_id);
					mysqli_query($db_handle,"UPDATE challenges SET challenge_status='4', last_update='$a' WHERE challenge_id = $ch_id ; ") ;
					mysqli_query($db_handle,"UPDATE challenge_ownership SET status='2', time='$a' WHERE challenge_id = $ch_id and user_id = '$user_id'; ") ;
					if (strlen($notes) < 1000) {
						mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, status) VALUES ('$user_id', '$ch_id', '$notes', '2'); ") ;
						if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
						else { echo "Posted succesfully!"; }
						}
						else {
							mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$notes');");        
							$id = mysqli_insert_id($db_handle);
							mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, blob_id, stmt, status) VALUES ('$user_id', '$ch_id', '$id', ' ', '2');");
							if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
							else { echo "Posted succesfully!"; }
						}
					}
					else {echo "Please Join Project First!"; }
			}
	mysqli_close($db_handle);
}	
else echo "Invalid parameters!";
?>
