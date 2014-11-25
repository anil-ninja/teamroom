<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['value']){
	$user_id = $_SESSION['user_id'];
	$reminder = $_POST['reminder'] ;
	$self = $_POST['value'] ;
	$eventtime = $_POST['date'] ;
	$user = $_POST['user'] ;
	$event = $_POST['case'] ;
	$a = date("Y-m-d H:i") ;
	//echo $event ;
	$time = $eventtime.":00" ;
switch($event){ 
	case 1:
	if ($a == $eventtime){
		if (strlen($reminder) < 250) {
			mysqli_query($db_handle,"UPDATE reminders SET reminder = '$reminder' where id = '$self' and user_id = '$user_id' ;") ;
			if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
				else { echo "Changed Successfully !!!"; }
			} 
			else {
				echo "Max length 250 characters!";
				}
		}
		else {
			if (strlen($reminder) < 250) {
				mysqli_query($db_handle,"UPDATE reminders SET reminder = '$reminder', time = '$time' where id = '$self' and user_id = '$user_id' ;") ;
				if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
					else { echo "Changed Successfully !!!"; }
				} 
				else {
					echo "Max length 250 characters!";
					}
			}
	break;
	exit ;
	
	case 2:
	if (strlen($reminder) < 250) {
		mysqli_query($db_handle,"UPDATE reminders SET reminder = '$reminder' where id = '$self' and user_id = '$user_id' ;") ;
		if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
			else { echo "Changed Successfully !!!"; }
		} 
		else {
			echo "Max length 250 characters!";
			}
	break;
	exit ;
	
	case 3:
	if ($a == $eventtime){
		echo "Changed Successfully !!!";
		}
		else {
			mysqli_query($db_handle,"UPDATE reminders SET time = '$time' where id = '$self' and user_id = '$user_id' ;") ;
			if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
				else { echo "Changed succesfully!"; }
			} 
	break;
	exit ;
	
	case 4:
		mysqli_query($db_handle,"UPDATE reminders SET person_id = '$user' where id = '$self' and user_id = '$user_id' ;") ;
		if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
			else { echo "Changed Successfully !!!"; }
	break;
	exit ;
	
	case 5:
	if (strlen($reminder) < 250) {
		mysqli_query($db_handle,"UPDATE reminders SET reminder = '$reminder', person_id = '$user' where id = '$self' and user_id = '$user_id' ;") ;
		if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
			else { echo "Changed Successfully !!!"; }
		} 
		else {
			echo "Max length 250 characters!";
			}
	break;
	exit ;
	
	case 6:
	if ($a == $eventtime){
			mysqli_query($db_handle,"UPDATE reminders SET person_id = '$user' where id = '$self' and user_id = '$user_id' ;") ;
			if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
				else { echo "Changed Successfully !!!"; }
		}
		else {
			mysqli_query($db_handle,"UPDATE reminders SET person_id = '$user', time = '$time' where id = '$self' and user_id = '$user_id' ;") ;
			if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
				else { echo "Changed Successfully !!!"; }
			}
	break;
	exit ;
	
	case 7:
	if ($a == $eventtime){
		if (strlen($reminder) < 250) {
			mysqli_query($db_handle,"UPDATE reminders SET reminder = '$reminder', person_id = '$user' where id = '$self' and user_id = '$user_id' ;") ;
			if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
				else { echo "Changed Successfully !!!"; }
			} 
			else {
				echo "Max length 250 characters!";
				}
		}
		else {
			if (strlen($reminder) < 250) {
				mysqli_query($db_handle,"UPDATE reminders SET reminder = '$reminder', time = '$time', person_id = '$user' where id = '$self' and user_id = '$user_id' ;") ;
				if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
					else { echo "Changed Successfully !!!"; }
				} 
				else {
					echo "Max length 250 characters!";
					}
			}
	break;
	exit ;	
}
mysqli_close($db_handle);	
} 
else echo "Invalid parameters!";
?>
