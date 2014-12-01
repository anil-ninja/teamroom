<?php

function user_articles ($db_handle, $user_id) {
    $user_articles_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, LEFT(a.stmt, 500) as stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=7 AND a.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, LEFT(b.stmt, 500) as stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=7 AND a.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY challenge_id DESC;");
    while($user_articles_displayRow= mysqli_fetch_array($user_articles_display)) {
        $article_id=$user_articles_displayRow['challenge_id'];
        $article_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_articles_displayRow['challenge_title'])));
        $article_stmt1 = $user_articles_displayRow['stmt'];
        $article_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $article_stmt1)));
        $article_firstname = $user_articles_displayRow['first_name'];
        $article_lastname = $user_articles_displayRow['last_name'];
        $article_username = $user_articles_displayRow['username'];
        $article_created1 = $user_articles_displayRow['creation_time'];
        $article_created = date("j F, g:i a", strtotime($article_created1));
        echo "<div class='list-group articlesch'>
                <div class='list-group-item' style='line-height: 16.50px;'>
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-book'></span>
                        <img src='uploads/profilePictures/$article_username.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>";
        if (isset($_SESSION['user_id'])) {
            $user_session_id = ($_SESSION['user_id']);
            dropDown_delete_article($db_handle, $article_id, $user_session_id);
        }
            echo "<span class='color strong'><a href ='profile.php?username=" . $article_username . "'>"
                        . ucfirst($article_firstname) . '&nbsp' . ucfirst($article_lastname) . " </a></span>
                    <br> " . $article_created . "<br/><br/>
                </div>";
    
        echo "<div class='list-group-item'>
                <a class='btn-link' style='color:#3B5998; font-size: 14pt;' href='challengesOpen.php?challenge_id=".$article_id."' target='_blank'><strong>
                        <p align='center'>"                          
                        .ucfirst($article_title)."</p></strong></a><br>
                ".$article_stmt."<br><br>";
        comments_all_type_challenges ($db_handle, $article_id);
        echo "</div>";
    }
}
function user_challenges ($db_handle, $user_id) {
    $user_challenges_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, b.user_id, LEFT(a.stmt, 200) as stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN challenge_ownership as b JOIN user_info as c 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_id AND b.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=c.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, c.user_id, LEFT(b.stmt, 200) as stmt, d.first_name, d.last_name, d.username FROM challenges as a JOIN blobs as b JOIN challenge_ownership as c JOIN user_info as d 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_id AND c.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=d.user_id) ORDER BY challenge_id DESC;");
    while($user_challenges_displayRow= mysqli_fetch_array($user_challenges_display)) {
        $challenge_id=$user_challenges_displayRow['challenge_id'];
        $challenge_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_challenges_displayRow['challenge_title'])));
        $challenge_stmt1 = $user_challenges_displayRow['stmt'];
        $challenge_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $challenge_stmt1)));
        $you_owned_or_not = $user_challenges_displayRow['user_id'];
        $chall_firstname = $user_challenges_displayRow['first_name'];
        $chall_lastname = $user_challenges_displayRow['last_name'];
        $chall_username = $user_challenges_displayRow['username'];
        $chall_creation1 = $user_challenges_displayRow['creation_time'];
        $chall_creation = date("j F, g:i a", strtotime($chall_creation1));
        echo "<div class='list-group challenge'>
                <div class='list-group-item' >";
        if (isset($_SESSION['user_id'])) {
            $user_session_id = ($_SESSION['user_id']);
            dropDown_challenge($db_handle, $challenge_id, $user_session_id, "");
        }
        echo "<div class='pull-left lh-fix'>     
                <span class='glyphicon glyphicon-question-sign'>
                <img src='uploads/profilePictures/$chall_username.jpg'  onError=this.src='img/default.gif' 
                style='width: 50px; height: 50px'></span>&nbsp &nbsp
            </div>
            <span class='color strong'><a href ='profile.php?username=" . $chall_username . "'>"
                .ucfirst($chall_firstname) . '&nbsp' . ucfirst($chall_lastname) . " </a></span><br/>" 
                .$chall_creation."<br/><br/>
            </div>";
	echo "<div class='list-group-item'>
                <a class='btn-link' style='color:#3B5998; font-size: 14pt;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'><strong>
                        <p align='center'>"                          
                        .ucfirst($challenge_title)."</p></strong></a><br>
                ".$challenge_stmt."<br><br>";
         comments_all_type_challenges ($db_handle, $challenge_id);
         echo "</div>";
    }
}
function user_idea ($db_handle, $user_id) {
    $user_idea_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, LEFT(a.stmt, 500) as stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=4 AND a.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, LEFT(b.stmt, 500) as stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=4 AND a.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY challenge_id DESC;");
    while($user_idea_displayRow= mysqli_fetch_array($user_idea_display)) {
        $idea_id= $user_idea_displayRow['challenge_id'];
        $idea_title =str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_idea_displayRow['challenge_title'])));
        $idea_stmt1 = $user_idea_displayRow['stmt'];
        $idea_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $idea_stmt1)));
        $idea_creation1 = $user_idea_displayRow['creation_time'];
        $idea_creation = date("j F, g:i a", strtotime($idea_creation1));
        $idea_firstname = $user_idea_displayRow['first_name'];
        $idea_lastname = $user_idea_displayRow['last_name'];
        $idea_username = $user_idea_displayRow['username'];
        echo "<div class='list-group idea'>
                        <div class='list-group-item' style='line-height: 16.50px;'></span>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-flash'></span>
                                <img src='uploads/profilePictures/$idea_username.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>";
        if (isset($_SESSION['user_id'])) {
            $user_session_id = ($_SESSION['user_id']);
            dropDown_delete_idea($db_handle, $idea_id, $user_session_id);
        }
                    echo "<span class='color strong'><a href ='profile.php?username=" . $idea_username . "'>"
                                        .ucfirst($idea_firstname) . '&nbsp' . ucfirst($idea_lastname) . " </a></span><br>" . $idea_creation . "<br/><br/>
                        </div>";
         echo "<div class='list-group-item'>
                <a class='btn-link' style='color:#3B5998; font-size: 14pt;' href='challengesOpen.php?challenge_id=".$idea_id."' target='_blank'><strong>
                        <p align='center'>"                          
                        .ucfirst($idea_title)."</p></strong></a><br>
                ".$idea_stmt."<br><br>";
         comments_all_type_challenges ($db_handle, $idea_id);
         echo "</div>";
    }
}

