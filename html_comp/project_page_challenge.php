<div class="panel panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"> <font color="silver">Remaining Time : <?php echo $remaining_time ; ?> </font></h3>
                        </div>
                    </div>
<?php    
		$message = mysqli_query($db_handle, "(select challenge_id from challenges where challenge_type='4' and user_id='$user_id');") ;
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
			$starttimestr = (string) $accepttime ;
			$initialtime = strtotime($starttimestr) ;
			$endtimestr = (string) $committime ;
			$endtime = strtotime($endtimestr) ;
			$time_taken = ($endtime-$initialtime) ;
			$day = floor($time_taken/(24*60*60)) ;
			$daysec = $time_taken%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ; //sudo apt-get install git
			$sec = $hoursec%60 ;
			$timetaken = $day." Days :".$hour." Hours :".$minute." Min :".$sec." "."Secs" ;
			$answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$id' and blob_id = '0')
												UNION
												(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$id' and a.blob_id = b.blob_id);") ;										
			$answerrow = mysqli_fetch_array($answer) ;
			echo "<div class='panel-body'>
					<div class='list-group'>
					 <div class='list-group-item'>
						Challenged by <span class='color strong' style= 'color :lightblue;'> You </span> On : ".$challangerow['challenge_creation'].
						"<br/>ETA Given : ".$etagiven."</div><div class='list-group-item'>Accepted By <span class='color strong' style= 'color :lightblue;'>".ucfirst($challangerow['first_name'])." ".ucfirst($challangerow['last_name']).
						"</span> and Submitted On : ".$committime."<br/>ETA Taken : ".$timetaken."</div><div class='list-group-item'>
						<span class='color strong' style= 'color :lightblue;font-size: 14pt;'><p align='center'>".ucfirst($challangerow['challenge_title'])."</p></span>
						".$challangerow['stmt']."<br/>
						<span class='color strong' style= 'color :lightblue;font-size: 14pt;'><p align='center'>Answer</p></span>"
						.$answerrow['stmt']."</div></div></div>";
			} 
			}
                                                                              
      $display = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b where
											a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and blob_id = '0' and
											a.challenge_status != '2' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c WHERE a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and 
											a.blob_id = c.blob_id and  a.challenge_status != '2'  and a.user_id = b.user_id) ORDER BY challenge_creation DESC  ;");
      while ($displayrow = mysqli_fetch_array($display)) {
			$chalangest = $displayrow['stmt'] ;
			$chalangetime = $displayrow['challenge_creation'] ;
			$opentime = $displayrow['challenge_open_time,'] ;
			$idb = $displayrow['challenge_id'] ;
			$ch_title = $displayrow['challenge_title'] ;
			$ETA = $displayrow['challenge_ETA'] ;
			$fname = $displayrow['first_name'] ;
			$lname = $displayrow['last_name'];
			$phonenom = $displayrow['contact_no'] ;
			$eid = $displayrow['email'] ;							
			$eta = $ETA*60 ;
			$day = floor($eta/(24*60*60)) ;
			$daysec = $eta%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remainingtime = $day." Days :".$hour." Hours :".$minute." Min" ;
			$starttimestr = (string) $chalangetime ;
			$initialtime = strtotime($starttimestr) ;
			$totaltime = $initialtime+$eta+($opentime*60) ;
			$completiontime = time() ;
		if ($completiontime > $totaltime) { 
			$remaining_time = "Time over" ; }
	else {	$remaintime = ($totaltime-$completiontime) ;
			$day = floor($remaintime/(24*60*60)) ;
			$daysec = $remaintime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$sec = $hoursec%60 ;
			$remaining_time = $day." Days :".$hour." Hours :".$minute." Min :".$sec." "."Secs" ;
		}	
	echo "<div class='panel-body'>
					<div class='list-group'>
						<div class='list-group-item'>
						<form method='POST' class='inline-form pull-right'>
					<input type='hidden' name='id' value='".$idb."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept Challenge'/>
					</form>";
      dropDown_challenge($db_handle, $idb, $user_id, $remaining_time);
	  
      echo "Created by &nbsp <span class='color strong' style= 'color :lightblue;'>
				: ".ucfirst($fname). '&nbsp'.ucfirst($lname)." </span><br/> ETA : ".$remainingtime." <br/> Challenge Created 
				ON :".$chalangetime. "<br/> and Remaining Time : ".$remaining_time."<br/>";
   	echo "<p align='center' style='font-size: 14pt;'  ><span style= 'color :lightblue;'><b>".ucfirst($ch_title)."</b></span></p><br/>
				<small>".str_replace("<s>","&nbsp;",$chalangest)."</small><br> <br>";
		$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$idb' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.response_ch_creation, a.user_id, b.first_name, b.last_name, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$idb' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp". ucfirst($fstname)."&nbsp".
					"</span><small>".$chalangeres."</small>";
					dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
				echo "</div>
			</div> 
		</div>";
		}
		echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='img/default.gif'> &nbsp
                        </div>
			<form class='inline-form' action='' method='POST'>
                            <input type='hidden' value='".$idb."' name='challenge_id' />
                            <input type='text' STYLE=' border: 1px solid #bdc7d8; width: 300px; height: 30px;' name='pr_resp' placeholder='Whats on your mind about this challenge'/>
                            <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='response'></button>
			</form>
                    </div>";
	echo "</div> </div> </div>";
	}
	 $displayd = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_creation, a.stmt, c.user_id, c.comp_ch_ETA ,c.ownership_creation,
                                            b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b join challenge_ownership as c where a.challenge_id=c.challenge_id and
											a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and a.blob_id = '0'  and b.user_id = c.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_creation, d.user_id, d.comp_ch_ETA ,d.ownership_creation, c.stmt,
											b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c join challenge_ownership as d WHERE a.challenge_id=d.challenge_id and (a.challenge_type = '1' OR a.challenge_type = '2') and a.project_id = '$p_id'  and 
											a.blob_id = c.blob_id and b.user_id = d.user_id) ;");
      while ($displayrowd = mysqli_fetch_array($displayd)) {
			$stmt = $displayrowd['stmt'] ;
			$chalangetime = $displayrowd['challenge_creation'] ;
			$timecreataion = $displayrowd['ownership_creation'] ;
			$idd = $displayrowd['challenge_id'] ;
			$ch_title = $displayrowd['challenge_title'] ;
			$ETA = $displayrowd['comp_ch_ETA'] ;
			$id = $displayrowd['user_id'] ;
			$fnamer = $displayrowd['first_name'] ;
			$lnamer = $displayrowd['last_name'];
			$eta = $ETA*60 ;
			$day = floor($eta/(24*60*60)) ;
			$daysec = $eta%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remainingtimer = $day." Days :".$hour." Hours :".$minute." Min" ;
			$starttimestr = (string) $timecreataion ;
			$initialtime = strtotime($starttimestr) ;
			$totaltime = $initialtime+$eta ;
			$completiontime = time() ;
		if ($completiontime > $totaltime) { 
			$remaining_time_own = "Time over" ; }
	else {	$remaintime = ($totaltime-$completiontime) ;
			$day = floor($remaintime/(24*60*60)) ;
			$daysec = $remaintime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$sec = $hoursec%60 ;
			$remaining_time_own = $day." Days :".$hour." Hours :".$minute." Min :".$sec." "."Secs" ;
		}	
	echo "<div class='panel-body'>
					<div class='list-group'>
						<div class='list-group-item'>";
	if($id==$user_id) {			
			echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='".$idd."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
					</form>";
				}
      echo "<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>                   
                     <li><a class='btn btn-default' >Report Spam</a></li>
                   </ul>
              </div>
            </div>";
	  echo "Created by &nbsp <span class='color strong' style= 'color :lightblue;'>
				: ".ucfirst($fname). '&nbsp'.ucfirst($lname)." </span><br/> Challenge Created 
				ON :".$chalangetime. "<br/>Owned By : <span class='color strong' style= 'color :lightblue;'>"
			  .ucfirst($fnamer). '&nbsp'. ucfirst($lnamer)."</span><br/>ETA taken : ".$remainingtimer. "<br/> Remaining Time : ".$remaining_time_own.
			  "<br/><br/><p align='center' style='font-size: 14pt; color :lightblue;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
			   $stmt. "</font><br/>" ;
			   
		$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$idd' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$idd' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp". ucfirst($fstname)."&nbsp".
					"</span><small>".$chalangeres."</small>
					<div class='list-group-item pull-right'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>
                     <li><a class='btn btn-default' href='#'>Edit Challenge</a></li>
                     <li><a class='btn btn-default' id='delChallenge' cID='".$comment_id."' onclick='delChallenge(".$comment_id.");'>Delete Challenge</a></li>                   
                     <li><a class='btn btn-default' >Report Spam</a></li>
                   </ul>
              </div>
				</div>
			</div> 
		</div>";
		}
		echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='img/default.gif'> &nbsp
                        </div>
			<form class='inline-form' action='' method='POST'>
                            <input type='hidden' value='".$idd."' id='challenge_id' />
                            <input type='text' STYLE=' border: 1px solid #bdc7d8; width: 300px; height: 30px;' id='pr_resp' placeholder='Whats on your mind about this challenge'/>
                            <button type='submit' class='btn-success btn-sm glyphicon glyphicon-play' id='response'></button>
			</form>
                    </div>";
	echo "</div> </div> </div>";
	}
?>

