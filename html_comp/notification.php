<?php
	  $a = $_SESSION['last_login'] ;
	  $user_id = $_SESSION['user_id'] ;
	  $notice = "" ;
	  $y = 0 ;
	  $notice1 = mysqli_query($db_handle, " select Distinct a.user_id, a.reminder, a.time, b.first_name from reminders as a join user_info
											as b where a.person_id = '$user_id' and a.user_id = b.user_id;") ;
				while ($notice1row = mysqli_fetch_array($notice1)) {
					$reminders = $notice1row['reminder'] ;
					$ruser_id = $notice1row['user_id'] ;
					if ($ruser_id == $user_id) {
						$rname = "You" ;
						}
						else {
							$rname = $notice1row['first_name'] ;
							}
					$reminder_time = $notice1row['time'] ;
					$starttime = strtotime($reminder_time) ;
					$endtime = time() ;
					if ($endtime <= $starttime) {
						$timeleft = $starttime - $endtime ;
					}
						else {
							$timeleft = $starttime ;
							}
					if ($timeleft < 600 && $timeleft > 0) {
						$notice .= "<span class='glyphicon glyphicon-bullhorn'>&nbsp; ".$reminders. "</span><br/><p style='font-size: 10px;'>By : ".$rname."</p><hr/>";
						$y++ ;
						}
				}
		$notice2 = mysqli_query($db_handle, " SELECT id, event_creater, event_type, p_c_id FROM events WHERE
												p_c_id IN 
												(SELECT p_c_id  FROM involve_in WHERE user_id = '$user_id')
												 and timestamp > '$a' 
												 and event_creater != '$user_id' ;") ;
		while($notice2row = mysqli_fetch_array($notice2)) {
			$newid = $notice2row['id'] ;
			$creater = $notice2row['event_creater'] ;
			$type2 = $notice2row['event_type'] ;
			$search_id = $notice2row['p_c_id'] ;
		switch($type2){
			case 3:
			
			
			
			
			break;
			case 4:
			break;
			case 5:
			break;
			case 6:
			break;
			case 7:
			break;
			case 10:
			break;
			case 11:
			break;
			case 12:
			break;
			case 14:
			break;
			case 15:
			break;
		$notice3 = mysqli_query($db_handle, " select Distinct first_name, username from user_info where user_id = '$creater' ;") ;
			$notice3row = mysqli_fetch_array($notice3) ;
			$fname3 = $notice3row['first_name'] ;
			$uname3 = $notice3row['username'] ;
			
		$notice4 = mysqli_query($db_handle, " select  first_name, username from user_info where user_id = '$creater' ;") ;
			$notice3row = mysqli_fetch_array($notice3) ;
			$fname3 = $notice3row['first_name'] ;
			$uname3 = $notice3row['username'] ;
			
			}	
			else {
				
				
				}
			
			
			
			$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp; ".$fname2." Commented On </p><br/>
								<a href='challengesOpen.php?challenge_id=" . $challenge_id2 . "'>".$title2."</a><hr/>" ;
			$y++ ;
			}
	/*  $notice2 = mysqli_query($db_handle, " select Distinct c.first_name, b.challenge_id, d.challenge_title from challenge_ownership as a join response_challenge as b
											join user_info as c join challenges as d where b.response_ch_creation > '$a' and d.challenge_id = b.challenge_id 
											and (a.user_id = '$user_id' OR d.user_id = '$user_id') and b.user_id = c.user_id and b.user_id != '$user_id' ;") ;
		while($notice2row = mysqli_fetch_array($notice2)) {
			$fname2 = $notice2row['first_name'] ;
			$challenge_id2 = $notice2row['challenge_id'] ;
			$title2 = $notice2row['challenge_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp; ".$fname2." Commented On </p><br/>
								<a href='challengesOpen.php?challenge_id=" . $challenge_id2 . "'>".$title2."</a><hr/>" ;
			$y++ ;
			}									
	 $notice3 = mysqli_query($db_handle, " select Distinct c.first_name, b.project_id, d.project_title from teams as a join response_project as b
											join user_info as c join projects as d where b.response_pr_creation > '$a' and d.project_id = b.project_id 
											and (a.user_id = '$user_id' OR d.user_id = '$user_id') and b.user_id = c.user_id and b.user_id != '$user_id' ;") ;
		while($notice3row = mysqli_fetch_array($notice3)) {
			$fname3 = $notice3row['first_name'] ;
			$project_id3 = $notice3row['project_id'] ;
			$title3 = $notice3row['project_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-star-empty'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Commented On </p><br/>".$title3."<hr/>" ;
			$y++ ;
			}			
	$notice4 = mysqli_query($db_handle, " select Distinct c.first_name, d.challenge_id, d.challenge_title from challenge_ownership as a join spems as b
											join user_info as c join challenges as d where b.time > '$a' and d.challenge_id = b.spem_id and b.type = '1'
											and (a.user_id = '$user_id' OR d.user_id = '$user_id') and b.user_id = c.user_id and b.user_id != '$user_id' ;") ;
		while($notice4row = mysqli_fetch_array($notice4)) {
			$fname4 = $notice4row['first_name'] ;
			$challenge_id4 = $notice4row['challenge_id'] ;
			$title4 = $notice4row['challenge_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-eye-close'></span><p style='font-size: 10px;'> &nbsp; ".$fname3." Spammed </p><br/>".$title3."<hr/>" ;
			$y++ ;
			}	
	$notice5 = mysqli_query($db_handle, " select Distinct c.first_name, b.challenge_id, b.challenge_title from challenge_ownership as a  
											join challenges as b join user_info as c where a.ownership_creation > '$a' and b.challenge_id = a.challenge_id 
											and b.challenge_type != '5'	and b.user_id = '$user_id' and a.user_id = c.user_id and b.user_id != '$user_id' ;") ;
		while($notice5row = mysqli_fetch_array($notice5)) {
			$fname5 = $notice5row['first_name'] ;
			$challenge_id5 = $notice5row['challenge_id'] ;
			$title5 = $notice5row['challenge_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-fire'></span><p style='font-size: 10px;'> &nbsp; ".$fname5." Accepted </p><br/>
								<a href='challengesOpen.php?challenge_id=" . $challenge_id5 . "'>".$title5."</a><hr/>" ;
			$y++ ;
			}
	$notice6 = mysqli_query($db_handle, " select Distinct c.first_name, b.challenge_id, b.challenge_title from challenge_ownership as a  
											join challenges as b join user_info as c where a.time > '$a' and b.challenge_id = a.challenge_id and a.status = '2' 
											and b.user_id = '$user_id' and a.user_id = c.user_id and b.user_id != '$user_id' ;") ;
		while($notice6row = mysqli_fetch_array($notice6)) {
			$fname6 = $notice6row['first_name'] ;
			$challenge_id6 = $notice6row['challenge_id'] ;
			$title6 = $notice6row['challenge_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-ok'></span><p style='font-size: 10px;'> &nbsp; ".$fname6." Submitted </p><br/>
								<a href='challengesOpen.php?challenge_id=" . $challenge_id6 . "'>".$title6."</a><hr/>" ;
			$y++ ;
			}
	$notice7 = mysqli_query($db_handle, " select Distinct c.first_name, b.challenge_id, b.challenge_title from challenge_ownership as a  
											join challenges as b join user_info as c where a.time > '$a' and b.challenge_id = a.challenge_id and a.status = '2' 
											and a.user_id = '$user_id' and b.user_id = c.user_id and b.challenge_status = '5' and a.user_id != '$user_id' ;") ;
		while($notice7row = mysqli_fetch_array($notice7)) {
			$fname7 = $notice7row['first_name'] ;
			$challenge_id7 = $notice7row['challenge_id'] ;
			$title7 = $notice7row['challenge_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-flag'></span><p style='font-size: 10px;'> &nbsp; ".$fname7." Closed </p><br/>
								<a href='challengesOpen.php?challenge_id=" . $challenge_id7 . "'>".$title7."</a><hr/>" ;
			$y++ ;
			}	 					
	$notice8 = mysqli_query($db_handle, " select Distinct c.first_name, b.challenge_id, b.challenge_title from challenge_ownership as a  
											join challenges as b join user_info as c where a.time > '$a' and b.challenge_id = a.challenge_id and a.status = '1' 
											and a.user_id = '$user_id' and b.user_id = c.user_id ;") ;
		while($notice8row = mysqli_fetch_array($notice8)) {
			$fname8 = $notice8row['first_name'] ;
			$challenge_id8 = $notice8row['challenge_id'] ;
			$title8 = $notice8row['challenge_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-screenshot'></span><p style='font-size: 10px;'> &nbsp; ".$fname8." Assigned Task </p><br/>
								<a href='challengesOpen.php?challenge_id=" . $challenge_id8 . "'>".$title8."</a><hr/>" ;
			$y++ ;
			} */			
    $notice9 = mysqli_query($db_handle, " select Distinct b.first_name, a.project_id, a.project_title from projects as a join user_info as b
											where a.project_creation > '$a' and a.project_type = '1' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
		while($notice9row = mysqli_fetch_array($notice9)) {
			$fname9 = $notice9row['first_name'] ;
			$project_id9 = $notice9row['project_id'] ;
			$title9 = $notice9row['project_title'] ;
			$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; ".$fname9." Created </p><br/>".$title9."<hr/>" ;
			$y++ ;
			} 
	$notice10 = mysqli_query($db_handle, " select Distinct a.ownership_creation, a.comp_ch_ETA, b.challenge_id, b.challenge_title from challenge_ownership as a  
											join challenges as b where b.challenge_id = a.challenge_id and a.status = '1' 
											and a.user_id = '$user_id';") ;
		while($notice10row = mysqli_fetch_array($notice10)) {
			$comp_ch_ETA = strtotime($notice10row['comp_ch_ETA']*60) ;
			$ownership_creation = strtotime($notice10row['ownership_creation']) ;
			$challenge_id10 = $notice10row['challenge_id'] ;
			$title10 = $notice10row['challenge_title'] ;
			if (time() > ($comp_ch_ETA + $ownership_creation)) { 
					//$dead_time = "Closed" ;
					$y++ ;
					$notice = $notice ."<span class='glyphicon glyphicon-time'></span><p style='font-size: 10px;'> Remaining Time Over</p><br/>
										<a href='challengesOpen.php?challenge_id=" . $challenge_id10 . "'>".$title10."</a><hr/>" ;
				}
			else {	
					$remainingtime = (($comp_ch_ETA + $ownership_creation)-time()) ;
				if ($remainingtime < ((24*60*60)-1)) {	
						$hour = floor($remainingtime/(60*60)) ;
						$hoursec = $remainingtime%(60*60) ;
						$minute = floor($hoursec/60) ;
						$notice = $notice ."<span class='glyphicon glyphicon-time'></span><p style='font-size: 10px;'> &nbsp; Deadline Reached (Remaining Time)
											: ".$hour." Hours : ".$minute." Mins</p><br/><a href='challengesOpen.php?challenge_id=" . $challenge_id10 . "'>
											".$title10."</a><hr/>" ;
						$y++ ;
					} 
				}
			}
			echo "<div class='dropdown'>
					<a data-toggle='dropdown'>" ;
			if ($y == 0) {
				echo "<p class='navbar-text' style ='cursor: pointer;'>" ;
			}
			else {
				echo "<p class='navbar-text' style ='cursor: pointer; color: red;'>" ;
				}
				echo "<i class='glyphicon glyphicon-bell'></i><span class='badge'>".$y."</span></p></a>
						<ul class='dropdown-menu multi-level' style=' max-height: 300px; overflow: auto;'role='menu' aria-labelledby='dropdownMenu'>
							<li>".$notice."</li>
						</ul>
					</div>" ;			
?>
