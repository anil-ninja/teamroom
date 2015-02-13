<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';
include_once '../../functions/image_resize.php';

if ($_POST['next']) {
    $profile_user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['lastfive'];
    $username = $_SESSION['username'];
    $a = (int) $limit;
    $b = $a + 3;
    
    $user_challenges_display = mysqli_query($db_handle, "(SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, b.user_id, a.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN challenge_ownership as b JOIN user_info as c 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$profile_user_id AND b.user_id=$profile_user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=c.user_id)
                                                        UNION
                                                        (SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, c.user_id, b.stmt, d.first_name, d.last_name, d.username FROM challenges as a JOIN blobs as b JOIN challenge_ownership as c JOIN user_info as d 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$profile_user_id AND c.user_id=$profile_user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=d.user_id) ORDER BY last_update DESC LIMIT $a, $b;");
    $show = "";
    while($user_challenges_displayRow= mysqli_fetch_array($user_challenges_display)) {
    $i++;
        $challenge_id=$user_challenges_displayRow['challenge_id'];
        $challenge_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $user_challenges_displayRow['challenge_title'])))));
        $challengetitle = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $user_challenges_displayRow['challenge_title']))));
        $challenge_stmt1 = $user_challenges_displayRow['stmt'];
        $challenge_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $challenge_stmt1)))));
        $challengestmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $challenge_stmt1))));
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
        $show = $show. "<span id='challenge_ti_".$challenge_id."' class='text' style='font-family: Tenali Ramakrishna, sans-serif;'><b>
                <a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'>" 
                    .ucfirst($challenge_title)."</a></b></span><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$challenge_id."' value='".$challengetitle."'/><br/>
                <span class='icon-question-sign'></span><span style= 'color: #808080;'> &nbsp; 
                By: <a href ='profile.php?username=" . $chall_username . "' style= 'color: #808080;'>".ucfirst($chall_firstname)." ".ucfirst($chall_lastname)."</a> | ".$chall_creation."</span>
                <hr/><span id='challenge_".$challenge_id."' class='text' style='font-size: 14px;'>".$challenge_stmt."</span><br/>";
		$show = $show. editchallenge($challengestmt, $challenge_id) ;
		$show = $show. "<hr/><div class='row-fluid'><div class='col-md-1'>".share_challenge($challenge_id)."</div><div class='col-md-5'>| &nbsp;&nbsp;&nbsp;
						<span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$challenge_id ."\", 1)'> <b>Push</b>
                        <input type='submit' class='btn-link' id='likes_".$challenge_id ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                    <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$challenge_id ."\", 2)'> <b>Pull</b>
                        <input type='submit' class='btn-link' id='dislikes_".$challenge_id ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>" ;
        $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.user_id, a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $challenge_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.user_id, a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$challenge_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+",$commenterRow['stmt'])))));
        $comment_user_id = $commenterRow['user_id'];
        $show = $show. "<div id='commentscontainer'>
				<div class='comments clearfix' id='comment_".$comment_id."'>
					<div class='pull-left lh-fix'>
					<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
					</div>" ;
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
        $show = $show."<div class='comment-text'>
						<span class='pull-left color strong'><a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp;&nbsp;" .$comment_all_ch."</div></div></div>";
    }
    $show = $show. "<div class='comments_".$challenge_id."'></div><div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
                        </div>";
                        if (isset($_SESSION['user_id'])) {
            $show = $show. "<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$challenge_id."'
                             placeholder='Want to know your comment....'/>
                            <button type='submit' class='btn btn-primary' onclick='comment(\"".$challenge_id."\", 1)' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                                <i class='icon-chevron-right'></i>
                            </button>";
                        }
                        else {
            $show = $show. "<input type='text' class='input-block-level' STYLE='width: 86%;' placeholder='Want to know your comment....'/>
                                <a data-toggle='modal' data-target='#SignIn'>
                                    <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                                        <i class='icon-chevron-right'></i>
                                    </button>
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
