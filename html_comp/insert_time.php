<?php
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$ip_add = $_SERVER['REMOTE_ADDR'] ;
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$user_id = $_SESSION['user_id'] ;
$end_time = time() ;
$session_id = session_id();
mysqli_query($db_handle,"INSERT INTO user_access_records (user_id, mac_address, ip_address, user_agent, page_url, session_id, start_load_time, end_load_time)
												VALUES ('$user_id', ' ', '$ip_add', '$user_agent', '$url', '$session_id', '$start_time', '$end_time') ;") ;
mysqli_close($db_handle);
?>
