<?php
session_start();
include_once '../lib/db_connect.php';
if (isset($_POST['old_pass'])) {
    $old_password = mysqli_real_escape_string($db_handle, $_POST['old_pass']);
    $new_pass1 = mysqli_real_escape_string($db_handle, $_POST['new_pass1']);
    $new_pass2 = mysqli_real_escape_string($db_handle, $_POST['new_pass2']);
    $user_id = $_SESSION['user_id']; 
    $confirm_old_pass = mysqli_query($db_handle, "SELECT password FROM user_info WHERE user_id = '$user_id';");
    $confirm_old_passRow = mysqli_fetch_array($confirm_old_pass);
    $old_pass_user = $confirm_old_passRow['password'];
    $old_passwordmd5 = md5($old_password);
    if ($old_passwordmd5 == $old_pass_user) {
        $pass_new_md = md5($new_pass1);
        mysqli_query($db_handle, "UPDATE user_info SET password = '$pass_new_md' WHERE user_id = '$user_id';");
        if(mysqli_error($db_handle)){ echo "Please try again"; } 
        else {  echo "Password Updated Successfully"; }
    }
    else {  echo "Old password is incorrect"; }  
}
else { echo "Invalid parameters!"; }
mysqli_close($db_handle);
?>
