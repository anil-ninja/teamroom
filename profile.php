<?php 
include_once 'lib/db_connect.php';
include_once 'functions/delete_comment.php';
$username = $_GET['username'] ;
$user_info = mysqli_query($db_handle, ("SELECT * FROM user_info WHERE username = '$username';"));
$user_infoRow =  mysqli_fetch_array($user_info);
$user_id = $user_infoRow['user_id'];

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

if (isset($_POST['logout'])) {
    header('Location: index.php');
    exit ;
} 
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
    <div class="navbar navbar-default navbar-fixed-top">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="ninjas.php">Collgo</a>
  </div>
  
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
		<li><form method="POST" class="navbar-text" action = "">
          <input type="text" placeholder="search"/>
            <button type="submit" name="search" class="glyphicon glyphicon-search btn-primary btn-xs">
            </button>
        </form></li>
    </ul>
       <ul class='nav navbar-nav navbar-right'>
		<li>
		  <div class='dropdown'>
            <a data-toggle='dropdown'><p class='navbar-text'>Your Projects<span class='caret'></span></p></a>
    		<ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>
			<?php
					$username = $_GET['username'] ;
					$user_info = mysqli_query($db_handle, ("SELECT user_id FROM user_info WHERE username = '$username';"));
					$user_infoRow =  mysqli_fetch_array($user_info);
					$user_id = $user_infoRow['user_id'];
					$project_title_display = mysqli_query($db_handle, ("(SELECT DISTINCT a.project_id, b.project_title FROM teams as a join projects 
																		as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '1')  
																		UNION (SELECT DISTINCT project_id, project_title FROM projects WHERE user_id = '$user_id' and project_type= '1');"));
			while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
					$p_title = $project_title_displayRow['project_title'] ;		
			echo "<li><form method='POST' action=''>
					<input type='hidden' name='project_title' value='".$p_title."'/>
					<input type='hidden' name='project_id' value='".$project_title_displayRow['project_id']."'/>
					<button type='submit' class='btn-link' name='projectphp' style='white-space: pre-line;'>".$p_title."</button><br/><br/></form></li>" ;
					}
           ?>
                        </ul>
                      </div>
                  </li>      
      <li> <form method='POST'> 
          <p class="navbar-text"><a href="challenges.php" style='cursor:pointer;'>Your Challenges</a></p>
          <p class="navbar-text">Rank :  <?php $username = $_GET['username'] ; $user_info = mysqli_query($db_handle, ("SELECT * FROM user_info WHERE username = '$username';")); $user_infoRow =  mysqli_fetch_array($user_info); $rank = $user_infoRow['rank']; echo $rank ; ?></p>
          <p class="navbar-text"><span class="glyphicon glyphicon-user"></span>Hello <?php $username = $_GET['username'] ; $user_info = mysqli_query($db_handle, ("SELECT * FROM user_info WHERE username = '$username';")); $user_infoRow =  mysqli_fetch_array($user_info); $f_name = $user_infoRow['first_name']; echo ucfirst($f_name); ?></p>                              
          <p class="navbar-text"><form method="POST" ><button type="submit" class="btn btn-danger btn-sm" name="logout" ><span class="glyphicon glyphicon-off"></span></button></form></p>
      </li>
    </ul>
  </div>
</div>
    <script type="text/javascript" src="scripts/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/jquery.wallform.js"></script>
    
    <div class="container">
	<div class="row">
            <div class="col-md-offset-1 col-md-8 col-lg-8">
                <div class="well profile">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-8">
					<?php
							$username = $_GET['username'] ;
							$user_info = mysqli_query($db_handle, ("SELECT * FROM user_info WHERE username = '$username';"));
							$user_infoRow =  mysqli_fetch_array($user_info);
							$f_name = $user_infoRow['first_name'];
							$l_name = $user_infoRow['last_name'];
							$email= $user_infoRow['email'];
							$phone = $user_infoRow['contact_no'];
                      echo "<h2><strong>".ucfirst($f_name). " ".ucfirst($l_name)."</strong></h2>
                            <p><strong>Email-Id: </strong>".$email."</p>
                            <p><strong>Contact: </strong>".$phone."</p>
                            <p><strong>Skills: </strong>
                                <span class='tags'>html5</span> 
                                <span class='tags'>css3</span>
                                <span class='tags'>jquery</span>
                                <span class='tags'>bootstrap3</span>
                            </p>" ;
                            ?>
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
            <div class="col-md-3 col-lg-3">
                <div class="well profile">
                    <p>  In-contact with Friends </p>
                    <?php
                       $userProjects = mysqli_query ($db_handle, ("SELECT * FROM user_info as a join 
                                                            (SELECT DISTINCT b.user_id FROM teams as a join
                                                            teams as b where a.user_id = '$user_id' and
                                                            a.team_name = b.team_name and b.user_id != '$user_id')
                                                            as b where a.user_id=b.user_id;"));
               
                        while ($userProjectsRow = mysqli_fetch_array($userProjects))  {
                            $friend_f_name = $userProjectsRow['first_name'];
                            $friend_l_name = $userProjectsRow['last_name'];
                            $username_friends = $userProjectsRow['username'];
                            echo "<form method='GET' action='profile.php'>
                                    <button type='submit' name='username' class='btn-link' value='".$username_friends."'>
                                        ".ucfirst($friend_f_name)." ".ucfirst($friend_l_name)."
                                    </button>
                                </form>";
                        }
                    ?>
                </div>                 
            </div>
        </div>
    </div>
</body>
</html>
