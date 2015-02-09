<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/collapMail.php';
include_once '../functions/delete_comment.php';
include_once '../functions/image_resize.php';
if($_POST['taskdetails']){
	$user_id = $_SESSION['user_id'];
	$firstname = $_SESSION['first_name'] ;
	$username = $_SESSION['username'] ;
	$detailstext = $_POST['taskdetails'] ;
	$pro_id = $_POST['project_id'];
	$team = $_POST['team'] ;
	$email = $_POST['email'] ;
	$users = $_POST['users'] ;
	$title = $_POST['title'] ;
	$image = $_POST['img'] ;
	$time = date("Y-m-d H:i:s") ;
	$info =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$titlepro = $inforow['project_title'] ;
	$type = $inforow['project_type'] ;
	if (strlen($image) < 30 ) {
		$details = $detailstext ;
	}
	else {
		$details = $image."<br/> ".$detailstext ;
	}
	$challange_eta = 999999 ;//$_POST['challange_eta'] ;
	if ($users != 0) {
		$owner = $users ;
		$info = mysqli_query($db_handle,"select * from user_info where user_id = '$users';") ;
		$inforow = mysqli_fetch_array($info);
		$mailto = $inforow['email'];
		$mail = $inforow['username'];
		$userFirstName = $inforow['first_name'] ;
		$userLastName = $inforow['last_name'] ;
		$body2 = "<h2>".ucfirst($titlepro)."</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>A new task has been asgined to you in a project you are involved in.</p>
<p>".ucfirst($username)." has assigned a new task ".$title." in project ".ucfirst($titlepro)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
		collapMail($mailto, "Task assigned IN Project", $body2);
		if (strlen($details) < 1000) {
			mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                    VALUES ('$user_id', '$pro_id', '$title', '$details', '1', '$challange_eta', '5', '2', '$time') ; ") ;
			$idp = mysqli_insert_id($db_handle);
			mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$idp', '$challange_eta', '1');") ;  
		}
		else {
			mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$details');");
            $idb = mysqli_insert_id($db_handle);
			mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
									VALUES ('$user_id', '$pro_id', '$title', '$idb', '1', '$challange_eta', '5', '2', '$time');");
			$idp = mysqli_insert_id($db_handle);
			mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$idp', '$challange_eta', '1');") ;
		}
		events($db_handle,$user_id,"4",$owner) ;
		mysqli_query($db_handle,"insert into involve_in (user_id, p_c_id, p_c_type) VALUES ('$user_id', '$idp', '1'),('$user_id', '$idp', '3'),('$user_id', '$idp', '5'),('$user_id', '$idp', '9') ;") ;
	}
	else if ($email != "") {
		$owners = mysqli_query($db_handle,"select * from user_info where email = '$email' ;") ;
		$ownersrow = mysqli_fetch_array($owners) ; 
		$owner = $ownersrow['user_id'] ;	
		$mailto = $ownersrow['email'] ;	
		$mail = $ownersrow['username'] ;
		$userFirstName = $ownersrow['first_name'] ;
		$userLastName = $ownersrow['last_name'] ;
		$body2 = "<h2>".ucfirst($titlepro)."</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>A new task has been asgined to you in a project you are involved in.</p>
<p>".ucfirst($username)." has assigned a new Task ".$title." in project ".ucfirst($titlepro)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
		collapMail($mailto, "Task assigned IN Project", $body2);
		$insert =  mysqli_query($db_handle,"select user_id from teams where project_id = '$pro_id' and user_id = '$owner' ;") ;
		if (mysqli_num_rows($insert) == 0){
			mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$owner', '$pro_id', 'defaultteam') ;" ) ; 
		}	
		if (strlen($details) < 1000) {
			mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                    VALUES ('$user_id', '$pro_id', '$title', '$details', '1', '$challange_eta', '5', '2', '$time') ; ") ;
			$idp = mysqli_insert_id($db_handle);
			mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$idp', '$challange_eta', '1');") ;
		}
		else {
			mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$details');");
            $idb = mysqli_insert_id($db_handle);
			mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
									VALUES ('$user_id', '$pro_id', '$title', '$idb', '1', '$challange_eta', '5', '2', '$time');");
			$idp = mysqli_insert_id($db_handle);
			mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$idp', '$challange_eta', '1');") ;
		}
		events($db_handle,$user_id,"4",$owner) ;
		mysqli_query($db_handle,"insert into involve_in (user_id, p_c_id, p_c_type) VALUES ('$user_id', '$idp', '1'),('$user_id', '$idp', '3'),('$user_id', '$idp', '5'),('$user_id', '$idp', '9') ;") ;
	}
	else {		
		if (strlen($details) < 1000) {
			mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                    VALUES ('$user_id', '$pro_id', '$title', '$details', '1', '$challange_eta', '5', '2', '$time') ; ") ;
			$idp = mysqli_insert_id($db_handle);
			mysqli_query($db_handle," insert into team_tasks (project_id, team_name, challenge_id) VALUES ('$pro_id', '$team', '$idp');") ;                  
		}
		else {
			mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$details');");
            $idb = mysqli_insert_id($db_handle);
			mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
									VALUES ('$user_id', '$pro_id', '$title', '$idb', '1', '$challange_eta', '5', '2', '$time');");
			$idp = mysqli_insert_id($db_handle);
			mysqli_query($db_handle," insert into team_tasks (project_id, team_name, challenge_id) VALUES ('$pro_id', '$team', '$idp');") ;
		}
		$owners = mysqli_query($db_handle,"select DISTINCT user_id from teams where project_id = '$pro_id' and team_name = '$team' and user_id != '$user_id' and member_status = '1' ;") ;
		while ($ownersrow = mysqli_fetch_array($owners)) { 
			$owner = $ownersrow['user_id'] ;
			$info = mysqli_query($db_handle,"select * from user_info where user_id = '$owner';") ;
			$inforow = mysqli_fetch_array($info);
			$mailto = $inforow['email'];
			$mail = $inforow['username'];
			$userFirstName = $inforow['first_name'] ;
			$userLastName = $inforow['last_name'] ;
			$body2 = "<h2>".ucfirst($titlepro)."</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>A new task has been asgined to you in a project you are involved in.</p>
<p>".ucfirst($username)." has assigned a new task ".$title." in project ".ucfirst($titlepro)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
			collapMail($mailto, "Task assigned IN Project", $body2);
			events($db_handle,$user_id,"4",$owner) ;
			mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$idp', '$challange_eta', '1');") ;
		}
		mysqli_query($db_handle,"insert into involve_in (user_id, p_c_id, p_c_type) VALUES ('$user_id', '$idp', '1'),('$user_id', '$idp', '3'),('$user_id', '$idp', '5'),('$user_id', '$idp', '9') ;") ;	
	}
	$totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idp' and like_status = '1' ;");
	if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
	else { $likes = '' ; }
	$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idp' and like_status = '2' ;");
	if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
	else { $dislikes = '' ; }
	$data = "" ;
	$timefunct = date("j F, g:i a") ;
	$chelange = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $details)))) ;
	$titletask = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $title)))) ;
	$newtitle = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $title))) ;
	$nchallange = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $details))) ;
	if($team != "") {
		$usersProjects = mysqli_query($db_handle,"select DISTINCT user_id from teams where project_id = '$pro_id' and team_name = '$team' and user_id != '$user_id' and member_status = '1' ;") ;
		while ($usersProjectsRow = mysqli_fetch_array($usersProjects)) { 
			$usersID = $usersProjectsRow['user_id'] ;
			$userInfo = mysqli_query($db_handle,"select * from user_info where user_id = '$usersID';") ;
			$userInfoRow = mysqli_fetch_array($userInfo);
			$usersName = $userInfoRow['username'] ;
			$usersFirstName = $userInfoRow['first_name'] ;
			$data .= "<div class='list-group pushpin'>
                <div class='list-group-item'>
					<div class='dropdown pull-right'>
						<a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
						<ul class='dropdown-menu'>
							<li><a class='btn-link' href='#' onclick='edit_content(\"".$idp."\", 1)'>Edit</a></li>
							<li><a class='btn-link' href='#' onclick='delChallenge(\"".$idp."\", 3);'>Delete</a></li>
						</ul>
					</div>
					<span style='font-family: Tenali Ramakrishna, sans-serif;' id='challenge_ti_".$idp."' class='text'><b>
					<a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$idp."' target='_blank'>".ucfirst($titletask)."</a>
					</b></span><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$idp."' value='".$newtitle."'/><br/>
					<span class='icon-pushpin'></span><span style= 'color: #808080;'>
                &nbspBy: <a href ='profile.php?username=" . $username . "' style= 'color: #808080;'>".ucfirst($firstname)."</a>&nbsp;
                     | Assigned To:&nbsp <a href ='profile.php?username=".$usersName."' style= 'color: #808080;'>"
                .ucfirst($usersFirstName)."</a> | ".$timefunct."</span>
                    <hr/><span id='challenge_".$idp."' class='text' style='line-height: 25px; font-size: 14px; color: #444;'>".$chelange."</span><br/>" ;
            $data = $data .editchallenge($nchallange, $idp) ;
            $data = $data ."<hr/><div class='row-fluid'><div class='col-md-1'>".share_challenge($idp)."</div><div class='col-md-5'>| &nbsp;&nbsp;&nbsp;
						<span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$idp ."\", 1)'> <b>Push</b>
                        <input type='submit' class='btn-link' id='likes_".$idp ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                    <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$idp ."\", 2)'> <b>Pull</b>
                        <input type='submit' class='btn-link' id='dislikes_".$idp ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>
                        <div class='comments_".$idp."'></div>
					<div id='step15' class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
						</div>
						<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$idp."'
						 placeholder='Want to know your comment....'/>
						<button type='submit' class='btn btn-primary' onclick='comment(\"".$idp."\", 1)' style='margin-bottom: 10px;'>
						<span class='icon-chevron-right'></span></button>
					</div></div> </div>" ;
		}
	}
	else {
		$infouser = mysqli_query($db_handle,"select * from user_info where user_id = '$users' or email = '$email' ;") ;
		$userInfoRow = mysqli_fetch_array($userInfo);
		$usersName = $userInfoRow['username'] ;
		$usersFirstName = $userInfoRow['first_name'] ;
		$data .= "<div class='list-group pushpin'>
                <div class='list-group-item'>
					<div class='dropdown pull-right'>
						<a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
						<ul class='dropdown-menu'>
							<li><a class='btn-link' href='#' onclick='edit_content(\"".$idp."\", 1)'>Edit</a></li>
							<li><a class='btn-link' href='#' onclick='delChallenge(\"".$idp."\", 3);'>Delete</a></li>
						</ul>
					</div>
					<span style='font-family: Tenali Ramakrishna, sans-serif;'	id='challenge_ti_".$idp."' class='text'><b>
					<a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$idp."' target='_blank'>".ucfirst($titletask)."</a>
					</b></span><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$idp."' value='".$newtitle."'/><br/>
					<span class='icon-pushpin'></span><span style= 'color: #808080;'>
                &nbspBy: <a href ='profile.php?username=" . $username . "' style= 'color: #808080;'>".ucfirst($firstname)."</a>&nbsp;
                     | Assigned To:&nbsp <a href ='profile.php?username=".$usersName."' style= 'color: #808080;'>"
                .ucfirst($usersFirstName)."</a> | ".$timefunct."</span>
                    <hr/><span id='challenge_".$idp."' class='text' style='line-height: 25px; font-size: 14px; color: #444;'>".$chelange."</span><br/>" ;
            $data = $data .editchallenge($nchallange, $idp) ;
            $data = $data ."<hr/><div class='row-fluid'><div class='col-md-1'>".share_challenge($idp)."</div><div class='col-md-5'>| &nbsp;&nbsp;&nbsp;
						<span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$idp ."\", 1)'> <b>Push</b>
                        <input type='submit' class='btn-link' id='likes_".$idp ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                    <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$idp ."\", 2)'> <b>Pull</b>
                        <input type='submit' class='btn-link' id='dislikes_".$idp ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>
                        <div class='comments_".$idp."'></div>
					<div id='step15' class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
						</div>
						<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$idp."'
						 placeholder='Want to know your comment....'/>
						<button type='submit' class='btn btn-primary' onclick='comment(\"".$idp."\", 1)' style='margin-bottom: 10px;'>
						<span class='icon-chevron-right'></span></button>
					</div></div> </div>" ;
		}
	if(mysqli_error($db_handle)) { echo "Failed to Assign Task !"; }
	else { echo "Posted succesfully!"."+"."7"."+".$data ; }
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
