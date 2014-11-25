<?php 
include_once 'lib/db_connect.php';
include_once 'ninjas.inc.php';
if(!isset($_SESSION['user_id'])) {
	header('Location:index.php') ;
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>All notifications</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenge, Project, Problem solving, problem, article, collaborate, collaboration">
        <meta name="author" content="Anil">
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">
        <script src="js/jquery.js"> </script>
        <script src="js/search.js"> </script>
        <script src="js/date_time.js"></script>

    </head>
    <body>
    	<?php include_once 'html_comp/navbar_homepage.php'; ?>
    <div class='alert_placeholder'></div>
        <div class="row" style='padding-top: 30px;'>
			<div class='col-md-6'>
				<div class="alert-placeholder"> </div>
				<div id="allnotices"></div>
			</div>
		</div>
    <script>
		getallnotices();	
    </script>
    <script src="js/jquery.js"> </script>
        <script src="js/search.js"> </script>
        <script src="js/date_time.js"></script>
    </body>
</html>