function created_projects ($db_handle, $user_id) {
    $project_created_display = mysqli_query($db_handle, "(SELECT a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.user_id = $user_id AND a.blob_id=0 AND a.project_type=1 AND a.user_id=b.user_id)
                                                        UNION 
                                                        (SELECT a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a JOIN blobs as b JOIN user_info as c 
                                                            WHERE a.user_id = $user_id AND a.blob_id=b.blob_id AND a.project_type=1 AND a.user_id=c.user_id);");
    
        while($project_table_displayRow = mysqli_fetch_array($project_created_display)) {
            $project_title_table = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_table_displayRow['project_title'])));
            $project_stmt_table1 = $project_table_displayRow['stmt'];
            $project_stmt_table = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_stmt_table1)));
            $project_id_table = $project_table_displayRow['project_id'];
            $fname = $project_table_displayRow['first_name'];
            $projectcreation1 = $project_table_displayRow['creation_time'];
            $projectcreation = date("j F, g:i a", strtotime($projectcreation1));
            $lname = $project_table_displayRow['last_name'];
            $username_project = $project_table_displayRow['username'];
            echo "<div class='list-group'>
                    <div class='list-group-item'>
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_project.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>";
                    echo "<div class='row'>
                            <div class='col-md-4'>
                                <span class='color strong' style= 'color :lightblue;'>
                                    <a href ='profile.php?username=" . $username_project . "'>" . ucfirst($fname) . '&nbsp' . ucfirst($lname) . "</a>
                                </span>  <br>" . $projectcreation . "
                            </div>";
                    echo "</div>
                        </div>
                    </div>
                    <div class='list-group-item'>
                    <span class='color strong' style= 'font-size: 14pt; color :#3B5998;'><p align='center'>" . str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", ucfirst($project_title_table)))) . "</p></span>                
                        ".$project_stmt_table."<br><br>";
                    project_comments($db_handle, $project_id_table);
               echo "</div>";

        }   
    }
    
