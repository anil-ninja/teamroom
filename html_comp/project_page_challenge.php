<?php 
include_once '../functions/delete_comment.php';
include_once '../lib/db_connect.php';
session_start();
$pro_id = $_GET['project_id'];
$totaltask = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND challenge_type = '5' AND challenge_status != '3' AND challenge_status != '7';") ;
$totaltaskopen = mysqli_query($db_handle, "select challenge_id, creation_time, challenge_ETA from challenges WHERE project_id = '$pro_id' AND challenge_type = '5' AND challenge_status = '2';") ;
$z = 0 ;
while ($ab = mysqli_fetch_array($totaltaskopen)) {
		$time = remaining_time($ab['creation_time'], $ab['challenge_ETA']) ;
		if($time == "Closed") {
			$z++ ;
		}
}
$az = $z ;
$bz = mysqli_num_rows($totaltaskopen) ;//- $az ;
$totaltasksubmitted = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND challenge_type = '5' AND challenge_status = '4';") ;
$totaltaskclosed = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND challenge_type = '5' AND challenge_status = '5';") ;

$totalchallenges = mysqli_query($db_handle, "select DISTINCT challenge_id from challenges WHERE project_id = '$pro_id' AND (challenge_type = '1' OR challenge_type = '2') AND challenge_status != '3' AND challenge_status != '7';") ;
$totalchallengesopen = mysqli_query($db_handle, "select challenge_id, creation_time, challenge_ETA from challenges WHERE project_id = '$pro_id' AND (challenge_type = '1' OR challenge_type = '2') AND challenge_status = '1';") ;
$y = 0 ;
while ($ac = mysqli_fetch_array($totalchallengesopen)) {
		$timec = remaining_time($ac['creation_time'], $ac['challenge_ETA']) ;
		if($timec == "Closed") {
			$y++ ;
		}
}
$ay = $y ;
$by = mysqli_num_rows($totalchallengesopen) - $ay ;
$totalchallengesaccepted = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, b.comp_ch_ETA, b.ownership_creation from challenges as a join challenge_ownership as b where a.project_id = '$pro_id' AND (a.challenge_type = '1' OR a.challenge_type = '2') AND a.challenge_status = '2' and a.challenge_id = b.challenge_id ;") ;
$x = 0 ;
while ($ad = mysqli_fetch_array($totalchallengesaccepted)) {
		$timed = remaining_time($ad['ownership_creation'], $ad['comp_ch_ETA']) ;
		if($timed == "Closed") {
			$x++ ;
		}
}
$ax = $x ;
$bx = mysqli_num_rows($totalchallengesaccepted) ;//- $ax ;
$totalchallengessubmitted = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND (challenge_type = '1' OR challenge_type = '2') AND challenge_status = '4';") ;
$totalchallengesclosed = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND (challenge_type = '1' OR challenge_type = '2') AND challenge_status = '5';") ;

