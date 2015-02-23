<?php
	include_once "../lib/db_connect.php";
if($_POST['id']){
	$project = $_POST['id'];
	$time = date("Y-m-d H:i:s") ;
	$myquery = mysqli_query($db_handle, "INSERT INTO targets (email) VALUES ('$project') ;") ;
	if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
	else { echo "Subscribed succesfully!"; }
}
else { echo "Invalid";}	
mysqli_close($db_handle);
?>
