<?="<div class='list-group'>
        <div class='list-group-item'>
            <span class='color strong' style= 'font-size: 14pt;'>" .ucfirst($projttitle) . "</span>
        </div>
    </div>"?>
<?php if (isset($_SESSION['user_id'])) {
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
            <div id='textForm'><p style="color: grey;"><I>Please Select Post Type From Above ......</I></p></div>
            <?php
            $_SESSION['project_id'] = $pro_id;
            ?>
            <div id='challegeprForm'>

                <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte .."/><br>
                <input class="btn btn-default btn-sm" type="file" id="_fileChallengepr" style ="width: auto;"><br/>
                <textarea rows="3" class="form-control" id="challangepr" placeholder="Description .. "></textarea><br>
                <!---<div class="inline-form">
                    Challenge Open For : <select class="btn btn-default btn-xs" id= "open_time" >	
                        <option value='0' selected >hour</option>
                <?php /*
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
                  } */
                ?>
                    </select>
                    <select class="btn btn-default btn-xs" id= "cc_etad" >	
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select>
                </div><br/><br/> --->
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
                $owner_project = mysqli_query($db_handle, "select user_id from projects where project_id = '$pro_id';");
                $owner_projectrow = mysqli_fetch_array($owner_project);
                $ownerof_project = $owner_projectrow['user_id'];
                if ($ownerof_project == $user_id) {
                    $teams = mysqli_query($db_handle, "select DISTINCT team_name from teams where project_id = '$pro_id' and status = '1';");
                    if (mysqli_num_rows($teams) > 0) {
                        $task = "";
                        $task .= "<div class='inline-form'>Assign To : &nbsp;&nbsp;
									<select class='btn-default btn-xs' id = 'teamtask' >
										<option value='0' selected > Select Team </option>";
                        while ($teamsrow = mysqli_fetch_array($teams)) {
                            $teamsname = $teamsrow['team_name'];
                            $task = $task . "<option value='" . $teamsname . "' >" . $teamsname . "</option>";
                        }
                        $task = $task . "</select>&nbsp;&nbsp;&nbsp;&nbsp;
									<select class='btn btn-default btn-xs' id= 'userstask' >	
										<option value='0' selected >Select Member </option>";
                        $users = mysqli_query($db_handle, "select DISTINCT a.user_id, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and 
												a.team_name IN (select DISTINCT team_name from teams where a.project_id = '$pro_id' and a.status = '1') 
												and a.member_status = '1' and a.user_id = b.user_id;");
                        while ($userssrow = mysqli_fetch_array($users)) {
                            $users_username_task = $userssrow['username'];
                            $u_id = $userssrow['user_id'];
                            $task = $task . "<option value='" . $u_id . "' >" . $users_username_task . "</option>";
                        }
                        $task = $task . "</select>&nbsp;&nbsp;&nbsp; <input type='email' id='emailtask' placeholder='Enter email-id'/></div><br/>
						<div class='input-group' >
						<span class='input-group-addon'>Title : </span>						
						<input type='text' class='form-control' id='title' placeholder='Tilte ..'/>
						</div><br>
						<input class='btn btn-default btn-sm' type='file' id='_fileTask' style ='width: auto;'><br/>
						<div class='input-group' >
							<span class='input-group-addon'>Task : </span>						
							<textarea rows='3' class='form-control' id='taskdetails' placeholder='Description .. ' style='max-width : 100%;'></textarea>
						</div><br> ";
                        /* <div class='inline-form'>
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
                          </div><br/> */
                        $task = $task . "<br/><input type='button' value='Assign' class='btn btn-success' id='create_task'/>";

                        echo $task;
                    } else {
                        echo "You hane no teams, Please create Team First";
                    }
                } else {
                    echo "Not authorised, please contact project owner";
                }
                ?>
            </div>
            <div id='teamForm'>
		<?php	$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
				 if(mysqli_num_rows($member_project) != 0) {
					 ?>
                <div class="input-group" >
                    <span class="input-group-addon">Team Name</span>
                    <input type="text" class="form-control" id="team_name_A" placeholder="Team name ..">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">Create Team with (Email)</span>
                    <input type="email" class="form-control" id = "email_team" placeholder="Enter First team member Email">
                </div>
                <br>
                <input type="submit" class="btn btn-success" id = "create_team" value = "Create New Team" >
         <?php } 
				else echo "Please Join Project First"; ?>
            </div>
            <div id='VideoFormpr'>
				<?php	$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
				 if(mysqli_num_rows($member_project) != 0) {
					 ?>
                <input type='text' class="form-control" id="video_titlepr" placeholder="Vedio title .."/><br>
                <input type='text' class="form-control" id="videoprjt" placeholder="Add Youtube URL"><br>
                <textarea rows="3" class="form-control" id="videodespr" placeholder="Description .."></textarea><br><br>
                <input type="button" value="Post" class="btn btn-success" id="create_videopr"/>
                <?php } 
				else echo "Please Join Project First"; ?>
            </div>
            <div id='notesForm'>
				<?php	$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
				 if(mysqli_num_rows($member_project) != 0) {
					 ?>
                <input type='text' class="form-control" id="notes_title" placeholder="Heading .."/><br>
                <input class="btn btn-default btn-sm" type="file" id="_fileNotes" style ="width: auto;"><br/>
                <textarea rows="3" class="form-control" id="notestmt" placeholder="Notes about Project or Importent Things about Project"></textarea><br><br>
                <input type="button" value="Post" class="btn btn-success" id="create_notes"/>
                <?php } 
				else echo "Please Join Project First"; ?>
            </div>
        <?php 
		echo "<div id='manageForm'>" ;
         $member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id';");
         if(mysqli_num_rows($member_project) != 0) {
					   echo "<div id='elfinder'></div>" ;
					}
					else { echo "Please Join Project First"; }
		echo "</div><br/>" ;
           ?>
        </div>
    </div>

    <?php
}

$project = mysqli_query($db_handle, "(SELECT a.user_id, a.project_ETA, a.creation_time, a.stmt, b.first_name, b.last_name, b.username FROM
                                            projects as a join user_info as b WHERE a.project_id = '$pro_id' and a.blob_id = '0' and a.user_id = b.user_id AND a.project_type !=3)
                                        UNION
                                            (SELECT a.user_id, a.project_ETA, a.creation_time, b.stmt, c.first_name, c.last_name, c.username FROM projects as a
                                            join blobs as b join user_info as c WHERE a.project_id = '$pro_id' and a.blob_id = b.blob_id and a.user_id = c.user_id AND a.project_type !=3);");
$project_row = mysqli_fetch_array($project);
$p_uid = $project_row['user_id'];
$projectst = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $project_row['stmt'])));
$fname = $project_row['first_name'];
$projectcreation = $project_row['creation_time'];
$lname = $project_row['last_name'];
$username_project = $project_row['username'];
$projecteta = $project_row['project_ETA'];
$timepr = eta($projecteta);
$prtime = remaining_time($projectcreation, $projecteta);
$timef = date("j F, g:i a", strtotime($projectcreation));
echo "<div class='list-group'>
        <div class='list-group-item'>
            <div class='pull-left lh-fix'>     
                <span class='glyphicon glyphicon-question-sign'></span>
                <img src='uploads/profilePictures/$username_project.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
            </div>";
