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

    <div class='alert_placeholder'></div>
    <div class="">
        <div class="row-fluid" style="margin-top:60px;">         
            <div id='tab2' class="span2 offset1">
                <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
            </div>  
            
            <div class="span6">
                <br>
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                    <ul class="nav nav-tabs" style="padding: 0;">
                        <li class="active">
                            <a href="#tabProject" data-toggle="tab" class="active " id="home_project" style="padding: 10px 5px;">
                                <i class='icon-star'> </i>Project Detail 
                            </a>
                        </li>
                        <li>
                            <a href="#tabDashboard" data-toggle="tab" id="dashboard_project" style="padding: 10px 5px;">
                                <i class='icon-th-list'> </i>Project Dashboard 
                            </a>
                        </li>
                        <li>
                            <a href="#tabteams" data-toggle="tab" id="teams_project" style="padding: 10px 5px;">
                                <i class='icon-user'><i class='icon-user'></i> </i>Teams 
                           </a>
                        </li>
                    </ul>

                    <div class="tab-content" >
                        <div role="tabpanel" class="row tab-pane active" id="tabProject">       
                            <?php include_once 'html_comp/project_page_project.php'; ?>
                            <div class="panel-primary" id='panel-cont'>
                            </div>
                        </div>
                        <div role="tabpanel" class="row tab-pane" id="tabDashboard" >
                            <div id="dashboard_project_content"></div>
                        </div>
                        <div role="tabpanel" class="row tab-pane" id="tabteams">
                            <div id="teams_project_content"></div>
                        </div>
                    </div>
                </div>
            </div>

                
                
            <div class="span2" style='width:290px'>
                <br>
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

$(document).ready(function(){
    $('#dashboard_project').click(function(){
        $('#dashboard_project_content').load('html_comp/project_page_challenge.php');        
    });
    $('#teams_project').click(function(){
        $('#teams_project_content').load('html_comp/teams_panel_project.php');        
    });
});



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
//include_once 'html_comp/login_signup_modal.php';
 include_once 'html_comp/insert_time.php';
mysqli_close($db_handle);
?>
        </body>
    </html>

