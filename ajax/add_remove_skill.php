<?php
session_start();
include_once "../lib/db_connect.php";
if  ($_POST['insert']) {
    $userID = $_SESSION['user_id'];
    $skill_Name = $_POST['skills'];
    $skill = $_POST['insert'];
   if($skill_Name != '0') { 
    mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$userID', '$skill_Name');");
    if(mysqli_error($db_handle)) {
        echo "Failed to Add Skills!"; 
    }
    else { 
        echo "Skill added succesfully!"; 
        }
   }
    else {
	   mysqli_query($db_handle, "INSERT INTO skill_names (skill_id, skill_name) VALUES (default, '$skill');");
	   $id = mysqli_insert_id($db_handle) ;
	   mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$userID', '$id');");
   if(mysqli_error($db_handle)) {
        echo "Failed to Add Skills!"; 
    }
    else { 
        echo "Skill added succesfully!"; 
        }
   }     
}
else {
    echo "Access Denied";
}
mysqli_close($db_handle);

?>
