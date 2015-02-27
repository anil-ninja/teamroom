<?php
	include_once "../lib/db_connect.php";
	$email_check=$_REQUEST['email_forget'];
	if ($_POST['email_forget']) {
		$sql="SELECT * FROM user_info where email='$email_check'";
		$data=mysqli_query($db_handle,$sql);
		if(mysqli_num_rows($data)>0) {
			echo true ;
		}
		else {
			echo false;
		}	
	}
	$sql="SELECT * FROM user_info where email='$email_check'";
	$data=mysqli_query($db_handle,$sql);
	if(mysqli_num_rows($data)==0) {
		print "<span style=\"color:red;\">No user registered with this Email, <br>Please try again with different Email-id or Signup</span><br>";
		return false;
	}
	mysqli_close($db_handle);
?>
