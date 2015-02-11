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
		$Projects = mysqli_query($db_handle, "SELECT project_id, project_title from projects where 
											  project_id NOT IN (SELECT DISTINCT project_id FROM teams WHERE user_id = '$user_id') 
											  and project_type = '1' limit 0, 30 ;") ;
		if(mysqli_num_rows($Projects) == 0){
			$data .= "Sorry, No Project To Join";
		}
		else {
			$data .=  "<div class='row-fluid'>" ;
			while($ProjectsRow = mysqli_fetch_array($Projects)) {
				$title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $ProjectsRow['project_title']))) ;
				$proId = $ProjectsRow['project_id'] ;
				$data = $data . "<div class='span4' style=' margin:2px;border: 1px solid; border-color: #E5E6E9;' id='poject_".$proId."'>
							<div class='row-fluid'>
								<div class='span7' style=' margin:2px;word-wrap:break-word;'><a href = 'project.php?project_id=".$proId."' style='word-wrap:break-word;'> ". $title."</a></div>
								<div class='span4' style=' margin:2px;'><a class='btn btn-primary pull-right' onclick='projectjoin(".$proId.")'>Join</a></div>
							</div>
						  </div>" ;
			}
			$data = $data . "</div>" ;
		}
	echo $data ;
	}
	else {
		events($db_handle,$user_id,"13",$knownid);
		involve_in($db_handle,$user_id,"13",$knownid);
		mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$user_id', '$knownid', 'defaultteam') ;") ;
		if(mysqli_error($db_handle)) { echo "Failed to Joined !"; }
		else { 
			$joinProjects = mysqli_query($db_handle, "SELECT project_title from projects where project_id = '$knownid' ;") ;
			$joinProjectsRow = mysqli_fetch_array($joinProjects) ;
			$data2 = "<a href = 'project.php?project_id=".$knownid."' style='word-wrap:break-word;'>".str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $joinProjectsRow['project_title'])))."</a><br/>" ;
			echo "Joined succesfully!"."+".$data2 ; 
		}
	} 
}
else {echo "Invalid parameters!"; }
mysqli_close($db_handle);	
?>
