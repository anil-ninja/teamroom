<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['email']) {
	$email = $_POST['email'] ;
	$user_id = $_SESSION['user_id'] ;
	$sql = mysqli_query($db_handle,"SELECT * FROM user_info where email='$email' ;") ;
	$data = mysqli_fetch_array($sql);
	$id = $data['user_id'] ;
	if(mysqli_num_rows($sql)>0) {
		if($id == $user_id) { echo "same" ; }
		else { echo "true"; }
	}
	else {
		echo "false";
	}
}
else { echo "Invalid parameters!"; }
mysqli_close($db_handle);
?>
