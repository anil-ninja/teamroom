<?php

session_start();
include_once "../lib/login_signup.php";
$request = "";
if(isset($_POST['request']))
	$request = $_POST['request'];

switch($request){
	case "login":
			login();
			break;
	case "Signup":
			signup();   
			break;
	
	
	}
?>
	
