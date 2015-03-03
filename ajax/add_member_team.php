<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/image_resize.php';
include_once '../functions/collapMail.php';
if ($_POST['email']) {
    $team_name = $_POST['name'];
    $user_id = $_SESSION['user_id'] ;
    $username = $_SESSION['username'] ;
    $email = $_POST['email'];
    $pro_id = $_POST['id'] ;
    $case = $_POST['case'] ;
    $info =  mysqli_query($db_handle, "select * from projects where project_id = '$pro_id' ;") ;
	$inforow = mysqli_fetch_array($info) ;
	$title = $inforow['project_title'] ;
    if($case == 1) {
		$respo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE email = '$email';");
		if (mysqli_num_rows($respo) > 0) {
			$responserow = mysqli_fetch_array($respo);
			$uid = $responserow['user_id'];
			$uname = $responserow['username'];
			$rank = $responserow['rank'];
			$firstname = $responserow['first_name'];
			$lastname = $responserow['last_name'];
			$already_member = mysqli_query($db_handle, "SELECT user_id FROM teams WHERE user_id = '$uid' AND project_id = '$pro_id' AND team_name = '$team_name' ;");
			if (mysqli_num_rows($already_member) > 0) {
				mysqli_query($db_handle, "UPDATE teams SET member_status = '1' where user_id = '$uid' AND project_id = '$pro_id' AND team_name = '$team_name' ;") ;
			} 
			else { 
				$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username, b.first_name, b.last_name from teams as a join user_info as b where a.project_id = '$pro_id' and
										a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
				while ($memrow = mysqli_fetch_array($members)){
					$emails = $memrow['email'] ;
					$mail = $memrow['username'] ;
					$userFirstName = $memrow['first_name'] ;
					$userLastName = $memrow['last_name'] ;
					$body2 = "<h2>Add Member in Team</h2><p>Hi ".ucfirst($userFirstName)." ".ucfirst($userLastName).",</p>
<p>A new member has been added in team ".$team_name.".</p>
<p>".$team_name." has a new member ".$uname." in project ".ucfirst($title)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
					collapMail($emails, "Member Added IN Team", $body2);
				}
				mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, project_id) VALUES ('$uid', '$team_name', '$pro_id');");
				events($db_handle,$user_id,"7",$pro_id);
				involve_in($db_handle,$user_id,"7",$pro_id);
				$body2 = "<h2>Added as Member in Team</h2><p>Hi ".ucfirst($firstname)." ".ucfirst($lastname).",</p>
<p>".$username." has added you as member in team ".$team_name." in project ".ucfirst($title)."</p>
<table><tr><td class='padding'><p><a href='http://collap.com/project.php?project_id=".$pro_id."' class='btn-primary'>Click Here to View</a></p>" ;
				collapMail($email, "Added IN Team", $body2);	
			}
			$data = "<div class='span4' style=' margin:4px; background : rgb(240, 241, 242);'>
						<a type='submit' class='btn-link badge pull-right' id='remove_member' onclick='remove_member(\"".$pro_id."\", \"".$team_name."\", \"".$uid."\");' 
							data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Teammate'><span class='icon-remove'></span>
						</a>
						<a href ='profile.php?username=".$uname."'>
                           <div class ='span2'>
                              <img src='".resize_image("uploads/profilePictures/$uname.jpg", 30, 30, 2)."'  style='width:30px; height:30px;' onError=this.src='img/default.gif'>
                          </div>
                          <div class = 'span7' style='font-size:10px;'>
                              <span class='color pull-left' id='new_added'>".ucfirst($firstname)." ".ucfirst($lastname)."</span><br/>
                              <span style='font-size:10px;'>".$rank."</span>
                          </div>
                       </a>
                    </div>" ;
			if(mysqli_error($db_handle)) { echo "Failed to Add Member!"; }
			else { echo "Member Added succesfully!"."|+".$data ; }		
		} 
		else { 
			echo "Member Not Registered Yet" ;
		}
	}
	else {
		$time = date("y-m-d H:i:s") ;
		mysqli_query($db_handle, "UPDATE teams SET member_status = '2', leave_team = '$time' WHERE team_name = '$team_name' AND project_id = '$pro_id' AND user_id = '$email' ;");
		if(mysqli_error($db_handle)) { echo "Failed to Remove Member!"; }
		else { echo "Member Removed succesfully!"; }			
	}
}
else { echo "Invalid parameters!"; }
mysqli_close($db_handle);
?>
