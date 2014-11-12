<?php
 //include_once 'kanban.php';
$project = mysqli_query($db_handle, "(SELECT a.user_id, a.project_ETA, a.project_creation, a.stmt, b.first_name, b.last_name, b.username FROM
												projects as a join user_info as b WHERE a.project_id = '$pro_id' and a.blob_id = '0' and a.user_id = b.user_id )
                                                UNION
                                                (SELECT a.user_id, a.project_ETA, a.project_creation, b.stmt, c.first_name, c.last_name, c.username FROM projects as a
                                                join blobs as b join user_info as c WHERE a.project_id = '$pro_id' and a.blob_id = b.blob_id and a.user_id = c.user_id);");
$project_row = mysqli_fetch_array($project);
$p_uid = $project_row['user_id'];
$projectst = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_row['stmt'])));
$fname = $project_row['first_name'];
$projectcreation = $project_row['project_creation'];
$lname = $project_row['last_name'];
$username_project = $project_row['username'];
$projecteta = $project_row['project_ETA'];
$timepr = eta($projecteta);
$prtime = remaining_time($projectcreation, $projecteta);
echo "<div class='list-group'>
        <div class='list-group-item'>
            <div class='pull-left lh-fix'>     
                <span class='glyphicon glyphicon-question-sign'></span>
                <img src='uploads/profilePictures/$username_project.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
            </div>
            <div style='line-height: 16.50px;'>";
if ($p_uid == $user_id) {
    echo "<div class='pull-right'>
                    <div class='list-group-item'>
                        <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                        <ul class='dropdown-menu' aria-labelledby='dropdown'>
                <li><button class='btn-link' href='#'>Edit Project</button></li>
                  <li><button class='btn-link' pID='" . $pro_id . "' onclick='delProject(" . $pro_id . ");'>Delete Project</button></li>
                  <li>";
    if ($prtime == 'Closed') {
        echo "<form method='POST' class='inline-form'>
                        <input type='hidden' name='id' value='" . $pro_id . "'/>
                        <input class='btn-link' type='submit' name='eta_project_change' value='Change ETA'/>
                    </form>";
    }
    echo "</li>
        </ul>
        </div>
    </div>";
}
                             
        echo "<div class='row'>
                    <div class='col-md-4'>
                        <span class='color strong' style= 'color :lightblue;'>
                            <a href ='profile.php?username=" . $username_project . "'>" . ucfirst($fname) . '&nbsp' . ucfirst($lname) . "</a>
                        </span>  <br>" . $timef ."
                    </div> 
                    <div class='col-md-5'>
                        ETA in &nbsp".$timepr."<br>Time Left:".$prtime."
                    </div>
            </div>
            </div>
    </div>
            <div class='list-group-item'>
            <span class='color strong' style= 'font-size: 14pt; color :#3B5998;'><p align='center'>" . ucfirst($projttitle) . "</p></span>                
            " . str_replace("<s>", "&nbsp;", $projectst) . "<br/><br/>
            ";

$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '1')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");
while ($displayrowc = mysqli_fetch_array($displayb)) {
    $frstnam = $displayrowc['first_name'];
    $lnam = $displayrowc['last_name'];
    $username_pr_comment = $displayrowc['username'];
    $ida = $displayrowc['response_pr_id'];
    $projectres = $displayrowc['stmt'];
    echo "<div id='commentscontainer'>
            <div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                </div>
                <div class='comment-text'>
                    <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a>&nbsp</span> 
                    <small>" . $projectres . "</small>";
    dropDown_delete_comment_project($db_handle, $ida, $user_id);

        echo "</div>
            </div> 
        </div>";
}
echo "<div class='comments clearfix'>
			<div class='pull-left lh-fix'>
				<img src='uploads/profilePictures/".$username.".jpg'  onError=this.src='img/default.gif'>&nbsp
			</div>
			<form method='POST' class='inline-form'>
				<input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='pr_resp' placeholder='Comment' />
				<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_project' ></button>
			</form>
		</div>
	</div>
</div>" ;
echo "<h3 ><p align='center'>Project Talk</p></h3>";
echo "<div class='list-group'>
        <div class='list-group-item'>" ;

