<?php

session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if ($_POST['chal']) {
    $user_id = $_SESSION['user_id'];
    $limit = $_SESSION['lastpanel'];

    $a = (int) $limit;

    $b = $a + 5;

    $open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.challenge_creation, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b where a.challenge_type != '2' and a.challenge_type != '5' and a.challenge_type != '6' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE a.challenge_type != '2' and a.challenge_type != '5' and a.challenge_type != '6' and a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											 ORDER BY challenge_creation DESC LIMIT $a,$b;");
    $show = "";
    $iR = 0;
    while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
        $i++;
       $chelange = str_replace("<s>", "&nbsp;", $open_chalangerow['stmt']);
    $ETA = $open_chalangerow['challenge_ETA'];
    $ch_title = $open_chalangerow['challenge_title'];
    $ch_id = $open_chalangerow['user_id'];
    $ctype = $open_chalangerow['challenge_type'];
    $frstname = $open_chalangerow['first_name'];
    $lstname = $open_chalangerow['last_name'];
    $username_ch_ninjas = $open_chalangerow['username'];
    $chelangeid = $open_chalangerow['challenge_id'];
    $status = $open_chalangerow['challenge_status'];
    $times = $open_chalangerow['challenge_creation'];
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

    if ($ctype == 1) {
        if ($status == 1) {
            $show .= "<div class='list-group challenge'>
                        <div class='list-group-item'>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-question-sign'></span>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>
                                <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
            . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a>
                                </span>";
            dropDown_challenge($db_handle, $chelangeid, $user_id, $remaintime);
            
            if ($remaintime != "Closed") {
                $show = $show . "<form method='POST' class='inline-form pull-right'>
                                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                                </form>
                                <br> " . $timefunction . "&nbsp&nbsp&nbsp with ETA : " . $sutime . "<br/>" . $remaintime;
            } else {
                $show = $show . "<br>Closed";
            }
                    $show = $show . "</div>
                    </div>";
        } 
        if ($status == 2) {
            $show = $show . "<div class='list-group challenge'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                            . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>&nbsp&nbsp On : " . $timefunction . "<br/>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>&nbsp&nbsp On : " . $timefunct . " and
                            ETA Taken : " . $timeo . " <br/> Time Remaining : " . $remaintimeown ;
          if($ownuser == $user_id) {			
			$show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='".$chelangeid."'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchlnin' value='Submit'/>
					</form>";
				}
			$show = $show . "</div></div>" ;	
        }
        if ($status == 4) {
            $show = $show . "<div class='list-group challenge'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                            . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>&nbsp&nbsp On : " . $timefunction . "<br/>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>&nbsp Submitted On : " . $timecomm . "<br/> and
                            ETA Taken : " . $timeo ;
          if($ch_id == $user_id) {			
			$show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                    <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                    <button type='submit' class='btn-primary' name='closechal'>Close</button>
                </form>";
				}
			$show = $show . "</div></div>" ;	
        }
        if ($status == 5) {
            $show = $show . "<div class='list-group challenge'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                            . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>&nbsp&nbsp On : " . $timefunction . "<br/>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>&nbsp Submitted On : " . $timecomm . "<br/> and
                            ETA Given : " . $timeo . " and ETA Taken : " . $timetakennin . "</div></div>" ;	
        }
    } 
     if ($ctype == 7) {
        $show = $show . "<div class='list-group articlesch'>
				<div class='list-group-item' style='line-height: 24.50px;'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-book'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>
        
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                                        <br> " . $timefunction . "<br/>
                                </div>";
    } 
     if ($ctype == 4) {
        $show = $show . "<div class='list-group idea'>
                        <div class='list-group-item' ></span>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-book'>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>	
                        Purposed by &nbsp
                        <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>&nbsp&nbsp On : " . $timefunction . "<br/>
                        <p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>IDEA</b></p></div>";
    } 
    if ($ctype == 3) {
		if ($status == 1) {
        $show = $show . "<div class='list-group openchalhide'>
                <div class='list-group-item' >
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-question-sign'>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>&nbsp&nbsp&nbsp On : " . $timefunction ;
        dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
        if ($ch_id != $user_id) {
            $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                    <input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
                </form>" ;
			}
        else {
            $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                    <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                    <button type='submit' class='btn-primary' name='closechal'>Close</button>
                </form>";
        }
        $show = $show . "</div>";
	}
        if ($status == 2 || $status == 4 || $status == 5) {
			$show = $show . "<div class='list-group openchalhide'>
                <div class='list-group-item' >
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-question-sign'>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>&nbsp&nbsp&nbsp On : " . $timefunction ;
         if ($ch_id != $user_id) {
            $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                    <input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
                </form>" ;
			}
        else {
            $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                    <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                    <button type='submit' class='btn-primary' name='closechal'>Close</button>
                </form>";
        }
           $show = $show . "</div>";
            $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
                                                from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
            while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                $owtime = $ownedbrow['ownership_creation'];
                $timfunct = date("j F, g:i a", strtotime($owtime));
                $owfname = $ownedbrow['first_name'];
                $owlname = $ownedbrow['last_name'];
                $owname = $ownedbrow['username'];
                $show = $show . "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span>&nbsp&nbsp On : " . $timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
                            <input type='hidden' name='id' value='" . $chelangeid . "'/>
                            <input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
                        </form>";
                }
                $show = $show . "</div>
                    </div>";
            }
        }
    
    }
    $show = $show . "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>" . ucfirst($ch_title) . "</b></p>
			<br/>" .$chelange . "<br/><br/>";
    if ($status == 4 || $status == 5) {
        $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$chelangeid' and blob_id = '0' and status = '2')
                                            UNION
                                            (select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$chelangeid' and a.status = '2' and a.blob_id = b.blob_id);");
        while ($answerrow = mysqli_fetch_array($answer)) {
            $show = $show . "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
                    <p align='center'>Answer</p></span>"
					. $answerrow['stmt'] . "<br/>";
        }
    }
    $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $chelangeid AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$chelangeid' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $challenge_ID = $commenterRow['challenge_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $show = $show . "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp&nbsp&nbsp" . $commenterRow['stmt'];
        dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
        $show = $show . "</div></div></div>";
    }
    $show = $show . "<div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                        <form action='' method='POST' class='inline-form'>
                            <input type='hidden' value='" . $chelangeid . "' name='own_challen_id' />
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 87.0%; height: 30px;' name='own_ch_response'
                             placeholder='Whats on your mind about this'/>
                            <button type='submit' class='btn-sm btn-primary glyphicon glyphicon-chevron-right' name='own_chl_response' ></button>
                        </form>
                    </div>";
    $show = $show . "</div> </div> ";
    }

    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['lastpanel'] = $a + $i;
        echo $show;
    }
}


else
    echo "Invalid parameters!";
mysqli_close($db_handle);
?>
