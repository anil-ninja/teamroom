<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
if(!isset($_SESSION['user_id'])) {
	 echo "Please Log In First" ; 
}
else {
	if ($_POST['id']) {
		$user_id = $_SESSION['user_id'] ;
		$knownid = $_POST['id'];
		$pro_id = $_POST['project_id'] ;
		$sql = mysqli_query($db_handle,"SELECT * FROM user_info where user_id='$knownid' ;") ;
		$data = mysqli_fetch_array($sql) ;
		$emails = $data['email'] ;
		$mail = $data['username'] ;
		$case = $_POST['case'];
		$time = date("Y-m-d H:i:s") ;
		$username = $_SESSION['username'];
		$linkid = mysqli_query($db_handle, "select requesting_user_id from known_peoples where id='$knownid' and knowning_id='$user_id' ;") ;
		$linkidrow = mysqli_fetch_array($linkid) ;
		$uid = $linkidrow['requesting_user_id'] ;
		$ownerinfo = mysqli_query($db_handle,"select b.username, b.email, a.challenge_title, b.firat_name, b.last_name from challenges as a join user_info as b where a.challenge_id = '$knownid' and a.user_id = b.user_id ;") ;
		$ownerinforow = mysqli_fetch_array($ownerinfo) ;
		$owneremail = $ownerinforow['email'] ;
		$ownername = $ownerinforow['username'] ;
		$userFirst = $ownerinforow['first_name'] ;
		$userLast = $ownerinforow['last_name'] ;
		$challangeTtitle = $ownerinforow['challenge_title'] ;
		switch($case) {
			case 1:
				mysqli_query($db_handle, "INSERT INTO known_peoples (requesting_user_id, knowning_id, last_action_time) VALUES ('$user_id', '$knownid', '$time') ;") ;
				if(mysqli_error($db_handle)) { echo "Request Already Send"; }
				else { echo "Request send succesfully"; }
				if(!mysqli_error($db_handle)) {
					$body2 = "Hi, ".$mail." \n \n ".$username." Send Link to you. View at \n
http://collap.com/profile.php?username=".$mail ;
					collapMail($emails, " Link Received ", $body2);
				}
				events($db_handle,$user_id,"10",$knownid);
				involve_in($db_handle,$user_id,"10",$knownid);
				mysqli_close($db_handle);
				exit ;
				break ;
			case 2:
				events($db_handle,$user_id,"3",$knownid);
				involve_in($db_handle,$user_id,"3",$knownid);
				$body2 = "<h2>".ucfirst($challengeTtitle)."</h2><p>Hi ".ucfirst($userFirst)." ".ucfirst($userLast).",</p><p>One of the challanges posted by you on collap has been accepted.</p>
<p>".ucfirst($username)." has accepted your challenge ".$challengeTtitle."</p><table><tr><td class='padding'>
<p><a href='http://collap.com/challengesOpen.php?challenge_id=".$knownid."' class='btn-primary'>Click Here to View</a></p>" ;
				collapMail($owneremail, "Challenge Accepted ", $body2);
				mysqli_query($db_handle,"UPDATE challenges SET challenge_status='2', last_update='$time' WHERE challenge_id = '$knownid' ; ") ;
				mysqli_query($db_handle,"INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)
										VALUES ('$user_id', '$knownid', '1');") ;
				echo "Challenge Accepted succesfully";
				exit ;
				break ;
			case 3:
				events($db_handle,$user_id,"3",$knownid);
				involve_in($db_handle,$user_id,"3",$knownid);
				$mailid = mysqli_query($db_handle,"select b.email, b.firat_name, b.last_name from challenge_ownership as a join user_info as 
													b where a.challenge_id = '$knownid' and a.user_id = b.user_id ;") ;
				while ($mailidrow = mysqli_fetch_array($mailid)) {
					$ownerMail = $mailidrow['email'] ;
					$userFirstN = $mailidrow['first_name'] ;
					$userLastN = $mailidrow['last_name'] ;
					$body2 = "<h2>".ucfirst($challengeTtitle)."</h2><p>Hi ".ucfirst($userFirstN)." ".ucfirst($userLastN).",</p><p>A challange posted on collap in which you are involved has been closed.</p>
<p>".ucfirst($username)." has, accepted an answer and closed the Challange, ".$challengeTtitle."</p><table><tr><td class='padding'>
<p><a href='http://collap.com/challengesOpen.php?challenge_id=".$knownid."' class='btn-primary'>Click Here to View</a></p>" ;
					collapMail($ownerMail, "Close challenge ", $body2);
				}
				mysqli_query($db_handle,"UPDATE challenges SET challenge_status='5' WHERE challenge_id = '$knownid' ; ") ;
				echo "Challenge Closed succesfully";
				exit ;
				break ;
			case 4:
				events($db_handle,$user_id,"13",$knownid);
				involve_in($db_handle,$user_id,"13",$knownid);
				mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$user_id', '$knownid', 'defaultteam') ;") ;
				echo "Joined succesfully";
				exit ;
				break ;
			case 5:
				$member_project = mysqli_query($db_handle, "select * from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1' ;");
				if(mysqli_num_rows($member_project) != 0) {
					$username = $_SESSION['username'];
					$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
					$inforow = mysqli_fetch_array($info) ;
					$title = $inforow['project_title'] ;
					$type = $inforow['project_type'] ;
					$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where
														a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
					while ($memrow = mysqli_fetch_array($members)){
						$emails = $memrow['email'] ;
						$mail = $memrow['username'] ;
						$userFirstName = $memrow['first_name'] ;
						$userLastName = $memrow['last_name'] ;
						$body2 = "<h2>".ucfirst($challengeTtitle)."</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p><p>One of the challanges posted by you on collap has been accepted.</p>
<p>".ucfirst($username)." has accepted your challenge ".$challengeTtitle."</p><table><tr><td class='padding'>
<p><a href='http://collap.com/challengesOpen.php?challenge_id=".$knownid."' class='btn-primary'>Click Here to View</a></p>" ;
				collapMail($emails, "Challenge Accepted ", $body);
					} 
					events($db_handle,$user_id,"3",$knownid);
					involve_in($db_handle,$user_id,"3",$knownid);
					mysqli_query($db_handle,"UPDATE challenges SET challenge_status='2', last_update='$time' WHERE challenge_id = '$knownid' ; ") ;
					mysqli_query($db_handle,"INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)
											VALUES ('$user_id', '$knownid', '1');") ;
					echo "Challenge Accepted succesfully";
					}
					else {echo "Please Join Project First!"; }
				exit ;
				break ;
			case 6:
				$member_project = mysqli_query($db_handle, "select * from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1' ;");
				if(mysqli_num_rows($member_project) != 0) {
					$username = $_SESSION['username'];
					$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
					$inforow = mysqli_fetch_array($info) ;
					$title = $inforow['project_title'] ;
					$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where
														a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
					while ($memrow = mysqli_fetch_array($members)){
						$emails = $memrow['email'] ;
						$mail = $memrow['username'] ;
						$userFirstName = $memrow['first_name'] ;
						$userLastName = $memrow['last_name'] ;
						$body2 = "<h2>".ucfirst($challengeTtitle)."</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p><p>A challange posted on collap in which you are involved has been closed.</p>
<p>".ucfirst($username)." has, accepted an answer and closed the Challange, ".$challengeTtitle."</p><table><tr><td class='padding'>
<p><a href='http://collap.com/challengesOpen.php?challenge_id=".$knownid."' class='btn-primary'>Click Here to View</a></p>" ;
					collapMail($emails, "Close challenge ", $body2);
						} 
					events($db_handle,$user_id,"3",$knownid);
					involve_in($db_handle,$user_id,"3",$knownid);
					mysqli_query($db_handle,"UPDATE challenges SET challenge_status='5' WHERE challenge_id = '$knownid' ; ") ;
					echo "Challenge Closed succesfully";
					}
					else {echo "Please Join Project First!"; }
				exit ;
				break ;
			case 7:
				mysqli_query($db_handle, "update known_peoples set status='2', last_action_time='$time' where id='$knownid' and knowning_id='$user_id' ;") ;
				events($db_handle,$user_id,"18",$uid);
				if(mysqli_error($db_handle)) { echo "Sorry Try again!"; }
				else { echo "Request Accepted succesfully!"; }
				mysqli_close($db_handle);
				exit ;
				break ;
			case 8:
				mysqli_query($db_handle, "update known_peoples set status='3', last_action_time='$time' where id='$knownid' and knowning_id='$user_id' ;") ; 
				if(mysqli_error($db_handle)) { echo "Sorry Try again!" ; }
				else { echo "Request Deleted succesfully!"; }
				mysqli_close($db_handle);
				exit ;
				break ;
		}
	} 
	else { echo "Invalid parameters!"; }
}
mysqli_close($db_handle);
?>