$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '5')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '5') ORDER BY response_pr_creation ASC;");
while ($displayrowc = mysqli_fetch_array($displayb)) {
    $frstnam = $displayrowc['first_name'];
    $lnam = $displayrowc['last_name'];
    $username_pr_comment = $displayrowc['username'];
    $ida = $displayrowc['response_pr_id'];
    $projectres = $displayrowc['stmt'];
    echo "<div id='commentscontainer'>
            <div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                </div>
                <div class='comment-text'>
                    <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a>&nbsp</span> 
                    <small>" . $projectres . "</small>";
					dropDown_delete_comment_project($db_handle, $ida, $user_id);

        echo "</div>
            </div> 
        </div>";
}
echo "<div class='comments clearfix'>
			<div class='pull-left lh-fix'>
				<img src='uploads/profilePictures/".$username.".jpg'  onError=this.src='img/default.gif'>&nbsp
			</div>
			<form method='POST' class='inline-form'>
				<input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='pr_resptalk' placeholder='Whats on your mind about this project' />
				<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_projecttalk' ></button>
			</form>
		</div>
	</div>
</div>"

?>

<div class='list-group'>
    <div class='list-group-item'><span class="glyphicon glyphicon-pencil" id='challengepr' style="cursor: pointer"> Challenge</span>
     | <span class="glyphicon glyphicon-pushpin" id='task' style="cursor: pointer"> Assign Task</span>
     | <span class="glyphicon glyphicon-phone-alt" id='team' style="cursor: pointer"> Create Team</span>
     | <span class="glyphicon glyphicon-tree-deciduous" id='notes' style="cursor: pointer"> Notes</span>
     | <span class="glyphicon glyphicon-hdd" id='files' style="cursor: pointer"> Manage Files</span>
     | <span class="glyphicon glyphicon-film" id='videopr' style="cursor: pointer"> Videos</span>
    </div>
    <div class='list-group-item'>
		<p style="color: grey;"><I>Please Select Post Type From Above ......</I></p>
		<?php
		$_SESSION['project_id'] = $pro_id;
		?>
        <div id='challegeprForm'>
            
                <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte"/><br>
                <input class="btn btn-default btn-sm" type="file" id="_fileChallengepr" style ="width: auto;"><br/>
                <textarea rows="3" class="form-control" id="challangepr" placeholder="Details of Challange"></textarea><br>
                <div class="inline-form">
                    Challenge Open For : <select class="btn btn-default btn-xs" id= "open_time" >	
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
                <input type="button" value="Create Challenge" class="btn btn-success" id="create_challange_pb_pr"/>
            
        </div><div id='invitation'></div>
        <div id='taskForm'>
			
	<?php
	$owner_project = mysqli_query($db_handle, "select user_id from projects where project_id = '$pro_id';" ) ;
	$owner_projectrow = mysqli_fetch_array($owner_project) ;
	$ownerof_project = $owner_projectrow['user_id'] ;
	if ($ownerof_project == $user_id) {
	$teams = mysqli_query($db_handle, "select DISTINCT team_name from teams where project_id = '$pro_id' and status = '1';" ) ;
		if (mysqli_num_rows($teams) > 0) { 
			$task = "";
          $task .= "<div class='inline-form'>Assign To : &nbsp;&nbsp;
                <select class='btn-default btn-xs' id = 'teamtask' >
                <option value='0' selected > Select Team </option>" ;
           while ($teamsrow = mysqli_fetch_array($teams)) {
			   $teamsname = $teamsrow['team_name'] ;
			  $task = $task ."<option value='" . $teamsname . "' >".$teamsname."</option>" ;
		   }
		   $task = $task ."</select>&nbsp;&nbsp;&nbsp;&nbsp;
					<select class='btn btn-default btn-xs' id= 'userstask' >	
                    <option value='0' selected >Select Member </option>" ;
		   $users = mysqli_query($db_handle, "select DISTINCT a.user_id, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and 
												a.team_name IN (select DISTINCT team_name from teams where a.project_id = '$pro_id' and a.status = '1') 
												and a.member_status = '1' and a.user_id = b.user_id;" ) ;
			 while ($userssrow = mysqli_fetch_array($users)) {
			   $users_username_task= $userssrow['username'] ;
			   $u_id = $userssrow['user_id'] ;
			  $task = $task ."<option value='" . $u_id . "' >" . $users_username_task . "</option>" ;
		   }									
        $task = $task ."</select>&nbsp;&nbsp;&nbsp; <input type='email' id='emailtask' placeholder='Enter email-id'/></div><br/>
            <div class='input-group' >
                <span class='input-group-addon'>Title : </span>						
                <input type='text' class='form-control' id='title' placeholder='Tilte'/>
            </div><br>
            <input class='btn btn-default btn-sm' type='file' id='_fileTask' style ='width: auto;'><br/><br/>
            <div class='input-group' >
                <span class='input-group-addon'>Task : </span>						
                <textarea rows='3' class='form-control' id='taskdetails' placeholder='Details of Tasks'></textarea>
            </div><br>
            <div class='inline-form'>
                ETA : 
                <select class='btn btn-default btn-xs' id = 'c_eta' >	
                    <option value='0' selected >Month</option>" ;
                    $m = 1;
                    while ($m <= 11) {
                      $task = $task . "<option value='" . $m . "' >" . $m . "</option>";
                        $m++;
                    }
         $task = $task ." </select>
                <select class='btn btn-default btn-xs' id= 'c_etab' >	
                    <option value='0' selected >Days</option> " ;
                    $d = 1;
                    while ($d <= 30) {
                   $task = $task ."<option value='" . $d . "' >" . $d . "</option>";
                        $d++;
                    }
        $task = $task ."</select>
                <select class='btn btn-default btn-xs' id= 'c_etac' >	
                    <option value='0' selected >hours</option>" ;
                    $h = 1;
                    while ($h <= 23) {
             $task = $task ."<option value='" . $h . "' >" . $h . "</option>";
                        $h++;
                    }
         $task = $task ."</select>
                <select class='btn btn-default btn-xs' id= 'c_etad' >	
                    <option value='15' selected >minute</option>
                    <option value='30' >30</option>
                    <option value='45'  >45</option>
                </select>
            </div><br/><br/>
            <input type='button' value='Assign' class='btn btn-success' id='create_task'/>" ;
            
         echo $task ;  
	 } 
		else {
			echo "You hane no teams, Please create Team First";			
			}
		}
		else {
			echo "You are not authorised only Project Manager can assign Tassk" ;
			}
     ?>
        </div>
        <div id='teamForm'>
                <div class="input-group" >
                    <span class="input-group-addon">Team Name</span>
                    <input type="text" class="form-control" id="team_name_A" placeholder="Enter your team name">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">Create Team with (Email)</span>
                    <input type="email" class="form-control" id = "email_team" placeholder="Enter First team member Email">
                </div>
                <br>
                <input type="submit" class="btn btn-success" id = "create_team" value = "Create New Team" >
        </div>
        <div id='VideoFormpr'>
            <input type='text' class="form-control" id="video_titlepr" placeholder="Title"/><br>
            <input type='text' class="form-control" id="videoprjt" placeholder="Add Youtube URL"><br>
            <textarea rows="3" class="form-control" id="videodespr" placeholder="About Video"></textarea><br><br>
            <input type="button" value="Post" class="btn btn-success" id="create_videopr"/>
        </div>
        <div id='notesForm'>
            <input type='text' class="form-control" id="notes_title" placeholder="Title"/><br>
            <input class="btn btn-default btn-sm" type="file" id="_fileNotes" style ="width: auto;"><br/>
            <textarea rows="3" class="form-control" id="notestmt" placeholder="Notes about Project or Importent Things about Project"></textarea><br><br>
            <input type="button" value="Post" class="btn btn-success" id="create_notes"/>
        </div>
        <div id='manageForm'>
            <div id="elfinder"></div>
        </div><br/>
    </div>
</div>
<div class="panel-primary eye_open" id="prch">
	<p id='home-ch'></p>
<?php
$_SESSION['lastpr'] = '10';
$_SESSION['project_id'] = $pro_id;
$tasks = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, a.stmt, a.challenge_creation, a.challenge_type,
											a.challenge_status, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b
											 WHERE a.project_id = '$pro_id' AND a.challenge_type !='6' AND a.challenge_status !='3' AND a.challenge_status !='7'
											AND a.blob_id = '0' and a.user_id = b.user_id)
											UNION
										 (SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, c.stmt,a.challenge_creation, a.challenge_type,
										  a.challenge_creation, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN blobs AS c 
										  WHERE a.project_id = '$pro_id' AND a.challenge_type !='6' AND a.challenge_status !='3' AND a.challenge_status !='7'
										   AND a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY challenge_creation DESC LIMIT 0, 10 ;");
if (mysqli_num_rows($tasks) > 0) {
    echo "<h3 class='panel-title'><p align='center'>Challenges</p></h3>";
} else {
    echo "<h3 class='panel-title'><p align='center'>You have no Challenges</p></h3>";
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
    $timetask = date("j F, g:i a", strtotime($creation_task));
    $stmt_task = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $tasksrow['stmt'])));
    $fname_task = $tasksrow['first_name'];
    $lname_task = $tasksrow['last_name'];
    $tasketa = eta($eta_task);
    $remaintime = remaining_time($creation_task, $eta_task);
    $ownedby = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, a.time, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$id_task' and b.user_id = a.user_id ;");
    $ownedbyrow = mysqli_fetch_array($ownedby);
    $owneta = $ownedbyrow['comp_ch_ETA'];
    $ownid = $ownedbyrow['user_id'];
    $owntime = $ownedbyrow['ownership_creation'];
    $timefunct = date("j F, g:i a", strtotime($owntime));
    $committime = $ownedbyrow['time'];
    $timecom = date("j F, g:i a", strtotime($committime));
    $ownfname = $ownedbyrow['first_name'];
    $ownlname = $ownedbyrow['last_name'];
    $ownname = $ownedbyrow['username'];
    $etaown = eta($owneta);
    $initialtimeo = strtotime($owntime);
    $endtime = strtotime($committime);
    $time_taken = ($endtime - $initialtimeo);
    $day = floor($time_taken / (24 * 60 * 60));
    $daysec = $time_taken % (24 * 60 * 60);
    $hour = floor($daysec / (60 * 60));
    $hoursec = $daysec % (60 * 60);
    $minute = floor($hoursec / 60);
    $timetaken = $day . " Days :" . $hour . " Hours :" . $minute . " Min :";
    $remaintimeown = remaining_time($owntime, $owneta);

    if ($type_task == 5) {
         if ($status_task == 2) {
			 echo "<div class='list-group pushpin'>
                    <div class='list-group-item'>
                       <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-pushpin'></span>
                            <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>";
                    echo "<div class='pull-right'>
            				<div class='list-group-item'>
            					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
            					<ul class='dropdown-menu' aria-labelledby='dropdown'>";
                                if ($id_create == $user_id) {
                                    echo "<li><button class='btn-link' href='#'>Edit</button></li>
                                            <li><button class='btn-link' cID='" . $id_task . "' onclick='delChallenge(" . $id_task . ");'>Delete</button></li>
                                           ";
                                    if ($remaintimeown == 'Closed') {
                                        echo "<li><form method='POST' class='inline-form'>
                                            <input type='hidden' name='id' value='" . $id_task . "'/>
                                            <input class='btn-link' type='submit' name='eta' value='Change ETA'/>
                                            </form></li>";
                                    }
                                }
                               else {
                                echo "<li><button class='btn-link' >Report Spam</button></li>";
                                }
                            echo "</ul>
                            </div>
                        </div>";
                        

            echo "<div class='row' style='line-height: 16.50px;'>
                    <div class='col-md-4'>
                        <span class='color strong' style= 'color :#3B5998;'>" 
                            . ucfirst($fname_task) ." ".ucfirst($lname_task) ."</a></span><br>" . $timefunct . "<br/>
                            ETA: " . $etaown."
				    </div>
                    <div class='col-md-5'>
                        Assigned To:&nbsp <span class='color strong' style= 'color :#3B5998;'>" 
                        . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> </span><br>
        					 " . $remaintimeown . "
                    </div>
                    <div class='col-md-1 pull-right'>";
                        if ($ownid == $user_id) {
                            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
                                    <input type='hidden' name='id' value='" . $id_task . "'/>
                                    <input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
                                </form>";
                        }
              echo "</div>
                </div>
            </div>";
        }
        if ($status_task == 4) {
			echo "<div class='list-group pushpin'>
                                <div class='list-group-item'>
                                    <div class='pull-left lh-fix'>     
                                    <span class='glyphicon glyphicon-pushpin'></span>
                                    <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                </div>
                                <div class='row' style='line-height: 16.50px;'>
                                    <div class='col-md-3'>";
                                    echo "<span class='color strong' style= 'color :#3B5998;'>" . ucfirst($fname_task) . "</a></span><br> " . $timefunct . "<br/>
                                            ETA Given:" .$etaown."

                                    </div>
                                    <div class='col-md-5'>";
                                        echo "Task Assigned To: &nbsp <span class='color strong' style= 'color :#3B5998;'>" . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> </span><br>
                                            Submitted On : " . $timecom . " ETA Taken : " . $timetaken . "
                                    </div>
                                    <div class='col-md-1 pull-right'>";
                                        if ($id_create == $user_id) {
                                        echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                                                        <input type='hidden' name='cid' value='" . $id_task . "'/>
                                                        <button type='submit' class='btn-primary' name='closechallenge'>Close</button>
                                            </form>";
                                    }
                            echo "</div>
                            </div>
                        </div>";
					 
        }
        if ($status_task == 5) {
			echo "<div class='list-group flag'>
                                <div class='list-group-item'>
                                    <div class='pull-left lh-fix'>     
                                    <span class='glyphicon glyphicon-flag'></span>
                                    <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                </div>
                                <div class='row' style='line-height: 16.50px;'>
                                    <div class='col-md-3'>";
                              echo "<span class='color strong' style= 'color :#3B5998;'>" . ucfirst($fname_task) . "</a></span><br>" 
                                        .$timefunct . "<br/>ETA Given:" .$etaown."
                                    </div>
                                    <div class='col-md-5'>
				        Task Assigned To: <span class='color strong' style= 'color :#3B5998;'>" 
                                        . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> </span><br>
				        Submitted On: " . $timecom . "<br> ETA Taken : " . $timetaken . "
                                    </div>
                                    <div class='col-md-1 pull-right'>";
                                        echo "<span class='color strong pull-right' style= 'color :#3B5998;'><p>Closed</p></span>
                                    </div>
                                </div>
                            </div>";
        }
    }
    if ($type_task == 8) {
			echo "<div class='list-group videofilm'>
                    <div class='list-group-item'>
                    <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-film'></span>
                                <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>";
            echo "<span class='color strong'><a href ='profile.php?username=" . $username_task . "'>"
            . ucfirst($fname_task) . '&nbsp' . ucfirst($lname_task) . " </a></span>";
            dropDown_delete_article($db_handle, $id_task, $user_id);
            echo "<br>" . $timetask . "</div></div>";
        }
    if ($type_task == 1 || $type_task == 2) {
        if ($status_task == 1) {
			echo "<div class='list-group sign'>
                    <div class='list-group-item'>
                    <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-question-sign'></span>
                                <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>";
            echo "<span class='color strong'><a href ='profile.php?username=" . $username_task . "'>"
            . ucfirst($fname_task) . '&nbsp' . ucfirst($lname_task) . " </a></span>";
            dropDown_challenge($db_handle, $id_task, $user_id, $remaintimeown);
            echo "<form method='POST' class='inline-form pull-right'>
                    <input type='hidden' name='id' value='" . $id_task . "'/>
                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                </form>
                <br>" . $timetask . "&nbsp&nbsp&nbsp with ETA : " . $tasketa . "<br/>" . $remaintime . "</div></div>";
        }
        if ($status_task == 2) {
			echo "<div class='list-group sign'>
                    <div class='list-group-item' style='line-height: 16.50px;'>
                    <div class='pull-left lh-fix'>     

                        <span class='glyphicon glyphicon-question-sign'></span>
                        <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <div class='row'>
                        <div class='col-md-3'>";
                            echo "<span class='color strong'><a href ='profile.php?username=" . $username_task . "'>"
                                . ucfirst($fname_task) . '&nbsp' . ucfirst($lname_task) . " </a></span><br>".$timetask."
                        </div>";      
                  echo "<div class='col-md-5'>
                            Owned By:  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br>" 
                            . $timefunct . "<br>ETA Taken: ". $etaown." <br/> Time Remaining : " . $remaintimeown . "
                        </div>
                        <div class='col-md-1 pull-right'>";
                            if ($ownid == $user_id) {
                                echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
                                        <input type='hidden' name='id' value='" . $id_task . "'/>
                                        <input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
                                    </form>";
                            } 
                            else {
                                dropDown_delete_after_accept($db_handle, $id_task, $user_id);
                            }
                    echo "</div>
                    </div>
                </div>";
        }

        if ($status_task == 4) {
			echo "<div class='list-group flag'>
                    <div class='list-group-item'>
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-flag'></span>
                        <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <div class='row' style='line-height: 16.50px;'>
                        <div class='col-md-3'>
                            <span class='color strong'><a href ='profile.php?username=" . $username_task . "'>"
                            . ucfirst($fname_task) . '&nbsp' . ucfirst($lname_task) . " </a></span><br>".$timetask."
                        </div>
                        <div class ='col-md-5'>
                            Owned By <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                .ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br>Submitted : " . $timefunct . "<br> 
                            ETA Taken: " . $timetaken . "
                        </div>
                        <div class='col-md-1 pull-right'>";
            if ($id_create == $user_id) {
                echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                        <input type='hidden' name='cid' value='" . $id_task . "'/>
                        <button type='submit' class='btn-primary' name='closechallenge'>Close</button>
                    </form>";
                dropDown_delete_after_accept($db_handle, $id_task, $user_id);
            }
            echo "</div></div></div>";
        }

        if ($status_task == 5) {
			echo "<div class='list-group flag'>
                    <div class='list-group-item' style='line-height: 16.50px;'>
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                       ";
                    echo "<div class='row'>
                            <div class='col-md-3'>
                				<span class='color strong' style= 'color :#3B5998;'>" . ucfirst($fname_task)." ".ucfirst($fname_task)."</a></span><br>" 
                                . $timefunct . "<br/>ETA Given: " . $etaown."
                            </div>
                            <div class='col-md-5'>
                                Owned By: <span class='color strong' style= 'color :#3B5998;'>" . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> </span><br>
                                Submitted On: ".$timecom . "<br>ETA Taken: ".$timetaken."
                            </div>
                            <div class='col-md-1 pull-right'>
                                <span class='color strong pull-right' style= 'color :#3B5998;'>Closed</span>";
                    dropDown_delete_after_accept($db_handle, $id_task, $user_id);
                   echo "</div>
                        </div>
                    </div>";
        }
    }

    echo "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'><b>" . ucfirst($title_task) . "</b></p>
				<small>" . str_replace("<s>", "&nbsp;", $stmt_task) . "</small><br/><br/>";
    if (($type_task == 1 || $type_task == 2 || $type_task == 5) && ($status_task == 4 || $status_task == 5)) {

        $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$id_task' and blob_id = '0' and status = '2')
												UNION
												(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$id_task' and a.status = '2' and a.blob_id = b.blob_id);");
        $answerrow = mysqli_fetch_array($answer);
        echo "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
				<p align='center'>Answer</p></span><br/>"
        . $answerrow['stmt'] . "<br/>";
    }

    $displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($displayrowb = mysqli_fetch_array($displaya)) {
        $fstname = $displayrowb['first_name'];
        $lstname = $displayrowb['last_name'];
        $username_commenter = $displayrowb['username'];
        $idc = $displayrowb['response_ch_id'];
        $chalangeres = $displayrowb['stmt'];
        echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_commenter.jpg'  onError=this.src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp<a href ='profile.php?username=" . $username_commenter . "'>" . ucfirst($fstname) . "&nbsp" . $lstname . "</a>&nbsp" .
        "</span><small>" . $chalangeres . "</small>";
        dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
        echo "</div>
			</div> 
		</div>";
    }
    echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='uploads/profilePictures/".$username.".jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                        <form action='' method='POST' class='inline-form'>
                                <input type='hidden' value='" . $id_task . "' name='own_challen_id' />
                                <input type='text' STYLE='border: 1px solid #bdc7d8; width: 84%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                        </form>
                    </div></div></div>";
}
?>
</div>
<?php
$echo = mysqli_query($db_handle, "select * from challenges where challenge_type = '6' ;");
if (mysqli_num_rows($echo) > 0) {
    echo "<h3 ><p align='center'> Notes</p></h3>";
}
?>             
<?php
$display_notes = mysqli_query($db_handle, "(select DISTINCT a.challenge_title,a.challenge_id, a.challenge_creation, a.user_id, a.stmt, b.first_name, b.last_name, b.username from challenges as a 
												join user_info as b where a.project_id = '$pro_id' and a.challenge_type = '6' and a.blob_id = '0' and a.user_id = b.user_id 
												)
												UNION
												(select DISTINCT a.challenge_title,a.challenge_id,a.challenge_creation, a.user_id, c.stmt, b.first_name, b.last_name, b.username from challenges as a 
												join user_info as b join blobs as c where a.project_id = '$pro_id' and a.challenge_type = '6' and a.blob_id = c.blob_id and a.user_id = b.user_id 
												) ORDER BY challenge_creation DESC;");

