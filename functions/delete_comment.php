<?php 
function dropDown_delete_comment($deleteid, $user_ID, $owner_id, $type) {
    echo  "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
			if($owner_id == $user_ID) {
				echo "<li><button class='btn-link' onclick='delcomment(\"".$deleteid."\",\"".$type."\");'>Delete</button></li>";
			} 
			else {
			   echo "<li><button class='btn-link' onclick='spem(\"".$deleteid."\",\"".$type."\");'>Report Spam</button></li>";
			}
                echo "</ul>
        </div>";
}

function dropDown_challenge($challenge_ID, $user_ID, $remaining_time_ETA_over, $owner_id, $type) {
        echo "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    if($owner_id == $user_ID) {
                        echo "<li><button class='btn-link' onclick='edit_content(\"".$challenge_ID."\",\"".$type."\")'>Edit</button></li>
                              <li><button class='btn-link' onclick='delChallenge(\"".$challenge_ID."\",\"".$type."\");'>Delete</button></li>";                    
                      /*  if($remaining_time_ETA_over == 'Time over') {        
                            echo "<li>
                                    <form method='POST' class='inline-form'>
                                        <input type='hidden' name='id' value='".$challenge_ID."'/>
                                        <input class='btn-link' type='submit' name='eta' value='Change ETA'/>
                                    </form>
                                </li>";
                        } */                                   
                     }
                    else {
                       echo "<li><button class='btn-link' onclick='spem(\"".$challenge_ID."\",\"".$type."\");'>Report Spam</button></li>";
                    } 
               echo "</ul>
              </div>";
}
function dropDown_delete_after_accept($challenge_ID, $user_ID, $owner_id, $type) {
    if($owner_id == $user_ID) {
        echo "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>
                    <li><button class='btn-link' onclick='edit_content(\"".$challenge_ID."\",\"".$type."\")'>Edit</button></li>
                    <li><button class='btn-link' onclick='delChallenge(\"".$challenge_ID."\",\"".$type."\");'>Delete</button></li>
                </ul>
            </div>";                    
    }
}
function eta($eta){
	$day = floor($eta/(24*60)) ;
	$daysec = $eta%(24*60) ;
	$hour = floor($daysec/(60)) ;
	$minute = $daysec%(60) ;
if($eta > 1439) {
		$time = $day." days" ;
		return $time ;
	}
	else {
		if(($eta < 1439) AND ($eta > 59)) {
			$time = $hour." hours" ;
			return $time ;	
		}
		else { 
			$time = $minute." mins" ;
			return $time ;
		 }
}
}
function remaining_time($creationtime, $eta) {
		$initialtime = strtotime($creationtime) ;
		$totaltime = $initialtime+($eta*60) ;
		$completiontime = time() ;
 if ($completiontime > $totaltime) { 
	  $remaining_time = "Closed" ;
	  return $remaining_time ; 
	  }
	else {	
			$remainingtime = ($totaltime-$completiontime) ;
			$day = floor($remainingtime/(24*60*60)) ;
			$daysec = $remainingtime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
		if ($remainingtime > ((24*60*60)-1)) {
			if($hour != '0') {
				$remaining_time = $day." Days and ".$hour." Hours" ;
				return $remaining_time ;
			} 
			else {
				$remaining_time = $day." Days" ;
				return $remaining_time ;
				}
			} 
		else {
			if (($remainingtime < ((24*60*60)-1)) AND ($remainingtime > ((60*60)-1))) {
				$remaining_time = $hour." Hours and ".$minute." Mins" ;
				return $remaining_time ;
				} 
				else {
					$remaining_time = $minute." Mins" ;
					return $remaining_time ;
					}
		}
	}
}
function events($db_handle,$user_ID,$type,$id){
	 mysqli_query($db_handle,"insert into events (event_creater, event_type, p_c_id) VALUES ('$user_ID', '$type', '$id') ;") ;
	}
function involve_in($db_handle,$user_ID,$type,$id){
	 mysqli_query($db_handle,"insert into involve_in (user_id, p_c_id, p_c_type) VALUES ('$user_ID', '$id', '$type') ;") ;
	}
?>
