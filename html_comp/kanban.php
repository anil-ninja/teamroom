<?php
include_once 'functions/delete_comment.php';
$openChallenges = "";
$open_chalange_of_project = mysqli_query($db_handle, "select challenge_id, challenge_title,creation_time from challenges WHERE project_id = '$team_project_id' 
														AND (challenge_type = '1' or challenge_type = '2') and challenge_status = '1' ;");
while ($open_chalange_of_projectrow = mysqli_fetch_array($open_chalange_of_project)) {
    //$first_name1 = $open_chalange_of_projectrow['first_name'];
    //$last_name2 = $open_chalange_of_projectrow['last_name'];
    $challenge_id11 = $open_chalange_of_projectrow['challenge_id'];
    $challenge_title11 = $open_chalange_of_projectrow['challenge_title'];
    $challenge_created1 = $open_chalange_of_projectrow['creation_time'];
    $openChallenges .= "<div class='col-xs-6 col-md-4' style='height:135px;'>
                <div class='panel panel-default'>
                  <div class = 'panel-heading' style = 'font-size:10px;'>
                    <span class='glyphicon glyphicon-question-sign'></span>
                    $challenge_created1
                  </div>
                  <div class='panel-body' style='padding: 5px;height:90px'>
                    <a href='challengesOpen.php?challenge_id=$challenge_id11'>" 
                    .ucfirst($challenge_title11)."</a>
                  </div>
                </div>
            </div>";
}

$td2 = "";
//$td2_delay ="";
$td5 = "";
$td3 = "";
$td4 = "";

$kanban2 = mysqli_query($db_handle, "select a.user_id, b.username, b.first_name,b.last_name, b.rank 
                                    from teams as a join user_info as b 
                                    where a.project_id = '$team_project_id'
                                            and a.team_name = '$team_name' 
                                            and a.user_id = b.user_id AND a.member_status=1;");
while ($kanban2row = mysqli_fetch_array($kanban2)) {
    $first_name2 = $kanban2row['first_name'];
    $last_name2 = $kanban2row['last_name'];
    
    $username2 = $kanban2row['username'];
    $user_id2 = $kanban2row['user_id'];
    $rank2 = $kanban2row['rank'];

    $kanban3 = mysqli_query($db_handle, "select DISTINCT a.challenge_id, a.challenge_title, a.challenge_status, a.challenge_ETA, b.first_name, b.username from challenges as a join
										user_info as b join challenge_ownership as c WHERE a.project_id = '$team_project_id' 
										 AND a.challenge_id = c.challenge_id and a.user_id = b.user_id and c.user_id = '$user_id2' ;");
    while ($kanban3row = mysqli_fetch_array($kanban3)) {
        $name3 = $kanban3row['first_name'];
        $username3 = $kanban3row['username'];
        $challenge_id12 = $kanban3row['challenge_id'];
        $challenge_title12 = $kanban3row['challenge_title'];
        $status3 = $kanban3row['challenge_status'];
        $challenge_ETA12 = $kanban3row['challenge_ETA'];
        if ($status3 == 2) {
            $td2 .= "<p style='font-size: 10px;'><a href='challengesOpen.php?challenge_id=$challenge_id12'>
                        ".$challenge_title12."</a></p><hr/>";

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
        if ($status3 == 4) {
            $td3 .= "<p style='font-size: 10px;'>Created By " . $name3 . "</p><br/>" . $challenge_title12 . "<hr/>";
        }
        if ($status3 == 5) {
            $td4 .= "<p style='font-size: 10px;'>Created By " . $name3 . "</p><br/>" . $challenge_title12 . "<hr/>";
        }
    }
    $td5 .= "<tr>
                <td style='font-size: 10px; width:150px;'><img src='uploads/profilePictures/$username2.jpg'  style='width:30px; height:30px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
                      <span class='color strong pull-left'><a href ='profile.php?username=".$username2."'>" 
                    .ucfirst($first_name2)." ".ucfirst($last_name2)."</a></span><br/>".$rank2."</td>
                <td style='width:150px;'>" . $td2 . "</td>
                <td style='width:150px;'>". $td3 . "</td>
                <td style='width:150px;'>" . $td4 . "</td>
            </tr>";
           // <td style='width:150px;'>" .$td2_delay."</td>
    $td2 = "";
    //$td2_delay ="";
    $td3 = "";
    $td4 = "";
}
//<th style='width:150px;'>Delay</th>
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
            " . $td2 . "
          </div>
        </div>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <h3 class='panel-title'>Work In Review</h3>
          </div>
          <div class='panel-body'>
            " . $td1 . "
          </div>
        </div>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <h3 class='panel-title'>Completed</h3>
          </div>
          <div class='panel-body'>
            " . $td1 . "
          </div>
        </div>

        <table class='table table-striped' border='1' style='background-color: #fff;'>
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
        </table>";
   
   $team_name = $_GET['team_name'];
   $team_project_id = $_GET['project_id'];
   $kanban5 = mysqli_query($db_handle, "select a.challenge_id, b.challenge_title, b.challenge_status from team_tasks as a join challenges as b
										WHERE a.project_id = '$team_project_id' and a.team_name = '$team_name' AND a.challenge_id = b.challenge_id ;");
    while ($kanban5row = mysqli_fetch_array($kanban5)) {
        $challenge_id15 = $kanban5row['challenge_id'];
        $challenge_title15 = $kanban5row['challenge_title'];
        $status5 = $kanban5row['challenge_status'];
        echo $challenge_id15."<br/>".$challenge_title15."<br/>".$status5."<hr/>" ;
		}
?>
