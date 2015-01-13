<?php 

function dropDown_delete_comment_ch($deleteid, $user_ID, $owner_id) {
    echo  "<div class='dropdown pull-right'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'>
                    <b class='caret'></b>
                </a>
                <ul class='dropdown-menu'>";
            if($owner_id == $user_ID) {
                echo "<li>
                        <a class='btn-link' href='#' onclick='delcomment(\"".$deleteid."\", 1);'><strong>
                            Delete</strong>
                        </a>
                    </li>";
            } 
            else {
               echo "<li>
                        <a class='btn-link' href='#' onclick='spem(\"".$deleteid."\", 6);'>
                            Report Spam
                        </a>
                    </li>";
            }
                echo "</ul>
        </div>";
}
function dropDown_delete_comment_ch_old($deleteid, $user_ID, $owner_id) {
    echo  "<div class='dropdown pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
			if($owner_id == $user_ID) {
				echo "<li><button class='btn-link' onclick='delcomment(\"".$deleteid."\", 1);'>Delete</button></li>";
			} 
			else {
			   echo "<li><button class='btn-link' onclick='spem(\"".$deleteid."\", 6);'>Report Spam</button></li>";
			}
                echo "</ul>
        </div>";
}

function dropDown_delete_comment_pr($deleteid, $user_ID, $owner_id) {
    echo  "<div class='dropdown pull-right'>
            <a href='#' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
            <ul class='dropdown-menu'>";
            if($owner_id == $user_ID) {
                echo "<li>
                        <a class='btn-link' href='#' onclick='delcomment(\"".$deleteid."\", 2);'>
                            Delete
                        </a>
                    </li>";
            }
            else {
               echo "<li>
                        <a class='btn-link' href='#' onclick='spem(\"".$deleteid."\", 8);'>
                            Report Spam
                        </a>
                    </li>";
            }
                echo "</ul>
        </div>";
}

function dropDown_delete_comment_pr_old($deleteid, $user_ID, $owner_id) {
    echo  "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
			if($owner_id == $user_ID) {
				echo "<li><button class='btn-link' onclick='delcomment(\"".$deleteid."\", 2);'>Delete</button></li>";
			}
			else {
			   echo "<li><button class='btn-link' onclick='spem(\"".$deleteid."\", 8);'>Report Spam</button></li>";
			}
                echo "</ul>
        </div>";
}

function dropDown_delete_comment_pr_ch_old($deleteid, $user_ID, $owner_id) {
    echo  "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
			if($owner_id == $user_ID) {
				echo "<li><button class='btn-link' onclick='delcomment(\"".$deleteid."\", 1);'>Delete</button></li>";
			}
			else {
			   echo "<li><button class='btn-link' onclick='spem(\"".$deleteid."\", 10);'>Report Spam</button></li>";
			}
                echo "</ul>
        </div>";
}

function dropDown_delete_comment_pr_ch($deleteid, $user_ID, $owner_id) {
    echo  "<div class='dropdown pull-right'>
            <a href='#' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
            <ul class='dropdown-menu'>";
            if($owner_id == $user_ID) {
                echo "<li>
                        <a class='btn-link' href='#' onclick='delcomment(\"".$deleteid."\", 1);'>
                            Delete
                        </a>
                    </li>";
            }
            else {
               echo "<li>
                        <a class='btn-link' href='#' onclick='spem(\"".$deleteid."\", 10);'>
                            Report Spam
                        </a>
                    </li>";
            }
                echo "</ul>
        </div>";
}
function dropDown_challenge_old($challenge_ID, $user_ID, $remaining_time_ETA_over, $owner_id) {
        echo "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    if($owner_id == $user_ID) {
                        echo "<li><button class='btn-link' onclick='edit_content(\"".$challenge_ID."\", 1)'>Edit</button></li>
                              <li><button class='btn-link' onclick='delChallenge(\"".$challenge_ID."\", 3);'>Delete</button></li>";                    
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
                       echo "<li><button class='btn-link' onclick='spem(\"".$challenge_ID."\", 5);'>Report Spam</button></li>";
                    } 
               echo "</ul>
              </div>";
}

