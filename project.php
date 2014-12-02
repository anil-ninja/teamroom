<?php
include_once 'project.inc.php';
include_once 'functions/delete_comment.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
            <title><?= $projttitle ?></title>
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
       <script src="js/content_edit.js"> </script>
        <script src="js/delete_comment_challenge.js" type="text/javascript"> </script>

        <!-- chat box -->
  
  <link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
  <link type="text/css" rel="stylesheet" media="all" href="css/screen.css" />

  <!--[if lte IE 7]>
  <link type="text/css" rel="stylesheet" media="all" href="css/screen_ie.css" />
  <![endif]-->

  <!-- end chat box-->
   </head>
<body>
	<?php include_once 'html_comp/navbar_homepage.php'; ?>
        <div class=" media-body" style="padding-top: 50px;">
            <div class="col-md-2">
            <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
            </div>  
            
            <div class="col-md-6">
                <div class='alert_placeholder'></div>
                <div class="panel-primary" id='panel-cont'>
                    <?php include_once 'html_comp/project_page_project.php'; ?>
                </div>
            </div>
            <div class="col-md-4">
            <div class="col-md-7">
                <?php include_once 'html_comp/project_page_challenge.php'; ?>
            </div>
            <div class="col-md-5" style="padding-top: 20px;">
            <?php include_once 'html_comp/friends.php' ; ?>
             <!--  <?php include_once 'html_comp/project_members.php'; ?> -->
        </div>	
        </div>
    </div>
           <?php //include_once 'html_comp/signup.php'; ?>
        <script>
        $(document).ready(function(){
	$(window).scroll(function(event) {
		if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
			event.preventDefault();
			var dataString = 'proch=10' ;
			$.ajax({
				type: "POST",
				url: "ajax/next_proch.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					$('#prch').append(result);
				}
			});
		}
	});	
	});
	chatBoxes.push('<?= $projttitle ?>');
        </script>
		<?php 
                    if (isset($_SESSION['user_id'])) {
                        include_once 'html_comp/project_talk.php'; 
                 ?>
                        <script>
                            $(document).ready(function(){
                           /*     $("#talkpro").click(function(){
                                    $("#talkprForm").show();
                                    $("#talkformdata").show();
                                    $("#talkformin").show();
                                    $("#talkformdata").scrollTop($('#talkformdata').height()) ;
                                    projecttalk();
                                }); */
                                projecttalk();
                            }); 
                        </script>
                        <script src="js/chat.js"></script>
                        <!-- chat box -->
                        <script type="text/javascript" src="js/chat_box.js"></script>
                        <!-- end Chat box-->
                    <?php 
                        }
                ?>
         <script src="js/content_edit.js"></script> 
        <script src="js/jquery-1.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/ninjas.js"></script>
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
      	$(".text").show();
		$(".editbox").hide();
        </script>     
        </body>
    </html>
<?php
include_once 'html_comp/login_signup_modal.php';
mysqli_close($db_handle);
?>
