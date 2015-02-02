<?php 
include_once '../functions/delete_comment.php';
include_once '../functions/image_resize.php';
include_once '../lib/db_connect.php';
session_start();
$pro_id = $_GET['project_id'];
$user_id = $_SESSION['user_id'] ;
$username = $_SESSION['username'] ;
$projectData = mysqli_query($db_handle, "SELECT * FROM projects WHERE project_id = '$pro_id' ;");
$projectDataRow = mysqli_fetch_array($projectData) ;
$projectttitle = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $projectDataRow['project_title']))) ;
 if (isset($_SESSION['user_id'])) {
    ?>
    <div class='list-group'>
        <div id='demo1' class='list-group-item'>
          <i class="icon-pencil"></i><span onclick='show_form(1, "<?php echo $pro_id ; ?>")' style="cursor: pointer; color:#000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Challenge</span>
            | 
          <i class="icon-pushpin"></i><span onclick='show_form(2, "<?php echo $pro_id ; ?>")' style="cursor: pointer; color:#000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Assign Task</span>
            | 
          <i class="icon-leaf"></i><span onclick='show_form(5, "<?php echo $pro_id ; ?>")' style="cursor: pointer; color:#000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Notes</span>
            | 
          <i class="icon-hdd"></i><span onclick='show_form_pro(6, "<?php echo ucfirst($projectttitle) ; ?>", "<?php echo $pro_id ; ?>")' style="cursor: pointer; color:#000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Manage Files</span>
            | 
          <i class="icon-film"></i><span onclick='show_form(4, "<?php echo $pro_id ; ?>")' style="cursor: pointer; color:#000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Videos</span>
           | 
          <i class="icon-asterisk"></i><span onclick='show_form(13, "<?php echo $pro_id ; ?>")' style="cursor: pointer; color:#000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Issues</span>
        </div>
        <div class='list-group-item'>
			<div id='selecttext' ><p style="color: grey;">Please Select Post Type From Above ......</p></div> 
			<div id='invitation'></div>
		</div>           
    </div>
    <?php
	}
?>
<div class="panel-primary eye_open" id="prch">
    <p id='home-ch'></p>
    <div class='newPosts' ></div>
