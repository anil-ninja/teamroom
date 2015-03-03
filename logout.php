<?php
	session_start();
	$requestedPage = $_GET['url'] ;
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    unset($_SESSION['username']);
    session_destroy();
    header('Location: '.$requestedPage);
    mysqli_close($db_handle);
?>
