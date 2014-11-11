<p> <b><u> Collaborating With </u></b></p>
	<?php
	$userProjects = mysqli_query($db_handle, ("SELECT * FROM user_info as a join 
											(SELECT DISTINCT b.user_id FROM teams as a join
											teams as b where a.user_id = '$profileViewUserID' and
											a.team_name = b.team_name and b.user_id != '$profileViewUserID')
											as b where a.user_id=b.user_id;"));

	while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
		$friendFirstName = $userProjectsRow['first_name'];
		$friendLastName = $userProjectsRow['last_name'];
		$usernameFriends = $userProjectsRow['username'];
		echo "<a href ='profile.php?username=" . $usernameFriends . "'>
						" . ucfirst($friendFirstName) . " " . ucfirst($friendLastName) . "
				   <br></a>";
	}
	?>
