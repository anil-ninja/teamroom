<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/collapMail.php';
if($_POST['fname']){
	$user_id = $_SESSION['user_id'] ;
	$username = $_SESSION['username'];
	$pro_id = $_SESSION['project_id'] ;
	$uname = mysqli_query($db_handle,"select * from user_info where user_id = '$user_id' ;") ;
	$unamerow = mysqli_fetch_array($uname) ;
	$name = $unamerow['username'] ;
	$senderfname = $unamerow['first_name'] ;
	$senderlname = $unamerow['last_name'] ;
	$fname = $_POST['fname'] ;
	$sname = $_POST['sname'] ;
	$email = $_POST['email'] ;
	$team = $_POST['team'] ;
	$password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);;
    mysqli_query($db_handle,"INSERT INTO user_info (first_name, last_name, email, username, password) 
                                    VALUES ('$fname', '$sname', '$email', '$password', '$password') ; ") ;
    $newuserid = mysqli_insert_id($db_handle);
	$body2 = "Hi, ".$fname." ".$sname." \n \n ".$senderfname." ".$senderlname." added You in team n View at \n
To know details login to http://collap.com/. \n \n
            Username: ".$email." \n \n
            Password: ".$password ;
	collapMail($email, " Invitation To Join ", $body2) ; 
	mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, project_id) VALUES ('$newuserid', '$team', '$pro_id');");
	if(mysqli_error($db_handle)) { echo "An error occured Sorry try again!"; }
	else { echo "Invitation Send Successfully !!!"; }	
}	
	else echo "Invalid parameters!";
	mysqli_close($db_handle);
?>
