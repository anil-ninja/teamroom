<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if ($_POST['chal']) {
    $user_id = $_SESSION['user_id'];
    $limit = $_SESSION['lastpanel'];
    $username = $_SESSION['username'];
    $a = (int)$limit ;
	$b = 5;
    $open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b where a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.project_id, a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											UNION
											(SELECT DISTINCT c.project_id, a.challenge_id, c.project_title, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b join projects as c where a.project_id = c.project_id and c.project_type='1' and a.challenge_type !='5' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT d.project_id, a.challenge_id, d.project_title, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c join projects as d
											WHERE a.project_id = d.project_id and d.project_type='1' and a.challenge_status != '3' and a.challenge_status != '7' and a.challenge_type !='5' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											 ORDER BY creation_time DESC LIMIT $a, $b;");
    $show = "";
    $get_display_ch_stmt_content = "" ;
    $iR = 0;
    while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
        $iR++;
       $chelange = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['stmt'])));
    $ETA = $open_chalangerow['challenge_ETA'];
    $ch_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['challenge_title'])));
    $owner_id = $open_chalangerow['user_id'];
    $public_project_id = $open_chalangerow['project_id'];
    $ctype = $open_chalangerow['challenge_type'];
    $frstname = $open_chalangerow['first_name'];
    $lstname = $open_chalangerow['last_name'];
    $username_ch_ninjas = $open_chalangerow['username'];
    $chelangeid = $open_chalangerow['challenge_id'];
    $status = $open_chalangerow['challenge_status'];
    $times = $open_chalangerow['creation_time'];
    $timefunction = date("j F, g:i a", strtotime($times));
    $timeopen = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['challenge_open_time'])));
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
    $dropdown1 = dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
    $dropdown2 = dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
        // list grp item header for all type chall/article/idea/photo/video
            $get_display_tilte = "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif' id='challenge_ti_".$chelangeid."' class='text'><b>
                <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$chelangeid."' target='_blank'>".ucfirst($ch_title)."</a></b></p><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$chelangeid."' value='".$ch_title."'/>";
            $get_display_fname_likes ="<span style= 'color: #808080'>
                &nbspBy: <a href ='profile.php?username=" . $username_ch_ninjas . "'>".ucfirst($frstname)." ".ucfirst($lstname)."</a> | ".$timefunction."</span> | 
                    <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$chelangeid ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span> &nbsp
                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$chelangeid ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>";
        // list grp item stmt content for all type chall/article/idea/photo/video
        $get_display_ch_stmt_content = "</div>                    
                                <div class='list-group-item'>
                        <br/><span id='challenge_".$chelangeid."' class='text' >".$chelange."</span><br/><br/>";
    if(isset($_SESSION['user_id'])){
		if(substr($chelange, 0, 1) != '<') {
	$get_display_ch_stmt_content = $get_display_ch_stmt_content . "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
			}
		else {
			if (substr($chelange, 0, 4) == ' <br') {
		$get_display_ch_stmt_content = $get_display_ch_stmt_content . "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
				}
			if (substr($chelange, 0, 3) == '<s>') {
		$get_display_ch_stmt_content = $get_display_ch_stmt_content . "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
				}
			$chaaa = substr(strstr($chelange, '<br/>'), 5) ;
			$cha = strstr($chelange, '<br/>' , true) ;
			if(substr($chelange, 0, 4) == '<img') {
	$get_display_ch_stmt_content = $get_display_ch_stmt_content . "<div class='editbox' style='width : 90%;' id='challenge_pic_".$chelangeid."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$chelangeid.")' id='pic_file_".$chelangeid."'/><br/><br/>" ;
					}
			if(substr($chelange, 0, 2) == '<a') {
	$get_display_ch_stmt_content = $get_display_ch_stmt_content . "<div class='editbox' style='width : 90%;' id='challenge_file_".$chelangeid."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$chelangeid.")' id='pic_file_".$chelangeid."'/><br/><br/>" ;
					}
			if(substr($chelange, 0, 3) == '<if') {
	$get_display_ch_stmt_content = $get_display_ch_stmt_content ."<div class='editbox' style='width : 90%;' id='challenge_video_".$chelangeid."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$chelangeid."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
	$get_display_ch_stmt_content = $get_display_ch_stmt_content . "<input id='_fileChallenge_".$chelangeid."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'>
					<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='save_pic_file(".$chelangeid.")' id='pic_file_save_".$chelangeid."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$chelangeid."' >".$chaaa."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedchallenge(".$chelangeid.")' id='doneediting_".$chelangeid."'/>";		
			}
		}
    if ($ctype == 1) {
        if ($status == 1) {
            $show .= "<div class='list-group challenge'>
                        <div class='list-group-item'>";    
        //dropdown for delete/edit/span challenge starts
        $show = $show . $dropdown1;
        //dropdown for delete/edit/span challenge ends here

        //    if ($remaintime != "Closed") {
                $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>"       ;
                                //. "<br> ETA : " . $sutime . "<br/>" . $remaintime;
          //  } else {
            //    $show = $show . " <br> " . $timefunction."<br>Closed";
          //  }
                $show = $show .$get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
                $get_display_ch_stmt_content = "" ;                    
        } 
        if ($status == 2) {
            $show = $show . "<div class='list-group challenge'>
                    <div class='list-group-item' >";
                                   
        if($ownuser == $user_id) {			
            $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
        }
            if($owner_id == $user_id) {
                $show = $show . $dropdown2 ;                    
            }
            $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes. "<br> <hr>Accepted: <a href ='profile.php?username=" . $ownname ."'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | ".$timefunct;
                                  //  <br/> Time Remaining : " . $remaintimeown ."<br>
                  $show = $show . $get_display_ch_stmt_content;
                  $get_display_ch_stmt_content = "" ;	
        }
        if ($status == 4) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
                    
                                if($owner_id == $user_id) {
                                    $show = $show . $dropdown2 ;                    
                                }
                                if($owner_id == $user_id) {			
                    $show = $show . "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                                }
                                
                                $show = $show.$get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes. "<br> <hr>Submitted: <a href ='profile.php?username=" . $ownname . "'>"
                                . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | " . $timecomm ;
                                                //. "<br/>  ETA Taken : " . $timeo ."
                                $show = $show. $get_display_ch_stmt_content;
                                $get_display_ch_stmt_content = "" ;
                }
        if ($status == 5) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
                                if($owner_id == $user_id) {
                                    $show = $show . $dropdown2 ;                    
                                }
            $show = $show .  $get_display_tilte."<span class='glyphicon glyphicon-flag'></span>".$get_display_fname_likes. "<br> <hr>Owned: <a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a><br> Submitted On : " . $timecomm ;
                                    //. "<br/> ETA Taken : " . $timetakennin . "
                $show = $show . $get_display_ch_stmt_content;
                $get_display_ch_stmt_content = "" ;
                    }
    }
    if ($ctype == 2) {
        if ($status == 1) {
            $show .= "<div class='list-group challenge'>
                        <div class='list-group-item'>";
                        
//dropdown for delete/edit/span challenge starts
        $show = $show . $dropdown1 ;
        //dropdown for delete/edit/span challenge ends here

            
        //    if ($remaintime != "Closed") {
                $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>"       ;
                                //. "<br> ETA : " . $sutime . "<br/>" . $remaintime;
          //  } else {
            //    $show = $show . " <br> " . $timefunction."<br>Closed";
          //  }
                $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes."| At: <a href='project.php?project_id=$public_project_id'>".ucfirst($timeopen)."</a>".$get_display_ch_stmt_content;
                $get_display_ch_stmt_content = "" ;
        } 
        if ($status == 2) {
            $show = $show . "<div class='list-group challenge'>
                    <div class='list-group-item'>";
                    
        if($ownuser == $user_id) {			
            $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
        }
        if($owner_id == $user_id) {
            $show = $show . $dropdown2 ;                    
        }
            $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes. "| At: <a href='project.php?project_id=$public_project_id'>".ucfirst($timeopen)."</a><br> <hr> Accepted: <a href ='profile.php?username=" . $ownname . "'>"
                                        . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | ".$timefunct;
                                    //  <br/> Time Remaining : " . $remaintimeown ."<br>
            $show = $show .$get_display_ch_stmt_content;
            $get_display_ch_stmt_content = "" ;
                                
        }
        if ($status == 4) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
                                if($owner_id == $user_id) {
                                    $show = $show . $dropdown2 ;                    
                                }
                                if($owner_id == $user_id) {			
                    $show = $show . "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                                }
                $show = $show .$get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes."| At: <a href='project.php?project_id=$public_project_id'>".ucfirst($timeopen)."</a><br> <hr>Submitted: <a href ='profile.php?username=" . $ownname . "'>"
                                . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | ".$timecomm ;
                                //. "<br/>  ETA Taken : " . $timeo ."
                $show = $show .$get_display_ch_stmt_content;
                $get_display_ch_stmt_content = "" ;	
        }
        if ($status == 5) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
                    if($owner_id == $user_id) {
                        $show = $show . $dropdown2 ;                    
                    }
                $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-flag'></span>".$get_display_fname_likes."| At: <a href='project.php?project_id=$public_project_id'>".ucfirst($timeopen)."</a><br><hr>"
                                    .ucfirst($ownfname).'&nbsp'.ucfirst($ownlname)."</a></span><br> Submitted: ".$timecomm;

                $show = $show .$get_display_ch_stmt_content; 
                $get_display_ch_stmt_content = "" ;          
        }
    } 
     if ($ctype == 6) {
        $show = $show . "<div class='list-group articlesch'>
				<div class='list-group-item'> " ;
            
                        $show = $show . $dropdown1 ;
                        
                        $show = $show .$get_display_tilte."<span class='glyphicon glyphicon-tree-deciduous'></span>".$get_display_fname_likes."| At: <a href='project.php?project_id=$public_project_id'>".ucfirst($timeopen)."</a>";
                        $show = $show .$get_display_ch_stmt_content;
                        $get_display_ch_stmt_content = "" ;
    } 
     if ($ctype == 7) {
        $show = $show . "<div class='list-group articlesch'>
				<div class='list-group-item'> " ;
                                    
                        $show = $show . $dropdown1 ;
                    $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-book'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
                    $get_display_ch_stmt_content = "" ;
    }
    if ($ctype == 8) {
        $show = $show . "<div class='list-group film'>
				<div class='list-group-item'> ";
                                   
                        $show = $show . $dropdown1 ;
                        $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-film'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
                        $get_display_ch_stmt_content = "" ;
    } 
     if ($ctype == 4) {
        $show = $show . "<div class='list-group idea'>
                        <div class='list-group-item'>";
                        
    //dropdown for delete/edit/span idea starts here
        $show = $show . $dropdown1 ;
    //dropdown for delete/edit/span idea ends here
       $show = $show .$get_display_tilte."<span class='glyphicon glyphicon-flash'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
       $get_display_ch_stmt_content = "" ;
    } 
    if ($ctype == 3) {  
        if ($status == 1) {
        $show = $show . "<div class='list-group challenge'>
                <div class='list-group-item'>";
            //dropdown for delete/edit/span challenge starts
        $show = $show . $dropdown1 ;
                    //dropdown for delete/edit/span challenge ends here

        if ($owner_id != $user_id) {
            $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
        }
        else {
            $show = $show . "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
        }
        $show = $show .$get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
        $get_display_ch_stmt_content = "" ;
	}	
		if ($status == 6) {
        $show = $show . "<div class='list-group pict'>
                <div class='list-group-item'>";
                
        //dropdown for delete/edit/span challenge starts
        $show = $show . $dropdown1 ;
        //dropdown for delete/edit/span challenge ends here

        $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-picture'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
        $get_display_ch_stmt_content = "" ;
	}
        if ($status == 2) {
			$show = $show . "<div class='list-group challenge'>
                                            <div class='list-group-item'>";
							
                            //dropdown for delete/edit/span challenge starts
        $show = $show . $dropdown1 ;
                    //dropdown for delete/edit/span challenge ends here

                        $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
                        if ($owner_id != $user_id ) {
                            if(mysqli_num_rows($owneduser) == 0){
                                $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                            }
                        }
                        else {
                            $show = $show . "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                        }
               $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes;
               
               $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
                                                from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
            while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                $owtime = $ownedbrow['ownership_creation'];
                $timfunct = date("j F, g:i a", strtotime($owtime));
                $owfname = $ownedbrow['first_name'];
                $owlname = $ownedbrow['last_name'];
                $owname = $ownedbrow['username'];
                $show = $show . "<hr>";
                           
                if ($ownedbrow['user_id'] == $user_id ) {
                    $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>" ;
                }
                $show = $show . "Owned: <a href ='profile.php?username=" . $owname . "'>"
                    .ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | " . $timfunct;
            }
            $show = $show. $get_display_ch_stmt_content;
            $get_display_ch_stmt_content = "" ;
        }
        if ($status == 4) {
            $show = $show . "<div class='list-group challenge'>
            <div class='list-group-item'>";
    
    //dropdown for delete/edit/span challenge starts
        $show = $show .$dropdown1  ;
    //dropdown for delete/edit/span challenge ends here

                $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
                if ($owner_id != $user_id ) {
                    if(mysqli_num_rows($owneduser) == 0){
                        $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                    }
                }
                else {
                    $show = $show . "<button type='submit' class='btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                }
                $show = $show .$get_display_tilte."<span class='glyphicon glyphicon-question-sign'></span>".$get_display_fname_likes;
                        
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
                    $show = $show . "<br><hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | ".$timfunct;
                    if ($ownedbrow['user_id'] == $user_id ) {
                        $show = $show . "<br><hr><input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
                    }
                }
                if  ($owlstatus==2){
                    $show = $show . "<br><hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | " . $timfunct." | Submitted: " .$owtimesubmit ;
                }
            }
            $show = $show . $get_display_ch_stmt_content;
            $get_display_ch_stmt_content = "" ;
        }
        if ($status == 5) {
            $show = $show . "<div class='list-group openchalhide'>
                                <div class='list-group-item'>";
                //dropdown for delete/edit/span challenge starts
        $show = $show . $dropdown1 ;
                    //dropdown for delete/edit/span challenge ends here

              $show = $show . $get_display_tilte."<span class='glyphicon glyphicon-flag'></span>".$get_display_fname_likes;
            
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
                $show = $show . "<br><hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | " . $timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
                }
            }
            if  ($owlstatus==2){
                $show = $show . "<br><hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | ".$timfunct."| Submitted: " .$owtimesubmit ;
                //." and Time  Taken : ".$timetakennin."
            }
        }
        $show = $show . $get_display_ch_stmt_content;
        $get_display_ch_stmt_content = "" ;
        }
     }
   /*$show = $show . "<div class='list-group-item'><p align='center' style='font-size: 14pt;' id='challenge_ti_".$chelangeid."' class='text' ><b>" . ucfirst($ch_title) . "</b></p>
			<br/><span id='challenge_".$chelangeid."' class='text' >".$chelange."</span>
			<input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$chelangeid."' value='".$ch_title."'/>";    */
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
        $creater_ID = $commenterRow['user_id'];
        $comment_id = $commenterRow['response_ch_id'];
        $challenge_ID = $commenterRow['challenge_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $commenterRow['stmt'])));
        $dropdown3 = dropDown_delete_comment_ch($comment_id, $user_id, $creater_ID) ;
        $show = $show . "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp&nbsp&nbsp" .$comment_stmt ;
        //delete comment dropdown chall function is not called due to function call witihin concatination string and then further concatenated to $show
        $show = $show . $dropdown3 ;
             //delete comment dropdown ends
        $show = $show . "</div></div></div>";
    }

    $show = $show . "<div class='comments_".$chelangeid."'></div><div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$chelangeid."'
                             placeholder='Want to know your comment....'/>
                            <button type='submit' class='btn-sm btn-primary glyphicon glyphicon-chevron-right' onclick='comment(".$chelangeid.")' ></button>
                    </div>";
    $show = $show . "</div> </div> ";
    }
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['lastpanel'] = $a + $iR;
        
        echo $show ;
        $iR = 0;
    }
}
else  echo "Invalid parameters!";
mysqli_close($db_handle);
?>
<script>
$(".text").show();
$(".editbox").hide();
$(".editbox").mouseup(function(){
return false
});
</script>
