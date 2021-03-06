<?php
include_once 'lib/db_connect.php';
include_once 'html_comp/start_time.php';
include_once 'functions/delete_comment.php';
include_once 'functions/image_resize.php';
session_start(); 
$user_id = $_SESSION['user_id'];
$name = $_SESSION['first_name'];
$username = $_SESSION['username'];
$rank = $_SESSION['rank'];
$email = $_SESSION['email'];

function checkProject($projectID, $userId, $db_handle){
	//returns true in case of public
	$type = mysqli_query($db_handle,"select project_type from projects where project_id = '$projectID' ;") ;
	$typerow = mysqli_fetch_array($type) ;
	$usertype = mysqli_query($db_handle, "select * from user_info where user_id = '$userId' ;") ;
	$usertypeRow = mysqli_fetch_array($usertype) ;
	$TypeUser = $usertypeRow['user_type'] ;
	if ($typerow['project_type'] == 1) {
		return true ;
	}
	else if ($typerow['project_type'] == 2) {
		if(isset($_SESSION['user_id'])){
			$access = mysqli_query($db_handle,"(select user_id from projects where project_id = '$projectID' and user_id = '$userId')
												UNION 
												(SELECT DISTINCT a.user_id FROM teams as a join projects as b WHERE a.user_id = '$userId' and a.project_id = b.project_id and b.project_id = '$projectID' and a.member_status = '1') ;") ;
			if (mysqli_num_rows($access) > 0) {
				return true ;
			}
			else return false ;
		}
		else return false ;
	}
	else if ($typerow['project_type'] == 4) { 
		if(isset($_SESSION['user_id'])){
			if($TypeUser == "invester" || $TypeUser == "collaboraterInvester" || $TypeUser == "fundsearcherInvester" || $TypeUser == "collaboraterinvesterfundsearcher"){
				return true ;
			} 
			else {
				$check = mysqli_query($db_handle,"(select user_id from projects where project_id = '$projectID' and user_id = '$userId')
													UNION 
													(SELECT DISTINCT a.user_id FROM teams as a join projects as b WHERE a.user_id = '$userId' and a.project_id = b.project_id and b.project_id = '$projectID' and a.member_status = '1') ;") ;
				if (mysqli_num_rows($check) > 0) {
					return true ;
				}
				else return false ;
			}
		}
		else return false ;
	}
	else return false ;
		//check user have access if access the return true
}

if(isset($_GET['projectphp'])){
	$projt_id = $_GET['project_id'];
	if(checkProject($projt_id,$user_id,$db_handle)) {
		 header("location: project.php?project_id=$projt_id") ;		
		exit ;
	} else {
		header("location: ninjas.php") ;
		}
	}
?>
