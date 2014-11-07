<?php
include_once 'lib/db_connect.php';

session_start();
if(!isset($_SESSION['user_id'])) 
    header ('location: index.php');
else 
    $user_id = $_SESSION['user_id'];

if (isset($_POST['logout'])) {
    header('Location: index.php');
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



$teams_member_display = mysqli_query($db_handle, "select b.first_name, b.username, b.last_name, a.team_name, a.team_owner, b.email,b.contact_no,b.rank 
                                                    from teams as a join user_info as b where a.team_name = '$team_name' AND a.user_id = b.user_id and a.member_status = '1' and a.project_id=$team_project_id;");
$total_members = mysqli_num_rows($teams_member_display);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $team_name; ?></title>
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
        <script src="js/jquery-1.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootswatch.js"></script>
        <script src="js/date_time.js"></script>
    </head>

    <body>
        <?php include_once 'html_comp/navbar_homepage.php'; ?>
         <div class='alert_placeholder'></div>
        <div class=" media-body" style="padding-top: 35px;"></div>
        <div class='row'>
        	<p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>
        	<?= ucfirst($team_name)." (".$project_team_title.") <a class='badge'>".$total_members."</a>";?>
        		
        	</b></p>
        </div>
        <div class='row'>
        <div class='col-md-2'>
        	<div class="panel">
            <div class='panel-body'>
        	    <?php
        	    	echo "<p style='color :#3B5998';>".$project_team_title." Teams </p><br>";
        	    	$teams_name_display = mysqli_query($db_handle, ("select team_name, project_id from teams where user_id= '$user_id' AND project_id='$team_project_id';"));
                        while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                            $list_of_teams = $teams_name_displayRow['team_name'];
                            $team_project_id = $teams_name_displayRow['project_id'];

                            echo "<a href='teams.php?project_id=$team_project_id&team_name=$list_of_teams'>" . ucfirst($list_of_teams)."</a><br>";
                        }
        	    ?>
        	</div>
            </div>
    	</div>
    	<div class="col-md-9">
        <div class="panel">
        <div class='panel-body'>
            
    	<?php
                $teams_owner_add= mysqli_query($db_handle, "SELECT team_owner FROM teams WHERE team_owner = '$user_id' AND team_name = '$team_name' AND member_status = '1' and project_id='$team_project_id';");
                $team_ownerRow = mysqli_fetch_array($teams_owner_add);
                $team_owner_project = $team_ownerRow['team_owner'];
                    if ($team_owner_project == $user_id) {
                        echo "<div class='col-md-2'>
                                <div class='dropdown'>
                                    <a data-toggle='dropdown'><span class='btn btn-success glyphicon glyphicon-plus'> Add</span></a>
                                    <ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>
                                        <li>
                                            <input type='email' class='form-control' id ='email_add_member' placeholder='Enter member Email'/>
                                            <input type='hidden' id ='team_name' value='" .$team_name. "'/>
                                            <input type='hidden' id ='project_id' value='" .$team_project_id."'/>
                                            <input type='submit' class='btn-success btn-sm' id='add_member' value='Add '/>
                                        </li>
                                    </ul>
                                </div>
                            </div>";
                    }
    		while ($teams_member_displayRow = mysqli_fetch_array($teams_member_display)) {
                    $firstname = $teams_member_displayRow['first_name'];
                    $username = $teams_member_displayRow['username'];
                    $lastname = $teams_member_displayRow['last_name'];
                    $rank = $teams_member_displayRow['rank'];
                    
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
            <?php include_once 'html_comp/kanban.php'; ?>
        </div>
    	</div>
        <script>
            $(document).ready(function(){

		$("#add_member").click(function(){
      		$("#add_member").attr('disabled','disabled');
			var email_add_member = $("#email_add_member").val() ;
			var team_name = $("#team_name").val();
                        var project_id = $("#project_id").val();
			
                        var dataString = 'email_add_member='+ email_add_member + '&team_name='+ (team_name+='') + '&project_id='+ project_id;
			//alert(dataString);
			$.ajax({
				type: "POST",
				url: ajax/add_member_team.php,
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Member Added succesfully!'){
					location.reload();
					}
				}
			}); 
		});
        </script>
            </body>
    	</html>


