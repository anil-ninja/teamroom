<?php
include_once 'delete_comment.php';
function user_articles ($db_handle, $user_IDF) {
    $user_articles_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, a.stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=7 AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, b.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=7 AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY creation_time DESC LIMIT 0, 3;");
    $_SESSION['last_article'] = 3;

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
        $totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$article_id' and like_status = '1' ;");
		if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
		else { $likes = '' ; }
		$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$article_id' and like_status = '2' ;");
		if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
		else { $dislikes = '' ; }
        echo "<div class='list-group articlesch'>
                <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
            $user_id = ($_SESSION['user_id']);
            dropDown_delete_after_accept($article_id, $user_id, $user_IDF) ;
        }
            echo "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$article_id."' target='_blank'>" 
                    .ucfirst($article_title)."</a></b></p>
                
                <span class='glyphicon glyphicon-book'></span><span style= 'color: #808080'> &nbsp; By: <a href ='profile.php?username=" . $article_username . "'>".ucfirst($article_firstname)." ".ucfirst($article_lastname)."</a> | ".$article_created."</span> | 
                    <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$article_id ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$article_id ."' value='".$likes."'/></span> &nbsp
                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$article_id ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$article_id ."' value='".$dislikes."'/>&nbsp;</span>
                </div>
                <div class='list-group-item'>
            <br/>".$article_stmt."</span><br/><br/>";
    
        comments_all_type_challenges ($db_handle, $article_id);
        echo "</div>";
    }
}
function user_challenges ($db_handle, $user_IDF) {
    $user_challenges_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, a.user_id, a.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN user_info as c 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=c.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, a.user_id, b.stmt, d.first_name, d.last_name, d.username FROM challenges as a JOIN blobs as b JOIN user_info as d 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=d.user_id) ORDER BY creation_time DESC LIMIT 0, 5;");
    $_SESSION['lastfive'] = 5;
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
        $totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$challenge_id' and like_status = '1' ;");
		if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
		else { $likes = '' ; }
		$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$challenge_id' and like_status = '2' ;");
		if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
		else { $dislikes = '' ; }
        echo "<div class='list-group challenge'>
                <div class='list-group-item' >";
        if (isset($_SESSION['user_id'])) {
            $user_id = ($_SESSION['user_id']);
            dropDown_delete_after_accept($challenge_id, $user_id, $user_IDF) ;
        }
        echo "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'>" 
                    .ucfirst($challenge_title)."</a></b></p>
                
                <span class='glyphicon glyphicon-question-sign'></span><span style= 'color: #808080'> &nbsp; 
                By: <a href ='profile.php?username=" . $chall_username . "'>".ucfirst($chall_firstname)." ".ucfirst($chall_lastname)."</a> | ".$chall_creation."</span> | 
                    <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$challenge_id ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$challenge_id ."' value='".$likes."'/></span> &nbsp
                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$challenge_id ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$challenge_id ."' value='".$dislikes."'/>&nbsp;</span>
                </div>
                <div class='list-group-item'>
            <br/>".$challenge_stmt."</span><br/><br/>";
         comments_all_type_challenges ($db_handle, $challenge_id);
         echo "</div>";
    }
}
function user_idea ($db_handle, $user_IDF) {
    $user_idea_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, a.stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=4 AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, b.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=4 AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY challenge_id DESC LIMIT 0, 5;");
    $_SESSION['next_idea'] = 5;
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
        $totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idea_id' and like_status = '1' ;");
		if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
		else { $likes = '' ; }
		$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idea_id' and like_status = '2' ;");
		if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
		else { $dislikes = '' ; }
        echo "<div class='list-group idea'>
                        <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
            $user_id = ($_SESSION['user_id']);
            dropDown_delete_after_accept($idea_id, $user_id, $user_IDF) ;
        }
        echo "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$idea_id."' target='_blank'>" 
                    .ucfirst($idea_title)."</a></b></p>
                
                <span class='glyphicon glyphicon-flash'></span><span style= 'color: #808080'>
                By: <a href ='profile.php?username=" . $idea_username . "'>".ucfirst($idea_firstname)." ".ucfirst($idea_lastname)."</a> | ".$idea_creation."</span> | 
                    <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$idea_id ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$idea_id ."' value='".$likes."'/></span> &nbsp
                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$idea_id ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$idea_id ."' value='".$dislikes."'/>&nbsp;</span>
                </div>
                <div class='list-group-item'>
            <br/>".$idea_stmt."</span><br/><br/>";
	
         comments_all_type_challenges ($db_handle, $idea_id);
         echo "</div>";
    }
}

