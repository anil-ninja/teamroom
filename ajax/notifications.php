<?php
session_start();
include_once "../lib/db_connect.php";
function insert($id, $user_ID,  $db_handle) {
	 mysqli_query($db_handle, "INSERT INTO notifications (event_id, user_id) VALUES ('$id', '$user_ID') ;") ;
	 }
 function update($id,$db_handle) {
		mysqli_query($db_handle, " UPDATE notifications SET status = '1' WHERE user_id = '$id' ;") ;
		}
if ($_POST['notice']) {
    $notificationTime = $_SESSION['last_login'] ;
	$user_id = $_SESSION['user_id'] ;
	$notice = "" ;
	$data = "" ;
	$data1 = "" ;
	$y = 0 ;
	$notice27 = mysqli_query($db_handle, "select Distinct b.first_name, b.username, a.project_id, a.project_title, a.creation_time from projects as a join user_info as b
											where a.creation_time > '$notificationTime' and a.project_type = '1' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
		while($notice27row = mysqli_fetch_array($notice27)) {
			$fname25 = ucfirst($notice27row['first_name']) ;
			$project_id25 = $notice27row['project_id'] ;
			$strtime = strtotime($notice27row['creation_time']) ;
			$eventtimeN = date("j F, g:i a", $strtime) ;
			$title25 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice27row['project_title']))) ;
			$uname25 = $notice27row['username'] ;
			$notice .= "<li>
							<a class='btn-link line' style='white-space: normal ;' href='project.php?project_id=".$project_id25."' target='_blank'>
								<i class='icon-plus'></i>
								".$fname25." Created ". $title25." on .".$eventtimeN."
							</a>
						</li>" ;
			$y++ ;
			}
	$notice1 = mysqli_query($db_handle, "(SELECT * FROM events WHERE (p_c_id, event_type) IN (SELECT p_c_id, p_c_type FROM involve_in WHERE user_id = '$user_id') 
										 and timestamp > '$notificationTime' and event_creater != '$user_id' )
										 UNION
										 (SELECT * FROM events WHERE event_type IN ( 8, 12, 18, 19, 20, 21, 22, 23, 24, 25, 28, 29, 30, 36 ) 
										 and p_c_id = '$user_id' and timestamp > '$notificationTime' and event_creater != '$user_id') order by timestamp DESC;") ;
	while($notice1row = mysqli_fetch_array($notice1)) {
		$eventid = $notice1row['id'] ;
		$creater = $notice1row['event_creater'] ;
		$type = $notice1row['event_type'] ;
		$search_id = $notice1row['p_c_id'] ;
		$strtme = strtotime($notice1row['timestamp']) ;
		$eventtime = date("j F, g:i a", $strtme) ;
		$notice2 = mysqli_query($db_handle, " select * from user_info where user_id = '$creater' ;") ;
		$notice2row = mysqli_fetch_array($notice2) ;
		$fname = ucfirst($notice2row['first_name']) ;
		$uname = $notice2row['username'] ;
		$rank = $notice2row['rank'] ;
		$lname = ucfirst($notice2row['last_name']) ;
		$phone = $notice2row['contact_no'] ;
			
		switch($type){
			case 3:
				$notice3 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice3row = mysqli_fetch_array($notice3) ;
				$challenge_id = $notice3row['challenge_id'] ;
				$challenge_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice3row['challenge_title']))) ;	
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id."' 
										target='_blank'	onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											".$fname."&nbsp; Commented On ".$challenge_title." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
			
			case 4:
				$notice4 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice4row = mysqli_fetch_array($notice4) ;
				$challenge_id2 = $notice4row['challenge_id'] ;
				$challenge_title2 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice4row['challenge_title']))) ;
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id2."' 
										target='_blank'	onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											".$fname."&nbsp; Accepted Challenge ".$challenge_title2." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
			
			case 5:
				$notice5 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice5row = mysqli_fetch_array($notice5) ;
				$challenge_id3 = $notice5row['challenge_id'] ;
				$challenge_title3 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice5row['challenge_title']))) ;
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id3."' 
										target='_blank'	onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											".$fname."&nbsp; Submit Answer of ".$challenge_title3." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
			
			case 6:
				$notice6 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice6row = mysqli_fetch_array($notice6) ;
				$challenge_id4 = $notice6row['challenge_id'] ;
				$challenge_title4 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice6row['challenge_title']))) ;
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id4."' 
										target='_blank'	onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											".$fname."&nbsp; Closed Challenge ".$challenge_title4." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
		
			case 7:
				$notice7 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice7row = mysqli_fetch_array($notice7) ;
				$challenge_id5 = $notice7row['challenge_id'] ;
				$challenge_title5 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice7row['challenge_title']))) ;
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id5."' 
										target='_blank'	onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											".$fname."&nbsp; Spammed Challenge ".$challenge_title5." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
		
			case 8:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick='".update($user_id,$db_handle)."'>
											<i class='icon-star'></i> ".$fname."&nbsp; Updated His Profile on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
					
				break;
			
			case 10:
				$notice8 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice8row = mysqli_fetch_array($notice8) ;
				$challenge_id6 = $notice8row['challenge_id'] ;
				$challenge_title6 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice8row['challenge_title']))) ;
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id6."' 
										target='_blank'	onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											".$fname."&nbsp; Created Challenge ".$challenge_title6." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
			
			case 11:
				$notice9 = mysqli_query($db_handle, "select a.project_id, a.project_title, b.team_name from projects as a join teams as b where
													a.project_id = '$search_id' and b.project_id = a.project_id and b.team_creation > '$notificationTime';") ;
				$notice9row = mysqli_fetch_array($notice9) ;
				$pro_id7 = $notice9row['project_id'] ;
				$team_name = $notice9row['team_name'] ;
				$project_title7 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice9row['project_title']))) ;	
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='project.php?project_id=".$pro_id7."' 
										onclick='".update($user_id,$db_handle)."' target='_blank'>
											<i class='icon-share'></i>
											".$fname."&nbsp; Created Team ".$team_name." in ".$project_title7." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;

			case 12:
				$notice10 = mysqli_query($db_handle, "select a.challenge_id, a.project_id, a.challenge_title from challenges as a join challenge_ownership as b
													  where a.user_id = '$creater' and b.user_id = '$user_id and a.challenge_type = '5' and a.challenge_status = '2'
													  and a.creation_time > '$notificationTime' and a.challenge_id = b.challenge_id ;") ;
				$notice10row = mysqli_fetch_array($notice10) ;
				$challenge_id8 = $notice10row['challenge_id'] ;
				$pro_id8 = $notice10row['project_id'] ;
				$challenge_title8 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice10row['challenge_title']))) ;
				$projectinfo8 = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id8';") ;
				$projectinforow8 = mysqli_fetch_array($projectinfo8) ;
				$project_title8 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $projectinforow8['project_title']))) ;
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='project.php?project_id=".$pro_id8."' 
										onclick= '".update($user_id,$db_handle)."' target='_blank'>
											<i class='icon-star'></i>
											".$fname."&nbsp; Assigned Task ".$challenge_title8." In ".$project_title8." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
			
				break;		
					
			case 13:
				$notice11 = mysqli_query($db_handle, " select * from projects where project_id = '$search_id';") ;
				$notice11row = mysqli_fetch_array($notice11) ;
				$pro_id9 = $notice11row['project_id'] ;
				$project_title9 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice11row['project_title']))) ;	
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='project.php?project_id=".$pro_id9."' 
										onclick=".update($user_id,$db_handle)." target='_blank'>
											<i class='icon-share'></i>
											".$fname." Joined in ".$project_title9." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
			
			case 14:
				$notice12 = mysqli_query($db_handle, " select * from projects where project_id = '$search_id';") ;
				$notice12row = mysqli_fetch_array($notice12) ;
				$pro_id10 = $notice12row['project_id'] ;
				$project_title10 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice12row['project_title']))) ;	
				$notice = $notice ."<li><a class='btn-link' style='white-space: normal ;' href='project.php?project_id=".$pro_id10."' 
										target='_blank' onclick=".update($user_id,$db_handle).">
										<i class='icon-share'></i>
										".$fname."&nbsp;	Commented On 
										".$project_title10." on  ".$eventtime."
									</a></li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
		
				break;
			
			case 15:
				$notice13 = mysqli_query($db_handle, "select a.project_id, a.project_title, b.team_name from projects as a join teams as b where
													 a.project_id = '$search_id' and b.project_id = a.project_id and b.team_creation > '$notificationTime';") ;
				$notice13row = mysqli_fetch_array($notice13) ;
				$pro_id11 = $notice13row['project_id'] ;
				$team_name2 = $notice13row['team_name'] ;
				$project_title11 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice13row['project_title']))) ;	
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='project.php?project_id=".$pro_id11."' 
										onclick=".update($user_id,$db_handle)." target='_blank'>
											<i class='icon-plus'></i>
											".$fname."&nbsp;	Add member in Team ".$team_name2." in ".$project_title11." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
			
				break;
			
			case 16:
				$notice14 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice14row = mysqli_fetch_array($notice14) ;
				$challenge_id12 = $notice14row['challenge_id'] ;
				$challenge_title12 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice14row['challenge_title']))) ;	
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id12."' 
										target='_blank' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											".$fname."&nbsp; Likes ".$challenge_title12." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				
				break;
				
			case 17:
				$notice15 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice15row = mysqli_fetch_array($notice15) ;
				$challenge_id13 = $notice15row['challenge_id'] ;
				$challenge_title13 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice15row['challenge_title']))) ;
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id13."' 
										target='_blank'	onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											".$fname."&nbsp; Dislike ".$challenge_title13." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 18:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i> ".$fname."`s Rank Updated to ".$rank ." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 19:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i> ".$fname." Updated His First name on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
						
				break;
				
			case 20:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i> ".$fname." Updated His Last Name to ".$lname ." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
						
				break;
				
			case 21:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i> ".$fname." Updated His Phome No. to ".$phone ." on  ".$eventtime."
										</a>
									</li>" ;
				
				break;
				
			case 22:
				$notice19 = mysqli_query($db_handle, " select * from about_users where user_id = '$creater';") ;
				$notice19row = mysqli_fetch_array($notice19) ;
				$org = $notice19row['organisation_name'] ;
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i> ".$fname." Changed His Organisation to ".$org." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 23:
				$notice20 = mysqli_query($db_handle, " select * from about_users where user_id = '$creater';") ;
				$notice20row = mysqli_fetch_array($notice20) ;
				$town = $notice20row['living_town'] ;
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i> ".$fname." Changed His Town to ".$town." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 24:
				$notice21 = mysqli_query($db_handle, " select * from about_users where user_id = '$creater';") ;
				$notice21row = mysqli_fetch_array($notice21) ;
				$about = $notice21row['about_user'] ;
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i> ".$fname." Changed His Information to ".$about." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 25:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i> ".$fname." Updated His Profile Picture on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 28:
				$notice22 = mysqli_query($db_handle, " SELECT * FROM known_peoples where last_action_time > '$notificationTime' and status = '1' and knowning_id = '$user_id' and requesting_user_id = '$creater' ;") ;
				$notice22row = mysqli_fetch_array($notice22) ;
				$linkid = $notice22row['id'] ;
				if(mysqli_num_rows($notice22) != 0) {
					$notice = $notice ."<li><div class='row-fluid'>
											<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-plus'></i> 
											".$fname."</a>&nbsp; Send Link on  ".$eventtime."<br/>
											<input type='submit' class='btn-link inline-form' onclick='requestaccept(\"".$linkid."\")' value='Accept'/>
											<input type='submit' class='btn-link inline-form' onclick='requestdelete(\"".$linkid."\")' value='Delete'/>
										</div></li>" ;
					$y++ ;
					insert($eventid, $user_id,  $db_handle) ;
				}
				
				break;
				
			case 29:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-plus'></i> ".$fname." Accepted Link on  ".$eventtime."
										<a/>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 30:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' style='white-space: normal ;' onclick=".update($user_id,$db_handle).">
											<i class='icon-plus'></i> ".$fname."&nbsp; Deleted Link on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 31:
				$notice23 = mysqli_query($db_handle, "select * from projects where project_id = '$search_id';") ;
				$notice23row = mysqli_fetch_array($notice23) ;
				$pro_id21 = $notice23row['project_id'] ;
				$project_title21 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice23row['project_title']))) ;	
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='project.php?project_id=".$pro_id21."' 
										onclick=".update($user_id,$db_handle)." target='_blank'>
											<i class='icon-share'></i> ".$fname." Masseged In ".$project_title21." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
		
				break;
				
			case 33:
				$notice24 = mysqli_query($db_handle, " select * from projects where project_id = '$search_id';") ;
				$notice24row = mysqli_fetch_array($notice24) ;	
				$pro_id22 = $notice24row['project_id'] ;
				$project_title22 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice24row['project_title']))) ;	
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='project.php?project_id=".$pro_id22."' 
										onclick=".update($user_id,$db_handle)." target='_blank'>
											<i class='icon-share'></i> ".$fname." Edited Project ".$project_title22." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
		
				break;
				
			case 36:
				$notice = $notice ."<li>
										<a href ='profile.php?username=".$uname."' onclick=".update($user_id,$db_handle).">
											<i class='icon-plus'></i>	".$fname." Added Skills to his profile on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
				
			case 38:
				$notice26 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id';") ;
				$notice26row = mysqli_fetch_array($notice26) ;
				$challenge_id24 = $notice26row['challenge_id'] ;
				$challenge_titl24 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $notice26row['challenge_title']))) ;	
				$notice = $notice ."<li>
										<a class='btn-link' style='white-space: normal ;' href='challengesOpen.php?challenge_id=".$challenge_id."' 
										target='_blank'	onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>	".$fname."&nbsp; Spammed Challenge ".$challenge_title." on  ".$eventtime."
										</a>
									</li>" ;
				$y++ ;
				insert($eventid, $user_id,  $db_handle) ;
				
				break;
			}
		}
		$notice25 = mysqli_query($db_handle, "select Distinct a.status, a.user_id, a.reminder, a.time, b.first_name from reminders as a join user_info
											as b where a.person_id = '$user_id' and a.user_id = b.user_id ;") ;
		while ($notice25row = mysqli_fetch_array($notice25)) { 
			$reminders = $notice25row['reminder'] ;
			$ruser_id = $notice25row['user_id'] ;
			$reminderstatus = $notice25row['status'] ;
			if ($ruser_id == $user_id) {
				$rname = "You" ;
			}
			else {
				$rname = ucfirst($notice25row['first_name']) ;
			}
			$reminder_time = $notice25row['time'] ;
			$starttime = strtotime($reminder_time) ;
			$endtime = time() ;
			if ($endtime <= $starttime) {
				$timeleft = $starttime - $endtime ;
			}
			else {
				$timeleft = $starttime ;
			}
			if($reminderstatus == '0') {
				if ($timeleft < 0) {
					$notice = $notice . "<li><a style='white-space: normal ;'>
											<i class='icon-bullhorn'></i> ". $reminders. " By : ".$rname."
										</a></li>";
					$y++ ;
				}
			}
			else {
				if ($timeleft < 600 && $timeleft > 0) {
					$notice = $notice . "<li><a style='white-space: normal ;'>
											<i class='icon-bullhorn'></i> ". $reminders. " By : ".$rname."
										</a></li>";
					$y++ ;
				}
			}
		}			
		$data1 .= "<input type='hidden' id='lasteventid' value='".$eventid."'/>";		
		$data .= "<a class='dropdown-toggle' data-toggle='dropdown' style='color: white;' onclick='updatetime()'><i class='btn-success icon-bell'></i>" ;
			if ($y != 0) {
				$data = $data . "<span class='badge' style='padding: 0px; color: white;' id='countnotice'>".$y."</span>" ;
				}
	$data = $data . "&nbsp;&nbsp; |</a>
					<ul class='dropdown-menu pull-right'>
							".$notice."
							<span class='newnotices' ></span>
							<li><a href='notifications.php'>See All</a></li>
					</ul>" ;
	echo $data."+".$data1 ;
mysqli_close($db_handle);
}
?>
