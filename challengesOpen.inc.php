<?php
session_start();
include_once 'functions/delete_comment.php';
include_once 'lib/db_connect.php';
include_once 'models/challenge.php';
$obj = new challenge($_GET['challenge_id']);
$challengeSearchID = $_GET['challenge_id'];
$challengeSearchIDR = $_GET['challenge_id'];
$private_check = mysqli_query($db_handle, "SELECT challenge_type FROM challenges WHERE challenge_id = $challengeSearchID");
$private_checkRow = mysqli_fetch_array($private_check);
$private_ch_type = $private_checkRow['challenge_type'];
if (!isset($_SESSION['user_id']) AND $private_ch_type == 2) {
    include_once 'error.php';
    exit;
} 
elseif (isset($_SESSION['user_id']) AND $private_ch_type == 2) {
    $userID = $_SESSION['user_id'];
    $private_ch_fn = private_challenge_access($db_handle, $userID, $challengeSearchID);
    if ($private_ch_fn == 0) {
        include_once 'error.php';
        exit;
    }
}
$open_chalange = mysqli_query($db_handle, "SELECT DISTINCT challenge_id, challenge_title from challenges 
            WHERE challenge_status != 3 AND challenge_status != 7 AND challenge_id='$challengeSearchID';");
$open_chalangeRtitle = mysqli_fetch_array($open_chalange);
$challenge_page_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangeRtitle['challenge_title'])));
function chOpen_title($title_length) {
    if (strlen($title_length) < 40) {
        echo  $title_length;
    } else {
        echo substr($title_length, 0, 40)."....";
    }
}
$emptySearch = mysqli_num_rows($open_chalange);
if ($emptySearch == 0) {
    include_once 'error.php';
    exit;                       //echo "no longer exists";
}
function private_challenge_access($db_handle, $user_id, $challenge_id) {
    $public_Private = mysqli_query($db_handle, "SELECT user_id FROM challenges WHERE challenge_id = $challenge_id AND user_id = $user_id AND challenge_type = 2;");
    $public_PrivateRow = mysqli_num_rows($public_Private);
    return $public_PrivateRow;
}
$challengeSearch_user = mysqli_query($db_handle, "SELECT a.user_id, b.username, b.first_name, b.last_name from challenges as a JOIN user_info as b WHERE a.challenge_id = $challengeSearchID AND a.user_id=b.user_id;");
$challengeSearch_user_IDRow = mysqli_fetch_array($challengeSearch_user);
$challengeSearch_user_ID = $challengeSearch_user_IDRow['user_id'];
$ch_username = $challengeSearch_user_IDRow['username'];
$challengeSearch_first = $challengeSearch_user_IDRow['first_name'];
$challengeSearch_last = $challengeSearch_user_IDRow['last_name'];