function dropDown_challenge($challenge_ID, $user_ID, $remaining_time_ETA_over, $owner_id) {
        echo "<div class='dropdown pull-right'>
                <a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
                <ul class='dropdown-menu'>";
                    if($owner_id == $user_ID) {
                        echo "<li>
                                <a class='btn-link' href='#' onclick='edit_content(\"".$challenge_ID."\", 1)'>
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a class='btn-link' href='#' onclick='delChallenge(\"".$challenge_ID."\", 3);'>
                                    Delete
                                </a>
                            </li>";                    
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
                       echo "<li>
                                <a class='btn-link' href='#' onclick='spem(\"".$challenge_ID."\", 5);'>
                                    Report Spam
                                </a>
                            </li>";
                    } 
               echo "</ul>
              </div>";
}
function dropDown_challenge_pr_old($challenge_ID, $user_ID, $remaining_time_ETA_over, $owner_id) {
        echo "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    if($owner_id == $user_ID) {
                        echo "<li><button class='btn-link' onclick='edit_content(\"".$challenge_ID."\", 2)'>Edit</button></li>
                              <li><button class='btn-link' onclick='delChallenge(\"".$challenge_ID."\", 3);'>Delete</button></li>";                    
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
                       echo "<li><button class='btn-link' onclick='spem(\"".$challenge_ID."\", 9);'>Report Spam</button></li>";
                    } 
               echo "</ul>
              </div>";
}

function dropDown_challenge_pr($challenge_ID, $user_ID, $remaining_time_ETA_over, $owner_id) {
        echo "<div class='dropdown pull-right'>
                <a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
                <ul class='dropdown-menu'>";
                    if($owner_id == $user_ID) {
                        echo "<li>
                                <a class='btn-link' href='#' onclick='edit_content(\"".$challenge_ID."\", 2)'>
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a class='btn-link' href='#' onclick='delChallenge(\"".$challenge_ID."\", 3);'>
                                    Delete
                                </a>
                            </li>";                    
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
                       echo "<li>
                                <a class='btn-link' href='#' onclick='spem(\"".$challenge_ID."\", 9);'>
                                    Report Spam
                                </a>
                            </li>";
                    } 
               echo "</ul>
              </div>";
}

function dropDown_delete_after_accept($challenge_ID, $user_ID, $owner_id) {
    if($owner_id == $user_ID) {
        echo "<div class='dropdown pull-right'>
                <a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
                <ul class='dropdown-menu'>
                    <li>
                        <a class='btn-link' href='#' onclick='edit_content(\"".$challenge_ID."\", 1)'>
                            Edit
                        </a>
                    </li>
                    <li>
                        <a class='btn-link' href='#' onclick='delChallenge(\"".$challenge_ID."\", 3);'>
                            Delete
                        </a>
                    </li>
                </ul>
            </div>";                    
    }
}

function dropDown_delete_after_accept_old($challenge_ID, $user_ID, $owner_id) {
    if($owner_id == $user_ID) {
        echo "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>
                    <li><button class='btn-link' onclick='edit_content(\"".$challenge_ID."\", 1)'>Edit</button></li>
                    <li><button class='btn-link' onclick='delChallenge(\"".$challenge_ID."\", 3);'>Delete</button></li>
                </ul>
            </div>";                    
    }
}
function dropDown_delete_after_accept_pr_old($challenge_ID, $user_ID, $owner_id) {
    if($owner_id == $user_ID) {
        echo "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>
                    <li><button class='btn-link' onclick='edit_content(\"".$challenge_ID."\", 2)'>Edit</button></li>
                    <li><button class='btn-link' onclick='delChallenge(\"".$challenge_ID."\", 3);'>Delete</button></li>
                </ul>
            </div>";                    
    }
}

function dropDown_delete_after_accept_pr($challenge_ID, $user_ID, $owner_id) {
    if($owner_id == $user_ID) {
        echo "<div class='dropdown pull-right'>
                <a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'> <span class='caret'></span></a>
                <ul class='dropdown-menu'>
                    <li><a class='btn-link' href='#' onclick='edit_content(\"".$challenge_ID."\", 2)'>Edit</a></li>
                    <li><a class='btn-link' href='#' onclick='delChallenge(\"".$challenge_ID."\", 3);'>Delete</a></li>
                </ul>
            </div>";                    
    }
}

