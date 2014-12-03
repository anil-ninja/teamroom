<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';

if ($_POST['next_CP']) {
    $user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['last_CP_3'];
    $username = $_SESSION['username'];
    $a = (int) $limit;
    $b = $a + 3;
    
    
    $project_created_display = mysqli_query($db_handle, "(SELECT a.user_id, a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.user_id = $user_id AND a.blob_id=0 AND a.project_type=1 AND a.user_id=b.user_id)
                                                        UNION 
                                                        (SELECT a.user_id, a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a JOIN blobs as b JOIN user_info as c 
                                                            WHERE a.user_id = $user_id AND a.blob_id=b.blob_id AND a.project_type=1 AND a.user_id=c.user_id) ORDER BY creation_time DESC LIMIT $a, $b;");
    //$_SESSION['last_CP_3'] = 3;
    $show_CP = "";
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
            
            $show_CP = $show_CP. "<div class='list-group'>
                                    <div class='list-group-item'>";
            if ($user_id_project == $_SESSION['user_id'] && isset($_SESSION['user_id'])) {
                $show_CP = $show_CP.  "<div class='pull-right'>
                        <div class='list-group-item'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                <li><button class='btn-link' href='#'>Edit Project</button></li>
                                <li><button class='btn-link' pID='" . $project_id_table . "' onclick='delProject(" . $project_id_table . ");'>Delete Project</button></li>
                            </ul>
                        </div>
                    </div>";
            }
            $show_CP = $show_CP. "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                                    <a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$project_id_table."' target='_blank'>" 
                                    .ucfirst($project_title_table)."</a></b></p>
                                <span style= 'color: #808080'>By: <a href ='profile.php?username=" . $username_project . "'>"
                                    .ucfirst($fname)." ".ucfirst($lname)."</a> | ".$projectcreation."</span> 
                                </div>
                            <div class='list-group-item'>
                        <br/>".$project_stmt_table."</span><br/><br/>";
                                       
            $displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$project_id_table' and a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$project_id_table' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");
    while ($displayrowc = mysqli_fetch_array($displayb)) {
        $frstnam = $displayrowc['first_name'];
        $lnam = $displayrowc['last_name'];
        $username_pr_comment = $displayrowc['username'];
        $ida = $displayrowc['response_pr_id'];
        $projectres = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $displayrowc['stmt'])));
$show_CP = $show_CP.  "<div id='commentscontainer'>
                <div class='comments clearfix'>
                    <div class='pull-left lh-fix'>
                        <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                    </div>
                    <div class='comment-text'>
                        <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a>&nbsp</span> 
                        <small>" . $projectres . "</small>";
                if (isset($_SESSION['user_id'])) {
                    $user_session_id = ($_SESSION['user_id']);
                    //dropDown_delete_comment_project($db_handle, $ida, $user_session_id);
$show_CP = $show_CP. "<div class='list-group-item pull-right'>
                        <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
                        <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            
            $project_dropdown_comment = mysqli_query($db_handle, ("SELECT user_id FROM response_project WHERE response_pr_id = '$deleteid' AND user_id='$user_ID';"));
                    $project_dropdown_commentRow = mysqli_fetch_array($project_dropdown_comment);
                    $project_dropdown_comment_userID = $project_dropdown_commentRow['user_id'];
                    if($project_dropdown_comment_userID == $user_ID) {
                        $show_CP = $show_CP. "<li><button class='btn-link' pID='".$deleteid."' onclick='del_project_comment(".$deleteid.");'>Delete</button></li>";
                    } 
                    else {
                       $show_CP = $show_CP. "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                    <button type='submit' name='spem_prresp' value='".$deleteid."' class='btn-link' >Report Spam</button>
                                </form>
                            </li>";
                    }
                $show_CP = $show_CP. "</ul>
        </div>";
                    
                }
            $show_CP = $show_CP. "</div>
                </div> 
            </div>";
    }
    $show_CP = $show_CP. "<div class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='uploads/profilePictures/" . $username . ".jpg'  onError=this.src='img/default.gif'>&nbsp
            </div>";
    if (isset($_SESSION['user_id'])) {
    $show_CP = $show_CP. "<form method='POST' class='inline-form'>
            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='pr_resp' placeholder='Comment' />
            <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_project' ></button>
        </form>";
    } 
    else {
        $show_CP = $show_CP. "<form action='' method='POST' class='inline-form'>
                <input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Whats on your mind about this Challenge'/>
                <a data-toggle='modal' data-target='#SignIn'>
                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                </a>
            </form>";
    }
$show_CP = $show_CP. "</div>
    </div></div>";
}       
        
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['last_CP_3'] = $a + $i;
        echo $show_CP;
    }
}
    
?>