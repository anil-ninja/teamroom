<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/collapMail.php';
if($_POST['chat']){
	$username = $_SESSION['username'] ;
	$data = mysqli_query($db_handle,"SELECT * FROM user_info WHERE user_id = '8' ;") ;
	$dataRow = mysqli_fetch_array($data) ;
	$Userid = $dataRow ['user_id'] ;
	$userName = $dataRow ['username'] ;
	$lastTime = $dataRow ['last_login'] ;
	$onTime = time() - strtotime($lastTime) ;
	if ($onTime < 600) {
		echo $userName ;
	}
	else {
		$data1 = mysqli_query($db_handle,"SELECT * FROM user_info WHERE user_id = '12' ;") ;
		$data1Row = mysqli_fetch_array($data1) ;
		$Userid1 = $data1Row ['user_id'] ;
		$userName1 = $data1Row ['username'] ;
		$lastTime1 = $data1Row ['last_login'] ;
		$onTime1 = time() - strtotime($lastTime1) ;
		if ($onTime1 < 600) {
			echo $userName1 ;
		}
		else {
			$data2 = mysqli_query($db_handle,"SELECT * FROM user_info WHERE user_id = '11' ;") ;
			$data2Row = mysqli_fetch_array($data2) ;
			$Userid2 = $data2Row ['user_id'] ;
			$userName2 = $data2Row ['username'] ;
			$lastTime2 = $data2Row ['last_login'] ;
			$onTime2 = time() - strtotime($lastTime2) ;
			if ($onTime2 < 600) {
				echo $userName2 ;
			}
			else {
				$data3 = mysqli_query($db_handle,"SELECT * FROM user_info WHERE user_id = '7' ;") ;
				$data3Row = mysqli_fetch_array($data3) ;
				$Userid3 = $data3Row ['user_id'] ;
				$userName3 = $data3Row ['username'] ;
				$lastTime3 = $data3Row ['last_login'] ;
				$onTime3 = time() - strtotime($lastTime3) ;
				if ($onTime3 < 600) {
					echo $userName3 ;
				}
				else {
					$body = $username." wants assitant in collap. Reply ASAP . <a href='http://collap.com/profile.php?username=".$username."' class='btn-primary'>Click Here to View</a>" ;
					collapMail("kumar.anil8892@gmail.com", "Assistent Needed", $body);
					collapMail("rahul_lahoria@yahoo.com", "Assistent Needed", $body);
					collapMail("neerajdexter@gmail.com", "Assistent Needed", $body);
					collapMail("rajnish_pawar90@yahoo.com", "Assistent Needed", $body);
					echo "Assitant" ;
				}
			}
		}
	}
}
mysqli_close($db_handle);
?>
