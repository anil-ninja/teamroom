
	<div class="panel-heading" >
		<h3 class="panel-title" >Your Challenges</h3>
	</div>

                        
<?php 

$challange_display = mysqli_query($db_handle, ("(SELECT DISTINCT challenge_id, challenge_status, challenge_title, user_id, challenge_ETA, stmt, challenge_creation from challenges where
											user_id = '$user_id' and (challenge_type = '1' OR challenge_type = '2') and blob_id = '0' ORDER BY challenge_creation DESC )
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, b.stmt, a.challenge_creation from challenges as a
											join blobs as b WHERE a.user_id = '$user_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and 
											a.blob_id = b.blob_id ORDER BY challenge_creation DESC);"));
while($challange_displayRow = mysqli_fetch_array($challange_display)) {
	echo "<div class='list-group'>
				<div class='list-group-item'>";
			$chall_id = $challange_displayRow['challenge_id'];
			$ch_title = $challange_displayRow['challenge_title'];
			$status = $challange_displayRow['challenge_status'];
		if ($status == '2') {
			$challange_owned = mysqli_query($db_handle, "(SELECT DISTINCT  a.user_id, a.ownership_creation, a.comp_ch_ETA, b.first_name, b.last_name, b.username from 
														challenge_ownership as a join user_info as b where a.challenge_id = '$chall_id' and a.user_id = b.user_id
														ORDER BY ownership_creation DESC);") ;
			$challange_ownedRow = mysqli_fetch_array($challange_owned) ;
			$ch_eta = $challange_ownedRow['comp_ch_ETA'] ;
			$fname = $challange_ownedRow['first_name'] ;
			$lname = $challange_ownedRow['last_name'] ;
                        $usename_link = $challange_ownedRow['username'];
			$time = $challange_ownedRow['ownership_creation'] ;
			$ETA = $ch_eta*60 ;
			$day = floor($ETA/(24*60*60)) ;
			$daysec = $ETA%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remainingtime = $day." Days :".$hour." Hours :".$minute." Min" ;
			echo "Owned by &nbsp <span class='color strong' style= 'color :lightblue;'><a href ='profile.php?username=".$usename_link."'>" .ucfirst($fname). "&nbsp". ucfirst($lname). "</a> </span> &nbsp on &nbsp".$time. " &nbsp with ETA in &nbsp".$remainingtime ;
		} else {
			echo "Ownership is not claimed till now";
		}
		dropDown_challenge($db_handle, $chall_id, $user_id, $remainingtime);
		echo "<br><p align='center' style='font-size: 14pt;'  ><span style= 'color :lightblue;'><b>".ucfirst($ch_title)."</b></span></p><br/>".
				str_replace("<s>","&nbsp;",$challange_displayRow['stmt']). "<br> <br>";
		$commenter = mysqli_query ($db_handle, ("(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name, b.username FROM response_challenge as a
                                                        JOIN user_info as b WHERE a.challenge_id = $chall_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1' ORDER BY response_ch_creation ASC)
                                                    UNION
                                                    (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name,b.username, c.stmt FROM response_challenge as a
                                                        JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$chall_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1' ORDER BY response_ch_creation ASC);"));
			while($commenterRow = mysqli_fetch_array($commenter)) {
				$comment_id = $commenterRow['response_ch_id'];
                                $username_commenter = $commenterRow['username'];
			echo "<div id='commentscontainer'>
					<div class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='uploads/profilePictures/$username_commenter.jpg'  onError=this.src='img/default.gif'>
						</div>
						<div class='comment-text'>
							<span class='pull-left color strong'>";
								echo "&nbsp<a href ='profile.php?username=".$username_commenter."'>".ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) .
							"</a>&nbsp</span>".$commenterRow['stmt'] ."";
                                       dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
                                            echo"</div>
					</div> 
				</div>";
		}
	echo "<div class='comments clearfix'>
			<div class='pull-left lh-fix'>
				<img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
			</div>
			<form action='' method='POST' class='inline-form'>
							<input type='hidden' value='".$chall_id."' name='own_challen_id' />
							<input type='text' STYLE='border: 1px solid #bdc7d8; width: auto; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
							<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
						</form>
		</div>";
	
	echo '</div> </div>';
    }
?>