function created_projects ($db_handle, $user_IDF) {
    $project_created_display = mysqli_query($db_handle, "(SELECT a.user_id, a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.user_id = $user_IDF AND a.blob_id=0 AND a.project_type=1 AND a.user_id=b.user_id)
                                                        UNION 
                                                        (SELECT a.user_id, a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a JOIN blobs as b JOIN user_info as c 
                                                            WHERE a.user_id = $user_IDF AND a.blob_id=b.blob_id AND a.project_type=1 AND a.user_id=c.user_id) ORDER BY creation_time DESC LIMIT 0, 3;");
    $_SESSION['last_CP_3'] = 3;
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
            $user_id_project = $project_table_displayRow['user_id'];
            echo "<div class='list-group' >
                    <div class='list-group-item'>";
            if ($user_id_project == $_SESSION['user_id'] && isset($_SESSION['user_id'])) {
                echo "<div class='pull-right'>
                        <div class='list-group-item'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdown'>
                                <li><button class='btn-link' href='#'>Edit Project</button></li>
                                <li><button class='btn-link' onclick='delChallenge(\"".$project_id_table."\", 4);'>Delete Project</button></li>
                            </ul>
                        </div>
                    </div>";
            }

                echo "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                        <a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$project_id_table."' target='_blank'>" 
                        .ucfirst($project_title_table)."</a></b></p>
                    <span style= 'color: #808080'>By: <a href ='profile.php?username=" . $username_project . "'>"
                        .ucfirst($fname)." ".ucfirst($lname)."</a> | ".$projectcreation."</span> 
                    </div>
                <div class='list-group-item'>
            <br/>".$project_stmt_table."</span><br/><br/>";
                       project_comments($db_handle, $project_id_table);
               echo "</div>";

        }   
    }
    
function joined_projects ($db_handle, $user_IDF) {
    $project_created_display = mysqli_query($db_handle, "(SELECT a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.project_id IN (SELECT teams.project_id from teams where teams.user_id = $user_IDF) AND a.user_id != $user_IDF and a.project_type = 1 AND a.blob_id = 0 AND a.user_id = b.user_id)
                                                        UNION 
                                                        (SELECT a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a 
                                                            JOIN user_info as c JOIN blobs as b WHERE a.project_id IN( SELECT teams.project_id from teams where teams.user_id = $user_IDF) AND a.user_id != $user_IDF AND a.project_type = 1 AND a.blob_id = b.blob_id AND a.user_id = c.user_id) ORDER BY project_id DESC LIMIT 0, 3;");
    $_SESSION['next_JP'] = 3;    
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
                    <div class='list-group-item'>";
            echo "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                        <a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$project_id_table."' target='_blank'>" 
                        .ucfirst($project_title_table)."</a></b></p>
                    <span style= 'color: #808080'>By: <a href ='profile.php?username=" . $username_project . "'>"
                        .ucfirst($fname)." ".ucfirst($lname)."</a> | ".$projectcreation."</span> 
                    </div>
                <div class='list-group-item'>
            <br/>".$project_stmt_table."</span><br/><br/>";
                      
                    project_comments($db_handle, $project_id_table);
               echo "</div>";
        }   
    }

function project_comments($db_handle, $project_id) {
    $username = $_SESSION['username'];
    $displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.user_id, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$project_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '1')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.user_id, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$project_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");
    while ($displayrowc = mysqli_fetch_array($displayb)) {
        $frstnam = $displayrowc['first_name'];
        $lnam = $displayrowc['last_name'];
        $username_pr_comment = $displayrowc['username'];
        $ida = $displayrowc['response_pr_id'];
        $idB = $displayrowc['user_id'];
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
                    $user_id = ($_SESSION['user_id']);
                    dropDown_delete_comment_pr($ida, $user_id, $idB) ;
                }
            echo "</div>
                </div> 
            </div>";
    }
    echo "<div class='comments_".$project_id."'></div><div class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='uploads/profilePictures/" . $username . ".jpg'  onError=this.src='img/default.gif'>&nbsp
            </div>";
    if (isset($_SESSION['user_id'])) {
        echo "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$project_id."'
			 placeholder='Want to know your comment....'/>
			<button type='submit' class='btn-primary btn-sm' onclick='comment(\"".$project_id."\", 1)' >
			<span class='glyphicon glyphicon-chevron-right'></span></button>";
    } 
    else {
        echo " <input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
                <a data-toggle='modal' data-target='#SignIn'>
                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                </a>";
    }
echo "</div>
	</div>";
}

function comments_all_type_challenges ($db_handle, $challenge_id) {
    $username = $_SESSION['username'];
        $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $challenge_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$challenge_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $creater_ID = $commenterRow['user_id'];
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
            $user_id = ($_SESSION['user_id']);
            dropDown_delete_comment_ch($comment_id, $user_id, $creater_ID);
        }
        echo "</div></div></div>";
    }
    echo "<div class='comments_".$challenge_id."'></div><div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$challenge_id."'
                             placeholder='Want to know your comment....'/>
                            <button type='submit' class='btn-primary btn-sm' onclick='comment(\"".$challenge_id."\", 1)' >
                            <span class='glyphicon glyphicon-chevron-right'></span></button></div></div>";
}
?>
