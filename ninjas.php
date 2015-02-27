<?php
include_once 'ninjas.inc.php';  
include_once 'functions/delete_comment.php';
include_once 'functions/sharepage.php';
if(!isset($_SESSION['user_id'])){
	header("location: index.php") ;
}
$view = 1 ;
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
	<title>collap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Challenge, Project, Problem solving, problem">
    <?php include_once 'lib/htmt_inc_headers.php'; ?>
  </head>
  <body>
   <?php include_once 'html_comp/navbar_homepage.php'; ?>
   <div class='alert_placeholder'></div>
   <div class='' >
		<div class="row-fluid" style='margin-top: 50px;'>  		
       		<div id='tab1' class="span2" style='margin-left:60px; width:280px;'>
   				<?php 
   					include_once 'html_comp/left_panel_ninjas.php';   
				?>
   			</div>       
         	<div id='tab2' class="span6">
				<div class="panel-primary" id='panel-cont'>
			  		<p id='home-ch'></p>
			 		<p id='home'></p>
	    			<?php 
	    				include_once 'html_comp/ninjas_page.php' ;
	    				echo "<input type='hidden' id='viewchid' value='".$view."'/>"; 
	    			?>
				</div>
			</div>
		 	<div id='tab3' class="span2">
				<?php 
					include_once 'html_comp/right_panel_ninjas.php'  ; 
				?>				
			</div>
			
			<?php 
				include_once 'html_comp/friends.php';  
			?>
		</div>
	</div>	
	
	<?php
 	include_once 'lib/html_inc_footers.php';
	include_once 'html_comp/check.php';  
	?>	
<script>
var width = window.screen.availWidth;
if(width < 980) {
	$("#phoneOPt").append("<a href='#menu-toggle' class='btn btn-default pull-right' id='menu-toggle'><i class='icon-tasks'></i></a>") ;
	$("body").prepend("<div id='wrapper'><div id='sidebar-wrapper'><ul class='sidebar-nav'>" + $("#tab1").html() + "<br/><br/><br/><br/>" + $("#tab3").html() + "</ul></div></div>");
	$('#tab1').remove();
	$('#tab3').remove();
	$("#tab2").attr('class','span12') ;
	$("#nav").attr('style', 'position:absolute;') ;
	$("#step16").attr('style', 'position:relative;top:0px;') ;
	//$("#user1project").attr('style', 'max-height:150px;overflow-y:scroll;') ;
	//$("#user2project").attr('style', 'max-height:150px;overflow-y:scroll;') ;
	//$("#user3project").attr('style', 'max-height:150px;overflow-y:scroll;') ;
	//$("#user4project").attr('style', 'max-height:150px;overflow-y:scroll;') ;
	//$("#user5project").attr('style', 'max-height:150px;overflow-y:scroll;') ;
	//$("#user6project").attr('style', 'max-height:150px;overflow-y:scroll;') ;
} ;
</script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
<script>
	$(window).scroll(function(event) {
		if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
			event.preventDefault();
			$('#panel-cont').append("<div class='loading'><center><img src='img/loading.gif' /></center><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>");
			var dataString = 'chal=6' ;
			var value = parseInt($("#viewchid").val()) ;
			$.ajax({
				type: "POST",
				url: "ajax/get_next.php",
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("<") ;
					if (notice['0'] == 'no data') {
						$('.loading').remove();
						var data = document.getElementById("appendloading") ;
						if(data == null) {
							$('#panel-cont').append("<div id='appendloading'><br/><br/><center style='font-size:24px;'> Whooo... You have read all Posts </center></div>");
						}
					}
					else {
						$('#panel-cont').append(result);
						$('.loading').remove();
						showclass(value) ;
					}
				}
			});
		}
	});
	 
	getallreminders() ; 
</script>
<?php include_once 'html_comp/insert_time.php'   ?>	  
</body>
</html>
