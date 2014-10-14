<?php 
//include_once './lib/db_connect.php';

function dropDown_delete_comment_challenge($db_handle, $deleteid, $user_ID) {
    echo  "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            
            $challenge_dropdown_comment = mysqli_query($db_handle, ("SELECT user_id FROM response_challenge WHERE response_ch_id = '$deleteid' AND user_id='$user_ID';"));
                    $challenge_dropdown_commentRow = mysqli_fetch_array($challenge_dropdown_comment);
                    $challenge_dropdown_comment_userID = $challenge_dropdown_commentRow['user_id'];
                    if($challenge_dropdown_comment_userID == $user_ID) {
                        echo "
                        <li><button class='btn-link' href='#'>Edit</button></li>
                        <li><button class='btn-link' cID='".$deleteid."' onclick='delcomment(".$deleteid.");'>Delete</button></li>";
                    } else {
                       echo "<li><button class='btn-link' >Report Spam</button></li>";
                    }
                echo "</ul>
        </div>";
}
function dropDown_delete_comment_project($db_handle, $deleteid, $user_ID) {
    echo  "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            
            $project_dropdown_comment = mysqli_query($db_handle, ("SELECT user_id FROM response_project WHERE response_pr_id = '$deleteid' AND user_id='$user_ID';"));
                    $project_dropdown_commentRow = mysqli_fetch_array($project_dropdown_comment);
                    $project_dropdown_comment_userID = $project_dropdown_commentRow['user_id'];
                    if($project_dropdown_comment_userID == $user_ID) {
                        echo "
                        <li><button class='btn-link' href='#'>Edit</button></li>
                        <li><button class='btn-link' pID='".$deleteid."' onclick='del_project_comment(".$deleteid.");'>Delete</button></li>";
                    } else {
                       echo "<li><button class='btn-link' >Report Spam</button></li>";
                    }
                echo "</ul>
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
                        <li><button class='btn-link' href='#'>Edit</button></li>
                        <li><button class='btn-link' cID='".$challenge_ID."' onclick='delChallenge(".$challenge_ID.");'>Delete</button></li>
                        <li><form method='POST' class='inline-form'>";                    
                        if($remaining_time_ETA_over == 'Time over') {        
                            echo "<input type='hidden' name='id' value='".$challenge_ID."'/>
                                <input class='btn-link' type='submit' name='eta' value='Change ETA'/>";
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
?>