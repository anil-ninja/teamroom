<?php
include_once "../models/rank.php";
function signup(){
	include_once "db_connect.php";
	$firstname = mysqli_real_escape_string($db_handle, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($db_handle, $_POST['lastname']);
	$email = mysqli_real_escape_string($db_handle, $_POST['email']);
	$phone = mysqli_real_escape_string($db_handle, $_POST['phone']);
	$username = mysqli_real_escape_string($db_handle, $_POST['username']);
	$pas = mysqli_real_escape_string($db_handle, $_POST['password']) ;
	$awe = mysqli_real_escape_string($db_handle, $_POST['password2']) ;
	
	if ( $pas == $awe ) {
            $already_registered = mysqli_query($db_handle, "SELECT email, username FROM user_info WHERE email = '$email' OR username = '$username';");
            $already_registered_email = mysqli_fetch_array($already_registered);
            $already_registered_email['email'] = mysqli_num_rows($already_registered);
            $already_registered_email['username'] = mysqli_num_rows($already_registered);
            if ($already_registered_email['email'] != 0) {
                header('Location: ./index.php?status=3');
            }
            elseif ($already_registered_email['username'] != 0) {
                header('Location: ./index.php?status=4');
            }
            else {
		mysqli_query($db_handle,"INSERT INTO user_info(first_name, last_name, email, contact_no, username, password) VALUES 
				('$firstname', '$lastname', '$email', '$phone', '$username', '$pas') ; ") ;
		if(mysqli_error($db_handle)){
			echo "Please try again";
		} else {

		$_SESSION['user_id'] = mysqli_insert_id($db_handle);
		$_SESSION['first_name'] = $firstname ;
		$_SESSION['username'] = $username ;
		$_SESSION['email'] = $email;
		$obj = new rank(mysqli_insert_id($db_handle));
    	//echo $obj->user_rank;
		$_SESSION['rank'] = $obj->user_rank;
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
	$password = mysqli_real_escape_string($db_handle, $_POST['password']);
	$response = mysqli_query($db_handle,"select * from user_info where (username = '$username' OR email = '$username') AND password = '$password';") ;
	$num_rows = mysqli_num_rows($response);
	if ( $num_rows){
		//echo "hi";
		//header('Location: ninjas.php');
		$responseRow = mysqli_fetch_array($response);
		$id = $responseRow['user_id'];
		$lastlogintime = $responseRow['last_login'];
		$logintime = date("y-m-d H:i:s") ;
		mysqli_query($db_handle,"UPDATE user_info SET last_login = '$logintime' where user_id = '$id' ;" ) ;
		$_SESSION['user_id'] = $id ;
		$_SESSION['first_name'] = $responseRow['first_name'] ;
		$_SESSION['username'] = $responseRow['username'] ;
		$_SESSION['email'] = $responseRow['email'];
		$obj = new rank($id);
		$_SESSION['rank'] = $obj->user_rank;
		exit;
	}
	else {
		echo "Sorry! Invalid username or password!";      
	}
	mysqli_close($db_handle);
}

?>
