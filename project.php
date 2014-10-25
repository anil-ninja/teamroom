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
        <meta name="description" content="Challenge, Project, Problem solving, problem">
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
                padding-top: 70px; /* 60px to make the container go all the way to the bottom of the topbar */
            }             
        </style>

        <script type="text/javascript" src="js/jquery.autosize.js"></script>
            <style>
            body {
                    padding-top: 70px; /* 60px to make the container go all the way to the bottom of the topbar */
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
   </head>
    <body>
       <?php include_once 'html_comp/navbar_homepage.php'; ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<div class='alert_placeholder'></div>
            <div class="col-lg-3" STYLE="font-size: 11pt;">
				<?php   include_once 'html_comp/left_panel_ninjas.php';      ?>
            </div> 
                <div class="col-lg-6">
                    <div class="panel-primary" id="prch">
                       <?php include_once 'html_comp/project_page_project.php'; ?>
                    </div>
                </div>
                <div class="col-lg-3">
						
					   <?php include_once 'html_comp/project_page_challenge.php'; ?>
                </div>	
           </div>
</div>
       <script src="js/jquery-1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/ninjas.js"></script>
    <script src="js/bootswatch.js"></script>
    <script src="js/project_page.js"></script>
     <script src="js/date_time.js"></script>




        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

        <!-- elFinder JS (REQUIRED) -->
        <script type="text/javascript" src="js/elfinder.min.js"></script>

        <!-- elFinder translation (OPTIONAL) -->
        <script type="text/javascript" src="js/i18n/elfinder.LANG.js"></script>

        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            $().ready(function() {
                var temp = "<?php echo $title."_".$pro_id; ?>";
                var elf = $('#elfinder').elfinder({
                    url : 'php/connector.php?project_fd='+temp  // connector URL (REQUIRED)
                    // lang: 'ru',             // language (OPTIONAL)
                }).elfinder('instance');
            });
        </script>

        </body>
    </html>
<?php
mysqli_close($db_handle);
?>
