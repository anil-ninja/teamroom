<?php 
$totaltask = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND challenge_type = '5' AND challenge_status != '3' AND challenge_status != '7';") ;
$totaltaskopen = mysqli_query($db_handle, "select challenge_id, challenge_creation, challenge_ETA from challenges WHERE project_id = '$pro_id' AND challenge_type = '5' AND challenge_status = '2';") ;
$z = 0 ;
while ($ab = mysqli_fetch_array($totaltaskopen)) {
		$time = remaining_time($ab['challenge_creation'], $ab['challenge_ETA']) ;
		if($time == "Closed") {
			$z++ ;
		}
}
$az = $z ;
$bz = mysqli_num_rows($totaltaskopen) - $az ;
$totaltasksubmitted = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND challenge_type = '5' AND challenge_status = '4';") ;
$totaltaskclosed = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND challenge_type = '5' AND challenge_status = '5';") ;

$totalchallenges = mysqli_query($db_handle, "select DISTINCT challenge_id from challenges WHERE project_id = '$pro_id' AND (challenge_type = '1' OR challenge_type = '2') AND challenge_status != '3' AND challenge_status != '7';") ;
$totalchallengesopen = mysqli_query($db_handle, "select challenge_id, challenge_creation, challenge_ETA from challenges WHERE project_id = '$pro_id' AND (challenge_type = '1' OR challenge_type = '2') AND challenge_status = '1';") ;
$y = 0 ;
while ($ac = mysqli_fetch_array($totalchallengesopen)) {
		$timec = remaining_time($ac['challenge_creation'], $ac['challenge_ETA']) ;
		if($timec == "Closed") {
			$y++ ;
		}
}
$ay = $y ;
$by = mysqli_num_rows($totalchallengesopen) - $ay ;
$totalchallengesaccepted = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, b.comp_ch_ETA, b.ownership_creation from challenges as a join challenge_ownership as b where a.project_id = '$pro_id' AND (a.challenge_type = '1' OR a.challenge_type = '2') AND a.challenge_status = '2' and a.challenge_id = b.challenge_id ;") ;
$x = 0 ;
while ($ad = mysqli_fetch_array($totalchallengesaccepted)) {
		$timed = remaining_time($ad['challenge_creation'], $ad['challenge_ETA']) ;
		if($timed == "Closed") {
			$x++ ;
		}
}
$ax = $x ;
$bx = mysqli_num_rows($totalchallengesaccepted) - $ax ;
$totalchallengessubmitted = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND (challenge_type = '1' OR challenge_type = '2') AND challenge_status = '4';") ;
$totalchallengesclosed = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND (challenge_type = '1' OR challenge_type = '2') AND challenge_status = '5';") ;

$totalnotes = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND challenge_type = '6' AND challenge_status = '1';") ;
  echo "<h3 class='panel-title'><p align='center'>Summary</p></h3>
			<table class='table table-striped table-hover '>
			<tbody>
				<tr class='info'>
					<td>Task</td>
					<td>".mysqli_num_rows($totaltask)."</td>
				</tr>
				<tr>
					<td>Tasks Accepted(within Remaining Time)</td>
					<td>".$bz."</td>
				</tr>
				<tr class='warning'>
					<td>Tasks Accepted(Remaining Time Over)</td>
					<td>".$az."</td>
				</tr>
				<tr>	
					<td>Tasks Submitted</td>
					<td>".mysqli_num_rows($totaltasksubmitted)."</td>
				</tr>
				<tr>
					<td>Tasks Completed/Closed</td>
					<td>".mysqli_num_rows($totaltaskclosed)."</td>
				</tr>
				<tr class='info'>
					<td>Challenges</td>
					<td>".mysqli_num_rows($totalchallenges)."</td>
				</tr>
				<tr>
					<td>Challenges Open(within Remaining Time)</td>
					<td>".$by."</td>
				</tr>
				<tr class='warning'>
					<td>Challenges Open(Remaining Time Over)</td>
					<td>".$ay."</td>
				</tr>
				<tr>
					<td>Challenges Accepted(within Remaining Time)</td>
					<td>".$bx."</td>
				</tr>
				<tr class='warning'>
					<td>Challenges Accepted(Remaining Time Over)</td>
					<td>".$ax."</td>
				</tr>
				<tr>
					<td>Challenges Submitted</td>
					<td>".mysqli_num_rows($totalchallengessubmitted)."</td>
				</tr>
				<tr>
					<td>Challenges Completed/Closed</td>
					<td>".mysqli_num_rows($totalchallengesclosed)."</td>
				</tr>
				<tr class='info'>
					<td>Notes</td>
					<td>".mysqli_num_rows($totalnotes)."</td>
				</tr>
			</tbody>
			</table><br/>" ;
  
  
  	echo "<h3 class='panel-title'><p align='center'>Open Challenges</p></h3>
			<table class='scroll table table-striped'>
			<thead>
				<tr>
					<th>Name</th>
					<th>Remaining Time</th>
				</tr>
			</thead>
			<tbody >" ;
		
	 $oc = mysqli_query($db_handle, "SELECT challenge_id, challenge_title, challenge_ETA, challenge_creation FROM challenges WHERE project_id = '$pro_id' AND challenge_type = '2' AND challenge_status = '1' ;");
      while($ocrow = mysqli_fetch_array($oc)) {
				$ocid = $ocrow['challenge_id'] ;
				$octitle = $ocrow['challenge_title'] ;
				$occtime = $ocrow['challenge_creation'] ;
				$oceta = $ocrow['challenge_ETA'] ;
				$rtoc = remaining_time($occtime, $oceta) ;
		echo "<tr>
				<td><a href ='challengesOpen.php?challenge_id=".$ocid."'>".$octitle."</a></td>
				<td>".$rtoc."</td>
			</tr>" ;
	}
	echo "</tbody>
            </table><br/>" ;
  	echo "<h3 class='panel-title'><p align='center'>In progress</p></h3>
			<table class='scroll table table-striped'>
			<thead>
				<tr>
					<th>Type</th>
					<th>Title</th>
					<th>Owned</th>
					<th>R Time</th>
				</tr>
			</thead>
			<tbody >" ;
		
	 $ip = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, b.comp_ch_ETA, b.ownership_creation, b.time, c.first_name, c.username
												from challenges as a join challenge_ownership as b join user_info as c where a.project_id = '$pro_id' 
												AND a.challenge_type != '6' AND a.challenge_status = '2' and a.challenge_id = b.challenge_id
												and b.user_id = c.user_id;");
      while($iprow = mysqli_fetch_array($ip)) {
				$ipid = $iprow['challenge_id'] ;
				$iptitle = $iprow['challenge_title'] ;
				$iptype = $iprow['challenge_type'] ;
				$ipctime = $iprow['ownership_creation'] ;
				$ipname = $iprow['username'] ;
				$ipfname = $iprow['first_name'] ;
				$ipeta = $iprow['comp_ch_ETA'] ;
				$rtip = remaining_time($ipctime, $ipeta) ;
			echo "<tr>
					<td>" ;
		if ($iptype == 2 || $iptype == 1) {
			echo "Challenge" ;
			}
		else {
				echo "Task" ;
			}		
			echo "</td><td><a href ='challengesOpen.php?challenge_id=".$ipid."'>".$iptitle."</a></td>
					<td><a href ='profile.php?username=".$ipname."'>".$ipfname."</a></td>
					<td>".$rtip."</td>
				</tr>" ;
	}
	echo "</tbody>
            </table><br/>" ;
