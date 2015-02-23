<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if(!isset($_SESSION['user_id'])) { echo "Please Log In First" ; }
else {
if(isset($_POST['id'])){
	$user_id = $_SESSION['user_id'];
	$id = $_POST['id'];
	$pro_id = $_POST['project_id'];
	$case = $_POST['case'];	
	$time = date("Y-m-d H:i:s") ;
    if($case == 1){
		mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '1');") ;
		mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$id' ; ") ;
		events($db_handle,$user_id,"9",$id);
		involve_in($db_handle,$user_id,"9",$id);
		if(mysqli_error($db_handle)) { echo "Already Liked" ; }
		else { echo "Posted successfully"; }
	}
	else if($case == 2){
		mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '2');") ;
		mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$id' ; ") ;
		events($db_handle,$user_id,"9",$id);
		involve_in($db_handle,$user_id,"9",$id);
		if(mysqli_error($db_handle)) { echo "Already Disliked" ; }
		else { echo "Posted successfully"; }
	}
	else {
		$member_project = mysqli_query($db_handle, "select * from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1' ;");
		if(mysqli_num_rows($member_project) != 0) {
			$username = $_SESSION['username'];
			$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
			$inforow = mysqli_fetch_array($info) ;
			$title = $inforow['project_title'] ;
			$type = $inforow['project_type'] ;
			if($type == 2) {
				$chtype = mysqli_query($db_handle, "select * from challenges where challenge_id = '$id' and project_id = '$pro_id' ;") ;
				$chtyperow = mysqli_fetch_array($chtype) ;
				$chtyperowval = $chtyperow['challenge_type'] ;
				$challangeTtitle = $chtyperow['challenge_title'] ;
				if($chtyperowval == 1 || $chtyperowval == 2 || $chtyperowval == 3) { $challangeType = "Challenge" ; }
				else if($chtyperowval == 5) { $challangeType = "Task" ; }
				else if($chtyperowval == 6) { $challangeType = "Notes" ; }
				else if($chtyperowval == 9) { $challangeType = "Issues" ; }
				else { $challangeType = "Videos" ; }
				$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where
													a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
				while ($memrow = mysqli_fetch_array($members)){
					$emails = $memrow['email'] ;
					$mail = $memrow['username'] ;
					$userFirstName = $memrow['first_name'] ;
					$userLastName = $memrow['last_name'] ;
					$body2 = "<h2>Likes in project</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>You have a new like on your ".$challangeType.".</p>
<p>".ucfirst($username)." likes your ".$challangeType." ".$challangeTtitle." in the project ".ucfirst($title).".</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
					collapMail($emails, "Likes in project", $body2);
				} 
			}
			if($case == 3) {
				mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '1');") ;
				mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$id' ; ") ;
				events($db_handle,$user_id,"9",$id);
				involve_in($db_handle,$user_id,"9",$id);
				if(mysqli_error($db_handle)) { echo "Already Liked" ; }
				else { echo "Posted successfully"; }
			}
			else {
				mysqli_query($db_handle,"INSERT INTO likes (challenge_id, user_id, like_status) VALUES ('$id', '$user_id', '2');") ;
				mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$challenge_id' ; ") ;
				events($db_handle,$user_id,"9",$id);
				involve_in($db_handle,$user_id,"9",$id);
				if(mysqli_error($db_handle)) { echo "Already Disliked" ; }
				else { echo "Posted successfully"; }
			}
		}	
		else {echo "Please Join Project First!"; }
	}
} 
else { echo "Invalid parameters!"; }
}
mysqli_close($db_handle);
?>
