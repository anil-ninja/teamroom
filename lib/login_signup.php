<?php
include_once "../models/rank.php";
include_once '../functions/collapMail.php';
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
		mysqli_query($db_handle,"INSERT INTO user_info(first_name, last_name, email, username, password) VALUES ('$firstname', '$lastname', '$email', '$username', '$pas') ; ") ;		
                $user_create_id = mysqli_insert_id($db_handle);
               // echo $user_create_id ;
                $hash_keyR = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
                mysqli_query($db_handle, "INSERT INTO user_access_aid (user_id, hash_key) VALUES ('$user_create_id', '$hash_keyR');");
                $id_access_id =  mysqli_insert_id($db_handle);
                $hash_keyR = $hash_keyR.".".$id_access_id;
                //echo $hash_keyR ;
                $body = "Hi <b>".$username."</b>,\n Welcome to Collap. \n \n We are building an engaged community of problem solvers in different domains of Science, Technology, Marketing, Economics, Electronics, Electrical, Mechanical, Computer Science, etc. We provide tools, technology and platform to manage projects, host and solve challenges, hosting articles, ideas, etc \n \n
We are excited to have you on-board and there’s just one step to verify if it’s actually your e-mail address: \n \n
http://collap.com/verifyEmail.php?hash_key=".$hash_keyR." \n \n \n
Hugs or bugs, please let us know by replying to this e-mail. \n \n
Welcome again! \n \n 
Thanks, \n
Collap Team";
                
                collapMail($email, "Email Verification From Collap", $body);
                $body2 = "Thanks for joining Collap,  ".$username."! \n \n \n
						  We’re thrilled to have you on board. \n
						  Be sure to save your important account details for future reference: \n \n
						  Your username is: ".$username." \n \n
						  You’ve joined a talented community of professionals dedicated to doing great work. \n
						  And the first step for building your career here is to update profile \n \n
						  http://collap.com/profile.php?username=".$username.". \n \n
						  A successful collapian profile is: \n \n
						  Complete: \n
						  With all information filled out, including your full name and picture \n \n
						  Accurate: \n
						  Featuring information that is true and verifiable \n \n
						  Contact: \n
						  Contact information will help you and other collapian to collaborate and do better. \n
						  Give you Phone no and Email id \n \n \n
						  Thanks again for joining Collap. We’re so happy you’re here! \n \n
						  Thanks, \n 
						  Collap Team" ; 
 ;
                collapMail($email, "complete your profile", $body2);
                
		if(mysqli_error($db_handle)){
			echo "Please Try Again";
		} else {

		$_SESSION['user_id'] = $user_create_id;
		$_SESSION['first_name'] = $firstname ;
		$_SESSION['username'] = $username ;
		$_SESSION['email'] = $email;
		$obj = new rank(mysqli_insert_id($db_handle));
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
	$email = mysqli_real_escape_string($db_handle, $_POST['email']); 
	$password = md5(mysqli_real_escape_string($db_handle, $_POST['password']));
	//echo $password ;
	$response = mysqli_query($db_handle,"select * from user_info where (username = '$username' OR email = '$username') AND password = '$password';") ;
	$num_rows = mysqli_num_rows($response);
	if ( $num_rows){
		//echo "hi";
		//header('Location: ninjas.php');
		$responseRow = mysqli_fetch_array($response);
		$id = $responseRow['user_id'];
		$lastlogintime = $responseRow['last_login'];
		$_SESSION['last_login'] = $lastlogintime ;
		$_SESSION['user_id'] = $id ;
		$_SESSION['first_name'] = $responseRow['first_name'] ;
		$_SESSION['username'] = $responseRow['username'] ;
		$_SESSION['email'] = $responseRow['email'];
		$logintime = date("y-m-d H:i:s") ;
		$obj = new rank($id);
		$new_rank = $obj->user_rank ;
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
