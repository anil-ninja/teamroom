<?php
include_once 'delete_comment.php';
include_once 'image_resize.php';
include_once 'sharepage.php';
function user_articles ($db_handle, $user_IDF) {
    $user_articles_display = mysqli_query($db_handle, "(SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, a.stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=7 AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, b.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=7 AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY last_update DESC LIMIT 0, 3;");
    $_SESSION['last_article'] = 3;

    $no_article = mysqli_num_rows($user_articles_display);
    if ($no_article == 0) {
        if ($_SESSION['user_id'] == $user_IDF AND isset($_SESSION['user_id'])) {
            echo "<div class='jumbotron'>
                    <p align='center'> You have not created any article <br> Create article and Contribute<br><br>
                    <a onclick='form_profile(8)'> +Create Article </a>
                    </p>
                </div>";
        }
        else {
            echo "<div class='jumbotron'>
                    <p align='center'>Oops No article has been created yet</p>
                </div>";
        }
    } 
    else {

        while($user_articles_displayRow= mysqli_fetch_array($user_articles_display)) {
            $article_id=$user_articles_displayRow['challenge_id'];
            $article_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $user_articles_displayRow['challenge_title'])))));
            $articletitle = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $user_articles_displayRow['challenge_title']))));
            $article_stmt1 = $user_articles_displayRow['stmt'];
            $article_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $article_stmt1)))));
            $articlestmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $article_stmt1))));
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
                echo "<span id='challenge_ti_".$article_id."' class='text' style='font-family: Tenali Ramakrishna, sans-serif;'><b>
                    <a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$article_id."' target='_blank'>" 
                        .ucfirst($article_title)."</a></b></span><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$article_id."' value='".$articletitle."'/><br/>
                    <span class='icon-book'></span><span style= 'color: #808080;'> &nbsp; By: <a href ='profile.php?username=" . $article_username . "' style= 'color: #808080'>
                    ".ucfirst($article_firstname)." ".ucfirst($article_lastname)."</a> | ".$article_created."</span> 
                    <hr/><span id='challenge_".$article_id."' class='text' style='font-size: 14px;'>".$article_stmt."</span><br/>";
			echo editchallenge($articlestmt, $article_id) ;
			echo "<hr/>".sharepage("http://www.collap.com/challengesOpen.php?challenge_id", $article_id) ;
			echo "<hr/><div class='row-fluid'><div class='col-md-5'>
					<span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$article_id ."\", 1)'> <b>Push</b>
                            <input type='submit' class='btn-link' id='likes_".$article_id ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                        <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$article_id ."\", 2)'> <b>Pull</b>
                            <input type='submit' class='btn-link' id='dislikes_".$article_id ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>";
            comments_all_type_challenges ($db_handle, $article_id);
            echo "</div>";
        }
    }
}
function user_challenges ($db_handle, $user_IDF) {
    $user_challenges_display = mysqli_query($db_handle, "(SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, a.user_id, a.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN user_info as c 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=c.user_id)
                                                        UNION
                                                        (SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, a.user_id, b.stmt, d.first_name, d.last_name, d.username FROM challenges as a JOIN blobs as b JOIN user_info as d 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=d.user_id) ORDER BY last_update DESC LIMIT 0, 5;");
    $_SESSION['lastfive'] = 5;

    $no_challenges = mysqli_num_rows($user_challenges_display);
    if ($no_challenges == 0) {
        if ($_SESSION['user_id'] == $user_IDF AND isset($_SESSION['user_id'])) {
            echo "<div class='jumbotron'>
                    <p align='center'> You have not created any Challenge <br> Create Challenges and Contribute<br><br>
                    <a onclick='form_profile(7)'> +Create Challenge </a>
                    </p>
                </div>";
        }
        else {
            echo "<div class='jumbotron'>
                    <p align='center'>Oops No Challenge has been created yet</p>
                </div>";
        }
    }
    else {
        while($user_challenges_displayRow= mysqli_fetch_array($user_challenges_display)) {
        $challenge_id=$user_challenges_displayRow['challenge_id'];
        $challenge_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $user_challenges_displayRow['challenge_title'])))));
        $challengetitle = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $user_challenges_displayRow['challenge_title']))));
        $challenge_stmt1 = $user_challenges_displayRow['stmt'];
        $challenge_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $challenge_stmt1)))));
        $challengestmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $challenge_stmt1))));
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
        echo "<span id='challenge_ti_".$challenge_id."' class='text' style='font-family: Tenali Ramakrishna, sans-serif;'><b>
                <a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'>" 
                    .ucfirst($challenge_title)."</a></b></span>
                    <input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$challenge_id."' value='".$challengetitle."'/><br/>                
                <span class='icon-question-sign'></span><span style= 'color: #808080;'> &nbsp; 
                By: <a href ='profile.php?username=" . $chall_username . "' style= 'color: #808080;'>
                ".ucfirst($chall_firstname)." ".ucfirst($chall_lastname)."</a> | ".$chall_creation."</span>
                <hr/><span id='challenge_".$challenge_id."' class='text' style='font-size: 14px;'>".$challenge_stmt."</span><br/>";
			echo editchallenge($challengestmt, $challenge_id) ;
			echo "<hr/>".sharepage("http://www.collap.com/challengesOpen.php?challenge_id", $article_id) ;
			echo "<hr/><div class='row-fluid'><div class='col-md-5'>
					<span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$challenge_id ."\", 1)'> <b>Push</b>
                        <input type='submit' class='btn-link' id='likes_".$challenge_id ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                    <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$challenge_id ."\", 2)'> <b>Pull</b>
                        <input type='submit' class='btn-link' id='dislikes_".$challenge_id ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>";
         comments_all_type_challenges ($db_handle, $challenge_id);
         echo "</div>";
        }
    }
}
function user_idea ($db_handle, $user_IDF) {
    $user_idea_display = mysqli_query($db_handle, "(SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, a.stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=4 AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, b.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=4 AND a.user_id=$user_IDF AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY last_update DESC LIMIT 0, 5;");
    $_SESSION['next_idea'] = 5;
    
    $no_idea = mysqli_num_rows($user_idea_display);
    if ($no_idea == 0) {
        if ($_SESSION['user_id'] == $user_IDF AND isset($_SESSION['user_id'])) {
            echo "<div class='jumbotron'>
                    <p align='center'> You have not given any Idea <br> Share Idea and Contribute to Society<br><br>
                    <a onclick='form_profile(11)'> +Share Idea </a>
                    </p>
                </div>";
        }
        else {
            echo "<div class='jumbotron'>
                    <p align='center'>Oops No Idea has been shared yet</p>
                </div>";
        }
    }
    else {
        while($user_idea_displayRow= mysqli_fetch_array($user_idea_display)) {
            $idea_id= $user_idea_displayRow['challenge_id'];
            $idea_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $user_idea_displayRow['challenge_title'])))));
            $ideatitle = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $user_idea_displayRow['challenge_title']))));
            $idea_stmt1 = $user_idea_displayRow['stmt'];
            $idea_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $idea_stmt1)))));
            $ideastmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $idea_stmt1))));
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
            echo "<span id='challenge_ti_".$idea_id."' class='text' style='font-family: Tenali Ramakrishna, sans-serif;'><b>
                    <a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$idea_id."' target='_blank'>" 
                        .ucfirst($idea_title)."</a></b></span>
                        <input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$idea_id."' value='".$ideatitle."'/><br/>                    
                    <span class='icon-lightbulb'></span><span style= 'color: #808080;'>
                    By: <a href ='profile.php?username=" . $idea_username . "' style= 'color: #808080;'>
                    ".ucfirst($idea_firstname)." ".ucfirst($idea_lastname)."</a> | ".$idea_creation."</span>
                    <hr/><span id='challenge_".$idea_id."' class='text' style='font-size: 14px;'>".$idea_stmt."</span><br/>";
                echo editchallenge($ideastmt, $idea_id) ;
            echo "<hr/>".sharepage("http://www.collap.com/challengesOpen.php?challenge_id", $article_id) ;
			echo "<hr/><div class='row-fluid'><div class='col-md-5'>
                <span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$idea_id ."\", 1)'> <b>Push</b>
                            <input type='submit' class='btn-link' id='likes_".$idea_id ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                        <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$idea_id ."\", 2)'> <b>Pull</b>
                            <input type='submit' class='btn-link' id='dislikes_".$idea_id ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>" ;
             comments_all_type_challenges ($db_handle, $idea_id);
             echo "</div>";
        }
    }
}

