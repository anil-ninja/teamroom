<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';

if ($_POST['next_JnPr']) {
    $profile_user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['next_JP_3'];
    $username = $_SESSION['username'];
    $a = (int) $limit;
    $b = $a + 3;
    
    
    $project_created_display = mysqli_query($db_handle, "(SELECT a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.project_id IN (SELECT teams.project_id from teams where teams.user_id = $profile_user_id) AND a.user_id != $profile_user_id and a.project_type = 1 AND a.blob_id = 0 AND a.user_id = b.user_id)
                                                        UNION 
                                                        (SELECT a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a 
                                                            JOIN user_info as c JOIN blobs as b WHERE a.project_id IN( SELECT teams.project_id from teams where teams.user_id = $profile_user_id) AND a.user_id != $profile_user_id AND a.project_type = 1 AND a.blob_id = b.blob_id AND a.user_id = c.user_id) ORDER BY project_id DESC LIMIT $a, $b;");
    $show_JP = "";
        while($project_table_displayRow = mysqli_fetch_array($project_created_display)) {
            $i++;
            $project_title_table = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_table_displayRow['project_title'])));
            $project_stmt_table1 = $project_table_displayRow['stmt'];
            $project_stmt_table = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_stmt_table1)));
            $project_id_table = $project_table_displayRow['project_id'];
            $fname = $project_table_displayRow['first_name'];
            $projectcreation1 = $project_table_displayRow['creation_time'];
            $projectcreation = date("j F, g:i a", strtotime($projectcreation1));
            $lname = $project_table_displayRow['last_name'];
            $username_project = $project_table_displayRow['username'];
            $user_id_project = $project_table_displayRow['user_id'];
            
            $show_JP = $show_JP. "<div class='list-group'>
                                    <div class='list-group-item'>";
            if ($user_id_project == $_SESSION['user_id'] && isset($_SESSION['user_id'])) {
                $show_JP = $show_JP.  "<div class='pull-right'>
                        <div class='list-group-item'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                <li><button class='btn-link' href='#'>Edit Project</button></li>
                                <li><button class='btn-link' pID='" . $project_id_table . "' onclick='delProject(" . $project_id_table . ");'>Delete Project</button></li>
                            </ul>
                        </div>
                    </div>";
            }
            $show_JP = $show_JP. "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                                    <a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$project_id_table."' target='_blank'>" 
                                    .ucfirst($project_title_table)."</a></b></p>
                                <span style= 'color: #808080'>By: <a href ='profile.php?username=" . $username_project . "'>"
                                    .ucfirst($fname)." ".ucfirst($lname)."</a> | ".$projectcreation."</span> 
                                </div>
                            <div class='list-group-item'>
                        <br/>".$project_stmt_table."</span><br/><br/>";
                                       
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
        $projectres = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $displayrowc['stmt'])));
        $comment_user_id = $displayrowc['user_id'];
       
$show_JP = $show_JP.  "<div id='commentscontainer'>
                <div class='comments clearfix'>
                    <div class='pull-left lh-fix'>
                        <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                    </div>
                    <div class='comment-text'>
                        <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a>&nbsp</span> 
                        <small>" . $projectres . "</small>";
                if (isset($_SESSION['user_id'])) {
$show_JP = $show_JP. "<div class='list-group-item pull-right'>
                        <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
                        <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            
                    if($comment_user_id == $_SESSION['user_id']) {
                        $show_JP = $show_JP. "<li><button class='btn-link' pID='".$ida."' onclick='del_project_comment(".$ida.");'>Delete</button></li>";
                    } 
                    else {
                       $show_JP = $show_JP. "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                    <button type='submit' name='spem_prresp' value='".$ida."' class='btn-link' >Report Spam</button>
                                </form>
                            </li>";
                    }
                $show_JP = $show_JP. "</ul>
        </div>";
                    
                }
            $show_JP = $show_JP. "</div>
                </div> 
            </div>";
    }
    $show_JP = $show_JP. "<div class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='uploads/profilePictures/" . $username . ".jpg'  onError=this.src='img/default.gif'>&nbsp
            </div>";
    if (isset($_SESSION['user_id'])) {
    $show_JP = $show_JP. "<form method='POST' class='inline-form'>
            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='pr_resp' placeholder='Want to know your comment....' />
            <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_project' ></button>
        </form>";
    } 
    else {
        $show_JP = $show_JP. "<form action='' method='POST' class='inline-form'>
                <input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
                <a data-toggle='modal' data-target='#SignIn'>
                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                </a>
            </form>";
    }
$show_JP = $show_JP. "</div>
    </div></div>";
}       
        
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['next_JP_3'] = $a + $i;
        echo $show_JP;
    }
}
    
?>