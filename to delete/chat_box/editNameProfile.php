<?php 
session_start();
include_once "../lib/db_connect.php";
if (isset($_POST['fname'])) {
    $new_first_name = $_POST['fname'];
    $new_last_name = $_POST['lname'];
    $new_email = $_POST['email'];
    $new_phone = $_POST['phone'];
    $about = $_POST['about'];
    $town = $_POST['townname'];
    $comp = $_POST['comp'];
    $user_id = $_SESSION['user_id'];
    mysqli_query($db_handle, "UPDATE user_info SET first_name='$new_first_name', last_name='$new_last_name', email='$new_email', contact_no='$new_phone'
								WHERE user_id='$user_id';");
    $check = mysqli_query($db_handle, "SELECT * FROM about_users WHERE user_id='$user_id' ;") ;
    if (mysqli_num_rows($check) != 0) {
		if($comp != "") {
			mysqli_query($db_handle, "UPDATE about_users SET organisation_name='$comp' WHERE user_id='$user_id' ;") ;
			}
		if($town != "") {
			mysqli_query($db_handle, "UPDATE about_users SET living_town='$town' WHERE user_id='$user_id' ;") ;
			}
		if($about != "") {
			mysqli_query($db_handle, "UPDATE about_users SET about_user='$about' WHERE user_id='$user_id' ;") ;
			}		
		}
		else {
			mysqli_query($db_handle, "INSERT INTO about_users (user_id, organisation_name, living_town, about_user) 
										VALUES ('$user_id', '$comp', '$town', '$about');") ;
			}
    if (mysqli_error($db_handle)) {
        echo "Please try again";
    }
    else {
        echo "Updated successfuly";
    }
}
?>
