<?php 
include_once 'lib/db_connect.php';
$hash_key_access_id = $_GET['hash_key'];
$hash_and_id = explode('.', $hash_key_access_id);
$hash_key = $hash_and_id[0];
$access_aid_id = $hash_and_id[1];
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
            <p>Reset your password</p>
            <div class="alert-placeholder"> </div>
        <form id="emailForm" class="form-horizontal">
            <div class="form-group">
                <div class="col-lg-5">
                    <input type="password" class="form-control" style="width: 100%" id="passwordnew" placeholder="New Password" /><br>
                    <input type="password" class="form-control" style="width: 100%" id="passwordnew2" placeholder="Re-enter password"/><br/><br/>
                    <input type="submit" class="btn btn-primary btn-lg" name = "updatePassword" value = "Update" onclick="validadeUpdatePasswordOnSubmit()">
                </div>
            </div>
        </form>
    </div>
        <script type="text/javascript" src="js/signupValidation.js"></script>
    </body>
</html>



