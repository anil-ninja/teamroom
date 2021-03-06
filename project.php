<?php
include_once 'project.inc.php';
$pro_id = $_GET['project_id'] ;
 echo "<input type='hidden' id='ProjectIDValue' value='".$pro_id ."'/>" ;
$view = 1 ;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title><?php echo str_replace("<br/>", "", $projttitle) ; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="<?php echo $keywords;?>">
    <meta name="description" content="Challenge, Project, Problem solving, problem">
    <?php include_once 'lib/htmt_inc_headers.php'; ?>
  </head>
  <body>
   <?php include_once 'html_comp/navbar_homepage.php'; ?>
   <div class='alert_placeholder'></div>
   <div class="" >
		<div class="row-fluid" style='margin-top: 50px;'>  		
       		<div id='tab4' class="span2" style='margin-left:50px; width:280px;'>
   				<?php 
   					include_once 'html_comp/left_panel_ninjas.php';   
				?>
   			</div>           
            <div id='tab5' class="span6">
                <br>
                
                <?php echo "
				      <span class='color strong' style= 'font-family: Tenali Ramakrishna, sans-serif; font-size: 32px;'>
                <p id='project_ti_".$pro_id."' class='text'>" .ucfirst($projttitle) . "
                </p>
              </span>
				      <input type='text' class='editbox' style='width : 90%;' id='project_title_".$pro_id."' value='".$projectttitle."'/>
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
                                    <?php if($totalOutgoings != '0') { 
										echo "<span class='badge'>".$totalOutgoings."</span>" ; 
										echo "<input type='hidden' id='viewprchid' value='".$view."'/>";
										}  
									?>
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
                                <span class='badge'><?=$totalTeams ;?></span>
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
            <div id='tab6' class="span2" style='width:260px'>
				<br/>
				<div id='aboutproject'>
                <?php include_once 'html_comp/right_panel_project.php'; ?>
                </div>
                <div id='indexproject'>
                <?php include_once 'html_comp/project_index.php'; ?>
                </div>
            </div>	
        </div>
        <script src="date.js"></script>
		<?php 
			if (isset($_SESSION['user_id'])) {
				include_once 'html_comp/project_talk.php'; 
				include_once 'html_comp/friends.php'; 
				}
		include_once 'lib/html_inc_footers.php';
        include_once 'html_comp/check.php'; ?>  
<script>
	 hidepanel();
    $('#project_data').click(function(){
		hidepanel();       
    });
    $('#home_project').click(function(){
        $('#home_project_content').load('html_comp/project_page_project.php?project_id='+ <?= $pro_id ;?>);
        showpanel();       
    });
    $('#dashboard_project').click(function(){
        $('#dashboard_project_content').load('html_comp/project_page_challenge.php?project_id='+ <?= $pro_id ;?>);
        hidepanel();       
    });
    $('#teams_project').click(function(){
        $('#teams_project_content').load('html_comp/teams_panel_project.php?project_id='+ <?= $pro_id ;?>);
        hidepanel();        
    });

$("#project_chat_form").hide();
$("#project_chat_data").hide();
</script>
<script>
	$(window).scroll(function(event) {
		if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
			event.preventDefault();
			$('#prch').append("<div class='loading'><center><img src='img/loading.gif' /></center><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>");
			var ID = $("#ProjectIDValue").val() ;
			var dataString = 'proch=5' + '&project_id=' + ID ;
			var value = parseInt($("#viewprchid").val()) ;
			$.ajax({
				type: "POST",
				url: "ajax/next_proch.php",
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("<") ;
					if (notice['0'] == 'no data') {
						$('.loading').remove();
						var data = document.getElementById("appendloading") ;
						if(data == null) {
							$('#prch').append("<div id='appendloading'><br/><br/><center style='font-size:24px;'> Whooo... You have read all Posts </center></div>");
						}
					}
					else {
						$('#prch').append(result);
						$('.loading').remove();
						showprclass(value) ;
					}
				}
			});
		}
	});	
	chatBoxes.push('<?= $pro_id ?>');
        </script>
<script>
var width = window.screen.availWidth;
if(width < 980) {
	$("#phoneOPt").append("<a href='#menu-toggle' class='btn btn-default pull-right' id='menu-toggle'><i class='icon-tasks'></i></a>") ;
	$("body").prepend("<div id='wrapper'><div id='sidebar-wrapper'><ul class='sidebar-nav'>" + $("#tab4").html() + "<br/><br/><br/><br/>" + $("#tab6").html() + "</ul></div></div>");
	$('#tab4').remove();
	$('#tab6').remove();
	$("#tab5").attr('class','span12') ;
	$("#nav").attr('style', 'position:absolute;') ;
	$("#step16").attr('style', 'position:relative;top:0px;') ;
} ;
</script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="js/graph.js"></script>
        <!-- jQuery and jQuery UI (REQUIRED) 
        <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
       
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

        <!-- elFinder CSS (REQUIRED) 
        <link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

        <!-- elFinder JS (REQUIRED) 
        <script type="text/javascript" src="js/elfinder.min.js"></script>

        <!-- elFinder translation (OPTIONAL) 
        <script type="text/javascript" src="js/i18n/elfinder.LANG.js"></script>

        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
      	$(".text").show();
		$(".editbox").hide();
        </script>
<?php 
	if (isset($_SESSION['user_id'])) { ?>
  <script>
	$(document).ready(function(){
		projecttalk();
	}); 
</script>   
<?php } 
    include_once 'html_comp/login_signup_modal.php';
    include_once 'html_comp/insert_time.php';
?>
        </body>
    </html>
