<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';

if ($_POST['user_next_idea']) {
    $profile_user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['next_idea'];
    $username = $_SESSION['username'];
    $a = (int) $limit;
    $b = $a + 5;
    
    $user_idea_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, LEFT(a.stmt, 500) as stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=4 AND a.user_id=$profile_user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, LEFT(b.stmt, 500) as stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=4 AND a.user_id=$profile_user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY challenge_id DESC LIMIT $a, $b;");
    $show_idea = "";
    //$_SESSION['next_idea'] = 5;
    while($user_idea_displayRow= mysqli_fetch_array($user_idea_display)) {
        $i++;
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
        $show_idea = $show_idea. "<div class='list-group idea'>
                        <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
            $show_idea = $show_idea. "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                    <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                        if($idea_user_id == $user_id) {
                            $show_idea = $show_idea. "<li><button class='btn-link' onclick='edit_content(\"".$idea_id."\", 1)'>Edit</button></li>
                                  <li><button class='btn-link' onclick='delChallenge(\"".$idea_id."\", 3);'>Delete</button></li>";
                        }
                        else {
                            $show_idea = $show_idea. "<li><button class='btn-link' onclick='spem(\"".$idea_id."\", 5);'>Report Spam</button></li>";
                        }
            $show_idea = $show_idea. "</ul>
              </div>";
            
        }
        $show_idea = $show_idea. "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
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
	
        $commenter = mysqli_query($db_handle, "(SELECT DISTINCT a.user_id, a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $idea_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.user_id, a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$idea_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$commenterRow['stmt'])));
        $comment_user_id = $commenterRow['user_id'];
        $show_idea = $show_idea. "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
                                            <span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" 
                                            .ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
                                            &nbsp&nbsp&nbsp" .$comment_all_ch ;
        if (isset($_SESSION['user_id'])) {
            $show_idea = $show_idea. "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                if($comment_user_id == $user_id) {
                    $show_idea = $show_idea. "<li><button class='btn-link' onclick='delcomment(\"".$comment_id."\", 2);'>Delete</button></li>";
                } 
                else {
                    $show_idea = $show_idea. "<li><<button class='btn-link' onclick='spem(\"".$comment_id."\", 8);'>Report Spam</button></li>";
                }
             $show_idea = $show_idea. "</ul>
        </div>";
        }
        $show_idea = $show_idea."</div></div></div>";
    }
    $show_idea = $show_idea. "
            <div class='comments_".$idea_id."'></div><div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                </div>";
                if (isset($_SESSION['user_id'])) {
    $show_idea = $show_idea. "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$idea_id."'
                        placeholder='Want to know your comment....'/>
                    <button type='submit' class='btn-primary btn-sm' onclick='comment(\"".$idea_id."\", 1)' ><span class='glyphicon glyphicon-chevron-right'></span></button>";
                else {
            $show_idea = $show_idea. "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
                                    <a data-toggle='modal' data-target='#SignIn'>
                                        <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                                    </a>";
                        }
         $show_idea = $show_idea."</div></div></div>";
    }
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['next_idea'] = $a + $i;
        echo $show_idea;
    }
}
?>
