<?php
//include_once '../lib/db_connect.php';
   $pro_id = $_SESSION['project_id'] ;
   $user_id = $_SESSION['user_id'] ;
   $team_name = $_SESSION['team_name'] ;

  include_once 'functions/delete_comment.php';
	$td1 = "" ;
	
			
   $open_chalange_of_project = mysqli_query($db_handle, "select DISTINCT a.challenge_id, a.challenge_title, b.first_name from challenges as a join user_info as b 
										WHERE a.project_id = '$pro_id' AND (a.challenge_type = '1' or a.challenge_type = '2') and a.challenge_status = '1'
										and a.user_id = b.user_id ;") ;
	while($open_chalange_of_projectrow = mysqli_fetch_array($open_chalange_of_project)) {
		$name1 = $open_chalange_of_projectrow['first_name'] ;
		$challenge_id11 = $open_chalange_of_projectrow['challenge_id'] ;
		$challenge_title11 = $open_chalange_of_projectrow['challenge_title'] ;
		 $td1 .= "<td><p style='font-size: 10px;'>Created By ".$name1."</p><br/>".$challenge_title11."<br/></td>";		
		}
		
	$td2 = "" ;
	$td5 = "" ;
	$td3 = "" ;
	$td4 = "" ;
	$kanban2 = mysqli_query($db_handle, "select a.user_id, b.username, b.first_name, b.rank 
											from teams as a join user_info as b 
											where a.project_id = '$pro_id'
												and a.team_name = '$team_name' 
												and a.user_id = b.user_id ;") ;
	while($kanban2row = mysqli_fetch_array($kanban2)) {
		$name2 = $kanban2row['first_name'] ;
		$username2 = $kanban2row['username'] ;
		$user_id2 = $kanban2row['user_id'] ;
		$rank2 = $kanban2row['rank'] ;
										
	$kanban3 = mysqli_query($db_handle, "select DISTINCT a.challenge_id, a.challenge_title, a.challenge_status, b.first_name from challenges as a join
										user_info as b join challenge_ownership as c WHERE a.project_id = '$pro_id' 
										 AND a.challenge_id = c.challenge_id and a.user_id = b.user_id and c.user_id = '$user_id2' ;") ;	
		while($kanban3row = mysqli_fetch_array($kanban3)) {
			$name3 = $kanban3row['first_name'] ;
			$challenge_id12 = $kanban3row['challenge_id'] ;
			$challenge_title12 = $kanban3row['challenge_title'] ;
			$status3 = $kanban3row['challenge_status'] ;
		if($status3 == 2){
			$td2 .= "<p style='font-size: 10px;'>Created By ".$name3."</p><br/>".$challenge_title12."<hr/>";
			}	
		if($status3 == 4){
			$td3 .= "<p style='font-size: 10px;'>Created By ".$name3."</p><br/>".$challenge_title12."<hr/>";
			}
		if($status3 == 5){	
			$td4 .= "<p style='font-size: 10px;'>Created By ".$name3."</p><br/>".$challenge_title12."<hr/>";
			}
		}
	$td5 .=	"<tr><td>".$name2." <br/>".$rank2."</td><td>".$td2."</td><td>".$td3."</td><td>".$td4."</td></tr>" ;
	$td2 = "" ;
	$td3 = "" ;
	$td4 = "" ;
		}
	echo "<table class='table table-striped' border='1'>
			<thead>
				<tr>
					<th>Open</th>
					<th>
						<table>
							<thead>
								<tr>
									<th>Team Members</th>
									<th>In - Progress</th>
									<th>In - Review</th>
									<th>Completed</th>
								</tr>
							</thead>
						</table>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>".$td1."
					<td><table border='1'>
							<thead><tr><th></th><th></th><th></th><th></th></tr></thead>
							<tbody>".$td5."</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		  </table>" ;
?>
