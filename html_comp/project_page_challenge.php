<div class="panel panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"> <font color="silver">Remaining Time : <?php echo $remaining_time ; ?> </font></h3>
                        </div>
                    </div>
<?php                                                                                  
      $display = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b where
											a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and blob_id = '0' and
											a.challenge_status != '2' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c WHERE a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and 
											a.blob_id = c.blob_id and  a.challenge_status != '2'  and a.user_id = b.user_id) ORDER BY challenge_creation DESC  ;");
      while ($displayrow = mysqli_fetch_array($display)) {
			$chalangest = $displayrow['stmt'] ;
			$chalangetime = $displayrow['challenge_creation'] ;
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
			$totaltime = $initialtime+$eta ;
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
        // ANIl update $remaining_time with remaining time ETA in function below AND DELETE this comment after doing this..hope you do so...
      dropDown_challenge($db_handle, $idb, $user_id, $remaining_time);
	  
      echo "<font color = '#F1AE1E'> Created by &nbsp <span class='color strong' style= 'color :#CAF11E;'>
				: ".ucfirst($fname). '&nbsp'.ucfirst($lname)." </span><br/> ETA : ".$remainingtime." <br/> Challenge Created 
				ON :".$chalangetime. "<br/> and Remaining Time : ".$remaining_time."</font><br/>";
   	echo "<p align='center' style='font-size: 14pt;'  ><span style= 'color :#CAF11E;'><b>".ucfirst($ch_title)."</b></span></p><br/>
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
	 $displayd = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b where
											a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and blob_id = '0' and
											a.challenge_status = '2' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c WHERE a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and 
											a.blob_id = c.blob_id and  a.challenge_status = '2'  and a.user_id = b.user_id) ORDER BY challenge_creation DESC ;");
      while ($displayrowd = mysqli_fetch_array($displayd)) {
			$stmt = $displayrowd['stmt'] ;
			$chalangetime = $displayrowd['challenge_creation'] ;
			$idd = $displayrowd['challenge_id'] ;
			$ch_title = $displayrowd['challenge_title'] ;
			$ETA = $displayrowd['challenge_ETA'] ;
			$fnamer = $displayrowd['first_name'] ;
			$lnamer = $displayrowd['last_name'];
			$eta = $ETA*60 ;
			$day = floor($eta/(24*60*60)) ;
			$daysec = $eta%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remainingtimer = $day." Days :".$hour." Hours :".$minute." Min" ;
			$starttimestr = (string) $chalangetime ;
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
      echo "<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>
                     <li><a class='btn btn-default' href='#'>Edit Challenge</a></li>
                     <li><a class='btn btn-default' id='delChallenge' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete Challenge</a></li>
                     <li><a class='btn btn-default' >Change ETA</a></li>                    
                     <li><a class='btn btn-default' >Report Spam</a></li>
                   </ul>
              </div>
            </div>";
	  echo "<font color = '#F1AE1E'> Created by &nbsp <span class='color strong' style= 'color :#CAF11E;'>
				: ".ucfirst($fname). '&nbsp'.ucfirst($lname)." </span>&nbsp&nbsp&nbsp ETA : ".$remainingtime." &nbsp Challenge Created 
				ON :".$chalangetime. "<br/>Owned By : <span class='color strong' style= 'color :#CAF11E;'>"
			  .ucfirst($fnamer). '&nbsp'. ucfirst($lnamer)."</span> &nbsp&nbsp".$remainingtimer. "&nbsp&nbsp&nbsp Remaining Time : ".$remaining_time_own.
			  "</font><br/><br/><p align='center' style='font-size: 14pt; color :#CAF11E;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
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
                            <input type='button' value='".$idd."' id='challenge_id' />
                            <input type='text' STYLE=' border: 1px solid #bdc7d8; width: 300px; height: 30px;' id='pr_resp' placeholder='Whats on your mind about this challenge'/>
                            <button type='submit' class='btn-success btn-sm glyphicon glyphicon-play' id='response'></button>
			</form>
                    </div>";
	echo "</div> </div> </div>";
	}
?>

