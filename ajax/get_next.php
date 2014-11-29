<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if ($_POST['chal']) {
    $user_id = $_SESSION['user_id'];
    $limit = $_SESSION['lastpanel'];
    $username = $_SESSION['username'];
    $a = (int) $limit;
    $b = $a + 5;
    $open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b where a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											UNION
											(SELECT DISTINCT a.challenge_id, c.project_title, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b join projects as c where a.project_id = c.project_id and c.project_type='1' and a.challenge_type !='5' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, d.project_title, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c join projects as d
											WHERE a.project_id = d.project_id and d.project_type='1' and a.challenge_status != '3' and a.challenge_status != '7' and a.challenge_type !='5' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											 ORDER BY creation_time DESC LIMIT $a,$b;");
    $show = "";
    $iR = 0;
    while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
        $i++;
       $chelange = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['stmt'])));
    $ETA = $open_chalangerow['challenge_ETA'];
    $ch_title = $open_chalangerow['challenge_title'];
    $ch_id = $open_chalangerow['user_id'];
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

    $show_add_dropdown = "<div class='list-group-item pull-right'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                                $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                                $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                                $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                                if($challenge_dropdown_userID == $user_id) {
                                    $show_add_dropdown = $show_add_dropdown . "<li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                        <li><button class='btn-link' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete</button></li>";                    
                                /*    if($remaining_time_ETA_over == 'Time over') {        
                                        $show = $show . "<li>
                                                <form method='POST' class='inline-form'>
                                                    <input type='hidden' name='id' value='".$chelangeid."'/>
                                                    <input class='btn-link' type='submit' name='eta' value='Change ETA'/>
                                                </form>
                                            </li>";
                                    }    */                                
                                }
                                else {
                                $show_add_dropdown = $show_add_dropdown . "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                                <button type='submit' name='pr_spem' value='".$chelangeid."' class='btn-link' >Report Spam</button>
                                            </form>
                                        </li>";
                                } 
                        $show_add_dropdown = $show_add_dropdown . "</ul>
                        </div>";
    
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
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>";
    