<?php
$_SESSION['lastpr'] = '5';
$display_task_stmt_content = "" ;
$tasks = mysqli_query($db_handle, "(SELECT DISTINCT a.last_update, a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, a.stmt, a.creation_time, 
									 a.challenge_type, a.challenge_status, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b
									 WHERE a.project_id = '$pro_id' AND a.challenge_status !='3' AND a.challenge_status !='7'
									 AND a.blob_id = '0' and a.user_id = b.user_id)
									UNION
									 (SELECT DISTINCT a.last_update, a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, c.stmt, a.creation_time, 
									 a.challenge_type, a.challenge_status, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b 
									 JOIN blobs AS c WHERE a.project_id = '$pro_id' AND a.challenge_status !='3' AND a.challenge_status !='7'
									 AND a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY last_update DESC LIMIT 0, 5 ;");
while ($tasksrow = mysqli_fetch_array($tasks)) {
    $username_task = $tasksrow['username'];
    $id_task = $tasksrow['challenge_id'];
    $id_create = $tasksrow['user_id'];
    $title_task = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $tasksrow['challenge_title']))));
    $tasktitle = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $tasksrow['challenge_title'])));
    $type_task = $tasksrow['challenge_type'];
    $status_task = $tasksrow['challenge_status'];
    $eta_task = $tasksrow['challenge_ETA'];
    $creation_task = $tasksrow['creation_time'];
    $timetask = date("j F, g:i a", strtotime($creation_task));
    $stmt_task = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $tasksrow['stmt']))));
    $taskstmt = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $tasksrow['stmt'])));
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
        $display_tilte_task = "<span style='font-family: Tenali Ramakrishna, sans-serif;' id='challenge_ti_".$id_task."' class='text'>
                                <b>
                                  <a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$id_task."' target='_blank'>"
                                    .ucfirst($title_task)."
                                  </a>
                                </b>
                              </span>
                              <input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$id_task."' value='".$tasktitle."'/><br/>";
        
        $dispaly_fname_likes ="<span style= 'color: #808080'>
                &nbspBy: <a style= 'color: #808080' href ='profile.php?username=" . $username_task . "'>".ucfirst($fname_task)." ".ucfirst($lname_task)."</a>&nbsp; |
                 ".$timetask." | </span><span class='icon-hand-up' style='cursor: pointer;color: #808080' onclick='like(\"".$id_task ."\", 3)'>
                         <input type='submit' class='btn-link' id='likes_".$id_task ."' value='".$likes."'/></span>
                    <span class='icon-hand-down' style='cursor: pointer;color: #808080' onclick='dislike(\"".$id_task ."\", 4)'>
                        <input type='submit' class='btn-link' id='dislikes_".$id_task ."' value='".$dislikes."'/>&nbsp;</span>";
        // list grp item stmt content for all type chall/article/idea/photo/video
        $display_task_stmt_content .= "<hr/>
                        <span id='challenge_".$id_task."' class='text' style='line-height:22px;font-size: 14px;'>".$stmt_task."</span><br/>";
        $display_task_stmt_content = $display_task_stmt_content. editchallenge($taskstmt, $id_task) ;
    
    if ($type_task == 5) {
        if ($status_task == 2) {
            echo "<div class='list-group pushpin'>
                    <div class='list-group-item'>
                    ";
            if (isset($_SESSION['user_id'])) {
                dropDown_challenge_pr($id_task, $user_id, $remaintimeown, $id_create) ;
            }
            if (($ownid == $user_id) && (isset($_SESSION['user_id']))) {
                echo "<input class='btn btn-primary pull-right' type='submit' onclick='answersubmit(\"".$id_task."\", 2)' value='Submit'/>";
            }
            
            echo $display_tilte_task."<span class='icon-pushpin'></span><span style= 'color: #808080'>
                &nbspBy: <a href ='profile.php?username=" . $username_task . "' style= 'color: #808080'>".ucfirst($fname_task)." ".ucfirst($lname_task)."</a>&nbsp
                     | Assigned To:&nbsp <a href ='profile.php?username=".$ownname."'>"
                .ucfirst($ownfname)." ".ucfirst($ownlname)."</a> | ".$timefunct." |  </span> 
                    <span class='icon-hand-up' style='cursor: pointer;color: #808080' onclick='like(\"".$id_task ."\", 3)'>
                         <input type='submit' class='btn-link' id='likes_".$id_task ."' value='".$likes."'/></span>
                    <span class='icon-hand-down' style='cursor: pointer;color: #808080' onclick='dislike(\"".$id_task ."\", 4)'>
                        <input type='submit' class='btn-link' id='dislikes_".$id_task ."' value='".$dislikes."'/>&nbsp;</span>";
             
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
            // " . $remaintimeown . "
        }
        if ($status_task == 4) {
            echo "<div class='list-group pushpin'>
                    <div class='list-group-item'>";
            if (($id_create == $user_id) && (isset($_SESSION['user_id']))) {
                echo "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$id_task."\", 6)'>Close</button>";
            }
            //	. "<br/> ETA Given:" .$etaown."
            echo $display_tilte_task."<span class='icon-pushpin'></span>".$dispaly_fname_likes.
            "<hr>Assigned To: <span class='color strong' style= 'color: #808080'>" . ucfirst($ownfname)." ".ucfirst($ownlname)."</a>
                | Submitted On: ".$timecom."</span>";
            // . " ETA Taken : " . $timetaken . "
            
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
        }
        if ($status_task == 5) {
            echo "<div class='list-group flag'>
                    <div class='list-group-item'>";
            echo "<span class='color strong pull-right' style= 'color: #808080'>Closed</span>";
            echo $display_tilte_task."<span class='icon-flag'></span>".$dispaly_fname_likes.
                "<hr>Assigned To: <span class='color strong' style= 'color: #808080'>"
                    .ucfirst($ownfname)." ".ucfirst($ownlname)."</a> | Submitted: " . $timecom."</span>";
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
         echo $display_tilte_task."<i class='icon-film'></i>".$dispaly_fname_likes;
         echo $display_task_stmt_content;
         $display_task_stmt_content = "" ;
        
    }
    if ($type_task == 6) {
        echo "<div class='list-group deciduous'>
                    <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
           dropDown_challenge_pr($id_task, $user_id, $remaintimeown, $id_create) ;
        }
         echo $display_tilte_task."<i class='icon-leaf'></i>".$dispaly_fname_likes;
         echo $display_task_stmt_content;
         $display_task_stmt_content = "" ;
        
    }
    if ($type_task == 9) {
        echo "<div class='list-group asterisk'>
                    <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
           dropDown_challenge_pr($id_task, $user_id, $remaintimeown, $id_create) ;
        }
         echo $display_tilte_task."<i class='icon-asterisk'></i>".$dispaly_fname_likes;
         echo $display_task_stmt_content;
         $display_task_stmt_content = "" ;
        
    }
    if ($type_task == 1 || $type_task == 2) {
        if ($status_task == 1) {
            echo "<div class='list-group sign'>
                    <div class='list-group-item'>";
            if (isset($_SESSION['user_id'])) {
               dropDown_challenge_pr($id_task, $user_id, $remaintimeown, $id_create) ;
                echo "<input class='btn btn-primary pull-right' type='submit' onclick='accept_pub(\"".$id_task."\", 5)' value='Accept'/>";
            }
            echo $display_tilte_task."<i class='icon-question-sign'></i>".$dispaly_fname_likes;
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
            // . "&nbsp&nbsp&nbsp with ETA : " . $tasketa . "<br/>" . $remaintime .             
        }

        else if ($status_task == 2) {
            echo "<div class='list-group sign'>
                    <div class='list-group-item'>";
            if (isset($_SESSION['user_id'])) {
                if ($ownid == $user_id) {
                    echo "<input class='btn btn-primary pull-right' type='submit' onclick='answersubmit(\"".$id_task."\", 2)' value='Submit'/>";
                } else {
                  dropDown_delete_after_accept_pr($id_task, $user_id, $id_create) ;
                }
            }
            echo $display_tilte_task."<i class='icon-question-sign'></i>".$dispaly_fname_likes;
            echo "<hr>Owned By: <span class='color strong' style= 'color: #808080'><a href ='profile.php?username=".$ownname."' style= 'color: #808080'>"
            .ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | ".$timefunct."</span>";
            //. "<br>ETA Taken: ". $etaown." <br/> Time Remaining : " . $remaintimeown . "
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
        }
        else if ($status_task == 4) {
            echo "<div class='list-group sign'>
                    <div class='list-group-item'>";
            if (($id_create == $user_id) && (isset($_SESSION['user_id']))) {
                echo "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$id_task."\", 6)'>Close</button>";
               dropDown_delete_after_accept_pr($id_task, $user_id, $id_create) ;
            }          
            echo $display_tilte_task."<span class='icon-question-sign'></span>".$dispaly_fname_likes."
            <hr>Owned By: <span class='color strong' style= 'color: #808080'><a href ='profile.php?username=" . $ownname . "' style= 'color: #808080'>"
            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | Submitted: ".$timecom."</span>";
            //. "<br>    ETA Taken: " . $timetaken . "
            echo $display_task_stmt_content;
            $display_task_stmt_content = "" ;
        }
        else if ($status_task == 5) {
            echo "<div class='list-group flag'>
                    <div class='list-group-item'>";
            echo "<span class='color strong pull-right' style= 'color :#3B5998;'>Closed</span>";
            if (isset($_SESSION['user_id'])) {
              dropDown_delete_after_accept_pr($id_task, $user_id, $id_create) ;
            }        
            //. "<br/>ETA Given: " . $etaown."
            echo $display_tilte_task."<span class='icon-flag'></span>".$dispaly_fname_likes."
                <hr>Owned By: <span class='color strong' style= 'color: #808080'><a href ='profile.php?username=" . $ownname . "' style= 'color: #808080'>" . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> 
                     | Submitted On: " . $timecom."</span>";
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
    if ($status_task == 4 || $status_task == 5) {

        $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$id_task' and blob_id = '0' and status = '2')
                                            UNION
                                            (select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$id_task' and a.status = '2' and a.blob_id = b.blob_id);");
        $answerrow = mysqli_fetch_array($answer);
        echo "<span class='color strong' style= 'font-size: 14pt;'>
				<p align='center'>Answer</p></span><br/>"
        . showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $answerrow['stmt'])))) . "<br/><br/>";
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
        $chalangeres = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $displayrowb['stmt']))));
        echo "
		<div id='commentscontainer'>
			<div class='comments clearfix' id='comment_".$idc."'>
				<div class='pull-left lh-fix'>
					<img src='".resize_image("uploads/profilePictures/$username_commenter.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
				</div>" ;
		if (isset($_SESSION['user_id'])) {
           dropDown_delete_comment_pr_ch($idc, $user_id, $idd) ;
        }
		echo "<div class='comment-text'>
					<span class='pull-left color strong'>
						<a href ='profile.php?username=" . $username_commenter . "'>" . ucfirst($fstname) . "&nbsp" . $lstname . "</a>&nbsp" .
        "</span><small>" . $chalangeres . "</small>";
        echo "</div>
			</div> 
		</div>";
    }
    echo "<div class='comments_".$id_task."'></div><div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
                        </div>";
    if (isset($_SESSION['user_id'])) {
        echo "<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$id_task."' placeholder='Want to know your comment....'/>
              <button type='submit' class='btn btn-primary' onclick='comment(\"".$id_task."\", 3)' style='margin-bottom: 10px;'>
                <span class='icon-chevron-right'></span>
              </button>";
    } else {
        echo "<input type='text' class='input-block-level' STYLE='width: 83.0%;' placeholder='Want to know your comment....'/>
                <a data-toggle='modal' data-target='#SignIn'>
                    <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px;'>
                      <span class='icon-chevron-right'></span>
                    </button>
                </a>";
    }
    echo "</div></div></div>";
}
?>
</div>
<script>
	$(".editbox").hide();
</script>
