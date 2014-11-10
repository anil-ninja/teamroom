<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['fname']){
		$user_id = $_SESSION['user_id'] ;
	$uname = mysqli_query($db_handle,"select * from user_info where user_id = '$user_id' ;") ;
		$unamerow = mysqli_fetch_array($uname) ;
		$name = $unamerow['first_name'] ;
		$fname = $_POST['fname'] ;
		$sname = $_POST['sname'] ;
		$email = $_POST['email'] ;
	 $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
    
    mysqli_query($db_handle,"INSERT INTO user_info
                                    (first_name, last_name, email, username, password) 
                                    VALUES 
                                    ('$fname', '$sname', '$email', '$password', '$password') ; ") ;
    
    if(mail($email,$name+" have share bill with you.","Hi,\n ".$name." have share bill with you.\n
            To know details login to http://54.64.1.52/Mybill/.\n
            Username: ".$email."\n
            Password: ".$password)){         
		if(mysqli_error($db_handle)) { echo "An error occured Sorry try again!"; }
		else { echo "Invitation Send Successfully !!!"; }
}
	
}	
	else echo "Invalid parameters!";
	mysqli_close($db_handle);
?>
