<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['reminder']) {
    $a = date("Y-m-d H:i:s") ;
   // echo $a ;
	 $user_id = $_SESSION['user_id'] ;
	 $notice = "" ;
	  $data = "" ;
	  $notice1 = mysqli_query($db_handle, " select Distinct a.id, a.person_id, a.reminder, a.time, b.first_name from reminders as a join user_info
											as b where a.user_id = '$user_id' and a.person_id = b.user_id and a.time > '$a' and a.time != '$a' ;") ;
				while ($notice1row = mysqli_fetch_array($notice1)) {
					$reminders = $notice1row['reminder'] ;
					$reminderid = $notice1row['id'] ;
					$ruser_id = $notice1row['person_id'] ;
					if ($ruser_id == $user_id) {
						$rname = "Self" ;
						}
						else {
							$rname = $notice1row['first_name'] ;
							}
						$notice .= "<p style = 'font-size:11px'><strong>To : ".$rname."</strong>
									<a onclick='editreminder(\"".$reminderid."\",\"".$ruser_id."\")' style = 'cursor:pointer;'>
									<i class = 'icon-pencil pull-right '></i></a></p>
									<p style = 'font-size:11px'>
									".$reminders. "
									</p><br/>";
				}		
		$data .= "<div class='panel-body '>
					".$notice."<div class='newreminders' ></div>
				</div>" ;
	echo $data."+".$reminderid ;
mysqli_close($db_handle);
}
else {
	echo "invalid" ;
	}
?>
