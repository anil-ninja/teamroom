<?php
include_once "../models/rank.php";
include_once '../functions/collapMail.php';
include_once '../functions/delete_comment.php';
function signup(){
	include_once "db_connect.php";
	$firstname = mysqli_real_escape_string($db_handle, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($db_handle, $_POST['lastname']);
	$email = mysqli_real_escape_string($db_handle, $_POST['email']);
	//$phone = mysqli_real_escape_string($db_handle, $_POST['phone']);
	$username = mysqli_real_escape_string($db_handle, $_POST['username']);
	$pas = mysqli_real_escape_string($db_handle, $_POST['password']) ;
	$awe = mysqli_real_escape_string($db_handle, $_POST['password2']) ;
	
	if ( $pas == $awe ) {
            $email_already_registered = mysqli_query($db_handle, "SELECT email FROM user_info WHERE email = '$email';");
            $email_exists = mysqli_num_rows($email_already_registered) ;
            $username_already_registered = mysqli_query($db_handle, "SELECT username FROM user_info WHERE username = '$username';");
            $username_registered = mysqli_num_rows($username_already_registered);
            if ($email_exists != 0) {
                //header('Location: ./index.php?status=3');
                echo "User is reistered with this Email,<br>
                      Try different email or Please Sign In";
            }
            elseif ($username_registered != 0) {
                //header('Location: ./index.php?status=4');
                echo "User is registered with this username,<br>
                    Try different username or Please Sign In";
            }
            else {
				$pas = md5($pas);
				$logintime = date("y-m-d H:i:s") ;
		mysqli_query($db_handle,"INSERT INTO user_info(first_name, last_name, email, username, password, last_login, registeration_time) VALUES ('$firstname', '$lastname', '$email', '$username', '$pas', '$logintime', '$logintime') ; ") ;		
                $user_create_id = mysqli_insert_id($db_handle);
               // echo $user_create_id ;
                $hash_keyR = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
                mysqli_query($db_handle, "INSERT INTO user_access_aid (user_id, hash_key) VALUES ('$user_create_id', '$hash_keyR');");
                $id_access_id =  mysqli_insert_id($db_handle);
                $hash_keyR = $hash_keyR.".".$id_access_id;
                //echo $hash_keyR ;
                $body = file_get_contents('../html_comp/mailheader.php')."<body bgcolor='#f6f6f6'><table class='body-wrap'><tr><td></td><td class='container' bgcolor='#FFFFFF'>
<div class='content'>
<table><tr><td><img style='width:108px' src = 'http://collap.com/img/collap.gif'/><i style='font-size:58px;'>collap.com</i></td></tr><tr><td><p>Hi ".ucfirst($username).",</p>
<p>Welcome to Collap. We are building an engaged community of problem solvers in different domains of Science, Technology, Marketing, Economics, Electronics, Electrical, Mechanical, Computer Science, etc. We provide tools, technology and platform to manage projects, host and solve challenges, hosting articles, ideas, etc</p>
<p>We are excited to have you on-board and there’s just one step to verify if it’s actually your e-mail address:</p>
<table><tr><td class='padding'><p><a href='http://collap.com/verifyEmail.php?hash_key=".$hash_keyR."' class='btn-primary'>Click Here to Verify Your Email</a></p></td></tr></table>
<p>Hugs or bugs, please let us know by replying to this e-mail. Welcome again!</p>
<p>Thanks,</p>
<p>Collap Team</p>
<p><a href='http://twitter.com/collapcom'>Follow @collapcom on Twitter</a></p>
</td></tr></table></div></td><td></td></tr></table></body></html>" ;
                
                collapMail($email, "Email Verification From Collap", $body);
                $body2 = file_get_contents('../html_comp/mailheader.php')."<body bgcolor='#f6f6f6'><table class='body-wrap'><tr><td></td><td class='container' bgcolor='#FFFFFF'>
<div class='content'><table><tr><td><img style='width:108px' src = 'http://collap.com/img/collap.gif'/><i style='font-size:58px;'>collap.com</i></td></tr><tr><td>
<h2>Thanks for joining Collap</h2><p>Hi ".ucfirst($username).",</p>
<p>We’re thrilled to have you on board. Be sure to save your important account details for future reference:</p>
<p>Your username is: ".$username."</p>
<p>You’ve joined a talented community of professionals dedicated to doing great work. The first step for building a successfull collaborative network is to update your profile</p>
<table><tr><td class='padding'><p><a href='http://collap.com/profile.php?username=".$username."' class='btn-primary'>Click Here to Update Your Profile</a></p></td></tr></table>
<p>Remember the following for your profile</p>
<ul>
	<li>Complete:<p>With all information filled out, including your full name and picture</p></li>
	<li>Accurate:<p>Featuring information that is true and verifiable</p></li>
	<li>Contact:<p>Contact information will help you and other collapian to collaborate and do better. Give you Phone no and Email id	</p></li>
<p>Thanks,</p>
<p>Collap Team</p>
<p><a href='http://twitter.com/collapcom'>Follow @collapcom on Twitter</a></p></td></tr></table>
</div>
</td><td></td></tr></table></body></html>" ; 

              collapMail($email, "complete your profile", $body2);
		if(mysqli_error($db_handle)){
			echo "Please Try Again";
		} else {

		$_SESSION['user_id'] = $user_create_id;
		$_SESSION['first_name'] = $firstname ;
		$_SESSION['username'] = $username ;
		$_SESSION['email'] = $email;
		$_SESSION['last_login'] = $logintime ;
		$newid = mysqli_insert_id($db_handle) ;
		$obj = new rank($newid);
    	//echo $obj->user_rank;
		$_SESSION['rank'] = $obj->user_rank;
		//header('Location: ../profile.php') ;
		exit;
		}
		//header('Location: ./index.php?status=0');
	    }
        }
	else {  
		//header('Location: ./index.php?status=1');
		echo "Password do not match, Try again";
        }
	mysqli_close($db_handle);
}

function login(){
	include_once "db_connect.php";
	$username = mysqli_real_escape_string($db_handle, $_POST['username']);
	if(isset($_POST['email']))
		$email = mysqli_real_escape_string($db_handle, $_POST['email']); 
	$password = md5(mysqli_real_escape_string($db_handle, $_POST['password']));
	//echo $password ;
	$response = mysqli_query($db_handle,"select * from user_info where (username = '$username' OR email = '$username') AND password = '$password';") ;
	$num_rows = mysqli_num_rows($response);
	if ( $num_rows){
		$responseRow = mysqli_fetch_array($response);
		$id = $responseRow['user_id'];
		$rank = $responseRow['rank'];
		$lastlogintime = $responseRow['last_login'];
		$_SESSION['last_login'] = $lastlogintime ;
		$obj = new rank($id);
		$new_rank = $obj->user_rank ;
		if($new_rank != $rank) {
			$userProjects = mysqli_query($db_handle, "(SELECT a.email, a.username, a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
												where a.user_id = '$id' and a.team_name = b.team_name and b.user_id != '$id')
												as b where a.user_id = b.user_id )
												UNION
												(select a.email, a.username, a.user_id FROM user_info as a join known_peoples as b
												where b.requesting_user_id = '$id' and a.user_id = b.knowning_id and b.status != '4')
												UNION
												(select a.email, a.username, a.user_id FROM user_info as a join known_peoples as b
												where b.knowning_id = '$id' and a.user_id = b.requesting_user_id and b.status = '2') ;");
			if (mysqli_num_rows($userProjects) != 0 ) {
				while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
					$friendFirstName = $userProjectsRow['email'];
					$usernameFriends = $userProjectsRow['username'];
					$useridFriends = $userProjectsRow['user_id'];
					events($db_handle,$id,"18",$useridFriends) ;
					$body2 = file_get_contents('../html_comp/mailheader.php')."<body bgcolor='#f6f6f6'><table class='body-wrap'><tr><td></td><td class='container' bgcolor='#FFFFFF'>
<div class='content'><table><tr><td><img style='width:108px' src = 'http://collap.com/img/collap.gif'/><i style='font-size:58px;'>collap.com</i></td></tr><tr><td>
<h2>Rank Updated</h2><p>Hi ".ucfirst($usernameFriends).",</p>
<p>".$username."'s rank has been Updated to ".$new_rank.".</p>
<table><tr><td class='padding'><p><a href='http://collap.com/profile.php?username=".$username."' class='btn-primary'>Click Here to View</a></p></td></tr><tr><td>
<p> Lets Collaborate!!! Because Heritage is what we pass on to the Next Generation.</p></td></tr></table>
<p>Thanks,</p><p>Collap Team</p>
<p><a href='http://twitter.com/collapcom'>Follow @collapcom on Twitter</a></p></td></tr></table>
</div>
</td><td></td></tr></table></body></html>" ;
					collapMail($friendFirstName, "Rank Updated ", $body2);
				}
			}
		}
		$_SESSION['user_id'] = $id ;
		$_SESSION['first_name'] = $responseRow['first_name'] ;
		$_SESSION['username'] = $responseRow['username'] ;
		$_SESSION['email'] = $responseRow['email'];
		$logintime = date("y-m-d H:i:s") ;
		mysqli_query($db_handle,"UPDATE user_info SET last_login = '$logintime', rank = '$new_rank' where user_id = '$id' ;" ) ;
		//$obj = new rank($id);
		$_SESSION['rank'] = $obj->user_rank;
		exit;
	}
	else {
		echo "Sorry! Invalid username or password!";      
	}
	mysqli_close($db_handle);
}

?>
