<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/image_resize.php';
if ($_POST['last_article']) {
    $user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['last_article'];
    $username = $_SESSION['username'];
    $art = (int) $limit;
    $b = $art + 3;
    
    $user_articles_display = mysqli_query($db_handle, "(SELECT a.last_update, a.user_id, a.challenge_id, a.challenge_title, a.creation_time, a.stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=7 AND a.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.last_update, a.user_id, a.challenge_id, a.challenge_title, a.creation_time, b.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=7 AND a.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY last_update DESC LIMIT $art, $b;");
    $show_article = "";
    while($user_articles_displayRow= mysqli_fetch_array($user_articles_display)) {
        $i++;
        $article_id=$user_articles_displayRow['challenge_id'];
        $article_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_articles_displayRow['challenge_title']))));
        $articletitle = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_articles_displayRow['challenge_title'])));
        $article_stmt1 = $user_articles_displayRow['stmt'];
        $article_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $article_stmt1))));
        $articlestmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $article_stmt1)));
        $article_firstname = $user_articles_displayRow['first_name'];
        $article_lastname = $user_articles_displayRow['last_name'];
        $article_username = $user_articles_displayRow['username'];
        $article_created1 = $user_articles_displayRow['creation_time'];
        $article_created = date("j F, g:i a", strtotime($article_created1));
        $art_user_id = $user_articles_displayRow['user_id'];
        $totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$article_id' and like_status = '1' ;");
		if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
		else { $likes = '' ; }
		$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$article_id' and like_status = '2' ;");
		if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
		else { $dislikes = '' ; }
        $show_article = $show_article. "
            <div class='list-group articlesch'>
                <div class='list-group-item'>";
            if (isset($_SESSION['user_id'])) {
                $show_article = $show_article. "<div class='list-group-item pull-right'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                    <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                        if($art_user_id == $user_id) {
                            $show_article = $show_article. "<li><button class='btn-link' onclick='edit_content(\"".$article_id."\", 1)'>Edit</button></li>
                                  <li><button class='btn-link' onclick='delChallenge(\"".$article_id."\", 3);'>Delete</button></li>";
                        }
                        else {
                            $show_article = $show_article. "<li><button class='btn-link' onclick='spem(\"".$article_id."\", 5);'>Report Spam</button></li>";
                        }
            $show_article = $show_article. "</ul>
              </div>";
            }

        $show_article = $show_article. "<span id='challenge_ti_".$article_id."' class='text' style='font-family: Tenali Ramakrishna, sans-serif; font-size: 24px; line-height: 42px;'><b>
                    <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$article_id."' target='_blank'>" 
                        .ucfirst($article_title)."</a></b></span><br/><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$article_id."' value='".$articletitle."'/>
                    <span class='icon-book'></span><span style= 'color: #808080;'> &nbsp; By: <a href ='profile.php?username=" . $article_username . "' style= 'color: #808080;'>
                    ".ucfirst($article_firstname)." ".ucfirst($article_lastname)."</a> | ".$article_created." | </span>
                        <span class='icon-hand-up' style='cursor: pointer;color: #808080;' onclick='like(\"".$article_id ."\", 1)'>
                         <input type='submit' class='btn-link' id='likes_".$article_id ."' value='".$likes."'/></span> &nbsp
                        <span class='icon-hand-down' style='cursor: pointer;color: #808080;' onclick='dislike(\"".$article_id ."\", 2)'>
                            <input type='submit' class='btn-link' id='dislikes_".$article_id ."' value='".$dislikes."'/>&nbsp;</span>
                    <hr/><span id='challenge_".$article_id."' class='text' style='font-size: 14px;'>".$article_stmt."</span><br/>";
		$show_article = $show_article. editchallenge($articlestmt, $article_id) ;
    $commenter = mysqli_query($db_handle, "(SELECT DISTINCT a.user_id, a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $article_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.user_id, a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$article_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$commenterRow['stmt']))));
        $comment_user_id = $commenterRow['user_id'];
        $show_article = $show_article. "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='".resize_image("uploads/profilePictures/$username_comment_ninjas.jpg", 30, 30)."'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
                                            <span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" 
                                            .ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
                                            &nbsp&nbsp&nbsp" .$comment_all_ch ;
        if (isset($_SESSION['user_id'])) {
            $show_article = $show_article. "<div class='list-group-item pull-right'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                if($comment_user_id == $user_id) {
                    $show_article = $show_article. "<li><button class='btn-link' onclick='delcomment(\"".$comment_id."\", 2);'>Delete</button></li>";
                } 
                else {
                    $show_article = $show_article. "<li><button class='btn-link' onclick='spem(\"".$comment_id."\", 8);'>Report Spam</button></li>";
                }
             $show_article = $show_article. "</ul>
        </div>";

        }
        $show_article = $show_article."</div></div></div>";
    }
    $show_article = $show_article. "
            <div class='comments_".$article_id."'></div><div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30)."'  onError=this.src='img/default.gif'>&nbsp
                </div>";
                if (isset($_SESSION['user_id'])) {
    $show_article = $show_article. "<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$article_id."'
                        placeholder='Want to know your comment....'/>
                    <button type='submit' class='btn btn-primary' onclick='comment(\"".$article_id."\", 1)' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                        <i class='icon-chevron-right'></i>
                    </button>";
                }
                else {
    $show_article = $show_article. "<input type='text' class='input-block-level' STYLE='width: 86%;' placeholder='Want to know your comment....'/>
                            <a data-toggle='modal' data-target='#SignIn'>
                                <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                                    <i class='icon-chevron-right'></i>
                                </button>
                            </a>";
                }
        $show_article = $show_article."</div></div></div>";
    }
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['last_article'] = $art + $i;
        echo $show_article;
    }
}
?>
