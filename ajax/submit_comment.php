<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';
include_once '../functions/image_resize.php';
if($_POST['id']){
	$user_id = $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$pro_id = $_POST['project_id'] ;
	$info = mysqli_query($db_handle,"select * from user_info where user_id = '$user_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$id = $_POST['id'];
	$stmt=$_POST['projectsmt'];
	$case = $_POST['case'];
	$time = date("Y-m-d H:i:s") ;
	$member_project = mysqli_query($db_handle, "select * from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
	switch ($case) {
		case 1:
			events($db_handle,$user_id,"5",$id);
			involve_in($db_handle,$user_id,"5",$id);
			mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$id' ; ") ;
			if (strlen($stmt)<1000) {	
				mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) VALUES ('$user_id', '$id', '$stmt');") ;
				$comment_id = mysqli_insert_id($db_handle);
			}
			else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$stmt');");
				$ida = mysqli_insert_id($db_handle);
				mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, blob_id) VALUES ('$user_id', '$id', ' ', '$ida');") ;
				$comment_id = mysqli_insert_id($db_handle);
			}
			$test = "<div class='commentscontainer' id='comment_".$comment_id."'>
						<div class='comments clearfix'>
							<div class='pull-left lh-fix'>
							<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
							</div>
							<div class='dropdown pull-right'>
								<a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
								<ul class='dropdown-menu'>
									<li><a class='btn-link' onclick='delcomment(\"".$comment_id."\", 1);'>Delete</a></li>
								</ul>
							</div>
							<div class='comment-text'>
								<span class='pull-left color strong'>&nbsp;<a href ='profile.php?username=" . $username . "'>". ucfirst($inforow['first_name']) ." ". ucfirst($inforow['last_name']) . "</a></span>
								&nbsp;&nbsp;" . showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $stmt)))))."
							</div>
						</div>
					</div>";
			if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
			else { echo $test."|+"."Posted succesfully!"; }
			
			break ;
			
		case 2:	
			$member_projects = mysqli_query($db_handle, "select * from teams where project_id = '$id' and user_id = '$user_id' and member_status = '1';");
			if(mysqli_num_rows($member_projects) != 0) {
				events($db_handle,$user_id,"6",$pro_id);
				involve_in($db_handle,$user_id,"6",$pro_id);
				if (strlen($resp_stmt)<1000) {
					mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt) VALUES ('$user_id', '$id', '$stmt');") ;
					$comment_id = mysqli_insert_id($db_handle);
				}
				else {
					mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$stmt');");
					$idb = mysqli_insert_id($db_handle);
					mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt, blob_id) VALUES ('$user_id', '$id', ' ', '$idb');") ;
					$comment_id = mysqli_insert_id($db_handle);
				}
				$test = "<div class='commentscontainer' id='comment_".$comment_id."'>
							<div class='comments clearfix'>
								<div class='pull-left lh-fix'>
								<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
								</div>
								<div class='dropdown pull-right'>
									<a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
									<ul class='dropdown-menu'>
										<li><a class='btn-link' onclick='delcomment(\"".$comment_id."\", 2);'>Delete</a></li>
									</ul>
								</div>
								<div class='comment-text'>
									<span class='pull-left color strong'>&nbsp;<a href ='profile.php?username=" . $username . "'>". ucfirst($inforow['first_name']) ." ". ucfirst($inforow['last_name']) . "</a></span>
									&nbsp;&nbsp;" . showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $stmt)))))."
								</div>
							</div>
						</div>";
				if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
				else { echo $test."|+"."Posted succesfully!"; }
			}
			else { echo "Please Join Project First!"; }
			
			break ;
			
		case 3:
			if(mysqli_num_rows($member_project) != 0) {
				events($db_handle,$user_id,"5",$id);
				involve_in($db_handle,$user_id,"5",$id);
				$infoet =  mysqli_query($db_handle, "select project_title, project_type from projects where project_id = '$pro_id' ;") ;
				$inforowt = mysqli_fetch_array($infoet) ;
				$title = $inforowt['project_title'] ;
				$type = $inforowt['project_type'] ;
				$chtype = mysqli_query($db_handle, "select * from challenges where challenge_id = '$id' and project_id = '$pro_id' ;") ;
				$chtyperow = mysqli_fetch_array($chtype) ;
				$chtyperowval = $chtyperow['challenge_type'] ;
				$challangeTtitle = $chtyperow['challenge_title'] ;
				if($chtyperowval == 1 || $chtyperowval == 2 || $chtyperowval == 3) { $challangeType = "Challenge" ; }
				else if($chtyperowval == 5) { $challangeType = "Task" ; }
				else if($chtyperowval == 6) { $challangeType = "Notes" ; }
				else if($chtyperowval == 9) { $challangeType = "Issues" ; }
				else { $challangeType = "Videos" ; }
				if($type == 2) {
					$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where 
														a.project_id = '$pro_id' and a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
					while ($memrow = mysqli_fetch_array($members)){
						$emails = $memrow['email'] ;
						$mail = $memrow['username'] ;
						$userFirstName = $memrow['first_name'] ;
						$userLastName = $memrow['last_name'] ;
						$body2 = "<h2>".ucfirst($challangeTtitle)."</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>There is a new comment on one of your contributions on collap.</p>
<p>".ucfirst($username)." has written a new comment on your ".ucfirst($challangeType)." ".ucfirst($challangeTtitle)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/challengesOpen.php?challenge_id=".$id."' class='btn-primary'>Click Here to View your contribution</a></p>" ;
					collapMail($emails, "Comment on challenge", $body2);
					}
				}
				mysqli_query($db_handle,"UPDATE challenges SET last_update='$time' WHERE challenge_id = '$id' ; ") ;
				if (strlen($stmt)<1000) {	
					mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) VALUES ('$user_id', '$id', '$stmt');") ;
					$comment_id = mysqli_insert_id($db_handle);
				}
				else {
					mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$stmt');");
					$ida = mysqli_insert_id($db_handle);
					mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, blob_id) VALUES ('$user_id', '$id', ' ', '$ida');") ;
					$comment_id = mysqli_insert_id($db_handle);
				}
				$test = "<div class='commentscontainer' id='comment_".$comment_id."'>
							<div class='comments clearfix'>
								<div class='pull-left lh-fix'>
								<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
								</div>
								<div class='dropdown pull-right'>
									<a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
									<ul class='dropdown-menu'>
										<li><a class='btn-link' onclick='delcomment(\"".$comment_id."\", 1);'>Delete</a></li>
									</ul>
								</div>
								<div class='comment-text'>
									<span class='pull-left color strong'>&nbsp;<a href ='profile.php?username=" . $username . "'>". ucfirst($inforow['first_name']) ." ". ucfirst($inforow['last_name']) . "</a></span>
									&nbsp;&nbsp;" . showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $stmt)))))."
								</div>
							</div>
						</div>";
				if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
				else { echo $test."|+"."Posted succesfully!"; }
			}
			else { echo "Please Join Project First!"; }
			
			break ;
	}
}
else { echo "Invalid parameters!"; }
mysqli_close($db_handle);
?>
