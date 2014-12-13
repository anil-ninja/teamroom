<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';

if ($_POST['next']) {
    $profile_user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['lastfive'];
    $username = $_SESSION['username'];
    $a = (int) $limit;
    $b = $a + 3;
    
    $user_challenges_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, b.user_id, a.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN challenge_ownership as b JOIN user_info as c 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$profile_user_id AND b.user_id=$profile_user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=c.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, c.user_id, b.stmt, d.first_name, d.last_name, d.username FROM challenges as a JOIN blobs as b JOIN challenge_ownership as c JOIN user_info as d 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$profile_user_id AND c.user_id=$profile_user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=d.user_id) ORDER BY last_update DESC LIMIT $a, $b;");
    $show = "";
    while($user_challenges_displayRow= mysqli_fetch_array($user_challenges_display)) {
    $i++;
        $challenge_id=$user_challenges_displayRow['challenge_id'];
        $challenge_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_challenges_displayRow['challenge_title'])));
        $challenge_stmt1 = $user_challenges_displayRow['stmt'];
        $challenge_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $challenge_stmt1)));
        //$you_owned_or_not = $user_challenges_displayRow['user_id'];
        $chall_firstname = $user_challenges_displayRow['first_name'];
        $chall_lastname = $user_challenges_displayRow['last_name'];
        $chall_username = $user_challenges_displayRow['username'];
        $chall_creation1 = $user_challenges_displayRow['creation_time'];
        $chall_creation = date("j F, g:i a", strtotime($chall_creation1));
        $chall_user_id = $user_challenges_displayRow['user_id'];
        $totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$challenge_id' and like_status = '1' ;");
		if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
		else { $likes = '' ; }
		$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$challenge_id' and like_status = '2' ;");
		if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
		else { $dislikes = '' ; }
        $show = $show. "<div class='list-group challenge'>
                            <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
            $show = $show. "<div class='list-group-item pull-right'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                                if($chall_user_id == $_SESSION['user_id']) {
                                    $show = $show . "<li><button class='btn-link' onclick='edit_content(\"".$challenge_id."\", 1)'>Edit</button></li>
                                        <li><button class='btn-link' onclick='delChallenge(\"".$challenge_id."\", 3);'>Delete</button></li>";                    
                                }
                                else {
                                $show = $show . "<li><button class='btn-link' onclick='spem(\"".$challenge_id."\", 5);'>Report Spam</button></li>";
                                } 
                        $show = $show . "</ul>
                        </div>";
        }
        $show = $show. "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
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
	
        $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.user_id, a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $challenge_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.user_id, a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$challenge_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$commenterRow['stmt'])));
        $comment_user_id = $commenterRow['user_id'];
        $show = $show. "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp&nbsp&nbsp" .$comment_all_ch ;
        if (isset($_SESSION['user_id'])) {
              $show = $show . "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
            
                 if($comment_user_id == $_SESSION['user_id']) {
                        $show = $show . "<li><button class='btn-link' onclick='delcomment(\"".$comment_id."\", 2);'>Delete</button></li>";
                    } 
                    else {
                      $show = $show . "<li><button class='btn-link' onclick='spem(\"".$comment_id."\", 8);'>Report Spam</button></li>";
                    }
             $show = $show . "</ul>
        </div>";
        }
        $show = $show."</div></div></div>";
    }
    $show = $show. "<div class='comments_".$challenge_id."'></div><div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>";
                        if (isset($_SESSION['user_id'])) {
            $show = $show. "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$challenge_id."'
                             placeholder='Want to know your comment....'/>
                            <button type='submit' class='btn-primary btn-sm' onclick='comment(\"".$challenge_id."\", 1)' ><span class='glyphicon glyphicon-chevron-right'></span></button>";
                        }
                        else {
            $show = $show. "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
                                    <a data-toggle='modal' data-target='#SignIn'>
                                        <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                                    </a>";
                        }

            $show = $show."</div></div></div>";
    }
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['lastfive'] = $a + $i;
        echo $show;
    }
}
    
?>
