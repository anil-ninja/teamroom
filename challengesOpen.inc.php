<?php
session_start();
include_once 'html_comp/start_time.php';
include_once 'functions/delete_comment.php';
include_once 'functions/image_resize.php';
include_once 'functions/sharepage.php';
include_once 'lib/db_connect.php';
include_once 'models/challenge.php';
$obj = new challenge($_GET['challenge_id']);
$challengeSearchID = $_GET['challenge_id'];
$challengeSearchIDR = $_GET['challenge_id'];
$open_chalange = mysqli_query($db_handle, "SELECT challenge_title from challenges WHERE challenge_status != 3 AND challenge_status != 7 AND challenge_id= '$challengeSearchID' ;");
$open_chalangeRtitle = mysqli_fetch_array($open_chalange);
$challenge_page_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangeRtitle['challenge_title']))));
if (mysqli_num_rows($open_chalange) == '0') {
    include_once 'error.php';
    exit;                       //echo "no longer exists";
}
$userID = $_SESSION['user_id'];
$private_check = mysqli_query($db_handle, "SELECT project_id, challenge_type FROM challenges WHERE challenge_id = $challengeSearchID");
$private_checkRow = mysqli_fetch_array($private_check);
$private_ch_type = $private_checkRow['challenge_type'];
$pro_id = $private_checkRow['project_id'];
if($pro_id != '0') {
	$typeProject = mysqli_query($db_handle, "SELECT project_type FROM projects WHERE project_id = '$pro_id' ;");
	$typeProjectRow = mysqli_fetch_array($typeProject);
	$projectType = $typeProjectRow['project_type'];
	if(isset($_SESSION['user_id'])){
		$checkAccess = mysqli_query($db_handle, "SELECT * FROM teams WHERE project_id = '$pro_id' and user_id = '$userID' and member_status = '1' ;");
		if (mysqli_num_rows($checkAccess) == '0') {
			include_once 'error.php';
			exit;
		}
	}
	else {
		if($projectType == '2' || $projectType == '4') {
			include_once 'error.php';
			exit;
		}
		else {
			if ($private_ch_type == '2' || $private_ch_type == '5') {
				include_once 'error.php';
				exit;
			}
		}
	}
	
}
function chOpen_title($title_length) {
    if (strlen($title_length) < 40) {
        echo  $title_length;
    } else {
        echo substr($title_length, 0, 40)."....";
    }
}
$challengeSearch_user = mysqli_query($db_handle, "SELECT a.user_id, b.username, b.first_name, b.last_name from challenges as a JOIN user_info as b WHERE a.challenge_id = $challengeSearchID AND a.user_id=b.user_id;");
$challengeSearch_user_IDRow = mysqli_fetch_array($challengeSearch_user);
$challengeSearch_user_ID = $challengeSearch_user_IDRow['user_id'];
$ch_username = $challengeSearch_user_IDRow['username'];
$challengeSearch_first = $challengeSearch_user_IDRow['first_name'];
$challengeSearch_last = $challengeSearch_user_IDRow['last_name'];

