<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['chal']){
	$user_id = $_SESSION['user_id'];
	$limit = $_SESSION['lastpanel'];
	
	$a = (int)$limit ;
	
	$b = $a+5;
	
	$open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.username from challenges as a join user_info as b where (a.challenge_type = '1' or a.challenge_type = '9' or a.challenge_type = '10')
                                             and blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE (a.challenge_type = '1' or a.challenge_type = '9' or a.challenge_type = '10') and a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY challenge_creation DESC LIMIT $a,$b;");
 $show = "";
 $iR=0;
 while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
	 $i++;
		$chelange = str_replace("<s>","&nbsp;",$open_chalangerow['stmt']) ;
		$ETA = $open_chalangerow['challenge_ETA'] ;
		$ch_title = $open_chalangerow['challenge_title'] ;
		$ctype = $open_chalangerow['challenge_type'] ;
		$frstname = $open_chalangerow['first_name'] ;
		$lstname = $open_chalangerow['last_name'] ;
        $username_ch_ninjas = $open_chalangerow['username'];
		$chelangeid = $open_chalangerow['challenge_id'] ;
		$status = $open_chalangerow['challenge_status'] ;
		$times = $open_chalangerow['challenge_creation'] ;
		$timefunction = date("j F, g:i a",strtotime($times));
		$timeopen = $open_chalangerow['challenge_open_time'] ;
		$day = floor($ETA/(24*60)) ;
		$daysec = $ETA%(24*60) ;
		$hour = floor($daysec/(60)) ;
		$minute = $daysec%(60) ;
		if($ETA > 1439) {
			$sutime = $day." days" ;
		}
		else {
			if(($ETA < 1439) AND ($ETA > 59)) {
				$sutime = $hour." hours" ;	
			}
			else { $sutime = $minute." mins" ; }
		}
		$starttimestr = (string) $times ;
        $initialtime = strtotime($starttimestr) ;
		$totaltime = $initialtime+($ETA+$timeopen)*60 ;
		$completiontime = time() ;
if ($completiontime > $totaltime) { 
	$remaining_time_own = "Closed" ; }
else {	$remainingtime = ($totaltime-$completiontime) ;
		$day = floor($remainingtime/(24*60*60)) ;
		$daysec = $remainingtime%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
	if ($totaltime > ((24*60*60)-1)) {
		if($hour != 0) {
		$remaining_time_own = $day." Days and ".$hour." Hours" ;
		} else {
			$remaining_time_own = $day." Days" ;
			}
	} else {
			if (($totaltime < ((24*60*60)-1)) AND ($totaltime > ((60*60)-1))) {
				$remaining_time_own = $hour." Hours and ".$minute." Mins" ;
				} else {
					$remaining_time_own = $minute." Mins" ;
					}
		}
			
}
			$ownedby = mysqli_query($db_handle,"SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;") ;
			$ownedbyrow = mysqli_fetch_array($ownedby) ;
			$owneta = $ownedbyrow['comp_ch_ETA'] ;
			$owntime = $ownedbyrow['ownership_creation'] ;
			$timefunct = date("j F, g:i a",strtotime($owntime));
			$ownfname = $ownedbyrow['first_name'] ;
			$ownlname = $ownedbyrow['last_name'] ;
			$ownname = $ownedbyrow['username'] ;
			$dayo = floor($owneta/(24*60)) ;
		$dayseco = $owneta%(24*60) ;
		$houro = floor($daysec/(60)) ;
		$minuteo = $daysec%(60) ;
		if($owneta > 1439) {
			$timeo = $dayo." days" ;
		}
		else {
			if(($owneta < 1439) AND ($owneta > 59)) {
				$timeo = $houro." hours" ;	
			}
			else { $timeo = $minuteo." mins" ; }
		}
		$starttimestro = (string) $owntime ;
        $initialtimeo = strtotime($starttimestro) ;
		$totaltimeo = $initialtimeo+($owneta*60) ;
		$completiontimeo = time() ;
if ($completiontimeo > $totaltimeo) { 
	$remaining_time_owno = "Closed" ; }
else {	$remainingtimeo = ($totaltimeo-$completiontimeo) ;
		$dayow = floor($remainingtimeo/(24*60*60)) ;
		$daysecow = $remainingtimeo%(24*60*60) ;
		$hourow = floor($daysecow/(60*60)) ;
		$hoursecow = $daysecow%(60*60) ;
		$minuteow = floor($hoursecow/60) ;
	if ($totaltimeo > ((24*60*60)-1)) {
		if($hourow != 0) {
		$remaining_time_owno = $dayow." Days and ".$hourow." Hours" ;
		} else {
			$remaining_time_owno = $dayow." Days" ;
			}
	} else {
			if (($totaltimeo < ((24*60*60)-1)) AND ($totaltimeo > ((60*60)-1))) {
				$remaining_time_owno = $hourow." Hours and ".$minuteow." Mins" ;
				} else {
					$remaining_time_owno = $minuteow." Mins" ;
					}
		}
}
		$show .= "<div class='list-group'>
				<div class='list-group-item'>" ;
	if ($ctype == 1) {			
		if($status == 1) {
		$show = $show . "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_ch_ninjas."'>" 
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </a></span>" ;		 		
				dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
			$show = $show . "<form method='POST' class='inline-form pull-right'>
						<input type='hidden' name='id' value='".$chelangeid."'/>
						<input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
					</form>
				 &nbsp&nbsp&nbsp On : ".$timefunction."&nbsp&nbsp&nbsp with ETA : ".$sutime."<br/>".$remaining_time_own."</div>";
		}
		else {

			$show = $show . "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_ch_ninjas."'>"
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </a></span>&nbsp&nbsp On : ".$timefunction."<br/>
				Owned By  <span class='color strong'><a href ='profile.php?username=".$ownname."'>"
				. ucfirst($ownfname). '&nbsp'. ucfirst($ownlname). " </a></span>&nbsp&nbsp On : ".$timefunct." and ETA Taken : ".$timeo." <br/> Time Remaining : ".$remaining_time_owno."</div>" ;
			}
	} else if ($ctype == 9) {
		$show = $show . "Written by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_ch_ninjas."'>"
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </a></span>&nbsp&nbsp On : ".$timefunction."<br/>
				<p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>Article</b></p></div>" ;
		
		}	
		else {
			$show = $show . "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_ch_ninjas."'>" 
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </a></span>" ;		 		
				dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
			$show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
						<input type='hidden' name='id' value='".$chelangeid."'/>
						<input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
					</form>
				 &nbsp&nbsp&nbsp On : ".$timefunction."</div>";
			 
		 if ($status == 3) {		 
			$ownedb = mysqli_query($db_handle,"SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;") ;
		while ($ownedbrow = mysqli_fetch_array($ownedb)) {
			$owtime = $ownedbrow['ownership_creation'] ;
			$timfunct = date("j F, g:i a",strtotime($owtime));
			$owfname = $ownedbrow['first_name'] ;
			$owlname = $ownedbrow['last_name'] ;
			$owname = $ownedbrow['username'] ;
			$show = $show . "<div class='list-group-item'> Owned By  <span class='color strong'><a href ='profile.php?username=".$owname."'>"
				. ucfirst($owfname). '&nbsp'. ucfirst($owlname). " </a></span>&nbsp&nbsp On : ".$timfunct."</div>" ;
			}
		}
	}	
			 $show = $show . "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
			   $chelange. "<br/><br/>";
	if	($ctype == 9 && $status == 4) {	 
		$answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$chelangeid' and blob_id = '0' and status = '2')
												UNION
												(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$chelangeid' and a.status = '2' and a.blob_id = b.blob_id);") ;										
		while ($answerrow = mysqli_fetch_array($answer)) { 
			$show = $show ."<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
				<p align='center'>Answer</p></span>"
				.$answerrow['stmt']."<br/>" ;
		}  
	}
		$commenter = mysqli_query ($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
													JOIN user_info as b WHERE a.challenge_id = $chelangeid AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$chelangeid' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
	while($commenterRow = mysqli_fetch_array($commenter)) {
              $comment_id = $commenterRow['response_ch_id'];
              $challenge_ID = $commenterRow['challenge_id'];
              $username_comment_ninjas = $commenterRow['username'];
		$show = $show . "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=".$username_comment_ninjas."'>".ucfirst($commenterRow['first_name'])." ". ucfirst($commenterRow['last_name']) ."</a></span>
						&nbsp&nbsp&nbsp".$commenterRow['stmt'] ."";
				
                dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
         $show = $show . "</div></div></div>";
		}
		$show = $show . "<div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                        <form action='' method='POST' class='inline-form'>
                            <input type='hidden' value='".$chelangeid."' name='own_challen_id' />
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 87.0%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                            <button type='submit' class='btn-sm btn-primary glyphicon glyphicon-play' name='own_chl_response' ></button>
                        </form>
                    </div>";
          $show = $show . "</div> </div> "; 
        }
											
	if(mysqli_error($db_handle)) 
	{ 
		echo "Failed!"; 
	}
	else { 
		$_SESSION['lastpanel'] = $a+$i;
		echo $show ; 
		}
}
	

else echo "Invalid parameters!";
mysqli_close($db_handle);
?>
