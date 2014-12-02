<?php 
session_start();
include_once '../../lib/db_connect.php';
include_once '../../functions/profile_page_function.php';
include_once '../../functions/delete_comment.php';

if ($_POST['next']) {
    $user_id = $_SESSION['profile_view_userID'];
    $limit = $_SESSION['lastfive'];
    $username = $_SESSION['username'];
    $a = (int) $limit;
    $b = $a + 3;
    
    $user_challenges_display = mysqli_query($db_handle, "(SELECT a.challenge_id, a.challenge_title, a.creation_time, b.user_id, a.stmt, c.first_name, c.last_name, c.username FROM challenges as a JOIN challenge_ownership as b JOIN user_info as c 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_id AND b.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=0 AND a.user_id=c.user_id)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, a.creation_time, c.user_id, b.stmt, d.first_name, d.last_name, d.username FROM challenges as a JOIN blobs as b JOIN challenge_ownership as c JOIN user_info as d 
                                                        WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_id AND c.user_id=$user_id AND (a.challenge_status!=3 AND a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.user_id=d.user_id) ORDER BY creation_time DESC LIMIT $a, $b;");
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
        
        $show = $show. "<div class='list-group challenge'>
                            <div class='list-group-item'>";
        if (isset($_SESSION['user_id'])) {
            $user_session_id = ($_SESSION['user_id']);
            $show = $show. "<div class='list-group-item pull-right'>
                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                                $challenge_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM challenges WHERE challenge_id = '$challenge_id' AND user_id='$user_id';"));
                                $challenge_dropdown_displayRow = mysqli_fetch_array($challenge_dropdown_display);
                                $challenge_dropdown_userID = $challenge_dropdown_displayRow['user_id'];
                                if($challenge_dropdown_userID == $user_id) {
                                    $show = $show . "<li><button class='btn-link' onclick='edit_content(".$challenge_id.")'>Edit</button></li>
                                        <li><button class='btn-link' cID='".$challenge_id."' onclick='delChallenge(".$challenge_id.");'>Delete</button></li>";                    
                                }
                                else {
                                $show = $show . "<li><form method='POST' onsubmit=\"return confirm('Sure to Report Spem !!!')\">
                                                <button type='submit' name='pr_spem' value='".$challenge_id."' class='btn-link' >Report Spam</button>
                                            </form>
                                        </li>";
                                } 
                        $show = $show . "</ul>
                        </div>";
        }
        $show = $show. "<div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'>
                            <img src='uploads/profilePictures/$chall_username.jpg'  onError=this.src='img/default.gif' 
                            style='width: 50px; height: 50px'></span>&nbsp &nbsp
                        </div>
            <span class='color strong'><a href ='profile.php?username=" . $chall_username . "'>"
                .ucfirst($chall_firstname) . '&nbsp' . ucfirst($chall_lastname) . " </a></span><br/>" 
                .$chall_creation."<br/><br/>
            </div>";
	$show = $show."<div class='list-group-item'>
                <a class='btn-link' style='color:#3B5998; font-size: 14pt;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'><strong>
                        <p align='center'>"                          
                        .ucfirst($challenge_title)."</p></strong></a><br>
                ".$challenge_stmt."<br><br>";
        $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                            JOIN user_info as b WHERE a.challenge_id = $challenge_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                        UNION
                                        (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                            JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$challenge_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $username_comment_ninjas = $commenterRow['username'];
        $comment_all_ch = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$commenterRow['stmt'])));
        $show = $show. "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp&nbsp&nbsp" .$comment_all_ch ;
        if (isset($_SESSION['user_id'])) {
            $user_session_id = ($_SESSION['user_id']);
            //dropDown_delete_comment_challenge($db_handle, $comment_id, $user_session_id);
        }
        $show = $show."</div></div></div>";
    }
    $show = $show. "<div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$challenge_id."'
                             placeholder='Whats on your mind about this'/>
                            <button type='submit' class='btn-primary btn-sm' onclick='comment(".$challenge_id.")' ><span class='glyphicon glyphicon-chevron-right'></span></button>
                    </div></div>";
         $show = $show."</div>";
    }
    if (mysqli_error($db_handle)) {
        echo "Failed!";
    } else {
        $_SESSION['lastfive'] = $a + $i;
        echo $show;
    }
}
    
?>