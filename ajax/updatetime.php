<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['update']){
	$user_id = $_SESSION['user_id'];
	$a = date("Y-m-d H:i:s") ;
	$_SESSION['last_login'] = $a ;
	$case = $_POST['case'] ;
	if($case == 2) {
		mysqli_query($db_handle, " UPDATE user_info SET last_login = '$a' WHERE user_id = '$user_id' ;") ;
		}
		else {
			mysqli_query($db_handle, " UPDATE user_info SET last_login = '$a' WHERE user_id = '$user_id' ;") ;
	$notice = "" ;
	$data = "" ;
	$data1 = "" ;
	$y = 0 ;
	$notice27 = mysqli_query($db_handle, "select Distinct b.first_name, b.username, a.project_id, a.project_title from projects as a join user_info as b
											where a.creation_time > '$a' and a.project_type = '1' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
		while($notice27row = mysqli_fetch_array($notice27)) {
			$fname25 = $notice27row['first_name'] ;
			$project_id25 = $notice27row['project_id'] ;
			$title25 = $notice27row['project_title'] ;
			$uname25 = $notice27row['username'] ;
			$notice .= "<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname25."'>
									".$fname25."</a> Created </p><br/>".$title25."<hr/>" ;
			$y++ ;
			}
	$notice1 = mysqli_query($db_handle, "(SELECT id, event_creater, event_type, p_c_id, timestamp FROM events WHERE p_c_id IN (SELECT p_c_id  FROM involve_in WHERE
										 user_id = '$user_id') and timestamp > '$a' and event_creater != '$user_id' )
										 UNION
										 (SELECT id, event_creater, event_type, p_c_id, timestamp FROM events WHERE event_type IN ( 8, 12, 18, 19, 20, 21, 22, 23, 24, 25, 28, 29, 30, 36, 37 ) 
										 and p_c_id = '$user_id' and event_creater != '$user_id') order by timestamp DESC;") ;
	while($notice1row = mysqli_fetch_array($notice1)) {
		$eventid = $notice1row['id'] ;
		$creater = $notice1row['event_creater'] ;
		$type = $notice1row['event_type'] ;
		$search_id = $notice1row['p_c_id'] ;
		$eventtime = date("j F, g:i a", strtotime($notice1row['timestamp'])) ;
		$notice2 = mysqli_query($db_handle, " select first_name, username from user_info where user_id = '$creater' ;") ;
		$notice2row = mysqli_fetch_array($notice2) ;
		$fname = $notice2row['first_name'] ;
		$uname = $notice2row['username'] ;
	
		switch($type){
			case 3:
				$notice3 = mysqli_query($db_handle, " select challenge_id, project_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice3row = mysqli_fetch_array($notice3)) {
					$challenge_id = $notice3row['challenge_id'] ;
					$pro_id = $notice3row['project_id'] ;
					$challenge_title = $notice3row['challenge_title'] ;
					if($pro_id == 0) {	
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Commented On </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
					else {
						$projectinfo = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id';") ;
						$projectinforow = mysqli_fetch_array($projectinfo) ;
						$project_title = $projectinforow['project_title'] ;
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Commented In </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$pro_id."' target='_blank'>".$project_title."
											</a><br/> On <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
				}
				
				break;
			
			case 4:
				$notice4 = mysqli_query($db_handle, " select challenge_id, project_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice4row = mysqli_fetch_array($notice4)) {
					$challenge_id2 = $notice4row['challenge_id'] ;
					$pro_id2 = $notice4row['project_id'] ;
					$challenge_title2 = $notice4row['challenge_title'] ;
					if($pro_id2 == 0) {	
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Accepted Challenge </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id2."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title2."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
					else {
						$projectinfo2 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id2';") ;
						$projectinforow2 = mysqli_fetch_array($projectinfo2) ;
						$project_title2 = $projectinforow2['project_title'] ;
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Accepted Challenge In </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$pro_id2."' target='_blank'>".$project_title2."
											</a><br/><a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id2."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title2."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
				}
				
				break;
			
			case 5:
				$notice5 = mysqli_query($db_handle, " select challenge_id, project_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice5row = mysqli_fetch_array($notice5)) {
					$challenge_id3 = $notice5row['challenge_id'] ;
					$pro_id3 = $notice5row['project_id'] ;
					$challenge_title3 = $notice5row['challenge_title'] ;
					if($pro_id3 == 0) {	
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Submit Answer of </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id3."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title3."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
					else {
						$projectinfo3 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id3';") ;
						$projectinforow3 = mysqli_fetch_array($projectinfo3) ;
						$project_title3 = $projectinforow3['project_title'] ;
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Submit Answer In </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$pro_id3."' target='_blank'>".$project_title3."
											</a><br/> of <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id3."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title3."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
				}
				
				break;
			
			case 6:
				$notice6 = mysqli_query($db_handle, " select challenge_id, project_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice6row = mysqli_fetch_array($notice6)) {
					$challenge_id4 = $notice6row['challenge_id'] ;
					$pro_id4 = $notice6row['project_id'] ;
					$challenge_title4 = $notice6row['challenge_title'] ;
					if($pro_id4 == 0) {	
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Closed Challenge </p><br/>
											<a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id4."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title4."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
					else {
						$projectinfo4 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id4';") ;
						$projectinforow4 = mysqli_fetch_array($projectinfo4) ;
						$project_title4 = $projectinforow4['project_title'] ;
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Closed Challenge In </p><br/>
											<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id4."' target='_blank'>".$project_title4."
											</a><br/><a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id4."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title4."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
				}
				
				break;
		
			case 7:
				$notice7 = mysqli_query($db_handle, " select challenge_id, project_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice7row = mysqli_fetch_array($notice7)) {
					$challenge_id5 = $notice7row['challenge_id'] ;
					$pro_id5 = $notice7row['project_id'] ;
					$challenge_title5 = $notice7row['challenge_title'] ;
					$projectinfo5 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id5';") ;
					$projectinforow5 = mysqli_fetch_array($projectinfo5) ;
					$project_title5 = $projectinforow5['project_title'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
										<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Spammed Challenge In </p><br/>
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id5."' target='_blank'>".$project_title5."
										</a><br/><a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id5."' target='_blank'
										onclick=".update($user_id,$db_handle).">".$challenge_title5."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
		
			case 8:
				$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
									<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
									".$fname."</a>&nbsp; Updated His Profile </p><br/> on  ".$eventtime."<hr/>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
			
			case 10:
				$notice8 = mysqli_query($db_handle, " select challenge_id, project_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice8row = mysqli_fetch_array($notice8)) {
					$challenge_id6 = $notice8row['challenge_id'] ;
					$pro_id6 = $notice8row['project_id'] ;
					$challenge_title6 = $notice8row['challenge_title'] ;
					$projectinfo6 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id6';") ;
					$projectinforow6 = mysqli_fetch_array($projectinfo6) ;
					$project_title6 = $projectinforow6['project_title'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
										<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Created Challenge In </p><br/>
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id6."' target='_blank'>".$project_title6."
										</a><br/><a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id6."' target='_blank'
										onclick=".update($user_id,$db_handle).">".$challenge_title6."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
			
			case 11:
				$notice9 = mysqli_query($db_handle, "select Distinct a.project_id, a.project_title, b.team_name from projects as a join teams as b where
													a.project_id = '$search_id' and b.project_id = '$search_id' and b.team_creation > '$a';") ;
				while ($notice9row = mysqli_fetch_array($notice9)) {
					$pro_id7 = $notice9row['project_id'] ;
					$team_name = $notice9row['team_name'] ;
					$project_title7 = $notice9row['project_title'] ;	
					$notice = $notice ."<span class='glyphicon glyphicon-phone-alt' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'><a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp;
										Created Team ".$team_name." in </p><br/>
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id7."' 
										target='_blank'>".$project_title7."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;

			case 12:
				$notice10 = mysqli_query($db_handle, "select a.challenge_id, a.project_id, a.challenge_title from challenges as a join challenge_ownership as b
													  where a.user_id = '$creater' and b.user_id = '$user_id and a.challenge_type = '5' and a.challenge_status = '2'
													  and a.creation_time > '$a' and a.challenge_id = b.challenge_id ;") ;
				while ($notice10row = mysqli_fetch_array($notice10)) {
					$challenge_id8 = $notice10row['challenge_id'] ;
					$pro_id8 = $notice10row['project_id'] ;
					$challenge_title8 = $notice10row['challenge_title'] ;
					$projectinfo8 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id8';") ;
					$projectinforow8 = mysqli_fetch_array($projectinfo8) ;
					$project_title8 = $projectinforow8['project_title'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
										<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Assigned Task </p><br/>
										<a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id8."' target='_blank'
										onclick=".update($user_id,$db_handle).">".$challenge_title8."</a><br/> In 
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id8."' target='_blank'>".$project_title8."
										</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
			
				break;		
					
			case 13:
				$notice11 = mysqli_query($db_handle, " select project_id, project_title from projects where project_id = '$search_id';") ;
				while ($notice11row = mysqli_fetch_array($notice11)) {
					$pro_id9 = $notice11row['project_id'] ;
					$project_title9 = $notice11row['project_title'] ;	
					$notice = $notice ."<span class='glyphicon glyphicon-phone-alt' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'><a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp;
										Jioned in </p><br/><a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id9."' 
										target='_blank'>".$project_title9."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
			
			case 14:
				$notice12 = mysqli_query($db_handle, " select project_id, project_title from projects where project_id = '$search_id';") ;
				while ($notice12row = mysqli_fetch_array($notice12)) {
					$pro_id10 = $notice12row['project_id'] ;
					$project_title10 = $notice12row['project_title'] ;	
					$notice = $notice ."<span class='glyphicon glyphicon-phone-alt' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'><a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp;
										Commented On </p><br/><a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id10."' 
										target='_blank'>".$project_title10."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
		
				break;
			
			case 15:
				$notice13 = mysqli_query($db_handle, "select a.project_id, a.project_title, b.team_name from projects as a join teams as b where
													 a.project_id = '$search_id' and b.project_id = '$search_id' and b.team_creation > '$a';") ;		
				while ($notice13row = mysqli_fetch_array($notice13)) {
					$pro_id11 = $notice13row['project_id'] ;
					$team_name2 = $notice13row['team_name'] ;
					$project_title11 = $notice13row['project_title'] ;	
					$notice = $notice ."<span class='glyphicon glyphicon-plus' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'><a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp;
										Add member in Team <a class='btn-link' style='color:#3B6998;' 
										href='teams.php?project_id=".$pro_id11."&team_name=".$team_name."' target='_blank'>".$team_name."</a> in </p><br/>
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id11."' 
										target='_blank'>".$project_title11."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
			
				break;
			
			case 16:
				$notice14 = mysqli_query($db_handle, " select challenge_id, project_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice14row = mysqli_fetch_array($notice14)) {
					$challenge_id12 = $notice14row['challenge_id'] ;
					$pro_id12 = $notice14row['project_id'] ;
					$challenge_title12 = $notice14row['challenge_title'] ;
					if($pro_id12 == 0) {	
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Likes </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id12."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title12."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
					else {
						$projectinfo12 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id12';") ;
						$projectinforow12 = mysqli_fetch_array($projectinfo12) ;
						$project_title12 = $projectinforow12['project_title'] ;
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Likes </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id12."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title12."</a><br/> In 
											<a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$pro_id12."' target='_blank'>".$project_title12."
											</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
				}
				
				break;
				
			case 17:
				$notice15 = mysqli_query($db_handle, " select challenge_id, project_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice15row = mysqli_fetch_array($notice15)) {
					$challenge_id13 = $notice15row['challenge_id'] ;
					$pro_id13 = $notice15row['project_id'] ;
					$challenge_title13 = $notice15row['challenge_title'] ;
					if($pro_id13 == 0) {	
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Dislike </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id13."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title13."</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
					else {
						$projectinfo13 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id13';") ;
						$projectinforow13 = mysqli_fetch_array($projectinfo13) ;
						$project_title13 = $projectinforow13['project_title'] ;
						$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
											<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Dislike </p><br/>
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id13."' target='_blank'
											onclick=".update($user_id,$db_handle).">".$challenge_title13."</a><br/> In 
											<a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$pro_id13."' target='_blank'>".$project_title13."
											</a><br/> on  ".$eventtime."<hr/>" ;
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
				}
				
				break;
				
			case 18:
				$notice16 = mysqli_query($db_handle, " select * from user_info where user_id = '$creater';") ;
				while ($notice16row = mysqli_fetch_array($notice16)) {
					$rank = $notice16row['rank'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
										".$fname."</a>&nbsp; Updated His Rank to ".$rank ." </p><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
				
			case 19:
				$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
									<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
									".$fname."</a>&nbsp; Updated His First name </p><br/> on  ".$eventtime."<hr/>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 20:
				$notice17 = mysqli_query($db_handle, " select * from user_info where user_id = '$creater';") ;
				while ($notice17row = mysqli_fetch_array($notice17)) {
					$lname = $notice17row['last_name'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
										".$fname."</a>&nbsp; Updated His Last Name to ".$lname ." </p><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
				
			case 21:
				$notice18 = mysqli_query($db_handle, " select * from user_info where user_id = '$creater';") ;
				while ($notice18row = mysqli_fetch_array($notice18)) {
					$phone = $notice18row['contact_no'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
										".$fname."</a>&nbsp; Updated His Phome No. to ".$phone ." </p><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
				
			case 22:
				$notice19 = mysqli_query($db_handle, " select * from about_users where user_id = '$creater';") ;
				while ($notice19row = mysqli_fetch_array($notice19)) {
					$org = $notice19row['organisation_name'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
										".$fname."</a>&nbsp; Changed His Organisation to ".$org." </p><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
				
			case 23:
				$notice20 = mysqli_query($db_handle, " select * from about_users where user_id = '$creater';") ;
				while ($notice20row = mysqli_fetch_array($notice20)) {
					$town = $notice20row['living_town'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
										".$fname."</a>&nbsp; Changed His Town to ".$town." </p><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
				
			case 24:
				$notice21 = mysqli_query($db_handle, " select * from about_users where user_id = '$creater';") ;
				while ($notice21row = mysqli_fetch_array($notice21)) {
					$about = $notice21row['about_user'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
										".$fname."</a>&nbsp; Changed His Information<br/> ".$about." </p><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
				
			case 25:
				$notice = $notice ."<span class='glyphicon glyphicon-star' onclick=".update($user_id,$db_handle)."></span>
									<p style='font-size: 10px;'> &nbsp;<a href ='profile.php?username=".$uname."'>
									".$fname."</a>&nbsp; Updated His Profile Picture </p><br/> on  ".$eventtime."<hr/>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 28:
				$notice22 = mysqli_query($db_handle, " SELECT * FROM known_peoples where last_action_time > '$a' and status = '1' and knowning_id = '$user_id' and requesting_user_id = '$creater' ;") ;
				while($notice22row = mysqli_fetch_array($notice22)) {
					$id1 = $notice22row['id'] ;
					$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; 
										<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Send Link </p><br/> on  ".$eventtime."<br/>
										<input type='submit' class='btn-link inline-form' onclick='requestaccept(\"".$id1."\")' value='Accept'/>
										<input type='submit' class='btn-link inline-form' onclick='requestdelete(\"".$id1."\")' value='Delete'/><hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
				
			case 29:
				$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; 
									<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Accepted Link </p><br/> on  ".$eventtime."<hr/>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 30:
				$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; 
									<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Deleted Link </p><br/> on  ".$eventtime."<hr/>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 31:
				$notice23 = mysqli_query($db_handle, " select project_id, project_title from projects where project_id = '$search_id';") ;
				while ($notice23row = mysqli_fetch_array($notice23)) {
					$pro_id21 = $notice23row['project_id'] ;
					$project_title21 = $notice23row['project_title'] ;	
					$notice = $notice ."<span class='glyphicon glyphicon-phone-alt' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'><a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp;
										Masseged In </p><br/><a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id21."' 
										target='_blank'>".$project_title21."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
		
				break;
				
			case 33:
				$notice24 = mysqli_query($db_handle, " select project_id, project_title from projects where project_id = '$search_id';") ;
				while ($notice24row = mysqli_fetch_array($notice24)) {
					$pro_id22 = $notice24row['project_id'] ;
					$project_title22 = $notice24row['project_title'] ;	
					$notice = $notice ."<span class='glyphicon glyphicon-phone-alt' onclick=".update($user_id,$db_handle)."></span>
										<p style='font-size: 10px;'><a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp;
										Edited Project </p><br/><a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id22."' 
										target='_blank'>".$project_title22."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
		
				break;
				
			case 36:
				$notice = $notice ."<span class='glyphicon glyphicon-plus'></span><p style='font-size: 10px;'> &nbsp; 
									<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Added Skills to his profile </p><br/> on  ".$eventtime."<hr/>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 37:
				$notice25 = mysqli_query($db_handle, "select Distinct a.user_id, a.reminder, a.time, b.first_name from reminders as a join user_info
													  as b where a.person_id = '$user_id' and a.user_id = b.user_id;") ;
				while ($notice25row = mysqli_fetch_array($notice25)) {
					$reminders = $notice25row['reminder'] ;
					$ruser_id = $notice25row['user_id'] ;
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
						$notice = $notice . "<span class='glyphicon glyphicon-bullhorn'>&nbsp; ".$reminders. "</span><br/>
												<p style='font-size: 10px;'>By : ".$rname."</p><hr/>";
						$y++ ;
						insert($eventid, $user_id,  $db_handle) ;
					}
				}
								
				break;
				
			case 38:
				$notice26 = mysqli_query($db_handle, " select challenge_id, challenge_title from challenges where challenge_id = '$search_id';") ;
				while ($notice26row = mysqli_fetch_array($notice26)) {
					$challenge_id24 = $notice26row['challenge_id'] ;
					$challenge_titl24 = $notice26row['challenge_title'] ;	
					$notice = $notice ."<span class='glyphicon glyphicon-star'></span><p style='font-size: 10px;'> &nbsp;
										<a href ='profile.php?username=".$uname."'>".$fname."</a>&nbsp; Spammed Challenge </p><br/>
										<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'
										onclick=".update($user_id,$db_handle).">".$challenge_title."</a><br/> on  ".$eventtime."<hr/>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
			}
		}
			
		$data1 .= "<input type='hidden' id='lasteventid' value='".$newid."'/>";		
			$data .= "<div class='dropdown'>
					<a data-toggle='dropdown' onclick='updatetime()'>" ;
			if ($y == 0) {
				$data = $data . "<p class='navbar-text' style ='cursor: pointer;'>" ;
			}
			else {
				$data = $data . "<p class='navbar-text' style ='cursor: pointer; color: red;'>" ;
				}
			$data = $data . "<i class='glyphicon glyphicon-bell'></i>
					  <span class='badge'>
					   <input type='submit' class='btn-link btn-xs' style='padding-left: 0; padding-right: 0; padding-bottom: 0; padding-top: 0; 
					   color: white;' id='countnotice' value='".$y."'/>
					  </span>
					 </p>
				   </a>
					<ul class='dropdown-menu multi-level' style=' max-height: 300px; overflow: auto;'role='menu' aria-labelledby='dropdownMenu'>
						<li>".$notice."</li>
						<div class='newnotices' ></div>
						<li><a href='notifications.php'>See All</a></li>
					</ul>
				</div>" ;
	if($y == 0) {
		echo "updated" ;
		}
	else {
	echo $data."+".$data1 ;
	}
	}
	mysqli_close($db_handle);
}	
else echo "Invalid parameters!";
?>
