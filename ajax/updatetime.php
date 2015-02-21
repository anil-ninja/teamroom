<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['update']){
	$user_id = $_SESSION['user_id'];
	$a = date("Y-m-d H:i:s") ;
	//$_SESSION['last_login'] = $a ;
	$case = $_POST['case'] ;
	mysqli_query($db_handle, " UPDATE user_info SET last_login = '$a' WHERE user_id = '$user_id' ;") ;
	if($case == '1') { 
		mysqli_query($db_handle, " UPDATE reminders SET status = '1' WHERE person_id = '$user_id' ;") ;
	}
	if(mysqli_error($db_handle)) { echo "Failed"; }
	else { echo "updated"; }
	mysqli_close($db_handle);
}	
else echo "Invalid parameters!";
?>
