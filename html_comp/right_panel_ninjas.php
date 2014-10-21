<div class="bs-component">
  
<p align="center"><font size="4">Your Tasks</font></p><hr/>
<?php
		$titles = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.challenge_creation, c.user_id, b.first_name, b.last_name, b.username
											FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE c.user_id = '$user_id' AND a.challenge_type = '8'
											AND a.user_id = b.user_id AND a.challenge_id = c.challenge_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.challenge_creation, c.user_id, b.first_name, b.last_name, b.username
											FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE c.user_id = '$user_id' AND (a.challenge_type = '1' OR a.challenge_type = '2') 
											and a.challenge_status = '2' AND a.user_id = b.user_id AND a.challenge_id = c.challenge_id) ;" ) ;
		while ($titlesrow =  mysqli_fetch_array($titles)) {		
				$title = $titlesrow['challenge_title'] ;
		if (strlen($title) > 25) {
			$chtitle = substr(ucfirst($title),0,26)."....";
		} else {
				$chtitle = ucfirst($title) ;
			}		
				$time = $titlesrow['challenge_creation'] ;
				$timefun = date("j F, g:i a",strtotime($time));
				$eta = $titlesrow['challenge_ETA'] ;
				$fname = $titlesrow['first_name'] ;
				$lname = $titlesrow['last_name'] ;
                $challengeOpen_pageID = $titlesrow['challenge_id'];
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
				if ($totaltime > ((24*60*60)-1)) {
		if($hour != 0) {
		$remaining_time_own = $day." Days and ".$hour." Hours" ;
		} else {
			$remaining_time_own = $day." Days" ;
			}
	} else {
			if (($totaltime < ((24*60*60)-1)) AND ($totaltime > ((60*60)-1))) {
				$remaining_time_own = $hour." Hours and ".$minute." Mins" ;
				} else {
					$remaining_time_own = $minute." Mins" ;
					}
		}
		}
				$tooltip = "Assigned By : ".ucfirst($fname)." ".ucfirst($lname)." On ".$timefun ;			
		echo "<a href='challengesOpen.php?challenge_id=".$challengeOpen_pageID."'> <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
				data-placement='bottom' data-original-title='".$tooltip."' style='white-space: pre-line;height: 20px; font-size:14px;'><b>".$chtitle."</b></button></a>
				<p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>&nbsp;&nbsp;&nbsp;".$remaining_time_own."</p>" ;
      }
  
?><hr/><hr/><br/><br/>
<p align="center"><font size="4">Assigned Tasks</font></p><hr/>
<?php
		$titlesass = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.challenge_creation, c.user_id, b.first_name, b.last_name, b.username
											FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE a.user_id = '$user_id' AND a.challenge_type = '8'
											AND c.user_id = b.user_id AND a.challenge_id = c.challenge_id ;" ) ;
		while ($titlesrowass =  mysqli_fetch_array($titlesass)) {		
				$titleas = $titlesrowass['challenge_title'] ;
		if (strlen($titleas) > 25) {
			$chtitleas = substr(ucfirst($titleas),0,26)."....";
		} else {
				$chtitleas = ucfirst($titleas) ;
			}		
				$timeas = $titlesrowass['challenge_creation'] ;
				$timefunas = date("j F, g:i a",strtotime($timeas));
				$etaas = $titlesrowass['challenge_ETA'] ;
				$fnameas = $titlesrowass['first_name'] ;
				$lnameas = $titlesrowass['last_name'] ;
                $challenge_pageID = $titlesrowass['challenge_id'];
				$dayas = floor($etaas/(24*60)) ;
				$daysecas = $etaas%(24*60) ;
				$houras = floor($daysec/(60)) ;
				$minuteas = $daysec%(60) ;
				$remaining_timeas = $dayas." Days :".$houras." Hours :".$minuteas." Min" ;
				$starttimestras = (string) $timeas ;
				$initialtimeas = strtotime($starttimestras) ;
				$totaltimeas = $initialtimeas+($etaas*60) ;
				$completiontimeas = time() ;
		if ($completiontimeas > $totaltimeas) { 
			$remaining_time_ownas = "Closed" ; }
		else {	$remainingtimeas = ($totaltimeas-$completiontimeas) ;
				$dayass = floor($remainingtimeas/(24*60*60)) ;
				$daysecass = $remainingtimeas%(24*60*60) ;
				$hourass = floor($daysecass/(60*60)) ;
				$hoursecass = $daysecass%(60*60) ;
				$minuteass = floor($hoursecass/60) ;
				if ($totaltimeas > ((24*60*60)-1)) {
		if($hourass != 0) {
		$remaining_time_ownas = $dayass." Days and ".$hourass." Hours" ;
		} else {
			$remaining_time_ownas = $dayass." Days" ;
			}
	} else {
			if (($totaltimeas < ((24*60*60)-1)) AND ($totaltimeas > ((60*60)-1))) {
				$remaining_time_ownas = $hourass." Hours and ".$minuteass." Mins" ;
				} else {
					$remaining_time_ownas = $minuteass." Mins" ;
					}
		}
		}
				$tooltipas = "Assigned To : ".ucfirst($fnameas)." ".ucfirst($lnameas)." On ".$timefunas ;			
		echo "<a href='challengesOpen.php?challenge_id=".$challenge_pageID."'> <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
				data-placement='bottom' data-original-title='".$tooltipas."' style='white-space: pre-line;height: 20px; font-size:14px;'><b>".$chtitleas."</b></button></a>
				<p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>&nbsp;&nbsp;&nbsp;".$remaining_time_ownas."</p>" ;
      }
  
?><hr/><hr/>
</div>
