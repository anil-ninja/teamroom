<?php
session_start();
include_once "../lib/db_connect.php";
include_once 'project.inc.php';
if($_POST['project_title']){
	$user_id = $_SESSION['user_id'];
	$project_title = $_POST['project_title'] ;
	$project_st = $_POST['project_stmt'] ;
	$project_eta = $_POST['project_eta'] ;
if (strlen($project_st) < 1000) {
        mysqli_query($db_handle, "INSERT INTO projects (user_id, project_title, project_stmt, project_ETA) 
                                  VALUES ('$user_id', '$project_title', '$project_st', '$project_eta');");
    if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Project posted succesfully!"; }
}
    else {
        mysqli_query($db_handle, "INSERT INTO projects_blob (project_blob_id, project_stmt) 
                                VALUES (default, '$project_st');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO projects (user_id, project_blob_id, project_title, project_stmt, project_ETA) 
                                VALUES ('$user_id', '$id', '$project_title', ' ', '$project_eta');");
	if(mysqli_error($db_handle)) { echo "Failed to Post Challange!"; }
	else { echo "Project posted succesfully!"; }
}
	mysqli_close($db_handle);
}