<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['team']) {
	$email = $_POST['email'] ;
	$team = $_POST['team'] ;
	$user_id = $_SESSION['user_id'] ;
	$pro_id = $_SESSION['project_id'];
	$sql = mysqli_query($db_handle,"SELECT * FROM user_info where email='$email' ;") ;
	$data = mysqli_fetch_array($sql);
	$id = $data['user_id'] ;
	//echo $id ;
	mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, team_owner, project_id) VALUES 
								('$id', '$team', '0', '$pro_id'),
								('$user_id','$team', '$user_id', '$pro_id');");
     if(mysqli_error($db_handle)) { echo "Failed to Create Team!"; }
	else { echo "Team Created Successfully !!!"; }    
 mysqli_close($db_handle);
}
else echo "Invalid parameters!";
?>
