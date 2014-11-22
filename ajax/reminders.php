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
						$notice .= "<p onclick='editreminder(\"".$reminderid."\",\"".$ruser_id."\")' >".$reminders. "</p><br/><p style='font-size: 10px;'>to : ".$rname."</p><hr/>";
				}		
		$data .= "<div class='dropdown'>
					<a data-toggle='dropdown'>
						<i class='glyphicon glyphicon-eye-open'></i> Reminders
				   </a>
					<ul class='dropdown-menu multi-level' style=' max-height: 300px; width: 200px; overflow: auto;'role='menu' aria-labelledby='dropdownMenu'>
						<li>".$notice."</li>
						<div class='newreminders' ></div>
					</ul>
				</div>" ;
	echo $data."+".$reminderid ;
mysqli_close($db_handle);
}
else {
	echo "invalid" ;
	}
?>
