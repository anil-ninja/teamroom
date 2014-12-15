<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/collapMail.php';
include_once '../functions/delete_comment.php';
if($_POST['taskdetails']){
	$user_id = $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$detailstext = $_POST['taskdetails'] ;
	$id = $_SESSION['project_id'];
	$team = $_POST['team'] ;
	$email = $_POST['email'] ;
	$users = $_POST['users'] ;
	$title = $_POST['title'] ;
	$image = $_POST['img'] ;
	$time = date("Y-m-d H:i:s") ;
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
		$body2 = "http://collap.com/profile.php?username=".$mail ;
        collapMail($mailto, $username." assign Task to you", $body2);		
 if (strlen($details) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                    VALUES ('$user_id', '$id', '$title', '$details', '1', '$challange_eta', '5', '2', '$time') ; ") ;
        $ida = mysqli_insert_id($db_handle);
       mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$ida', '$challange_eta', '1');") ;  
                          
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Posted succesfully!"; }

}
else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$details');");
        
        $idb = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                VALUES ('$user_id', '$id', '$title', '$idb', '1', '$challange_eta', '5', '2', '$time');");
        $idc = mysqli_insert_id($db_handle);
       mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$idc', '$challange_eta', '1');") ;
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Posted succesfully!"; }
}
}
else if ($email != "") {
		$owners = mysqli_query($db_handle,"select * from user_info where email = '$email' ;") ;
       $ownersrow = mysqli_fetch_array($owners) ; 
		   $owner = $ownersrow['user_id'] ;	
		   $mailto = $ownersrow['email'] ;	
		   $mail = $ownersrow['username'] ;
		   $body2 = "http://collap.com/profile.php?username=".$mail ;
		   collapMail($mailto, $username." assign Task to you", $body2);	
		   $insert =  mysqli_query($db_handle,"select user_id from teams where project_id = '$id' and user_id = '$owner' ;") ;
		   if (mysqli_num_rows($insert) == 0){
			  mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$owner', '$id', 'defaultteam') ;" ) ; 
			   }	
 if (strlen($details) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                    VALUES ('$user_id', '$id', '$title', '$details', '1', '$challange_eta', '5', '2', '$time') ; ") ;
        $ida = mysqli_insert_id($db_handle);
       mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$ida', '$challange_eta', '1');") ;                   
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Posted succesfully!"; }

}
else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$details');");
        
        $idb = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                VALUES ('$user_id', '$id', '$title', '$idb', '1', '$challange_eta', '5', '2', '$time');");
        $idc = mysqli_insert_id($db_handle);
       mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$idc', '$challange_eta', '1');") ;
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Posted succesfully!"; }
}
}
else {		
 if (strlen($details) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, project_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                    VALUES ('$user_id', '$id', '$title', '$details', '1', '$challange_eta', '5', '2', '$time') ; ") ;
        $ida = mysqli_insert_id($db_handle);
        mysqli_query($db_handle," insert into team_tasks (project_id, team_name, challenge_id) VALUES ('$id', '$team', '$ida');") ;
        $owners = mysqli_query($db_handle,"select DISTINCT user_id from teams where project_id = '$id' and team_name = '$team' and user_id != '$user_id' ;") ;
       while ($ownersrow = mysqli_fetch_array($owners)) { 
		   $owner = $ownersrow['user_id'] ;
		   $info = mysqli_query($db_handle,"select * from user_info where user_id = '$owner';") ;
		$inforow = mysqli_fetch_array($info);
		$mailto = $inforow['email'];
		$mail = $inforow['username'];
		$body2 = "http://collap.com/profile.php?username=".$mail ;
        collapMail($mailto, $username." assign Task to you", $body2);
       mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$ida', '$challange_eta', '1');") ; 
	}                  
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Posted succesfully!"; }

}
else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$details');");
        
        $idb = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, project_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                VALUES ('$user_id', '$id', '$title', '$idb', '1', '$challange_eta', '5', '2', '$time');");
        $idc = mysqli_insert_id($db_handle);
        mysqli_query($db_handle," insert into team_tasks (project_id, team_name, challenge_id) VALUES ('$id', '$team', '$idc');") ;
           $owners = mysqli_query($db_handle,"select DISTINCT user_id from teams where project_id = '$id' and team_name = '$team' and user_id != '$user_id' ;") ;
       while ($ownersrow = mysqli_fetch_array($owners)) { 
		   $owner = $ownersrow['user_id'] ;
		  $info = mysqli_query($db_handle,"select * from user_info where user_id = '$owner';") ;
		$inforow = mysqli_fetch_array($info);
		$mailto = $inforow['email'];
		$mail = $inforow['username'];
		$body2 = "http://collap.com/profile.php?username=".$mail ;
        collapMail($mailto, $username." assign Task to you", $body2);
       mysqli_query($db_handle," insert into challenge_ownership (user_id, challenge_id, comp_ch_ETA, status) VALUES ('$owner', '$ida', '$challange_eta', '1');") ;
	}
	 if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Posted succesfully"; }
}
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
