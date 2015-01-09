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
    $new_first_name = $_POST['fname'];
    $new_last_name = $_POST['lname'];
    $email = $_POST['email'];
    $new_phone = $_POST['phone'];
    $about = $_POST['about'];
    $town = $_POST['townname'];
    $comp = $_POST['comp'];
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
			mysqli_query($db_handle, "INSERT INTO skill_names (skill_id, skill_name) VALUES (default, '$skill');");
			$id = mysqli_insert_id($db_handle) ;
			mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$user_id', '$id');");
			while ($friendsrow = mysqli_fetch_array($friends)){
				$emails = $friendsrow['email'] ;
				$mail = $friendsrow['username'] ;
				$idfr = $friendsrow['user_id'] ;
				events($db_handle,$user_id,"36",$idfr);
				}
			if(mysqli_error($db_handle)) { echo "Duplicate Entry!";  }
			else { echo "Skill added succesfully!"."+"."<span class='btn-success' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".$skill."&nbsp 
							<a type='submit' class='btn-success' style='padding-left: 0px; padding-right: 0px;' id='remove_skill' 
							onclick='remove_skill(\"".$id."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Remove Skill'>
                            <i class='icon-remove'></i></a></span>&nbsp;"; }
			exit ;
			break ;
			
		case 2:
			mysqli_query($db_handle, "INSERT INTO user_skills (user_id, skill_id) VALUES ('$user_id', '$skill_Name');");
			while ($friendsrow = mysqli_fetch_array($friends)){
				$emails = $friendsrow['email'] ;
				$mail = $friendsrow['username'] ;
				$idfr = $friendsrow['user_id'] ;
				events($db_handle,$user_id,"36",$idfr);
				}
			$skill_display = mysqli_query($db_handle, "SELECT skill_name from skill_names WHERE skill_id = '$skill_Name' ;");
			$skill_displayrow = mysqli_fetch_array($skill_display) ;
			$skill_id = $skill_displayrow['skill_name'] ;
			if(mysqli_error($db_handle)) { echo "Duplicate Entry!"; }
			else { echo "Skill added succesfully!"."+"."<span class='btn-success' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".$skill_id."&nbsp 
							<a type='submit' class='btn-success' style='padding-left: 0px; padding-right: 0px;' id='remove_skill' 
							onclick='remove_skill(\"".$skill_Name."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Remove Skill'>
                            <i class='icon-remove'></i></a></span>&nbsp;"; }
			exit ;
			break ;
			
		case 3:
			mysqli_query($db_handle, "DELETE FROM user_skills WHERE user_id='$user_id' AND skill_id='$skillID';");
			if(mysqli_error($db_handle)) { echo "Failed to Remove!"; }
			else { echo "Skill Removed succesfully!"; }
			exit ;
			break ;
			
		case 4:
			$aboutuser = mysqli_query($db_handle, "SELECT organisation_name, living_town, about_user FROM about_users WHERE user_id = '$user_id' ;") ;
            $aboutuserRow = mysqli_fetch_array($aboutuser); 
            $var4 = $aboutuserRow['organisation_name'] ;
            $var5= $aboutuserRow['living_town'] ;
            $var6 = $aboutuserRow['about_user'] ;
            $detail = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = '$user_id' and email = '$email' ;") ;
            $detailRow = mysqli_fetch_array($detail) ;
            $var1 = $detailRow['first_name'] ;
            $var2 = $detailRow['last_name'] ;
            $var3 = $detailRow['contact_no'] ;
            if ($var1 != $new_first_name) {
				mysqli_query($db_handle, "UPDATE user_info SET first_name='$new_first_name' WHERE user_id='$user_id and email = '$email' ;");
				while ($friendsrow = mysqli_fetch_array($friends)){
					$emails = $friendsrow['email'] ;
					$mail = $friendsrow['username'] ;
					$idfr = $friendsrow['user_id'] ;
					events($db_handle,$user_id,"19",$idfr);
					}
				}
			if ($new_last_name != "") {
				if ($var2 != $new_last_name) {
					mysqli_query($db_handle, "UPDATE user_info SET last_name='$new_last_name' WHERE user_id='$user_id' and email = '$email' ;");
					while ($friendsrow = mysqli_fetch_array($friends)){
						$emails = $friendsrow['email'] ;
						$mail = $friendsrow['username'] ;
						$idfr = $friendsrow['user_id'] ;
						events($db_handle,$user_id,"20",$idfr);
						}
					}
				}
			if ($new_phone != "") {
				if ($var3 != $new_phone) {
					mysqli_query($db_handle, "UPDATE user_info SET contact_no='$new_phone' WHERE user_id='$user_id' and email = '$email' ;");
					while ($friendsrow = mysqli_fetch_array($friends)){
						$emails = $friendsrow['email'] ;
						$mail = $friendsrow['username'] ;
						$idfr = $friendsrow['user_id'] ;
						events($db_handle,$user_id,"21",$idfr);
						}
					}
				}
			if (mysqli_num_rows($aboutuser) != 0) {
				if ($comp != "") {
					if ($var4 != $comp) {
						mysqli_query($db_handle, "UPDATE about_users SET organisation_name='$comp' WHERE user_id='$user_id' ;");
						while ($friendsrow = mysqli_fetch_array($friends)){
							$emails = $friendsrow['email'] ;
							$mail = $friendsrow['username'] ;
							$idfr = $friendsrow['user_id'] ;
							events($db_handle,$user_id,"22",$idfr);
							}
						}
					}
				if ($town != "") {
					if ($var5 != $town) {
						mysqli_query($db_handle, "UPDATE about_users SET living_town='$town' WHERE user_id='$user_id' ;");
						while ($friendsrow = mysqli_fetch_array($friends)){
							$emails = $friendsrow['email'] ;
							$mail = $friendsrow['username'] ;
							$idfr = $friendsrow['user_id'] ;
							events($db_handle,$user_id,"23",$idfr);
							}
						}
					}
				if ($about != "") {
					if ($var6 != $about) {
						mysqli_query($db_handle, "UPDATE about_users SET about_user='$about' WHERE user_id='$user_id' ;");
						while ($friendsrow = mysqli_fetch_array($friends)){
							$emails = $friendsrow['email'] ;
							$mail = $friendsrow['username'] ;
							$idfr = $friendsrow['user_id'] ;
							events($db_handle,$user_id,"24",$idfr);
							}
						}
					}		
				}
				else {
					mysqli_query($db_handle, "INSERT INTO about_users (user_id, organisation_name, living_town, about_user) 
																			VALUES ('$user_id', '$comp', '$town', '$about');") ;
					while ($friendsrow = mysqli_fetch_array($friends)){
						$emails = $friendsrow['email'] ;
						$mail = $friendsrow['username'] ;
						$idfr = $friendsrow['user_id'] ;
						events($db_handle,$user_id,"8",$idfr);
						}
					}
			if (mysqli_error($db_handle)) { echo "Please try again"; }
			else { echo "Updated successfuly"; }
			exit ;
			break ;
			
		case 5:
			while ($friendsrow = mysqli_fetch_array($friends)){
				$emails = $friendsrow['email'] ;
				$mail = $friendsrow['username'] ;
				$idfr = $friendsrow['user_id'] ;
				events($db_handle,$user_id,"25",$idfr);
				}
			echo "Posted succesfully!";
			exit ;
			break ;
		   
   }
 }
mysqli_close($db_handle);
?>
