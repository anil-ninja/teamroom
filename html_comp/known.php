<p> <b><u> Collaborating With </u></b></p>
 <div>
	<?php
	$user_id = $_SESSION['user_id'] ;
	$userProjects = mysqli_query($db_handle, "SELECT * FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
												where a.user_id = '$profileViewUserID' and a.team_name = b.team_name and 
												b.user_id != '$profileViewUserID' and b.user_id != '$user_id')
											    as b where a.user_id = b.user_id ;");
	
	while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
		$friendFirstName = $userProjectsRow['first_name'];
		$friendLastName = $userProjectsRow['last_name'];
		$usernameFriends = $userProjectsRow['username'];
		$useridFriends = $userProjectsRow['user_id'];
		$friendRank = $userProjectsRow['rank'];
			
		$firends = mysqli_query($db_handle, "SELECT a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
												where a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id')
											    as b where a.user_id = b.user_id ;");
											    
		while($firendsRow = mysqli_fetch_array($firends)) {
			$firendsuserid = $firendsRow['user_id'];
			if ($firendsuserid == $useridFriends) {	
						$flag = 1;
						break;
			}		   
		}
		if ($flag) {			
				echo "<div class ='row' style='border-width: 1px; border-style: solid;margin:4px;background : #E1F9E4;'>
						<div class ='col-md-3 ' style='padding:1px;'>
                        <img src='uploads/profilePictures/$usernameFriends.jpg'  onError=this.src='img/default.gif' style='height:40px' class='img-responsive'>
                      </div>
                	  <div class = 'col-md-8' style='font-size:12px;padding: 1px;'><span class='color pull-left' id='new_added'><a href ='profile.php?username=" . $usernameFriends. "'>" 
                                    .ucfirst($friendFirstName)." ".ucfirst($friendLastName)."</a></span><br/><span style='font-size:10px;'>"
                                    .$friendRank."</span>
                      </div><br/>
                      </div>";
	
			 }		   
			else {
				echo "<div class ='row' style='border-width: 1px; border-style: solid;margin:4px;background : #E1F9E4;'>
						<div class ='col-md-2' style='padding:1px;'>
                         <img src='uploads/profilePictures/$usernameFriends.jpg'  onError=this.src='img/default.gif' style='height:40px' class='img-responsive'>
                      </div>
                      <div class = 'col-md-7' style='font-size:12px;padding: 1px;'>
                      	<span class='color pull-left' id='new_added'><a href ='profile.php?username=" . $usernameFriends. "'>" 
                                    .ucfirst($friendFirstName)." ".ucfirst($friendLastName)."</a>
                        </span><br/>
                        <span style='font-size:10px;'>".$friendRank."</span>
                       </div>
                       <div class = 'col-md-2' style='font-size:12px;padding-left: 1px; padding-right: 0px;'>
							<form method='POST' action='' onsubmit=\"return confirm('Really Know this Person !!!')\">
								<input type = 'hidden' name = 'knownid' value = '".$useridFriends."'/><br/>
								<input type = 'submit' class = 'btn-success' name = 'knownperson' value = 'link'/>
							</form>
                         </div>
                       </div>";
			}
			$flag = 0;
}
if(isset($_POST['knownperson'])){
	$knownid = $_POST['knownid'] ;
	$time = date("Y-m-d H:i:s") ;
	$user_id = $_SESSION['user_id'] ;
	echo $knownid ;
	mysqli_query($db_handle, "INSERT INTO known_peoples (requesting_user_id, knowning_id, last_action_time) VALUES ('$user_id', '$knownid', '$time') ;") ; 
	 if(mysqli_error($db_handle)) { echo "<script>alert('Request Already Send!')</script>"; }
	else { echo "<script>alert('Request send succesfully!')</script>"; }
	//header('Location: #');
	}
	?>
</div>