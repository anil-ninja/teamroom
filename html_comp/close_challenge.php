<?php
			$message = mysqli_query($db_handle, "select challenge_id from challenges where challenge_type='4' and user_id='$user_id';") ;
		if(mysqli_num_rows($message) > 0) {
		while ($messagerow = mysqli_fetch_array($message)) {
			$id = $messagerow['challenge_id'] ;
			$challange = mysqli_query($db_handle,"(select a.challenge_title, a.challenge_ETA, a.stmt, a.challenge_creation, b.ownership_creation, b.time, b.user_id, c.first_name, c.last_name 
													from challenges as a join challenge_ownership as b join user_info as c where a.challenge_id = '$id' and a.blob_id = '0'
													and a.challenge_id = b.challenge_id and b.user_id = c.user_id)
													UNION
													(select a.challenge_title, a.challenge_ETA, b.stmt, a.challenge_creation, c.ownership_creation, c.time, c.user_id, d.first_name, d.last_name
													 from challenges as a join blobs as b join challenge_ownership as c join user_info as d where a.challenge_id = '$id' and a.blob_id = b.blob_id
													 and a.challenge_id = c.challenge_id and c.user_id = d.user_id);") ;
			$challangerow = mysqli_fetch_array($challange) ;
			$accepttime = $challangerow['ownership_creation'] ;
			$eta = $challangerow['challenge_ETA'] ;
			$days = floor($eta/(24*60)) ;
			$daysecs = $eta%(24*60) ;
			$hours = floor($daysecs/(60)) ;
			$mins = $daysecs%(60);
			$etagiven = $days." Days : ".$hours." Hours : ".$mins." Minutes" ; 
			$committime = $challangerow['time'] ;
			$timecom = date("j F, g:i a",strtotime($committime));
			$starttimestr = (string) $accepttime ;
			$initialtime = strtotime($starttimestr) ;
			$endtimestr = (string) $committime ;
			$endtime = strtotime($endtimestr) ;
			$time_taken = ($endtime-$initialtime) ;
			$day = floor($time_taken/(24*60*60)) ;
			$daysec = $time_taken%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$timetaken = $day." Days :".$hour." Hours :".$minute." Min :" ;
			$answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$id' and blob_id = '0' and status = '2')
												UNION
												(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$id'and a.status = '2' and a.blob_id = b.blob_id);") ;										
			$answerrow = mysqli_fetch_array($answer) ;
			echo "<div class='list-group'>
					 <div class='list-group-item'>
						Challenged by <span class='color strong' style= 'color :#3B5998;'> You </span> On : ".date("j F, g:i a",strtotime($challangerow['challenge_creation'])).
						"<br/>ETA Given : ".$etagiven."</div><div class='list-group-item'>Accepted By <span class='color strong' style= 'color :#3B5998;'>".ucfirst($challangerow['first_name'])." ".ucfirst($challangerow['last_name']).
						"</span> and Submitted On : ".$timecom."<br/>ETA Taken : ".$timetaken."</div><div class='list-group-item'>
						<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'><p align='center'>".ucfirst($challangerow['challenge_title'])."</p></span>
						".$challangerow['stmt']."<br/>
						<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'><p align='center'>Answer</p></span>"
						.$answerrow['stmt']."<br/><form method='POST' onsubmit=\"return confirm('Really Close Challenge !!!')\">
						<div class='pull-right'><input type='hidden' name='cid' value='".$id."'/>
						<button type='submit' class='btn-primary' name='closechallenge'>Close</button></div></form><br/>";
						
			$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, b.first_name, a.response_ch_creation FROM response_challenge as a JOIN user_info as b WHERE
												  a.challenge_id = '$id' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												  UNION
												  (SELECT DISTINCT b.first_name, c.stmt, a.response_ch_creation FROM response_challenge as a JOIN user_info as b JOIN 
												  blobs as c WHERE a.challenge_id = '$id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
                        while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
				 <div class='pull-left lh-fix'>
					<img src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>&nbsp". ucfirst($fstname)."&nbsp</span><small>".$chalangeres."</small>
				</div>
			   </div> 
		     </div>";
		}
		echo "</div></div>" ;
			} 
			}
?>
