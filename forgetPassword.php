<?php 

include_once 'lib/db_connect.php';
include_once "models/rank.php";
$hash_key_access_id = $_GET['hash_key'];
$hash_and_id = explode('.', $hash_key_access_id);
$hash_key = $hash_and_id[0];
$access_aid_id = $hash_and_id[1];

$verify_check = mysqli_query($db_handle, "SELECT user_id FROM user_access_aid WHERE hash_key ='$hash_key' AND id = '$access_aid_id' AND status='0';");
if (mysqli_num_rows($verify_check) == 0) {
    header('location: index.php');
    exit;
}

$accessed_or_not = mysqli_num_rows($verify_check);

    $verify_checkRow = mysqli_fetch_array($verify_check);
    $verify_check_user_id = $verify_checkRow['user_id'];
    if ($accessed_or_not == 1) {
    if (isset($_POST['updatePassword']) && isset($_POST['passwordnewchange1']) && isset($_POST['passwordnewchange2'])) {
        $passnew = mysqli_real_escape_string($db_handle, $_POST['passwordnewchange1']);
        $passnew2 = mysqli_real_escape_string($db_handle, $_POST['passwordnewchange2']);
        if ($passnew == $passnew2) {
            $passnew = md5($passnew);
            mysqli_query($db_handle,"UPDATE user_info SET  password ='$passnew' WHERE user_id = '$verify_check_user_id';");
            mysqli_query ($db_handle, "UPDATE user_access_aid SET status='1' WHERE id = $access_aid_id;");
            $user_info = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = '$verify_check_user_id';");
            $user_infoRow = mysqli_fetch_array($user_info);
            $user_create_id = $user_infoRow['user_id'];
            $firstname = $user_infoRow['first_name'];
            $username = $user_infoRow['username'];
            $email = $user_infoRow['email'];
            if(mysqli_error($db_handle)){
                echo "Please try again";
            } else {
                echo "Password Updated Successfuly";
                session_start();
                $_SESSION['user_id'] = $user_create_id;
		$_SESSION['first_name'] = $firstname ;
		$_SESSION['username'] = $username ;
		$_SESSION['email'] = $email;
		$obj = new rank(mysqli_insert_id($db_handle));
    		$_SESSION['rank'] = $obj->user_rank;
		
                if (isset($_SESSION['first_name'])) {
                    header ('location: ninjas.php');
                } else {
                    header('location: #');
                }
                exit;
            }
            
            
        }
        else {
            echo "Password don't match, Try again";
        }
        //mysqli_close($db_handle);
    }
    else {
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>forgetPassword</title>
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
        <div class="jumbotron">
            <p align='center'>Reset your password</p>
            <div class="alert-placeholder"> </div>
            <?php 
                if ($accessed_or_not == 0) {
                    echo "<p align='center'>Something going wrong here, Please try again</p>";
                }
                else {
            ?>
        <form method='POST' class="form-horizontal" id="form_elem">
            <div class="form-group">
                <div class="col-lg-5">
                    <input type="password" class="form-control" name="passwordnewchange1" id="example" placeholder="password" /><br>
                    <input type="password" class="form-control" name="passwordnewchange2" placeholder="Re-enter password"/><br/><br/>
                    <input type="submit" class="btn btn-primary btn-lg" name = "updatePassword" id="validate" value = "Update">
                </div>
            </div>
        </form>
            <?php   } ?>
        </div>
    <script>

    </script>
    </body>
</html>



