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
function dropDown_challenge($db_handle, $challenge_ID) {
    //echo $challenge_ID;
        echo "<div class='pull-right'>
            <div class='list-group-item'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                $challenge_status_display = mysqli_query($db_handle, ("SELECT challenge_status FROM challenges WHERE challenge_id = '$challenge_ID';"));
                    $challenge_status_displayRow = mysqli_fetch_array($challenge_status_display);
                    $challenge_status_accept_OR_submit = $challenge_status_displayRow['challenge_status'];
                    //echo $challenge_status_accept_OR_submit;
                            if ($challenge_status_accept_OR_submit == 1) {
                        echo "<li><a class='btn btn-default' >Accept</a></li>";
                    } else {
                        echo "<li><a class='btn btn-default' >Submit</a></li>";
                    }
                  echo "<li><a class='btn btn-default' href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                    <li><a class='btn btn-default' id='delChallenge' cID='".$challenge_ID."' onclick='delChallenge(".$challenge_ID.");'>Delete Challenge</a></li>
                    <li><a class='btn btn-default' >Change ETA</a></li>                    
                    <li><a class='btn btn-default' >Report Spam</a></li>";
                   
                    
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