function eta($eta){
	$day = floor($eta/(24*60)) ;
	$daysec = $eta%(24*60) ;
	$hour = floor($daysec/(60)) ;
	$minute = $daysec%(60) ;
if($eta > 1439) {
		$time = $day." days" ;
		return $time ;
	}
	else {
		if(($eta < 1439) AND ($eta > 59)) {
			$time = $hour." hours" ;
			return $time ;	
		}
		else { 
			$time = $minute." mins" ;
			return $time ;
		 }
}
}
function remaining_time($creationtime, $eta) {
		$initialtime = strtotime($creationtime) ;
		$totaltime = $initialtime+($eta*60) ;
		$completiontime = time() ;
 if ($completiontime > $totaltime) { 
	  $remaining_time = "Closed" ;
	  return $remaining_time ; 
	  }
	else {	
			$remainingtime = ($totaltime-$completiontime) ;
			$day = floor($remainingtime/(24*60*60)) ;
			$daysec = $remainingtime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
		if ($remainingtime > ((24*60*60)-1)) {
			if($hour != '0') {
				$remaining_time = $day." Days and ".$hour." Hours" ;
				return $remaining_time ;
			} 
			else {
				$remaining_time = $day." Days" ;
				return $remaining_time ;
				}
			} 
		else {
			if (($remainingtime < ((24*60*60)-1)) AND ($remainingtime > ((60*60)-1))) {
				$remaining_time = $hour." Hours and ".$minute." Mins" ;
				return $remaining_time ;
				} 
				else {
					$remaining_time = $minute." Mins" ;
					return $remaining_time ;
					}
		}
	}
}
function events($db_handle,$user_ID,$type,$id){
	 mysqli_query($db_handle,"insert into events (event_creater, event_type, p_c_id) VALUES ('$user_ID', '$type', '$id') ;") ;
	}
function involve_in($db_handle,$user_ID,$type,$id){
	 mysqli_query($db_handle,"insert into involve_in (user_id, p_c_id, p_c_type) VALUES ('$user_ID', '$id', '$type') ;") ;
	}