function created_projects ($db_handle, $user_IDF) {
    $project_created_display = mysqli_query($db_handle, "(SELECT a.user_id, a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.user_id = $user_IDF AND a.blob_id=0 AND a.project_type=1 AND a.user_id=b.user_id)
                                                        UNION 
                                                        (SELECT a.user_id, a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a JOIN blobs as b JOIN user_info as c 
                                                            WHERE a.user_id = $user_IDF AND a.blob_id=b.blob_id AND a.project_type=1 AND a.user_id=c.user_id) ORDER BY creation_time DESC LIMIT 0, 3;");
    $_SESSION['last_CP_3'] = 3;
$no_created_projects = mysqli_num_rows($project_created_display);
    if ($no_created_projects == 0) {
        if ($_SESSION['user_id'] == $user_IDF AND isset($_SESSION['user_id'])) {
            echo "<div class='jumbotron'>
                    <p align='center'> You have not Created any Project <br> Create your project and Contribute<br><br>
                        <a data-toggle='modal' data-target='#createProject' style='cursor:pointer;'>+Create Project</a>
                    </p>
                </div>";
        }
        else {
            echo "<div class='jumbotron'>
                    <p align='center'>Oops No project has been created yet</p>
                </div>";
        }
    }
    else {
        while($project_table_displayRow = mysqli_fetch_array($project_created_display)) {
            $project_title_table = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_table_displayRow['project_title'])))));
            $projecttitletable = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_table_displayRow['project_title']))));
            $project_stmt_table1 = $project_table_displayRow['stmt'];
            $project_stmt_table = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_stmt_table1)))));
            $projectstmttable = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_stmt_table1))));
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
                echo "<div class='dropdown pull-right'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'>
                            <b class='caret'></b>
                        </a>
                        <ul class='dropdown-menu'>
                            <li><a href='#' class='btn-link' onclick='editproject(".$project_id_table.")'>Edit Project</a></li>
                            <li><a href='#' class='btn-link' onclick='delChallenge(\"".$project_id_table."\", 4);'>Delete Project</a></li>
                        </ul>
                    </div>";
            }

                echo "<span id='project_ti_".$project_id_table."' class='text' style='font-family: Tenali Ramakrishna, sans-serif;'><b>
                        <a style='color:#3B5998;font-size: 26px;' href='project.php?project_id=".$project_id_table."' target='_blank'>" 
                        .ucfirst($project_title_table)."</a></b></span>
                        <input type='text' class='editbox' style='width : 90%;' id='project_title_".$project_id_table."' value='".$projecttitletable."'/><br/>
                    <span style= 'color: #808080;'>By: <a href ='profile.php?username=" . $username_project . "' style= 'color: #808080;'>"
                        .ucfirst($fname)." ".ucfirst($lname)."</a> | ".$projectcreation."</span>
                    <hr/><span id='project_".$project_id_table."' class='text' style='font-size: 14px;'>".$project_stmt_table."</span><br/>";
			echo editproject($projectstmttable, $project_id_table) ;
                       project_comments($db_handle, $project_id_table);
               echo "</div>";

        }   
    }
}
    
