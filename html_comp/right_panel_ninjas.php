<div class="bs-component">
  <p align="center"><font size="4">Your Tasks</font></p>
  <div class="well">
<?php
    $title_display = mysqli_query($db_handle, "SELECT DISTINCT challenge_id FROM challenge_ownership where user_id = '$user_id' and status='5';");
		while ($title_displayRow = mysqli_fetch_array($title_display)) {
				$id = $title_displayRow['challenge_id'] ;
		$titles = mysqli_query($db_handle, "select DISTINCT a.challenge_title, a.project_id, a.user_id, a.challenge_creation, a.challenge_ETA, b.first_name, b.last_name from
											challenges as a join user_info as b where a.challenge_id = '$id' and a.challenge_type = '8' and a.user_id = b.user_id order by challenge_creation DESC ;" ) ;
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
				$tooltip = "Assigned By : ".ucfirst($fname)." ".ucfirst($lname)."On ".$time." ETA given : ".$remaining_time." ".$remaining_time_own ;			
		echo "<form method='POST' action=''>
				<input type='hidden' name='project_id' value='".$titlesrow['project_id']."'/>
				<p align='center'><button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
				data-placement='bottom' data-original-title='".$tooltip."' style='white-space: pre-line;'><b>".ucfirst($title)."</b><br/><p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>".$remaining_time_own."</p></button></p></form><hr/>" ;
      }
  }
?>
   </div>
</div>
