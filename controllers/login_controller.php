<?php

session_start();
include_once "../lib/login_signup.php";
$request = "";
if(isset($_POST['request']))
	$request = $_POST['request'];

switch($request){
	case "login":
			login();
			break;
	case "Signup":
			signup();   
			break;
	
	
	}
    if(isset($_POST['updatePassword'])) {
	$update_pass = $_POST['updatePassword']; 
        $passnew = mysqli_real_escape_string($db_handle, $_POST['passwordnew']);
	$passnew2 = mysqli_real_escape_string($db_handle, $_POST['passwordnew2']);
        if ($passnew == $passnew2) {
            $passnew = md5($passnew);
            mysqli_query($db_handle,"UPDATE user_info SET  password ='$passnew' WHERE email = $forget_email;");
        
            if(mysqli_error($db_handle)){
                echo "Please try again";
            } else {
                echo "Password Updated Successfuly";
                header('location: index.php');
                
            }
        }
        mysqli_close($db_handle);
    }
?>
	
