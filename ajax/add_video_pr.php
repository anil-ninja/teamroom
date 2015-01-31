<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
include_once '../functions/image_resize.php';
if($_POST['videos']){
	$user_id = $_SESSION['user_id'];	
	$challangetext = $_POST['videos'];
	$pro_id = $_POST['project_id'] ;	
	$challenge_title = $_POST['title'] ;
	$videodes = $_POST['videodes'] ;
	$challange = $challangetext."<br/> ".$videodes ;
	$firstname = $_SESSION['first_name'] ;
	$username = $_SESSION['username'] ;
	$remaintime = 99 ;
	$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$title = $inforow['project_title'] ;
	$type = $inforow['project_type'] ;
	$time = date("Y-m-d H:i:s") ;
	$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where a.project_id = '$pro_id' and
										a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
	while ($memrow = mysqli_fetch_array($members)){
		$emails = $memrow['email'] ;
		$mail = $memrow['username'] ;
		$userFirstName = $memrow['first_name'] ;
		$userLastName = $memrow['last_name'] ;
		$body2 = "<body bgcolor='#f6f6f6'><table class='body-wrap'><tr><td></td><td class='container' bgcolor='#FFFFFF'>
<div class='content'><table><tr><td><img style='width:108px' src = 'http://collap.com/img/collap.gif'/><i style='font-size:58px;'>collap.com</i></td></tr><tr><td>
<h2>".ucfirst($title)."</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>A new Video has been created in project ".ucfirst($title).".</p>
<p>".ucfirst($username)." has posted a new Video ".$challenge_title." in project ".ucfirst($title)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View your</a></p></td></tr><tr><td>
<p> Lets Collaborate!!! Because Heritage is what we pass on to the Next Generation.</p></td></tr></table>
<p>Thanks,</p><p>Collap Team</p>
<p><a href='http://twitter.com/collapcom'>Follow @collapcom on Twitter</a></p></td></tr></table>
</div>
</td><td></td></tr></table></body></html>" ;
		collapMail($emails, "Video Added IN Project", $body2, file_get_contents('../html_comp/mailheader.php'));
		} 								
	if (strlen($challange) < 1000) {
		mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, last_update) 
									VALUES ('$user_id', '$pro_id', '$challenge_title', '$challange', '1', '999999', '8', '$time') ; ") ;
			$idp = mysqli_insert_id($db_handle);
		involve_in($db_handle,$user_id,"10",$idp);
		events($db_handle,$user_id,"10",$idp); 
	}
	else {
		mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$challange');");
		$id = mysqli_insert_id($db_handle);
		mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type, last_update) 
							VALUES ('$user_id', '$pro_id', '$challenge_title', '$id', '1', '999999', ' ', '8', '$time');");
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
	$timefunct = date("j F, g:i a") ;
	$chelange = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $challange)))) ;
	$title = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $challenge_title)))) ;
	$ntitle = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $challenge_title))) ;
	$nchallange = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $challange))) ;
	$data = "<div class='list-group videofilm'>
                <div class='list-group-item'>
					<div class='dropdown pull-right'>
						<a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
						<ul class='dropdown-menu'>
							<li><a class='btn-link' href='#' onclick='edit_content(\"".$idp."\", 1)'>Edit</a></li>
							<li><a class='btn-link' href='#' onclick='delChallenge(\"".$idp."\", 3);'>Delete</a></li>
						</ul>
					</div>" ;
    $data = $data ."<span style='font-family: Tenali Ramakrishna, sans-serif;' 
					id='challenge_ti_".$idp."' class='text'><b>
					<a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$idp."' target='_blank'>".ucfirst($title)."</a>
					</b></span><br/><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$idp."' value='".$ntitle."'/>
					<span class='icon-film'></span>
					<span style= 'color: #808080;'>
					&nbspBy: <a href ='profile.php?username=" . $username . "' style= 'color: #808080;'>".ucfirst($firstname)."</a> | ".$timefunct." | </span> 
                    <span class='icon-hand-up' style='cursor: pointer;color: #808080;' onclick='like(\"".$idp ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$idp ."' value='".$likes."'/></span> &nbsp
                    <span class='icon-hand-down' style='cursor: pointer;color: #808080;' onclick='dislike(\"".$idp ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$idp ."' value='".$dislikes."'/>&nbsp;</span>
                    <hr/><span id='challenge_".$idp."' class='text' style='line-height: 25px; font-size: 14px; color: #444;'>".$chelange."</span><br/>" ;
       $data = $data .editchallenge($nchallange, $idp) ;
      $data = $data ."<div class='comments_".$idp."'></div>
					<div id='step15' class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
						</div>
						<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$idp."'
						 placeholder='Want to know your comment....'/>
						<button type='submit' class='btn btn-primary' onclick='comment(\"".$idp."\", 1)' style='margin-bottom: 10px;'>
						<span class='icon-chevron-right'></span></button>
					</div></div> </div> " ;
	if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
	else { echo "Video Posted Successfully !!!"."+".$data ; }
	mysqli_close($db_handle);
}
else echo "Invalid parameters!";	
?>
