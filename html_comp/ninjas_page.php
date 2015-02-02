<div class='list-group'>
	<div class='alert_placeholder'></div>
    <div id='step1' class='list-group-item'>
        <i class="icon-question-sign"></i><span onclick='show_form_h(7)' style="cursor: pointer;color: #000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Challenge</span>
        |
        <i class="icon-book"></i><span onclick='show_form_h(8)' style="cursor: pointer;color: #000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Article</span>
        |
        <i class="icon-picture"></i><span onclick='show_form_h(9)' style="cursor: pointer;color: #000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Photos</span>
        |
        <i class="icon-film"></i><span onclick='show_form_h(10)' style="cursor: pointer;color: #000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Videos</span>
        | 
        <i class="icon-lightbulb"></i><span onclick='show_form_h(11)' style="cursor: pointer;color: #000;font-family: Tenali Ramakrishna, sans-serif;font-size:20px;"> Ideas</span>
       <!-- | 
        <span class="icon-link" onclick='show_form_h(12)' style="cursor: pointer;color: #000;"> Share Links</span> -->
    </div>
    <div class='list-group-item'>
		<div id='textForm' ><p style="color: grey;">Please Select Post Type From Above ......</p></div>
		<div id='remindervalue'></div>
    </div>
</div>
<div class='newPosts' ></div>
<?php
$user_id = $_SESSION['user_id'];
$open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, a.last_update, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b where a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.project_id, a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time, a.last_update, b.first_name, b.last_name, b.username from challenges 
											as a join user_info as b join blobs as c WHERE a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											UNION
											(SELECT DISTINCT c.project_id, a.challenge_id, c.project_title, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, a.last_update, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b join projects as c where a.project_id = c.project_id and c.project_type='1' and a.challenge_type !='5' and a.challenge_type !='2' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT d.project_id, a.challenge_id, d.project_title, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time, a.last_update,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c join projects as d
											WHERE a.project_id = d.project_id and d.project_type='1' and a.challenge_status != '3' and a.challenge_status != '7' and a.challenge_type !='5' and a.challenge_type !='2' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											 ORDER BY last_update DESC LIMIT 0, 6;");
$_SESSION['lastpanel'] = '6';
$display_ch_stmt_content = "";
while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
    $chelange = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['stmt']))));
    $chelangestmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['stmt'])));
    $ETA = $open_chalangerow['challenge_ETA'];
    $ch_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['challenge_title']))));
    $chal_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['challenge_title'])));
    $owner_id = $open_chalangerow['user_id'];
    $open_project_id = $open_chalangerow['project_id'];
    $ctype = $open_chalangerow['challenge_type'];
    $frstname = $open_chalangerow['first_name'];
    $lstname = $open_chalangerow['last_name'];
    $username_ch_ninjas = $open_chalangerow['username'];
    $chelangeid = $open_chalangerow['challenge_id'];
    $status = $open_chalangerow['challenge_status'];
    $times = $open_chalangerow['creation_time'];
    $timefunction = date("j F, g:i a", strtotime($times));
    $timeopen = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['challenge_open_time']))));
    $sutime = eta($ETA);
    $remaintime = remaining_time($times, $ETA);
    $ownedby = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, a.time, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
    $ownedbyrow = mysqli_fetch_array($ownedby);
    $owneta = $ownedbyrow['comp_ch_ETA'];
    $owntime = $ownedbyrow['ownership_creation'];
    $owntimecom = $ownedbyrow['time'];
    $timecomm = date("j F, g:i a", strtotime($owntimecom));
    $timefunct = date("j F, g:i a", strtotime($owntime));
    $ownfname = $ownedbyrow['first_name'];
    $ownlname = $ownedbyrow['last_name'];
    $ownuser = $ownedbyrow['user_id'];
    $ownname = $ownedbyrow['username'];
    $initialtimen = strtotime($owntime) ;
	$endtimen = strtotime($owntimecom) ;
	$time_taken = ($endtimen-$initialtimen)/60 ;
    $timetakennin = eta($time_taken);
    $timeo = eta($owneta);
    $remaintimeown = remaining_time($owntime, $owneta);

	$totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$chelangeid' and like_status = '1' ;");
	if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
	else { $likes = '' ; }
	$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$chelangeid' and like_status = '2' ;");
	if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
	else { $dislikes = '' ; }
        
        // list grp item header for all type chall/article/idea/photo/video
        $display_tilte_ch = "<span style='font-family: Tenali Ramakrishna, sans-serif;' id='challenge_ti_".$chelangeid."' class='text'>
            <a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$chelangeid."' target='_blank'><b>".ucfirst($ch_title)."</b></a>
            </span><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$chelangeid."' value='".$chal_title."'/><br/>";
        $display_fname_likes = "<span style= 'color: #808080;'>
                &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "' style= 'color: #808080;'>".ucfirst($frstname)." ".ucfirst($lstname)."</a> | ".$timefunction."</span> | 
                    <span class='icon-hand-up' style='cursor: pointer;color: #808080;' onclick='like(\"".$chelangeid ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span> &nbsp
                    <span class='icon-hand-down' style='cursor: pointer;color: #808080;' onclick='dislike(\"".$chelangeid ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>";
        // list grp item stmt content for all type chall/article/idea/photo/video
        $display_ch_stmt_content .= "<hr/><span id='challenge_".$chelangeid."' class='text' style='line-height: 25px; font-size: 14px; color: #444;'>".$chelange."</span><br/>";
        $display_ch_stmt_content = $display_ch_stmt_content . editchallenge($chelangestmt, $chelangeid) ;             
    if ($ctype == 1) {
        if ($status == 1) {
            echo "<div class='list-group challenge'>
                        <div class='list-group-item'>";
                        dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;            
            //if ($remaintime != "Closed") {
                echo "<input class='btn btn-primary pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                                //. $timefunction . "<br> ETA : " . $sutime . "<br/>" . $remaintime;
            //} else {
               // echo " <br> " . $timefunction."<br>Closed";
            //}
                   echo $display_tilte_ch."<span class='icon-question-sign'></span>".$display_fname_likes.$display_ch_stmt_content;
                   $display_ch_stmt_content = "";
        } 
        if ($status == 2) {
            echo "<div class='list-group challenge'>
                    <div class='list-group-item' >";
          dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
            if($ownuser == $user_id) {			
                echo "<input class='btn btn-primary pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>" ;
            }
               echo $display_tilte_ch."<span class='icon-question-sign'></span>".$display_fname_likes. "
                        <hr>Accepted: <a href ='profile.php?username=" . $ownname ."' style= 'color: #808080;'>"
                            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | <span style= 'color: #808080;'>on ".$timefunct."</span>" ;
                        //  <br/> Time Remaining : " . $remaintimeown ."<br>
                   echo $display_ch_stmt_content;
                   $display_ch_stmt_content = "";
        }
        if ($status == 4) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
                dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
                    if($owner_id == $user_id) {			
                        echo "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
            }
                    echo $display_tilte_ch."<span class='icon-question-sign'></span>".$display_fname_likes."<hr>Submitted: 
							<a href ='profile.php?username=" . $ownname . "' style= 'color: #808080;'>"
                            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | <span style= 'color: #808080;'>Submitted: ".$timecomm."</span>" ;
                                            //. "<br/>  ETA Taken : " . $timeo ."
                    echo $display_ch_stmt_content;
                    $display_ch_stmt_content = "";
        }
        if ($status == 5) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
                dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
            echo $display_tilte_ch."<span class='icon-question-sign'></span>".$display_fname_likes. "<hr>Owned: 
								<a href ='profile.php?username=" . $ownname . "' style= 'color: #808080;'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | <span style= 'color: #808080;'>Submitted: " . $timecomm."</span>" ;
                                    //. "<br/> ETA Taken : " . $timetakennin . "
                echo $display_ch_stmt_content;
                $display_ch_stmt_content = "";
            }
    } 
    if ($ctype == 6) {
        echo "<div class='list-group articlesch'>
                <div class='list-group-item'>";
               dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
        echo $display_tilte_ch."<span class='icon-leaf'></span>".$display_fname_likes."| At: <a href='project.php?project_id=$open_project_id'>".ucfirst($timeopen)."</a>"
                .$display_ch_stmt_content;
        $display_ch_stmt_content = "";
    }
    if ($ctype == 9) {
        echo "<div class='list-group challenge'>
                <div class='list-group-item'>";
               dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
        echo $display_tilte_ch."<span class='icon-asterisk'></span>".$display_fname_likes."| At: <a href='project.php?project_id=$open_project_id'>".ucfirst($timeopen)."</a>"
                .$display_ch_stmt_content;
        $display_ch_stmt_content = "";
    }
    if ($ctype == 7) {
        echo "<div class='list-group articlesch'>
                <div class='list-group-item'>";
           dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
          echo $display_tilte_ch."<span class='icon-book'></span>".$display_fname_likes.$display_ch_stmt_content; 
          $display_ch_stmt_content = "";   
    }
    if ($ctype == 8) {
        echo "<div class='list-group film'>
                <div class='list-group-item'>";
                    dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
          echo $display_tilte_ch."<span class='icon-film'></span>".$display_fname_likes.$display_ch_stmt_content; 
          $display_ch_stmt_content = "";         
    } 
     if ($ctype == 4) {
        echo "<div class='list-group idea'>
                        <div class='list-group-item'>";
          dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
        echo $display_tilte_ch."<span class='icon-lightbulb'></span>".$display_fname_likes.$display_ch_stmt_content;
        $display_ch_stmt_content = "";
    } 
    if ($ctype == 3) {
        if ($status == 1) {
            echo "<div class='list-group challenge'>
                    <div class='list-group-item' >";
                    dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
                if ($owner_id != $user_id) {
                    echo "<input class='btn btn-primary pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                }
                else {
                    echo "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                }
                echo $display_tilte_ch."<span class='icon-question-sign'></span>".$display_fname_likes.$display_ch_stmt_content;
                $display_ch_stmt_content = "";
        }	
        if ($status == 6) {
        echo "<div class='list-group pict'>
                <div class='list-group-item'>";
                dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
               echo $display_tilte_ch."<span class='icon-picture'></span>".$display_fname_likes.$display_ch_stmt_content;
               $display_ch_stmt_content = "";
                    
        }
        if ($status == 4 || $status == 2) {
            echo "<div class='list-group challenge'>
                    <div class='list-group-item'>";
                     dropDown_challenge($chelangeid, $user_id, $remaintimeown, $owner_id) ;
                       $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
                        if ($owner_id != $user_id ) {
                            if(mysqli_num_rows($owneduser) == 0){
                                echo "<input class='btn btn-primary pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                            }
                        }
                        else {
                            echo "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                        }
                           echo $display_tilte_ch."<span class='icon-question-sign'></span>".$display_fname_likes;
                 $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.status, a.comp_ch_ETA, a.time, a.ownership_creation, b.first_name, b.last_name,b.username
                                                from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
            while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                $owtime = $ownedbrow['ownership_creation'];
                $owtimesub = $ownedbrow['time'];
                $timfunct = date("j F, g:i a", strtotime($owtime));
                $owtimesubmit = date("j F, g:i a", strtotime($owtimesub));
                $owfname = $ownedbrow['first_name'];
                $owlstatus = $ownedbrow['status'];
                $owlname = $ownedbrow['last_name'];
                $owname = $ownedbrow['username'];
                $initialtimen = strtotime($owtime) ;
				$endtimen = strtotime($owtimesub) ;
				$time_taken = ($endtimen-$initialtimen)/60 ;
				$timetakennin = eta($time_taken);
              if  ($owlstatus==1){
                echo "<hr/>Owned: <a href ='profile.php?username=" . $owname . "' style= 'color: #808080;'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a>| <span style= 'color: #808080;'>".$timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    echo "<input class='btn btn-primary pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>" ;
                }
            }
            if  ($owlstatus==2){
                echo "<hr/>Owned: <a href ='profile.php?username=" . $owname . "' style= 'color: #808080;'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | <span style= 'color: #808080;'>" . $timfunct." | Submitted: " .$owtimesubmit ;
                //." and Time Taken : ".$timetakennin."
            }
        }
       echo $display_ch_stmt_content;
       $display_ch_stmt_content = "";
    }
        if ($status == 5) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
                  dropDown_challenge($chelangeid, $user_id, $remaining_time_own, $owner_id) ;
                    echo $display_tilte_ch."<span class='icon-flag'></span>".$display_fname_likes;
                    $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.status, a.comp_ch_ETA, a.time, a.ownership_creation, b.first_name, b.last_name,b.username
                                                from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
            while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                $owtime = $ownedbrow['ownership_creation'];
                $owtimesub = $ownedbrow['time'];
                $timfunct = date("j F, g:i a", strtotime($owtime));
                $owtimesubmit = date("j F, g:i a", strtotime($owtimesub));
                $owfname = $ownedbrow['first_name'];
                $owlstatus = $ownedbrow['status'];
                $owlname = $ownedbrow['last_name'];
                $owname = $ownedbrow['username'];
                $initialtimen = strtotime($owtime) ;
				$endtimen = strtotime($owtimesub) ;
				$time_taken = ($endtimen-$initialtimen)/60 ;
				$timetakennin = eta($time_taken);
              if  ($owlstatus==1){
                echo "<hr/>Owned: <span style= 'color: #808080;'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | " . $timfunct."</span>";
                if ($ownedbrow['user_id'] == $user_id ) {
                    echo "<input class='btn btn-primary pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>" ;
                }
            }
            if  ($owlstatus==2){
                echo "<hr/>Owned: <a href ='profile.php?username=" . $owname . "' style= 'color: #808080;'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | ".$timfunct."| <span style= 'color: #808080;'>Submitted: " .$owtimesubmit."</span>" ;
                //." and Time Taken : ".$timetakennin."
            }
            }
            echo $display_ch_stmt_content;
            $display_ch_stmt_content = "";
        }
    }
    
    if ($status == 4 || $status == 5 || $status == 2) {
        $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$chelangeid' and blob_id = '0' and status = '2')
                                            UNION
                                            (select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$chelangeid' and a.status = '2' and a.blob_id = b.blob_id);");
        while ($answerrow = mysqli_fetch_array($answer)) {
            echo "<span class='color strong' style= 'font-size: 14pt;'>
                    <p align='center'>Answer</p></span>"
					. showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $answerrow['stmt'])))) . "<br/><br/>";
        }
    }
    $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $chelangeid AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$chelangeid' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $challenge_ID = $commenterRow['challenge_id'];
        $creater_ID = $commenterRow['user_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_of_ch = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $commenterRow['stmt']))));
        echo "<div id='commentscontainer'>
				<div class='comments clearfix showHere' id='comment_".$comment_id."'>
					<div class='pull-left lh-fix'>
					<img src='".resize_image("uploads/profilePictures/$username_comment_ninjas.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
					</div>" ;
				dropDown_delete_comment_ch($comment_id, $user_id, $creater_ID);
		echo "<div class='comment-text'>
				<span class='pull-left color strong'>&nbsp;<a href ='profile.php?username=".$username_comment_ninjas."'>".ucfirst($commenterRow['first_name'])." ".ucfirst($commenterRow['last_name'])."</a></span>
				&nbsp;&nbsp;" . $comment_of_ch;
        echo "</div></div></div>";
    }
    echo "<div class='comments_".$chelangeid."'></div>
        <div id='step15' class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
            </div>
            <input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$chelangeid."'
             placeholder='Want to know your comment....'/>
            <button type='submit' class='btn btn-primary' onclick='comment(\"".$chelangeid."\", 1)' style='margin-bottom: 10px;'>
            <span class='icon-chevron-right'></span></button>
        </div>";
    echo "</div> </div> ";
}
?>
