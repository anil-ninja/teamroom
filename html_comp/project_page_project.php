 <div class='list-group'>
				   <div class='list-group-item'><span class="glyphicon glyphicon-pencil" id='challengepr'> Challenge</span> | <span class="glyphicon glyphicon-pushpin" id='task'> Assign Task</span> | <span class="glyphicon glyphicon-phone-alt" id='team'> Create Team</span> | <span class="glyphicon glyphicon-tree-deciduous" id='notes'> Notes</span> | <span class="glyphicon glyphicon-hdd" id='files'> Manage Files</span></div>
				<div class='list-group-item'>
				<div id='challegeprForm'>
                  <form>
                        <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte"/><br>
                        <textarea rows="3" class="form-control" id="challange" placeholder="Details of Challange"></textarea><br>
                    <div class="inline-form">
                        Challange Open For : <select class="btn btn-default btn-xs" id= "open_time" >	
                            <option value='0' selected >hour</option>
                            <?php
                            $o = 1;
                            while ($o <= 24) {
                                echo "<option value='" . $o . "' >" . $o . "</option>";
                                $o++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id = "open" >	
                            <option value='10' selected >minute</option>
                            <option value='20'  >20</option>
                            <option value='30' >30</option>
                            <option value='40'  >40</option>
                            <option value='50' >50</option>
                        </select><br/><br/>ETA : 
                        <select class="btn btn-default btn-xs" id = "cc_eta" >	
                            <option value='0' selected >Month</option>
                            <?php
                            $m = 1;
                            while ($m <= 11) {
                                echo "<option value='" . $m . "' >" . $m . "</option>";
                                $m++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "cc_etab" >	
                            <option value='0' selected >Days</option>
                            <?php
                            $d = 1;
                            while ($d <= 30) {
                                echo "<option value='" . $d . "' >" . $d . "</option>";
                                $d++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "cc_etac" >	
                            <option value='0' selected >hours</option>
                            <?php
                            $h = 1;
                            while ($h <= 23) {
                                echo "<option value='" . $h . "' >" . $h . "</option>";
                                $h++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "cc_etad" >	
                            <option value='15' selected >minute</option>
                            <option value='30' >30</option>
                            <option value='45'  >45</option>
                        </select>
                        </div><br/><br/>
                        <div class="input-group">Challenge Type : 
                            <select class='btn-default btn-xs' id="type" >
                                <option value=" 1" >Public</option>
                                <option value=" 2" selected >Private</option>
                            </select>
                        </div>
                        <br>
                        <input type='hidden' name='project_id' value="<?php echo $pro_id; ?>"/>
                        <input type="button" value="Create Challenge" class="btn btn-success" id="create_challange_pb_pr"/>
                    </form>
                    </div>
                    <div id='taskForm'>
                       <div class="input-group" >
                        <span class="input-group-addon">Assign To : </span>
                         <input type="text" class="form-control" id="email" placeholder="Enter email or Team name ">
                      </div><br/>
                      <div class="input-group" >
                        <span class="input-group-addon">Title : </span>						
                        <input type="text" class="form-control" id="title" placeholder="Tilte"/>
                       </div><br>
                       <div class="input-group" >
                        <span class="input-group-addon">Task : </span>						
                        <textarea rows="3" class="form-control" id="taskdetails" placeholder="Details of Tasks"></textarea>
                        </div><br>
                    <div class="inline-form">
                        ETA : 
                        <select class="btn btn-default btn-xs" id = "c_eta" >	
                            <option value='0' selected >Month</option>
                            <?php
                            $m = 1;
                            while ($m <= 11) {
                                echo "<option value='" . $m . "' >" . $m . "</option>";
                                $m++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "c_etab" >	
                            <option value='0' selected >Days</option>
                            <?php
                            $d = 1;
                            while ($d <= 30) {
                                echo "<option value='" . $d . "' >" . $d . "</option>";
                                $d++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "c_etac" >	
                            <option value='0' selected >hours</option>
                            <?php
                            $h = 1;
                            while ($h <= 23) {
                                echo "<option value='" . $h . "' >" . $h . "</option>";
                                $h++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "c_etad" >	
                            <option value='15' selected >minute</option>
                            <option value='30' >30</option>
                            <option value='45'  >45</option>
                        </select>
                        </div><br/><br/>
                         <input type='hidden' id='project_id' value="<?php echo $pro_id; ?>"/>
                        <input type="button" value="Assign" class="btn btn-success" id="create_task"/>
                    </div>
                    <div id='teamForm'>
                       <form role="form" method="POST">
                    <div class="input-group" >
                        <span class="input-group-addon">Team Name</span>
                        <input type="text" class="form-control" name="team_name" placeholder="Enter your team name">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon">Create Team with (Email)</span>
                        <input type="email" class="form-control" name="email" placeholder="Enter First team member Email">
                    </div>
                    <br>
                    <input type="submit" class="btn btn-success" name = "create_team" value = "Create New Team" >
                </form>
                    </div>
                    <div id='notesForm'>
                         <input type='text' class="form-control" id="notes_title" placeholder="Title"/><br>
                        <textarea rows="3" class="form-control" id="notes" placeholder="Notes about Project or Importent Things about Project"></textarea><br><br>
                        <input type='hidden' name='project_id' value="<?php echo $pro_id; ?>"/>
                        <input type="button" value="Post" class="btn btn-success" id="create_notes"/>
                    </div>
                     <div id='manageForm'>
                        <div id="elfinder"></div>
                    </div><br/>
                </div>
                </div>
<?php
	   $project = mysqli_query($db_handle, "(SELECT a.user_id, a.project_ETA, a.project_creation, a.stmt, b.first_name, b.last_name, b.username FROM
												projects as a join user_info as b WHERE a.project_id = '$pro_id' and a.blob_id = '0' and a.user_id = b.user_id )
                                                UNION
                                                (SELECT a.user_id, a.project_id, a.project_ETA, a.project_creation, b.stmt, c.first_name, c.last_name, c.username FROM projects as a
                                                join blobs as b join user_info as c WHERE a.project_id = '$pro_id' and a.blob_id = b.blob_id and a.user_id = c.user_id);");
	   $project_row = mysqli_fetch_array($project) ;
		$p_uid = $project_row['user_id'] ;
		$projectst = $project_row['stmt'];
		$fname = $project_row['first_name'];
		$lname = $project_row['last_name'];
        $username_project = $project_row['username'];
		$projecteta = $project_row['project_ETA'];
		$timepr = eta($projecteta) ;		
	echo "<div class='list-group'>
			<div class='list-group-item'>
			<div class='pull-right'>
            <div class='list-group-item'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    if($p_uid == $user_id) {
                        echo "
                        <li><button class='btn-link' href='#'>Edit Project</button></li>
                        <li><button class='btn-link' pID='".$pro_id."' onclick='delProject(".$pro_id.");'>Delete Project</button></li>
                        <li><form method='POST' class='inline-form'>";                    
                        if($prtime == 'Closed') {        
                            echo "<input type='hidden' name='id' value='".$pro_id."'/>
                                <input class='btn-link' type='submit' name='eta_project_change' value='Change ETA'/>";
                            }                                    
                       echo "</form></li>
								<li><button class='btn-link' >Report Spam</button></li>";
                    } 
    echo "</ul>
              </div>
            </div>Created by &nbsp <span class='color strong' style= 'color :lightblue;'>
			<a href ='profile.php?username=".$username_project."'>".ucfirst($fname). '&nbsp'.ucfirst($lname)."</a>
			</span>  on &nbsp".$timef. " with ETA in &nbsp".$timepr. " <br>".$prtime." <br>
			<span class='color strong' style= 'font-size: 14pt; color :#3B5998;'><p align='center'>".ucfirst($projttitle)."</p></span>
			".str_replace("<s>","&nbsp;",$projectst)."<br/><br/>" ;
					
	$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
											where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '1')
											UNION
											(SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
											where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");	
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
			</div><form method='POST' class='inline-form'>
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='pr_resp' placeholder='Whats on your mind about this project' />
                            <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_project' ></button>
             </form></div></div></div>"								  
	
?>

<?php  
$_SESSION['lastpr'] = '10' ;  
		$tasks = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, a.stmt, a.challenge_creation, a.challenge_type,
											a.challenge_status, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b
											 WHERE a.project_id = '$pro_id' AND a.challenge_type !='6' AND a.challenge_status !='3' AND a.challenge_status !='7'
											AND a.blob_id = '0' and a.user_id = b.user_id)
											UNION
										 (SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, c.stmt,a.challenge_creation, a.challenge_type,
										  a.challenge_creation, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN blobs AS c 
										  WHERE a.project_id = '$pro_id' AND a.challenge_type !='6' AND a.challenge_status !='3' AND a.challenge_status !='7'
										   AND a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY challenge_creation DESC LIMIT 0, 10 ;");
		if(mysqli_num_rows($tasks) > 0){
			echo "<h3 class='panel-title'><p align='center'>Challenges</p></h3>" ;
			}
			else {
				echo "<h3 class='panel-title'><p align='center'>You have no Challenges</p></h3>" ;
				}

		while ($tasksrow = mysqli_fetch_array($tasks)) {
			$username_task = $tasksrow['username'];
			$id_task = $tasksrow['challenge_id'];
			$id_create = $tasksrow['user_id'];
			$title_task = $tasksrow['challenge_title'];
			$type_task = $tasksrow['challenge_type'];
			$status_task = $tasksrow['challenge_status'];
			$eta_task = $tasksrow['challenge_ETA'];
			$creation_task = $tasksrow['challenge_creation'];
			$timetask = date("j F, g:i a",strtotime($creation_task));
			$stmt_task = $tasksrow['stmt'];
			$fname_task = $tasksrow['first_name'];
			$lname_task = $tasksrow['last_name'];
			$tasketa = eta($eta_task) ;
			$remaintime = remaining_time($creation_task, $eta_task) ;
		$ownedby = mysqli_query($db_handle,"SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, a.time, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$id_task' and b.user_id = a.user_id ;") ;
			$ownedbyrow = mysqli_fetch_array($ownedby) ;
			$owneta = $ownedbyrow['comp_ch_ETA'] ;
			$ownid = $ownedbyrow['user_id'] ;
			$owntime = $ownedbyrow['ownership_creation'] ;
			$timefunct = date("j F, g:i a",strtotime($owntime));
			$committime = $ownedbyrow['time'] ;
			$timecom = date("j F, g:i a",strtotime($committime));
			$ownfname = $ownedbyrow['first_name'] ;
			$ownlname = $ownedbyrow['last_name'] ;
			$ownname = $ownedbyrow['username'] ;
			$etaown = eta($owneta) ;
			$initialtimeo = strtotime($owntime) ;
			$endtime = strtotime($committime) ;
			$time_taken = ($endtime-$initialtimeo) ;
			$day = floor($time_taken/(24*60*60)) ;
			$daysec = $time_taken%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$timetaken = $day." Days :".$hour." Hours :".$minute." Min :" ;
			$remaintimeown = remaining_time($owntime, $owneta) ;
	if ($type_task == 4) {
		if ($tasksrow['user_id'] == $user_id) {
		echo "Challenged by <span class='color strong' style= 'color :#3B5998;'> You </span> On : ".$timetask.
				"<br/>ETA Given : ".$remainingtime."</div>
				<div class='list-group-item'>Accepted By <span class='color strong' style= 'color :#3B5998;'>".ucfirst($ownfname)." ".ucfirst($ownlname).
				"</span> and Submitted On : ".$timecom."<br/>ETA Taken : ".$timetaken."</div>" ;
			}					
		}				
	 if($type_task == 5) {					
	      echo "<div class='list-group'>
				<div class='list-group-item'>
				<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>" ;
		if($id_create == $user_id) {
              echo "<li><button class='btn-link' href='#'>Edit Project</button></li>
                        <li><button class='btn-link' pID='".$id_task."' onclick='delProject(".$id_task.");'>Delete Project</button></li>
                        <li><form method='POST' class='inline-form'>";                    
              if($remaintimeown == 'Closed') {        
                     echo "<input type='hidden' name='id' value='".$id_task."'/>
                                <input class='btn-link' type='submit' name='eta' value='Change ETA'/>";
                            }                                    
                       echo "</form></li>
								<li><button class='btn-link' >Report Spam</button></li>";
                    } 
      if($ownid==$user_id) {			
			echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='".$id_task."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
					</form>";
				}
		echo "Task Assigned by &nbsp <span class='color strong' style= 'color :#3B5998;'>".ucfirst($fname_task)."</a></span> On ".$timefunct."<br/>
				Task Assigned To &nbsp <span class='color strong' style= 'color :#3B5998;'>".ucfirst($ownfname)." ".ucfirst($ownlname)."</a> </span>
					 ETA Given : ".$etaown." <br/>".$remaintimeown."</div>";
		} 
		else if($status_task == 4) {
				if($id_create==$user_id) {			
			echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
				   <input type='hidden' name='cid' value='" . $chelangeid . "'/>
				   <button type='submit' class='btn-primary' name='closechal'>Close</button></form>";
				}
		echo "Task Assigned by &nbsp <span class='color strong' style= 'color :#3B5998;'>".ucfirst($fname_task)."</a></span> On ".$timefunct."<br/>
				Task Assigned To &nbsp <span class='color strong' style= 'color :#3B5998;'>".ucfirst($ownfname)." ".ucfirst($ownlname)."</a> </span>
					 ETA Given : ".$etaown." <br/>".$remaintimeown."</div>";
		}
		else {			
		if($status_task == 1) {
		echo "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_task."'>" 
				. ucfirst($fname_task). '&nbsp'. ucfirst($lname_task). " </a></span>" ;		 		
				dropDown_challenge($db_handle, $id_task, $user_id, $remaining_time_owno);
			echo "<form method='POST' class='inline-form pull-right'>
						<input type='hidden' name='id' value='".$id_task."'/>
						<input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
					</form>
				 &nbsp&nbsp&nbsp On : ".$timetask."&nbsp&nbsp&nbsp with ETA : ".$remainingtime."<br/>".$remaining_time."</div>";
		}
		else {
			echo "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_task."'>"
				. ucfirst($fname_task). '&nbsp'. ucfirst($lname_task). " </a></span>&nbsp&nbsp On : ".$timetask."<br/>
				Owned By  <span class='color strong'><a href ='profile.php?username=".$ownname."'>"
				. ucfirst($ownfname). '&nbsp'. ucfirst($ownlname). " </a></span>&nbsp&nbsp On : ".$timefunct." and 
				ETA Taken : ".$timeo." <br/> Time Remaining : ".$remaining_time_owno."</div>" ;
			}
		}			
   	echo "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'><b>".ucfirst($title_task)."</b></p><br/>
				<small>".str_replace("<s>","&nbsp;",$stmt_task)."</small><br>";
	if ($type_task == 4) {
		if ($tasksrow['user_id'] == $user_id) {
		$answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$id_task' and blob_id = '0' and status = '2')
												UNION
												(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$id_task' and a.status = '2' and a.blob_id = b.blob_id);") ;										
			$answerrow = mysqli_fetch_array($answer) ;
		echo "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
				<p align='center'>Answer</p></span>"
				.$answerrow['stmt']."<br/><form method='POST' onsubmit=\"return confirm('Really Close Challenge !!!')\">
				<div class='pull-right'><input type='hidden' name='cid' value='".$id_task."'/>
				<button type='submit' class='btn-primary' name='closechallenge'>Close</button></div></form><br/>" ;
		
		}			
	}	
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
                                <input type='text' STYLE='border: 1px solid #bdc7d8; width: 84%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                        </form>
                    </div>";
	echo "</div> </div>";		
			
			
			}

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
						&nbsp&nbsp&nbsp".$chalangeres."";
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
                                    <input type='hidden' value='".$CID."' name='own_challen_id' />
                                    <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                                </form>
			</div>
		</div>
	</div>" ;      
  } 
?>
