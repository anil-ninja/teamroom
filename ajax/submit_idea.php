<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if($_POST['idea']){
	$user_id = $_SESSION['user_id'];
	$articletext = $_POST['idea'] ;
	$article_title = $_POST['idea_title'] ;
	$image = $_POST['img'] ;
	$article = $image."<br/> ".$articletext ;
 if (strlen($article) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type) 
                                    VALUES ('$user_id', '$article_title', '$article', '1', '1', '4') ; ") ;
      $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"1",$idp); 
    if(mysqli_error($db_handle)) { echo "Failed to Post IDEA!"; }
	else { echo "Posted succesfully!"; }
} else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$article');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type) 
                                VALUES ('$user_id', '$article_title', '$id', '1', '1', ' ', '4');");
       $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"1",$idp); 
	 if(mysqli_error($db_handle)) { echo "Failed to Post Idea!"; }
	else { echo "Posted succesfully!"; }
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