function recommended_project ($db_handle) {
    $user_id = $_SESSION['user_id'];
    $project_public_title_display2 = mysqli_query($db_handle, "SELECT DISTINCT project_id, project_title, project_ETA, creation_time
                                                            FROM projects WHERE user_id != '$user_id' and project_type= '1' and project_id NOT
                                                            IN (SELECT DISTINCT project_id FROM teams WHERE user_id = '$user_id')
                                                            ORDER BY rand() LIMIT 10;");
    if (mysqli_num_rows($project_public_title_display2) != 0) { 
        echo "
                <div class='panel panel-default'>
                    <div class='panel-heading' style ='padding-top: 0px; padding-bottom: 0px;'>
                        <font size='2'><b> Recommended</b></font>
                    </div>
                    <div class='bs-component' style='max-height:130px;overflow-y:scroll;'>
                        <table>";
    while ($project_public_title_displayRow2 = mysqli_fetch_array($project_public_title_display2)) {
            $public_pr_titlep2 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_public_title_displayRow2['project_title']))) ;
            $idproject2 = $project_public_title_displayRow2['project_id'] ;
        if (strlen($public_pr_titlep2) > 30) {
            $prtitlep2 = substr(ucfirst($public_pr_titlep2),0,30)." ...";
        } 
        else {
            $prtitlep2 = ucfirst($public_pr_titlep2) ;
        }                                  
        $p_etap2 = $project_public_title_displayRow2['project_ETA'] ;
        $p_timep2 = $project_public_title_displayRow2['creation_time'] ;
        $timefuncp2 = date("j F, g:i a",strtotime($p_timep2));
        $titlep2 =  strtoupper($public_pr_titlep2)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefuncp2 ;
        // $remaining_time_ownp = remaining_time($p_timep, $p_etap);

    echo "<tr><td id='step14' >
                <a href = 'project.php?project_id=".$idproject2."'>
                <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                data-placement='bottom' data-original-title='".$titlep2."' style='color:#000;font-size:11px;text-align: left;'>
                ".$prtitlep2."
                
            </button></a></td><td id='step7' >";
                //$remaining_time_ownp.
        if (isset($_SESSION['user_id'])) {
            echo "<button type='submit' class='btn-link' onclick='joinproject(".$idproject2.")' data-toggle='tooltip' 
                    data-placement='bottom' data-original-title='Join This Project' style='height: 20px;font-size:11px;text-align: left;'
                    >Join</button>";
        }
        else {
            echo "<a class='pull-right' data-toggle='modal' data-target='#SignIn' style='cursor:pointer; pull-right'>Join</a>";
        }
        echo "</td></tr>" ;
        }
        echo "</table>
        </div>
        </div>";
    }
}
function showLinks($stmt){
	$stmtArray = explode(" ", $stmt);
	$returnStmt = "";
	foreach($stmtArray as $element){
		if(substr($element, 0, 4) == "http"){
			$element = "<a href='".html_entity_decode($element)."' target='_blank'> ".$element." </a>";
		}
		$returnStmt .= $element . " ";
	}
	return $returnStmt;
}
function removescript($stmt){
	$stmtArray = explode("<script>", $stmt);
	$returnStmt = "";
	foreach($stmtArray as $element){
		
		if(substr($element, 0, 4) == "<scr"){
			$element = "<code>";
		}
		else if (substr($element, 0, 4) == "</sc") {
			$element = "</code>";
		}
		
		$returnStmt .= $element . " ";
	}
	return $returnStmt;
}
function editchallenge($stmt, $ch_id) {
	$data = "" ;
	$user_id = $_SESSION['user_id'] ;
	if(isset($_SESSION['user_id'])){
		if(substr($stmt, 0, 1) != '<') {
           $data .= "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$ch_id."' >".str_replace("<br/>", "\n",$stmt)."</textarea>
					 <input type='submit' class='btn btn-primary editbox' value='Add photo' onclick='upload_pic_file(".$ch_id.")' id='pic_file_".$ch_id."'/><br/>
					 <input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveedited(".$ch_id.")' id='doneedit_".$ch_id."'/>";
		}
		else {
			if (substr($stmt, 0, 4) == ' <br') {
			$data = $data."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$ch_id."' >".str_replace("<br/>", "\n",$stmt)."</textarea>
						<input type='submit' class='btn btn-primary editbox' value='Add photo' onclick='upload_pic_file(".$ch_id.")' id='pic_file_".$ch_id."'/><br/>
						<input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveedited(".$ch_id.")' id='doneedit_".$ch_id."'/>";
				}
			if (substr($stmt, 0, 3) == '<br') {
			$data = $data."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$ch_id."' >".str_replace("<br/>", "\n",$stmt)."</textarea>
						<input type='submit' class='btn btn-primary editbox' value='Add photo' onclick='upload_pic_file(".$ch_id.")' id='pic_file_".$ch_id."'/><br/>
						<input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveedited(".$ch_id.")' id='doneedit_".$ch_id."'/>";
				}
			if (substr($stmt, 0, 4) == '<s>') {
			$data = $data."<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$ch_id."' >".str_replace("<br/>", "\n",$stmt)."</textarea>
						<input type='submit' class='btn btn-primary editbox' value='Add photo' onclick='upload_pic_file(".$ch_id.")' id='pic_file_".$ch_id."'/><br/>
						<input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveedited(".$ch_id.")' id='doneedit_".$ch_id."'/>";
				}
			$chaaa = str_replace("<br/>", "\n",substr(strstr($stmt, '<br/>'), 5)) ;
			$cha = str_replace("<br/>", "\n",strstr($stmt, '<br/>' , true)) ;
			if(substr($stmt, 0, 4) == '<img') {
			$data = $data."<div class='editbox' style='width : 90%;' id='challenge_pic_".$ch_id."' >".$cha."</div>
					<input type='submit' class='btn btn-primary editbox' value='Update' onclick='upload_pic_file(".$ch_id.")' id='pic_file_".$ch_id."'/><br/>" ;
					}
			if(substr($stmt, 0, 2) == '<a') {
			$data = $data."<div class='editbox' style='width : 90%;' id='challenge_file_".$ch_id."' >".$cha."</div>
					<input type='submit' class='btn btn-primary editbox' value='Update' onclick='upload_pic_file(".$ch_id.")' id='pic_file_".$ch_id."'/><br/>" ;
					}
			if(substr($stmt, 0, 3) == '<if') {
			$data = $data."<div class='editbox' style='width : 90%;' id='challenge_video_".$ch_id."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$ch_id."' placeholder='Add You-tube URL'/><br/>" ;
					}
			$data = $data."<input id='_fileChallenge_".$ch_id."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn btn-primary editbox' value='Upload New Photo/File' onclick='save_pic_file(".$ch_id.")' id='pic_file_save_".$ch_id."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$ch_id."' >".$chaaa."</textarea>
						<input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveeditedchallenge(".$ch_id.")' id='doneediting_".$ch_id."'/>";		
			}
		$data = $data."<input id='_fileChallenge_".$ch_id."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn btn-primary editbox' value='Upload New Photo/File' onclick='save_pic_file(".$ch_id.")' id='pic_file_save_".$ch_id."'/>" ;
		}
	return $data ;
}
function editproject($stmt, $pro_id) {
	$data = "" ;
	$user_id = $_SESSION['user_id'] ;
	if(isset($_SESSION['user_id'])){
		if(substr($stmt, 0, 1) != '<') {
			$data .= "<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_".$pro_id."' >".str_replace("<br/>", "\n",$stmt)."</textarea>
					 <input type='submit' class='btn btn-primary editbox' value='Add photo' onclick='upload_pic_file_project(".$pro_id.")' id='project_pic_file_".$pro_id."'/><br/>
					 <input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveeditedproject(".$pro_id.")' id='project_doneedit_".$pro_id."'/>";
			}
		else {
			if (substr($stmt, 0, 4) == ' <br') {
			$data = $data."<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_".$pro_id."' >".str_replace("<br/>", "\n",$stmt)."</textarea>
					       <input type='submit' class='btn btn-primary editbox' value='Add photo' onclick='upload_pic_file_project(".$pro_id.")' id='project_pic_file_".$pro_id."'/><br/>
						   <input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveeditedproject(".$pro_id.")' id='project_doneedit_".$pro_id."'/>";
				}
			if (substr($stmt, 0, 3) == '<br') {
			$data = $data."<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_".$pro_id."' >".str_replace("<br/>", "\n",$stmt)."</textarea>
						   <input type='submit' class='btn btn-primary editbox' value='Add photo' onclick='upload_pic_file_project(".$pro_id.")' id='project_pic_file_".$pro_id."'/><br/>
						   <input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveeditedproject(".$pro_id.")' id='project_doneedit_".$pro_id."'/>";
				}
			if (substr($stmt, 0, 3) == '<s>') {
			$data = $data."<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_".$pro_id."' >".str_replace("<br/>", "\n",$stmt)."</textarea>
						<input type='submit' class='btn btn-primary editbox' value='Add photo' onclick='upload_pic_file_project(".$pro_id.")' id='project_pic_file_".$pro_id."'/><br/>
						<input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveeditedproject(".$pro_id.")' id='project_doneedit_".$pro_id."'/>";
				}
			$stmt1 = str_replace("<br/>", "\n",substr(strstr($stmt, '<br/>'), 5)) ;
			$projectst1 = str_replace("<br/>", "\n",strstr($stmt, '<br/>' , true)) ;
			if(substr($stmt, 0, 4) == '<img') {
			$data = $data."<div class='editbox' style='width : 90%;' id='project_pic_".$pro_id."' >".$projectst1."</div>
					<input type='submit' class='btn btn-primary editbox' value='Update' onclick='upload_pic_file_project(".$pro_id.")' id='project_pic_file_".$pro_id."'/><br/>" ;
					}
			if(substr($stmt, 0, 2) == '<a') {
			$data = $data."<div class='editbox' style='width : 90%;' id='project_file_".$pro_id."' >".$projectst1."</div>
					<input type='submit' class='btn btn-primary editbox' value='Update' onclick='upload_pic_file_project(".$pro_id.")' id='project_pic_file_".$pro_id."'/><br/>" ;
					}
			if(substr($stmt, 0, 3) == '<if') {
			$data = $data."<div class='editbox' style='width : 90%;' id='project_video_".$pro_id."' >".$projectst1."</div>
					<input type='text' class='editbox' id='project_url_video_".$pro_id."' placeholder='Add You-tube URL'/><br/>" ;
					}
			$data = $data."<input id='project_fileChallenge_".$pro_id."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
						<input type='submit' class='btn btn-primary editbox' value='Upload New Photo/File' onclick='save_pic_file_project(".$pro_id.")' id='pic_file_project_".$pro_id."'/>
						<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_p_".$pro_id."' >".$stmt1."</textarea>
						<input type='submit' class='btn btn-primary editbox' value='Save' onclick='saveeditedpro(".$pro_id.")' id='doneediting_project_".$pro_id."'/>";		
			}
		$data = $data."<input id='project_fileChallenge_".$pro_id."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn btn-primary editbox' value='Upload New Photo/File' onclick='save_pic_file_project(".$pro_id.")' id='pic_file_project_".$pro_id."'/>" ;
		}
	return $data ;
}
?>
