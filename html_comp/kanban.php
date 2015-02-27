<?php
    include_once '../lib/db_connect.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    $team_name = 'Defaultteam';
	$openChallenges = "";
$open_chalange_of_project = mysqli_query($db_handle, "SELECT challenge_id, challenge_title, creation_time FROM challenges 
                                                        WHERE project_id = '$pro_id' 
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
      <div class='span6' style='height:135px;margin: 10px 5px 3px 0px;'>
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
                                      FROM challenges as a 
                                        JOIN user_info as b 
                                          JOIN challenge_ownership as c 
                                            WHERE a.project_id = '$pro_id' 
								                              AND a.challenge_id = c.challenge_id 
                                              AND c.user_id = b.user_id 
                                              AND a.challenge_status != '3' 
                                              AND a.challenge_status != '7'
								                              AND c.user_id 
                                                IN (SELECT user_id FROM teams WHERE project_id = '$pro_id' and team_name = '$team_name' AND member_status = '1')
								                              AND a.challenge_id 
                                                NOT IN (SELECT challenge_id FROM team_tasks WHERE project_id = '$pro_id' AND team_name = '$team_name');
                        ");
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

           //  This is commented because ETA is not used in this release     
           //  $delayed_challenges = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, b.comp_ch_ETA, b.ownership_creation from challenges as a 
           //                                                  join challenge_ownership as b 
           //                                                  where a.challenge_id=$challenge_id12 AND (a.challenge_type = '1' OR a.challenge_type = '2') AND a.challenge_status = '2' and a.challenge_id = b.challenge_id;") ;
           //  $delayed_challengesRow = mysqli_fetch_array($delayed_challenges);
           //  $comp_ch_ETA = $delayed_challengesRow['comp_ch_ETA'];
           //  $ownership_creation = $delayed_challengesRow['ownership_creation'];
           //  $delayed = remaining_time($ownership_creation, $comp_ch_ETA) ;
           //  if ($delayed == "Closed") {
           //     $td2_delay .= "<p style='font-size: 10px;'><a href='challengesOpen.php?challenge_id=$challenge_id12'>
           //             ".$challenge_title12."</a></p><hr/>";
           // }
            
        }
//<th style='width:150px;'>Delay</th>


       /* <table class='table table-striped' border='1' style='background-color: #fff;'>
            <thead>
                <tr>
                    <th>Team Members</th>
                    <th>In-Progress</th>
                    <th>In-Review</th>
                    <th>Completed</th>
                </tr>
            </thead>
            <tbody style='background-color: #fff;' >
                ".$td5."
            </tbody>
        </table>"; */
   
   $kanban5 = mysqli_query($db_handle, "SELECT a.challenge_id, b.challenge_title, b.challenge_status FROM team_tasks as a JOIN challenges as b
							                            WHERE a.project_id = '$pro_id' 
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
    </div>" ;
  }

    echo "
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
      </div>" ;
mysqli_close($db_handle); 
?>
