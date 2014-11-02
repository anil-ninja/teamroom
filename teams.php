<?php
include_once 'lib/db_connect.php';

session_start();

if (isset($_POST['logout'])) {
    header('Location: profile.php?username='."$UserName");
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    session_destroy();
    exit;
}
$team_name = $_GET['team_name'];
$team_project_id = $_GET['project_id'];

$project_name_display = mysqli_query($db_handle, "SELECT project_title FROM projects WHERE project_id = $team_project_id;");
$project_name_displayRow = mysqli_fetch_array($project_name_display);
$project_team_title = $project_name_displayRow['project_title'];



$teams_names_display = mysqli_query($db_handle, (" select b.first_name, b.username, b.last_name,
		a.team_name,b.email,b.contact_no,b.rank from teams as a	join user_info as b where a.team_name = '$team_name' AND a.user_id = b.user_id and a.member_status = '1' and a.project_id=$team_project_id;"));

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/profile_page_style.css">
        
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	
	<link href="css/font-awesome.css" rel="stylesheet">
	<script src="js/jquery.js"> </script>
	<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery.autosize.js"></script>
    </head>

    <body>
        <?php include_once 'html_comp/navbar_homepage.php'; ?>
         <div class='alert_placeholder'></div>
        <div class=" media-body" style="padding-top: 35px;"></div>
        <div class='row'>
        	<p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>
        	<?= ucfirst($team_name)." (".$project_team_title.") <a class='badge'>3</a>";?>
        		
        	</b></p>
        </div>
        <div clas='row'>
        <div class='col-md-2'>
        	<div class="panel">
            <div class='panel-body'>
        	    <?php
        	    	echo "<p style='color :#3B5998';>".$project_team_title." Teams </p><br>";
        	    	$teams_name_display = mysqli_query($db_handle, ("select team_name, project_id from teams where user_id= '$user_id' AND project_id='$team_project_id';"));
                        while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                            $team_name = $teams_name_displayRow['team_name'];
                            $team_project_id = $teams_name_displayRow['project_id'];

                            echo "<a href='teams.php?project_id=$team_project_id&team_name=$team_name'>" . ucfirst($team_name)."</a><br>";
                        }
        	    ?>
        	</div>
            </div>
    	</div>
    	<div class="col-md-9">
        <div class="panel">
        <div class='panel-body'>
    	<?php
    		while ($teams_names_displayRow = mysqli_fetch_array($teams_names_display)) {
                $firstname = $teams_names_displayRow['first_name'];
                $username = $teams_names_displayRow['username'];
                $lastname = $teams_names_displayRow['last_name'];
                $rank = $teams_names_displayRow['rank'];
                echo "<div class='col-md-2'>
                        <img src='uploads/profilePictures/$username.jpg'  style='width:25%' onError=this.src='img/default.gif' class='img-circle img-responsive'>
                        <span class='color strong pull-left'><a href ='profile.php?username=" . $username . "'>" 
                            .ucfirst($firstname)." ".ucfirst($lastname)."</a></span><br>"
                            .$rank."
                    </div>";
            }
?>
</div>
    	</div>
        </div>
    	</div>
    	</body>
    	</html>


