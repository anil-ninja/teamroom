<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';
include_once '../../functions/image_resize.php';

if ($_POST['next_JnPr']) {
    $profile_user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['next_JP'];
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $ajoin = (int) $limit;
    $bjoin = $ajoin + 3;    
    $project_created_display = mysqli_query($db_handle, "(SELECT a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.project_id IN (SELECT teams.project_id from teams where teams.user_id = $profile_user_id) AND a.user_id != $profile_user_id and a.project_type = 1 AND a.blob_id = 0 AND a.user_id = b.user_id)
                                                        UNION 
                                                        (SELECT a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a 
                                                            JOIN user_info as c JOIN blobs as b WHERE a.project_id IN( SELECT teams.project_id from teams where teams.user_id = $profile_user_id) AND a.user_id != $profile_user_id AND a.project_type = 1 AND a.blob_id = b.blob_id AND a.user_id = c.user_id) ORDER BY creation_time DESC LIMIT $ajoin, $bjoin;");
        $show_JP = "";
        while($project_table_displayRow = mysqli_fetch_array($project_created_display)) {
            $i ++;
            $project_title_table = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_table_displayRow['project_title'])))));
            $project_stmt_table1 = $project_table_displayRow['stmt'];
            $project_stmt_table = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_stmt_table1)))));
            $project_id_table = $project_table_displayRow['project_id'];
            $fname = $project_table_displayRow['first_name'];
            $projectcreation1 = $project_table_displayRow['creation_time'];
            $projectcreation = date("j F, g:i a", strtotime($projectcreation1));
            $lname = $project_table_displayRow['last_name'];
            $username_project = $project_table_displayRow['username'];
            $user_id_project = $project_table_displayRow['user_id'];
            
            $show_JP = $show_JP. "<div class='list-group'>
                                    <div class='list-group-item'>";
            $show_JP = $show_JP. "<span style='font-family: Tenali Ramakrishna, sans-serif;'><b>
                                    <a style='color:#3B5998;font-size: 26px;' href='project.php?project_id=".$project_id_table."' target='_blank'>" 
                                    .ucfirst($project_title_table)."</a></b></span><br/>
                                <span style= 'color: #808080;'>By: <a href ='profile.php?username=" . $username_project . "' style= 'color: #808080;'>"
                                    .ucfirst($fname)." ".ucfirst($lname)."</a> | ".$projectcreation."</span> 
                                <hr/><span style='font-size: 14px;'>".$project_stmt_table."</span><br/>";
                                       
            $displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.user_id, a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$project_id_table' and a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.user_id, c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$project_id_table' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");
    while ($displayrowc = mysqli_fetch_array($displayb)) {
        $frstnam = $displayrowc['first_name'];
        $lnam = $displayrowc['last_name'];
        $username_pr_comment = $displayrowc['username'];
        $ida = $displayrowc['response_pr_id'];
        $projectres = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $displayrowc['stmt'])))));
        $comment_user_id = $displayrowc['user_id'];
$show_JP = $show_JP.  "<div id='commentscontainer'>
                <div class='comments clearfix' id='comment_".$ida."'>
                    <div class='pull-left lh-fix'>
                        <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
                    </div>";
                if (isset($_SESSION['user_id'])) {
$show_JP = $show_JP. "<div class='list-group-item pull-right'>
                        <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
                        <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            
                    if($comment_user_id == $_SESSION['user_id']) {
                        $show_JP = $show_JP. "<li><button class='btn-link' onclick='delcomment(\"".$ida."\", 1);'>Delete</button></li>";
                    } 
                    else {
                       $show_JP = $show_JP. "<li><button class='btn-link' onclick='spem(\"".$ida."\", 10);'>Report Spam</button></li>";
                    }
                $show_JP = $show_JP. "</ul>
        </div>";
                    
                }
            $show_JP = $show_JP. "<div class='comment-text'>
                        <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a>&nbsp;&nbsp;</span> 
                        <small>" . $projectres . "</small>
                        </div>
                </div> 
            </div>";
    }
    $show_JP = $show_JP. "<div class='comments_".$project_id_table."'></div><div class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
            </div>";
    if (isset($_SESSION['user_id'])) {
    $show_JP = $show_JP. "<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$project_id_table."'
						 placeholder='Want to know your comment....'/>
						<button type='submit' class='btn btn-primary' onclick='comment(\"".$project_id_table."\", 2)' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
						  <i class='icon-chevron-right'></i>
                        </button>";
    } 
    else {
        $show_JP = $show_JP. "<input type='text' class='input-block-level' STYLE='width: 86%;' placeholder='Want to know your comment....'/>
                            <a data-toggle='modal' data-target='#SignIn'>
                                <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                                    <i class='icon-chevron-right'></i>
                                </button>
                            </a>";
    }
$show_JP = $show_JP. "</div>
    </div></div>";
}       
        
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['next_JP'] = $ajoin + $i;
        echo $show_JP;
    }
}
 mysqli_close($db_handle);    
?>
