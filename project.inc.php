<?php 
include_once 'ninjas.inc.php';
include_once 'functions/delete_comment.php';

$pro_id = $_GET['project_id'] ;

if(!checkProject($pro_id,$user_id,$db_handle))
	{	 
	header("location: ninjas.php") ;
		exit ;
	} 	
$user_id = $_SESSION['user_id'] ;
$name = $_SESSION['first_name'];
$rank = $_SESSION['rank'] ;
$pro_idR = $pro_id;
$project_id = mysqli_query($db_handle, "SELECT * FROM projects WHERE project_id = '$pro_id' ;");
$project_idrow = mysqli_fetch_array($project_id) ;
$eta = $project_idrow['project_ETA'] ;
$creater_id = $project_idrow['user_id'] ;
$projttitle = $project_idrow['project_title'] ;
$starttime = $project_idrow['creation_time'] ;
$timef = date("j F, g:i a",strtotime($starttime));
$prtime = remaining_time($starttime, $eta) ;	//resp_projecttalk

$contact = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = '$user_id';");
$contactrow = mysqli_fetch_array($contact) ;
$con_no = $contactrow['contact_no'] ;
$email = $contactrow['email'] ;
?>
