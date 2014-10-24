<?php 
	$i = 0 ;
	$c = mysqli_query($db_handle, "SELECT * FROM challenges WHERE project_id = '$p_id' AND challenge_type != '3' AND challenge_type != '6' 
											AND challenge_type != '7' AND blob_id = '0' ;") ;
	if(mysqli_num_rows($c) > 0)	{									
	echo "   
			<h3 class='panel-title'><p align='center'>Summary</p></h3>
		<table class='scroll table table-striped'>
			<thead>
				<tr>
					<th>No.</th>
					<th>Challenges</th>
					<th>Time</th>
					<th>Owned</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody >" ;
		}
	 $summary = mysqli_query($db_handle, "(SELECT DISTINCT challenge_id, challenge_title, challenge_type, challenge_status, challenge_ETA, LEFT(stmt, 90) as stmt
											FROM challenges WHERE project_id = '$p_id' AND challenge_type != '3' AND challenge_type != '6' 
											AND challenge_type != '7' AND blob_id = '0')
											UNION
										 (SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, a.challenge_ETA, a.challenge_status, LEFT(b.stmt, 90) as stmt
										   FROM challenges AS a JOIN blobs AS b WHERE a.project_id = '$p_id' AND a.challenge_type != '3' AND a.challenge_type != '6' 
										   AND a.challenge_type != '7' AND a.blob_id = b.blob_id );");
      while($summaryrow = mysqli_fetch_array($summary)) {
				$sid = $summaryrow['challenge_id'] ;
				$sidtitle = $summaryrow['challenge_title'] ;
				$sideta = $summaryrow['challenge_ETA'] ;
				$sidstmt = str_replace("<s>","&nbsp;",$summaryrow['stmt']) ;
				$sidtype = $summaryrow['challenge_type'] ;
				$sidstatus = $summaryrow['challenge_status'] ;
				$daysu = floor($sideta/(24*60)) ;
				$daysecsu = $sideta%(24*60) ;
				$hoursu = floor($daysecsu/(60)) ;
				$minutesu = $daysecsu%(60) ;
		if($sideta > 1439) {
			$sutime = $daysu." days" ;
		}
		else {
			if(($sideta < 1439) AND ($sideta > 59)) {
				$sutime = $hoursu." hours" ;	
			}
			else { $sutime = $minutesu." mins" ; }
		} 
		if (($sidtype == 1 OR $sidtype == 2) AND $sidstatus == 1 )	{
			$sstatus = "Not Owned" ;
		}
		else if (($sidtype == 1 OR $sidtype == 2) AND $sidstatus == 2 )	{
			$sstatus = "IN Progress" ;
		}	
		else if ($sidtype == 4 OR $sidtype == 5) {	
			$sstatus = "Completed" ;
		}
		else if ($sidtype == 8) {	
			$sstatus = "Task" ;
		}
		$owned = mysqli_query($db_handle, "select a.user_id, b.first_name, b.username from challenge_ownership as a join user_info as b where a.challenge_id = '$sid' and a.user_id = b.user_id ;") ;	
		$ownedrow = mysqli_fetch_array($owned) ;
		$sname = $ownedrow['username'] ;
		$sfname = $ownedrow['first_name'] ;
		$i++; 
		
		echo "<tr>
				<td>".$i."</td>
				<td><a href ='challengesOpen.php?challenge_id=".$sid."'>".$sidtitle."</a><br/>".$sidstmt."</td>
				<td>".$sutime."</td>
				<td><a href ='profile.php?username=".$sname."'>".$sfname."</a></td>
				<td>".$sstatus."</td>
			</tr>" ;
	}
	echo "</tbody>
            </table>" ;
				?>
