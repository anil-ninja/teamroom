<?php
include_once "../lib/db_connect.php";
$email=$_REQUEST['email'];
if ($_POST['email']) {
$sql="SELECT * FROM user_info where email='$email'";
$data=mysqli_query($db_handle,$sql);
	if(mysqli_num_rows($data)>0) {
		echo true ;
	}
		else {
			echo false;
		}	
}
$sql="SELECT * FROM user_info where email='$email'";
$data=mysqli_query($db_handle,$sql);
if(mysqli_num_rows($data)>0)
{
print "<span style=\"color:red;\">Email already exists</span>";
return true ;
}
else
{
print "<span style=\"color:green;\">Email is available</span>";
return false;
}
?>
