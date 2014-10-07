<?php
include_once 'ninjas.inc.php';

if(isset($_POST['chl_response'])) {
    $user_id = $_SESSION['user_id'];
    $challenge_id_comment = $_POST['challen_id'] ;
    $ch_response = $_POST['ch_response'] ;
   if(strlen($ch_response)>1) {    
    mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) 
                                VALUES ('$user_id', '$challenge_id_comment', '$ch_response');") ;
    header('Location: challenges.php');
} else { echo "<script>alert('Is your mind empty!')</script>"; }
}
if(isset($_POST['own_chl_response'])) {
    $user_id = $_SESSION['user_id'];
    $own_challenge_id_comment = $_POST['own_challen_id'] ;
    $own_ch_response = $_POST['own_ch_response'] ;
    if (strlen($own_ch_response)>1) {
    mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) 
                                VALUES ('$user_id', '$own_challenge_id_comment', '$own_ch_response');") ;
    header('Location: challenges.php');
} else { echo "<script>alert('Is your mind empty!')</script>"; }
}
?>