if ($p_uid == $user_id) {
	
    echo "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
              <ul class='dropdown-menu' aria-labelledby='dropdown'>
                <li><button class='btn-link' href='#'>Edit Project</button></li>
                <li><button class='btn-link' onclick='delChallenge(\"".$pro_id."\", 4)'>Delete Project</button></li>
                <li>
                  <a data-toggle='modal' class='btn-link' data-target='#project_order'>Sort Order</a>
                </li>";
    /* if ($prtime == 'Closed') {
      echo "<form method='POST' class='inline-form'>
      <input type='hidden' name='id' value='" . $pro_id . "'/>
      <input class='btn-link' type='submit' name='eta_project_change' value='Change ETA'/>
      </form>";
      } */
    echo "</ul></div>";
}

echo "<div class='row'>
        <div class='col-md-4'>
          <span class='color strong' style= 'color :lightblue;'>
             <a href ='profile.php?username=" . $username_project . "'>" . ucfirst($fname) . '&nbsp' . ucfirst($lname) . "</a>
          </span>  <br/>" . $timef . "
        <br/></div>";
/*      <div class='col-md-5'>
  ETA in &nbsp".$timepr."<br>Time Left:".$prtime."
  </div> */
echo "</div>
     </div>
      <div class='list-group-item'>
            " . $projectst . "<br/><br/>";

