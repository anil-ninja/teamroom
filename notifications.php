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
        <div class="row-fluid" style='margin-top: 50px;'>
            <div id='tab1' class="span2" style='margin-left:60px; width:280px;'>
                <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
            </div>       
            <div id='tab2' class="span6">
                <div class="panel-primary" id='panel-cont'>
                    <p id='home-ch'></p>
                    <p id='home'></p>
                    <div class="list-group-item" style="margin-top: 20px;"><center> <h4> <strong> All Notices For You</strong></h4></center>
                        <div id="allnotices" style="margin-left: 0px; margin-right: 0px;">
                        </div>
                    </div>
                </div>
            </div>
            <div id='tab3' class="span2">
                <?php include_once 'html_comp/right_panel_ninjas.php' ; ?>
            </div>
            <?php include_once 'html_comp/friends.php' ;?>
        </div>
        
        <?php include_once 'lib/html_inc_footers.php'; ?>
<div class='footer'>
		<a href='www.dpower4.com' target = '_blank' ><b>Powered By: </b> Dpower4</a>
		 <p>Making World a Better Place, because Heritage is what we pass on to the Next Generation.</p>
</div>
<script>
var width = window.screen.availWidth;
if(width < 800) {
	$('#tab1').hide();
	$('#tab3').hide();
	$("body").append("<div id='navtab'><div class='nav-btntab'><p class='icon-chevron-right'></p></div><div id='new'></div></div>");
	$("#new").html($("#tab1").html() + $("#tab3").html());
} ;
</script>
<script>
	getallnotices();	
	getallreminders() ;
</script>     
    </body>
</html>
<?php mysqli_close($db_handle); ?>