//dropdown for delete/edit/span challenge starts
        $show = $show . $show_add_dropdown;
        //dropdown for delete/edit/span challenge ends here

            
        //    if ($remaintime != "Closed") {
                $show = $show . "<form method='POST' class='inline-form pull-right'>
                                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                                </form>"       ;
                                //. "<br> ETA : " . $sutime . "<br/>" . $remaintime;
          //  } else {
            //    $show = $show . " <br> " . $timefunction."<br>Closed";
          //  }
                    $show = $show . "<br/>" . $timefunction."<br/><br/></div>
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
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
										<br>" . $timefunction . "<br/><br/>
                                </div>
                                <div class='col-md-5'>    
                                    Accepted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>" ;
                                    //<br/> Time Remaining : " . $remaintimeown ."<br>
               $show = $show . "</div>";
          if($ownuser == $user_id) {			
			$show = $show . " <div class='col-md-2'>  
                                  <input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>
                            </div>";
				}
                                $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                                $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                                $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                                if($challenge_dropdown_userID == $user_id) {
                                    $show = $show . "<div class='list-group-item pull-right'>
                                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                            <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                                <li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                                <li><button class='btn-link' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete</button></li>
                                            </ul>
                                        </div>";                    
                                }
			$show = $show . "</div>
                            </div>
                        </div>" ;	
        }
        if ($status == 4) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix' >     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div class='row' style='line-height: 16.50px;'>
                            <div class='col-md-3'>
                                <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/><br/>
                            </div>
                            <div class='col-md-5'>
                                Submitted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> " . $timecomm ;
                                //. "<br/>  ETA Taken : " . $timeo ."
            $show = $show . "</div>
                            <div class='col-md-2 pull-right'>";
          
            $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                                $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                                $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                                if($challenge_dropdown_userID == $user_id) {
                                    $show = $show . "<div class='list-group-item pull-right'>
                                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                            <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                                <li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                                <li><button class='btn-link' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete</button></li>
                                            </ul>
                                        </div>";                    
                                }
                                if($ch_id == $user_id) {			
                    $show = $show . " <form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                                        <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                                        <button type='submit' class='btn-primary' name='closechal'>Close</button>
                                    </form>";
                                }
                $show = $show . "</div>
                            </div>
                        </div>" ;	
        }
        if ($status == 5) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br> " . $timefunction."<br/><br/>" ;
                                    //. "<br/> ETA Given : " . $timeo . "
             $show = $show . "</div>
                                <div class='col-md-5'>
                                    Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> Submitted On : " . $timecomm ;
                                    //. "<br/>  ETA Taken : " . $timetakennin . "
             $show = $show . "</div>";
                                $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                                $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                                $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                                if($challenge_dropdown_userID == $user_id) {
                                    $show = $show . "<div class='list-group-item pull-right'>
                                                        <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                                        <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                                            <li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                                            <li><button class='btn-link' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete</button></li>
                                                        </ul>
                                                    </div>";                    
                                }
                         $show = $show . "</div>
                        </div>
                    </div>" ;	
            }
    }
    if ($ctype == 2) {
        if ($status == 1) {
            $show .= "<div class='list-group challenge'>
                        <div class='list-group-item'>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-question-sign'></span>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>";
    
//dropdown for delete/edit/span challenge starts
        $show = $show . $show_add_dropdown;
        //dropdown for delete/edit/span challenge ends here

            
        //    if ($remaintime != "Closed") {
                $show = $show . "<form method='POST' class='inline-form pull-right'>
                                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                                </form>"       ;
                                //. "<br> ETA : " . $sutime . "<br/>" . $remaintime;
          //  } else {
            //    $show = $show . " <br> " . $timefunction."<br>Closed";
          //  }
                    $show = $show . "<br/>" . $timefunction."<br/><br/></div>
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
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
										<br>" . $timefunction . "<br/><br/>
                                </div>
                                <div class='col-md-5'>    
                                    Accepted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>" ;
                                    //<br/> Time Remaining : " . $remaintimeown ."<br>
               $show = $show . "</div>";
          if($ownuser == $user_id) {			
			$show = $show . " <div class='col-md-2'>  
                                  <input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>
                            </div>";
				}
                                $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                                $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                                $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                                if($challenge_dropdown_userID == $user_id) {
                                    $show = $show . "<div class='list-group-item pull-right'>
                                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                            <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                                <li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                                <li><button class='btn-link' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete</button></li>
                                            </ul>
                                        </div>";                    
                                }
			$show = $show . "</div>
                            </div>
                        </div>" ;	
        }
        if ($status == 4) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix' >     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div class='row' style='line-height: 16.50px;'>
                            <div class='col-md-3'>
                                <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/><br/>
                            </div>
                            <div class='col-md-5'>
                                Submitted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> " . $timecomm ;
                                //. "<br/>  ETA Taken : " . $timeo ."
            $show = $show . "</div>
                            <div class='col-md-2 pull-right'>";
          
            $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                                $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                                $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                                if($challenge_dropdown_userID == $user_id) {
                                    $show = $show . "<div class='list-group-item pull-right'>
                                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                            <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                                <li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                                <li><button class='btn-link' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete</button></li>
                                            </ul>
                                        </div>";                    
                                }
                                if($ch_id == $user_id) {			
                    $show = $show . " <form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                                        <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                                        <button type='submit' class='btn-primary' name='closechal'>Close</button>
                                    </form>";
                                }
                $show = $show . "</div>
                            </div>
                        </div>" ;	
        }
        if ($status == 5) {
            $show = $show . "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br> " . $timefunction."<br/><br/>" ;
                                    //. "<br/> ETA Given : " . $timeo . "
             $show = $show . "</div>
                                <div class='col-md-5'>
                                    Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> Submitted On : " . $timecomm ;
                                    //. "<br/>  ETA Taken : " . $timetakennin . "
             $show = $show . "</div>";
                                $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                                $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                                $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                                if($challenge_dropdown_userID == $user_id) {
                                    $show = $show . "<div class='list-group-item pull-right'>
                                                        <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                                        <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                                            <li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                                            <li><button class='btn-link' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete</button></li>
                                                        </ul>
                                                    </div>";                    
                                }
                         $show = $show . "</div>
                        </div>
                    </div>" ;	
            }
    $show = $show . "<div class='list-group-item'><p align='center' style='font-size: 14pt;'>Posted in <b>" . ucfirst($timeopen) . "</b></p></div>" ;
    } 
     if ($ctype == 6) {
        $show = $show . "<div class='list-group articlesch'>
				<div class='list-group-item' style='line-height: 24.50px;'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-book'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>
                           <div class='pull-right list-group-item'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                        $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                        $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                        if($challenge_dropdown_userID == $user_id) {
                            $show = $show . "<li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                <li><button class='btn-link' cID='".$chelangeid."' onclick='delArticle(".$chelangeid.");'>Delete</button></li>";
                        }
                        else {
                            $show = $show . "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                        <button type='submit' name='pr_spem' value='".$chelangeid."' class='btn-link' >Report Spam</button>
                                    </form></li>";
                        }
                        $show = $show . "</ul>
                        </div>
                            <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                            <br> " . $timefunction . "<br/><br/>
                        </div>";
    $show = $show . "<div class='list-group-item'><p align='center' style='font-size: 14pt;'>Posted in <b>" . ucfirst($timeopen) . "</b></p></div>" ;
    } 
     if ($ctype == 7) {
        $show = $show . "<div class='list-group articlesch'>
				<div class='list-group-item' style='line-height: 24.50px;'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-book'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>
                           <div class='pull-right list-group-item'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                        $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                        $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                        if($challenge_dropdown_userID == $user_id) {
                            $show = $show . "<li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                <li><button class='btn-link' cID='".$chelangeid."' onclick='delArticle(".$chelangeid.");'>Delete</button></li>";
                        }
                        else {
                            $show = $show . "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                        <button type='submit' name='pr_spem' value='".$chelangeid."' class='btn-link' >Report Spam</button>
                                    </form></li>";
                        }
                        $show = $show . "</ul>
                        </div>
                            <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                            <br> " . $timefunction . "<br/><br/>
                        </div>";
    }
    if ($ctype == 8) {
        $show = $show . "<div class='list-group film'>
				<div class='list-group-item' style='line-height: 24.50px;'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-film'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>
                           <div class='pull-right list-group-item'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$chelangeid' AND user_id='$user_id';"));
                        $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                        $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                        if($challenge_dropdown_userID == $user_id) {
                            $show = $show . "<li><button class='btn-link' onclick='edit_content(".$chelangeid.")'>Edit</button></li>
                                <li><button class='btn-link' cID='".$chelangeid."' onclick='delArticle(".$chelangeid.");'>Delete</button></li>";
                        }
                        else {
                            $show = $show . "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                        <button type='submit' name='pr_spem' value='".$chelangeid."' class='btn-link' >Report Spam</button>
                                    </form></li>";
                        }
                        $show = $show . "</ul>
                        </div>
                            <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                            <br> " . $timefunction . "<br/><br/>
                        </div>";
    } 
     if ($ctype == 4) {
        $show = $show . "<div class='list-group idea'>
                        <div class='list-group-item' style='line-height: 24.50px;'></span>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-flash'></span>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>";
    //dropdown for delete/edit/span idea starts here
        $show = $show . $show_add_dropdown;
    //dropdown for delete/edit/span idea ends here
        $show = $show . "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                        .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/><br/>
                             </div>";
    } 
    if ($ctype == 3) {
        
		if ($status == 1) {
        $show = $show . "<div class='list-group challenge'>
                <div class='list-group-item'>";
            //dropdown for delete/edit/span challenge starts
        $show = $show . $show_add_dropdown;
                    //dropdown for delete/edit/span challenge ends here

        if ($ch_id != $user_id) {
            $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                    <input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
                </form>" ;
			}
        else {
            $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                    <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                    <button type='submit' class='btn-primary' name='closechallenge'>Close</button>
                </form>";
        }
        $show = $show ."<div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-question-sign'></span>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                        .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>"
                        .$timefunction."<br/><br/>
            </div>";
	}	
		if ($status == 6) {
        $show = $show . "<div class='list-group film'>
                <div class='list-group-item'>";
        //dropdown for delete/edit/span challenge starts
        $show = $show . $show_add_dropdown;
        //dropdown for delete/edit/span challenge ends here

        $show = $show . "<div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-picture'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                            .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>".$timefunction."<br/><br/>
                </div>";
	}
        if ($status == 2) {
			$show = $show . "<div class='list-group challenge'>
                                            <div class='list-group-item' >";
                            //dropdown for delete/edit/span challenge starts
        $show = $show . $show_add_dropdown;
                    //dropdown for delete/edit/span challenge ends here

                        $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
                        if ($ch_id != $user_id ) {
                            if(mysqli_num_rows($owneduser) == 0){
                                $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
                                                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                                    <input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
                                                </form>" ;
                            }
                        }
                        else {
                            $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                                                <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                                                <button type='submit' class='btn-primary' name='closechallenge'>Close</button>
                                            </form>";
                        }
               $show = $show . "<div class='pull-left lh-fix'>     
                                    <span class='glyphicon glyphicon-question-sign'></span>
                                    <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                        .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>"
                       .$timefunction."<br/><br>
                </div>";
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
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span><br/>" . $timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>" ;
                }
                $show = $show . "<br/>".$timefunction."<br/><br/></div>";
            }
        }
        if ($status == 4) {
            $show = $show . "<div class='list-group challenge'>
            <div class='list-group-item'>";
                //dropdown for delete/edit/span challenge starts
            
        $show = $show .$show_add_dropdown ;
                    //dropdown for delete/edit/span challenge ends here

                $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
                if ($ch_id != $user_id ) {
                    if(mysqli_num_rows($owneduser) == 0){
                        $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
                                            <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                            <input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
                                        </form>" ;
                    }
                }
                else {
                    $show = $show . "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                                        <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                                        <button type='submit' class='btn-primary' name='closechallenge'>Close</button>
                                    </form>";
                }
                $show = $show . "<div class='pull-left lh-fix'>     
                                    <span class='glyphicon glyphicon-question-sign'></span>
                                    <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                </div>
                                <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>"
                                .$timefunction."<br/><br/>
            </div>";
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
                    $show = $show . "<div class='list-group-item'>";
                    if ($ownedbrow['user_id'] == $user_id ) {
                        $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>";
                    }
                    $show = $show . "Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                    . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span><br/>" . $timfunct."
                    </div>";
                }
                if  ($owlstatus==2){
                    $show = $show . "<div class='list-group-item'>
                                Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                    . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a></span><br/>" . $timfunct."<br/> Submitted on : " .$owtimesubmit ;
                    //." and Time Taken : ".$timetakennin."
                    $show = $show . "</div>";
                }
            }
        }
        if ($status == 5) {
            $show = $show . "<div class='list-group openchalhide'>
                <div class='list-group-item' >";
                //dropdown for delete/edit/span challenge starts
        $show = $show . $show_add_dropdown;
                    //dropdown for delete/edit/span challenge ends here

              $show = $show . "<div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-flag'></flag>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>" . $timefunction."<br/><br/></div>";
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
                $show = $show . "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span><br/>" . $timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    $show = $show . "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>";
                }
                $show = $show . "</div>";
			}
			 if  ($owlstatus==2){
                $show = $show . "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a></span><br/>" . $timfunct."<br/> Submitted on : " .$owtimesubmit ;
                //." and Time  Taken : ".$timetakennin."
                $show = $show . "</div>";
			}
            }
        }
    
    }
   $show = $show . "<div class='list-group-item'><p align='center' style='font-size: 14pt;' id='challenge_ti_".$chelangeid."' class='text' ><b>" . ucfirst($ch_title) . "</b></p>
			<br/><span id='challenge_".$chelangeid."' class='text' >".$chelange."</span>
			<input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$chelangeid."' value='".$ch_title."'/>" ;
	if(isset($_SESSION['user_id'])){
		if(substr($chelange, 0, 1) != '<') {
	$show = $show . "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
			}
		else {
			$chaaa = substr(strstr($chelange, '<br/>'), 5) ;
			$cha = strstr($chelange, '<br/>' , true) ;
			if(substr($chelange, 0, 4) == '<img') {
	$show = $show . "<div class='editbox' style='width : 90%;' id='challenge_pic_".$chelangeid."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$chelangeid.")' id='pic_file_".$chelangeid."'/><br/><br/>" ;
					}
			if(substr($chelange, 0, 2) == '<a') {
	$show = $show . "<div class='editbox' style='width : 90%;' id='challenge_file_".$chelangeid."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$chelangeid.")' id='pic_file_".$chelangeid."'/><br/><br/>" ;
					}
			if(substr($chelange, 0, 3) == '<if') {
					echo "<div class='editbox' style='width : 90%;' id='challenge_video_".$chelangeid."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$chelangeid."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
	$show = $show . "<input id='_fileChallenge_".$chelangeid."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'>
					<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='save_pic_file(".$chelangeid.")' id='pic_file_save_".$chelangeid."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$chelangeid."' >".$chaaa."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedchallenge(".$chelangeid.")' id='doneediting_".$chelangeid."'/>";		
			}
		}
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
        //delete comment dropdown chall function is not called due to function call witihin concatination string and then further concatenated to $show
        $show = $show . "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            
            $challenge_dropdown_comment = mysqli_query($db_handle, ("SELECT user_id FROM response_challenge WHERE response_ch_id = '$comment_id' AND user_id='$user_id';"));
                    $challenge_dropdown_commentRow = mysqli_fetch_array($challenge_dropdown_comment);
                    $challenge_dropdown_comment_userID = $challenge_dropdown_commentRow['user_id'];
                    if($challenge_dropdown_comment_userID == $user_id) {
                        $show = $show . "<li><button class='btn-link' cID='".$comment_id."' onclick='delcomment(".$comment_id.");'>Delete</button></li>";
                    } 
                    else {
                      $show = $show . "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                    <button type='submit' name='spem' value='".$comment_id."' class='btn-link' >Report Spam</button>
                                </form>
                            </li>";
                    }
             $show = $show . "</ul>
        </div>";
             //delete comment dropdown ends
        $show = $show . "</div></div></div>";
    }

    $show = $show . "<div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                        <form action='' method='POST' class='inline-form'>
                            <input type='hidden' value='" . $chelangeid . "' name='own_challen_id' />
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' name='own_ch_response'
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
<script>
$(".text").show();
$(".editbox").hide();
$(".editbox").mouseup(function(){
return false
});
</script>
