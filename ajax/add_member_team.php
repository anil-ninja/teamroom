<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';

if (isset($_POST['emailadd_member1'])) {
    $team_name = $_POST['teamName1'];
    $user_id = $_SESSION['user_id'] ;
    $email = $_POST['emailadd_member1'];
    $pro_id = $_POST['project_id1'] ;
    $respo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE email = '$email';");
    $row = mysqli_num_rows($respo);
    if ($row == 1) {
            $responserow = mysqli_fetch_array($respo);
            $uid = $responserow['user_id'];
            $already_member = mysqli_query($db_handle, "SELECT user_id FROM teams WHERE user_id = '$uid' AND project_id = '$pro_id' AND member_status = '1' AND status = '1' AND team_name = '$team_name';");
            $already_memberRow = mysqli_num_rows($already_member);
            if ($already_memberRow == 1) {
                echo "Already a member of this team";
            } 
            else {
                mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, project_id, team_owner) VALUES ('$uid', '$team_name', '$pro_id', '$user_id');");
                events($db_handle,$user_id,"12",$pro_id);
                involve_in($db_handle,$user_id,"12",$pro_id);
                echo "Member Added succesfully!";
            }
    } 
    else { 
        echo "Member Not Registered Yet" ;
    }
    //header('location: #');
}
if (isset($_POST['team_name'])) {
    $team_name = $_POST['team_name'];
    $mem_remove_id = $_POST['mem_remove_id'] ;
    $pro_id = $_POST['project_id'] ;
    $leave_team = date("y-m-d H:i:s") ;
    mysqli_query($db_handle, "UPDATE teams SET member_status='2', leave_team='$leave_team' 
                            WHERE team_name = '$team_name' AND project_id = $pro_id AND user_id = $mem_remove_id;");
    echo "Member Removed succesfully!";
}
?>
