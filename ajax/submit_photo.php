<?php
session_start();
include_once "../lib/db_connect.php";
//print_r($_POST);
//echo "hi";
if($_POST['picturech']){
	$user_id = $_SESSION['user_id'];
	$articletext = $_POST['picturech'] ;
	$article_title = $_POST['picture_title'] ;
	$image = $_POST['img'] ;
	$article = $image." ".$articletext ;
 if (strlen($article) < 400) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status) 
                                    VALUES ('$user_id', '$article_title', '$article', '1', '1', '3', '6') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Article!"; }
	else { echo "Posted succesfully!"; }
} 
else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$article');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type, challenge_status) 
                                VALUES ('$user_id', '$article_title', '$id', '1', '1', ' ', '3', '6');");
	 if(mysqli_error($db_handle)) { echo "Failed to Post Article!"; }
	else { echo "Posted succesfully!"; }
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
