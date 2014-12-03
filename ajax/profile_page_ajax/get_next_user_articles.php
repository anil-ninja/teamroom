<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';

if ($_POST['last_article']) {
    $user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['last_article_3'];
    $username = $_SESSION['username'];
    $art = (int) $limit;
    $b = $art + 3;
    
    $user_articles_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, LEFT(a.stmt, 500) as stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=7 AND a.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, LEFT(b.stmt, 500) as stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=7 AND a.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY challenge_id LIMIT $art, $b;");
    $show_article = "";
    while($user_articles_displayRow= mysqli_fetch_array($user_articles_display)) {
        $i++;
        $article_id=$user_articles_displayRow['challenge_id'];
        $article_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_articles_displayRow['challenge_title'])));
        $article_stmt1 = $user_articles_displayRow['stmt'];
        $article_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $article_stmt1)));
        $article_firstname = $user_articles_displayRow['first_name'];
        $article_lastname = $user_articles_displayRow['last_name'];
        $article_username = $user_articles_displayRow['username'];
        $article_created1 = $user_articles_displayRow['creation_time'];
        $article_created = date("j F, g:i a", strtotime($article_created1));
        
        $show_article = $show_article. "
            <div class='list-group articlesch'>
                <div class='list-group-item'>";
            if (isset($_SESSION['user_id'])) {
                $user_session_id = ($_SESSION['user_id']);
                //dropDown_delete_article($db_handle, $article_id, $user_session_id);
            }

        $show_article = $show_article. "<p style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$article_id."' target='_blank'>" 
                    .ucfirst($article_title)."</a></b></p>
                
                <span class='glyphicon glyphicon-book'></span><span style= 'color: #808080'> &nbsp; By: <a href ='profile.php?username=" . $article_username . "'>".ucfirst($article_firstname)." ".ucfirst($article_lastname)."</a> | ".$article_created."</span> | 
                    <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(".$article_id .")'>
                        <input type='submit' class='btn-link' id='likes_".$article_id ."' value='".$likes."'/></span> &nbsp
                    <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(".$article_id .")'>
                        <input type='submit' class='btn-link' id='dislikes_".$article_id ."' value='".$dislikes."'/>&nbsp;</span>
                </div>
                <div class='list-group-item'>
            <br/>".$article_stmt."</span><br/><br/>";
        //comments_all_type_challenges ($db_handle, $article_id);
        
    
    $commenter = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $article_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$article_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$commenterRow['stmt'])));
        $show_article = $show_article. "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
                                            <span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" 
                                            .ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
                                            &nbsp&nbsp&nbsp" .$comment_all_ch ;
        if (isset($_SESSION['user_id'])) {
            $user_session_id = ($_SESSION['user_id']);
            //dropDown_delete_comment_challenge($db_handle, $comment_id, $user_session_id);
        }
        $show_article = $show_article."</div></div></div>";
    }
    $show_article = $show_article. "
            <div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                </div>
                    <input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$article_id."'
                        placeholder='Want to know your comment....'/>
                    <button type='submit' class='btn-primary btn-sm' onclick='comment(".$article_id.")' ><span class='glyphicon glyphicon-chevron-right'></span></button>
                </div>
            </div>";
         $show_article = $show_article."</div></div>";
    }
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['last_article_3'] = $art + $i;
        echo $show_article;
    }
}
?>