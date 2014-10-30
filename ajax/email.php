<?php
include_once "../lib/db_connect.php";
if ($_POST['email']) {
	$email = $_POST['email'] ;
$sql="SELECT * FROM user_info where email='$email'";
$data=mysqli_query($db_handle,$sql);
	if(mysqli_num_rows($data)>0) {
		echo true ;
	}
		else {
			echo false;
		}	
}
?>
