<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../ninjas.inc.php';
include_once '../functions/delete_comment.php';
if($_POST['project_title']){
	$user_id = $_SESSION['user_id'];
	$project_title = $_POST['project_title'] ;
	$project_sttext = htmlspecialchars(trim($_POST['project_stmt']), ENT_QUOTES);
	$project_eta = $_POST['project_eta'] ;
	$type = $_POST['type'] ;
	$image = $_POST['img'] ;
	$project_st = $image." ".$project_sttext ;
if (strlen($project_st) < 1000) {
        mysqli_query($db_handle, "INSERT INTO projects (user_id, project_title, stmt, project_ETA, project_type) 
                                  VALUES ('$user_id', '$project_title', '$project_st', '$project_eta', '$type');");
       $idp = mysqli_insert_id($db_handle);                           
     mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name, team_owner) VALUES ('$user_id', '$idp', 'defaultteam', '$user_id') ;" ) ;
    if($type == 2) { 
     involve_in($db_handle,$user_id,"2",$idp); 
       events($db_handle,$user_id,"2",$idp);
		}  
		else {
			  involve_in($db_handle,$user_id,"9",$idp);
	   }
    if(mysqli_error($db_handle)) { echo "Failed to Post Project!"; }
	else { echo "Project posted succesfully!"; }
}
    else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$project_st');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO projects (user_id, blob_id, project_title, stmt, project_ETA, project_type) 
                                VALUES ('$user_id', '$id', '$project_title', ' ', '$project_eta', '$type');");
	$idp = mysqli_insert_id($db_handle);
	mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name, team_owner) VALUES ('$user_id', '$idp', 'defaultteam', '$user_id') ;" ) ;
	if($type == 2) { 
     involve_in($db_handle,$user_id,"2",$idp); 
       events($db_handle,$user_id,"2",$idp);
		}  
		else {
			  involve_in($db_handle,$user_id,"9",$idp);
	   }
	if(mysqli_error($db_handle)) { echo "Failed to Post Project!"; }
	else { echo "Project posted succesfully!"; }
}
	mysqli_close($db_handle);
}
