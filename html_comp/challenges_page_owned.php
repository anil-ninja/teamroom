<div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Your Owned Challenges</h3>
                            </div>
                        </div>
                        
		<?php 
			$owned_challenges = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b where
											a.user_id = '$user_id' and blob_id = '0' and
											a.challenge_status = '2' and a.user_id = b.user_id ORDER BY challenge_creation DESC )
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c WHERE a.user_id = '$user_id' and  
											a.blob_id = c.blob_id and  a.challenge_status = '2'  and a.user_id = b.user_id ORDER BY challenge_creation DESC);");
			while ($owned_challengesRow = mysqli_fetch_array($owned_challenges)) {
				$eta = $owned_challengesRow['comp_ch_ETA'];
				$ch_title = $owned_challengesRow['challenge_title'];
				$ch_id = $owned_challengesRow['challenge_id'];
				$time = $owned_challengesRow['ownership_creation'] ;
				$ETA = $eta*60 ;
				$day = floor($ETA/(24*60*60)) ;
				$daysec = $ETA%(24*60*60) ;
				$hour = floor($daysec/(60*60)) ;
				$hoursec = $daysec%(60*60) ;
				$minute = floor($hoursec/60) ;
				$remainingtime = "to accomplish in : ".$day." Days :".$hour." Hours :".$minute." Min" ;
				$starttimestr = (string) $time ;
				$initialtime = strtotime($starttimestr) ;
				$totaltime = $initialtime+$ETA ;
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
				<div class='list-group-item'>";
		echo "<font color = '#F1AE1E'> Challenge by &nbsp <span class='color strong' style= 'color :#CAF11E;'>" .ucfirst($owned_challengesRow['first_name']). '&nbsp'. ucfirst($owned_challengesRow['last_name']). " </span> &nbsp on &nbsp".$time. " &nbsp".$remainingtime. "&nbsp&nbsp&nbsp&nbsp&nbsp Remaining Time : ".$remaining_time."</font> <br> 
				<p align='center' style='font-size: 14pt;'  ><span style= 'color :#CAF11E;'><b>".ucfirst($ch_title)."</b></span></p>
				<br/>". str_replace("<s>","&nbsp;",$owned_challengesRow['stmt'])."<br> <br>";
		$commenter = mysqli_query ($db_handle, ("(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$ch_id' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1' ORDER BY response_ch_creation ASC)
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$ch_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1' ORDER BY response_ch_creation ASC);"));
		while($commenterRow = mysqli_fetch_array($commenter)) {
			$comment_owned_id = $commenterRow['response_ch_id'];
		echo "
				<div id='commentscontainer'>
						<div class='comments clearfix'>
								<div class='pull-left lh-fix'>
										<img src='img/default.gif'>
								</div>
								<div class='comment-text'>
										<span class='pull-left color strong'>";
											echo "&nbsp". ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) .
										"</span> &nbsp&nbsp&nbsp" .$commenterRow['stmt'] ."
										<div class='list-group-item pull-right'>
											<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
											<ul class='dropdown-menu' aria-labelledby='dropdown'>
											 <li><a class='btn btn-default' href='http://bootswatch.com/default/'>Edit Challenge</a></li>
											 <li><a class='btn btn-default' id='delChallenge' cID='".$comment_id."' onclick='delChallenge(".$comment_id.");'>Delete Challenge</a></li>                   
											 <li><a class='btn btn-default' >Report Spam</a></li>
										   </ul>
									  </div>
								</div>
						</div> 
					</div>";
			}
			echo "<div class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='img/default.gif'>&nbsp
						</div>
						<form action='' method='POST' class='inline-form'>
							<input type='hidden' value='$user_id'/></td></tr>
							<input type='hidden' value='".$owned_challengesRow['challenge_id']."' name='own_challen_id' />
							<input type='text' STYLE='border: 1px solid #bdc7d8; width: auto; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
							<button type='submit' class='btn-success btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
						</form>
				</div>
			";
		echo '</tr> </div> </div> </div>';

}
?>
                        
