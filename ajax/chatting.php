<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['name']) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $fname = $_POST['name'] ;
    $fid = $_POST['fid'] ;
    $data = "" ;
    $data2 = "" ;
	$displayb = mysqli_query($db_handle, "SELECT a.id, a.sender_id, a.receiver_id, a.message, a.timestamp, b.username FROM messages as a join user_info as b WHERE 
										((a.sender_id = '$user_id' and a.receiver_id = '$fid') OR (a.sender_id = '$fid' and a.receiver_id = '$user_id')) and 
										a.sender_id = b.user_id ORDER BY a.timestamp ASC;");
	while ($displayrowc = mysqli_fetch_array($displayb)) {
		$ida = $displayrowc['id'];
		$idb = $displayrowc['username'];
		$projectres = $displayrowc['message'];
		$data.= "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
						<img src='uploads/profilePictures/$idb.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<small>" . $projectres . "</small>
					</div>
				</div> 
			</div>";
	}
	$data = $data ."</div><div class='newmassages'></div>" ;
	$data2 .= "<div class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='uploads/profilePictures/".$username.".jpg'  onError=this.src='img/default.gif'>&nbsp
						</div>
						<input type='text' STYLE='border: 1px solid #bdc7d8; width: 65%; height: 30px;' id ='chattalk' placeholder='' />
						<button onclick='newchat(\"".$fid."\",\"".$fname."\")' class='btn-primary btn-sm glyphicon glyphicon-play' id ='resp_talk' ></button>
					</div>" ;
	echo $data."+".$data2."+".$ida ;
mysqli_close($db_handle);
}
?>