function joined_projects ($db_handle, $user_IDF) {
    $project_created_display = mysqli_query($db_handle, "(SELECT a.project_id, a.project_title, a.stmt, a.creation_time, b.first_name, b.last_name, b.username FROM projects as a 
                                                            JOIN user_info as b WHERE a.project_id IN (SELECT teams.project_id from teams where teams.user_id = $user_IDF) AND a.user_id != $user_IDF and a.project_type = 1 AND a.blob_id = 0 AND a.user_id = b.user_id)
                                                        UNION 
                                                        (SELECT a.project_id, a.project_title, b.stmt, a.creation_time, c.first_name, c.last_name, c.username FROM projects as a 
                                                            JOIN user_info as c JOIN blobs as b WHERE a.project_id IN( SELECT teams.project_id from teams where teams.user_id = $user_IDF) AND a.user_id != $user_IDF AND a.project_type = 1 AND a.blob_id = b.blob_id AND a.user_id = c.user_id) ORDER BY project_id DESC LIMIT 0, 3;");
    $_SESSION['next_JP'] = 3;

    $no_joined = mysqli_num_rows($project_created_display);
    if ($no_joined == 0) {
        if ($_SESSION['user_id'] == $user_IDF AND isset($_SESSION['user_id'])) {
            echo "<div class='jumbotron'>
                    <p align='center'> You have not Joined any Project <br> Join projects and Contribute<br><br>
                    </p>";
                    recommended_project ($db_handle);
                echo "</div>";
        }
        else {
            echo "<div class='jumbotron'>
                    <p align='center'>Oops No project has been joined yet </p>
                </div>";
        }
    }
    else {
        while($project_table_displayRow = mysqli_fetch_array($project_created_display)) {
            $project_title_table = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_table_displayRow['project_title'])))));
            $project_stmt_table1 = $project_table_displayRow['stmt'];
            $project_stmt_table = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_stmt_table1)))));
            $project_id_table = $project_table_displayRow['project_id'];
            $fname = $project_table_displayRow['first_name'];
            $projectcreation1 = $project_table_displayRow['creation_time'];
            $projectcreation = date("j F, g:i a", strtotime($projectcreation1));
            $lname = $project_table_displayRow['last_name'];
            $username_project = $project_table_displayRow['username'];
            echo "<div class='list-group'>
                    <div class='list-group-item'>";
            echo "<span style='font-family: Tenali Ramakrishna, sans-serif;'><b>
                        <a style='color:#3B5998;font-size: 26px;' href='project.php?project_id=".$project_id_table."' target='_blank'>" 
                        .ucfirst($project_title_table)."</a></b></span><br/>
                    <span style= 'color: #808080'>By: <a href ='profile.php?username=" . $username_project . "' style= 'color: #808080;'>"
                        .ucfirst($fname)." ".ucfirst($lname)."</a> | ".$projectcreation."</span><hr/> 
                    <span style='font-size: 14px;'>".$project_stmt_table."</span><br/>";
                 project_comments($db_handle, $project_id_table);
               echo "</div>";
        }   
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
        $projectres = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $displayrowc['stmt'])))));
        echo "<div id='commentscontainer'>
                <div class='comments clearfix' id='comment_".$ida."'>
                    <div class='pull-left lh-fix'>
                        <img src='".resize_image("uploads/profilePictures/$username_pr_comment.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
                    </div>";
                if (isset($_SESSION['user_id'])) {
                    $user_id = ($_SESSION['user_id']);
                    dropDown_delete_comment_pr($ida, $user_id, $idB) ;
                }
            echo "<div class='comment-text'>
                        <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " " . ucfirst($lnam) . "</a></span> 
                        &nbsp;&nbsp;<small>" . $projectres . "</small></div>
                </div> 
            </div>";
    }
    echo "<div class='comments_".$project_id."'></div><div class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
            </div>";
    if (isset($_SESSION['user_id'])) {
        echo "<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$project_id."'
			 placeholder='Want to know your comment....'/>
			<button type='submit' class='btn btn-primary' onclick='comment(\"".$project_id."\", 2)' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
		      <i class='icon-chevron-right'></i>
            </button>";
    } 
    else {
        echo " <input type='text' class='input-block-level' STYLE='width: 86%;' placeholder='Want to know your comment....'/>
                <a data-toggle='modal' data-target='#SignIn'>
                    <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                        <i class='icon-chevron-right'></i>
                    </button>
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
        $comment_all_ch = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+",$commenterRow['stmt'])))));
        echo "<div id='commentscontainer'>
				<div class='comments clearfix' id='comment_".$comment_id."'>
					<div class='pull-left lh-fix'>
						<img src='".resize_image("uploads/profilePictures/$username_comment_ninjas.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
					</div>" ;
        if (isset($_SESSION['user_id'])) {
            $user_id = ($_SESSION['user_id']);
            dropDown_delete_comment_ch($comment_id, $user_id, $creater_ID);
        }
        echo "<div class='comment-text'>
				<span class='pull-left color strong'><a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
				&nbsp;&nbsp;" .$comment_all_ch."</div></div></div>";
    }
    echo "<div class='comments_".$challenge_id."'></div><div class='comments clearfix'>
            <div class='pull-left lh-fix'>
                <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
            </div>";
            if (isset($_SESSION['user_id'])) {
        echo "<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$challenge_id."'
                 placeholder='Want to know your comment....'/>
                <button type='submit' class='btn btn-primary' onclick='comment(\"".$challenge_id."\", 1)' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                    <i class='icon-chevron-right'></i>
                </button>";
            }
            else {
                echo " <input type='text' class='input-block-level' STYLE='width: 86%;' placeholder='Want to know your comment....'/>
                        <a data-toggle='modal' data-target='#SignIn'>
                            <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                                <i class='icon-chevron-right'></i>
                            </button>
                        </a>";
            }
            echo "</div>
                </div>";
}
?>
