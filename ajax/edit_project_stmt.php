<?php
include_once "../lib/db_connect.php";
if($_POST['id']){
	$id=mysql_escape_String($_POST['id']);
	$projectsmt=mysql_escape_String($_POST['projectsmt']);
	$sql = "update projects set project_stmt='$projectsmt' where project_id='$id'";
	mysqli_query($db_handle,$sql);
}
?>
