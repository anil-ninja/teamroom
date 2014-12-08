<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/collapMail.php';
if($_POST['fname']){
		$user_id = $_SESSION['user_id'] ;
	$uname = mysqli_query($db_handle,"select * from user_info where user_id = '$user_id' ;") ;
		$unamerow = mysqli_fetch_array($uname) ;
		$name = $unamerow['username'] ;
		$fname = $_POST['fname'] ;
		$sname = $_POST['sname'] ;
		$email = $_POST['email'] ;
		collapMail($email, $name." Send Invitation To Join http://collap.com ", $body2) ;   
		$body2 = "http://collap.com/index.php" ;
		if(mysqli_error($db_handle)) { echo "An error occured Sorry try again!"; }
		else { echo "Invitation Send Successfully !!!"; }	
}	
	else echo "Invalid parameters!";
	mysqli_close($db_handle);
?>
