<?php
include_once 'project.inc.php';
include_once 'functions/delete_comment.php';
$pro_id = $_GET['project_id'] ;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
            <title><?= $projttitle ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenge, Project, Problem solving, problem">
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
   </head>
<body>
	<?php include_once 'html_comp/navbar_homepage.php'; ?>

    <div class='alert_placeholder'></div>
    <div class="">
        <div class="row-fluid" style='margin-top: 50px;'>         
            <div id='tab4' class="span2 offset1">
                <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
            </div>  
            
            <div id='tab5' class="span6">
                <br>
                
                <?php echo "
			<center>
				      <span class='color strong' style= 'font-family: Tenali Ramakrishna, sans-serif; font-size: 28px;'>
                <p id='project_ti_".$pro_id."' class='text'>" .ucfirst($projttitle) . "
                </p>
              </span>
				      <input type='text' class='editbox' style='width : 90%;' id='project_title_".$pro_id."' value='".$projectttitle."'/>
			</center>
		  ";?>                 
                    <ul class="nav nav-tabs" style="padding: 0;" id="myTab">
                        <li class="active">
                            <a href="#tabProjectData" data-toggle="tab" class="active " id="project_data" style="padding: 10px 5px;">
                                <i class='icon-star'> </i><span>Project</span> 
                            </a>
                        </li>
                        <li>
                            <a href="#tabProjectContent" data-toggle="tab" id="home_project" style="padding: 10px 5px;">
                                <i class='icon-star'> </i><span>Outgoings</span> 
                            </a>
                        </li>
                        <li>
                            <a href="#tabDashboard" data-toggle="tab" id="dashboard_project" style="padding: 10px 5px;">
                                <i class='icon-th-list'> </i><span>Dashboard</span> 
                            </a>
                        </li>
                        <li>
                            <a href="#tabteams" data-toggle="tab" id="teams_project" style="padding: 10px 5px;">
                                <i class='icon-user'><i class='icon-user'></i> </i><span>Teams</span> 
                           </a>
                        </li>
                    </ul>

                    <div class="tab-content" id= 'myTabContent'>
                        <div role="tabpanel" class="tab-pane fade in active" id="tabProjectData">       
                            <?php include_once 'html_comp/project_page_data.php' ; ?>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabProjectContent">
							<div id="home_project_content"></div>
							<div class="panel-primary" id='panel-cont'></div> 
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabDashboard" >
                            <div id="dashboard_project_content"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabteams">
                            <div id="teams_project_content"></div>
                        </div>
                    </div>
                 
            </div>      
            <div id='tab6' class="span2" style='width:290px'>
                <br>
                <?php include_once 'html_comp/right_panel_project.php'; ?>
            </div>	
        </div>
		<?php 
                    if (isset($_SESSION['user_id'])) {
                        include_once 'html_comp/project_talk.php'; 
                        include_once 'html_comp/friends.php'; 
                 ?>
                        <script>
                            $(document).ready(function(){
                                projecttalk();
                            }); 
                        </script>
                    <?php 
                        }
                ?>   
        <?php include_once 'lib/html_inc_footers.php';
        include_once 'html_comp/check.php'; ?>  
<div class='footer'>
		<a href='www.dpower4.com' target = '_blank' ><b>Powered By: </b> Dpower4</a>
		 <p>Making World a Better Place, because Heritage is what we pass on to the Next Generation.</p>
</div>
                 <script>
    $('#home_project').click(function(){
        $('#home_project_content').load('html_comp/project_page_project.php?project_id='+ <?= $pro_id ;?>);       
    });
    $('#dashboard_project').click(function(){
        $('#dashboard_project_content').load('html_comp/project_page_challenge.php?project_id='+ <?= $pro_id ;?>);       
    });
    $('#teams_project').click(function(){
        $('#teams_project_content').load('html_comp/teams_panel_project.php?project_id='+ <?= $pro_id ;?>);        
    });

$("#project_chat_form").hide();
$("#project_chat_data").hide();
$('#scrollFriends').jScrollPane() ;
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
	chatBoxes.push('<?= $pro_id ?>');
        </script>
<script>
var width = window.screen.availWidth;
if(width < 800) {
	$('#tab4').hide();
	$('#tab6').hide();
	$("body").append("<div id='navtab'><div class='nav-btntab'><p class='icon-chevron-right'></p></div><div id='new'></div></div>");
	$("#new").html($("#tab4").html() + $("#tab6").html());
} ;
</script>
<script>
$(function() {
	$('#navtab').stop().animate({'margin-left':'-170px'},1000);

function toggleDivs() {
    var $inner = $("#navtab");
    if ($inner.css("margin-left") == "-170px") {
        $inner.animate({'margin-left': '0'});
		$(".nav-btntab").html('<p class="icon-chevron-left"></p><p class="icon-comment"></p>')
    }
    else {
        $inner.animate({'margin-left': "-170px"}); 
		$(".nav-btntab").html('<p class="icon-chevron-right"></p><p class="icon-comment"></p>')
    }
}
$(".nav-btntab").bind("click", function(){
    toggleDivs();
});

});
</script>
<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="js/graph.js"></script>
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

