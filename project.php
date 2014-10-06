<?php
include_once 'project.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta http-equiv="refresh" content="60" >
        <meta charset="utf-8">
            <title>Projects</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Billing, Sharing, budget">
        <meta name="author" content="Anil">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootswatch.css">
        <script type="text/javascript" src="js/jquery.autosize.js"></script>
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery.js"> </script>
        <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
        <style>
            body {
                padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
            }             
        </style>

        <script type="text/javascript" src="js/jquery.autosize.js"></script>

            <style>
            body {
                    padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
                }             
                .editbox{
                            display:none
                    }
                    td{
                            padding:5px;
                    }
                    .editbox{

                            background-color:#ffffcc;
                            border:solid 1px #000;
                            padding:4px;
                    }
                    .edit_tr:hover{
                            background:url(edit.png) right no-repeat #80C8E5;
                            cursor:pointer;
                    }             
            </style>
        <script src="js/content_edit.js"> </script>
        <script src="js/project.js"></script>
    </head>
    <body>
       <?php include_once 'html_comp/navbar_homepage.php'; ?>

        <div class="container-fluid">
            <div class="row-fluid">
            
                <div class="col-xs-12 col-sm-5">
                    <div class="row" style="visibility: visible; position: relative;">
                       <?php include_once 'html_comp/project_page_project.php'; ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <div class="row" style="visibility: visible; position: relative;">
					   <?php include_once 'html_comp/project_page_challenge.php'; ?>
				    </div>
                </div>	
            <div class="col-lg-2" STYLE="font-size: 11pt;">
				<?php   include_once 'html_comp/right_panel_project.php';      ?>
            </div> 
    </div>
</div>
       <script src="js/jquery-1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootswatch.js"></script>
     <script type="text/javascript">
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});	
            $('#example')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered');
            
    function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
	
	$(document).ready(function(){
		$("#create_challange_pb_pr").click(function(){
			$("#create_challange_pb_pr").attr('disabled','disabled');
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
			var type = $("#type").val();
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',challenge)) + '&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + 
			'&challange_eta='+ (challange_eta+='') + '&type='+ type ;
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
				url: "ajax/submit_chalange_project.php",
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
						$("#type").val("");
					
					}
				}
			});
			}
			return false;
		});
	});
</script>
        </body>
    </html>
<?php
mysqli_close($db_handle);
?>
