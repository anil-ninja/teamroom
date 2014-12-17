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
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
   </head>
<body>
	<?php include_once 'html_comp/navbar_homepage.php'; ?>
        <div class=" media-body" style="padding-top: 50px;">
            <div class="col-md-1"> </div>
            <div class="col-md-2">
                <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
            </div>  
            <div class="col-md-6">
                <div class='alert_placeholder'></div>
                <div class="panel-primary" id='panel-cont'>
                    <?php include_once 'html_comp/project_page_project.php'; ?>
                </div>
            </div>
            <div class="col-md-3" style='width:290px'>
                
                <?php include_once 'html_comp/project_page_challenge.php'; ?>
            </div>	
        </div>
		<?php 
                    if (isset($_SESSION['user_id'])) {
                        include_once 'html_comp/project_talk.php'; 
                 ?>
                        <script>
                            $(document).ready(function(){
                                projecttalk();
                            }); 
                        </script>
                    <?php 
                        }
                ?>   
        <?php include_once 'lib/html_inc_footers.php'; ?>  
                 <script>
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
	chatBoxes.push('<?= $projttitle ?>');
        </script>
        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
       
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
<?php
include_once 'html_comp/login_signup_modal.php';
 include_once 'html_comp/insert_time.php';
mysqli_close($db_handle);
?>
        </body>
    </html>

