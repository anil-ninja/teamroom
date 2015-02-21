<?php
include_once '../lib/db_connect.php';
include_once '../functions/image_resize.php';
session_start();
if(!isset($_SESSION['user_id'])) 
    header ('location: index.php');
else {
    $user_id = $_SESSION['user_id'];
} 
if ($_POST['team']) {
	$pro_id = $_POST['project_id'];
    $data_display = "";
    $team_name = $_POST['team'];
    $teams_member_display = mysqli_query($db_handle, "SELECT b.user_id, b.first_name, b.username, b.last_name, a.team_name, a.team_owner, b.email,b.contact_no,b.rank 
                                                        FROM teams as a join user_info as b WHERE a.team_name = '$team_name' AND a.user_id = b.user_id 
                                                        AND a.member_status = '1' AND a.project_id='$pro_id' ORDER BY team_creation ASC;"
                                        );
    $total_members = mysqli_num_rows($teams_member_display);
    $data_display .= "
        <div class='row-fluid'>
            
                <div class='tab-content'>
                    <div class='list-group-item'>
                        <div class='alert_placeholder'> </div>
                        <a  style='font-size: 12pt; color :#3B5998;'>
                            <b>".ucfirst($team_name)."
                                <a class='badge'>".$total_members."
                                </a>
                            </b>
                        </a>";
    $teams_owner_add= mysqli_query($db_handle, "SELECT team_owner FROM teams WHERE team_owner = '$user_id' AND team_name = '$team_name' AND member_status = '1' and project_id='$pro_id';");
    $team_ownerRow = mysqli_fetch_array($teams_owner_add);
    $team_owner_project = $team_ownerRow['team_owner'];
    if ($team_owner_project == $user_id) {
        $data_display = $data_display. "<a href='#' class='btn btn-link pull-right' onclick='add_Team_Member(\"".$team_name."\")'> + Add New Teammate </a>";
    }
    $data_display = $data_display. "
                    </div>
                    <div class='list-group-item'>" ;
    $member_project = mysqli_query($db_handle, "select * from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
	if(mysqli_num_rows($member_project) != 0) {
		$data_display = $data_display."<a class='btn-link pull-right' data-toggle='modal' data-target='#AddTeam'>Create Team</a>" ;
	}
        $data_display = $data_display."<p style='color :#3B5998;' class='color strong'> Teams</p>
                            <div class ='row-fluid'>";

    $teams_name_display = mysqli_query($db_handle, "SELECT DISTINCT team_name, project_id FROM teams WHERE project_id='$pro_id';");

    while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
        $list_of_teams = $teams_name_displayRow['team_name'];
        $team_project_id = $teams_name_displayRow['project_id'];

        $data_display = $data_display. "
                            <div class='span4' style=' margin:4px; background : rgb(240, 241, 242);'>
                                <a class='btn-link' onclick='loadteampanel(\"".$pro_id."\",\"".$list_of_teams."\")' style='font-size: 12pt;'>"
                                    .ucfirst($list_of_teams)."
                                </a>
                            </div>";
    }
    $data_display = $data_display. "
                        </div>
                    </div>
                    <div class='list-group-item'>
						<p style='color :#3B5998;' class='color strong'> Team Members </p>
                        <div class='row-fluid team-member'>";

    while ($teams_member_displayRow = mysqli_fetch_array($teams_member_display)) {
        $firstname = $teams_member_displayRow['first_name'];
        $username = $teams_member_displayRow['username'];
        $lastname = $teams_member_displayRow['last_name'];
        $rank = $teams_member_displayRow['rank'];
        $user_id_member = $teams_member_displayRow['user_id'];
                
        $data_display = $data_display. "
                            <div class='span4' style=' margin:4px; background : rgb(240, 241, 242);'>";
        if ($team_owner_project == $user_id && $user_id_member != $user_id) {
            $data_display = $data_display. "
                                <a type='submit' class='btn-link badge pull-right' id='remove_member' onclick='remove_member(\"".$team_project_id."\", \"".$team_name."\", \"".$user_id_member."\");' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Teammate'>
                                    <i class='icon-remove'></i>
                                </a>";
        }
        else{
            $data_display = $data_display. "
                                <a class='btn-link badge pull-right'>
                                    <i class='icon-star'></i>
                                </a>";
        }

        $data_display = $data_display.  "
                            
                            <a href ='profile.php?username=" . $username . "'>
                                <div class ='span2'>
                                    <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  style='width:30px; height:30px;' onError=this.src='img/default.gif'>
                                </div>
                                <div class = 'span7' style='font-size:10px;'>
                                    <span class='color pull-left' id='new_added'>" 
                                         .ucfirst($firstname)." ".ucfirst($lastname)."
                                    </span><br>
                                    <span style='font-size:10px;'>"
                                       .$rank."
                                    </span>
                                </div>
                            </a>
                        </div>";
    }
                     
                        
    $data_display = $data_display. "        
                    </div>
                </div>
            </div>";
    
    //kanban started from here appended to team panel content
    $openChallenges = "";
    $open_chalange_of_project = mysqli_query($db_handle, "SELECT challenge_id, challenge_title, creation_time FROM challenges 
                                                            WHERE project_id = '$team_project_id' 
                                                                AND (challenge_type = '1' OR challenge_type = '2') 
                                                                AND challenge_status = '1' ;"
                                            );
    while ($open_chalange_of_projectrow = mysqli_fetch_array($open_chalange_of_project)) {
        //$first_name1 = $open_chalange_of_projectrow['first_name'];
        //$last_name2 = $open_chalange_of_projectrow['last_name'];
        $challenge_id11 = $open_chalange_of_projectrow['challenge_id'];
        $challenge_title11 = $open_chalange_of_projectrow['challenge_title'];
        $challenge_created1 = $open_chalange_of_projectrow['creation_time'];
        $openChallenges .= "
                    <div class='span6' style='height:135px; margin: 10px 5px 3px 0px;'>
                        <div class='panel panel-default'>
                            <div class = 'panel-heading' style = 'font-size:10px;'>
                                <span class='icon-question-sign'></span>".
                                $challenge_created1."
                            </div>
                            <div class='panel-body' style='padding: 5px;height:90px'>
                                <a href='challengesOpen.php?challenge_id=".$challenge_id11."'>" 
                                    .ucfirst($challenge_title11)."
                                </a>
                            </div>
                        </div>
                    </div>";
    }

    $acceptedChallenges = "";
    //$td2_delay ="";
    $submittedChallenges = "";
    $completedChallenges = "";

    $kanban3 = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_status, a.challenge_ETA, b.first_name, b.last_name, b.username 
                                            FROM challenges as a JOIN user_info as b join challenge_ownership as c 
                                            WHERE a.project_id = '$team_project_id' 
                                                AND a.challenge_id = c.challenge_id 
                                                AND c.user_id = b.user_id 
                                                AND a.challenge_status != '3' 
                                                AND a.challenge_status != '7'
                                                AND c.user_id 
                                                    IN (SELECT user_id FROM teams WHERE project_id = '$team_project_id' AND team_name = '$team_name' AND member_status = '1')
                                                AND a.challenge_id 
                                                    NOT IN (SELECT challenge_id FROM team_tasks WHERE project_id = '$team_project_id' AND team_name = '$team_name');"
                            );
    while ($kanban3row = mysqli_fetch_array($kanban3)) {
        $name3 = $kanban3row['first_name'];
        $lname3 = $kanban3row['last_name'];
        $username3 = $kanban3row['username'];
        $challenge_id12 = $kanban3row['challenge_id'];
        $challenge_title12 = $kanban3row['challenge_title'];
        $status3 = $kanban3row['challenge_status'];
        $challenge_ETA12 = $kanban3row['challenge_ETA'];
        switch($status3) {
            case 2:
                $acceptedChallenges .= "
                    <div class='span6' style='height:135px; margin: 10px 5px 3px 0px;'>
                        <div class='panel panel-default'>
                            <div class = 'panel-heading' style = 'font-size:10px;'>
                                <span class='icon-question-sign'></span>
                            </div>
                            <div class='panel-body' style='padding: 5px;height:90px'>
                                <a href='challengesOpen.php?challenge_id=$challenge_id12'>" 
                                    .ucfirst($challenge_title12)."
                                </a>
                            </div>
                        </div>
                    </div>";
                break;
            
            case 4:
                $submittedChallenges .= "
                    <div class='span6' style='height:135px; margin: 10px 5px 3px 0px;'>
                        <div class='panel panel-default'>
                            <div class = 'panel-heading' style = 'font-size:10px;'>
                                <span class='icon-question-sign'></span>
                            </div>
                            <div class='panel-body' style='padding: 5px;height:90px'>
                                <a href='challengesOpen.php?challenge_id=$challenge_id12'>" 
                                    .ucfirst($challenge_title12)."
                                </a>
                            </div>
                        </div>
                    </div>";
                break;
                
            case 5:
                $completedChallenges .= "
                    <div class='span6' style='height:135px; margin: 10px 5px 3px 0px;'>
                        <div class='panel panel-default'>
                            <div class = 'panel-heading' style = 'font-size:10px;'>
                                <span class='icon-question-sign'></span>
                            </div>
                            <div class='panel-body' style='padding: 5px;height:90px'>
                                <a href='challengesOpen.php?challenge_id=$challenge_id12'>" 
                                    .ucfirst($challenge_title12)."
                                </a>
                            </div>
                        </div>
                    </div>";
                break;
        }                   
    }

    $kanban5 = mysqli_query($db_handle, "SELECT a.challenge_id, b.challenge_title, b.challenge_status 
                                            FROM team_tasks as a join challenges as b
                                                WHERE a.project_id = '$team_project_id' 
                                                    AND a.team_name = '$team_name' 
                                                    AND a.challenge_id = b.challenge_id ;"
                            );
    $teamTasks = "";
    while ($kanban5row = mysqli_fetch_array($kanban5)) {
        $challenge_id15 = $kanban5row['challenge_id'];
        $challenge_title15 = $kanban5row['challenge_title'];
        $status5 = $kanban5row['challenge_status'];
        $teamTasks .= "
                    <div class='span6' style='height:135px; margin: 10px 5px 3px 0px;'>
                        <div class='panel panel-default'>
                            <div class = 'panel-heading' style = 'font-size:10px;'>
                                <span class=' icon-pushpin'></span>
                            </div>
                            <div class='panel-body' style='padding: 5px;height:90px'>
                                <a href='challengesOpen.php?challenge_id=".$challenge_id15."'>" 
                                    .ucfirst($challenge_title15)."
                                </a>
                            </div>
                        </div>
                    </div>";
    }

    $data_display = $data_display. "
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3 class='panel-title'>Open Challenges</h3>
                        </div>
                        <div class='panel-body'>
                            " . $openChallenges . "
                        </div>
                    </div>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3 class='panel-title'>Work In Progress</h3>
                        </div>
                        <div class='panel-body'>
                            " . $acceptedChallenges . $teamTasks."
                        </div>
                    </div>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3 class='panel-title'>Work In Review</h3>
                        </div>
                        <div class='panel-body'>
                            " . $submittedChallenges . "
                        </div>
                    </div>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3 class='panel-title'>Completed</h3>
                        </div>
                        <div class='panel-body'>
                            " . $completedChallenges . "
                        </div>
                    </div>
                </div>";
    echo $data_display;
}

?>

