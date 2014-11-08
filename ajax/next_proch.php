<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['proch']){
	$user_id = $_SESSION['user_id'];
	$p_id = $_SESSION['project_id'];
	$limitpr = $_SESSION['lastpr'];
	
	$a = (int)$limitpr ;
	
	$b = $a+5;
$tasks = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, a.stmt, a.challenge_creation, a.challenge_type,
                                    a.challenge_status, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b
                                        WHERE a.project_id = '$p_id' AND a.challenge_type !='6' AND a.challenge_status !='3' AND a.challenge_status !='7'
                                    AND a.blob_id = '0' and a.user_id = b.user_id)
                                UNION
                                    (SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, c.stmt,a.challenge_creation, a.challenge_type,
                                    a.challenge_creation, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN blobs AS c 
                                    WHERE a.project_id = '$p_id' AND a.challenge_type !='6' AND a.challenge_status !='3' AND a.challenge_status !='7'
                                    AND a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY challenge_creation DESC LIMIT $a, $b ;");
	$show = "";
        $iR=0;
		while ($tasksrow = mysqli_fetch_array($tasks)) {
			$iR++;
			$username_task = $tasksrow['username'];
			$id_task = $tasksrow['challenge_id'];
			$id_create = $tasksrow['user_id'];
			$title_task = $tasksrow['challenge_title'];
			$type_task = $tasksrow['challenge_type'];
			$status_task = $tasksrow['challenge_status'];
			$eta_task = $tasksrow['challenge_ETA'];
			$creation_task = $tasksrow['challenge_creation'];
			$timetask = date("j F, g:i a",strtotime($creation_task));
			$stmt_task = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $tasksrow['stmt'])));
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
					
    if ($type_task == 5) {
         if ($status_task == 2) {
			 $show .= "<div class='list-group pushpin'>
                                    <div class='list-group-item'>
                                        <div class='pull-left lh-fix'>     
                                            <span class='glyphicon glyphicon-pushpin'></span>
                                            <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                        </div>
                                    <div style='line-height: 16.50px;'>";
                        $show = $show ."<div class='pull-right'>
                                            <div class='list-group-item'>
                                                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                            if ($id_create == $user_id) {
                                $show = $show . "<li><button class='btn-link' href='#'>Edit</button></li>
                                        <li><button class='btn-link' cID='" . $id_task . "' onclick='delChallenge(" . $id_task . ");'>Delete</button></li>
                                        ";
                                if ($remaintimeown == 'Closed') {
                    $show = $show . "<li><form method='POST' class='inline-form'>
                                            <input type='hidden' name='id' value='" . $id_task . "'/>
                                            <input class='btn-link' type='submit' name='eta' value='Change ETA'/>
                                        </form>
                                    </li>";
                                }
                            }
                            else {
                    $show = $show . "<li><button class='btn-link' >Report Spam</button></li>";
                            }
                    $show = $show . "</ul>
                        </div>
                    </div>";

            if ($ownid == $user_id) {
                $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='" . $id_task . "'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
					</form>";
            }
            $show = $show . "<span class='color strong' style= 'color :#3B5998;'>" . ucfirst($fname_task) . "</a></span> On " . $timefunct . "<br/>
				Task Assigned To &nbsp <span class='color strong' style= 'color :#3B5998;'>" . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> </span>
					 ETA Given : " . $etaown . " <br/>" . $remaintimeown . "</div></div>";
        }
        if ($status_task == 4) {
			$show = $show . "<div class='list-group flag'>
                                            <div class='list-group-item'>
                                            <div class='pull-left lh-fix'>     
                                                <span class='glyphicon glyphicon-pushpin'></span>
                                                <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                            </div>
                            <div style='line-height: 16.50px;'>";
            if ($id_create == $user_id) {
                $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
				   <input type='hidden' name='cid' value='" . $id_task . "'/>
				   <button type='submit' class='btn-primary' name='closechallenge'>Close</button></form>";
            }
            $show = $show . "<span class='color strong' style= 'color :#3B5998;'>" . ucfirst($fname_task) . "</a></span> On " . $timefunct . "<br/>
				Task Assigned To &nbsp <span class='color strong' style= 'color :#3B5998;'>" . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> </span>
					 ETA Given : " . $etaown . " <br/> and Submitted On : " . $timecom . " ETA Taken : " . $timetaken . "</div></div>";
        }
        if ($status_task == 5) {
			$show = $show . "<div class='list-group flag'>
                    <div class='list-group-item'>
                    <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-pushpin'></span>
                                <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>";
            $show = $show . "<span class='color strong pull-right' style= 'color :#3B5998;'><p>Closed</p></span><br/>
				<span class='color strong' style= 'color :#3B5998;'>" . ucfirst($fname_task) . "</a></span> On " . $timefunct . "<br/>
				Task Assigned To &nbsp <span class='color strong' style= 'color :#3B5998;'>" . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> </span>
					 ETA Given : " . $etaown . " <br/> and Submitted On : " . $timecom . " ETA Taken : " . $timetaken . "</div></div>";
        }
    }
    if ($type_task == 1 || $type_task == 2) {
        if ($status_task == 1) {
			$show = $show . "<div class='list-group sign'>
                    <div class='list-group-item'>
                    <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-pushpin'></span>
                                <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>";
            $show = $show . "<span class='color strong'><a href ='profile.php?username=" . $username_task . "'>"
            . ucfirst($fname_task) . '&nbsp' . ucfirst($lname_task) . " </a></span>";

    //dropdown for delete/edit/span challenge starts
        $show = $show . "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$id_task' AND user_id='$user_id';"));
                    $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                    $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                    if($challenge_dropdown_userID == $user_id) {
                        $show = $show . "<li><button class='btn-link' href='#'>Edit</button></li>
                              <li><button class='btn-link' cID='".$id_task."' onclick='delChallenge(".$id_task.");'>Delete</button></li>";                    
                        if($remaining_time_ETA_over == 'Time over') {        
                            $show = $show . "<li>
                                    <form method='POST' class='inline-form'>
                                        <input type='hidden' name='id' value='".$id_task."'/>
                                        <input class='btn-link' type='submit' name='eta' value='Change ETA'/>
                                    </form>
                                </li>";
                        }                                    
                     }
                    else {
                       $show = $show . "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                    <button type='submit' name='pr_spem' value='".$id_task."' class='btn-link' >Report Spam</button>
                                </form>
                            </li>";
                    } 
               $show = $show . "</ul>
              </div>";
        //dropdown for delete/edit/span challenge ends here

            $show = $show . "<form method='POST' class='inline-form pull-right'>
                    <input type='hidden' name='id' value='" . $id_task . "'/>
                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                </form>
                <br>" . $timetask . "&nbsp&nbsp&nbsp with ETA : " . $tasketa . "<br/>" . $remaintime . "</div></div>";
        }
        if ($status_task == 2) {
			$show = $show . "<div class='list-group sign'>
                    <div class='list-group-item'>
                    <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-pushpin'></span>
                                <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>";
            $show = $show . "<span class='color strong'><a href ='profile.php?username=" . $username_task . "'>"
            . ucfirst($fname_task) . '&nbsp' . ucfirst($lname_task) . " </a></span></div>";
            if ($ownid == $user_id) {
                $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
                        <input type='hidden' name='id' value='" . $id_task . "'/>
                        <input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
                    </form>";
            }
            $show = $show . "&nbsp&nbsp On : " . $timetask . "<br/>
				Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>&nbsp&nbsp On : " . $timefunct . " and 
				ETA Taken : " . $etaown . " <br/> Time Remaining : " . $remaintimeown . "</div>";
        }

        if ($status_task == 4) {
			$show = $show . "<div class='list-group flag'>
                    <div class='list-group-item'>
                    <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-pushpin'></span>
                                <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>";
            $show = $show . "<span class='color strong'><a href ='profile.php?username=" . $username_task . "'>"
            . ucfirst($fname_task) . '&nbsp' . ucfirst($lname_task) . " </a></span>";
            if ($id_create == $user_id) {
                $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
				   <input type='hidden' name='cid' value='" . $id_task . "'/>
				   <button type='submit' class='btn-primary' name='closechallenge'>Close</button></form>";
            }
            $show = $show . "&nbsp&nbsp On : " . $timetask . "<br/>
				Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>&nbsp&nbsp Submitted On : " . $timefunct . " and 
				ETA Taken : " . $timetaken . "</div></div>";
        }

        if ($status_task == 5) {
			$show = $show . "<div class='list-group flag'>
                    <div class='list-group-item'>
                    <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-pushpin'></span>
                                <img src='uploads/profilePictures/$username_task.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>";
            $show = $show . "</span><span class='color strong' style= 'color :#3B5998;'><p align='center'>Closed</p></span><br/>
				<span class='color strong' style= 'color :#3B5998;'>" . ucfirst($fname_task) . "</a></span> On " . $timefunct . "<br/>
				Owned By &nbsp <span class='color strong' style= 'color :#3B5998;'>" . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> </span>
					 ETA Given : " . $etaown . " <br/> and Submitted On : " . $timecom . " ETA Taken : " . $timetaken . "</div></div>";
        }
    }				 
				
   	$show = $show . "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'><b>".ucfirst($title_task)."</b></p>
				<small>".str_replace("<s>","&nbsp;",$stmt_task)."</small><br/><br/>";
	if (($type_task == 1 || $type_task == 2 || $type_task == 5) && ($status_task == 4 || $status_task == 5)){

		$answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$id_task' and blob_id = '0' and status = '2')
												UNION
												(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$id_task' and a.status = '2' and a.blob_id = b.blob_id);") ;										
			$answerrow = mysqli_fetch_array($answer) ;
		$show = $show . "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
				<p align='center'>Answer</p></span><br/>"
				.$answerrow['stmt']."<br/>" ;
		}			
		
	$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$id_task' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
                $lstname = $displayrowb['last_name'];
                $username_commenter = $displayrowb['username'];
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		$show = $show . "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_commenter_pr_ch.jpg'  onError=this.src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp<a href ='profile.php?username=".$username_commenter."'>". ucfirst($fstname)."&nbsp".$lstname."</a>&nbsp".
					"</span><small>".$chalangeres."</small>";
        //delete comment dropdown chall function is not called due to function call witihin concatination string and then further concatenated to $show
        $show = $show . "<div class='list-group-item pull-right'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdown'>";

                            $challenge_dropdown_comment = mysqli_query($db_handle, ("SELECT user_id FROM response_challenge WHERE response_ch_id = '$idc' AND user_id='$user_id';"));
                                    $challenge_dropdown_commentRow = mysqli_fetch_array($challenge_dropdown_comment);
                                    $challenge_dropdown_comment_userID = $challenge_dropdown_commentRow['user_id'];
                                    if($challenge_dropdown_comment_userID == $user_id) {
                    $show = $show . "<li><button class='btn-link' href='#'>Edit</button></li>
                                     <li><button class='btn-link' cID='".$idc."' onclick='delcomment(".$idc.");'>Delete</button></li>";
                                    } 
                                    else {
                    $show = $show . "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                            <button type='submit' name='spem' value='".$idc."' class='btn-link' >Report Spam</button>
                                        </form>
                                    </li>";
                                    }
             $show = $show . "</ul>
                            </div>";
             //delete comment dropdown ends
            $show = $show . "</div>
			</div> 
                    </div>";
		}
		$show = $show . "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                        <form action='' method='POST' class='inline-form'>
                                <input type='hidden' value='".$id_task."' name='own_challen_id' />
                                <input type='text' STYLE='border: 1px solid #bdc7d8; width: 84%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                        </form>
                    </div></div></div>";		
	}	
												
	if(mysqli_error($db_handle)) 
	{ 
		echo "Failed!"; 
	}
	else { 
		$_SESSION['lastpr'] = $a+$iR;
		echo $show ; 
		}
}
	

else echo "Invalid parameters!";
mysqli_close($db_handle);
?>
