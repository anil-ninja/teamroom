<?php
include_once "challenges.inc.php";
include_once 'functions/delete_comment.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Challenges</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenges, Projects, Problem solving, problems">
        <meta name="author" content="Rajnish">

        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <style>
            body {
                padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
            }             
        </style>

        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
            <link rel="stylesheet" href="css/bootswatch.css">
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery.js"> </script>
        <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery.autosize.js"></script>

    </head>
    <body>
		<?php include_once 'html_comp/navbar_homepage.php'; ?>
       <div class='alert_placeholder'></div>
       <div class="container-fluid">
            <div class="row-fluid"> 
				<div class="col-lg-2" STYLE="font-size: 10pt;">
                  <?php   include_once 'html_comp/right_panel_challenge.php';      ?>
                </div>         
                <div class="col-lg-5">
                        <?php include_once 'html_comp/challenges_page_created.php';   ?>
            </div>
              <div class="col-lg-5">
                        <?php include_once 'html_comp/challenges_page_owned.php';   ?>
            </div>
            </div>
    </div>

<script src="js/jquery.js"></script>


<script src="js/bootstrap.min.js"></script>
<script src="js/bootswatch.js"></script>
<script src="js/delete_comment_challenge.js" type="text/javascript"> </script>
<script src="js/ninjas.js"></script>
<script>
	startTime();
 function getDateTime() {
    var now     = new Date(); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    if(month.toString().length == 1) {
        var month = '0'+month;
    }
    if(day.toString().length == 1) {
        var day = '0'+day;
    }   
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }   
    var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;   
     return dateTime;
}

function startTime() {
    document.getElementById('demo').innerHTML = String(getDateTime());
    t = setTimeout(function () {
        startTime()
    }, 500);
}
</script>
<div class="row">
    <div class="col-md-6 pull-right">

        <script src="js/custom.js"></script>

        <div class="row">
            <div class="col-md-4 pull-right">

                <ul class="list-inline">
                    <li>Powered by: Dpower4.com</li>
                    <li>Copyright @ 2014</li>
                </ul>
            </div>
        </div>
    </div>
</div>



     </body>
</html>
<?php
mysqli_close($db_handle);
?>
