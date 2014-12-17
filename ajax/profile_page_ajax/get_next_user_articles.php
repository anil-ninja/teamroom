<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';+

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
        $article_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_articles_displayRow['challenge_title'])));
        $article_stmt1 = $user_articles_displayRow['stmt'];
        $article_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $article_stmt1)));
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

        $show_article = $show_article. "<p id='challenge_ti_".$article_id."' class='text' style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                    <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$article_id."' target='_blank'>" 
                        .ucfirst($article_title)."</a></b></p><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$article_id."' value='".$article_title."'/>
                    <span class='glyphicon glyphicon-book'></span><span style= 'color: #808080'> &nbsp; By: <a href ='profile.php?username=" . $article_username . "'>".ucfirst($article_firstname)." ".ucfirst($article_lastname)."</a> | ".$article_created."</span> | 
                        <span class='glyphicon glyphicon-hand-up' style='cursor: pointer;' onclick='like(\"".$article_id ."\", 1)'>
                            <input type='submit' class='btn-link' id='likes_".$article_id ."' value='".$likes."'/></span> &nbsp
                        <span class='glyphicon glyphicon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$article_id ."\", 2)'>
                            <input type='submit' class='btn-link' id='dislikes_".$article_id ."' value='".$dislikes."'/>&nbsp;</span>
                    </div>
                    <div class='list-group-item'>
                <br/><span id='challenge_".$article_id."' class='text'>".$article_stmt."</span><br/><br/>";
if(isset($_SESSION['user_id'])){
		if(substr($article_stmt, 0, 1) != '<') {
$show_article = $show_article. "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$article_id."' >".$article_stmt."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$article_id.")' id='doneedit_".$article_id."'/>";
			}
		else {
			if (substr($article_stmt, 0, 4) == ' <br') {
$show_article = $show_article. "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$article_id."' >".$article_stmt."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$article_id.")' id='doneedit_".$article_id."'/>";
				}
			if (substr($article_stmt, 0, 3) == '<s>') {
$show_article = $show_article. "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$article_id."' >".$article_stmt."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$article_id.")' id='doneedit_".$article_id."'/>";
				}
			$chaaa = substr(strstr($article_stmt, '<br/>'), 5) ;
			$cha = strstr($article_stmt, '<br/>' , true) ;
			if(substr($article_stmt, 0, 4) == '<img') {
$show_article = $show_article. "<div class='editbox' style='width : 90%;' id='challenge_pic_".$article_id."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$article_id.")' id='pic_file_".$article_id."'/><br/><br/>" ;
					}
			if(substr($article_stmt, 0, 2) == '<a') {
$show_article = $show_article. "<div class='editbox' style='width : 90%;' id='challenge_file_".$article_id."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$article_id.")' id='pic_file_".$article_id."'/><br/><br/>" ;
					}
			if(substr($article_stmt, 0, 3) == '<if') {
$show_article = $show_article. "<div class='editbox' style='width : 90%;' id='challenge_video_".$article_id."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$article_id."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
$show_article = $show_article. "<input id='_fileChallenge_".$article_id."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn-success btn-xs editbox' value='Upload New Photo/File' onclick='save_pic_file(".$article_id.")' id='pic_file_save_".$article_id."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$article_id."' >".$chaaa."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedchallenge(".$article_id.")' id='doneediting_".$article_id."'/>";		
			}
		}        
    
    $commenter = mysqli_query($db_handle, "(SELECT DISTINCT a.user_id, a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $article_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.user_id, a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$article_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$commenterRow['stmt'])));
        $comment_user_id = $commenterRow['user_id'];
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
                    <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                </div>";
                if (isset($_SESSION['user_id'])) {
    $show_article = $show_article. "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$article_id."'
                        placeholder='Want to know your comment....'/>
                    <button type='submit' class='btn-primary btn-sm' onclick='comment(\"".$article_id."\", 1)' >
                        <span class='glyphicon glyphicon-chevron-right'></span>
                    </button>";
                }
                else {
    $show_article = $show_article. "<input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Want to know your comment....'/>
                            <a data-toggle='modal' data-target='#SignIn'>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
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