echo "<h3 class='panel-title'><p align='center'>In Review</p></h3>
			<table class='scroll table table-striped'>
			<thead>
				<tr>
					<th>Type</th>
					<th>Title</th>
					<th>Submitted By</th>
					<th>ON</th>
				</tr>
			</thead>
			<tbody >" ;
		
	 $ir = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, b.comp_ch_ETA, b.ownership_creation, b.time, c.first_name, c.username
												from challenges as a join challenge_ownership as b join user_info as c where a.project_id = '$pro_id' 
												AND a.challenge_type != '6' AND a.challenge_status = '4' and a.challenge_id = b.challenge_id
												and b.user_id = c.user_id;");
      while($irrow = mysqli_fetch_array($ir)) {
				$irid = $irrow['challenge_id'] ;
				$irtitle = $irrow['challenge_title'] ;
				$irtype = $irrow['challenge_type'] ;
				$irctime = $irrow['ownership_creation'] ;
				$irname = $irrow['username'] ;
				$irtime = $irrow['time'] ;
				$irontime = date("j F, g:i a",strtotime($irtime));
				$irfname = $irrow['first_name'] ;
				$ireta = $irrow['comp_ch_ETA'] ;
				$rtir = remaining_time($irctime, $ireta) ;
			echo "<tr>
					<td>" ;
		if ($irtype == 2 || $irtype == 1) {
			echo "Challenge" ;
			}
		else {
				echo "Task" ;
			}		
			echo "</td><td><a href ='challengesOpen.php?challenge_id=".$irid."'>".$irtitle."</a></td>
					<td><a href ='profile.php?username=".$irname."'>".$irfname."</a></td>
					<td>".$irontime."</td>
				</tr>" ;
	}
	echo "</tbody>
            </table><br/>" ;
echo "<h3 class='panel-title'><p align='center'>Completed</p></h3>
			<table class='scroll table table-striped'>
			<thead>
				<tr>
					<th>Type</th>
					<th>Title</th>
					<th>Submitted By</th>
					<th>ON</th>
				</tr>
			</thead>
			<tbody >" ;
		
	 $com = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, b.comp_ch_ETA, b.ownership_creation, b.time, c.first_name, c.username
												from challenges as a join challenge_ownership as b join user_info as c where a.project_id = '$pro_id' 
												AND a.challenge_type != '6' AND a.challenge_status = '5' and a.challenge_id = b.challenge_id
												and b.user_id = c.user_id;");
      while($comrow = mysqli_fetch_array($com)) {
				$comid = $comrow['challenge_id'] ;
				$comtitle = $comrow['challenge_title'] ;
				$comtype = $comrow['challenge_type'] ;
				$comctime = $comrow['ownership_creation'] ;
				$comname = $comrow['username'] ;
				$comtime = $comrow['time'] ;
				$comontime = date("j F, g:i a",strtotime($comtime));
				$comfname = $comrow['first_name'] ;
				$cometa = $comrow['comp_ch_ETA'] ;
				$rtcom = remaining_time($comctime, $cometa) ;
			echo "<tr>
					<td>" ;
		if ($irtype == 2 || $irtype == 1) {
			echo "Challenge" ;
			}
		else {
				echo "Task" ;
			}		
			echo "</td><td><a href ='challengesOpen.php?challenge_id=".$comid."'>".$comtitle."</a></td>
					<td><a href ='profile.php?username=".$comname."'>".$comfname."</a></td>
					<td>".$comontime."</td>
				</tr>" ;
	}
	echo "</tbody>
            </table>" ;            
				?>
