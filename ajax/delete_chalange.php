<?php
session_start();
include_once "../lib/db_connect.php";
if(isset($_SESSION['user_id']))
    $userID = $_SESSION['user_id'];
else 
    header ('location:../index.php');


//echo $challengeID . $userID;
if(isset($_POST['cID'])){
	$challengeID = $_POST['cID'];

	$sql = "UPDATE challenges SET challenge_type = '3' WHERE challenge_id = '$challengeID' and user_id = '$userID';";
	mysqli_query($db_handle, $sql);

    if(mysqli_error($db_handle)) echo "Failed to delete Challange!"; 
	else echo "Deleted succesfully!"; 

} 
//else echo "Access Denied";

if(isset($_POST['noteID'])){
	$noteID = $_POST['noteID'];
        echo 'DFVJHVFDJHV';
        //echo $challengeID;
	$sql = "UPDATE challenges SET challenge_type = '3' WHERE challenge_id = '$noteID' and user_id = '$userID';";
	mysqli_query($db_handle, $sql);

    if(mysqli_error($db_handle)) echo "Failed to delete Note!"; 
	else echo "Deleted succesfully!"; 

} 
else echo "Access Denied";
mysqli_close($db_handle);
?>