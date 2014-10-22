
    <div class="panel-heading">
        <h3 class="panel-title">Your Owned Challenges</h3>
    </div>
                        
		<?php 

			$owned_challenges = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.stmt, a.challenge_creation,a.challenge_ETA, c.comp_ch_ETA, c.ownership_creation,
                                            b.first_name, b.last_name, b.username from challenges as a join user_info as b join challenge_ownership as c where
											a.user_id = '$user_id' and a.blob_id = '0' and a.challenge_id = c.challenge_id and c.status = '1' and
											a.challenge_status = '2' and c.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title,a.challenge_ETA, c.stmt, a.challenge_creation, d.comp_ch_ETA, d.ownership_creation,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c join challenge_ownership as d
											 WHERE a.user_id = '$user_id' and  a.challenge_id = d.challenge_id and d.status = '1' and
											a.blob_id = c.blob_id and  a.challenge_status = '2'  and a.user_id = b.user_id) ORDER BY challenge_creation DESC;");

			while ($owned_challengesRow = mysqli_fetch_array($owned_challenges)) {
                            $username_owned_challenge = $owned_challengesRow['username'];
				$eta = $owned_challengesRow['challenge_ETA'];
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
		echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='".$idd."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
					</form>";		
		echo "Challenge by &nbsp <span class='color strong' style= 'color :lightblue;'><a href ='profile.php?username=".$username_owned_challenge."'>" 
		.ucfirst($owned_challengesRow['first_name']). '&nbsp'. ucfirst($owned_challengesRow['last_name']). "</a> </span> on ".$time. "<br/>".$remainingtime. "<br/>".$remaining_time."<br> 
				<p align='center' style='font-size: 14pt;'  ><span style= 'color :lightblue;'><b>".ucfirst($ch_title)."</b></span></p>
				<br/>". str_replace("<s>","&nbsp;",$owned_challengesRow['stmt'])."<br> <br>";
		$commenter = mysqli_query ($db_handle, ("(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name,b.username FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$ch_id' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1' ORDER BY response_ch_creation ASC)
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name,b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$ch_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1' ORDER BY response_ch_creation ASC);"));
		while($commenterRow = mysqli_fetch_array($commenter)) {
			$comment_owned_id = $commenterRow['response_ch_id'];
                        $username_commenter_owned = $commenterRow['username'];
		echo "
				<div id='commentscontainer'>
						<div class='comments clearfix'>
								<div class='pull-left lh-fix'>
										<img src='uploads/profilePictures/$username_commenter_owned.jpg'  onError=this.src='img/default.gif'>
								</div>
								<div class='comment-text'>
										<span class='pull-left color strong'>";
											echo "&nbsp<a href ='profile.php?username=".$username_commenter_owned."'>". ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) .
										"</a></span> &nbsp" .$commenterRow['stmt'] ."";
										dropDown_delete_comment_challenge($db_handle, $comment_owned_id, $user_id);
							echo "	</div>
						</div> 
					</div>";
			}
			echo "<div class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
						</div>
						<form action='' method='POST' class='inline-form'>
							<input type='hidden' value='".$ch_id."' name='own_challen_id' />
							<input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
							<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
						</form>
				</div>
			";
		echo '</div> </div>';

}
?>
                        
