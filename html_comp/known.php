<p> <b><u> Collaborating With </u></b></p>
	<?php
	$user_id = $_SESSION['user_id'] ;
	$userProjects = mysqli_query($db_handle, ("SELECT * FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
												where a.user_id = '$profileViewUserID' and a.team_name = b.team_name and b.user_id != '$profileViewUserID')
											    as b where a.user_id = b.user_id ;"));
	
	while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
		$friendFirstName = $userProjectsRow['first_name'];
		$friendLastName = $userProjectsRow['last_name'];
		$usernameFriends = $userProjectsRow['username'];
		$useridFriends = $userProjectsRow['user_id'];
			
		$firends = mysqli_query($db_handle, ("SELECT a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
												where a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id')
											    as b where a.user_id = b.user_id ;"));
											    
		while($firendsRow = mysqli_fetch_array($firends)) {
			//$firendsusername = $firendsRow['username'];
			//$firendsuserid = $firendsRow['user_id'];
			//echo $firendsuserid ." :: ". $useridFriends."<br/>";
			if ($firendsuserid == $useridFriends) {	
						
						$flag = 1;
						break;
			}		   
					   		   
					  // INSERT INTO `known_peoples`(`id`, `requesting_user_id`, `knowning_id`, `status`, `requesting_time`, `last_action_time`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
		}
		if ($flag) {			
				echo "<a href ='profile.php?username=" . $usernameFriends . "'>" . ucfirst($friendFirstName) . " " . ucfirst($friendLastName) . "</a><br>";
			}		   
			else {
					echo "<a href ='profile.php?username=" . $usernameFriends . "'>" . ucfirst($friendFirstName) . " " . ucfirst($friendLastName) . "</a>
							<form method='POST' action='' onsubmit=\"return confirm('Really Know this Person !!!')\">
								<input type = 'hidden' name = 'knownid' value = '".$useridFriends."'/>
								<input type = 'submit' class = 'btn-info' name = 'knownperson' value = 'I Know'/>
							</form>
						<br>";
			}
			$flag = 0;
}
	?>
