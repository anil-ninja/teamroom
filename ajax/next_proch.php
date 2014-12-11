<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['proch']){
	$user_id = $_SESSION['user_id'];
	$p_id = $_SESSION['project_id'];
	$limitpr = $_SESSION['lastpr'];
	$a = (int)$limitpr ;
	$b = 5;
	$get_display_task_stmt = "" ;
$tasks = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, a.stmt, a.creation_time, a.challenge_type,
                                    a.challenge_status, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b
                                        WHERE a.project_id = '$p_id' AND a.challenge_status !='3' AND a.challenge_status !='7'
                                    AND a.blob_id = '0' and a.user_id = b.user_id)
                                UNION
                                    (SELECT DISTINCT a.challenge_id, a.user_id, a.challenge_title, a.challenge_ETA, c.stmt,a.creation_time, a.challenge_type,
                                    a.creation_time, b.first_name, b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN blobs AS c 
                                    WHERE a.project_id = '$p_id' AND a.challenge_status !='3' AND a.challenge_status !='7'
                                    AND a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY creation_time DESC LIMIT $a, $b ;");
	$show = "";
        $iR=0;
        $dropdown1 = "";
        $dropdown2 = "";
		while ($tasksrow = mysqli_fetch_array($tasks)) {
			$iR++;
			$username_task = $tasksrow['username'];
			$id_task = $tasksrow['challenge_id'];
			$id_create = $tasksrow['user_id'];
			$title_task = $tasksrow['challenge_title'];
			$type_task = $tasksrow['challenge_type'];
			$status_task = $tasksrow['challenge_status'];
			$eta_task = $tasksrow['challenge_ETA'];
			$creation_task = $tasksrow['creation_time'];
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
			$totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$id_task' and like_status = '1' ;");
			if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
			else { $likes = '' ; }
			$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$id_task' and like_status = '2' ;");
			if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
			else { $dislikes = '' ; }	
               $dropdown1 = "<div class='list-group-item pull-right'>
								<a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
									<ul class='dropdown-menu' aria-labelledby='dropdown'>" ;
			if($id_create == $user_id) {
             $dropdown1 = $dropdown1 ."<li><button class='btn-link' onclick='edit_content(\"".$id_task."\", 2)'>Edit</button></li>
                              <li><button class='btn-link' onclick='delChallenge(\"".$id_task."\", 3);'>Delete</button></li>";                    
                      /*  if($remaining_time_ETA_over == 'Time over') {        
                            echo "<li>
                                    <form method='POST' class='inline-form'>
                                        <input type='hidden' name='id' value='".$challenge_ID."'/>
                                        <input class='btn-link' type='submit' name='eta' value='Change ETA'/>
                                    </form>
                                </li>";
                        } */                                   
                     }
                    else {
              $dropdown1 = $dropdown1 . "<li><button class='btn-link' onclick='spem(\"".$id_task."\", 9);'>Report Spam</button></li>";
                    } 
              $dropdown1 = $dropdown1 . "</ul></div>";
              if($id_create == $user_id) {
				$dropdown2 ="<div class='list-group-item pull-right'>
								<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
								<ul class='dropdown-menu' aria-labelledby='dropdown'>
									<li><button class='btn-link' onclick='edit_content(\"".$id_task."\", 2)'>Edit</button></li>
									<li><button class='btn-link' onclick='delChallenge(\"".$id_task."\", 3);'>Delete</button></li>
								</ul>
							</div>";                    
				}
                        // list grp item header for all type chall/article/idea/photo/video
                        $get_display_tilte_task = "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif' id='challenge_ti_".$id_task."' class='text'><b>
                            <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$id_task."' target='_blank'>".ucfirst($title_task)."</a></b></p><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$id_task."' value='".$title_task."'/>";

                        $get_dispaly_fname_likes = "<span style= 'color: #808080'>
                                &nbspBy: <a href ='profile.php?username=" . $username_task . "'>".ucfirst($fname_task)." ".ucfirst($lname_task)."</a>&nbsp</span> | ".$timefunct." | 
                                    <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$id_task ."\", 3)'>
                                        <input type='submit' class='btn-link' id='likes_".$id_task ."' value='".$likes."'/></span>
                                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$id_task ."\", 4)'>
                                        <input type='submit' class='btn-link' id='dislikes_".$id_task ."' value='".$dislikes."'/>&nbsp;</span>";
                        // list grp item stmt content for all type chall/article/idea/photo/video
                        $get_display_task_stmt .= "<br></div>                    
                                            <div class='list-group-item'><br>
                                                <span id='challenge_".$id_task."' class='text'>".$stmt_task."</span>
                                                <input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$id_task."' value='".$title_task."'/><br/><br/>";
    if(isset($_SESSION['user_id'])){
		if(substr($stmt_task, 0, 1) != '<') {
		$get_display_task_stmt = $get_display_task_stmt.  "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$id_task."' >".$stmt_task."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$id_task.")' id='doneedit_".$id_task."'/>";
			}
		else {
			if (substr($stmt_task, 0, 4) == ' <br') {
			$get_display_task_stmt = $get_display_task_stmt . "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$id_task."' >".$stmt_task."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$id_task.")' id='doneedit_".$id_task."'/>";
				}
			if (substr($stmt_task, 0, 3) == '<s>') {
		$get_display_task_stmt = $get_display_task_stmt . "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$id_task."' >".$stmt_task."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$id_task.")' id='doneedit_".$id_task."'/>";
				}
			$chaaa = substr(strstr($stmt_task, '<br/>'), 5) ;
			$cha = strstr($stmt_task, '<br/>' , true) ;
			if(substr($stmt_task, 0, 4) == '<img') {
			$get_display_task_stmt = $get_display_task_stmt.  "<div class='editbox' style='width : 90%;' id='challenge_pic_".$id_task."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$id_task.")' id='pic_file_".$id_task."'/><br/><br/>" ;
					}
			if(substr($stmt_task, 0, 2) == '<a') {
			$get_display_task_stmt = $get_display_task_stmt . "<div class='editbox' style='width : 90%;' id='challenge_file_".$id_task."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$id_task.")' id='pic_file_".$id_task."'/><br/><br/>" ;
					}
			if(substr($stmt_task, 0, 3) == '<if') {
			$get_display_task_stmt = $get_display_task_stmt . "<div class='editbox' style='width : 90%;' id='challenge_video_".$id_task."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$id_task."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
			$get_display_task_stmt = $get_display_task_stmt . "<input id='_fileChallenge_".$id_task."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn-success btn-xs editbox' value='Upload New Photo/File' onclick='save_pic_file(".$id_task.")' id='pic_file_save_".$id_task."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$id_task."' >".$chaaa."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedchallenge(".$id_task.")' id='doneediting_".$id_task."'/>";		
			}
		}
    if ($type_task == 5) {
         if ($status_task == 2) {
			 $show .= "<div class='list-group pushpin'>
                                    <div class='list-group-item'>";
                                    
             $show = $show . $dropdown1 ;
             $dropdown1 = ""; 
            $show = $show .$get_display_tilte_task."<span class='glyphicon glyphicon-pushpin'></span><span style= 'color: #808080'>
                            &nbspBy: <a href ='profile.php?username=" . $username_task . "'>".ucfirst($fname_task)." ".ucfirst($lname_task)."</a>&nbsp</span> | 
                            Assigned To:<a href ='profile.php?username=" . $ownname ."'>".ucfirst($ownfname)." ".ucfirst($ownlname)."</a> |
                                <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$id_task ."\", 3)'>
                                        <input type='submit' class='btn-link' id='likes_".$id_task ."' value='".$likes."'/></span>
                                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$id_task ."\", 4)'>
                                        <input type='submit' class='btn-link' id='dislikes_".$id_task ."' value='".$dislikes."'/>&nbsp;</span>";
                        //<br>ETA Given: " . $etaown . " <br/>" . $remaintimeown . "
                    $show = $show . $get_display_task_stmt;
                    $get_display_task_stmt = "" ;
            if ($ownid == $user_id) {
                $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$id_task ."\", 2)' value='Submit'/>";
            }
                 
        }
        if ($status_task == 4) {
			$show = $show . "<div class='list-group flag'>
                                            <div class='list-group-item'>";                               
            if ($id_create == $user_id) {
                $show = $show . "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$id_task ."\", 6)'>Close</button>";
            }
            $show = $show .$get_display_tilte_task."<span class='glyphicon glyphicon-pushpin'></span>".$get_dispaly_fname_likes."
				<br><hr>Assigned To: <a href ='profile.php?username=" . $ownname ."'>".ucfirst($ownfname)." ".ucfirst($ownlname)."</a> | Submitted: " . $timecom ;
					 //. " ETA Taken : " . $timetaken . "
			$show = $show .$get_display_task_stmt;
			$get_display_task_stmt = "" ;		 
        }
        if ($status_task == 5) {
			$show = $show . "<div class='list-group flag'>
                    <div class='list-group-item'>";
                    
            $show = $show . "<span class='color strong pull-right' style= 'color :#3B5998;'><p>Closed</p></span><br/>";
            $show = $show . $get_display_tilte_task."<span class='glyphicon glyphicon-flag'></span>".$get_dispaly_fname_likes."
				<br><hr>Assigned To: <a href ='profile.php?username=" . $ownname ."'>".ucfirst($ownfname)." ".ucfirst($ownlname)."</a> | Submitted: ".$timecom;
	    $show = $show . $get_display_task_stmt;
	    $get_display_task_stmt = "" ;
        }
    }
    if ($type_task == 8) {
        $show = $show . "<div class='list-group videofilm'>
                    <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
            $show = $show . $dropdown1 ;
            $dropdown1 = "";
        }
        $show = $show . $get_display_tilte_task . "<span class='glyphicon glyphicon-film'></span>" . $get_dispaly_fname_likes . $get_display_task_stmt;
        $get_display_task_stmt = "" ;
        
    }
    if ($type_task == 6) {
        $show = $show . "<div class='list-group deciduous'>
                    <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
            $show = $show . $dropdown1 ;
            $dropdown1 = "";
        }
        $show = $show . $get_display_tilte_task . "<span class='glyphicon glyphicon-tree-deciduous'></span>" . $get_dispaly_fname_likes . $get_display_task_stmt;
        $get_display_task_stmt = "" ;
        
    }
    if ($type_task == 1 || $type_task == 2) {
        if ($status_task == 1) {
            $show = $show . "<div class='list-group sign'>
                                <div class='list-group-item'>";
                             
    //dropdown for delete/edit/span challenge starts
        $show = $show .$dropdown1 ;
        $dropdown1 = ""; 
        //dropdown for delete/edit/span challenge ends here

        $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$id_task ."\", 5)' value='Accept'/>";
        $show = $show . $get_display_tilte_task . "<span class='glyphicon glyphicon-question-sign'></span>" . $get_dispaly_fname_likes . $get_display_task_stmt;
        $get_display_task_stmt = "" ;
                  
        }
        if ($status_task == 2) {
                    $show = $show . "<div class='list-group sign'>
                                        <div class='list-group-item'>";
				if ($ownid == $user_id) {
					$show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$id_task ."\", 2)' value='Submit'/>";
				}

                //dropdown for delete/edit/span challenge starts
            if($id_create == $user_id) {
                $show = $show . $dropdown2 ;
                $dropdown2 = "";                    
            }
        //dropdown for delete/edit/span challenge ends here
            $show = $show . $get_display_tilte_task."<span class='glyphicon glyphicon-question-sign'></span>".$get_dispaly_fname_likes.
                          "<br><hr>Owned By: <a href ='profile.php?username=".$ownname."'>".ucfirst($ownfname)." ".ucfirst($ownlname)."</a> | ".$timefunct .
                        $get_display_task_stmt;
                        $get_display_task_stmt = "" ;
                //. "<br>ETA Taken: " . $etaown . "<br>Time Remaining : " . $remaintimeown . "
                        
        }
        if ($status_task == 4) {
            $show = $show . "<div class='list-group flag'>
                                <div class='list-group-item'>";
                    
    //dropdown for delete/edit/span challenge starts
            if($id_create == $user_id) {
                $show = $show . $dropdown2 ;
                $dropdown2 = "";                    
            }
        //dropdown for delete/edit/span challenge ends here
            if ($id_create == $user_id) {
                $show = $show . "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$id_task ."\", 6)'>Close</button>";
            }
            $show = $show .$get_display_tilte_task."<span class='glyphicon glyphicon-question-sign'></span>".$get_dispaly_fname_likes."
            <br><hr>Owned By: <a href ='profile.php?username=" . $ownname . "'>".ucfirst($ownfname)." ".ucfirst($ownlname)."</a> | Submitted: ".$timefunct
                    . $get_display_task_stmt;
                    $get_display_task_stmt = "" ;
            //. " and ETA Taken : " . $timetaken . "
            
        }
        if ($status_task == 5) {
            $show = $show . "<div class='list-group flag'>
                    <div class='list-group-item'>";
                    
            //dropdown for delete/edit/span challenge starts
            if($id_create == $user_id) {
                $show = $show . $dropdown2 ;
                $dropdown2 = "";                    
            }
//dropdown for delete/edit/span challenge ends here
            $show = $show . "</span><span class='color strong' style= 'color :#3B5998;'><p align='center'>Closed</p></span><br/>";
            $show = $show . $get_display_tilte_task."<span class='glyphicon glyphicon-flag'></span>". $get_dispaly_fname_likes.
                            "<br><hr>Owned By: " . ucfirst($ownfname) . " " . ucfirst($ownlname) . "</a> | Submitted: ".$timecom
                        .$get_display_task_stmt;
                        $get_display_task_stmt = "" ;
					// ETA Given : " . $etaown . " 
					
					//. " ETA Taken : " . $timetaken . "
        }
    }			
	
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
                $comment_user_id = $displayrowb['user_id'];
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


                            if($comment_user_id == $user_id) {
                                $show = $show . "<li><button class='btn-link' href='#'>Edit</button></li>
                                                  <li><button class='btn-link' cID='".$idc."' onclick='delcomment(".$idc.");'>Delete</button></li>";
                            } 
                            else {
                                $show = $show . "<li><button type='submit' onclick='spemchpr(\"".$idc."\", 5, \"".$pro_id."\")' class='btn-link' >Report Spam</button></li>";
                            }
             $show = $show . "</ul>
                            </div>";
             //delete comment dropdown ends
            $show = $show . "</div>
			</div> 
                    </div>";
		}
		$show = $show . "<div class='comments_".$id_task."'></div><div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp;
                        </div>";
                if (isset($_SESSION['user_id'])) {
                    $show = $show . "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$id_task."' placeholder='Want to know your comment....'/>
                                    <button type='submit' class='btn-sm btn-primary glyphicon glyphicon-chevron-right' onclick='comment(\"".$id_task ."\", 3)' ></button>";
                }
                else {
                   $show = $show . " <input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
                                    <a data-toggle='modal' data-target='#SignIn'>
                                        <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                                    </a>";
                }
               $show = $show . "</div></div></div>";		
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
<script>
$(".text").show();
$(".editbox").hide();
$(".editbox").mouseup(function(){
return false
});
</script>
