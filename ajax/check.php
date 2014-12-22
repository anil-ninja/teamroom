<?php 
session_start() ;
include_once "../lib/db_connect.php";
$user_id = $_SESSION['user_id'] ;
if($_POST['url']) {
	$url = $_POST['url'] ;
	echo "1" ;
	mysqli_close($db_handle);
}
else echo "Invalid Parameters!" ;
?>
