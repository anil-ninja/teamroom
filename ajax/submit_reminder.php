<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['reminder']){
	$user_id = $_SESSION['user_id'];
	$reminder = $_POST['reminder'] ;
	$self = $_POST['self'] ;
	$eventtime = $_POST['eventtime'] ;
	$timestr = time() + $eventtime ;
	//echo = $timestr ;
	$time = date("Y-m-d H:i:s", $timestr);
	//echo $time ;
	
 if (strlen($reminder) < 250) {
        mysqli_query($db_handle,"INSERT INTO reminders (user_id, person_id, reminder, time) 
                                    VALUES ('$user_id', '$self', '$reminder', '$time') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
	else { echo "Reminder Set succesfully!"; }
} else {
         echo "Max length 250 characters!"; 
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
