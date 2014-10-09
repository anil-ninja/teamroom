<?php
include_once 'project.inc.php';
include_once 'functions/delete_comment.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
            <title>Projects</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Billing, Sharing, budget">
        <meta name="author" content="Anil">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootswatch.css">
        <script type="text/javascript" src="js/jquery.autosize.js"></script>
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery.js"> </script>
        <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
        <style>
            body {
                padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
            }             
        </style>

        <script type="text/javascript" src="js/jquery.autosize.js"></script>

            <style>
            body {
                    padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
                }             
                .editbox{
                            display:none
                    }
                    td{
                            padding:5px;
                    }
                    .editbox{

                            background-color:#ffffcc;
                            border:solid 1px #000;
                            padding:4px;
                    }
                    .edit_tr:hover{
                            background:url(edit.png) right no-repeat #80C8E5;
                            cursor:pointer;
                    }             
            </style>
        <script src="js/content_edit.js"> </script>
        <script src="js/project.js"></script>
        <script src="js/delete_comment_challenge.js" type="text/javascript"> </script>
        <script type="text/javascript">
           
    </script>
    </head>
    <body>
       <?php include_once 'html_comp/navbar_homepage.php'; ?>

        <div class="container-fluid">
            <div class="row-fluid">
            
                <div class="col-xs-12 col-sm-5">
                    <div class="row" style="visibility: visible; position: relative;">
                       <?php include_once 'html_comp/project_page_project.php'; ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <div class="row" style="visibility: visible; position: relative;">
					   <?php include_once 'html_comp/project_page_challenge.php'; ?>
				    </div>
                </div>	
            <div class="col-lg-2" STYLE="font-size: 11pt;">
				<?php   include_once 'html_comp/right_panel_project.php';      ?>
            </div> 
    </div>
</div>
       <script src="js/jquery-1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootswatch.js"></script>
    <script src="js/poject_page.js"></script>
        </body>
    </html>
<?php
mysqli_close($db_handle);
?>
