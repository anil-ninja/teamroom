<?php    
		include_once 'html_comp/close_challenge.php' ;
		$tasks = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.stmt, a.challenge_creation, c.user_id, b.first_name, b.last_name, b.username
											FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE a.project_id = '$p_id' AND a.challenge_type = '8'
											AND a.blob_id = '0' AND c.user_id = b.user_id AND a.challenge_id = c.challenge_id)
											UNION
										 (SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, c.stmt, a.challenge_creation, d.user_id, b.first_name, b.last_name, b.username
											FROM challenges AS a JOIN user_info AS b JOIN blobs AS c JOIN challenge_ownership AS d WHERE a.project_id = '$p_id'
											AND a.challenge_type = '8' AND a.blob_id = c.blob_id AND d.user_id = b.user_id AND a.challenge_id = d.challenge_id);");
		while ($tasksrow = mysqli_fetch_array($tasks)) {
			$username_task = $tasksrow['username'];
			$id_task = $tasksrow['challenge_id'];
			$userid_task = $tasksrow['user_id'];
			$title_task = $tasksrow['challenge_title'];
			$eta_task = $tasksrow['challenge_ETA'];
			$creation_task = $tasksrow['challenge_creation'];
			$timetask = date("j F, g:i a",strtotime($creation_task));
			$stmt_task = $tasksrow['stmt'];
			$fname_task = $tasksrow['first_name'];
			$lname_task = $tasksrow['last_name'];
			$day = floor($eta_task/(24*60)) ;
			$daysec = $eta_task%(24*60) ;
			$hour = floor($daysec/(60)) ;
			$minute = $daysec%(60) ;
			$remainingtime = $day." Days :".$hour." Hours :".$minute." Min" ;
			$starttimestr = (string) $creation_task ;
			$initialtime = strtotime($starttimestr) ;
			$totaltime = $initialtime+($eta_task*60) ;
			$completiontime = time() ;
		if ($completiontime > $totaltime) { 
			$remaining_time = "Closed" ; }
	else {	$remaintime = ($totaltime-$completiontime) ;
			$day = floor($remaintime/(24*60*60)) ;
			$daysec = $remaintime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remaining_time = "Remaining Time : ".$day." Days :".$hour." Hours :".$minute." Min " ;
		}	
			echo "<div class='list-group'>
						<div class='list-group-item'>";
	      echo "<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>                   
                     <li><button class='btn-link' >Report Spam</button></li>
                   </ul>
              </div>
            </div>";
       if($userid_task==$user_id) {			
			echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='".$id_task."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
					</form>";
				}
	echo "Task Assigned by &nbsp <span class='color strong' style= 'color :#3B5998;'>".ucfirst($name)."</a></span> On ".$timetask."<br/>
			Task Assigned To &nbsp <span class='color strong' style= 'color :#3B5998;'>".ucfirst($fname_task)." ".ucfirst($lname_task)."</a> </span>
					<br/> ETA Given : ".$remainingtime." <br/>".$remaining_time."<br/>";
   	echo "<p align='center' style='font-size: 14pt;'  ><span style= 'color :#3B5998;'><b>".ucfirst($title_task)."</b></span></p><br/>
				<small>".str_replace("<s>","&nbsp;",$stmt_task)."</small><br> <br>";
			
	$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
                $lstname = $displayrowb['last_name'];
                $username_commenter_pr_ch = $displayrowb['username'];
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_commenter_pr_ch.jpg'  onError=this.src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp<a href ='profile.php?username=".$username_commenter_pr_ch."'>". ucfirst($fstname)."&nbsp".$lstname."</a>&nbsp".
					"</span><small>".$chalangeres."</small>";
					dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
				echo "</div>
			</div> 
		</div>";
		}
		echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                        <form action='' method='POST' class='inline-form'>
                                <input type='hidden' value='".$id_task."' name='own_challen_id' />
                                <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                        </form>
                    </div>";
	echo "</div> </div>";		
			
			
			}
                                                                              
      $display = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name,b.username, b.contact_no,b.email from challenges as a join user_info as b where
											a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and blob_id = '0' and
											a.challenge_status != '2' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.username, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c WHERE a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and 
											a.blob_id = c.blob_id and  a.challenge_status != '2'  and a.user_id = b.user_id) ORDER BY challenge_creation DESC  ;");
      while ($displayrow = mysqli_fetch_array($display)) {
          $username_pr_ch_cr = $displayrow['username'];
			$chalangest = $displayrow['stmt'] ;
			$chalangetime = $displayrow['challenge_creation'] ;
			$timech = date("j F, g:i a",strtotime($chalangetime));
			$opentime = $displayrow['challenge_open_time'] ;
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
			$remaining_time = "Closed" ; }
	else {	$remaintime = ($totaltime-$completiontime) ;
			$day = floor($remaintime/(24*60*60)) ;
			$daysec = $remaintime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remaining_time = "Remaining Time : ".$day." Days :".$hour." Hours :".$minute." Min " ;
		}	
	echo "<div class='list-group'>
						<div class='list-group-item'>";
      dropDown_challenge($db_handle, $idb, $user_id, $remaining_time);
	  
      echo "Created by &nbsp <span class='color strong' style= 'color :#3B5998;'>
				: <a href ='profile.php?username=".$username_pr_ch_cr."'>".ucfirst($fname). '&nbsp'.ucfirst($lname)."</a> </span>
				<form method='POST' class='inline-form pull-right'>
					<input type='hidden' name='id' value='".$idb."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
					</form><br/> ETA : ".$remainingtime." <br/> Challenge Created 
				ON :".$timech. "<br/>".$remaining_time."<br/>";
   	echo "<p align='center' style='font-size: 14pt;'  ><span style= 'color :#3B5998;'><b>".ucfirst($ch_title)."</b></span></p><br/>
				<small>".str_replace("<s>","&nbsp;",$chalangest)."</small><br> <br>";
		$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$idb' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$idb' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
                                $lstname = $displayrowb['last_name'];
                                $username_commenter_pr_ch = $displayrowb['username'];
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_commenter_pr_ch.jpg'  onError=this.src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp<a href ='profile.php?username=".$username_commenter_pr_ch."'>". ucfirst($fstname)."&nbsp".$lstname."</a>&nbsp".
					"</span><small>".$chalangeres."</small>";
					dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
				echo "</div>
			</div> 
		</div>";
		}
		echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
						<form action='' method='POST' class='inline-form'>
							<input type='hidden' value='".$idb."' name='own_challen_id' />
							<input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
							<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
						</form>
                    </div>";
	echo "</div> </div>";
	}
	 $displayd = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_creation, a.stmt, c.user_id, c.comp_ch_ETA ,c.ownership_creation,
                                            b.first_name, b.last_name,b.username, b.contact_no,b.email from challenges as a join user_info as b join challenge_ownership as c where a.challenge_id=c.challenge_id and
											a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and a.blob_id = '0'  and b.user_id = c.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_creation, d.user_id, d.comp_ch_ETA ,d.ownership_creation, c.stmt,
											b.first_name, b.last_name,b.username, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c join challenge_ownership as d WHERE a.challenge_id=d.challenge_id and (a.challenge_type = '1' OR a.challenge_type = '2') and a.project_id = '$p_id'  and 
											a.blob_id = c.blob_id and b.user_id = d.user_id) ;");
      while ($displayrowd = mysqli_fetch_array($displayd)) {
          $username_pr_ch = $displayrowd['username'];
			$stmt = $displayrowd['stmt'] ;
			$chalangetimer = $displayrowd['challenge_creation'] ;
			$timecha = date("j F, g:i a",strtotime($chalangetimer));
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
			$remaining_time_own = "Closed" ; }
	else {	$remaintime = ($totaltime-$completiontime) ;
			$day = floor($remaintime/(24*60*60)) ;
			$daysec = $remaintime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$sec = $hoursec%60 ;
			$remaining_time_own = "Remaining Time : ".$day." Days :".$hour." Hours :".$minute." Min " ;
		}	
	echo "<div class='list-group'>
						<div class='list-group-item'>";
	      echo "<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>                   
                     <li><button class='btn-link' >Report Spam</button></li>
                   </ul>
              </div>
            </div>";
       if($id==$user_id) {			
			echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='".$idd."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
					</form>";
				}
	  echo "Created by &nbsp <span class='color strong' style= 'color :#3B5998;'>
				: <a href ='profile.php?username=".$username_pr_ch_cr."'>".ucfirst($fname). '&nbsp'.ucfirst($lname)."</a> </span><br/> Challenge Created 
				ON :".$timecha. "<br/>Owned By : <span class='color strong' style= 'color :#3B5998;'><a href ='profile.php?username=".$username_pr_ch."'>"
			  .ucfirst($fnamer). '&nbsp'. ucfirst($lnamer)."</a></span><br/>ETA taken : ".$remainingtimer. "<br/>".$remaining_time_own.
			  "<br/><br/><p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
			   $stmt. "</font><br/>" ;
			   
		$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$idd' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$idd' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
   
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
                    $username_commenter_pr_ch_owned = $displayrowb['username'];
				$fstname = $displayrowb['first_name'] ;
                                $lstname = $displayrowb['last_name'];
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_commenter_pr_ch_owned.jpg'  onError=this.src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp<a href ='profile.php?username=".$username_commenter_pr_ch_owned."'>". ucfirst($fstname)."&nbsp".ucfirst($lstname).
					"&nbsp</a></span><small>".$chalangeres."</small>";
	              dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
			echo "</div>
			</div> 
		</div>";
		}
		echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
			<form action='' method='POST' class='inline-form'>
							<input type='hidden' value='".$idd."' name='own_challen_id' />
							<input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
							<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
						</form>
                    </div>";
	echo "</div> </div>";
	}
?>