function challenge_display($db_handle, $challengeSearchID) {
    
    $open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
                                                a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
                                                as a join user_info as b where a.challenge_id = '$challengeSearchID' AND a.challenge_status != '3' and a.challenge_status != '7' 
                                                and blob_id = '0' and a.user_id = b.user_id)
                                            UNION
                                                (SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
                                                b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
                                                WHERE a.challenge_id = '$challengeSearchID' AND a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id );");

        while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
            $chelange = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['stmt'])));
            $ETA = $open_chalangerow['challenge_ETA'];
            $ch_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['challenge_title'])));
            $owner_id = $open_chalangerow['user_id'];
            $ctype = $open_chalangerow['challenge_type'];
            $frstname = $open_chalangerow['first_name'];
            $lstname = $open_chalangerow['last_name'];
            $username_ch_ninjas = $open_chalangerow['username'];
            $chelangeid = $open_chalangerow['challenge_id'];
            $status = $open_chalangerow['challenge_status'];
            $times = $open_chalangerow['creation_time'];
            $timefunction = date("j F, g:i a", strtotime($times));
            $timeopen = $open_chalangerow['challenge_open_time'];
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
        $display_title = "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif' id='challenge_ti_".$chelangeid."' class='text'><b>
							<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$chelangeid."' target='_blank'>".ucfirst($ch_title)."</a></b>
						</p><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$chelangeid."' value='".$ch_title."'/>";
        $display_name_stmt .= "<span style= 'color: #808080'>
                &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a> | ".$timefunction."</span> | 
                    <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$chelangeid ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span> &nbsp
                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$chelangeid ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span></div>                    
                       <div class='list-group-item'>
                        <br/><span id='challenge_".$chelangeid."' class='text' style='line-height: 25px; font-size: 14px; font-family: Georgia, Times New Roman, Times,serif; color: #444;'>".$chelange."</span><br/><br/>";
        //    $display_title =  "<p style='font-famiy: Calibri,sans-serif; font-size: 32px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>" 
          //                              .ucfirst($ch_title)."</b></p>";
           // $display_name_stmt = "<span style= 'color: #808080'>
             //               By: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a> | Posted ".$timefunction."</span></div>                    
               //             <div class='list-group-item'>
                 //           <br/><span style='line-height: 25px; font-size: 16px; font-family: Georgia, Times New Roman, Times,serif; color: #444;'>" .$chelange . "</span><br/><br/>";
            if (isset ($_SESSION['user_id'])) {
				$user_id = $_SESSION['user_id'];
		if(substr($chelange, 0, 1) != '<') {
$display_name_stmt = $display_name_stmt."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
			}
		else {
			if (substr($chelange, 0, 4) == ' <br') {
$display_name_stmt = $display_name_stmt."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
				}
			if (substr($chelange, 0, 3) == '<s>') {
$display_name_stmt = $display_name_stmt."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
				}
			$chaaa = substr(strstr($chelange, '<br/>'), 5) ;
			$cha = strstr($chelange, '<br/>' , true) ;
			if(substr($chelange, 0, 4) == '<img') {
$display_name_stmt = $display_name_stmt."<div class='editbox' style='width : 90%;' id='challenge_pic_".$chelangeid."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$chelangeid.")' id='pic_file_".$chelangeid."'/><br/><br/>" ;
					}
			if(substr($chelange, 0, 2) == '<a') {
$display_name_stmt = $display_name_stmt."<div class='editbox' style='width : 90%;' id='challenge_file_".$chelangeid."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$chelangeid.")' id='pic_file_".$chelangeid."'/><br/><br/>" ;
					}
			if(substr($chelange, 0, 3) == '<if') {
$display_name_stmt = $display_name_stmt."<div class='editbox' style='width : 90%;' id='challenge_video_".$chelangeid."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$chelangeid."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
$display_name_stmt = $display_name_stmt."<input id='_fileChallenge_".$chelangeid."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn-success btn-xs editbox' value='Upload New Photo/File' onclick='save_pic_file(".$chelangeid.")' id='pic_file_save_".$chelangeid."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$chelangeid."' >".$chaaa."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedchallenge(".$chelangeid.")' id='doneediting_".$chelangeid."'/>";		
			}
            if ($ctype == 1 or $ctype == 2) {
                if ($status == 1) {
                    echo "<div class='list-group challenge'>
                                <div class='list-group-item'>";
                   dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
                    //if ($remaintime != "Closed") {
                        echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                                        //. $timefunction . "<br> ETA : " . $sutime . "<br/>" . $remaintime;
                    //} else {
                    // echo " <br> " . $timefunction."<br>Closed";
                    //}
                          echo $display_title."<span class='glyphicon glyphicon-question-sign'></span>".$display_name_stmt;
                } 
                if ($status == 2) {
                    echo "<div class='list-group challenge'>
                            <div class='list-group-item'>";
                  dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
                    if($ownuser == $user_id) {			
                        echo "<input class='btn btn-primary btn-sm pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
                    }
                    echo $display_title."<span class='glyphicon glyphicon-question-sign'></span>
                                        <span style= 'color: #808080'>
                                        &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a> | ".$timefunction."</span>
                                            <br><hr>Accepted: <a href ='profile.php?username=" . $ownname . "'>"
                                        . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></div>";
                                        //  <br/> Time Remaining : " . $remaintimeown ."<br>
                                echo "<div class='list-group-item'>
                                    <br/>" .$chelange . "<br/><br/>";   
                    }
                if ($status == 4) {
                    echo "<div class='list-group openchalhide'>
                            <div class='list-group-item'>";
                     if($owner_id == $user_id) {			
                        echo "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                    }
                  dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
                    echo $display_title."
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <span style= 'color: #808080'>
                            &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a> | ".$timefunction."
                                <br><hr>Submitted: <a href ='profile.php?username=" . $ownname . "'>"
                                        . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . "</a> | " . $timecomm."</div>";
                                        //. "<br/>  ETA Taken : " . $timeo;
                                        //  <br/> Time Remaining : " . $remaintimeown ."<br>
                                echo "<div class='list-group-item'>
                                    <br/>" .$chelange . "<br/><br/>";
                }
                if ($status == 5) {
                    echo "<div class='list-group openchalhide'>
                            <div class='list-group-item' >";
                          dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
                    echo $display_title."<span class='glyphicon glyphicon-flag'></span>
                            <span style= 'color: #808080'>
                            &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a></span> | ".$timefunction."
                                <br><hr>Owned: <a href ='profile.php?username=" . $ownname . "'>"
                                . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> | ".$timecomm;
                                //. "<br/> ETA Taken : " . $timetakennin . "
                                echo "</div><div class='list-group-item'>
                                    <br/>" .$chelange . "<br/><br/>";
                }
            } 
            else if ($ctype == 3) {
                if ($status == 1) {
                    echo "<div class='list-group challenge'>
                            <div class='list-group-item'>";
                      dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
                        if ($owner_id != $user_id) {
                            echo "<input class='btn btn-primary btn-default-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                        }
                    else {
                        echo "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                    }
                    echo $display_title."<span class='glyphicon glyphicon-question-sign'></span>".$display_name_stmt;
                }	
                if ($status == 6) {
                echo "<div class='list-group film'>
                        <div class='list-group-item'>";
                      dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
                        echo $display_title."<span class='glyphicon glyphicon-question-picture'></span>".$display_name_stmt;
                }
                if ($status == 2) {
                    echo "<div class='list-group challenge'>
                            <div class='list-group-item' >";

                    $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
                    if ($owner_id != $user_id ) {
                        if(mysqli_num_rows($owneduser) == 0){
                            echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                        }
                    }
                    else {
                        echo "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                    }
                    echo $display_title."<span class='glyphicon glyphicon-question-sign'></span>
                            <span style= 'color: #808080'>
                            &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a></span> | ".$timefunction."
                            <br>";
                                
                    $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
                                                        from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
                    while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                        $owtime = $ownedbrow['ownership_creation'];
                        $timfunct = date("j F, g:i a", strtotime($owtime));
                        $owfname = $ownedbrow['first_name'];
                        $owlname = $ownedbrow['last_name'];
                        $owname = $ownedbrow['username'];
                        echo "<hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                        . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | ".$timfunct;
                        if ($ownedbrow['user_id'] == $user_id ) {
                            echo "<input class='btn btn-primary btn-sm pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
                        }
                    }
                    echo "</div><div class='list-group-item'>
                            <br/>" .$chelange . "<br/><br/>";
                } 
                 
                if ($status == 4) {
                    echo "<div class='list-group challenge'>
                            <div class='list-group-item' >";
                        $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
                    if ($owner_id != $user_id ) {
                        if(mysqli_num_rows($owneduser) == 0){
                            echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                        }
                    }
                    else {
                        echo "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                    }
                echo $display_title."<span class='glyphicon glyphicon-question-sign'></span>
                            <span style= 'color: #808080'>
                            &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a></span> | ".$timefunction."
                        <br>";
                
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
                    if  ($owlstatus==1) {
                        echo "<hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                        . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | ".$timfunct;
                        if ($ownedbrow['user_id'] == $user_id ) {
                            echo "<input class='btn btn-primary btn-sm pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
                        }
                    }
                    if  ($owlstatus==2){
                        echo "<hr>Submitted: <a href ='profile.php?username=" . $owname . "'>"
                        . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | ".$owtimesubmit ;
                        //." and Time Taken : ".$timetakennin."
                    }
                }
                echo "</div><div class='list-group-item'>
                            <br/>" .$chelange . "<br/><br/>";
            }
                 
                if ($status == 5) {
                    echo "<div class='list-group openchalhide'>
                        <div class='list-group-item' >";
                      echo $display_title."<span class='glyphicon glyphicon-flag'></span>
                            <span style= 'color: #808080'>
                            &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a></span> | ".$timefunction."
                        <br>";      
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
                        echo "<hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                        .ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span> | " . $timfunct;
                        if ($ownedbrow['user_id'] == $user_id ) {
                            echo "<input class='btn btn-primary btn-sm pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
                        }
                    }
                    if  ($owlstatus==2){
                        echo "<hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                        . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | ".$timfunct." | Submitted: " .$owtimesubmit ;
                        //." and Time Taken : ".$timetakennin."
                    }
                }
                echo "</div><div class='list-group-item'>
                            <br/>" .$chelange . "<br/><br/>";
            }
        }
            else if ($ctype == 4) {
                echo "<div class='list-group idea'>
                                <div class='list-group-item'>";
              dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
                echo $display_title."<span class='glyphicon glyphicon-flash'></span>".$display_name_stmt;
            }
            else if ($ctype == 5) {
                echo "<div class='list-group tree'>
                                <div class='list-group-item'>";
               dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
                            echo $display_title."<span class='glyphicon glyphicon-pushpin'></span>".$display_name_stmt;
            }
            else if ($ctype == 6) {
                echo "<div class='list-group deciduous'>
                                <div class='list-group-item'>";
              dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
                           echo $display_title."<span class='glyphicon glyphicon-tree-deciduous'></span>".$display_name_stmt;
            }
            else if ($ctype == 7) {
                echo "<div class='list-group articlesch'>
                                        <div class='list-group-item'>";
             dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;                
               echo $display_title."<span class='glyphicon glyphicon-book'></span>".$display_name_stmt;
            }
            else if ($ctype == 8) {
                echo "<div class='list-group film'>
                                        <div class='list-group-item'>";
             dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
                  echo $display_title."<span class='glyphicon glyphicon-film'></span>".$display_name_stmt;
            } 
            
            if ($status == 4 || $status == 5) {
                $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$chelangeid' and blob_id = '0' and status = '2')
                                                    UNION
                                                    (select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$chelangeid' and a.status = '2' and a.blob_id = b.blob_id);");
                while ($answerrow = mysqli_fetch_array($answer)) {
                    $answer_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $answerrow['stmt'])));
                    echo "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
                            <p align='center'>Answer</p></span>"
                        . $answer_stmt. "<br/>";
                }
            }
            }
            // if user id not set 
            else {
                if ($ctype == 1 OR $ctype == 3) {
                    echo "<div class='list-group challenge'>
                            <div class='list-group-item'>
                                <a data-toggle='modal' data-target='#SignIn'>
                                    <button class='btn btn-primary btn-sm pull-right' >Accept</button>
                                </a>";
                                    echo $display_title."<span class='glyphicon glyphicon-question-sign'></span>".$display_name_stmt;
                          
                }
                else if ($ctype == 4) {
                    echo "<div class='list-group idea'>
                                <div class='list-group-item'>";
                                   echo $display_title."<span class='glyphicon glyphicon-flash'></span>".$display_name_stmt;
                }
                else if ($ctype == 6) {
                    echo "<div class='list-group deciduous'>
                                <div class='list-group-item'>";
                                    echo $display_title."<span class='glyphicon glyphicon-tree-deciduous'></span>".$display_name_stmt;
                }
                else if ($ctype == 7) {
                    echo "<div class='list-group articlesch'>
                            <div class='list-group-item'>";
                        echo $display_title."<span class='glyphicon glyphicon-book'></span>".$display_name_stmt;
                }
                else if ($ctype == 8) {
                    echo "<div class='list-group film'>
                            <div class='list-group-item'>";
                            echo $display_title."<span class='glyphicon glyphicon-film'></span>".$display_name_stmt;
                }
            }
            $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                    JOIN user_info as b WHERE a.challenge_id = $challengeSearchID AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                UNION
                                    (SELECT DISTINCT c.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                    JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$challengeSearchID' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");

            while ($commenterRow = mysqli_fetch_array($commenter)) {
                $comment_id = $commenterRow['response_ch_id'];
                $challenge_ID = $commenterRow['challenge_id'];
                $creater_ID = $commenterRow['user_id'];
                $username_comment_ninjas = $commenterRow['username'];
                $comment_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $commenterRow['stmt'])));
                echo "<div id='commentscontainer'>
                    <div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
                        </div>
                    <div class='comment-text'>
                    <span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
                        &nbsp&nbsp&nbsp".$comment_stmt;
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                 dropDown_delete_comment_ch($comment_id, $user_id, $creater_ID);
                }
                echo "</div>
                </div>
            </div>";
            }
            echo "<div class='comments_".$chelangeid."'></div><div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>&nbsp
                </div>
                <div class='comment-text'>";
            if (isset($_SESSION['user_id'])) {
                $userID = $_SESSION['user_id'];
                echo "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$chelangeid."'
                             placeholder='Want to know your comment....'/>
                            <button type='submit' class='btn-primary btn-sm' onclick='comment(\"".$chelangeid."\", 1)' ><span class='glyphicon glyphicon-chevron-right'></span></button>";
            } else {
                echo "<form action='' method='POST' class='inline-form'>
                        <input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
                            <a data-toggle='modal' data-target='#SignIn'>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                            </a>
                        </form>";
            }
            echo "</div>
            </div>";
            echo " </div></div>";
        }
    }
?>
