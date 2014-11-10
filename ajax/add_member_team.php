<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if (isset($_POST['email_add_member'])) {
    $team_name = $_POST['team_name'];
    $user_id = $_SESSION['user_id'] ;
    $email = $_POST['email_add_member'];
    $pro_id = $_POST['project_id'] ;
    $respo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE email = '$email';");
    $row = mysqli_num_rows($respo);
    if ($row == 1) {
            $responserow = mysqli_fetch_array($respo);
            $uid = $responserow['user_id'];
            mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, project_id) VALUES ('$uid', '$team_name', '$pro_id');");
            events($db_handle,$user_id,"12",$pro_id) ;
			involve_in($db_handle,$user_id,"12",$pro_id) ;
            //header('Location: projct.php');
    } 
    else { 
        echo "Member Not Registered Yet" ;
    }
    //header('location: #');
}
?>