function challenge_display($db_handle, $challengeSearchID) {
    $username = $_SESSION['username']; 
    $display_name_stmt = "";   
    $open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
                                                a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
                                                as a join user_info as b where a.challenge_id = '$challengeSearchID' AND a.challenge_status != '3' and a.challenge_status != '7' 
                                                and blob_id = '0' and a.user_id = b.user_id)
                                            UNION
                                                (SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
                                                b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
                                                WHERE a.challenge_id = '$challengeSearchID' AND a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id );");

        while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
            $chelange = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['stmt'])))));
            $chelangestmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['stmt']))));
            $ETA = $open_chalangerow['challenge_ETA'];
            $ch_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['challenge_title'])))));
            $chal_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $open_chalangerow['challenge_title']))));
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
			$display_title = "<span style='font-family: Tenali Ramakrishna, sans-serif;' id='challenge_ti_".$chelangeid."' class='text'><b>
							<a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$chelangeid."' target='_blank'>".ucfirst($ch_title)."</a></b>
						</span><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$chelangeid."' value='".$chal_title."'/><br/>";
			$display_fname_likes = "<span style= 'color: #808080;'>
							&nbspBy : <a href ='profile.php?username=" . $username_ch_ninjas . "' style= 'color: #808080;'>".ucfirst($frstname)." ".ucfirst($lstname)."</a> | ".$timefunction."</span>" ;
			$display_name_stmt .= "<hr/><span id='challenge_".$chelangeid."' class='text' style='line-height: 25px; font-size: 14px;color: #444;'>".$chelange."</span><br/>";
			$display_name_stmt = $display_name_stmt . editchallenge($chelangestmt, $chelangeid) ;
            if (isset ($_SESSION['user_id'])) {
				$user_id = $_SESSION['user_id'];
				if ($ctype == 1 or $ctype == 2) {
					if ($status == 1) {
						echo "<div class='list-group challenge'>
								<div class='list-group-item'>";
								dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;         
						echo "<input class='btn btn-primary pull-right' type='submit' onclick='accept_pub(\"".$chelangeid."\", 2)' value='Accept'/>" ;
						echo $display_title."<span class='icon-question-sign'></span>".$display_fname_likes.$display_name_stmt;
						   $display_name_stmt = "";
					} 
					if ($status == 2) {
						echo "<div class='list-group challenge'>
								<div class='list-group-item' >";
							dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
						if($ownuser == $user_id) {			
							echo "<input class='btn btn-primary pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>" ;
						}
						echo $display_title."<span class='icon-question-sign'></span>".$display_fname_likes. "<span style= 'color: #808080;'>
								<hr>Accepted: <a href ='profile.php?username=" . $ownname ."' style= 'color: #808080;'>"
									. ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | on ".$timefunct."</span>" ;
								//  <br/> Time Remaining : " . $remaintimeown ."<br>
						echo $display_name_stmt;
						$display_name_stmt = "";
					}
					if ($status == 4) {
						echo "<div class='list-group openchalhide'>
								<div class='list-group-item'>";
						dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
						if($owner_id == $user_id) {			
							echo "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 3)'>Close</button>";
						}
						echo $display_title."<span class='icon-question-sign'></span>".$display_fname_likes."<hr><span style= 'color: #808080;'>Submitted: 
									<a href ='profile.php?username=" . $ownname . "' style= 'color: #808080;'>"
									. ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | Submitted: ".$timecomm."</span>" ;
													//. "<br/>  ETA Taken : " . $timeo ."
						echo $display_name_stmt;
							$display_name_stmt = "";
					}
					if ($status == 5) {
						echo "<div class='list-group openchalhide'>
								<div class='list-group-item'>";
						dropDown_delete_after_accept($chelangeid, $user_id, $owner_id) ;
						echo $display_title."<span class='icon-question-sign'></span>".$display_fname_likes. "<hr><span style= 'color: #808080;'>Owned: 
										<a href ='profile.php?username=" . $ownname . "' style= 'color: #808080;'>"
										. ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a> | Submitted: " . $timecomm."</span>" ;
											//. "<br/> ETA Taken : " . $timetakennin . "
						echo $display_name_stmt;
						$display_name_stmt = "";
					}
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
						echo $display_title."<span class='icon-question-sign'></span>".$display_fname_likes.$display_name_stmt;
						$display_name_stmt = "";
					}	
					if ($status == 6) {
						echo "<div class='list-group pict'>
								<div class='list-group-item'>";
						dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
					    echo $display_title."<span class='icon-picture'></span>".$display_fname_likes.$display_name_stmt;
					    $display_name_stmt = "";
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
					    echo $display_title."<span class='icon-question-sign'></span>".$display_fname_likes;
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
								echo "<hr/><span style= 'color: #808080;'>Owned: <a href ='profile.php?username=" . $owname . "' style= 'color: #808080;'>"
									. ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a>| ".$timfunct."</span>";
								if ($ownedbrow['user_id'] == $user_id ) {
									echo "<input class='btn btn-primary pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>" ;
								}
							}
							if  ($owlstatus==2){
								echo "<hr/><span style= 'color: #808080;'>Owned: <a href ='profile.php?username=" . $owname . "' style= 'color: #808080;'>"
									. ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | " . $timfunct." | Submitted: " .$owtimesubmit."</span>" ;
									//." and Time Taken : ".$timetakennin."
							}
						}
					    echo $display_name_stmt;
					   $display_name_stmt = "";
					}
					if ($status == 5) {
						echo "<div class='list-group openchalhide'>
								<div class='list-group-item'>";
					    dropDown_challenge($chelangeid, $user_id, $remaining_time_own, $owner_id) ;
						echo $display_title."<span class='icon-flag'></span>".$display_fname_likes;
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
								echo "<hr/><span style= 'color: #808080;'>Owned: <a href ='profile.php?username=" . $owname . "'>"
									. ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a> | " . $timfunct."</span>";
								if ($ownedbrow['user_id'] == $user_id ) {
									echo "<input class='btn btn-primary pull-right' type='submit' style='padding: 0px 0px 0px;' onclick='answersubmit(\"".$chelangeid."\", 1)' value='Submit'/>" ;
								}
							}
							if  ($owlstatus==2){
								echo "<hr/><span style= 'color: #808080;'>Owned: <a href ='profile.php?username=" . $owname . "' style= 'color: #808080;'>"
									. ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a> | ".$timfunct."| Submitted: " .$owtimesubmit."</span>" ;
										//." and Time Taken : ".$timetakennin."
							}
						}
						echo $display_name_stmt ;
						$display_name_stmt = "";
					}
				}
				if ($ctype == 4) {
					echo "<div class='list-group idea'>
							<div class='list-group-item'>";
				    dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
					echo $display_title."<span class='icon-lightbulb'></span>".$display_fname_likes.$display_name_stmt;
					$display_name_stmt = "";
				}
				if ($ctype == 5) {
				   if ($status == 2) {
						echo "<div class='list-group pushpin'>
								<div class='list-group-item'>";
							dropDown_challenge_pr($chelangeid, $user_id, $remaintimeown, $owner_id) ;
						if ($ownuser == $user_id) {
							echo "<input class='btn btn-primary pull-right' type='submit' onclick='answersubmit(\"".$chelangeid."\", 2)' value='Submit'/>";
						}
						echo $display_title."<span class='icon-pushpin'></span>".$display_fname_likes."<hr/><span style= 'color: #808080'> Assigned To:&nbsp <a style= 'color: #808080' href ='profile.php?username=".$ownname."'>"
										.ucfirst($ownfname)." ".ucfirst($ownlname)."</a> | ".$timefunct."</span>";
						echo $display_name_stmt;
						$display_name_stmt = "" ;
						// " . $remaintimeown . "
					}
					if ($status == 4) {
						echo "<div class='list-group pushpin'>
								<div class='list-group-item'>";
						if ($owner_id == $user_id) {
							echo "<button type='submit' class='btn btn-primary pull-right' onclick='closechal(\"".$chelangeid."\", 6)'>Close</button>";
						}
						echo $display_title."<span class='icon-pushpin'></span>".$dispaly_fname_likes.
											"<hr><span style= 'color: #808080'>Assigned To: " . ucfirst($ownfname)." ".ucfirst($ownlname)."</a>
											| Submitted On: ".$timecomm."</span>";
						echo $display_name_stmt;
						$display_name_stmt = "" ;
					}
					if ($status == 5) {
						echo "<div class='list-group flag'>
								<div class='list-group-item'>";
						echo "<span class='color strong pull-right' style= 'color: #808080'>Closed</span>";
						echo $display_title."<span class='icon-flag'></span>".$dispaly_fname_likes.
											"<hr><span style= 'color: #808080'>Assigned To: "
											.ucfirst($ownfname)." ".ucfirst($ownlname)."</a> | Submitted: " . $timecomm."</span>";
						echo $display_name_stmt;
						$display_name_stmt = "" ;
					}
				}
				if ($ctype == 6) {
					echo "<div class='list-group articlesch'>
							<div class='list-group-item'>";
				    dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
					echo $display_title."<span class='icon-leaf'></span>".$display_fname_likes.$display_name_stmt;
					$display_name_stmt = "";
				}
				if ($ctype == 9) {
					echo "<div class='list-group challenge'>
							<div class='list-group-item'>";
				    dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
					echo $display_title."<span class='icon-asterisk'></span>".$display_fname_likes.$display_name_stmt;
					$display_name_stmt = "";
				}
				if ($ctype == 7) {
					echo "<div class='list-group articlesch'>
							<div class='list-group-item'>";
				    dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
				    echo $display_title."<span class='icon-book'></span>".$display_fname_likes.$display_name_stmt; 
				    $display_name_stmt = "";   
				}
				if ($ctype == 8) {
					echo "<div class='list-group film'>
							<div class='list-group-item'>";
					dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
				    echo $display_title."<span class='icon-film'></span>".$display_fname_likes.$display_name_stmt; 
				    $display_name_stmt = "";         
				}
				if ($ctype == 10) {
					echo "<div class='list-group film'>
							<div class='list-group-item'>";
					dropDown_challenge($chelangeid, $user_id, $remaintime, $owner_id) ;
				    echo $display_title."<span class='icon-globe'></span>".$display_fname_likes.$display_name_stmt; 
				    $display_name_stmt = "";         
				} 
                if ($status == 4 || $status == 5 || $status == 2) {
					$answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$chelangeid' and blob_id = '0' and status = '2')
														UNION
														(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$chelangeid' and a.status = '2' and a.blob_id = b.blob_id);");
					while ($answerrow = mysqli_fetch_array($answer)) {
						$answer_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", str_replace("<an>", "+",$answerrow['stmt'])))));
						echo "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
								<p align='center'>Answer</p></span>"
							. $answer_stmt. "<br/><br/>";
					}
				}
			} 
            else {
                if ($ctype == 1 OR $ctype == 3) {
                    echo "<div class='list-group challenge'>
                            <div class='list-group-item'>
                                <a data-toggle='modal' data-target='#SignIn'>
                                    <button class='btn btn-primary pull-right' >Accept</button>
                                </a>";
                    echo $display_title."<span class='icon-question-sign'></span>".$display_fname_likes.$display_name_stmt;
                          
                }
                else if ($ctype == 4) {
                    echo "<div class='list-group idea'>
                                <div class='list-group-item'>";
                                   echo $display_title."<span class='icon-lightbulb'></span>".$display_fname_likes.$display_name_stmt;
                }
                else if ($ctype == 6) {
                    echo "<div class='list-group deciduous'>
                                <div class='list-group-item'>";
                                    echo $display_title."<span class='icon-leaf'></span>".$display_fname_likes.$display_name_stmt;
                }
                else if ($ctype == 9) {
                    echo "<div class='list-group asterisk'>
                                <div class='list-group-item'>";
                                    echo $display_title."<span class='icon-asterisk'></span>".$display_fname_likes.$display_name_stmt;
                }
                else if ($ctype == 7) {
                    echo "<div class='list-group articlesch'>
                            <div class='list-group-item'>";
                        echo $display_title."<span class='icon-book'></span>".$display_fname_likes.$display_name_stmt;
                }
                else if ($ctype == 8) {
                    echo "<div class='list-group film'>
                            <div class='list-group-item'>";
                            echo $display_title."<span class='icon-film'></span>".$display_fname_likes.$display_name_stmt;
                }
                else if ($ctype == 10) {
                    echo "<div class='list-group film'>
                            <div class='list-group-item'>";
                            echo $display_title."<span class='icon-globe'></span>".$display_fname_likes.$display_name_stmt;
                }
            }
            echo "<hr/>".sharepage("http://www.collap.com/challengesOpen.php?challenge_id", $chelangeid) ;
            echo "<hr/><div class='row-fluid'><div class='col-md-5'>
            <span id='demo11' class='icon-hand-up' style='cursor: pointer; float: none;' onclick='like(\"".$chelangeid ."\", 1)'> <b>Push</b>
                        <input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                    <span id='demo13' class='icon-hand-down' style='cursor: pointer; float: none;' onclick='dislike(\"".$chelangeid ."\", 2)'> <b>Pull</b>
                        <input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>" ;
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
                $comment_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", str_replace("<an>", "+",$commenterRow['stmt'])))));
                echo "<div id='commentscontainer'>
                    <div class='comments clearfix' id='comment_".$comment_id."'>
                        <div class='pull-left lh-fix'>
                            <img src='".resize_image("uploads/profilePictures/$username_comment_ninjas.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
                        </div>" ;
                 if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                 dropDown_delete_comment_ch($comment_id, $user_id, $creater_ID);
                }
                echo "<div class='comment-text'>
                    <span class='pull-left color strong'>&nbsp;<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
                        &nbsp;&nbsp;".$comment_stmt;
                echo "</div>
                </div>
            </div>";
            }
            echo "<div class='comments_".$chelangeid."'></div><div id='demo14' class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
                </div>
                <div class='comment-text'>";
            if (isset($_SESSION['user_id'])) {
                $userID = $_SESSION['user_id'];
                echo "
                    <input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$chelangeid."' placeholder='Want to know your comment....'/>
                    <button type='submit' class='btn btn-primary' onclick='comment(\"".$chelangeid."\", 1)' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                        <i class='icon-chevron-right'></i>
                    </button>";
            } else {
                echo "<input type='text' class='input-block-level' STYLE='width: 83%;' placeholder='Want to know your comment....'/>
                    <a data-toggle='modal' data-target='#SignIn'>
                        <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                            <i class='icon-chevron-right'></i>
                        </button>
                    </a>";
            }
            echo "</div>
            </div>";
            echo " </div></div>";
        }
    }
?>
