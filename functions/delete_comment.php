<?php 
//include_once './lib/db_connect.php';

function dropDown_delete_comment_challenge($deleteid) {
    echo  "<div class='pull-right'>
            <div class='list-group-item'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='themes'>
                    <li><a href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                    <li><a href='#' id='deleteComment' commentID='".$deleteid."' onclick='delcomment(".$deleteid.");' class='delete color'>Delete</a></li>
                </ul>
            </div>
        </div>";
}
function dropDown_delete_comment_project($deleteid) {
    echo  "<div class='pull-right'>
            <div class='list-group-item'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='themes'>
                    <li><a href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                    <li><a href='#' id='comment_projectID' comment_projectID='".$deleteid."' onclick='del_project_comment(".$deleteid.");' class='delete color'>Delete</a></li>            
                </ul>
            </div>
        </div>";
}
function dropDown_challenge($db_handle, $challenge_ID, $user_ID, $remaining_time_ETA_over) {
        echo "<div class='pull-right'>
            <div class='list-group-item'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$challenge_ID' AND user_id='$user_ID';"));
                    $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                    $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                    if($challenge_dropdown_userID == $user_ID) {
                        echo "
                        <li><button class='btn btn-link' href='#'>Edit Challenge</button></li>
                        <li><button class='btn btn-link' cID='".$challenge_ID."' onclick='delChallenge(".$challenge_ID.");'>Delete Challenge</button></li>
                        <li><form method='POST' class='inline-form'>";                    
                        if($remaining_time_ETA_over == 'Time over') {        
                            echo "<input type='hidden' name='id' value='".$chelangeid."'/>
                                <input class='btn btn-link' type='submit' name='eta' value='Change ETA'/>";
                            }                                    
                       echo "</form></li>";
                    }
                    else {
                       echo "<li><button class='btn btn-link' >Report Spam</button></li>";
                    } 
               echo "</ul>
              </div>
            </div>";
}

function dropDown_project($project_ID) {
    echo  "<div class='pull-right'>
            <div class='list-group-item'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='themes'>
                    <li><a class='btn btn-default' href='http://bootswatch.com/default/'>Edit Project</a></li>
                    <li><a class='btn btn-default' href='#' id='delProject' pID='".$project_ID."' onclick='delProject(".$project_ID.");' class='delete color'>Delete Project</a></li>         
                    <li><a class='btn btn-default' >Change ETA</a></li>                    
                    <li><a class='btn btn-default' >Report Spam</a></li>
                </ul>
            </div>
        </div>";
}
?>