<?php
include_once '../lib/db_connect.php';
include_once '../functions/collapMail.php';


if (isset($_POST['email_rew_pass'])) {
    $email_req = $_POST['email_rew_pass'];
    $user_id_access_aid = mysqli_query($db_handle, "SELECT user_id FROM user_info WHERE email= $email_req ;");
    
    $user_id_access_aidRow = mysqli_fetch_array($user_id_access_aid);
    $user_id_access = $user_id_access_aidRow['user_id'];
    $hash_key = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
    mysqli_query($db_handle, "INSERT INTO user_access_aid (user_id, hash_key) VALUES ($user_id_access, $hash_key);");
    
    $id_access_id = mysqli_insert_id($db_handle);
    $hash_key = $hash_key.".".$id_access_id;
    $body = "http://collap.com/forgetPassword.php?hash_key='$hash_key'";

    collapMail($email_req, "Update password", $body);

    if(mysqli_error($db_handle)){
            echo "Please try again";
    }
}
?>