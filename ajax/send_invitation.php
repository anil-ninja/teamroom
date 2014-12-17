<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/collapMail.php';
if($_POST['fname']){
		$user_id = $_SESSION['user_id'] ;
		$username = $_SESSION['username'];
	$uname = mysqli_query($db_handle,"select * from user_info where user_id = '$user_id' ;") ;
		$unamerow = mysqli_fetch_array($uname) ;
		$name = $unamerow['username'] ;
		$fname = $_POST['fname'] ;
		$sname = $_POST['sname'] ;
		$email = $_POST['email'] ;
		$body2 = "Hi, ".$name." \n \n ".$username." Send Invitation To Join http://collap.com \n  \n View at \n
http://collap.com/profile.php?user_id=".$username ;
		collapMail($email, $name." Invitation To Join ", $body2) ; 
		if(mysqli_error($db_handle)) { echo "An error occured Sorry try again!"; }
		else { echo "Invitation Send Successfully !!!"; }	
}	
	else echo "Invalid parameters!";
	mysqli_close($db_handle);
?>
