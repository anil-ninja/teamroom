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

if (isset($_POST['resp_project'])) {
	$user_id = $_SESSION['user_id'] ;
	$pro_id = $_SESSION['project_id'] ;
	$pr_respon = $_POST['pr_resp'] ;
	events($db_handle,$user_id,"14",$pro_id);
    involve_in($db_handle,$user_id,"14",$pro_id);
  if(strlen($pr_respon)>1) {
  if (strlen($pr_respon) < 1000) {
        mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt) VALUES ('$user_id', '$pro_id', '$pr_respon') ; ") ;
		header('Location: #');
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$pr_respon');");
          $id = mysqli_insert_id($db_handle);
       mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, blob_id, stmt) VALUES ('$user_id', '$pro_id', '$id', ' ') ; ") ;
		header('Location: #');
}
} else { echo "<script>alert('Enter something!')</script>"; }
}
if(isset($_POST['requestaccept'])){
	$request_id = $_POST['request_id'] ;
	$time = date("Y-m-d H:i:s") ;
	$user_id = $_SESSION['user_id'] ;
	echo $knownid ;
	mysqli_query($db_handle, "update known_peoples set status='2', last_action_time='$time' where id='$request_id' and knowning_id='$user_id' ;") ; 
	 if(mysqli_error($db_handle)) { echo "<script>alert('Sorry Try again!')</script>"; }
	else { echo "<script>alert('Request Accepted succesfully!')</script>"; }
	header('Location: #');
	}
if(isset($_POST['requestdelete'])){
	$request_id = $_POST['request_id'] ;
	$time = date("Y-m-d H:i:s") ;
	$user_id = $_SESSION['user_id'] ;
	echo $knownid ;
	mysqli_query($db_handle, "update known_peoples set status='3', last_action_time='$time' where id='$request_id' and knowning_id='$user_id' ;") ; 
	 if(mysqli_error($db_handle)) { echo "<script>alert('Sorry Try again!')</script>"; }
	else { echo "<script>alert('Request Deleted succesfully!')</script>"; }
	header('Location: #');
	}	

$contact = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = '$user_id';");
$contactrow = mysqli_fetch_array($contact) ;
$con_no = $contactrow['contact_no'] ;
$email = $contactrow['email'] ;
?>
