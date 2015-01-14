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
					events($db_handle,$user_id,"15",$pro_id);
					involve_in($db_handle,$user_id,"15",$pro_id); 
					mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, project_id) VALUES ('$uid', '$team_name', '$pro_id');");
					$members = mysqli_query($db_handle, "select DISTINCT a.user_id, b.email, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and
											a.user_id != '$user_id' and a.user_id = b.user_id ;") ;
					while ($memrow = mysqli_fetch_array($members)){
						$emails = $memrow['email'] ;
						$mail = $memrow['username'] ;
						$body2 = "Hi, ".$mail." \n \n ".$username." add new member in team (".$team_name."). View new member profile at \n
 http://collap.com/profile.php?username=".$uname ;
						collapMail($emails, "Member Added IN Team", $body2);
						}
					}
			$data = "<div class='span4' style=' margin:4px; background : rgb(240, 241, 242);'>
						<a type='submit' class='btn-link badge pull-right' id='remove_member' onclick='remove_member(\"".$pro_id."\", \"".$team_name."\", \"".$uid."\");' 
							data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Teammate'><span class='icon-remove'></span>
						</a>
						<a href ='profile.php?username=".$uname."'>
                           <div class ='span2'>
                              <img src='".resize_image("uploads/profilePictures/$uname.jpg", 30, 30)."'  style='width:30px; height:30px;' onError=this.src='img/default.gif'>
                          </div>
                          <div class = 'span7' style='font-size:10px;'>
                              <span class='color pull-left' id='new_added'>".ucfirst($firstname)." ".ucfirst($lastname)."</span><br/>
                              <span style='font-size:10px;'>".$rank."</span>
                          </div>
                       </a>
                    </div>" ;
			if(mysqli_error($db_handle)) { echo "Failed to Add Member!"; }
			else { echo "Member Added succesfully!"."+".$data ; }		
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
    else echo "Invalid" ;
?>
