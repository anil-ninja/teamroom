<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';

if($_POST['challange']){
	$user_id = $_SESSION['user_id'];
	$pro_id = $_SESSION['project_id'] ;	
	$challangetext = $_POST['challange'];
	$username = $_SESSION['username'];
	$opentime = 1;//$_POST['opentime'] ;
	$challenge_title = $_POST['challenge_title'] ;
	$challange_eta = 999999 ;//$_POST['challange_eta'] ; 
	$image = $_POST['img'] ;
	$time = date("Y-m-d H:i:s") ;
	if (strlen($image) < 30 ) {
			$challange = $challangetext ;
		}
		else {
			$challange = $image."<br/> ".$challangetext ;
			}
	$type = $_POST['type'] ;
	$remaintime = 99 ;
	$firstname = $_SESSION['first_name'] ;
	$username = $_SESSION['username'] ;
	$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$title = $inforow['project_title'] ;
	$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and
										a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
	while ($memrow = mysqli_fetch_array($members)){
		$emails = $memrow['email'] ;
		$mail = $memrow['username'] ;
		$body2 = "Hi, ".$mail." \n \n ".$username." Create Challenge IN Project (".$title."). View at \n
http://collap.com/project.php?project_id=".$pro_id ;
		collapMail($emails, " Challenge Created", $body2);
		} 
	if (strlen($challange) < 1000) {
		mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, last_update) 
										VALUES ('$user_id', '$pro_id', '$challenge_title', '$challange', '$opentime', '$challange_eta', '$type', '$time') ; ") ;
		$idp = mysqli_insert_id($db_handle);
		involve_in($db_handle,$user_id,"10",$idp); 
		events($db_handle,$user_id,"10",$idp);
	}
	 else {
		mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$challange');");
		$id = mysqli_insert_id($db_handle);
		mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, stmt, blob_id, challenge_open_time, challenge_ETA, challenge_type, last_update) 
							VALUES ('$user_id', '$pro_id', '$challenge_title', ' ', '$id', '$opentime', '$challange_eta', '$type', '$time');");
		$idp = mysqli_insert_id($db_handle);
		involve_in($db_handle,$user_id,"10",$idp); 
		events($db_handle,$user_id,"10",$idp);
	}
	$totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idp' and like_status = '1' ;");
	if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
	else { $likes = '' ; }
	$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idp' and like_status = '2' ;");
	if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
	else { $dislikes = '' ; }
	$data = "" ;
	$timefunct = date("j F, g:i a") ;
	$chelange = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $challange)))) ;
	$title = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $challenge_title)))) ;
	$ntitle = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $challenge_title))) ;
	$nchallange = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $challange))) ;
	$data .= "<div class='list-group sign'>
                <div class='list-group-item'>
					<div class='dropdown pull-right'>
						<a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
						<ul class='dropdown-menu'>
							<li><a class='btn-link' href='#' onclick='edit_content(\"".$idp."\", 1)'>Edit</a></li>
							<li><a class='btn-link' href='#' onclick='delChallenge(\"".$idp."\", 3);'>Delete</a></li>
						</ul>
					</div>
					<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='accept_pub(\"".$idp."\", 5)' value='Accept'/>" ;
    $data = $data ."<p style='font-family: Tenali Ramakrishna, sans-serif; font-size: 24px; line-height: 42px;' 
					id='challenge_ti_".$idp."' class='text'><b>
					<a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$idp."' target='_blank'>".ucfirst($title)."</a>
					</b></p><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$idp."' value='".$ntitle."'/>
					<span class='icon-question-sign'></span>
					<span style= 'color: #808080'>
					&nbspBy: <a href ='profile.php?username=" . $username . "'>".ucfirst($firstname)."</a> | ".$timefunct."</span> | 
                    <span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$idp ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$idp ."' value='".$likes."'/></span> &nbsp
                    <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$idp ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$idp ."' value='".$dislikes."'/>&nbsp;</span>
                    </div><div class='list-group-item'>
                    <br/><span id='challenge_".$idp."' class='text' style='line-height: 25px; font-size: 14px; color: #444;'>".$chelange."</span><br/>" ;
       $data = $data .editchallenge($nchallange, $idp) ;
      $data = $data ."<div class='comments_".$idp."'></div>
					<div id='step15' class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
						</div>
						<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$idp."'
						 placeholder='Want to know your comment....'/>
						<button type='submit' class='btn btn-primary' onclick='comment(\"".$idp."\", 1)' style='margin-bottom: 10px;'>
						<span class='icon-chevron-right'></span></button>
					</div></div> </div> " ;
	if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
	else { echo "Posted succesfully!"."+"."5"."+".$data ; }
	mysqli_close($db_handle);
}
	else echo "Invalid parameters!";
?>
