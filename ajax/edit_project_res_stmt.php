<?php
include_once "../lib/db_connect.php";
if($_POST['id']){
	$id=mysql_escape_String($_POST['id']);
	$projectsmt=mysql_escape_String($_POST['projectsmt']);
	$sql = "update response_project set response_pr='$projectsmt' where response_pr_id='$id'";
	mysqli_query($db_handle,$sql);
}
?>
