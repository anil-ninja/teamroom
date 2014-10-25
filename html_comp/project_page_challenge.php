<?php 

	$i = 0 ;
	$c = mysqli_query($db_handle, "SELECT * FROM challenges WHERE project_id = '$p_id' AND challenge_type != '3' AND challenge_type != '6' 
										 AND blob_id = '0' ;") ;
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
											FROM challenges WHERE project_id = '$pro_id' AND challenge_type != '3' AND challenge_type != '6' 
											AND challenge_type != '7' AND blob_id = '0')
											UNION
										 (SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, a.challenge_ETA, a.challenge_status, LEFT(b.stmt, 90) as stmt
										   FROM challenges AS a JOIN blobs AS b WHERE a.project_id = '$pro_id' AND a.challenge_type != '3' AND a.challenge_type != '6' 
										   AND a.challenge_type != '7' AND a.blob_id = b.blob_id );");
      while($summaryrow = mysqli_fetch_array($summary)) {
				$sid = $summaryrow['challenge_id'] ;
				$sidtitle = $summaryrow['challenge_title'] ;
				$sideta = $summaryrow['challenge_ETA'] ;
				$sidstmt = str_replace("<s>","&nbsp;",$summaryrow['stmt']) ;
				$sidtype = $summaryrow['challenge_type'] ;
				$sidstatus = $summaryrow['challenge_status'] ;
				$sutime = eta($sideta) ;
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
