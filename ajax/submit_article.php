<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/image_resize.php';
//echo "hi";
if($_POST['article']){
	$user_id = $_SESSION['user_id'];
	$articletext = $_POST['article'] ;
	$article_title = $_POST['article_title'] ;
	$image = $_POST['img'] ;
	//echo $image ;
	if (strlen($image) < 30 ) {
		$article = $articletext ;
		}
		else {
			$article = $image."<br/> ".$articletext ;
			}
	$remaintime = 99 ;
	$firstname = $_SESSION['first_name'] ;
	$username = $_SESSION['username'] ;
	$time = date("Y-m-d H:i:s") ;
	if (strlen($article) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, last_update) 
                                    VALUES ('$user_id', '$article_title', '$article', '1', '999999', '7', '$time') ; ") ;
		$idp = mysqli_insert_id($db_handle);
		involve_in($db_handle,$user_id,"1",$idp);
	} 
	else {
		mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
								VALUES (default, '$article');");        
		$id = mysqli_insert_id($db_handle);
		mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type, last_update) 
								VALUES ('$user_id', '$article_title', '$id', '1', '999999', ' ', '7', '$time');");
		$idp = mysqli_insert_id($db_handle);
		involve_in($db_handle,$user_id,"1",$idp);
	}
	$totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idp' and like_status = '1' ;");
	if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
	else { $likes = '' ; }
	$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idp' and like_status = '2' ;");
	if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
	else { $dislikes = '' ; }
	$data = "" ;
	$timefunct = date("j F, g:i a") ;
	$chelange = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $article)))) ;
	$title = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $article_title)))) ;
	$ntitle = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $article_title))) ;
	$nchallange = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&", $article))) ;
	$data .= "<div class='list-group articlesch'>
                <div class='list-group-item'>
					<div class='dropdown pull-right'>
						<a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
						<ul class='dropdown-menu'>
							<li><a class='btn-link' href='#' onclick='edit_content(\"".$idp."\", 1)'>Edit</a></li>
							<li><a class='btn-link' href='#' onclick='delChallenge(\"".$idp."\", 3);'>Delete</a></li>
						</ul>
					</div>" ;
    $data = $data ."<span style='font-family: Tenali Ramakrishna, sans-serif;' id='challenge_ti_".$idp."' class='text'><b>
					<a class='btn btn-link' style='color:#3B5998;font-size: 28px;padding:10px 0px 0px ;' href='challengesOpen.php?challenge_id=".$idp."' target='_blank'>".ucfirst($title)."</a>
					</b></span><br/><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$idp."' value='".$ntitle."'/>
					<span class='icon-book'></span>
					<span style= 'color: #808080;'>
					&nbspBy: <a href ='profile.php?username=" . $username . "' style='color: #808080;'>".ucfirst($firstname)."</a> | ".$timefunct." | </span>
                    <span class='icon-hand-up' style='cursor: pointer;color: #808080;' onclick='like(\"".$idp ."\", 1)'>
                        <input type='submit' class='btn-link' id='likes_".$idp."' value='".$likes."'/></span> &nbsp
                    <span class='icon-hand-down' style='cursor: pointer;color: #808080;' onclick='dislike(\"".$idp ."\", 2)'>
                        <input type='submit' class='btn-link' id='dislikes_".$idp."' value='".$dislikes."'/>&nbsp;</span>
                    <hr/><span id='challenge_".$idp."' class='text' style='line-height: 25px; font-size: 14px; color: #444;'>".$chelange."</span><br/>" ;
       $data = $data .editchallenge($nchallange, $idp) ;
      $data = $data ."<div class='comments_".$idp."'></div>
					<div id='step15' class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30)."'  onError=this.src='img/default.gif'>&nbsp
						</div>
						<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$idp."'
						 placeholder='Want to know your comment....'/>
						<button type='submit' class='btn btn-primary' onclick='comment(\"".$idp."\", 1)' style='margin-bottom: 10px;'>
						<span class='icon-chevron-right'></span></button>
					</div></div> </div> " ;
	if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
	else { echo "Posted succesfully!"."+"."3"."+".$data ; }
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>
