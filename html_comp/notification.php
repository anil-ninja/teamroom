<div class='dropdown'>
					<a data-toggle='dropdown'><p class='navbar-text' style ='cursor: pointer; color: red;'>
							 <i class='glyphicon glyphicon-bell'></i><span class='badge'>
			<?php
				$count = mysqli_query($db_handle, " select Distinct time from reminders where person_id = '$user_id';") ;
				$y = 0 ;
				while ($countrow = mysqli_fetch_array($count)) {
					$count_time = $countrow['time'] ;
					$startingtime = strtotime($count_time) ;
					$endtimecount = time() ;
					if ($endtimecount <= $startingtime) {
						$timeleftcount = $startingtime - $endtimecount ;
					} else {
						$timeleftcount = $startingtime ;
						}
					if ($timeleftcount < 600 && $timeleftcount > 0) {
						$y++ ;
					}
				}
				echo $y ;
				?>
				</span>
				</p></a>
					<ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>
				<?php 					
				$reminder = mysqli_query($db_handle, " select Distinct user_id, reminder, creation_time, time from reminders where person_id = '$user_id';") ;
				while ($reminderrow = mysqli_fetch_array($reminder)) {
					$reminders = $reminderrow['reminder'] ;
					$ruser_id = $reminderrow['user_id'] ;
					if (strlen($reminders) > 20) {
						$rtitle = substr(ucfirst($reminders), 0, 20) . "....";
					}
						else {
						$rtitle = ucfirst($reminders);
						}
					$remindby = mysqli_query($db_handle, " select first_name, last_name from user_info where user_id = '$ruser_id' ;") ;
					$remindbyrow = mysqli_fetch_array($remindby) ;
					if ($ruser_id == $user_id) {
						$rname = "Remind By : You" ;
						}
						else {
							$rname = "Remind By : ".$remindbyrow['first_name']." ".$remindbyrow['last_name'] ;
							}
					$tooltip = strtoupper($reminders)." ".$rname ;
					$creation_time = $reminderrow['creation_time'] ;
					$reminder_time = $reminderrow['time'] ;
					$createdon = date("j F, g:i a", strtotime($creation_time));
					$starttime = strtotime($reminder_time) ;
					$endtime = time() ;
					if ($endtime <= $starttime) {
						$timeleft = $starttime - $endtime ;
					}
						else {
							$timeleft = $starttime ;
							}
					if ($timeleft < 600 && $timeleft > 0) {
						echo "<li><button class='btn-link' data-toggle='tooltip' data-placement='bottom' data-original-title='" .$tooltip."' >
									<b>" .$rtitle. "</b><p style='font-size:8pt; color:rgba(161, 148, 148, 1); text-align: left;'>
									" . $createdon . "</p></button></li>" ;
						
						}
				}
                ?>
					</ul> 
				</div>
