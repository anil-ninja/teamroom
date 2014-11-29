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
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
        <link rel="stylesheet" href="css/bootswatch.css">
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery.js"> </script>
        <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery.autosize.js"></script>
    <!-- script fro challenge comment delete, it is common for all challenges comments.  -->
        <script src="js/delete_comment_challenge.js" type="text/javascript"> </script>
        <script src="js/ninjas.js" type="text/javascript"></script>
        <link type="text/css" href="jquery.simple-dtpicker.css" rel="stylesheet" />
        <script src="js/jquery-1.js"></script>
        <script src="js/chat.js"></script>

    </head>
    <body>
    	<?php include_once 'html_comp/navbar_homepage.php'; ?>
    <div class='alert_placeholder'></div>
    <div class="col-md-3" style="width:260px; padding-top: 50px">
           <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
           </div> 
          <div class=" media-body" style="padding-top: 50px;">
          <div class="col-md-8">
              <div class="panel-primary" id='panel-cont'>
                  <p id='home-ch'></p>
                  <p id='home'></p>
                <div class="list-group-item pull-center"style="margin-top: 20px;"><h5> <strong> All Notices For You</strong></h5>
               <div id="allnotices" class= "list-group"></div></div>
            </div>
          </div>
        <div class="col-md-3">
            <?php include_once 'html_comp/right_panel_ninjas.php'  ; ?>
        </div>
        <div class="col-md-1">
              <?php include_once 'html_comp/friends.php' ; ?>
        </div>
    </div>
    <script>
		getallnotices();	
    </script>
    <script src="js/jquery.js"> </script>
        <script src="js/search.js"> </script>
        <script src="js/date_time.js"></script>
        <script>
            $(window).scroll(function(event) {
                
            if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
                 event.preventDefault();
                var dataString = 'chal=10' ;
                      $.ajax({
                        type: "POST",
                        url: "ajax/get_next.php",
                        data: dataString,
                        cache: false,
                        success: function(result){
                            //alert(result) ;
                            $('#panel-cont').append(result);
                            }
                    }); 
                    }
                }); 
                getallreminders() ;
    </script>
    <script>
    $(".text").show();
    $(".editbox").hide();
    $(".edit-button").hide();
    $(".edit_pic_video_file").hide();
    </script>
    <script src="js/jquery-1.js"></script>
    <script src="date.js"></script>
    <script src="jquery.simple-dtpicker.js"></script>
    <script src="js/chat.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootswatch.js"></script>
    <script src="js/project_page.js"></script>
    <script src="js/content_edit.js"></script>
   <script src="js/date_time.js"></script>
   
   <!-- chat box -->
   <script type="text/javascript" src="js/chat_box.js"></script>
   <!-- end Chat box-->
    </body>
</html>
