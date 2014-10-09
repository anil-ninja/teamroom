<?php
//include('../init.php');
## Server's date and time. Converting it as per local time.
//$date = date('Y-m-d H:i:s');
//$con_date = date('c', strtotime($date));
session_start();
include_once "../lib/db_connect.php";

$userID = $_SESSION['user_id'];

if(isset($_POST['commentID'])){
	$commentID = $_POST['commentID'];
	$sql = "DELETE FROM response_challenge WHERE response_ch_id = '$commentID' and user_id = '$userID';";
	mysqli_query($db_handle, $sql);

    if(mysqli_error($db_handle)) echo "Failed to delete Challange!"; 
	else echo "Deleted succesfully!"; 
} 
//else echo "Access Denied";
if(isset($_POST['comment_projectID'])){
	$ida = $_POST['comment_projectID'];
	$sql = "DELETE FROM response_project WHERE response_pr_id = '$ida' and user_id = '$userID';";
	mysqli_query($db_handle, $sql);
    if(mysqli_error($db_handle)) echo "Failed to delete Challange!"; 
	else echo "Deleted succesfully!"; 
} 

mysqli_close($db_handle);


//echo $challengeID . $userID;


/*
if ($r == 'delete_comment') {
    if (isset($_GET['token']) &&isset($_GET['c_id'])) {
        //$token = clean_input($_GET['token']);
        $comment_id = intval($_GET['c_id']);
        if (!empty($comment_id)) {
            try {
                $del_comment = 'DELETE FROM `response_challenge` WHERE `response_ch_id` = comment_id AND `user_id` = $user_id';
                $del_comment_do = $db_handle->prepare($del_comment);
                $del_comment_do->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
                $del_comment_do->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $del_comment_do->execute();

                ## Sending the response back to the page
                echo 'success';
            } catch (PDOException $e) {
                ## Place to catch and log errors.
                echo 'failed';
            }
            }
        }
    }
 */

?>