$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.user_id, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '1')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.user_id, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");
while ($displayrowc = mysqli_fetch_array($displayb)) {
    $frstnam = $displayrowc['first_name'];
    $lnam = $displayrowc['last_name'];
    $username_pr_comment = $displayrowc['username'];
    $ida = $displayrowc['response_pr_id'];
    $idb = $displayrowc['user_id'];
    $projectres = $displayrowc['stmt'];
    echo "<div id='commentscontainer'>
            <div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                </div>
                <div class='comment-text'>
                    <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " 
                    " . ucfirst($lnam) . "</a>&nbsp</span> 
                    <small>" . $projectres . "</small>";
    if (isset($_SESSION['user_id'])) {
       dropDown_delete_comment_pr($ida, $user_id, $idb) ;
    }
    echo "</div>
         </div> 
        </div>";
}
echo "<div class='comments_".$pro_id."'></div><div class='comments clearfix'>
			<div class='pull-left lh-fix'>
				<img src='uploads/profilePictures/" . $username . ".jpg'  onError=this.src='img/default.gif'>&nbsp
			</div>";
if (isset($_SESSION['user_id'])) {
    echo "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' id='own_ch_response_".$pro_id."' placeholder='Want to know your comment....' />
            <button type='submit' onclick='comment(\"".$pro_id."\", 2)' class='btn-primary btn-sm glyphicon glyphicon-play'></button>";
} else {
    echo "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
			<a data-toggle='modal' data-target='#SignIn'>
				<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
			</a>";
}
echo "</div>
	</div>
</div>";
?>

<div class="panel-primary eye_open" id="prch">
    <p id='home-ch'></p>
