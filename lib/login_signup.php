<?php

function signup(){
	include_once "db_connect.php";
	$firstname = mysql_real_escape_string($_POST['firstname']);
	$lastname = mysql_real_escape_string($_POST['lastname']);
	$email = mysql_real_escape_string($_POST['email']);
	$phone = mysql_real_escape_string($_POST['phone']);
	$username = mysql_real_escape_string($_POST['username']);
	$pas = mysql_real_escape_string($_POST['password']) ;
	$awe = mysql_real_escape_string($_POST['password2']) ;
	
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
	$username = mysql_real_escape_string($_POST['username']);
	$email = mysql_real_escape_string($_POST['email']); 
	$password = mysql_real_escape_string($_POST['password']);
	$response = mysqli_query($db_handle,"select * from user_info where (username = '$username' OR email = '$username') AND password = '$password';") ;
	$num_rows = mysqli_num_rows($response);
	if ( $num_rows){
		header('Location: ninjas.php');
		$responseRow = mysqli_fetch_array($response);
		$_SESSION['user_id'] = $responseRow['user_id'];
		$_SESSION['first_name'] = $responseRow['first_name'] ;
		$_SESSION['email'] = $responseRow['email'];
		$_SESSION['rank'] = $responseRow['rank'];
		exit;
	}
	else {
		header('Location: ./index.php?status=2');
	}
	mysqli_close($db_handle);
}

?>
