<div class="bs-component">
  <p align="center"><font size="4">Your Tasks</font></p>
  <div class="well">
<?php
		$titles = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.project_id, a.challenge_title, a.challenge_ETA, a.stmt, a.challenge_creation, c.user_id, b.first_name, b.last_name, b.username
											FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE c.user_id = '$user_id' AND a.challenge_type = '8'
											AND c.user_id = b.user_id AND a.challenge_id = c.challenge_id ;" ) ;
		while ($titlesrow =  mysqli_fetch_array($titles)) {		
				$title = $titlesrow['challenge_title'] ;
				$time = $titlesrow['challenge_creation'] ;
				$eta = $titlesrow['challenge_ETA'] ;
				$fname = $titlesrow['first_name'] ;
				$lname = $titlesrow['last_name'] ;
				$day = floor($eta/(24*60)) ;
				$daysec = $eta%(24*60) ;
				$hour = floor($daysec/(60)) ;
				$minute = $daysec%(60) ;
				$remaining_time = $day." Days :".$hour." Hours :".$minute." Min" ;
				$starttimestr = (string) $time ;
				$initialtime = strtotime($starttimestr) ;
				$totaltime = $initialtime+($eta*60) ;
				$completiontime = time() ;
		if ($completiontime > $totaltime) { 
			$remaining_time_own = "Closed" ; }
		else {	$remainingtime = ($totaltime-$completiontime) ;
				$day = floor($remainingtime/(24*60*60)) ;
				$daysec = $remainingtime%(24*60*60) ;
				$hour = floor($daysec/(60*60)) ;
				$hoursec = $daysec%(60*60) ;
				$minute = floor($hoursec/60) ;
				$remaining_time_own = "Remaining Time : ".$day." Days :".$hour." Hours :".$minute." Min " ;
		}
				$tooltip = "Assigned By : ".ucfirst($fname)." ".ucfirst($lname)." On ".$time." ETA given : ".$remaining_time." ".$remaining_time_own ;			
		echo "<form method='POST' action=''>
				<input type='hidden' name='project_id' value='".$titlesrow['project_id']."'/>
				<p align='center'><button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
				data-placement='bottom' data-original-title='".$tooltip."' style='white-space: pre-line;'><b>".ucfirst($title)."</b><br/><p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>".$remaining_time_own."</p></button></p></form><hr/>" ;
      }
  
?>
   </div>
</div>