<?php
$_SESSION['lastpr'] = '10';
$_SESSION['project_id'] = $pro_id;
$display_task_stmt_content = "" ;
$tasks = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, a.stmt, a.creation_time, a.challenge_type,
									a.challenge_status, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b
									 WHERE a.project_id = '$pro_id' AND a.challenge_status !='3' AND a.challenge_status !='7'
									AND a.blob_id = '0' and a.user_id = b.user_id)
									UNION
								 (SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, c.stmt,a.creation_time, a.challenge_type,
								  a.creation_time, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN blobs AS c 
								  WHERE a.project_id = '$pro_id' AND a.challenge_status !='3' AND a.challenge_status !='7'
								   AND a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY creation_time ".$sort_by." LIMIT 0, 10 ;");
while ($tasksrow = mysqli_fetch_array($tasks)) {
    $username_task = $tasksrow['username'];
    $id_task = $tasksrow['challenge_id'];
    $id_create = $tasksrow['user_id'];
    $title_task = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $tasksrow['challenge_title'])));
    $type_task = $tasksrow['challenge_type'];
    $status_task = $tasksrow['challenge_status'];
    $eta_task = $tasksrow['challenge_ETA'];
    $creation_task = $tasksrow['creation_time'];
    $timetask = date("j F, g:i a", strtotime($creation_task));
    $stmt_task = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $tasksrow['stmt'])));
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
	$totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$id_task' and like_status = '1' ;");
	if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
	else { $likes = '' ; }
	$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$id_task' and like_status = '2' ;");
	if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
	else { $dislikes = '' ; }
        
        // list grp item header for all type chall/article/idea/photo/video
        $display_tilte_task = "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif' id='challenge_ti_".$id_task."' class='text'><b>
            <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$id_task."' target='_blank'>".ucfirst($title_task)."</a></b></p><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$id_task."' value='".$title_task."'/>";
        
        $dispaly_fname_likes ="<span style= 'color: #808080'>
                &nbspBy: <a href ='profile.php?username=" . $username_task . "'>".ucfirst($fname_task)." ".ucfirst($lname_task)."</a>&nbsp</span> |
                 ".$timefunct." | <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$id_task ."\", 3)'>
                         <input type='submit' class='btn-link' id='likes_".$id_task ."' value='".$likes."'/></span>
                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$id_task ."\", 4)'>
                        <input type='submit' class='btn-link' id='dislikes_".$id_task ."' value='".$dislikes."'/>&nbsp;</span>";
        // list grp item stmt content for all type chall/article/idea/photo/video
        $display_task_stmt_content .= "<br></div>                    
                    <div class='list-group-item'><br>
                        <span id='challenge_".$id_task."' class='text'>".$stmt_task."</span>
                        <input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$id_task."' value='".$title_task."'/><br/><br/>";
    if(isset($_SESSION['user_id'])){
		if(substr($stmt_task, 0, 1) != '<') {
$display_task_stmt_content = $display_task_stmt_content."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$id_task."' >".$stmt_task."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$id_task.")' id='doneedit_".$id_task."'/>";
			}
		else {
			if (substr($stmt_task, 0, 4) == ' <br') {
$display_task_stmt_content = $display_task_stmt_content."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$id_task."' >".$stmt_task."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$id_task.")' id='doneedit_".$id_task."'/>";
				}
			if (substr($stmt_task, 0, 3) == '<s>') {
$display_task_stmt_content = $display_task_stmt_content."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$id_task."' >".$stmt_task."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$id_task.")' id='doneedit_".$id_task."'/>";
				}
			$chaaa = substr(strstr($stmt_task, '<br/>'), 5) ;
			$cha = strstr($stmt_task, '<br/>' , true) ;
			if(substr($stmt_task, 0, 4) == '<img') {
$display_task_stmt_content = $display_task_stmt_content."<div class='editbox' style='width : 90%;' id='challenge_pic_".$id_task."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$id_task.")' id='pic_file_".$id_task."'/><br/><br/>" ;
					}
			if(substr($stmt_task, 0, 2) == '<a') {
$display_task_stmt_content = $display_task_stmt_content."<div class='editbox' style='width : 90%;' id='challenge_file_".$id_task."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$id_task.")' id='pic_file_".$id_task."'/><br/><br/>" ;
					}
			if(substr($stmt_task, 0, 3) == '<if') {
$display_task_stmt_content = $display_task_stmt_content."<div class='editbox' style='width : 90%;' id='challenge_video_".$id_task."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$id_task."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
$display_task_stmt_content = $display_task_stmt_content."<input id='_fileChallenge_".$id_task."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn-success btn-xs editbox' value='Upload New Photo/File' onclick='save_pic_file(".$id_task.")' id='pic_file_save_".$id_task."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$id_task."' >".$chaaa."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedchallenge(".$id_task.")' id='doneediting_".$id_task."'/>";		
			}
		}
    if ($type_task == 5) {
        if ($status_task == 2) {
            echo "<div class='list-group pushpin'>
                    <div class='list-group-item'>
                    ";
            if (isset($_SESSION['user_id'])) {
                dropDown_challenge_pr($id_task, $user_id, $remaintimeown, $id_create) ;
            }
            if (($ownid == $user_id) && (isset($_SESSION['user_id']))) {
                echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$id_task."\", 2)' value='Submit'/>";
            }
            
            echo $display_tilte_task."<span class='glyphicon glyphicon-pushpin'></span><span style= 'color: #808080'>
                &nbspBy: <a href ='profile.php?username=" . $username_task . "'>".ucfirst($fname_task)." ".ucfirst($lname_task)."</a>&nbsp</span>
                     | Assigned To:&nbsp <a href ='profile.php?username=".$username_task."'>"
                .ucfirst($ownfname)." ".ucfirst($ownlname)."</a></span> | ".$timefunct." | 
                    <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$id_task ."\", 3)'>
                         <input type='submit' class='btn-link' id='likes_".$id_task ."' value='".$likes."'/></span>
                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$id_task ."\", 4)'>
                        <input type='submit' class='btn-link' id='dislikes_".$id_task ."' value='".$dislikes."'/>&nbsp;</span>";
             
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
            // " . $remaintimeown . "
        }
        if ($status_task == 4) {
            echo "<div class='list-group pushpin'>
                    <div class='list-group-item'>";
            if (($id_create == $user_id) && (isset($_SESSION['user_id']))) {
                echo "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$id_task."\", 6)'>Close</button>";
            }
            //	. "<br/> ETA Given:" .$etaown."
            echo $display_tilte_task."<span class='glyphicon glyphicon-pushpin'></span>".$dispaly_fname_likes.
            "<br><hr>Assigned To: <span class='color strong' style= 'color :#3B5998;'>" . ucfirst($ownfname)." ".ucfirst($ownlname)."</a></span>
                | Submitted On: ".$timecom;
            // . " ETA Taken : " . $timetaken . "
            
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
        }
        if ($status_task == 5) {
            echo "<div class='list-group flag'>
                    <div class='list-group-item'>";
            echo "<span class='color strong pull-right' style= 'color :#3B5998;'><p>Closed</p></span>";
            echo $display_tilte_task."<span class='glyphicon glyphicon-flag'></span>".$dispaly_fname_likes.
                "<br><hr>Assigned To: <span class='color strong' style= 'color :#3B5998;'>"
                    .ucfirst($ownfname)." ".ucfirst($ownlname)."</a></span> | Submitted: " . $timecom;
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
            //. "<br/>ETA Given:" .$etaown."
           			        
            //. "<br> ETA Taken : " . $timetaken . "
        }
    }
    if ($type_task == 8) {
        echo "<div class='list-group videofilm'>
                    <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
           dropDown_challenge_pr($id_task, $user_id, $remaintimeown, $id_create) ;
        }
         echo $display_tilte_task."<span class='glyphicon glyphicon-film'></span>".$dispaly_fname_likes;
         echo $display_task_stmt_content;
         $display_task_stmt_content = "" ;
        
    }
    if ($type_task == 6) {
        echo "<div class='list-group deciduous'>
                    <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
           dropDown_challenge_pr($id_task, $user_id, $remaintimeown, $id_create) ;
        }
         echo $display_tilte_task."<span class='glyphicon glyphicon-tree-deciduous'></span>".$dispaly_fname_likes;
         echo $display_task_stmt_content;
         $display_task_stmt_content = "" ;
        
    }
    if ($type_task == 1 || $type_task == 2) {
        if ($status_task == 1) {
            echo "<div class='list-group sign'>
                    <div class='list-group-item'>";
            if (isset($_SESSION['user_id'])) {
               dropDown_challenge_pr($id_task, $user_id, $remaintimeown, $id_create) ;
                echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$id_task."\", 5)' value='Accept'/>";
            }
            echo $display_tilte_task."<span class='glyphicon glyphicon-question-sign'></span>".$dispaly_fname_likes;
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
            // . "&nbsp&nbsp&nbsp with ETA : " . $tasketa . "<br/>" . $remaintime .             
        }
        if ($status_task == 2) {
            echo "<div class='list-group sign'>
                    <div class='list-group-item'>";
            if (isset($_SESSION['user_id'])) {
                if ($ownid == $user_id) {
                    echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$id_task."\", 2)' value='Submit'/>";
                } else {
                  dropDown_delete_after_accept_pr($id_task, $user_id, $id_create) ;
                }
            }
            echo $display_tilte_task."<span class='glyphicon glyphicon-question-sign'></span>".$dispaly_fname_likes;
            echo "<br><hr>Owned By: <span class='color strong'><a href ='profile.php?username=".$ownname."'>"
            .ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span> | ".$timefunct;
            //. "<br>ETA Taken: ". $etaown." <br/> Time Remaining : " . $remaintimeown . "
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
        }
        if ($status_task == 4) {
            echo "<div class='list-group flag'>
                    <div class='list-group-item'>";
            if (($id_create == $user_id) && (isset($_SESSION['user_id']))) {
                echo "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$id_task."\", 6)'>Close</button>";
               dropDown_delete_after_accept_pr($id_task, $user_id, $id_create) ;
            }          
            echo $display_tilte_task."<span class='glyphicon glyphicon-question-sign'></span>".$dispaly_fname_likes."
            <br><hr>Owned By: <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span> | Submitted: ".$timefunct;
            //. "<br>    ETA Taken: " . $timetaken . "
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
        }
        if ($status_task == 5) {
            echo "<div class='list-group flag'>
                    <div class='list-group-item'>";
            echo "<span class='color strong pull-right' style= 'color :#3B5998;'>Closed</span>";
            if (isset($_SESSION['user_id'])) {
              dropDown_delete_after_accept_pr($id_task, $user_id, $id_create) ;
            }        
            //. "<br/>ETA Given: " . $etaown."
            echo $display_tilte_task."<span class='glyphicon glyphicon-flag'></span>".$dispaly_fname_likes."
                <br><hr>Owned By: <span class='color strong' style= 'color :#3B5998;'>" . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> 
                    </span> | Submitted On: " . $timecom;
            //. "<br>ETA Taken: ".$timetaken."
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
        }
    }
