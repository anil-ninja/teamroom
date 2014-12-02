<?php
include_once 'ninjas.inc.php';  
include_once 'functions/delete_comment.php';
if(!isset($_SESSION['user_id'])){
	header("location: index.php") ;
}
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
	<title>collap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Challenge, Project, Problem solving, problem">
    <meta name="author" content="Anil">
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
	<link type="text/css" href="jquery.simple-dtpicker.css" rel="stylesheet" />
	<script src="js/jquery-1.js"></script>
    <script src="js/chat.js"></script>
    <script src="js/bootbox.js"></script>
	
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
   <div class='alert_placeholder'></div>
   <div class=" media-body " style="padding-top: 50px;">
  		<div class="col-md-2">
   				<?php include_once 'html_comp/left_panel_ninjas.php'   ?>
   		</div>       
         <div class="col-md-7">
			<div class="panel-primary" id='panel-cont'>
			  	<p id='home-ch'></p>
			 	<p id='home'></p>
	    		<?php include_once 'html_comp/ninjas_page.php' ; ?>
			</div>
		</div>
		 <div class="col-md-3">
			
			<?php include_once 'html_comp/right_panel_ninjas.php'  ; ?>
			
				
			</div>
		</div>
	
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
	</script>
    
    <script src="js/ninjas.js" type="text/javascript"></script>
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
   <script>
   bootbox.confirm("Are you sure?", function(result) {
 Example.show("Confirm result: "+result);
});
   </script>
</body></html>
<?php
mysqli_close($db_handle);
?>
