<?php 
session_start();
include_once "../lib/db_connect.php";
 function update($id,$db_handle) {
		mysqli_query($db_handle, " UPDATE notifications SET status = '1' WHERE user_id = '$id' ;") ;
		}
if ($_POST['all']) {
    $user_id = $_SESSION['user_id'];
    $notice = "" ;
	$notice1 = mysqli_query($db_handle, "select Distinct b.first_name, b.username, a.project_id, a.project_title, a.creation_time from projects as a join user_info as b
											where a.project_type = '1' and a.user_id != '$user_id' and a.user_id = b.user_id order by creation_time DESC ;") ;
	while($notice1row = mysqli_fetch_array($notice1)) {
		$fname = ucfirst($notice1row['first_name']) ;
		$project_id = $notice1row['project_id'] ;
		$strtime = strtotime($notice1row['creation_time']) ;
		$eventtime = date("j F, g:i a", $strtime) ;
		$title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice1row['project_title'])))) ;
		$uname = $notice1row['username'] ;
		$notice .= "<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);'>
						<i class='icon-plus'></i>
						<a href ='profile.php?username=".$uname."'>".$fname."</a> Created 
						<a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$project_id."' 
						target='_blank'>". $title."</a> on ".$eventtime."
					</div>" ;
	}
	$notice2 = mysqli_query($db_handle, "(SELECT * FROM events WHERE (p_c_id, event_type) IN (SELECT p_c_id, p_c_type FROM involve_in WHERE user_id = '$user_id') and event_creater != '$user_id' )
										 UNION
										 (SELECT * FROM events WHERE event_type IN ( 4, 8, 10, 14, 15, 16 ) 
										 and p_c_id = '$user_id' and event_creater != '$user_id') order by timestamp DESC;") ;
	while($notice2row = mysqli_fetch_array($notice2)) {
		$eventid = $notice2row['id'] ;
		$creater = $notice2row['event_creater'] ;
		$type = $notice2row['event_type'] ;
		$search_id = $notice2row['p_c_id'] ;
		$strtme2 = strtotime($notice2row['timestamp']) ;
		$eventtime2 = date("j F, g:i a", $strtme2) ;
		$notice3 = mysqli_query($db_handle, " select * from user_info where user_id = '$creater' ;") ;
		$notice3row = mysqli_fetch_array($notice3) ;
		$fname2 = ucfirst($notice3row['first_name']) ;
		$uname2 = $notice3row['username'] ;
		$rank = $notice3row['rank'] ;
		$lname = ucfirst($notice3row['last_name']) ;
		$phone = $notice3row['contact_no'] ;
	
		switch($type){
			case 1:
				$notice4 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id' and challenge_status != '3' and challenge_status != '7' ;") ;
				$notice4row = mysqli_fetch_array($notice4) ;
				$challenge_id3 = $notice4row['challenge_id'] ;
				$type3 = $notice4row['challenge_type'] ;
				if($type3 == '1' || $type3 == '2' || $type3 == '3'){
					$created = "Challenge";
				}
				else if ($type3 == '6') {
					$created = "Note";
				}
				else if ($type3 == '8') {
					$created = "Video";
				}
				else {
					$created = "Issue";
				}
				$pro_id = $notice4row['project_id'] ;
				$challenge_title3 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice4row['challenge_title'])))) ;
				$projectinfo = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id';") ;
				$projectinforow = mysqli_fetch_array($projectinfo) ;
				$project_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $projectinforow['project_title'])))) ;
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-star'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Created ".$created." In Project
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id."' 
										target='_blank'>".$project_title."</a>
										<a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id3."' 
										target='_blank'>".$challenge_title3."</a> on  ".$eventtime2."
									</div>" ;
				
				break;
				
			case 3:
				$notice5 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id' and challenge_status != '3' ;") ;
				$notice5row = mysqli_fetch_array($notice5) ;
				$challenge_status = $notice5row['challenge_status'] ;
				$challenge_id4 = $notice5row['challenge_id'] ;
				$challenge_title4 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice5row['challenge_title'])))) ;
				if($challenge_status == '2') {	
					$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Accepted Challenge 
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id4."' 
											target='_blank'>".$challenge_title4."</a> on  ".$eventtime2."
										</div>" ;
				}
				else if($challenge_status == '4') {	
					$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Submit Answer of 
											<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id4."' 
											target='_blank'>".$challenge_title4."</a> on  ".$eventtime2."
										</div>" ;
				}
				else if($challenge_status == '5') {	
					$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Closed Challenge 
											<a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id4."' 
											target='_blank'>".$challenge_title4."</a> on  ".$eventtime2."
										</div>" ;
				}
				else {	
					$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
											<i class='icon-star'></i>
											<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Spammed Challenge 
											<a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id4."' 
											target='_blank'>".$challenge_title4."</a> on  ".$eventtime2."
										</div>" ;
				}
				
				break;
				
			case 4:
				$notice6 = mysqli_query($db_handle, "select a.challenge_id, a.project_id, a.challenge_title from challenges as a join challenge_ownership as b
													  where a.user_id = '$creater' and b.user_id = '$user_id and a.challenge_type = '5' and 
													  a.challenge_status = '2' and a.challenge_id = b.challenge_id ;") ;
				$notice6row = mysqli_fetch_array($notice6) ;
				$challenge_id5 = $notice6row['challenge_id'] ;
				$pro_id5 = $notice6row['project_id'] ;
				$challenge_title5 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice6row['challenge_title'])))) ;
				$projectinfo = mysqli_query($db_handle, " select * from projects where project_id = '$pro_id5';") ;
				$projectinforow = mysqli_fetch_array($projectinfo) ;
				$project_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $projectinforow['project_title'])))) ;
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-star'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Assigned Task 
										<a class='btn-link' style='color:#3B6998;' href='challengesOpen.php?challenge_id=".$challenge_id5."' 
										target='_blank'>".$challenge_title5."</a> In 
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id5."' 
										target='_blank'>".$project_title."</a> on  ".$eventtime2."
									</div>" ;
			
				break;	
			
			case 5:
				$notice7 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id' and challenge_status != '3' and challenge_status != '7' ;") ; 
				$notice7row = mysqli_fetch_array($notice7) ;
				$challenge_id6 = $notice7row['challenge_id'] ;
				$challenge_status2 = $notice7row['challenge_status'] ;
				$type6 = $notice7row['challenge_type'] ;
				if($type6 == '1' || $type6 == '2'){
					$commmented = "Challenge";
				}
				else if ($type6 == '3') {
					if($challenge_status2 == '6') {
						$commmented = "Photo";
					}
					else {
						$commmented = "Challenge";
					}
				}
				else if ($type6 == '4') {
					$commmented = "Idea";
				}
				else if ($type6 == '5') {
					$commmented = "Task";
				}
				else if ($type6 == '6') {
					$commmented = "Note";
				}
				else if ($type6 == '7') {
					$commmented = "Article";
				}
				else if ($type6 == '8') {
					$commmented = "Video";
				}
				else {
					$commmented = "Issue";
				}
				$challenge_title6 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice7row['challenge_title'])))) ;
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-star'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Commented On ".$commmented." 
										<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id6."' 
										target='_blank'>".$challenge_title6."</a> on  ".$eventtime2."
									</div>" ;
				
				break;			
			
			case 6:
				$notice8 = mysqli_query($db_handle, " select * from projects where project_id = '$search_id' and project_type != '3' and project_type != '5' ;") ;
				$notice8row = mysqli_fetch_array($notice8) ;
				$pro_id3 = $notice8row['project_id'] ;
				$project_title3 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice8row['project_title'])))) ;	
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-share'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp;	Commented On 
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id3."' 
										target='_blank'>".$project_title3."</a> on  ".$eventtime2."
									</div>" ;
		
				break;
				
			case 7:
				$notice9 = mysqli_query($db_handle, "select a.project_id, a.project_title, b.team_name from projects as a join teams as b where
													 a.project_id = '$search_id' and b.project_id = a.project_id and a.project_type != '3' and a.project_type != '5' ;") ;
				$notice9row = mysqli_fetch_array($notice9) ;
				$pro_id3 = $notice9row['project_id'] ;
				$team_name = $notice9row['team_name'] ;
				$project_title3 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice9row['project_title'])))) ;	
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-plus'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp;	Add member in Team ".$team_name."
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id3."' 
										target='_blank'>".$project_title3."</a> on  ".$eventtime2."
									</div>" ;
			
				break;
				
			case 8:
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-star'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Updated His Profile on  ".$eventtime2."
									</div>" ;
					
				break;
			
			case 9:
				$notice10 = mysqli_query($db_handle, " select * from challenges where challenge_id = '$search_id' and challenge_status != '3' and challenge_status != '7' ;") ;
				$notice10row = mysqli_fetch_array($notice10) ;
				$challenge_id9 = $notice10row['challenge_id'] ;
				$likes = mysqli_query($db_handle, " select * from likes where challenge_id = $search_id' and user_id = '$creater' ;") ;
				$likesrow = mysqli_fetch_array($likes) ;
				$statusl = $likesrow['like_status'] ;
				if ($statusl == '1'){
					$like = "Push" ;
				}
				else {
					$like = "Pull" ;
				}
				$challenge_title9 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice10row['challenge_title'])))) ;	
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-star'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; ".$like."  
										<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id9."' 
										target='_blank' >".$challenge_title9."</a> on  ".$eventtime2."
									</div>" ;
				
				break;
				
			case 10:
				$notice11 = mysqli_query($db_handle, " SELECT * FROM known_peoples where status = '1' and knowning_id = '$user_id' and requesting_user_id = '$creater' ;") ;
				$notice11row = mysqli_fetch_array($notice11) ;
				$linkid = $notice11row['id'] ;
				if(mysqli_num_rows($notice11) != 0) {
					$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
											<i class='icon-plus'></i> 
											<a href ='profile.php?username=".$uname2."'>".$fname2."</a>&nbsp; Send Link on  ".$eventtime2."<br/>
											<input type='submit' class='btn-link inline-form' onclick='requestaccept(\"".$linkid."\");' value='Accept'/>
											<input type='submit' class='btn-link inline-form' onclick='requestdelete(\"".$linkid."\");' value='Delete'/>
										</div>" ;
				}
			
				break;
				
			case 11:
				$notice12 = mysqli_query($db_handle, " select * from projects where project_id = '$search_id' and project_type != '3' and project_type != '5' ;") ;
				$notice12row = mysqli_fetch_array($notice12) ;	
				$pro_id4 = $notice12row['project_id'] ;
				$project_title4 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice12row['project_title'])))) ;	
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-share' ></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a> Edited Project 
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id4."' 
										target='_blank'>".$project_title4."</a> on  ".$eventtime2."
									</div>" ;
		
				break;
			
			case 13:
				$notice13 = mysqli_query($db_handle, " select * from projects where project_id = '$search_id' and project_type != '3' and project_type != '5' ;") ;
				$notice13row = mysqli_fetch_array($notice13) ;
				$pro_id5 = $notice13row['project_id'] ;
				$project_title5 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice13row['project_title'])))) ;	
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-share'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a> Joined in 
										<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id5."' 
										target='_blank'>".$project_title5."</a> on  ".$eventtime2."
									</div>" ;

				break;
			
			case 14:
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-star'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a> Changed His Organisation, Home Town and Informaton on ".$eventtime2."
									</div>" ;
				 
				break;
				
			case 15:
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-plus'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a> Added Skills to his profile on  ".$eventtime2."
									</div>" ;
			
			break;
				
			case 16:
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-plus'></i>
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a> Added Profession to his profile on  ".$eventtime2."
									</div>" ;
			
			break;
				
			case 17:
				$notice14 = mysqli_query($db_handle, " select * from projects where project_id = '$search_id' and project_type != '3' and project_type != '5' ;") ;
				$notice14row = mysqli_fetch_array($notice14) ;
				$pro_id6 = $notice14row['project_id'] ;
				$owner = $notice14row['user_id'] ;
				if ($owner == $user_id) {
					$project_title6 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $notice14row['project_title'])))) ;	
					$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
											<i class='icon-share'></i>
											<a href ='profile.php?username=".$uname2."'>".$fname2."</a> wants to invest in your project 
											<a class='btn-link' style='color:#3B6998;' href='project.php?project_id=".$pro_id6."' 
											target='_blank'>".$project_title6."</a> on  ".$eventtime2."
										</div>" ;
				}
			
			break;
				
			case 18:
				$notice = $notice ."<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);' onclick=".update($user_id,$db_handle).">
										<i class='icon-plus'></i> 
										<a href ='profile.php?username=".$uname2."'>".$fname2."</a> Accepted Link on  ".$eventtime2."
									</div>" ;
				 
				break;
			}
		}
		$notice15 = mysqli_query($db_handle, "select Distinct a.user_id, a.reminder, a.creation_time, b.first_name from reminders as a join user_info
											as b where a.person_id = '$user_id' and a.user_id = b.user_id ;") ;
		while ($notice15row = mysqli_fetch_array($notice15)) { 
			$reminders = $notice15row['reminder'] ;
			$ruser_id = $notice15row['user_id'] ;
			$reminderstatus = $notice15row['status'] ;
			$strtime3 = strtotime($notice15row['creation_time']) ;
			$eventtime3 = date("j F, g:i a", $strtime3) ;
			if ($ruser_id == $user_id) {
				$rname = "You" ;
			}
			else {
				$rname = ucfirst($notice15row['first_name']) ;
			}	
			$notice = $notice . "<div class ='row-fluid' style='margin-top:10px;padding-left:5px; background : rgb(240, 241, 242);'>
									<i class='icon-bullhorn'> ". $reminders."</i> By : ".$rname." on " .$eventtime3."
								</div>";
		}
echo $notice ;
}
else {
	echo "invalid" ;
	}
						
?>
