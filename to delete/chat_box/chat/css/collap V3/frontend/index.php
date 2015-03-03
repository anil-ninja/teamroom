<?php 
session_start();
$user_id = $_SESSION['user_id'];
if ($user_id != "admin") {
    header('Location: login.php');
    exit;
}
?>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Nucleus Admin</title>
	<meta name="description" content="">
	<meta name="author" content="rahul lahoria">

	<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.css" media="screen">
<link rel="stylesheet" href="css/bootswatch.css">
	
  <link rel="stylesheet" href="css/jquery-dataTables.css">


<script src="js/libs/bootstrap/ga.js" async="" type="text/javascript"></script>


	<script data-main="js/main" src="js/libs/require/require.js"></script>
  <style>
      .renderjson a { text-decoration: none; }
      .renderjson .disclosure { color: crimson;
      font-size: 150%; }
      .renderjson .syntax { color: grey; }
      .renderjson .string { color: darkred; }
      .renderjson .number { color: darkcyan; }
      .renderjson .boolean { color: blueviolet; }
      .renderjson .key { color: darkblue; }
      .renderjson .keyword { color: blue; }
      .renderjson .object.syntax { color: lightseagreen; }
      .renderjson .array.syntax { color: orange; }
  </style>
</head>
<body>



  
  <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="index.php" class="navbar-brand">
          	<img src ='imgs/c-logo-common.png' style="width:100px;"/>
          		
          </a>
          <a href="index.php" class="navbar-brand">
          		Nucleus Admin
          </a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          

          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" >Home</a></li>
            <li><a href="#" >Organizations</a></li>
        	<li ><a href="#/channels" >Channels</a></li>
        	<li><a href="#/datafields">Data fields</a></li>
        	<li><a href="#/validators">Validators</a></li>
        	<li><a href="#/conflicts">Conflicts Customers</a></li>
          </ul>

        </div>
      </div>
    </div>


    <br/>

<div class="container">
  <div class='row'>
      <div class='col-md-1'>
        
      </div>
      <div class='col-md-10' >
        <div id="page">
          Loading....
        </div>
      </div> 
  </div>

  <div class='row'>
      <div class='col-md-1'>
        
      </div>
      <div class='col-md-8' >
        <div id="page2">
          
        </div>
      </div> 
  </div>

  <div id="footer"></div>
</div>

</body>
</html>
