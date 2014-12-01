<?php
session_start();
include_once 'C:\wamp\www\localllll\teamroom\lib/db_connect.php';
include_once 'C:\wamp\www\localllll\teamroom\functions/profile_page_function.php';
include_once 'C:\wamp\www\localllll\teamroom\functions/delete_comment.php';
$user_id_joined = $_SESSION['profile_view_userID'];
user_articles ($db_handle, $user_id_joined);
?>