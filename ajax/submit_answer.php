<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if($_POST['answer']){
	$user_id = $_SESSION['user_id'] ;
	$username = $_SESSION['username'];
	$pro_id = $_POST['project_id'] ;
	$ch_id = $_POST['cid'] ;
	$ownerinfo = mysqli_query($db_handle,"select b.username, b.email, a.challenge_title, b.firat_name, b.last_name from challenges as a join user_info as b where a.challenge_id = '$ch_id' and a.user_id = b.user_id ;") ;
	$ownerinforow = mysqli_fetch_array($ownerinfo) ;
	$owneremail = $ownerinforow['email'] ;
	$ownername = $ownerinforow['username'] ;
	$userFirst = $ownerinforow['first_name'] ;
	$userLast = $ownerinforow['last_name'] ;
	$challangeTtitle = $ownerinforow['challenge_title'] ;
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
		involve_in($db_handle,$user_id,"3",$ch_id); 
		events($db_handle,$user_id,"3",$ch_id);
		$body2 = "<h2>".$challengeTtitle."</h2><p>Hi ".$userFirst." ".$userLast.",</p><p>Answer to a challange posted on collap in which you are involved has been submitted.</p>
<p>".$username." has submitted a answer to the Challange, ".$challengeTtitle."</p><table><tr><td class='padding'>
<p><a href='http://collap.com/challengesOpen.php?challenge_id=".$ch_id."' class='btn-primary'>Click Here to View the answer</a></p>" ;
		collapMail($owneremail, "Challenge Accepted ", $body2);
		mysqli_query($db_handle,"UPDATE challenges SET challenge_status='4', last_update='$a' WHERE challenge_id = $ch_id ; ") ;
		mysqli_query($db_handle,"UPDATE challenge_ownership SET status='2', time='$a' WHERE challenge_id = $ch_id and user_id = '$user_id'; ") ;
		if (strlen($notes) < 1000) {
			mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, status) VALUES ('$user_id', '$ch_id', '$notes', '2'); ") ;
			if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
			else { echo "Answer Submitted succesfully!"; }
		}
		else {
			mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$notes');");        
			$id = mysqli_insert_id($db_handle);
			mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, blob_id, stmt, status) VALUES ('$user_id', '$ch_id', '$id', ' ', '2');");
			if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
			else { echo "Answer Submitted succesfully!"; }
		}
	}
	else {
		$username = $_SESSION['username'];
		$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
		$inforow = mysqli_fetch_array($info) ;
		$title = $inforow['project_title'] ;
		$type = $inforow['project_type'] ;
		$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.firat_name, b.last_name from teams as a join user_info as b where 
											a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
		while ($memrow = mysqli_fetch_array($members)){
			$emails = $memrow['email'] ;
			$mail = $memrow['username'] ;
			$userFirstName = $memrow['first_name'] ;
			$userLastName = $memrow['last_name'] ;
			$body2 = "<h2>".$challengeTtitle."</h2><p>Hi ".$userFirstName." ".$userLastName.",</p><p>Answer to a challange posted on collap in which you are involved has been submitted.</p>
<p>".$username." has submitted a answer to the Challange, ".$challengeTtitle."</p><table><tr><td class='padding'>
<p><a href='http://collap.com/challengesOpen.php?challenge_id=".$ch_id."' class='btn-primary'>Click Here to View the answer</a></p>" ;
			collapMail($emails, "Challenge Accepted ", $body2);
		} 
		involve_in($db_handle,$user_id,"3",$ch_id); 
		events($db_handle,$user_id,"3",$ch_id);
		mysqli_query($db_handle,"UPDATE challenges SET challenge_status='4', last_update='$a' WHERE challenge_id = $ch_id ; ") ;
		mysqli_query($db_handle,"UPDATE challenge_ownership SET status='2', time='$a' WHERE challenge_id = $ch_id and user_id = '$user_id'; ") ;
		if (strlen($notes) < 1000) {
			mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, status) VALUES ('$user_id', '$ch_id', '$notes', '2'); ") ;
			if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
			else { echo "Answer Submitted succesfully!"; }
		}
		else {
			mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$notes');");        
			$id = mysqli_insert_id($db_handle);
			mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, blob_id, stmt, status) VALUES ('$user_id', '$ch_id', '$id', ' ', '2');");
			if(mysqli_error($db_handle)) { echo "Failed to Post Answer!"; }
			else { echo "Answer Submitted succesfully!"; }
		}
	}
}	
else { echo "Invalid parameters!"; }
mysqli_close($db_handle);
?>
