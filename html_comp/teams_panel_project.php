<?php
include_once '../lib/db_connect.php';

session_start();
if(!isset($_SESSION['user_id'])) 
    header ('location: index.php');
else {
    $user_id = $_SESSION['user_id'];
    $pro_id = $_GET['project_id'];
} 
$team_name = 'Defaultteam';

$teams_member_display = mysqli_query($db_handle, "select b.user_id, b.first_name, b.username, b.last_name, a.team_name, a.team_owner, b.email,b.contact_no,b.rank 
                                                    from teams as a join user_info as b where a.team_name = '$team_name' AND a.user_id = b.user_id and a.member_status = '1' and a.project_id='$pro_id' ORDER BY team_creation ASC;");
$total_members = mysqli_num_rows($teams_member_display);
?>

        <div class="row-fluid">
                <div class="tab-content">
                    <div class='list-group-item'>
                        <a  style='font-size: 12pt; color :#3B5998;'>
                            <b><?= ucfirst($team_name)." <a class='badge'>".$total_members."</a>";?></b>
                        </a>
                   
        <?php
            $teams_owner_add= mysqli_query($db_handle, "SELECT team_owner FROM teams WHERE team_owner = '$user_id' AND team_name = '$team_name' AND member_status = '1' and project_id='$pro_id';");
            $team_ownerRow = mysqli_fetch_array($teams_owner_add);
            $team_owner_project = $team_ownerRow['team_owner'];
            if ($team_owner_project == $user_id) {
                echo "<a href='#' class='btn btn-link pull-right' onclick='add_Team_Member(\"".$team_name."\")'> + Add New Teammate </a>";
            }
        ?>
                    </div>
                    <div class='list-group-item'>
            <?php
            $member_project = mysqli_query($db_handle, "select user_id from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
			if(mysqli_num_rows($member_project) != 0) {
				echo "<a class='btn-link pull-right' onclick='add_New_Team()'>Create Team</a>" ;
			}
                echo "<p style='color :#3B5998;' class='color strong'> Teams </p>
                        <div class ='row-fluid' id='ProjectTeams'>";
                $teams_name_display = mysqli_query($db_handle, "SELECT DISTINCT team_name FROM teams WHERE project_id = '$pro_id' ;") ;
                while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                    $list_of_teams = $teams_name_displayRow['team_name'];
                    echo "  <div class='span4' style=' margin:4px; background : rgb(240, 241, 242);'>
                                <a class='btn-link' onclick='loadteampanel(\"".$pro_id."\",\"".$list_of_teams."\")' style='font-size: 12pt;'>"
                                    .ucfirst($list_of_teams)."
                                </a>
                            </div>";
                }
                echo "  </div>";
        ?>
                    </div>
                    <div class='list-group-item'>

<?php
    echo "<p style='color :#3B5998;' class='color strong'> Team Members </p><div class='row-fluid team-member'>";
    while ($teams_member_displayRow = mysqli_fetch_array($teams_member_display)) {
        $firstname = $teams_member_displayRow['first_name'];
        $username = $teams_member_displayRow['username'];
        $lastname = $teams_member_displayRow['last_name'];
        $rank = $teams_member_displayRow['rank'];
        $user_id_member = $teams_member_displayRow['user_id'];
        
        echo "<div class='span4' style=' margin:4px; background : rgb(240, 241, 242);'>";

            if ($team_owner_project == $user_id && $user_id_member != $user_id) {
                        echo "  <a type='submit' class='btn-link badge pull-right' id='remove_member' onclick='remove_member(\"".$pro_id."\", \"".$team_name."\", \"".$user_id_member."\");' 
										data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Teammate'>
                                    <span class='icon-remove'></span>
                                </a>";
            }
            else{
                echo "          <a class='btn-link badge pull-right'>
                                    <span class='icon-star'>
                                </a>";
            }

                        echo "<a href ='profile.php?username=" . $username . "'>
                                <div class ='span2'>
                                    <img src='uploads/profilePictures/$username.jpg'  style='width:30px; height:35px;' onError=this.src='img/default.gif'>
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
            echo "  </div>";
        ?>
        </div>
   </div>    
   <?php include_once 'kanban.php'; ?> 
