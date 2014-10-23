<?php  
$_SESSION['lastch'] = '10' ;  
		$tasks = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, a.stmt, a.challenge_creation, a.challenge_type,
											a.challenge_status, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b
											 WHERE a.project_id = '$p_id' AND (a.challenge_type = '8' OR a.challenge_type = '4' OR a.challenge_type = '1' OR a.challenge_type='2')
											AND a.blob_id = '0' and a.user_id = b.user_id)
											UNION
										 (SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, c.stmt,a.challenge_creation, a.challenge_type,
										  a.challenge_creation, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN blobs AS c 
										  WHERE a.project_id = '$p_id' AND (a.challenge_type = '8' OR a.challenge_type = '4' OR a.challenge_type = '1' OR a.challenge_type='2')
										   AND a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY challenge_creation DESC LIMIT 0, 10 ;");
		while ($tasksrow = mysqli_fetch_array($tasks)) {
			$username_task = $tasksrow['username'];
			$id_task = $tasksrow['challenge_id'];
			$title_task = $tasksrow['challenge_title'];
			$type_task = $tasksrow['challenge_type'];
			$status_task = $tasksrow['challenge_status'];
			$eta_task = $tasksrow['challenge_ETA'];
			$creation_task = $tasksrow['challenge_creation'];
			$timetask = date("j F, g:i a",strtotime($creation_task));
			$stmt_task = $tasksrow['stmt'];
			$fname_task = $tasksrow['first_name'];
			$lname_task = $tasksrow['last_name'];
			$day = floor($eta_task/(24*60)) ;
			$daysec = $eta_task%(24*60) ;
			$hour = floor($daysec/(60)) ;
			$minute = $daysec%(60) ;
			$remainingtime = $day." Days :".$hour." Hours :".$minute." Min" ;
			$starttimestr = (string) $creation_task ;
			$initialtime = strtotime($starttimestr) ;
			$totaltime = $initialtime+($eta_task*60) ;
			$completiontime = time() ;
		if ($completiontime > $totaltime) { 
			$remaining_time = "Closed" ; }
	else {	$remaintime = ($totaltime-$completiontime) ;
			$day = floor($remaintime/(24*60*60)) ;
			$daysec = $remaintime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remaining_time = "Remaining Time : ".$day." Days :".$hour." Hours :".$minute." Min " ;
		}	
		$ownedby = mysqli_query($db_handle,"SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, a.time, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$id_task' and b.user_id = a.user_id ;") ;
			$ownedbyrow = mysqli_fetch_array($ownedby) ;
			$owneta = $ownedbyrow['comp_ch_ETA'] ;
			$ownid = $ownedbyrow['user_id'] ;
			$owntime = $ownedbyrow['ownership_creation'] ;
			$timefunct = date("j F, g:i a",strtotime($owntime));
			$committime = $ownedbyrow['time'] ;
			$timecom = date("j F, g:i a",strtotime($committime));
			$ownfname = $ownedbyrow['first_name'] ;
			$ownlname = $ownedbyrow['last_name'] ;
			$ownname = $ownedbyrow['username'] ;
			$dayo = floor($owneta/(24*60)) ;
		$dayseco = $owneta%(24*60) ;
		$houro = floor($daysec/(60)) ;
		$minuteo = $daysec%(60) ;
		if($owneta > 1439) {
			$timeo = $dayo." days" ;
		}
		else {
			if(($owneta < 1439) AND ($owneta > 59)) {
				$timeo = $houro." hours" ;	
			}
			else { $timeo = $minuteo." mins" ; }
		}
        $initialtimeo = strtotime($owntime) ;
        $endtime = strtotime($committime) ;
        $time_taken = ($endtime-$initialtimeo) ;
		$day = floor($time_taken/(24*60*60)) ;
		$daysec = $time_taken%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
		$timetaken = $day." Days :".$hour." Hours :".$minute." Min :" ;
		$totaltimeo = $initialtimeo+($owneta*60) ;
		$completiontimeo = time() ;
if ($completiontimeo > $totaltimeo) { 
	$remaining_time_owno = "Closed" ; }
else {	$remainingtimeo = ($totaltimeo-$completiontimeo) ;
		$dayow = floor($remainingtimeo/(24*60*60)) ;
		$daysecow = $remainingtimeo%(24*60*60) ;
		$hourow = floor($daysecow/(60*60)) ;
		$hoursecow = $daysecow%(60*60) ;
		$minuteow = floor($hoursecow/60) ;
	if ($totaltimeo > ((24*60*60)-1)) {
		if($hourow != 0) {
		$remaining_time_owno = $dayow." Days and ".$hourow." Hours" ;
		} else {
			$remaining_time_owno = $dayow." Days" ;
			}
	} else {
			if (($totaltimeo < ((24*60*60)-1)) AND ($totaltimeo > ((60*60)-1))) {
				$remaining_time_owno = $hourow." Hours and ".$minuteow." Mins" ;
				} else {
					$remaining_time_owno = $minuteow." Mins" ;
					}
		}
}
			echo "<div class='list-group'>
						<div class='list-group-item'>";
	if ($type_task == 4) {
		if ($tasksrow['user_id'] == $user_id) {
		echo "Challenged by <span class='color strong' style= 'color :#3B5998;'> You </span> On : ".$timetask.
				"<br/>ETA Given : ".$remainingtime."</div>
				<div class='list-group-item'>Accepted By <span class='color strong' style= 'color :#3B5998;'>".ucfirst($ownfname)." ".ucfirst($ownlname).
				"</span> and Submitted On : ".$timecom."<br/>ETA Taken : ".$timetaken."</div>" ;
			}					
		}				
	else if($type_task == 8) {					
	      echo "<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>                   
                     <li><button class='btn-link' >Report Spam</button></li>
                   </ul>
              </div>
            </div>";
       if($ownid==$user_id) {			
			echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='".$id_task."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
					</form>";
				}
	echo "Task Assigned by &nbsp <span class='color strong' style= 'color :#3B5998;'>".ucfirst($fname_task)."</a></span> On ".$timefunct."<br/>
			Task Assigned To &nbsp <span class='color strong' style= 'color :#3B5998;'>".ucfirst($ownfname)." ".ucfirst($ownlname)."</a> </span>
					 ETA Given : ".$timeo." <br/>".$remaining_time_owno."</div>";
		} 
		 
		else {			
		if($status_task == 1) {
		echo "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_task."'>" 
				. ucfirst($fname_task). '&nbsp'. ucfirst($lname_task). " </a></span>" ;		 		
				dropDown_challenge($db_handle, $id_task, $user_id, $remaining_time_owno);
			echo "<form method='POST' class='inline-form pull-right'>
						<input type='hidden' name='id' value='".$id_task."'/>
						<input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
					</form>
				 &nbsp&nbsp&nbsp On : ".$timetask."&nbsp&nbsp&nbsp with ETA : ".$sutime."<br/>".$remaining_time."</div>";
		}
		else {
			echo "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_task."'>"
				. ucfirst($fname_task). '&nbsp'. ucfirst($lname_task). " </a></span>&nbsp&nbsp On : ".$timetask."<br/>
				Owned By  <span class='color strong'><a href ='profile.php?username=".$ownname."'>"
				. ucfirst($ownfname). '&nbsp'. ucfirst($ownlname). " </a></span>&nbsp&nbsp On : ".$timefunct." and 
				ETA Taken : ".$timeo." <br/> Time Remaining : ".$remaining_time_owno."</div>" ;
			}
		}			
   	echo "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'><b>".ucfirst($title_task)."</b></p><br/>
				<small>".str_replace("<s>","&nbsp;",$stmt_task)."</small><br>";
	if ($type_task == 4) {
		if ($tasksrow['user_id'] == $user_id) {
		$answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$id_task' and blob_id = '0' and status = '2')
												UNION
												(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$id_task' and a.status = '2' and a.blob_id = b.blob_id);") ;										
			$answerrow = mysqli_fetch_array($answer) ;
		echo "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
				<p align='center'>Answer</p></span>"
				.$answerrow['stmt']."<br/><form method='POST' onsubmit=\"return confirm('Really Close Challenge !!!')\">
				<div class='pull-right'><input type='hidden' name='cid' value='".$id_task."'/>
				<button type='submit' class='btn-primary' name='closechallenge'>Close</button></div></form><br/>" ;
		
		}			
	}	
	$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
                $lstname = $displayrowb['last_name'];
                $username_commenter_pr_ch = $displayrowb['username'];
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_commenter_pr_ch.jpg'  onError=this.src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp<a href ='profile.php?username=".$username_commenter_pr_ch."'>". ucfirst($fstname)."&nbsp".$lstname."</a>&nbsp".
					"</span><small>".$chalangeres."</small>";
					dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
				echo "</div>
			</div> 
		</div>";
		}
		echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                        <form action='' method='POST' class='inline-form'>
                                <input type='hidden' value='".$id_task."' name='own_challen_id' />
                                <input type='text' STYLE='border: 1px solid #bdc7d8; width: 84%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                        </form>
                    </div>";
	echo "</div> </div>";		
			
			
			}

?>