function joined_projects ($db_handle, $user_id) {
    $project_created_display = mysqli_query($db_handle, "(SELECT a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.project_id IN (SELECT teams.project_id from teams where teams.user_id = $user_id) AND a.user_id != $user_id and a.project_type = 1 AND a.blob_id = 0 AND a.user_id = b.user_id)
                                                        UNION 
                                                        (SELECT a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a 
                                                            JOIN user_info as c JOIN blobs as b WHERE a.project_id IN( SELECT teams.project_id from teams where teams.user_id = $user_id) AND a.user_id != $user_id AND a.project_type = 1 AND a.blob_id = b.blob_id AND a.user_id = c.user_id);");
        while($project_table_displayRow = mysqli_fetch_array($project_created_display)) {
            $project_title_table = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_table_displayRow['project_title'])));
            $project_stmt_table1 = $project_table_displayRow['stmt'];
            $project_stmt_table = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_stmt_table1)));
            $project_id_table = $project_table_displayRow['project_id'];
            $fname = $project_table_displayRow['first_name'];
            $projectcreation1 = $project_table_displayRow['creation_time'];
            $projectcreation = date("j F, g:i a", strtotime($projectcreation1));
            $lname = $project_table_displayRow['last_name'];
            $username_project = $project_table_displayRow['username'];
            echo "<div class='list-group'>
                    <div class='list-group-item' style='line-height: 24.50px;'>
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_project.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <span class='color strong' style= 'color :lightblue;'>
                            <a href ='profile.php?username=" . $username_project . "'>" . ucfirst($fname) . '&nbsp' . ucfirst($lname) . "</a>
                        </span><br>" . $projectcreation . "
                    </div>
                    <div class='list-group-item'>
                        <span class='color strong' style= 'font-size: 14pt; color :#3B5998;'><p align='center'>" . str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", ucfirst($project_title_table)))) . "</p></span>
                            ".$project_stmt_table."<br><br>";
                    project_comments($db_handle, $project_id_table);
               echo "</div>";
        }   
    }

function project_comments($db_handle, $project_id) {
    $username = $_SESSION['username'];
    $displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$project_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '1')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$project_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");
    while ($displayrowc = mysqli_fetch_array($displayb)) {
        $frstnam = $displayrowc['first_name'];
        $lnam = $displayrowc['last_name'];
        $username_pr_comment = $displayrowc['username'];
        $ida = $displayrowc['response_pr_id'];
        $projectres = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $displayrowc['stmt'])));
        echo "<div id='commentscontainer'>
                <div class='comments clearfix'>
                    <div class='pull-left lh-fix'>
                        <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                    </div>
                    <div class='comment-text'>
                        <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a>&nbsp</span> 
                        <small>" . $projectres . "</small>";
                if (isset($_SESSION['user_id'])) {
                    $user_session_id = ($_SESSION['user_id']);
                    dropDown_delete_comment_project($db_handle, $ida, $user_session_id);
                }
            echo "</div>
                </div> 
            </div>";
    }
    echo "<div class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='uploads/profilePictures/" . $username . ".jpg'  onError=this.src='img/default.gif'>&nbsp
            </div>";
    if (isset($_SESSION['user_id'])) {
    echo "<form method='POST' class='inline-form'>
            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 85%; height: 30px;' name='pr_resp' placeholder='Comment' />
            <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_project' ></button>
        </form>";
    } 
    else {
        echo "<form action='' method='POST' class='inline-form'>
                <input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Whats on your mind about this Challenge'/>
                <a data-toggle='modal' data-target='#SignIn'>
                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                </a>
            </form>";
    }
echo "</div>
    </div>";
}

function comments_all_type_challenges ($db_handle, $challenge_id) {
    $username = $_SESSION['username'];
        $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $challenge_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$challenge_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        //$challenge_ID = $commenterRow['challenge_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$commenterRow['stmt'])));
        echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp&nbsp&nbsp" .$comment_all_ch ;
        if (isset($_SESSION['user_id'])) {
            $user_session_id = ($_SESSION['user_id']);
            dropDown_delete_comment_challenge($db_handle, $comment_id, $user_session_id);
        }
        echo "</div></div></div>";
    }
    echo "<div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$challenge_id."'
                             placeholder='Whats on your mind about this'/>
                            <button type='submit' class='btn-primary btn-sm' onclick='comment(".$challenge_id.")' ><span class='glyphicon glyphicon-chevron-right'></span></button>
                    </div>";
    echo "</div>";
}
?>