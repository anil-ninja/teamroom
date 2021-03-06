<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/image_resize.php';
include_once '../functions/sharepage.php';
if ($_POST['chal']) {
    $user_id = $_SESSION['user_id'];
    $limit = $_SESSION['lastpanel'];
    $username = $_SESSION['username'];
    $a = (int)$limit ;
	$b = 5;
    $open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.last_update, a.project_id, a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b where a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.last_update, a.project_id, a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											UNION
											(SELECT DISTINCT a.last_update, c.project_id, a.challenge_id, c.project_title, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b join projects as c where a.project_id = c.project_id and c.project_type='1' and a.challenge_type !='5' and a.challenge_type !='2' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.last_update, d.project_id, a.challenge_id, d.project_title, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c join projects as d
											WHERE a.project_id = d.project_id and d.project_type='1' and a.challenge_status != '3' and a.challenge_status != '7' and a.challenge_type !='5' and a.challenge_type !='2' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											 ORDER BY last_update DESC LIMIT $a, $b;");
    $show = "";
    $get_display_ch_stmt_content = "" ;
    $iR = 0;
    while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
        $iR++;
       $chelange = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['stmt'])))));
       $chelangestmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['stmt']))));
    $ETA = $open_chalangerow['challenge_ETA'];
    $ch_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['challenge_title'])))));
    $chal_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['challenge_title']))));
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
    $timeopen = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['challenge_open_time'])))));
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
            $get_display_tilte = "<span style='font-family: Tenali Ramakrishna, sans-serif;' id='challenge_ti_".$chelangeid."' class='text'><b>
                <a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$chelangeid."' target='_blank'>
                ".ucfirst($ch_title)."</a></b></span>
                <input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$chelangeid."' value='".$chal_title."'/><br/>";
            $get_display_fname_likes ="<span style= 'color: #808080;'>
                &nbsp;By : <a href ='profile.php?username=" . $username_ch_ninjas . "' style= 'color: #808080;'>
                ".ucfirst($frstname)." ".ucfirst($lstname)."</a> | ".$timefunction."</span>";
        // list grp item stmt content for all type chall/article/idea/photo/video
        $get_display_ch_stmt_content = "<hr/><span id='challenge_".$chelangeid."' class='text' style='font-size: 14px'>".$chelange."</span><br/>";
		$get_display_ch_stmt_content = $get_display_ch_stmt_content. editchallenge($chelangestmt, $chelangeid) ;
//dropdown for edit/delete added here for all type of challenges except status 2, 4, 5
        $dropDown_challenge_get = "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
    if($owner_id == $user_id) {
        $dropDown_challenge_get .= "<li><a class='btn-link' onclick='edit_content(\"".$chelangeid."\", 1)'>Edit</a></li>
                              <li><a class='btn-link' onclick='delChallenge(\"".$chelangeid."\", 3);'>Delete</a></li>";                    
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
        $dropDown_challenge_get = $dropDown_challenge_get ."<li><a class='btn-link' onclick='spem(\"".$chelangeid."\", 5);'>Report Spam</a></li>";
                    } 
        $dropDown_challenge_get = $dropDown_challenge_get ."</ul>
              </div>";
//dropdown for edit/delete ended here for all type of challenges except status 2, 4, 5
//dropdown for chall after accept state starts 
        $dropDown_ch_after_accept = "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>
                    <li><a class='btn-link' onclick='edit_content(\"".$chelangeid."\", 1)'>Edit</a></li>
                    <li><a class='btn-link' onclick='delChallenge(\"".$chelangeid."\", 3);'>Delete</a></li>
                </ul>
            </div>";                    
