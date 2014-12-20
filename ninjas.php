<?php
include_once 'ninjas.inc.php';  
include_once 'functions/delete_comment.php';
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
    <meta name="author" content="Anil">
    <?php include_once 'lib/htmt_inc_headers.php'; ?>
  </head>
  <body>
   <?php include_once 'html_comp/navbar_homepage.php'; ?>
   <div class='alert_placeholder'></div>
   
   <div class="container" style="margin-top:60px;">
		<div class="row-fluid">  		
       		<div id='tab2' class="span2 offset1">
   				<?php 
   					include_once 'html_comp/left_panel_ninjas.php';   
				?>
   			</div>       
         	<div id='tab3' class="span7">
				<div class="panel-primary" id='panel-cont'>
			  		<p id='home-ch'></p>
			 		<p id='home'></p>
	    			<?php 
	    				include_once 'html_comp/ninjas_page.php' ;
	    				echo "<input type='hidden' id='viewchid' value='".$view."'/>"; 
	    			?>
				</div>
			</div>
		 	<div id='tab4' class="span2">
				<?php 
					include_once 'html_comp/right_panel_ninjas.php'  ; 
				?>				
			</div>
			
			<?php 
				include_once 'html_comp/friends.php';  
			?>
		</div>
	</div>	
	<?php include_once 'lib/html_inc_footers.php'; ?>	
<script>
var width = window.screen.availWidth;
if(width < 800) {
	$('#tab1').remove();
	$('#tab4').hide();
	$('#tab2').hide();
	$("body").append("<div id='navtab'><div class='nav-btntab'><p class='glyphicon glyphicon-chevron-right'></p></div><div id='new'></div></div>");
	$("#new").html($("#tab2").html() + $("#tab4").html());
} ;
</script>
<script>
$(function() {
	$('#navtab').stop().animate({'margin-left':'-170px'},1000);

function toggleDivs() {
    var $inner = $("#navtab");
    if ($inner.css("margin-left") == "-170px") {
        $inner.animate({'margin-left': '0'});
		$(".nav-btntab").html('<p class="glyphicon glyphicon-chevron-left"></p><p class="glyphicon glyphicon-comment"></p>')
    }
    else {
        $inner.animate({'margin-left': "-170px"}); 
		$(".nav-btntab").html('<p class="glyphicon glyphicon-chevron-right"></p><p class="glyphicon glyphicon-comment"></p>')
    }
}
$(".nav-btntab").bind("click", function(){
    toggleDivs();
});

});
</script>
	<script>
	$(window).scroll(function(event) {
    if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
         event.preventDefault();
         $('#panel-cont').append("<div class='loading'><center><img src='img/loading.gif' /></center><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>");
         var dataString = 'chal=10' ;
         var value = parseInt($("#viewchid").val()) ;
			$.ajax({
				type: "POST",
				url: "ajax/get_next.php",
				data: dataString,
				cache: false,
				success: function(result){
					$('#panel-cont').append(result);
					$('.loading').remove();
					showclass(value) ;
				}
			});
		}
	}); 
getallreminders() ; 
	</script>
<?php include_once 'html_comp/insert_time.php'   ?>	  
</body>
</html>
<?php
mysqli_close($db_handle);
?>
