<?php
session_start();
include_once "../lib/db_connect.php";
if  ($_POST['insert']) {
    $userID = $_SESSION['user_id'];
    $skill = $_POST['insert'];
    mysqli_query($db_handle, "INSERT INTO skill_names (skill_id, skill_name) VALUES (default, '$skill');");
	   $id = mysqli_insert_id($db_handle) ;
	   mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$userID', '$id');");
   if(mysqli_error($db_handle)) {
        echo "Duplicate Entry!"; 
    }
    else { 
        echo "Skill added succesfully!";
         }   
   }
 else if ($_POST['skills']) {
    $userID = $_SESSION['user_id'];
     $skill_Name = $_POST['skills'];
     //echo $userID ;
	    mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$userID', '$skill_Name');");
    if(mysqli_error($db_handle)) {
        echo "Duplicate Entry!"; 
    }
    else { 
        echo "Skill added succesfully!"; 
        }
   }     

elseif ($_POST['skill_id']) {
    $userID = $_SESSION['user_id'];
    $skillID = $_POST['skill_id'];
    mysqli_query($db_handle, "DELETE FROM user_skills WHERE user_id='$userID' AND skill_id='$skillID';");
    if(mysqli_error($db_handle)) {
        echo "Failed to Remove!"; 
    }
    else { 
        echo "Skill Removed succesfully!"; }
}
else {
    echo "Access Denied";
}
mysqli_close($db_handle);

?>
