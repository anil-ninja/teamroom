<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['id']){
	$user_id = $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$info = mysqli_query($db_handle,"select * from user_info where user_id = '$user_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$id = $_POST['id'];
	$stmt=$_POST['projectsmt'];
	$case = $_POST['case'];
	$test = "" ;
	if ($case == 1) {
		events($db_handle,$user_id,"3",$id);
		involve_in($db_handle,$user_id,"3",$id);
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
		}
	else { 	$member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$id' and user_id = '$user_id';");
			if(mysqli_num_rows($member_project) != 0) {
			events($db_handle,$user_id,"14",$id);
			involve_in($db_handle,$user_id,"14",$id);
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
				}
				else {echo "Please Join Project First!"; }
			}
	$test .= "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username . "'>". ucfirst($inforow['first_name']) ." ". ucfirst($inforow['last_name']) . "</a></span>
						&nbsp&nbsp&nbsp" . str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $stmt)));
		$test = $test .dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
        $test = $test . "</div>
					</div>
				</div>";
	if(mysqli_error($db_handle)) { echo "Failed to Post!"; }
	else { echo $test."+"."Posted succesfully!"; }
	}
else echo "Invalid parameters!";
mysqli_close($db_handle);
?>
