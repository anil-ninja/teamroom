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
    
    $user_idea_display = mysqli_query($db_handle, "(SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, LEFT(a.stmt, 500) as stmt, b.first_name, b.last_name, b.username FROM challenges as a 
                                                        JOIN user_info as b WHERE a.challenge_type=4 AND a.user_id=$profile_user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=b.user_id)
                                                        UNION
                                                        (SELECT a.last_update, a.challenge_id, a.challenge_title, a.creation_time, LEFT(b.stmt, 500) as stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN blobs as b JOIN user_info as c 
                                                        WHERE a.challenge_type=4 AND a.user_id=$profile_user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=c.user_id) ORDER BY last_update DESC LIMIT $a, $b;");
    $show_idea = "";
    //$_SESSION['next_idea'] = 5;
    while($user_idea_displayRow= mysqli_fetch_array($user_idea_display)) {
        $i++;
        $idea_id= $user_idea_displayRow['challenge_id'];
        $idea_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_idea_displayRow['challenge_title']))));
        $ideatitle = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $user_idea_displayRow['challenge_title'])));
        $idea_stmt1 = $user_idea_displayRow['stmt'];
        $idea_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $idea_stmt1))));
        $ideastmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $idea_stmt1)));
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
        $show_idea = $show_idea. "<p id='challenge_ti_".$idea_id."' class='text' style='font-famiy: Calibri,sans-serif; font-size: 24px; line-height: 42px; font-family: open_sans_condensedbold ,Calibri,sans-serif'><b>
                    <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$idea_id."' target='_blank'>" 
                        .ucfirst($idea_title)."</a></b></p><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$idea_id."' value='".$ideatitle."'/>                    
                    <span class='icon-lightbulb'></span><span style= 'color: #808080'>
                    By: <a href ='profile.php?username=" . $idea_username . "'>".ucfirst($idea_firstname)." ".ucfirst($idea_lastname)."</a> | ".$idea_creation."</span> | 
                        <span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$idea_id ."\", 1)'>
                            <input type='submit' class='btn-link' id='likes_".$idea_id ."' value='".$likes."'/></span> &nbsp
                        <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$idea_id ."\", 2)'>
                            <input type='submit' class='btn-link' id='dislikes_".$idea_id ."' value='".$dislikes."'/>&nbsp;</span>
                    </div>
                    <div class='list-group-item'>
                <br/><span id='challenge_".$idea_id."' class='text'>".$idea_stmt."</span><br/><br/>";
if(isset($_SESSION['user_id'])){
		if(substr($ideastmt, 0, 1) != '<') {
$show_idea = $show_idea. "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$idea_id."' >".str_replace("<br/>", "\n",$ideastmt)."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$idea_id.")' id='doneedit_".$idea_id."'/>";
			}
		else {
			if (substr($ideastmt, 0, 4) == ' <br') {
$show_idea = $show_idea. "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$idea_id."' >".str_replace("<br/>", "\n",$ideastmt)."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$idea_id.")' id='doneedit_".$idea_id."'/>";
				}
			if (substr($ideastmt, 0, 3) == '<s>') {
$show_idea = $show_idea. "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$idea_id."' >".str_replace("<br/>", "\n",$ideastmt)."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$idea_id.")' id='doneedit_".$idea_id."'/>";
				}
			$chaaa = str_replace("<br/>", "\n",substr(strstr($ideastmt, '<br/>'), 5)) ;
			$cha = str_replace("<br/>", "\n",strstr($ideastmt, '<br/>' , true)) ;
			if(substr($ideastmt, 0, 4) == '<img') {
$show_idea = $show_idea. "<div class='editbox' style='width : 90%;' id='challenge_pic_".$idea_id."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$idea_id.")' id='pic_file_".$idea_id."'/><br/><br/>" ;
					}
			if(substr($ideastmt, 0, 2) == '<a') {
$show_idea = $show_idea. "<div class='editbox' style='width : 90%;' id='challenge_file_".$idea_id."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$idea_id.")' id='pic_file_".$idea_id."'/><br/><br/>" ;
					}
			if(substr($ideastmt, 0, 3) == '<if') {
$show_idea = $show_idea. "<div class='editbox' style='width : 90%;' id='challenge_video_".$idea_id."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$idea_id."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
$show_idea = $show_idea. "<input id='_fileChallenge_".$idea_id."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn-success btn-xs editbox' value='Upload New Photo/File' onclick='save_pic_file(".$idea_id.")' id='pic_file_save_".$idea_id."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$idea_id."' >".$chaaa."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedchallenge(".$idea_id.")' id='doneediting_".$idea_id."'/>";		
			}
		}	
        $commenter = mysqli_query($db_handle, "(SELECT DISTINCT a.user_id, a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $idea_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.user_id, a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$idea_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$commenterRow['stmt']))));
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
    $show_idea = $show_idea. "<input type='text' STYLE='idth: 83.0%;' id='own_ch_response_".$idea_id."'
                        placeholder='Want to know your comment....'/>
                    <button type='submit' class='btn btn-primary' onclick='comment(\"".$idea_id."\", 1)' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                        <i class='icon-chevron-right'></i>
                    </button>";
                else {
            $show_idea = $show_idea. "
                            <input type='text' class='input-block-level' STYLE='width: 86%;' placeholder='Want to know your comment....'/>
                                <a data-toggle='modal' data-target='#SignIn'>
                                    <button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px; padding-bottom: 6px; padding-top: 7px;'>
                                        <i class='icon-chevron-right'></i>
                                    </button>
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
