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
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body>
    	<?php include_once 'html_comp/navbar_homepage.php'; ?>
        
        <div class='alert_placeholder'></div>
        <div class="row-fluid">
            <div class="span2 offset1">
                <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
            </div>       
            <div class="span6">
                <div class="panel-primary" id='panel-cont'>
                    <p id='home-ch'></p>
                    <p id='home'></p>
                    <div class="list-group-item pull-center" style="margin-top: 20px;"><h5> <strong> All Notices For You</strong></h5>
                        <div id="allnotices" class= "list-group" style="margin-left: 0px; margin-right: 0px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="span2">
                <?php include_once 'html_comp/right_panel_ninjas.php'  ;
                     include_once 'html_comp/friends.php' ; ?>
            </div>
        </div>
        
        <?php include_once 'lib/html_inc_footers.php'; ?>
        <script>
    		getallnotices();	
        </script>
        <script>
            getallreminders() ;
        </script>     
    </body>
</html>
