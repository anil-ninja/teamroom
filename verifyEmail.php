<?php
include_once "lib/db_connect.php";
include_once "models/rank.php";

$url_value = $_GET['hash_key'];
$hash_key_access_id = explode('.', $url_value);
$hash_key= $hash_key_access_id[0];
$user_access_aid = $hash_key_access_id[1];

$verify_check = mysqli_query($db_handle, "SELECT user_id FROM user_access_aid WHERE hash_key ='$hash_key' AND id = '$user_access_aid' AND status = 0;");
$accessed_or_not = mysqli_num_rows($verify_check);
if ($accessed_or_not == 1) {
    $verify_checkRow = mysqli_fetch_array($verify_check);
    $verify_check_user_id = $verify_checkRow['user_id'];
    mysqli_query ($db_handle, "UPDATE user_access_aid SET status='1' WHERE user_id = $verify_check_user_id;");
    $response = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = $verify_check_user_id;") ;
	$num_rows = mysqli_num_rows($response);
	if ($num_rows == 1){
            session_start();
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
		//exit;
	}
	mysqli_close($db_handle);
}
else {
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>verifyEmail</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenge, Project, Problem solving, problem, article, collaborate, collaboration">
        <meta name="author" content="Anil">
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">

    </head>
    <body>
    <div class="navbar navbar-default navbar-fixed-top">
        <div>
            <div class="col-md-2 navbar-header">
                 <a class="brand" style='font-size:16pt; color: #fff; font-weight: bold;' href="index.php">
                 <img src ='img/collap.gif' style="width:70px;">collap</a>
            </div>
            <div class="span3 pull-right">
                <ul class="list-inline">
                    <li><p style='font-size:9pt; color:#fff;'>Powered By : </p></li>
                    <li><a class="btn-link" style='font-size:12pt; color: #fff; font-weight: bold;' href="http://dpower4.com/" target="_blank">Dpower4.com</a></li>
                </ul>
            </div>
        </div>
    </div>
        <div class=" media-body" style="padding-top: 50px;"></div>
        <div class="jumbotron">
            <?php 
                if ($accessed_or_not == 0) {
                    echo "<p align='center'>Something going wrong, Please try again<br>
                    <a href = 'index.php'>Go Back</a></p>";
                }
                else {
                    
                    if (isset($_SESSION['first_name'])) {
                        echo "<p align='center'>Your Email and account has been succussfully verified. You are redirected to your home page after 10 seconds<br>
                    Or <a href = 'ninjas.php'>Click Here</a></p>";
                        header("refresh:10;url=ninjas.php");
                    }
                }
            ?>
            
        </div>
<?php mysqli_close($db_handle); ?>
    </body>
</html>
