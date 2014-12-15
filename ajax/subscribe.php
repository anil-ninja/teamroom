<?php
	include_once "../lib/db_connect.php";
if($_POST['id']){
	$project = $_POST['id'];
	$time = date("Y-m-d H:i:s") ;
	$myquery = mysqli_query($db_handle, "INSERT INTO targets (email) VALUES ('$project') ;") ;
	if(mysqli_error($db_handle)) { echo "Failed to Post Project!"; }
	else { echo "Posted succesfully!"; }
	mysqli_close($db_handle);
}
else echo "Invalid";	
?>