$totalnotes = mysqli_query($db_handle, "select challenge_id from challenges WHERE project_id = '$pro_id' AND challenge_type = '6' AND challenge_status = '1';") ;

   echo "<div class='panel-group' id= 'Dashboard' role='tablist' aria-multiselectable='true'>
                    <div class='panel panel-default'>
                        <div class='panel-heading' style='padding: 5px;' role='tab' id='DashboardHead'>
                            <a class='collapsed' data-toggle='collapse' data-parent='#Dashboard' href='#DashboardBody' aria-expanded='false' aria-controls='collapseFive'>
                                <b>PROJECT DASHBOARD</b>
                            </a>
						</div>" ;
				echo "	<div class='row-fluid' >
							<div class='span5' >
								<div id='DashboardBody' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='DashboardHead'>   
									<div class='panel-body' style='padding: 1px;'>
										<div class='list-group-item' style='font-size:10px;'>
											<table class='table table-striped'>
												<thead> 
													<center>
														TASKS (".mysqli_num_rows($totaltaskclosed)."/".mysqli_num_rows($totaltask).") 
													</center>
												</thead>
												<tbody>												
													<tr class='active'>
														<td>On Track</td>
														<td id='graph_val_1'>".$bz."</td>
													</tr>
													<tr class='active'>	
														<td>Submitted</td>
														<td id='graph_val_2'>".mysqli_num_rows($totaltasksubmitted)."</td>
													</tr>
													<tr >
														<td>Completed</td>
														<td id='graph_val_3'>".mysqli_num_rows($totaltaskclosed)."</td>
													</tr>
												</tbody>
											</table>
										</div>
								   </div>
								</div>
							</div>
							<div class='span7' >" ;
				if(mysqli_num_rows($totaltask) != 0) {			
						echo "<div id='chart_div'></div>" ;
		?>
						<script type="text/javascript">drawChart() ;</script>
		<?php
				}
				else {  
					echo "<p style='font-size: 20px; text-align: center; margin-top: 20px; color: lightblue;'> No Data Available</p>" ;
				}	
					echo  "</div>
						</div>" ;
				  echo "<div class='row-fluid' >
							<div class='span5' >
								<div id='DashboardBody' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='DashboardHead'>   
									<div class='panel-body' style='padding: 1px;'>
										<div class='list-group-item' style='font-size:10px;'>
											<table class='table table-striped table-hover '>
												<thead> 
													<center>
														CHALLENGES (".mysqli_num_rows($totalchallengesclosed)."/".mysqli_num_rows($totalchallenges).")
													</center>
												</thead>
												<tbody>
													<tr>
														<td>Open</td>
														<td id='graph2_val_1'>".$by."</td>
													</tr>
													<tr>
														<td>Closed</td>
														<td id='graph2_val_2'>".$ay."</td>
													</tr>
													<tr>
														<td>Accepted</td>
														<td id='graph2_val_3'>".$bx."</td>
													</tr>
													<tr>
														<td>Submitted</td>
														<td id='graph2_val_4'>".mysqli_num_rows($totalchallengessubmitted)."</td>
													</tr>
													<tr>
														<td>Completed</td>
														<td id='graph2_val_5'>".mysqli_num_rows($totalchallengesclosed)."</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class='span7' >" ;
				if(mysqli_num_rows($totalchallenges) != 0) {			
						echo "<div id='chart_div2'></div>" ;
		?>
						<script type="text/javascript">drawChart2() ;</script>
		<?php
				}
				else {  
					echo "<p style='font-size: 20px; text-align: center; margin-top: 20px; color: lightblue;'> No Data Available</p>" ;
				}	
					echo "</div>
						</div>" ;	  
 
                echo "<div class='panel-group' id= 'SUMMARY' role='tablist' aria-multiselectable='true'>
                        <div class='panel panel-default'>
                            <div class='panel-heading' style='padding: 5px;' role='tab' id='SUMMARYHead'>
                                <a class='collapsed' data-toggle='collapse' data-parent='#SUMMARY' href='#SUMMARYBody' aria-expanded='false' aria-controls='collapseFive'>
                                    <b>WORK SUMMARY</b>
                                </a>
                            </div>
                            <div id='SUMMARYBody' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='SUMMARYHead'>   
                                <div class='panel-body' style='padding: 1px;'>
                                <div class='list-group-item' style='font-size:10px;'>
                                    <table class='table table-striped scroll '>
                                        <thead> <center><b>Not Accepted</b></center>
                                        </thead>
                                        <tbody>" ;
		
            $oc = mysqli_query($db_handle, "SELECT challenge_id, challenge_title, challenge_ETA, creation_time FROM challenges WHERE project_id = '$pro_id' AND challenge_type = '2' AND challenge_status = '1' ;");
            if (mysqli_num_rows($oc) == 0) {
        		echo "<tr>
						<td style='width:180px'>
						<i> No content to display.</i>
						</td>
					  </tr>" ;    	
            }
            else {

	            while($ocrow = mysqli_fetch_array($oc)) {
					$ocid = $ocrow['challenge_id'] ;
					$octitle = $ocrow['challenge_title'] ;
					$occtime = $ocrow['creation_time'] ;
					$oceta = $ocrow['challenge_ETA'] ;
					$rtoc = remaining_time($occtime, $oceta) ;
			echo "<tr>
					<td style='width:180px'><a href ='challengesOpen.php?challenge_id=".$ocid."'>".$octitle."</a></td>
				  </tr>" ;
				}
			}
            echo "</tbody>
                </table></div>" ;


  	echo "<div class='list-group-item' style='font-size:10px;'>
				<table class='table table-striped scroll '>
				 <thead> <center><b>In Progress</b></center>
				 </thead>
				 <tbody>";
		
	 $ip = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, b.comp_ch_ETA, b.ownership_creation, b.time, c.first_name, c.username
												from challenges as a join challenge_ownership as b join user_info as c where a.project_id = '$pro_id' 
												AND a.challenge_type != '6' AND a.challenge_status = '2' and a.challenge_id = b.challenge_id
												and b.user_id = c.user_id;");
      
	if (mysqli_num_rows($ip) == 0) {
		echo "<tr>
				<td style='width:180px'>
				<i> No content to display.</i>
				</td>
			  </tr>" ;
	}
	else {
		echo "<tr>
				<td>Type</td>
				<td>Title</td>
				<td>Owned</td>
			</tr>";
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
				</tr>" ;
		}
	}
	echo "</tbody>
            </table></div>" ;
        echo "<div class='list-group-item' style='font-size:10px;'>
				<table class='table table-striped scroll '>
				 <thead> <center><b>In Review</b></center>
				 </thead>
				 <tbody>";

				
		
	$ir = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, b.comp_ch_ETA, b.ownership_creation, b.time, c.first_name, c.username
												from challenges as a join challenge_ownership as b join user_info as c where a.project_id = '$pro_id' 
												AND a.challenge_type != '6' AND a.challenge_status = '4' and a.challenge_id = b.challenge_id
												and b.user_id = c.user_id;");
    if (mysqli_num_rows($ir) == 0) {
		echo "<tr>
				<td style='width:180px'>
				<i> No content to display.</i>
				</td>
			  </tr>";
	}
	else {
		echo "
			<tr>
				<td style='width:70px'>Type</td>
				<td style='width:70px'>Title</td>
				<td style='width:70px'>Submitted By</td>
				<td style='width:70px'>ON</td>
			</tr>";
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
					<td style='width:70px'>" ;
		if ($irtype == 2 || $irtype == 1) {
			echo "Challenge" ;
			}
		else {
				echo "Task" ;
			}		
			echo "</td><td style='width:70px'><a href ='challengesOpen.php?challenge_id=".$irid."'>".$irtitle."</a></td>
					<td style='width:70px'><a href ='profile.php?username=".$irname."'>".$irfname."</a></td>
					<td style='width:70px'>".$irontime."</td>
				</tr>" ;
	}
}
	echo "</tbody>
            </table></div>" ;
