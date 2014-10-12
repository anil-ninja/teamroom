<?php
include_once 'ninjas.inc.php';
include_once 'functions/delete_comment.php';
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
	<title>TeamRoom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Billing, Sharing, budget">
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
		<script src="js/ninjas.js" type="text/javascript"></script>
  </head>
  <body>
       <?php include_once 'html_comp/navbar_homepage.php'; ?>

        <div class="row-fluid">
          <div class="col-lg-2" style="width:200px;">
           <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
           </div> 
          <div class="col-lg-8">
              <div class="panel-primary">
			<?php include_once 'html_comp/ninjas_page.php'   ?>
	</div>
	</div>
	<div class="col-lg-2" style="width:200px;">
           <?php include_once 'html_comp/right_panel_ninjas.php'   ?> 
</div></div>
    <script src="js/jquery-1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootswatch.js"></script>
    <script src="js/project.js"></script>
  <script>
   
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});	
document.getElementById("demo").innerHTML = String(getDateTime());
  </script>


</body></html>


<?php
mysqli_close($db_handle);
?>
