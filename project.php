<?php
include_once 'project.inc.php';
include_once 'functions/delete_comment.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
            <title>Projects</title>
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
        <script src="js/project.js"></script>
        <script src="js/delete_comment_challenge.js" type="text/javascript"> </script>
   </head>
<body>
	<?php include_once 'html_comp/navbar_homepage.php'; ?>
    <div class='alert_placeholder'></div>
        <div class='row'>
          <div class="col-md-3" style="width:260px; padding-top: 35px; position: auto;">
           <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
           </div>  
            <div class=" media-body" style="padding-top: 35px;">
          <div class="col-md-9">
              <div class="panel-primary" id='panel-cont'>
                       <?php include_once 'html_comp/project_page_project.php'; ?>
                </div>
            </div>
            <div class="col-md-3">
				   <?php include_once 'html_comp/project_page_challenge.php'; ?>
            </div>	
            </div>
           </div>
       <div class='footer' style='margin-left: 1000px; margin-right: 50px;'><button id='talkpro' class='btn-link' type='submit' >Project Talk</button> </div>
       <div class='footer' id='talkprForm' style='margin-left: 1000px; margin-right: 50px; margin-bottom: 30px; height: 300px; overflow-y: auto; overflow-x: hidden;'>  
       <?php 
       echo "<div class='list-group'>
				<div class='list-group-item'>" ;

$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '5')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '5') ORDER BY response_pr_creation ASC;");
while ($displayrowc = mysqli_fetch_array($displayb)) {
    $frstnam = $displayrowc['first_name'];
    $lnam = $displayrowc['last_name'];
    $username_pr_comment = $displayrowc['username'];
    $ida = $displayrowc['response_pr_id'];
    $projectres = $displayrowc['stmt'];
    echo "<div id='commentscontainer'>
            <div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                </div>
                <div class='comment-text'>
                    <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a>&nbsp</span> 
                    <small>" . $projectres . "</small>";
        echo "</div>
            </div> 
        </div>";
}
echo "<div class='comments clearfix'>
			<div class='pull-left lh-fix'>
				<img src='uploads/profilePictures/".$username.".jpg'  onError=this.src='img/default.gif'>&nbsp
			</div>
			<form method='POST' class='inline-form'>
				<input type='text' STYLE='border: 1px solid #bdc7d8; width: 65%; height: 30px;' name='pr_resptalk' placeholder='Whats on your mind about this project' />
				<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_projecttalk' ></button>
			</form>
		</div>
	</div>
</div>" ;
?>
</div>
       <script>
       $(document).ready(function(){
			$("#talkprForm").toggle();
			$("#talkpro").click(function(){
				$("#talkprForm").toggle();
				$("#talkprForm").scrollTop($('#talkprForm').height()) ;
				//$("#protalk").animate({ scrollTop: $(document).height() }, "fast") ;
				//return false;
				//var box = document.getElementById('protalk');
				//box.scrollTop = box.scrollHeight;
			});
		});   
       </script>   
       <script src="js/jquery-1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/ninjas.js"></script>
    <script src="js/bootswatch.js"></script>
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
        </script>
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
        </script>

        </body>
    </html>
<?php
mysqli_close($db_handle);
?>