while ($displayrow = mysqli_fetch_array($display_notes)) {
    $notes = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $displayrow['stmt'])));
    $title = $displayrow['challenge_title'];
    $fname = $displayrow['first_name'];
    $lname = $displayrow['last_name'];
    $username_notes = $displayrow['username'];
    $note_posted_user_id = $displayrow['user_id'];
    $note_ID = $displayrow['challenge_id'];
    $note_created_on = $displayrow['challenge_creation'];
    $note_creation = date("j F, g:i a", strtotime($note_created_on));
    echo "<div class='list-group deciduous'>
		  <div class='list-group-item'>
		      <div class='pull-right'>
	 	        <div class='list-group-item'>
				   <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
				   <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                        if ($note_posted_user_id == $user_id) {
                            echo "<li><a class='btn-link' href='#'>Edit Note</a></li>
                                <li><a class='btn-link' noteID='" . $note_ID . "' onclick='delNote(" . $note_ID . ");'>Delete Note</a></li>";
                        } 
                        else {
                            echo "<li><a class='btn-link' >Report Spam</a></li>";
                        }
                        echo "</ul>
              </div>
			</div>
			<p align='center' style='font-size: 14pt;color :#3B5998;'>" . $title . "</p>
			<div class='pull-left lh-fix'>     
				<span class='glyphicon glyphicon-tree-deciduous'></span>
				<img src='uploads/profilePictures/$username_notes.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
			</div>
			<div style='line-height: 16.50px;'>
				<span class='pull-left color strong' style= 'color :#3B5998;'>
				<a href ='profile.php?username=" . $username_notes . "'>" . ucfirst($fname) . " " . ucfirst($lname) . "</a></span><br>".$note_creation." 
			</div>
			<small><br><br>" . $notes . "</small><br/><br/>";
    $display_comment_notes = mysqli_query($db_handle, "(select DISTINCT a.user_id, a.stmt, a.response_ch_id, a.response_ch_creation, b.first_name, b.last_name, b.username
										FROM response_challenge as a join user_info as b where a.challenge_id = " . $note_ID . " 
										and a.user_id = b.user_id and a.blob_id = '0')
										UNION
										(select DISTINCT a.user_id, c.stmt, a.response_ch_id, a.response_ch_creation, b.first_name, b.last_name, b.username
										 FROM response_challenge as a join user_info as b join blobs as c where a.challenge_id = " . $note_ID . "
										  and a.user_id = b.user_id and a.blob_id = c.blob_id);");
    while ($displayrowb = mysqli_fetch_array($display_comment_notes)) {
        $fstname = $displayrowb['first_name'];
        $lstname = $displayrowb['last_name'];
        $username_notes_comment = $displayrowb['username'];
        $idc = $displayrowb['response_ch_id'];
        $chalangeres = $displayrowb['stmt'];

        echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
						<img src='uploads/profilePictures/$username_notes_comment.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_notes_comment . "'>" . ucfirst($fstname) . " " . ucfirst($lstname) . "</a>&nbsp</span> 
						" . $chalangeres . "";
							dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
				echo "</div>
				</div> 
			</div>";
    }
    echo "<div class='comments clearfix'>
			<div class='pull-left lh-fix'>
                <img src='uploads/profilePictures/".$username.".jpg'  onError=this.src='img/default.gif'>&nbsp				</div>
				<form action='' method='POST' class='inline-form'>
                    <input type='hidden' value='" . $note_ID . "' name='own_challen_id' />
                    <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                </form>
			</div>
        </div>
    </div>";
}
?>
