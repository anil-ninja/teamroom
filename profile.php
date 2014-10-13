<?php 
include_once 'ninjas.inc.php';
echo "<br> <br>";
echo $username;
echo $name;

echo $user_id;
echo $email;


$challenge_created = mysqli_query($db_handle, ("SELECT challenge_id FROM challenges WHERE user_id = $user_id;"));
$total_challenge_created = mysqli_num_rows($challenge_created);


$challenge_progress = mysqli_query($db_handle, ("SELECT status FROM challenge_ownership WHERE status = 1 and user_id = $user_id;"));
$total_challenge_progress = mysqli_num_rows($challenge_progress);

$challenge_completed = mysqli_query($db_handle, ("SELECT status FROM challenge_ownership WHERE status = 2 and user_id = $user_id;"));
$total_challenge_completed = mysqli_num_rows($challenge_completed);

$project_created = mysqli_query($db_handle, ("SELECT project_id FROM projects WHERE user_id = $user_id;"));
$total_project_created = mysqli_num_rows($project_created);

$project_completed = mysqli_query($db_handle, ("SELECT project_id FROM projects WHERE user_id = $user_id and project_type = '2';"));
$total_project_completed = mysqli_num_rows($project_completed);

?>
<!DOCTYPE html>
<html lang="en">

    <head>

    <meta charset="utf-8">
    
    <title>profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        
body
{
    font-family: 'Lato', 'sans-serif';
    }
.profile 
{
    min-height: 355px;
    display: inline-block;
    }
figcaption.ratings
{
    margin-top:20px;
    }
figcaption.ratings a
{
    color:#f1c40f;
    font-size:11px;
    }
figcaption.ratings a:hover
{
    color:#f39c12;
    text-decoration:none;
    }
.divider 
{
    border-top:1px solid rgba(0,0,0,0.1);
    }
.emphasis 
{
    border-top: 4px solid transparent;
    }
.emphasis:hover 
{
    border-top: 4px solid #1abc9c;
    }
.emphasis h2
{
    margin-bottom:0;
    }
span.tags 
{
    background: #1abc9c;
    border-radius: 2px;
    color: #f5f5f5;
    font-weight: bold;
    padding: 2px 4px;
    }
.dropdown-menu 
{
    background-color: #34495e;    
    box-shadow: none;
    -webkit-box-shadow: none;
    width: 250px;
    margin-left: -125px;
    left: 50%;
    }
.dropdown-menu .divider 
{
    background:none;    
    }
.dropdown-menu>li>a
{
    color:#f5f5f5;
    }
.dropup .dropdown-menu 
{
    margin-bottom:10px;
    }
.dropup .dropdown-menu:before 
{
    content: "";
    border-top: 10px solid #34495e;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    bottom: -10px;
    left: 50%;
    margin-left: -10px;
    z-index: 10;
    }
    </style>

    <script src="jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/bootswatch.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'html_comp/navbar_homepage.php'; ?>
    <script type="text/javascript" src="scripts/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/jquery.wallform.js"></script>
    
    <div class="container">
	<div class="row">
            <div class="col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
                <div class="well profile">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-8">
                            <h2><strong> <?php echo ucfirst($name); ?> </strong></h2>
                            <p><strong>Email-Id: </strong> <?php echo $email; ?> </p>
                            <p><strong>Contact: </strong> <?php echo 0000000000; ?> </p>
                            <p><strong>Skills: </strong>
                                <span class="tags">html5</span> 
                                <span class="tags">css3</span>
                                <span class="tags">jquery</span>
                                <span class="tags">bootstrap3</span>
                            </p>
                        </div>             
                        <div class="col-xs-12 col-sm-4 text-center">
                        <figure>
                            <img src="img/default-user-icon-profile.png" alt="" class="img-circle img-responsive">
                                <figcaption class="ratings">
                                    <p>Ratings
                                    <a href="#">
                                        <span class="fa fa-star"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa fa-star"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa fa-star"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa fa-star"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa fa-star-o"></span>
                                    </a> 
                                    </p>
                                </figcaption>
                        </figure>
                    </div>
                    </div>            
                <div class="col-xs-12 divider text-center">
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong> <?php echo $total_challenge_created; ?> </strong></h2>                    
                        <p><small>challenges</small></p>
                        <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Created </button>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong> <?php echo $total_challenge_completed; ?> </strong></h2>                    
                        <p><small>challenges</small></p>
                        <button class="btn btn-success btn-block"><span class="glyphicon glyphicon-ok"></span> Completed </button>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong><?php echo $total_challenge_progress; ?> </strong></h2>                    
                        <p><small>challenges</small></p>
                        <button class="btn btn-success btn-block"><span class="glyphicon glyphicon-fire"></span> In-progress </button>
                    </div>
                </div>
                <div class="col-xs-12 divider text-center">
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong><?php echo $total_project_created; ?></strong></h2>                    
                        <p><small>projects</small></p>
                        <button class="btn btn-info btn-block"><span class="fa fa-plus-circle"></span> Created </button>
                    </div>
                    
                    
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong><?php echo $total_project_completed; ?> </strong></h2>                    
                        <p><small>projects</small></p>
                        <button class="btn btn-info btn-block"><span class="glyphicon glyphicon-ok"></span> Completed </button>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong> 0 </strong></h2>                    
                        <p><small>projects</small></p>
                        <button class="btn btn-info btn-block"><span class="glyphicon glyphicon-fire"></span> In-progress </button>
                    </div>
                </div>
            </div>
        </div>
    </div>                 
</div>
</body>
</html>
