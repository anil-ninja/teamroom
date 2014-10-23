<?php
session_start();
include_once "../lib/db_connect.php";
if (isset ($_POST['skills'])) {
    $userID = $_SESSION['user_id'];
    $skill_Name = $_POST['skill_name'];
    mysqli_query($db_handle, "INSERT INTO skills (user_id, skill_name) VALUES ('$userID', '$skill_Name');");
    if(mysqli_error($db_handle)) {
        echo "Failed to Add Skills!"; 
    }
    else { 
        echo "Skill added succesfully!"; }
}
elseif (isset ($_POST['skill_id'])) {
    $userID = $_SESSION['user_id'];
    $skillID = $_POST['skill_id'];
    mysqli_query($db_handle, "UPDATE skills SET skill_status=2 WHERE user_id='$userID' AND skill_id='$skillID';");
    if(mysqli_error($db_handle)) {
        echo "Failed to Removes Skills!"; 
    }
    else { 
        echo "Skill Removed succesfully!"; }
}
else 
    echo "Access Denied";
mysqli_close($db_handle);

?>
