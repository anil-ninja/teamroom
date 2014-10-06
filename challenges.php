<?php
include_once "challenges.inc.php";
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="60" >
        <title>Challenges</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Billing, Sharing, budget">
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
       <div class="container-fluid">
            <div class="row-fluid">          
                <div class="col-xs-12 col-sm-5">
                    <div class="row" style="visibility: visible; position: relative;">
                        <?php include_once 'html_comp/challenges_page_created.php';   ?>
                    </div> 
            </div>
              <div class="col-xs-12 col-sm-5">
                    <div class="row" style="visibility: visible; position: relative;">
						<?php include_once 'html_comp/challenges_page_owned.php';   ?>
					</div> 
            </div>
                <div class="col-xs-12 col-sm-2" STYLE="font-size: 10pt;">
                  <?php   include_once 'html_comp/right_panel_challenge.php';      ?>
                </div>
            </div>
    </div>

<script src="js/jquery.js"></script>


<script src="js/bootstrap.min.js"></script>
<script src="js/bootswatch.js"></script>
<script>
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});	

	function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
	
	$(document).ready(function(){
		$("#submit_ch").click(function(){
			$("#submit_ch").attr('disabled','disabled');
			var challenge = $("#challange").val() ;
			var challenge_title = $("#challange_title").val() ;
			var open_time = parseInt($("#open_time").val());
			var open = parseInt($("#open").val());
			var opentime = parseInt(open_time*60+open) ;
			var eta = parseInt($("#c_eta").val());
			var etab = parseInt($("#c_etab").val());
			var etac = parseInt($("#c_etac").val());
			var etad = parseInt($("#c_etad").val());
			var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',challenge)) + '&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + 
			'&challange_eta='+ (challange_eta+='') ;
			//alert(dataString);
			if(challenge==''){
				alert("Please Enter Something !!!");
			}
			else if(challenge_title==''){
				alert("Please Enter Something !!!");
			}
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_chalange.php",
				data: dataString,
				cache: false,
				success: function(result){
					alert(result);
					if(result=='Challange posted succesfully!'){
						$("#challange").val("");
						$("#challange_title").val("");
						$("#open_time").val("");
						$("#open").val("");
						$("#c_eta").val("");
						$("#c_etab").val("");
						$("#c_etac").val("");
						$("#c_etad").val("");
					
					}
				}
			});
			}
			return false;
		});
	});
</script>
<script src="js/project.js"></script>
<div class="row">
    <div class="col-md-6 pull-right">

        <script src="js/custom.js"></script>

        <div class="row">
            <div class="col-md-4 pull-right">

                <ul class="list-inline">
                    <li>Posted by: Mybill.com</li>
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
