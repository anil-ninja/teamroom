<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
//echo "hi";
if($_POST['article']){
	$user_id = $_SESSION['user_id'];
	$articletext = $_POST['article'] ;
	$article_title = $_POST['article_title'] ;
	$image = $_POST['img'] ;
	//echo $image ;
	if (strlen($image) < 30 ) {
		$article = $articletext ;
	}
	else {
		$article = $image."<br/> ".$articletext ;
		}
	$time = date("Y-m-d H:i:s") ;
 if (strlen($article) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, last_update) 
                                    VALUES ('$user_id', '$article_title', '$article', '1', '999999', '7', '$time') ; ") ;
    $idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"1",$idp);
    if(mysqli_error($db_handle)) { echo "Failed to Post Article!"; }
	else { echo "Posted succesfully!"; }
} 
else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$article');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type, last_update) 
                                VALUES ('$user_id', '$article_title', '$id', '1', '999999', ' ', '7', '$time');");
	$idp = mysqli_insert_id($db_handle);
      involve_in($db_handle,$user_id,"1",$idp);
	 if(mysqli_error($db_handle)) { echo "Failed to Post Article!"; }
	else { echo "Posted succesfully!"; }
}
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
