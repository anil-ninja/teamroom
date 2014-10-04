<?php
include_once 'ninjas.inc.php';
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

<script type="text/javascript">
	function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
	
	$(document).ready(function(){
		$("#submit_ch").click(function(){
			var challenge = $("#challange").val() ;
			var open_time = $("#open_time").val();
			var open = $("#open").val();
			var eta = $("#c_eta").val();
			var etab = $("#c_etab").val();
			var etac = $("#c_etac").val();
			var etad = $("#c_etad").val();
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll(' ','<s>',replaceAll('\n','<br>',challenge)) + '&opentime='+ (open_time*60+open) + 
			'&challange_eta='+ (((eta*30+etab)*24+etac)*60+etad) ;
			//alert(dataString);
			if(challenge==''){
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

</script>
  </head>
  <body>
       <div class="row">
          <div class="col-lg-12">
              <div class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
				   <a class="navbar-brand" href="ninjas.php">Ninjas</a>
                  <div class=" col-md-offset-3">
                  <form class="navbar-text navbar-left" method="POST" action="">
                    <input class="inline-form" placeholder="Search" type="text"><button type="submit" name="search" class="glyphicon glyphicon-search btn-primary btn-xs"></button>
                <ul class="nav navbar-nav navbar-right  navbar-user">
					<li><a data-toggle="modal"  data-target="#myModal" style="cursor:pointer; color:white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-edit"></i>Create New Project</a></li>
				  <li><a href="challenges.php" >Your Challenges</a></li>
				  <li><p class="navbar-text">Your rank :  <?php echo $rank ; ?></p></li>
                    <li><p class="navbar-text"><span class="glyphicon glyphicon-user"></span> Hello <?php echo ucfirst($name); ?></p></li>                              
					<li><p class="navbar-text" ><span id="demo"></span></p></li>                   
                   <li><p class="navbar-text"><button type="submit" class="btn btn-danger btn-xs" name="logout" ><span class="glyphicon glyphicon-off"></span></button></p>
                   </li></ul></form> 
               </div></div>
          </div>
        </div>
      </div>

        <div class="row-fluid">
          <div class="col-lg-3" style="width:300px;">
           <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
           </div> 
          <div class="col-lg-6">
              <div class="panel-primary">
			<?php include_once 'html_comp/ninjas_page.php'   ?>
	</div>
	</div>
	<div class="col-lg-3" style="width:300px;">
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
