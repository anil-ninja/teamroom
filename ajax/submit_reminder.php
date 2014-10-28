<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['reminder']){
	$user_id = $_SESSION['user_id'];
	$reminder = $_POST['reminder'] ;
	$month = $_POST['month'] ;
	$date = $_POST['date'] ;
	$hour = $_POST['hour'] ;
	$minute = $_POST['minute'] ;
	if ($minute != 0 && $hour == 0 && $date == 0 && $month == 0) {
		$m = date("i") ;
		if ($minute >= $m) {
			$time =  date("y-m-d H").":".$minute.":00" ;
		}
		else {
			$h = date("H") + 1 ;
			$time =  date("y-m-d")." ".$h.":".$minute.":00" ;
			}
	}
	else if ($hour != 0 && $date == 0 && $month == 0) {
		$hr = date("H") ;
		if ($hour >= $hr) {
			$time =  date("y-m-d")." ".$hour.":".$minute.":00" ;
		}
		else {
			$d = date("d") + 1 ;
			$time =  date("y-m")."-".$d." ".$hour.":".$minute.":00" ;	
			}
	}
	else if ($date != 0 && $month == 0) {
		$da = date("d") ;
		if ($date >= $da) {
			$time =  date("y-m")."-".$date." ".$hour.":".$minute.":00" ;
		}
		else {
			$mo = date("m") + 1 ;
			$time =  date("y")."-".$mo."-".$date." ".$hour.":".$minute.":00" ;	
			}
	}
	else {
		$mon = date("m") ;
		if ($month >= $mon) {
			$time =  date("y")."-".$month."-".$date." ".$hour.":".$minute.":00" ;
		}
		else {
			$y = date("y") + 1 ;
			$time =  $y."-".$month."-".$ddate." ".$hour.":".$minute.":00" ;	
			}
	}
 if (strlen($reminder) < 250) {
        mysqli_query($db_handle,"INSERT INTO reminders (user_id, reminder, time) 
                                    VALUES ('$user_id', '$reminder', '$time') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Set !!!!"; }
	else { echo "Reminder Set succesfully!"; }
} else {
         echo "Max length 250 characters!"; 
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
