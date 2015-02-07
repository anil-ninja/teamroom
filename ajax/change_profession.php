<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/collapMail.php';

if  ($_POST['case']) {
    $user_id = $_SESSION['user_id'];
    $skill = $_POST['insert'];
    $skill_Name = $_POST['skills'];
    $skillID = $_POST['skill_id'];
    $case = $_POST['case'];
    $friends = mysqli_query($db_handle, "(SELECT a.email, a.username, a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
											where a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id')
											as b where a.user_id = b.user_id )
											UNION
											(select a.email, a.username, a.user_id FROM user_info as a join known_peoples as b
											where b.requesting_user_id = '$user_id' and a.user_id = b.knowning_id and b.status != '4')
											UNION
											(select a.email, a.username, a.user_id FROM user_info as a join known_peoples as b
											where b.knowning_id = '$user_id' and a.user_id = b.requesting_user_id and b.status = '2') ;");
    switch($case) {
		case 1:
			mysqli_query($db_handle, "INSERT INTO professsion_name (p_id, p_name) VALUES (default, '$skill');");
			$id = mysqli_insert_id($db_handle) ;
			mysqli_query($db_handle, "INSERT INTO user_profession (user_id, p_id) VALUES ('$user_id', '$id');");
			while ($friendsrow = mysqli_fetch_array($friends)){
				$emails = $friendsrow['email'] ;
				$mail = $friendsrow['username'] ;
				$idfr = $friendsrow['user_id'] ;
				events($db_handle,$user_id,"40",$idfr);
				}
			if(mysqli_error($db_handle)) { echo "Duplicate Entry!";  }
			else { echo "Profession added succesfully!"."+"."<span class='btn-success' id='profession_".$id."' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".$skill."&nbsp 
							<a type='submit' class='btn-success' style='padding-left: 0px; padding-right: 0px;' id='remove_profession' 
							onclick='remove_profession(\"".$id."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Remove Profession'>
                            <i class='icon-remove'></i></a></span>&nbsp;"; }
			exit ;
			break ;
			
		case 2:
			mysqli_query($db_handle, "INSERT INTO user_profession (user_id, p_id) VALUES ('$user_id', '$skill_Name');");
			while ($friendsrow = mysqli_fetch_array($friends)){
				$emails = $friendsrow['email'] ;
				$mail = $friendsrow['username'] ;
				$idfr = $friendsrow['user_id'] ;
				events($db_handle,$user_id,"40",$idfr);
				}
			$skill_display = mysqli_query($db_handle, "SELECT p_name from professsion_name WHERE p_id = '$skill_Name' ;");
			$skill_displayrow = mysqli_fetch_array($skill_display) ;
			$skill_id = $skill_displayrow['p_name'] ;
			if(mysqli_error($db_handle)) { echo "Duplicate Entry!"; }
			else { echo "Profession added succesfully!"."+"."<span class='btn-success' id='profession_".$skill_Name."' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".$skill_id."&nbsp 
							<a type='submit' class='btn-success' style='padding-left: 0px; padding-right: 0px;' id='remove_profession' 
							onclick='remove_profession(\"".$skill_Name."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Remove Profession'>
                            <i class='icon-remove'></i></a></span>&nbsp;"; }
			exit ;
			break ;
			
		case 3:
			mysqli_query($db_handle, "DELETE FROM user_profession WHERE user_id='$user_id' AND p_id='$skillID';");
			if(mysqli_error($db_handle)) { echo "Failed to Remove!"; }
			else { echo "Profession Removed succesfully!"; }
			exit ;
			break ;
		   
   }
 }
mysqli_close($db_handle);
?>
