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
					 location.reload();
					}
				}
			});
			}
      $("#submit_ch").removeAttr('disabled');
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
  function delChallenge(href){
  
    //e.preventDefault();//this will prevent the link trying to navigate to another page
    //var href = $(this).attr("cID");//get the href so we can navigate later
    alert(href);
    if(confirm("Do u really want to delete this challenge?")){
        var dataString = 'challengeID='+ href;
        $.ajax({
        type: "POST",
        url: "ajax/delete_chalange.php",
        data: dataString,
        cache: false,
        success: function(result){
          alert(result);
          location.reload();
          
        }
        });
      }
  }
  </script>


</body></html>


<?php
mysqli_close($db_handle);
?>
