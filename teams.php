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



$teams_member_display = mysqli_query($db_handle, "select b.user_id, b.first_name, b.username, b.last_name, a.team_name, a.team_owner, b.email,b.contact_no,b.rank 
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
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="js/jquery-1.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootswatch.js"></script>
        <script src="js/date_time.js"></script>
    </head>

    <body>
        <?php include_once 'html_comp/navbar_homepage.php'; ?>
        <div class=" media-body" style="padding-top: 35px;"></div>
        <div class='row'>
        	<p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>
        	<?= ucfirst($team_name)." (<a href='project.php?project_id=$team_project_id'>".$project_team_title."</a>) <a class='badge'>".$total_members."</a>";?>
        		
        	</b></p>
        </div>
        <div class='row'>
        <div class='col-md-2'>
        	<div class="panel">
            <div class='panel-body'>
        	    <?php
        	    	echo "<p style='color :#3B5998;' class='color strong'>
                                <a href='project.php?project_id=$team_project_id'>".ucfirst($project_team_title)."</a> Teams </p><br>";
        	    	$teams_name_display = mysqli_query($db_handle, ("select DISTINCT team_name, project_id from teams where user_id= '$user_id' AND project_id='$team_project_id';"));
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
            <div class='alert_placeholder'> </div>
            
    	<?php
                $teams_owner_add= mysqli_query($db_handle, "SELECT team_owner FROM teams WHERE team_owner = '$user_id' AND team_name = '$team_name' AND member_status = '1' and project_id='$team_project_id';");
                $team_ownerRow = mysqli_fetch_array($teams_owner_add);
                $team_owner_project = $team_ownerRow['team_owner'];
                    if ($team_owner_project == $user_id) {
                       echo "<div class='col-md-2'>
                           
                                <div class='dropdown'>
                                    <button class='btn btn-success dropdown-toggle glyphicon glyphicon-plus' id='dropdownMenu1' data-toggle='dropdown'> Add</button>
                                    <ul class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu1'>
                                        <li><form method='POST'>
                                            <input type='email' class='form-control' id ='email_add_member' placeholder='Enter member Email'/>
                                            <input type='hidden' id ='team_name' value='" .$team_name. "'/>
                                            <input type='hidden' id ='project_no' value='" .$team_project_id."'/>
                                            <input type='button' class='btn-success btn-sm submit' id='add_member' onclick='add_member_to_team()' value='Add' />
                                            </form>
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
                    $user_id_member = $teams_member_displayRow['user_id'];
                    
                        echo "<div class='col-md-2'>
                                <img src='uploads/profilePictures/$username.jpg'  style='width:25%' onError=this.src='img/default.gif' class='img-circle img-responsive'>";
                        if ($team_owner_project == $user_id && $user_id_member != $user_id) {
                          echo "<input type='hidden' id ='team_name' value='" .$team_name. "'/>
                                <input type='hidden' id ='project_id' value='" .$team_project_id."'/>
                                <input type='hidden' id ='user_remove_id' value='" .$user_id_member."'/>
                                <button type='submit' class='glyphicon glyphicon-minus pull-top' style='top: -28px; margin: -20px;' id='remove_member' onclick='remove_member_team();'></button>";
                        }
                        echo "<span class='color strong pull-left'><a href ='profile.php?username=" . $username . "'>" 
                                    .ucfirst($firstname)." ".ucfirst($lastname)."</a></span><br>"
                                    .$rank."</div>";
                }
        ?>
</div>
    	</div>
            <?php include_once 'html_comp/kanban.php'; ?>
        </div>
    	</div>
        <script language="JavaScript" type="text/javascript">
        function add_member_to_team () {
			var emailadd_member =document.getElementById("email_add_member").value;
                        var teamName = document.getElementById("team_name").value;
                        var project_id = document.getElementById("project_no").value;
			var dataString = 'emailadd_member1='+ emailadd_member + '&teamName1='+ (teamName+='') + '&project_id1='+ project_id;
                        
                        if (emailadd_member == "") {
                            alert("Email can't be empty");
                        }
                        else {
                        $.ajax({
				type: "POST",
				url: "ajax/add_member_team.php",
				data: dataString,
				cache: false,
				success: function(result){
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Member Added succesfully!'){
                                            location.reload();
					}
                                }
				});
			}
                        return false;
                        }
        </script>
                <script>
            function remove_member_team(href){
                if(confirm("Do u really want to Remove this member?")){
                    var team_name = $("#team_name").val();
                    var project_id = $("#project_id").val();
                    var member_remove_id = $("#user_remove_id").val();
                    var dataString = 'team_name=' + team_name + '&project_id='+ project_id + '&mem_remove_id=' + member_remove_id;
                    alert(dataString);
                    $.ajax({
                        type: "POST",
                        url: "ajax/add_member_team.php",
                        data: dataString,
                        cache: false,
                        success: function(result){
                            bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
                            if(result=='Member Removed succesfully!') {
                                location.reload();
                            }
                        }
                    });
                }
            }
function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; right: 20%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};
        </script>
            </body>
    	</html>