echo  "<div class='list-group-item'style='font-size:10px;'>
				<table class='table table-striped scroll '>
				 <thead> <center><b>Completed</b></center>
				 </thead>
				 <tbody>";

				
		
	$com = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, b.comp_ch_ETA, b.ownership_creation, b.time, c.first_name, c.username
												from challenges as a join challenge_ownership as b join user_info as c where a.project_id = '$pro_id' 
												AND a.challenge_type != '6' AND a.challenge_status = '5' and a.challenge_id = b.challenge_id
												and b.user_id = c.user_id;");
	if (mysqli_num_rows($com) == 0) {
		echo "<tr>
				<td style='width:180px'>
				<i> No content to display.</i>
				</td>
			  </tr>";
	}
	else {
		echo "<tr>
					<td style='width:70px'>Type</td>
					<td style='width:70px'>Title</td>
					<td style='width:70px'>Submitted By</td>
					<td style='width:70px'>ON</td>
				</tr>";
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
					<td style='width:70px'>" ;
		if ($irtype == 2 || $irtype == 1) {
			echo "Challenge" ;
			}
		else {
				echo "Task" ;
			}		
			echo "</td><td style='width:70px'><a href ='challengesOpen.php?challenge_id=".$comid."'>".$comtitle."</a></td>
					<td style='width:70px'><a href ='profile.php?username=".$comname."'>".$comfname."</a></td>
					<td style='width:70px'>".$comontime."</td>
				</tr>" ;
		}
	}
	echo "</tbody>
            </table></div></div>" ;  
mysqli_close($db_handle);          
?>
