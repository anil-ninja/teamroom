<?php

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
		header('Location: ./index.php?status=0');
	    }
        }
	else {  
		header('Location: ./index.php?status=1');
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
		$_SESSION['user_id'] = $responseRow['user_id'];
		$_SESSION['first_name'] = $responseRow['first_name'] ;
		$_SESSION['username'] = $responseRow['username'] ;
		$_SESSION['email'] = $responseRow['email'];
		$_SESSION['rank'] = $responseRow['rank'];
		exit;
	}
	else {
		echo "Sorry! Invalid username or password!";      
	}
	mysqli_close($db_handle);
}

?>
