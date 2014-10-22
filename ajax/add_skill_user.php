<?php
session_start();
include_once "../lib/db_connect.php";
if(isset($_SESSION['user_id']))
    $userID = $_SESSION['user_id'];
else 
    header ('location:../index.php');
if (isset ($_POST['skill_id'])) {
    $userID = $_SESSION['user_id'];
    $skillID = $_POST['skill_id'];
    mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$userID', '$skillID');");
    if(mysqli_error($db_handle)) {
        echo "Failed to Add Skills!"; 
    }
    else { 
        echo "Skill added succesfully!"; }
}
else 
    echo "Access Denied";
mysqli_close($db_handle);

?>
