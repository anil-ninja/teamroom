<?php
session_start();
include_once "../lib/db_connect.php";

$userID = $_SESSION['user_id'];


//echo $challengeID . $userID;
if(isset($_POST['challengeID'])){
	$challengeID = $_POST['challengeID'];

	$sql = "UPDATE challenges SET challenge_type = '3' WHERE challenge_id = '$challengeID' and user_id = '$userID';";
	mysqli_query($db_handle, $sql);

    if(mysqli_error($db_handle)) echo "Failed to delete Challange!"; 
	else echo "Deleted succesfully!"; 

} 
else echo "Access Denied";

mysqli_close($db_handle);
?>