<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';

if ($_POST['next_CP']) {
    $profile_user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['last_CP_3'];
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $a = (int) $limit;
    $b = $a + 3;
    $project_created_display = mysqli_query($db_handle, "(SELECT a.user_id, a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.user_id = $profile_user_id AND a.blob_id=0 AND a.project_type=1 AND a.user_id=b.user_id)
                                                        UNION 
                                                        (SELECT a.user_id, a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a JOIN blobs as b JOIN user_info as c 
                                                            WHERE a.user_id = $profile_user_id AND a.blob_id=b.blob_id AND a.project_type=1 AND a.user_id=c.user_id) ORDER BY creation_time DESC LIMIT $a, $b;");
    //$_SESSION['last_CP_3'] = 3;
    $show_CP = "";
        while($project_table_displayRow = mysqli_fetch_array($project_created_display)) {
            $i ++;
            $project_title_table = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_table_displayRow['project_title']))));
            $projecttitletable = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_table_displayRow['project_title'])));
            $project_stmt_table1 = $project_table_displayRow['stmt'];
            $project_stmt_table = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_stmt_table1))));
            $projectstmttable = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_stmt_table1)));
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
                                <li><button class='btn-link' onclick='editproject(".$project_id_table.")'>Edit Project</button></li>
                                <li><button class='btn-link' onclick='delChallenge(\"".$project_id_table."\", 4);'>Delete Project</button></li>
                            </ul>
                        </div>
                    </div>";
            }
            $show_CP = $show_CP. "<p id='project_ti_".$project_id_table."' class='text' style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                                    <a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$project_id_table."' target='_blank'>" 
                                    .ucfirst($project_title_table)."</a></b></p>
                                    <input type='text' class='editbox' style='width : 90%;' id='project_title_".$project_id_table."' value='".$projecttitletable."'/>
                                <span style= 'color: #808080'>By: <a href ='profile.php?username=" . $username_project . "'>"
                                    .ucfirst($fname)." ".ucfirst($lname)."</a> | ".$projectcreation."</span> 
                                </div>
                            <div class='list-group-item'>
                        <br/><span id='project_".$project_id_table."' class='text'>".$project_stmt_table."</span><br/><br/>";
     if(isset($_SESSION['user_id'])){
		if(substr($projectstmttable, 0, 1) != '<') {
			$show_CP = $show_CP. "<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_".$project_id_table."' >".str_replace("<br/>", "\n",$projectstmttable)."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedproject(".$project_id_table.")' id='project_doneedit_".$project_id_table."'/>";
			}
		else {
			if (substr($projectstmttable, 0, 4) == ' <br') {
			$show_CP = $show_CP. "<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_".$project_id_table."' >".str_replace("<br/>", "\n",$projectstmttable)."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedproject(".$project_id_table.")' id='project_doneedit_".$project_id_table."'/>";
				}
			if (substr($projectstmttable, 0, 3) == '<s>') {
			$show_CP = $show_CP. "<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_".$project_id_table."' >".str_replace("<br/>", "\n",$projectstmttable)."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedproject(".$project_id_table.")' id='project_doneedit_".$project_id_table."'/>";
				}
			$projectstmt1 = str_replace("<br/>", "\n",substr(strstr($projectstmttable, '<br/>'), 5)) ;
			$projectst1 = str_replace("<br/>", "\n",strstr($projectstmttable, '<br/>' , true)) ;
			if(substr($projectstmttable, 0, 4) == '<img') {
			$show_CP = $show_CP. "<div class='editbox' style='width : 90%;' id='project_pic_".$project_id_table."' >".$projectst1."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file_project(".$project_id_table.")' id='project_pic_file_".$project_id_table."'/><br/><br/>" ;
					}
			if(substr($projectstmttable, 0, 2) == '<a') {
			$show_CP = $show_CP. "<div class='editbox' style='width : 90%;' id='project_file_".$project_id_table."' >".$projectst1."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file_project(".$project_id_table.")' id='project_pic_file_".$project_id_table."'/><br/><br/>" ;
					}
			if(substr($projectstmttable, 0, 3) == '<if') {
			$show_CP = $show_CP. "<div class='editbox' style='width : 90%;' id='project_video_".$project_id_table."' >".$projectst1."</div>
					<input type='text' class='editbox' id='project_url_video_".$project_id_table."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
			$show_CP = $show_CP. "<input id='project_fileChallenge_".$project_id_table."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn-success btn-xs editbox' value='Upload New Photo/File' onclick='save_pic_file_project(".$project_id_table.")' id='pic_file_project_".$project_id_table."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'project_stmt_p_".$project_id_table."' >".$projectstmt1."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedpro(".$project_id_table.")' id='doneediting_project_".$project_id_table."'/>";		
			}
		}                                      
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
        $projectres = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $displayrowc['stmt']))));
        $comment_user_id = $displayrowc['user_id'];
$show_CP = $show_CP.  "<div id='commentscontainer'>
                <div class='comments clearfix'>
                    <div class='pull-left lh-fix'>
                        <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                    </div>
                    <div class='comment-text'>
                        <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a>&nbsp</span> 
                        <small>" . $projectres . "</small>";
                if (isset($_SESSION['user_id'])) {
	$show_CP = $show_CP. "<div class='list-group-item pull-right'>
                        <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
                        <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            
                    if($comment_user_id == $_SESSION['user_id']) {
                        $show_CP = $show_CP. "<li><button class='btn-link' onclick='delcomment(\"".$ida."\", 1);'>Delete</button></li>";
                    } 
                    else {
                       $show_CP = $show_CP. "<li><button class='btn-link' onclick='spem(\"".$ida."\", 10);'>Report Spam</button></li>";
                    }
                $show_CP = $show_CP. "</ul>
        </div>";                    
                }
            $show_CP = $show_CP. "</div>
                </div> 
            </div>";
    }
    $show_CP = $show_CP. "<div class='comments_".$project_id_table."'></div><div class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='uploads/profilePictures/" . $username . ".jpg'  onError=this.src='img/default.gif'>&nbsp
            </div>";
    if (isset($_SESSION['user_id'])) {
    $show_CP = $show_CP. "<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$project_id_table."'
						 placeholder='Want to know your comment....'/>
						<button type='submit' class='btn btn-primary' onclick='comment(\"".$project_id_table."\", 2)' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
						  <i class='icon-chevron-right'></i>
                        </button>";
    } 
    else {
        $show_CP = $show_CP. "<input type='text' class='input-block-level' STYLE='width: 86%;' placeholder='Want to know your comment....'/>
                            <a data-toggle='modal' data-target='#SignIn'>
                                <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                                    <i class='icon-chevron-right'></i>
                                </button>
                            </a>";
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