/*	
    echo "<div class='list-group-item'><p align='center' style='font-size: 14pt;' id='challenge_ti_".$id_task."' class='text'><b>" . ucfirst($title_task) . "</b></p>
			<br/><span id='challenge_".$id_task."' class='text' >".$stmt_task."</span>
			<input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$id_task."' value='".$title_task."'/>" ;
 */
    if (($type_task == 1 || $type_task == 2 || $type_task == 5) && ($status_task == 4 || $status_task == 5)) {

        $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$id_task' and blob_id = '0' and status = '2')
                                            UNION
                                            (select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$id_task' and a.status = '2' and a.blob_id = b.blob_id);");
        $answerrow = mysqli_fetch_array($answer);
        echo "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
				<p align='center'>Answer</p></span><br/>"
        . str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $answerrow['stmt']))) . "<br/>";
    }

    $displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
										JOIN user_info as b WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
										 UNION
										  (SELECT DISTINCT c.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
										JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($displayrowb = mysqli_fetch_array($displaya)) {
        $fstname = $displayrowb['first_name'];
        $lstname = $displayrowb['last_name'];
        $username_commenter = $displayrowb['username'];
        $idc = $displayrowb['response_ch_id'];
        $idd = $displayrowb['user_id'];
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
        if (isset($_SESSION['user_id'])) {
           dropDown_delete_comment_pr_ch($idc, $user_id, $idd) ;
        }
        echo "</div>
			</div> 
		</div>";
    }
    echo "<div class='comments_".$id_task."'></div><div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='uploads/profilePictures/" . $username . ".jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>";
    if (isset($_SESSION['user_id'])) {
        echo "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$id_task."' placeholder='Want to know your comment....'/>
              <button type='submit' class='btn-sm btn-primary glyphicon glyphicon-chevron-right' onclick='comment(\"".$id_task."\", 3)' ></button>";
    } else {
        echo "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
                <a data-toggle='modal' data-target='#SignIn'>
                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                </a>";
    }
    echo "</div></div></div>";
}
?>
</div>
