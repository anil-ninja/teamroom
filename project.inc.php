<?php 
include_once 'ninjas.inc.php';
include_once 'functions/delete_comment.php';

$pro_id = $_GET['project_id'] ;

if(!checkProject($pro_id,$user_id,$db_handle))
	{	 
	header("location: ninjas.php") ;
		exit ;
	}
if(!isset($_SESSION['user_id'])) {
	header('Location:index.php') ;
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
$starttime = $project_idrow['project_creation'] ;
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

if (isset($_POST['resp_projecttalk'])) {
	$user_id = $_SESSION['user_id'] ;
	$pro_id = $_SESSION['project_id'] ;
	$pr_respon = $_POST['pr_resptalk'] ;
	//events($db_handle,$user_id,"14",$pro_id);
   // involve_in($db_handle,$user_id,"14",$pro_id);
  if(strlen($pr_respon)>1) {
  if (strlen($pr_respon) < 1000) {
        mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt, status) VALUES ('$user_id', '$pro_id', '$pr_respon', '5') ; ") ;
		header('Location: #');
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$pr_respon');");
          $id = mysqli_insert_id($db_handle);
       mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, blob_id, stmt, status) VALUES ('$user_id', '$pro_id', '$id', ' ', '5') ; ") ;
		header('Location: #');
}
} else { echo "<script>alert('Enter something!')</script>"; }
}
	
if(isset($_POST['submitchl'])) {
	$id = $_POST['id'] ;
	echo "<div style='display: block;' class='modal fade in' id='answerForm' tabindex='-1' role='dialog' aria-labelledby='shareuserinfo' aria-hidden='false'>
			<div class='modal-dialog'> 
				<div class='modal-content'>
				 <div class='modal-header'> 
				   <a href = 'project.php' type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></a>
				   <h4 class='modal-title' id='myModalLabel'>Submit Answer</h4> 
				 </div> 
				 <div class='modal-body'><form>
				  <div class='input-group-addon'>
				  <textarea row='5' id='answerchal' class='form-control' placeholder='submit your answer'></textarea>
				  </div><br/>
				  <input class='btn btn-default btn-sm' type='file' id='_fileanswer' style ='width: auto;'><br/>
				    <input type='hidden' id='answercid' value='".$id."'>
				    <input type='submit' class='btn btn-success btn-sm' id='answerch' value = 'Submit' ></small>
				</form></div> 
				<div class='modal-footer'>
				   <a type='button' href = 'project.php' class='btn btn-default' data-dismiss='modal'>Close</a>
				</div>
			</div> 
		</div>
	</div>" ;
}

$contact = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = '$user_id';");
$contactrow = mysqli_fetch_array($contact) ;
$con_no = $contactrow['contact_no'] ;
$email = $contactrow['email'] ;
?>
