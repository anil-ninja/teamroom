<?php 
session_start();
include_once "../lib/db_connect.php";
if (isset($_POST['new_first'])) {
    $new_first_name = $_POST['new_first'];
    $new_last_name = $_POST['new_last'];
    $user_id = $_SESSION['user_id'];
    mysqli_query($db_handle, "UPDATE user_info SET first_name='$new_first_name', last_name='$new_last_name' WHERE user_id='$user_id';");
    if (mysqli_error($db_handle)) {
        echo "Please try again";
    }
    else {
        echo "Updated successfuly";
    }
}
?>