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
                                                    from teams as a join user_info as b where a.team_name = '$team_name' AND a.user_id = b.user_id and a.member_status = '1' and a.project_id=$team_project_id ORDER BY team_creation ASC;");
$total_members = mysqli_num_rows($teams_member_display);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $team_name; ?></title>
        <meta charset="utf-8">
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>

    <body>
         <?php include_once 'html_comp/navbar_homepage.php'; ?>
   <div class='alert_placeholder'></div>
   <div class=" media-body " style="padding-top: 50px;">
	   <div class="col-md-1"></div>
        <div class="col-md-2">
                <?php include_once 'html_comp/left_panel_ninjas.php'   ?>
        </div>       
        <div class="col-md-6" style="padding-top: 20px;">
            <div class="panel-primary" id='panel-cont'>
                <p id='home-ch'></p>
                <p id='home'></p>
                <div class="panel panel-default">
                    <div class='panel-body'>
                        <div class='alert_placeholder'> </div>
                        <div class='row'>
                            <div class="col-md-8">
                                <p  style='font-size: 12pt; color :#3B5998;'  ><b>
                                <?= ucfirst($team_name)." (<a href='project.php?project_id=$team_project_id'>".$project_team_title."</a>) <a class='badge'>".$total_members."</a>";?>
                                    
                                </b></p>
                            </div>
                            <div class="col-md-4">
                            <?php
                                $teams_owner_add= mysqli_query($db_handle, "SELECT team_owner FROM teams WHERE team_owner = '$user_id' AND team_name = '$team_name' AND member_status = '1' and project_id='$team_project_id';");
                                $team_ownerRow = mysqli_fetch_array($teams_owner_add);
                                $team_owner_project = $team_ownerRow['team_owner'];
                                if ($team_owner_project == $user_id) {
                                    echo "<div class='dropdown'>
                                            <button class='btn-link dropdown-toggle' id='dropdownMenu1' data-toggle='dropdown'> + Add New Teammate</button>
                                            <ul class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu1'>
                                                <li><form method='POST'>
                                                        <input type='email' class='form-control' id ='email_add_member' placeholder='Enter member Email'/>
                                                        <input type='hidden' id ='team_name' value='" .$team_name. "'/>
                                                        <input type='hidden' id ='project_no' value='" .$team_project_id."'/>
                                                        <input type='button' class='btn-success btn-sm submit' id='add_member' onclick='add_member_to_team()' value='Add' />
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>";
                                }
                            ?>
                            </div>
                        </div>
                        </div>
                        <hr/>
                        <div class="panel-body">
                            
                        
                    	<?php
                                while ($teams_member_displayRow = mysqli_fetch_array($teams_member_display)) {
                                    $firstname = $teams_member_displayRow['first_name'];
                                    $username = $teams_member_displayRow['username'];
                                    $lastname = $teams_member_displayRow['last_name'];
                                    $rank = $teams_member_displayRow['rank'];
                                    $user_id_member = $teams_member_displayRow['user_id'];
                                    
                                        echo "<div class='row col-md-4' style=' background : rgb(240, 241, 242); margin:4px; padding:1px;;'>
                                                <div class ='col-md-3' style='padding:1px;'>
                                                    <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif' style='height:40px' class='img-responsive'>
                                                </div>";
                                        
                                        echo "<div class = 'col-md-7' style='font-size:12px;padding: 1px;'><span class='color pull-left' id='new_added'><a href ='profile.php?username=" . $username . "'>" 
                                                    .ucfirst($firstname)." ".ucfirst($lastname)."</a></span><br/><span style='font-size:10px;'>"
                                                    .$rank."</span></div>";
                                        if ($team_owner_project == $user_id && $user_id_member != $user_id) {
                                          echo "<div class = 'col-md-1' style='font-size:12px;padding-left: 3px; padding-right: 0px;'><input type='hidden' id ='team_name' value='" .$team_name. "'/>
                                                    <input type='hidden' id ='project_id' value='" .$team_project_id."'/>
                                                    <input type='hidden' id ='user_remove_id' value='" .$user_id_member."'/>
                                                    <button type='submit' class='btn-link' id='remove_member' onclick='remove_member_team(".$user_id_member.");' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Teammate'>x</button>
                                                </div>";
                                        }
                                        echo "</div>";
                                }
                        ?>
                    </div>
                    </div>
    	       </div>
                <?php include_once 'html_comp/kanban.php'; ?>
        </div>
         <div class="col-md-2" style="padding-top: 20px;">
                <div class="panel">
                    <div class='panel-body' style="font-size:10px">
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
                <?php include_once 'html_comp/friends.php' ; ?>
                </div>
        </div>
        <?php include_once 'lib/html_inc_footers.php'; ?>
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
            function remove_member_team(id){
                if(confirm("Do u really want to Remove this member?")){
                    var team_name = $("#team_name").val();
                    var project_id = $("#project_id").val();
                    var member_remove_id = id;
                    alert ("user id is" +id);
                    var dataString = 'team_name=' + team_name + '&project_id='+ project_id + '&mem_remove_id=' + member_remove_id;
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
