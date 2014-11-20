<?php 
session_start();
include_once "../lib/db_connect.php";
 function update($id,$db_handle) {
		mysqli_query($db_handle, " UPDATE notifications SET status = '1' WHERE user_id = '$id' ;") ;
		}
if ($_POST['all']) {
    $user_id = $_SESSION['user_id'];
    $notice = "" ;
	  $notice1 = mysqli_query($db_handle, " select Distinct a.user_id, a.reminder, a.time, b.first_name from reminders as a join user_info
											as b where a.person_id = '$id' and a.user_id = b.user_id;") ;
				while ($notice1row = mysqli_fetch_array($notice1)) {
					$reminders = $notice1row['reminder'] ;
					$ruser_id = $notice1row['user_id'] ;
					if ($ruser_id == $user_id) {
						$rname = "You" ;
						}
						else {
							$rname = $notice1row['first_name'] ;
							}
					$notice .= "<span class='glyphicon glyphicon-bullhorn'>&nbsp; ".$reminders. "</span><br/><p style='font-size: 10px;'>By : ".$rname."</p><hr/>";
					}
		$notice2 = mysqli_query($db_handle, " SELECT id, event_creater, event_type, p_c_id FROM events WHERE
												p_c_id IN 
												(SELECT p_c_id  FROM involve_in WHERE user_id = '$user_id')
												 and event_creater != '$user_id' ;") ;
		while($notice2row = mysqli_fetch_array($notice2)) {
			$newid = $notice2row['id'] ;
			$creater = $notice2row['event_creater'] ;
			$type2 = $notice2row['event_type'] ;
			$search_id = $notice2row['p_c_id'] ;
		$notice3 = mysqli_query($db_handle, " select Distinct first_name, username from user_info where user_id = '$creater' ;") ;
			$notice3row = mysqli_fetch_array($notice3) ;
			$fname3 = $notice3row['first_name'] ;
			$uname3 = $notice3row['username'] ;
		
		switch($type2){
			case 3:
		$notice4 = mysqli_query($db_handle, " select challenge_id, challenge_title from challenges where challenge_id = '$search_id';") ;
		
			while ($notice4row = mysqli_fetch_array($notice4)) {
				$challenge_id4 = $notice4row['challenge_id'] ;
				$challenge_title4 = $notice4row['challenge_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Commented On </p><br/>
									<a href='challengesOpen.php?challenge_id=" . $challenge_id4 . "'>".$challenge_title4."</a><hr/>" ;
				}
			
			break;
			
			case 4:
		$notice5 = mysqli_query($db_handle, " select Distinct challenge_id, challenge_title from challenges where challenge_id = '$search_id';") ;
		
			while ($notice5row = mysqli_fetch_array($notice5)) {
				$challenge_id5 = $notice5row['challenge_id'] ;
				$challenge_title5 = $notice5row['challenge_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-fire'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Accepted </p><br/>
									<a href='challengesOpen.php?challenge_id=" . $challenge_id5 . "' >".$challenge_title5."</a><hr/>" ;
				}
			
			break;
			
			case 5:
		$notice6 = mysqli_query($db_handle, " select Distinct challenge_id, challenge_title from challenges where challenge_id = '$search_id';") ;
		
			while ($notice6row = mysqli_fetch_array($notice6)) {
				$challenge_id6 = $notice6row['challenge_id'] ;
				$challenge_title6 = $notice6row['challenge_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-ok'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Submitted </p><br/>
									<a href='challengesOpen.php?challenge_id=" . $challenge_id6 . "' >".$challenge_title6."</a><hr/>" ;
				}

			break;
			
			case 6:
		$notice7 = mysqli_query($db_handle, " select Distinct challenge_id, challenge_title from challenges where challenge_id = '$search_id';") ;
		
			while ($notice7row = mysqli_fetch_array($notice7)) {
				$challenge_id7 = $notice7row['challenge_id'] ;
				$challenge_title7 = $notice7row['challenge_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-flag'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Closed </p><br/>
									<a href='challengesOpen.php?challenge_id=" . $challenge_id7 . "' >".$challenge_title7."</a><hr/>" ;
				}
			
			break;
		
			case 7:
		$notice8 = mysqli_query($db_handle, " select Distinct challenge_id, challenge_title from challenges where challenge_id = '$search_id';") ;
		
			while ($notice8row = mysqli_fetch_array($notice8)) {
				$challenge_id8 = $notice8row['challenge_id'] ;
				$challenge_title8 = $notice8row['challenge_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-eye-close'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Spemmed </p><br/>
									<a href='challengesOpen.php?challenge_id=" . $challenge_id8 . "'>".$challenge_title8."</a><hr/>" ;
				}
		
			break;
		
			case 10:
		$notice9 = mysqli_query($db_handle, " select Distinct challenge_id, challenge_title from challenges where challenge_id = '$search_id';") ;
		
			while ($notice9row = mysqli_fetch_array($notice9)) {
				$challenge_id9 = $notice9row['challenge_id'] ;
				$challenge_title9 = $notice9row['challenge_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Created </p><br/>
									<a href='challengesOpen.php?challenge_id=" . $challenge_id9 . "'>".$challenge_title9."</a><hr/>" ;
				}
		
			break;
			
			case 11:
		$notice10 = mysqli_query($db_handle, " select Distinct a.project_id, a.project_title, b.team_name from projects as a join teams as b where
												a.project_id = '$search_id' and b.project_id = '$search_id' ;") ;
			while ($notice10row = mysqli_fetch_array($notice10)) {
				$challenge_id10 = $notice10row['project_id'] ;
				$team_name = $notice10row['team_name'] ;
				$challenge_title10 = $notice10row['project_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-phone-alt'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Created Team ".$team_name." in </p><br/>
									<a href='project.php?project_id=" . $challenge_id10 . "'>".$challenge_title10."</a><hr/>" ;
				}
			
			break;
			
			case 13:
		$notice17 = mysqli_query($db_handle, " select project_id, project_title from projects where project_id = '$search_id';") ;
			while ($notice17row = mysqli_fetch_array($notice17)) {
				$challenge_id17 = $notice17row['project_id'] ;
				$challenge_title17 = $notice17row['project_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-phone-alt'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Joined in </p><br/>
									<a href='project.php?project_id=" . $challenge_id17 . "' >".$challenge_title17."</a><hr/>" ;
				}
			
			break;
		
			case 15:
		$notice14 = mysqli_query($db_handle, " select Distinct a.project_id, a.project_title, b.team_name from projects as a join teams as b where
												a.project_id = '$search_id' and b.project_id = '$search_id';") ;
		
			while ($notice14row = mysqli_fetch_array($notice14)) {
				$challenge_id14 = $notice14row['project_id'] ;
				$team_name2 = $notice11row['team_name'] ;
				$challenge_title14 = $notice14row['project_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Add member in ".$team_name2." in </p>
									<a href='project.php?project_id=" . $challenge_id14 . "'>".$challenge_title14."</a><hr/>" ;
				}
		
			break;
			
			case 14:
		$notice11 = mysqli_query($db_handle, " select Distinct project_id, project_title from projects where project_id = '$search_id';") ;
		
			while ($notice11row = mysqli_fetch_array($notice11)) {
				$challenge_id11 = $notice11row['project_id'] ;
				$challenge_title11 = $notice11row['project_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Commented On </p><br/>
										<a href='project.php?project_id=" . $challenge_id11 . "'>".$challenge_title11."</a><hr/>" ;
				}
		
			break;
		
			case 12:
		$notice12 = mysqli_query($db_handle, " select Distinct challenge_id, challenge_title from challenges where challenge_id = '$search_id';") ;
		
			while ($notice12row = mysqli_fetch_array($notice12)) {
				$challenge_id12 = $notice12row['challenge_id'] ;
				$challenge_title12 = $notice12row['challenge_title'] ;	
				$notice = $notice ."<span class='glyphicon glyphicon-screenshot'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Assigned Task </p><br/>
									<a href='challengesOpen.php?challenge_id=" . $challenge_id12 . "'>".$challenge_title12."</a><hr/>" ;
				}
		
			break;		
			}
		}
	$notice15 = mysqli_query($db_handle, " select Distinct b.first_name, a.project_id, a.project_title from projects as a join user_info as b
											where a.project_type = '1' and a.user_id != '$id' and a.user_id = b.user_id ;") ;
		while($notice15row = mysqli_fetch_array($notice15)) {
			$fname5 = $notice15row['first_name'] ;
			$project_id15 = $notice15row['project_id'] ;
			$title15 = $notice15row['project_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; ".$fname5." Created </p><br/>
								<a href='challengesOpen.php?challenge_id=" . $project_id15 . "'>".$title15."</a><hr/>" ;
			}
	$notice18 = mysqli_query($db_handle, " SELECT a.id, a.requesting_user_id, b.first_name, b.username FROM known_peoples as a join user_info as b
											where a.status = '1' and a.knowning_id = '$id' and a.requesting_user_id = b.user_id ;") ;
		while($notice18row = mysqli_fetch_array($notice18)) {
			$fname18 = $notice18row['first_name'] ;
			$id1 = $notice18row['id'] ;
			
			$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; ".$fname18." Send Friend Request </p><hr/>" ;
			}
	$notice20 = mysqli_query($db_handle, " SELECT a.id, a.knowning_id, b.first_name, b.username FROM known_peoples as a join user_info as b
											where and a.status = '2' and a.requesting_user_id = '$id' and a.knowning_id = b.user_id ;") ;
		while($notice20row = mysqli_fetch_array($notice20)) {
			$fname20 = $notice20row['first_name'] ;
			$id2 = $notice20row['id'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; ".$fname20." Accepted Your Friend Request </p><hr/>" ;
			}
	$notice19 = mysqli_query($db_handle, " SELECT a.id, a.knowning_id, b.first_name, b.username FROM known_peoples as a join user_info as b
											where and a.status = '3' and a.requesting_user_id = '$id' and a.knowning_id = b.user_id ;") ;
		while($notice19row = mysqli_fetch_array($notice19)) {
			$fname19 = $notice19row['first_name'] ;
			$id3 = $notice19row['id'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; ".$fname19." Deleted Your Friend Request </p><hr/>" ;
			} 
echo $notice ;
}
else {
	echo "invalid" ;
	}
						
?>
