<?php
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';
$user_id_joined = $_SESSION['profile_view_userID'];
joined_projects ($db_handle, $user_id_joined);
mysqli_close($db_handle);
?>
