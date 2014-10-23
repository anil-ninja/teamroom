<?php
session_start();
include_once "../lib/db_connect.php";
if(isset($_SESSION['user_id']))
    $userID = $_SESSION['user_id'];
else 
    header ('location:../index.php');

else echo "Access Denied";
mysqli_close($db_handle);
?>