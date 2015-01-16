<?php 
include_once 'ninjas.inc.php';
include_once 'html_comp/start_time.php';
include_once 'functions/delete_comment.php';
include_once 'functions/image_resize.php';
$pro_id = $_GET['project_id'] ;
$_SESSION['project_id']= $pro_id;
if (isset($_POST['request_order']) && ($_POST['select_order'] == 'ASC')) {
  //$sort_by = 'ASC';
  mysqli_query($db_handle, "INSERT INTO project_order (project_id) VALUES ('$pro_id');");
}
elseif (isset($_POST['request_order']) && ($_POST['select_order'] == 'DESC')) {
  //$sort_by = 'DESC'; 
  mysqli_query($db_handle, "DELETE FROM project_order WHERE project_id ='$pro_id';");
}

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
$projttitle = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $project_idrow['project_title'])))) ;
$projectttitle = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $project_idrow['project_title']))) ;
$starttime = $project_idrow['creation_time'] ;
$timef = date("j F, g:i a",strtotime($starttime));
$prtime = remaining_time($starttime, $eta) ;	//resp_projecttalk

$contact = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = '$user_id';");
$contactrow = mysqli_fetch_array($contact) ;
$con_no = $contactrow['contact_no'] ;
$email = $contactrow['email'] ;

$order_content = mysqli_query($db_handle, "SELECT project_id FROM project_order WHERE project_id='$pro_id';");
$order_contentRow = mysqli_fetch_array($order_content);
$order_check_pro_id = $order_contentRow['project_id'];
if ($pro_id == $order_check_pro_id) {
	$sort_by = 'ASC';
}
else {
	$sort_by = 'DESC';
}
?>