//dropdown for chall after accept state ends 
    if ($ctype == 1) {
        if ($status == 1) {
            $show .= "<div class='list-group challenge'>
                        <div class='list-group-item'>";    
        //dropdown for delete/edit/span challenge starts
        $show = $show . $dropDown_challenge_get;
        $dropDown_challenge_get = "";
        //dropdown for delete/edit/span challenge ends here

        //    if ($remaintime != "Closed") {
                $show = $show . "<input class='btn btn-primary pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>"       ;
                                //. "<br> ETA : " . $sutime . "<br/>" . $remaintime;
          //  } else {
            //    $show = $show . " <br> " . $timefunction."<br>Closed";
          //  }
                $show = $show .$get_display_tilte."<span class='icon-question-sign'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
                $get_display_ch_stmt_content = "" ;                    
        } 
        if ($status == 2) {
            $show = $show . "<div class='list-group challenge'>
                    <div class='list-group-item' >";
                                   
        if($ownuser == $user_id) {			
            $show = $show . "<input class='btn btn-primary pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
            $show = $show . $dropDown_ch_after_accept;
            $dropDown_ch_after_accept = "";
           }
            $show = $show . $get_display_tilte."<span class='icon-question-sign'></span>".$get_display_fname_likes. "<hr><span style= 'color: #808080;'>Accepted: 
										<a href ='profile.php?username=" . $ownname ."' style= 'color: #808080;'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | ".$timefunct ."</span>";
                                  //  <br/> Time Remaining : " . $remaintimeown ."<br>
                  $show = $show . $get_display_ch_stmt_content;
                  $get_display_ch_stmt_content = "" ;	
        }
        if ($status == 4) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
                    
			if($owner_id == $user_id) {
				$show = $show . $dropDown_ch_after_accept;   
				$dropDown_ch_after_accept = "";                
                $show = $show . "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
             }    
			$show = $show.$get_display_tilte."<span class='icon-question-sign'></span>".$get_display_fname_likes. "<hr><span style= 'color: #808080;'>
												Submitted: <a href ='profile.php?username=" . $ownname . "'style= 'color: #808080;'>"
												. ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | " . $timecomm ."</span>";
							//. "<br/>  ETA Taken : " . $timeo ."
			$show = $show. $get_display_ch_stmt_content;
			$get_display_ch_stmt_content = "" ;
          }
        if ($status == 5) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item'>";
			if($owner_id == $user_id) {
				$show = $show . $dropDown_ch_after_accept; 
				$dropDown_ch_after_accept = "";                   
			}
            $show = $show .  $get_display_tilte."<span class='icon-flag'></span>".$get_display_fname_likes. "<hr><span style= 'color: #808080;'>
												Owned: <a href ='profile.php?username=" . $ownname . "' style= 'color: #808080;'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a><br> Submitted On : " . $timecomm ."</span>";
                                    //. "<br/> ETA Taken : " . $timetakennin . "
			$show = $show . $get_display_ch_stmt_content;
			$get_display_ch_stmt_content = "" ;
        }
    }
     
     if ($ctype == 6) {
        $show = $show . "<div class='list-group articlesch'> 
				<div class='list-group-item'> " ;
            
		$show = $show . $dropDown_challenge_get;
		$dropDown_challenge_get = "" ;
		
		$show = $show .$get_display_tilte."<span class='icon-leaf'></span>".$get_display_fname_likes."| At: <a href='project.php?project_id=$public_project_id'>".ucfirst($timeopen)."</a>";
		$show = $show .$get_display_ch_stmt_content;
		$get_display_ch_stmt_content = "" ;
    }
    if ($ctype == 9) {
        $show = $show . "<div class='list-group challenge'> 
				<div class='list-group-item'> " ;
            
		$show = $show . $dropDown_challenge_get;
		$dropDown_challenge_get = "" ;
		
		$show = $show .$get_display_tilte."<span class='icon-asterisk'></span>".$get_display_fname_likes."| At: <a href='project.php?project_id=$public_project_id'>".ucfirst($timeopen)."</a>";
		$show = $show .$get_display_ch_stmt_content;
		$get_display_ch_stmt_content = "" ;
    } 
     if ($ctype == 7) {
        $show = $show . "<div class='list-group articlesch'>
				<div class='list-group-item'> " ;
                                    
		$show = $show . $dropDown_challenge_get;
		$dropDown_challenge_get = "" ;
		$show = $show . $get_display_tilte."<span class='icon-book'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
		$get_display_ch_stmt_content = "" ;
    }
    if ($ctype == 8) {
        $show = $show . "<div class='list-group film'>
				<div class='list-group-item'> ";
                                   
		$show = $show . $dropDown_challenge_get;
		$dropDown_challenge_get = "";
		$show = $show . $get_display_tilte."<span class='icon-film'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
		$get_display_ch_stmt_content = "" ;
    } 
    if ($ctype == 10) {
        $show = $show . "<div class='list-group film'>
				<div class='list-group-item'> ";
                                   
		$show = $show . "<div class='list-group-item pull-right'>
							<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
								<ul class='dropdown-menu' aria-labelledby='dropdown'>";
		if($owner_id == $user_id) {
			$show = $show . "<li><a class='btn-link' onclick='delChallenge(\"".$chelangeid."\", 3);'>Delete</a></li>";                    
        }
        else {
			$show = $show ."<li><a class='btn-link' onclick='spem(\"".$chelangeid."\", 5);'>Report Spam</a></li>";
        } 
        $show = $show ."</ul>
              </div>";
		$show = $show . $get_display_tilte."<span class='icon-globe'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
		$get_display_ch_stmt_content = "" ;
    } 
     if ($ctype == 4) {
        $show = $show . "<div class='list-group idea'>
                        <div class='list-group-item'>";
                        
    //dropdown for delete/edit/span idea starts here
        $show = $show . $dropDown_challenge_get;
        $dropDown_challenge_get = "";
    //dropdown for delete/edit/span idea ends here
       $show = $show .$get_display_tilte."<span class='icon-lightbulb'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
       $get_display_ch_stmt_content = "" ;
    } 
    if ($ctype == 3) {  
        if ($status == 1) {
        $show = $show . "<div class='list-group challenge'>
                <div class='list-group-item'>";
            //dropdown for delete/edit/span challenge starts
        $show = $show . $dropDown_challenge_get;
        $dropDown_challenge_get = "";
                    //dropdown for delete/edit/span challenge ends here

        if ($owner_id != $user_id) {
            $show = $show . "<input class='btn btn-primary pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
        }
        else {
            $show = $show . "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
        }
        $show = $show .$get_display_tilte."<span class='icon-question-sign'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
        $get_display_ch_stmt_content = "" ;
	}	
		if ($status == 6) {
        $show = $show . "<div class='list-group pict'>
                <div class='list-group-item'>";
                
        //dropdown for delete/edit/span challenge starts
        $show = $show . $dropDown_challenge_get;
        $dropDown_challenge_get = "";
        //dropdown for delete/edit/span challenge ends here

        $show = $show . $get_display_tilte."<span class='icon-picture'></span>".$get_display_fname_likes.$get_display_ch_stmt_content;
        $get_display_ch_stmt_content = "" ;
	}
        if ($status == 4 || $status == 2) {
            $show = $show . "<div class='list-group challenge'>
            <div class='list-group-item'>";
    
    //dropdown for delete/edit/span challenge starts
        $show = $show .$dropDown_challenge_get;
        $dropDown_challenge_get = "";
    //dropdown for delete/edit/span challenge ends here

                $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
                if ($owner_id != $user_id ) {
                    if(mysqli_num_rows($owneduser) == 0){
                        $show = $show . "<input class='btn btn-primary pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
                    }
                }
                else {
                    $show = $show . "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
                }
                $show = $show .$get_display_tilte."<span class='icon-question-sign'></span>".$get_display_fname_likes."<span style= 'color: #808080;'>";
                        
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
                    $show = $show . "<hr/>Owned: <a href ='profile.php?username=" . $owname . "' style= 'color: #808080;'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | ".$timfunct;
                    if ($ownedbrow['user_id'] == $user_id ) {
                        $show = $show . "<input class='btn btn-primary pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
                    }
                }
                if  ($owlstatus==2){
                    $show = $show . "<br/>Owned: <a href ='profile.php?username=" . $owname . "' style= 'color: #808080;'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | " . $timfunct." | Submitted: " .$owtimesubmit ;
                }
            }
            $show = $show . "</span>".$get_display_ch_stmt_content;
            $get_display_ch_stmt_content = "" ;
        }
        if ($status == 5) {
            $show = $show . "<div class='list-group openchalhide'>
                                <div class='list-group-item'>";
                //dropdown for delete/edit/span challenge starts
        $show = $show . $dropDown_challenge_get;
        $dropDown_challenge_get = "";
                    //dropdown for delete/edit/span challenge ends here

              $show = $show . $get_display_tilte."<span class='icon-flag'></span>".$get_display_fname_likes."<span style= 'color: #808080;'>";
            
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
                $show = $show . "<hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | " . $timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    $show = $show . "<input class='btn btn-primary pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>";
                }
            }
            if  ($owlstatus==2){
                $show = $show . "<hr>Owned: <a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | ".$timfunct."| Submitted: " .$owtimesubmit ;
                //." and Time  Taken : ".$timetakennin."
            }
        }
        $show = $show . "</span>".$get_display_ch_stmt_content;
        $get_display_ch_stmt_content = "" ;
        }
     }
    if ($status == 4 || $status == 5 || $status == 2) {
        $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$chelangeid' and blob_id = '0' and status = '2')
                                            UNION
                                            (select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$chelangeid' and a.status = '2' and a.blob_id = b.blob_id);");
        while ($answerrow = mysqli_fetch_array($answer)) {
            $show = $show . "<span class='color strong' style= 'font-size: 14pt;'>
                    <p align='center'>Answer</p></span>"
					. showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $answerrow['stmt']))))) . "<br/>";
        }
    }
      $show = $show ."<hr/>".sharepage("http://www.collap.com/challengesOpen.php?challenge_id", $chelangeid) ;
      $show = $show ."<hr/><div class='row-fluid'><div class='col-md-5'>
					<span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$chelangeid ."\", 1)'> <b>Push</b>
                        <input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                    <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$chelangeid ."\", 2)'> <b>Pull</b>
                        <input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>" ;
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
        $comment_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $commenterRow['stmt'])))));
        $show = $show . "<div id='commentscontainer'>
				<div class='comments clearfix' id='comment_".$comment_id."'>
					<div class='pull-left lh-fix'>
					<img src='".resize_image("uploads/profilePictures/$username_comment_ninjas.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
					</div>" ;
		 $show = $show . "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            if($creater_ID == $user_id) {
                $show = $show . "<li><a class='btn-link' onclick='delcomment(\"".$comment_id."\", 1);'>Delete</a></li>";
            } 
            else {
               $show = $show . "<li><a class='btn-link' onclick='spem(\"".$comment_id."\", 6);'>Report Spam</a></li>";
            }
                $show = $show . "</ul>
        </div>";
		$show = $show . "<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp;&nbsp;" .$comment_stmt ;
        $show = $show . "</div></div></div>";
    }
	$show = $show . "<div class='comments_".$chelangeid."'></div><div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;
                        </div>
                            <input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$chelangeid."'
                             placeholder='Want to know your comment....'/>
                            <button type='submit' class='btn btn-primary' onclick='comment(\"".$chelangeid."\", 1)' style='margin-bottom: 10px;'>
                                <i class='icon-chevron-right'></i>
                            </button>
                    </div>";
    $show = $show . "</div> </div> ";
    }
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    }
    else {
		if(mysqli_num_rows($open_chalange) != 0) {
			$_SESSION['lastpanel'] = $a + $iR;
			echo $show ;
		}
		else echo "no data" ;
    }
    $iR = 0;
}
else { echo "Invalid parameters!"; }
mysqli_close($db_handle);
?>
<script>
$(".text").show();
$(".editbox").hide();
$(".editbox").mouseup(function(){
return false
});
</script>
