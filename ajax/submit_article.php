<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['article']){
	$user_id = $_SESSION['user_id'];
	$article = $_POST['article'] ;
	$article_title = $_POST['article_title'] ;
 if (strlen($article) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$article_title', '$article', '1', '1', '9') ; ") ;
    if(mysqli_error($db_handle)) { echo "Failed to Post Article!"; }
	else { echo "Article posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$article');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type) 
                                VALUES ('$user_id', '$article_title', '$id', '$opentime', '$challange_eta', ' ', '9');");
	 if(mysqli_error($db_handle)) { echo "Failed to Post Article!"; }
	else { echo "Article posted succesfully!"; }
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
