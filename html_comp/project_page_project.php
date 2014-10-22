<?php
	   $project_id = mysqli_query($db_handle, "(SELECT a.user_id, a.project_id, a.project_ETA, a.project_creation, a.stmt, b.first_name, b.last_name, b.username FROM
												projects as a join user_info as b WHERE a.project_id = '$pro_id' and blob_id = '0' and a.user_id = b.user_id AND a.project_type = '1')
                                                UNION
                                                (SELECT a.user_id, a.project_id, a.project_ETA, a.project_creation, b.stmt, c.first_name, c.last_name, c.username FROM projects as a
                                                join blobs as b join user_info as c WHERE a.project_id = '$pro_id' AND a.project_type = '1' and a.blob_id = b.blob_id and a.user_id = c.user_id);");
	   $project_idrow = mysqli_fetch_array($project_id) ;
		$p_id = $project_idrow['project_id'] ;
		$projectst = $project_idrow['stmt'];
		$fname = $project_idrow['first_name'];
		$lname = $project_idrow['last_name'];
        $username_project = $project_idrow['username'];
		$projecteta = $project_idrow['project_ETA'];
		$daypr = floor(($projecteta)/(24*60)) ;
		$daysecpr = ($projecteta)%(24*60) ;
		$hourpr = floor($daysecpr/(60)) ;
		$minutepr = $daysecpr%(60) ;
		if($projecteta > 1439) {
			$timepr = $daypr." days" ;
		}
		else {
			if(($projecteta < 1439) AND ($projecteta > 59)) {
				$timepr = $hourpr." hours" ;	
			}
			else { $timepr = $minutepr." mins" ; }
		}
					
	echo "<div class='list-group'>
				<div class='list-group-item'>";

      echo "<div class='pull-right'>
            <div class='list-group-item'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    $project_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM projects WHERE project_id = '$p_id' AND user_id='$user_id';"));
                    $project_dropdown_displayRow = mysqli_fetch_array($project_dropdown_display);
                    $project_dropdown_userID = $project_dropdown_displayRow['user_id'];
                    if($project_dropdown_userID == $user_id) {
                        echo "
                        <li><button class='btn-link' href='#'>Edit Project</button></li>
                        <li><button class='btn-link' pID='".$p_id."' onclick='delProject(".$p_id.");'>Delete Project</button></li>
                        <li><form method='POST' class='inline-form'>";                    
                        if($projecteta == 'Time over') {        
                            echo "<input type='hidden' name='id' value='".$p_id."'/>
                                <input class='btn-link' type='submit' name='eta_project_change' value='Change ETA'/>";
                            }                                    
                       echo "</form></li>";
                    }
                    else {
                       echo "<li><button class='btn-link' >Report Spam</button></li>";
                    } 
               echo "</ul>
              </div>
            </div>";
	echo "Created by &nbsp <span class='color strong' style= 'color :lightblue;'>
			<a href ='profile.php?username=".$username_project."'>".ucfirst($fname). '&nbsp'.ucfirst($lname)."</a>
			</span>  on &nbsp".$timef. " with ETA in &nbsp".$timepr. " <br>".$remaining_timepr." <br>
			<span class='color strong' style= 'font-size: 14pt; color :#3B5998;'><p align='center'>".ucfirst($title)."</p></span>
			".str_replace("<s>","&nbsp;",$projectst)."<br/><br/>" ;
					
	$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
											where a.project_id = '$p_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '1')
											UNION
											(SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
											where a.project_id = '$p_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");	
	while ( $displayrowc = mysqli_fetch_array($displayb)) {
			$frstnam = $displayrowc['first_name'] ;
			$lnam = $displayrowc['last_name'] ;
            $username_pr_comment = $displayrowc['username'];
			$ida = $displayrowc['response_pr_id'] ;
			$projectres = $displayrowc['stmt'] ;
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'><a href ='profile.php?username=".$username_pr_comment."'>".ucfirst($frstnam)." ".ucfirst($lnam)."</a>&nbsp</span> 
						<small>".$projectres."</small>";
				dropDown_delete_comment_project($db_handle, $ida, $user_id);
       
				echo "</div>
				</div> 
			</div>";
	}
	echo "<div class='comments clearfix'>
			<div class='pull-left lh-fix'>
			<img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
			</div>
			
                        <form method='POST' class='inline-form'>
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='pr_resp' placeholder='Whats on your mind about this project' />
                            <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_project' ></button>
                        </form>
			
		</div></div></div>"								  
	
?>
<?php 
	$i = 0 ;
	$c = mysqli_query($db_handle, "SELECT * FROM challenges WHERE project_id = '$p_id' AND challenge_type != '3' AND challenge_type != '6' 
											AND challenge_type != '7' AND blob_id = '0' ;") ;
	if(mysqli_num_rows($c) > 0)	{									
	echo "<div class='panel-heading'>    
			<h3 class='panel-title'><p align='center'>Summary</p></h3>
		</div>
		<table class='table table-striped table-hover'>
			<thead>
				<tr>
					<th>No.</th>
					<th>Challenges</th>
					<th>Time</th>
					<th>Owned By</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>" ;
		}
	 $summary = mysqli_query($db_handle, "(SELECT DISTINCT challenge_id, challenge_title, challenge_type, challenge_status, challenge_ETA, LEFT(stmt, 90) as stmt
											FROM challenges WHERE project_id = '$p_id' AND challenge_type != '3' AND challenge_type != '6' 
											AND challenge_type != '7' AND blob_id = '0')
											UNION
										 (SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_type, a.challenge_ETA, a.challenge_status, LEFT(b.stmt, 90) as stmt
										   FROM challenges AS a JOIN blobs AS b WHERE a.project_id = '$p_id' AND a.challenge_type != '3' AND a.challenge_type != '6' 
										   AND a.challenge_type != '7' AND a.blob_id = b.blob_id );");
      while($summaryrow = mysqli_fetch_array($summary)) {
				$sid = $summaryrow['challenge_id'] ;
				$sidtitle = $summaryrow['challenge_title'] ;
				$sideta = $summaryrow['challenge_ETA'] ;
				$sidstmt = str_replace("<s>","&nbsp;",$summaryrow['stmt']) ;
				$sidtype = $summaryrow['challenge_type'] ;
				$sidstatus = $summaryrow['challenge_status'] ;
				$daysu = floor($sideta/(24*60)) ;
				$daysecsu = $sideta%(24*60) ;
				$hoursu = floor($daysecsu/(60)) ;
				$minutesu = $daysecsu%(60) ;
		if($sideta > 1439) {
			$sutime = $daysu." days" ;
		}
		else {
			if(($sideta < 1439) AND ($sideta > 59)) {
				$sutime = $hoursu." hours" ;	
			}
			else { $sutime = $minutesu." mins" ; }
		} 
		if (($sidtype == 1 OR $sidtype == 2) AND $sidstatus == 1 )	{
			$sstatus = "Not Owned" ;
		}
		else if (($sidtype == 1 OR $sidtype == 2) AND $sidstatus == 2 )	{
			$sstatus = "IN Progress" ;
		}	
		else if ($sidtype == 4 OR $sidtype == 5) {	
			$sstatus = "Completed" ;
		}
		else if ($sidtype == 8) {	
			$sstatus = "Task" ;
		}
		$owned = mysqli_query($db_handle, "select a.user_id, b.first_name, b.username from challenge_ownership as a join user_info as b where a.challenge_id = '$sid' and a.user_id = b.user_id ;") ;	
		$ownedrow = mysqli_fetch_array($owned) ;
		$sname = $ownedrow['username'] ;
		$sfname = $ownedrow['first_name'] ;
		$i++; 
		
		echo "<tr>
				<td>".$i."</td>
				<td><a href ='challengesOpen.php?challenge_id=".$sid."'>".$sidtitle."</a><br/>".$sidstmt."</td>
				<td>".$sutime."</td>
				<td><a href ='profile.php?username=".$sname."'>".$sfname."</a></td>
				<td>".$sstatus."</td>
			</tr>" ;
	}
	echo "</tbody>
            </table>" ;
				?>
	
<?php
	$echo = mysqli_query($db_handle,"select * from challenges where challenge_type = '6' ;");
		if(mysqli_num_rows($echo) > 0) {
    echo "<div class='panel-heading'>    
            <h3 class='panel-title'><p align='center'> Notes</p></h3>
          </div>"; 
	  }
  ?>             
<?php
		 $display = mysqli_query($db_handle, "(select DISTINCT a.challenge_title,a.challenge_id, a.challenge_creation, a.user_id, a.stmt, b.first_name, b.last_name, b.username from challenges as a 
												join user_info as b where a.project_id = '$p_id' and a.challenge_type = '6' and a.blob_id = '0' and a.user_id = b.user_id 
												)
												UNION
												(select DISTINCT a.challenge_title,a.challenge_id,a.challenge_creation, a.user_id, c.stmt, b.first_name, b.last_name, b.username from challenges as a 
												join user_info as b join blobs as c where a.project_id = '$p_id' and a.challenge_type = '6' and a.blob_id = c.blob_id and a.user_id = b.user_id 
												) ORDER BY challenge_creation DESC;");
          while ($displayrow = mysqli_fetch_array($display)) {
			  $notes = str_replace("<s>","&nbsp;",$displayrow['stmt']) ;
			  $title = $displayrow['challenge_title'] ;
			  $fname = $displayrow['first_name'] ;
			  $lname = $displayrow['last_name'] ;
                          $username_notes = $displayrow['username'];
              $note_ID = $displayrow['challenge_id'];
			  echo "<div class='list-group'>
							<div class='list-group-item'>
							   <div class='pull-right'>
								<div class='list-group-item'>
									<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
									<ul class='dropdown-menu' aria-labelledby='dropdown'>
									 <li><a class='btn-link' href='#'>Edit Note</a></li>
									 <li><a class='btn-link' noteID='".$note_ID."' onclick='delNote(".$note_ID.");'>Delete Note</a></li>                  
									 <li><a class='btn-link' >Report Spam</a></li>
								   </ul>
							  </div>
							</div>
							<p align='center' style='font-size: 14pt;color :#3B5998;'>".$title."</p>
							<span class='pull-left color strong' style= 'color :#3B5998;'><a href ='profile.php?username=".$username_notes."'>".ucfirst($fname)." ".ucfirst($lname)."</a>&nbsp&nbsp&nbsp</span> 
							<small>".$notes."</small><br/><br/>";
			$displaya = mysqli_query($db_handle, "(select DISTINCT a.user_id, a.stmt, a.response_ch_id, a.response_ch_creation, b.first_name, b.last_name, b.username
													FROM response_challenge as a join user_info as b where a.challenge_id = ".$displayrow['challenge_id']." 
													and a.user_id = b.user_id and a.blob_id = '0')
													UNION
													(select DISTINCT a.user_id, c.stmt, a.response_ch_id, a.response_ch_creation, b.first_name, b.last_name, b.username
													 FROM response_challenge as a join user_info as b join blobs as c where a.challenge_id = ".$displayrow['challenge_id']."
													  and a.user_id = b.user_id and a.blob_id = c.blob_id);");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
				$lstname = $displayrowb['last_name'] ;
                                $username_notes_comment = $displayrowb['username'];
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
				
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_notes_comment.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=".$username_notes_comment."'>". ucfirst($fstname)." ".ucfirst($lstname)."</a>&nbsp</span> 
						".$chalangeres."";
                 dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
						
				echo "</div>
				</div> 
			</div>";
		}
		echo "<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
				</div>
				<form action='' method='POST' class='inline-form'>
                                    <input type='hidden' value='".$note_ID."' name='own_challen_id' />
                                    <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                                </form>
			</div></div></div>" ;
	}
$closehd = mysqli_query($db_handle,"select * from challenges where challenge_type = '5' ;");
		if(mysqli_num_rows($closehd) > 0) {
echo "<div class='panel-heading'>    
        <h3 class='panel-title'><p align='center'>Closed Challenges</p></h3>
      </div>";
  }
      $closed = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.stmt, a.challenge_creation, b.first_name, b.last_name, b.username
											FROM challenges AS a JOIN user_info AS b WHERE a.project_id = '$p_id' and a.challenge_type = '5' AND a.blob_id = '0' AND a.user_id = b.user_id )
											UNION
										 (SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, c.stmt, a.challenge_creation, b.first_name, b.last_name, b.username
											FROM challenges AS a JOIN user_info AS b JOIN blobs AS c WHERE a.project_id = '$p_id' and a.challenge_type = '5' AND a.blob_id = c.blob_id AND a.user_id = b.user_id);");
      while($closedrow = mysqli_fetch_array($closed)) {
				$CID = $closedrow['challenge_id'] ;
				$CIDtitle = $closedrow['challenge_title'] ;
				$CIDeta = $closedrow['challenge_ETA'] ;
				$CIDstmt = $closedrow['stmt'] ;
				$CIDtime = $closedrow['challenge_creation'] ;
				$timeCID = date("j F, g:i a",strtotime($CIDtime));
				$CIDfname = $closedrow['first_name'] ;
				$CIDlname = $closedrow['last_name'] ;
				$CIDname = $closedrow['username'] ;
				$dayD = floor($CIDeta/(24*60)) ;
				$daysecD = $CIDeta%(24*60) ;
				$hourD = floor($daysecD/(60)) ;
				$minuteD = $daysecD%(60) ;
	if($CIDeta > 1439) {
			$timeD = $dayD." days" ;
		}
		else {
			if(($CIDeta < 1439) AND ($CIDeta > 59)) {
				$timeD = $hourD." hours" ;	
			}
			else { $timeD = $minuteD." mins" ; }
		}
		$complete = mysqli_query($db_handle, "select a.user_id, a.ownership_creation, a.time, b.first_name, b.last_name, b.username from challenge_ownership as a 
											join user_info as b where a.challenge_id = '$CID' and a.user_id = b.user_id ;") ;
		$completerow = mysqli_fetch_array($complete) ;
				$Clname = $completerow['last_name'] ;							
				$Cfname = $completerow['first_name'] ;							
				$Cname = $completerow['username'] ;							
				$Ctime = $completerow['time'] ;							
				$Ccreation = $completerow['ownership_creation'] ;
				$timeC = date("j F, g:i a",strtotime($Ctime));
				$initialtimeC = strtotime($Ccreation) ;
				$endingtimeC = strtotime($Ctime) ;
				$totaltimeC =$endingtimeC-$initialtimeC ;
				$dayC = floor($totaltimeC/(24*60*60)) ;
				$daysecC = $totaltimeC%(24*60*60) ;
				$hourC = floor($daysecC/(60*60)) ;
				$hoursecC = $daysecC%(60*60) ;
				$minuteC = floor($hoursecC/60) ;
		if($totaltimeC > ((24*60*60)-1)) {
			$timeC = $dayC." days" ;
		}
		else {
			if(($totaltimeC < ((24*60*60)-1)) AND ($totaltimeC > ((60*60)-1))) {
				$timeC = $hourC." hours" ;	
			}
			else { $timeC = $minuteC." mins" ; }
		}
		$ans = 	mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id= '$CID' and blob_id = '0') UNION (select b.stmt from 
										response_challenge as a join blobs as b where a.challenge_id= '$CID' and a.blob_id = b.blob_id);") ;	
			$ansrow = mysqli_fetch_array($ans) ;
				$ansstmt = $ansrow['stmt'] ;						
       echo "<div class='list-group'>
				<div class='list-group-item'>
					Challenge Created By : <span color strong' style= 'color :#3B5998;'>
					<a href ='profile.php?username=".$CIDname."'>".ucfirst($CIDfname)." ".ucfirst($CIDlname)."</a></span>
					&nbsp&nbsp&nbsp&nbsp On : ".$timeCID."<br/>
					ETA Given : ".$remainingtime." <br/>
					Challenge Accepted and Sumitted By : <span color strong' style= 'color :#3B5998;;'>
					<a href ='profile.php?username=".$Cname."'>".ucfirst($Cfname)." ".ucfirst($Clname)."</a></span>
					&nbsp&nbsp&nbsp&nbsp On : ".$timeC."<br/>
					ETA Taken : ".$remaining_time." <br/>
					<p align='center' style='font-size: 14pt;color :#3B5998;'>".ucfirst($CIDtitle)."</p><br/>
					<small>".$CIDstmt."</small><br/>
					<p align='center' style='font-size: 14pt;color :#3B5998;'>Statement</p><br/>
					<small>".$ansstmt."</small><br/>";
			$displaya = mysqli_query($db_handle, "(select DISTINCT a.user_id, a.stmt, a.response_ch_id, a.response_ch_creation, b.first_name, b.last_name, b.username
													FROM response_challenge as a join user_info as b where a.challenge_id = ".$CID." and a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
													UNION
													(select DISTINCT a.user_id, c.stmt, a.response_ch_id, a.response_ch_creation, b.first_name, b.last_name, b.username
													 FROM response_challenge as a join user_info as b join blobs as c where a.challenge_id = ".$CID."
													  and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1');");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
				$lstname = $displayrowb['last_name'] ;
                $username_notes_comment = $displayrowb['username'];
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
				
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_notes_comment.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>
						<a href ='profile.php?username=".$username_notes_comment."'>". ucfirst($fstname)." ".ucfirst($lstname)."</a></span> 
						&nbsp&nbsp&nbsp".$chalangeres."
					</div>
				</div> 
			</div>";
		}
		echo "<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
				</div>
				<form action='' method='POST' class='inline-form'>
                                    <input type='hidden' value='".$CID."' name='own_challen_id' />
                                    <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                                </form>
			</div>
		</div>
	</div>" ;      
  } 
?>
