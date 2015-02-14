<?php 
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/image_resize.php';
$user_id = $_SESSION['user_id'];
if($_POST['type']){
	$type = $_POST['type'] ;
	$knownid = $_POST['pro_id'] ;
	$data = "";
	if($type == '1') {
		$Projects = mysqli_query($db_handle, "SELECT project_id, project_title, stmt, blob_id from projects where 
											  project_id NOT IN (SELECT DISTINCT project_id FROM teams WHERE user_id = '$user_id') 
											  and project_type = '1' limit 0, 30 ;") ;
		if(mysqli_num_rows($Projects) == 0){
			$data .= "Sorry, No Project To Join";
		}
		else {
			$data .=  "<div class='row-fluid'>" ;
			while($ProjectsRow = mysqli_fetch_array($Projects)) {
				$title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $ProjectsRow['project_title'])))) ;
				$stmt = $ProjectsRow['stmt'] ;
				$blob_id = $ProjectsRow['blob_id'] ;
				$proId = $ProjectsRow['project_id'] ;
				if($blob_id == '0') {
					if(substr($stmt, 0, 4) == '<img') {
						$ProjectPicFull = strstr($stmt, '<br/>' , true) ;
					}
					else {
						$ProjectPicFull = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
					}
				}
				else {
					$photo = mysqli_query($db_handle, "SELECT stmt from blobs where blob_id = '$blob_id' ;") ;
					$photoRow = mysqli_fetch_array($photo) ;
					$blobstmt = $photoRow['stmt'] ;
					if(substr($blobstmt, 0, 4) == '<img') {
						$ProjectPicFull = strstr($blobstmt, '<br/>' , true) ;
					}
					else {
						$ProjectPicFull = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
					}
				}
				$ProjectPicLink2 =explode("\"",$ProjectPicFull)[1] ; 			
				$ProjectPic = "<img src='".resize_image($ProjectPicLink2, 60, 60, 1)."' onError=this.src='img/default.gif' style='height:60px;width:60px;'>" ;
				
				$data = $data . "<div class='span4' style=' margin:2px;border: 1px solid; border-color: #E5E6E9;max-height:72px;overflow;hidden;' id='poject_".$proId."'>
									<div class='row-fluid'>
										<div class='span3' style=' margin:2px;'>
											<a class='btn btn-link' onclick='projectjoin(".$proId.")'>".$ProjectPic."</a>
										</div>
										<div class='span8' style=' margin:2px 15px 2px -10px;'>
											<a class='btn btn-link' style='color: #000;white-space:pre-line;' onclick='projectjoin(".$proId.")'>". $title."</a>
										</div>
										<div class='span1' style=' margin:2px;'>
											<a class='btn btn-primary pull-right' onclick='projectjoin(".$proId.")'>Join</a>
										</div>
									</div>
								  </div>" ;
			}
			$data = $data . "</div>" ;
		}
	echo $data ;
	}
	if($type == '2') {
		events($db_handle,$user_id,"13",$knownid);
		involve_in($db_handle,$user_id,"13",$knownid);
		mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$user_id', '$knownid', 'defaultteam') ;") ;
		if(mysqli_error($db_handle)) { echo "Failed to Joined !"; }
		else { echo "Joined succesfully!"; 	}
	}
	if($type == '3') {                  
		$member = "" ;                       
		$userProjects = mysqli_query($db_handle, "(SELECT a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
													where a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id')
													as b where a.user_id = b.user_id )
													UNION
													(select a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join known_peoples as b
													where b.requesting_user_id = '$user_id' and a.user_id = b.knowning_id and b.status != '4')
													UNION
													(select a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join known_peoples as b
													where b.knowning_id = '$user_id' and a.user_id = b.requesting_user_id and b.status = '2') ;");
		$member .= "<table>
					 <tbody>";
		if (mysqli_num_rows($userProjects) != 0 ) {
			while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
				$friendFirstName = $userProjectsRow['first_name'];
				$friendLastName = $userProjectsRow['last_name'];
				$usernameFriends = $userProjectsRow['username'];
				$useridFriends = $userProjectsRow['user_id'];
				$member = $member ."<tr id='member_".$useridFriends."'>
										<td>".$friendFirstName." ".$friendLastName."</td>
										<td style='padding-left:20px;'><button class='btn btn-primary' onclick='AddTeamMember(\"".$useridFriends."\")'>Add</button></td>
									</tr>" ;
			}
		} 
		$member = $member ."</tbody>
								</table>";
		echo $member ; 						
	}
	if($type == '4') {                  
		$member = "" ;                       
		$userProjects = mysqli_query($db_handle, "(SELECT a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
													where a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id')
													as b where a.user_id = b.user_id )
													UNION
													(select a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join known_peoples as b
													where b.requesting_user_id = '$user_id' and a.user_id = b.knowning_id and b.status != '4')
													UNION
													(select a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join known_peoples as b
													where b.knowning_id = '$user_id' and a.user_id = b.requesting_user_id and b.status = '2') ;");
		$member .= "<table>
					 <tbody>";
		if (mysqli_num_rows($userProjects) != 0 ) {
			while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
				$friendFirstName = $userProjectsRow['first_name'];
				$friendLastName = $userProjectsRow['last_name'];
				$usernameFriends = $userProjectsRow['username'];
				$useridFriends = $userProjectsRow['user_id'];
				$member = $member ."<tr id='username_".$useridFriends."'>
										<td>".$friendFirstName." ".$friendLastName."</td>
										<td style='padding-left:20px;'><button class='btn btn-primary' onclick='CreateTeamMember(\"".$useridFriends."\")'>Add</button></td>
									</tr>" ;
			}
		} 
		$member = $member ."</tbody>
								</table>";
		echo $member ; 						
	}
}
else {echo "Invalid parameters!"; }
mysqli_close($db_handle);	
?>
