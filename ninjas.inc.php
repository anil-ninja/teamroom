<?php
include_once 'lib/db_connect.php';

session_start();
$user_id = $_SESSION['user_id'];
$name = $_SESSION['first_name'];
$rank = $_SESSION['rank'];
$email = $_SESSION['email'];

if (!isset($_SESSION['first_name'])) {
    header('Location: index.php');
}
if(isset($_POST['public_chl_response'])) {
    $user_id = $_SESSION['user_id'];
    $challenge_id_comment = $_POST['public_challen_id'] ; 
    $ch_response = $_POST['public_ch_response'] ;
   if(strlen($ch_response)>1){
    mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) 
                                VALUES ('$user_id', '$challenge_id_comment', '$ch_response');") ;
    header('Location: #');
   }
   else{ echo "<script>alert('Is your mind empty!')</script>";
}
}

if (isset($_POST['logout'])) {
    header('Location: index.php');
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    session_destroy();
}   

if (isset($_POST['chlange'])) {
		$user_id = $_SESSION['user_id'];
		$chalange = $_POST['challenge_id'] ;
		$youreta = $_POST['y_eta'] ;
		$youretab = $_POST['y_etab'] ;
		$youretac = $_POST['y_etac'] ;
		$youretad = $_POST['y_etad'] ;
		$your_eta = (($youreta*30+$youretab)*24+$youretac)*60+$youretad ;
		mysqli_query($db_handle,"UPDATE challenges SET challenge_status='2' WHERE challenge_id = $chalange ; ") ;
		mysqli_query($db_handle,"INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)
									VALUES ('$user_id', '$chalange', '$your_eta');") ;
header('Location: ninjas.php');
}
if(isset($_POST['projectphp'])){
		 header('location: project.php') ;   
		$_SESSION['user_id'] = $user_id;
		$_SESSION['email'] = $email;
		$_SESSION['first_name'] = $name;
		$_SESSION['project_title'] = $_POST['project_title'] ;
		$_SESSION['project_id'] = $_POST['project_id'] ;
		$_SESSION['rank'] = $rank;
		exit ;
	}

?>
