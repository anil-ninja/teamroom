<?php
include_once 'lib/db_connect.php';
include_once 'html_comp/start_time.php';
include_once 'ninjas.inc.php';
session_start();
if(!isset($_SESSION['user_id'])) 
    header ('location: index.php');
else 
    $user_id = $_SESSION['user_id'];
    $pro_id = $_SESSION['project_id'];

//$team_name = $_GET['team_name'];
//$team_project_id = $_GET['project_id'];

//$project_name_display = mysqli_query($db_handle, "SELECT project_title FROM projects WHERE project_id = $team_project_id;");
//$project_name_displayRow = mysqli_fetch_array($project_name_display);
//$project_team_title = $project_name_displayRow['project_title'];


$teams_member_display = mysqli_query($db_handle, "select b.user_id, b.first_name, b.username, b.last_name, a.team_name, a.team_owner, b.email,b.contact_no,b.rank 
                                                    from teams as a join user_info as b where a.team_name = '$team_name' AND a.user_id = b.user_id and a.member_status = '1' and a.project_id=$team_project_id ORDER BY team_creation ASC;");
$total_members = mysqli_num_rows($teams_member_display);
?>
 
        <div class="span8">
        <?php 
            $teams_name_display = mysqli_query($db_handle, ("SELECT DISTINCT team_name, project_id 
                                                    FROM teams 
                                                    WHERE user_id = '$user_id' 
                                                        AND project_id ='$pro_id';"
                                                )
                                    );

                            while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                                $team_name = $teams_name_displayRow['team_name'];
                                $team_project_id = $teams_name_displayRow['project_id'];

                                echo "<strong>" . ucfirst($team_name) . "</strong>
                                        <br>";
                                }
        ?>
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
                                                    <li><form>
                                                        <input type='email' class='form-control' id ='email_add_member' placeholder='Enter member Email'/><br/>
                                                        <input type='button' class='btn-success btn-sm submit' onclick='add_member(\"".$team_project_id."\",\"".$team_name."\")' value='Add' />
                                                    </form></li>
                                                </ul>
                                            </div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="panel-body">
                        <div class="row">
                        	<?php
                                while ($teams_member_displayRow = mysqli_fetch_array($teams_member_display)) {
                                    $firstname = $teams_member_displayRow['first_name'];
                                    $username = $teams_member_displayRow['username'];
                                    $lastname = $teams_member_displayRow['last_name'];
                                    $rank = $teams_member_displayRow['rank'];
                                    $user_id_member = $teams_member_displayRow['user_id'];
                                    
                                        echo "<div class='col-sm-4 col-md-3'>";

                                        if ($team_owner_project == $user_id && $user_id_member != $user_id) {
                                          echo "<a type='submit' class='btn-link badge pull-right' id='remove_member' 
												onclick='remove_member(\"".$team_project_id."\", \"".$team_name."\", \"".$user_id_member."\");' 
												data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Teammate'>
                                                    <span class='icon-remove'>
                                                </a>
                                                ";
                                        }
                                        else{
                                            echo "<a class='btn-link badge pull-right'><span class='icon-star'></a>";
                                        }

                                        echo "<div class='thumbnail'>
                                                <a href ='profile.php?username=" . $username . "'>
                                                    <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif' style='height:100px;' class='img-responsive img-circle '>
                                                    <div class='caption'>
                                                        <span class='color pull-left' id='new_added'>" 
                                                             .ucfirst($firstname)." ".ucfirst($lastname)."</a>
                                                        </span>
                                                        <br/>
                                                        <span style='font-size:10px;'>"
                                                           .$rank."
                                                        </span>
                                                    </div>
                                                </a>
                                               </div>
                                          </div>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
	        </div>
            <?php include_once 'html_comp/kanban.php'; ?>
        </div>
        <div class="span3" style="padding-top: 20px;">
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
        </div>
            