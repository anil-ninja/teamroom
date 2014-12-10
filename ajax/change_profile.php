<?php
session_start();
include_once "../lib/db_connect.php";
if  ($_POST['case']) {
    $user_id = $_SESSION['user_id'];
    $skill = $_POST['insert'];
    $skill_Name = $_POST['skills'];
    $skillID = $_POST['skill_id'];
    $case = $_POST['case'];
    $new_first_name = $_POST['fname'];
    $new_last_name = $_POST['lname'];
    $email = $_POST['email'];
    $new_phone = $_POST['phone'];
    $about = $_POST['about'];
    $town = $_POST['townname'];
    $comp = $_POST['comp'];
    switch($case) {
		case 1:
			mysqli_query($db_handle, "INSERT INTO skill_names (skill_id, skill_name) VALUES (default, '$skill');");
			$id = mysqli_insert_id($db_handle) ;
			mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$user_id', '$id');");
			if(mysqli_error($db_handle)) { echo "Duplicate Entry!";  }
			else { echo "Skill added succesfully!"; }
			exit ;
			break ;
			
		case 2:
			mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$user_id', '$skill_Name');");
			if(mysqli_error($db_handle)) { echo "Duplicate Entry!"; }
			else { echo "Skill added succesfully!"; }
			exit ;
			break ;
			
		case 3:
			mysqli_query($db_handle, "DELETE FROM user_skills WHERE user_id='$user_id' AND skill_id='$skillID';");
			if(mysqli_error($db_handle)) { echo "Failed to Remove!"; }
			else { echo "Skill Removed succesfully!"; }
			exit ;
			break ;
			
		case 4:
			$aboutuser = mysqli_query($db_handle, "SELECT organisation_name, living_town, about_user FROM about_users WHERE user_id = '$user_id' ;") ;
            $aboutuserRow = mysqli_fetch_array($aboutuser); 
            $var4 = $aboutuserRow['organisation_name'] ;
            $var5= $aboutuserRow['living_town'] ;
            $var6 = $aboutuserRow['about_user'] ;
            $detail = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = '$user_id' and email = '$email' ;") ;
            $detailRow = mysqli_fetch_array($detail) ;
            $var1 = $detailRow['first_name'] ;
            $var2 = $detailRow['last_name'] ;
            $var3 = $detailRow['contact_no'] ;
            if ($var1 != $new_first_name) {
				mysqli_query($db_handle, "UPDATE user_info SET first_name='$new_first_name' WHERE user_id='$user_id and email = '$email' ;");
				}
			if ($new_last_name != "") {
				if ($var2 != $new_last_name) {
					mysqli_query($db_handle, "UPDATE user_info SET last_name='$new_last_name' WHERE user_id='$user_id' and email = '$email' ;");
					}
				}
			if ($new_phone != "") {
				if ($var3 != $new_phone) {
					mysqli_query($db_handle, "UPDATE user_info SET contact_no='$new_phone' WHERE user_id='$user_id' and email = '$email' ;");
					}
				}
			if (mysqli_num_rows($aboutuser) != 0) {
				if ($comp != "") {
					if ($var4 != $comp) {
						mysqli_query($db_handle, "UPDATE about_users SET organisation_name='$comp' WHERE user_id='$user_id' ;");
						}
					}
				if ($town != "") {
					if ($var5 != $town) {
						mysqli_query($db_handle, "UPDATE about_users SET living_town='$town' WHERE user_id='$user_id' ;");
						}
					}
				if ($about != "") {
					if ($var6 != $about) {
						mysqli_query($db_handle, "UPDATE about_users SET about_user='$about' WHERE user_id='$user_id' ;");
						}
					}		
				}
				else {
					mysqli_query($db_handle, "INSERT INTO about_users (user_id, organisation_name, living_town, about_user) 
																			VALUES ('$user_id', '$comp', '$town', '$about');") ;
					}
			if (mysqli_error($db_handle)) { echo "Please try again"; }
			else { echo $user_id; }
			exit ;
			break ;
			
		case 5:
			echo "Posted succesfully!";
			exit ;
			break ;
		   
   }
 }
mysqli_close($db_handle);
?>
