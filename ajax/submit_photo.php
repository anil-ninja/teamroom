<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
include_once '../functions/sharepage.php';
include_once '../functions/image_resize.php';
//print_r($_POST);
//echo "hi";
if($_POST['picturech']){
	$user_id = $_SESSION['user_id'];
	$articletext = $_POST['picturech'] ;
	$article_title = $_POST['picture_title'] ;
	$image = $_POST['img'] ;
	if (strlen($image) < 30 ) {
		$article = $articletext ;
	}
	else {
		$article = $image."<br/> ".$articletext ;
	}
	$time = date("Y-m-d H:i:s") ;
	$remaintime = 99 ;
	$firstname = $_SESSION['first_name'] ;
	$username = $_SESSION['username'] ;
	if (strlen($article) < 1000) {
        mysqli_query($db_handle,"INSERT INTO challenges (user_id, challenge_title, stmt, challenge_open_time, challenge_ETA, challenge_type, challenge_status, last_update) 
                                    VALUES ('$user_id', '$article_title', '$article', '1', '1', '3', '6', '$time') ; ") ;
		$idp = mysqli_insert_id($db_handle);                               
	} 
	else {
		mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) VALUES (default, '$article');");        
		$id = mysqli_insert_id($db_handle);
		mysqli_query($db_handle, "INSERT INTO challenges (user_id, challenge_title, blob_id, challenge_open_time, challenge_ETA, stmt, challenge_type, challenge_status, last_update) 
								VALUES ('$user_id', '$article_title', '$id', '1', '1', ' ', '3', '6', '$time');");
		$idp = mysqli_insert_id($db_handle);                               
	}
	mysqli_query($db_handle,"insert into involve_in (user_id, p_c_id, p_c_type) VALUES ('$user_id', '$idp', '1'),('$user_id', '$idp', '3'),('$user_id', '$idp', '5'),('$user_id', '$idp', '9') ;") ;
	$totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idp' and like_status = '1' ;");
	if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
	else { $likes = '' ; }
	$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$idp' and like_status = '2' ;");
	if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
	else { $dislikes = '' ; }
	$data = "" ;
	$timefunct = date("j F, g:i a") ;
	$chelange = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $article))))) ;
	$title = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $article_title))))) ;
	$ntitle = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $article_title)))) ;
	$nchallange = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $article)))) ;
	$data .= "<div class='list-group pict'>
                <div class='list-group-item'>
					<div class='dropdown pull-right'>
						<a href='#'' id='themes' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'><span class='caret'></span></a>
						<ul class='dropdown-menu'>
							<li><a class='btn-link' href='#' onclick='edit_content(\"".$idp."\", 1)'>Edit</a></li>
							<li><a class='btn-link' href='#' onclick='delChallenge(\"".$idp."\", 3);'>Delete</a></li>
						</ul>
					</div>" ;
    $data = $data ."<span style='font-family: Tenali Ramakrishna, sans-serif;' id='challenge_ti_".$idp."' class='text'><b>
					<a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$idp."' target='_blank'>".ucfirst($title)."</a>
					</b></span><input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$idp."' value='".$ntitle."'/><br/>
					<span class='icon-picture'></span>
					<span style= 'color: #808080;'>
					&nbspBy: <a href ='profile.php?username=" . $username . "' style= 'color: #808080;'>".ucfirst($firstname)."</a> | ".$timefunct."</span>
                    <hr/><span id='challenge_".$idp."' class='text' style='line-height: 25px; font-size: 14px; color: #444;'>".$chelange."</span><br/>" ;
      $data = $data .editchallenge($nchallange, $idp) ;
      $data = $data ."<hr/>".sharepage("http://www.collap.com/challengesOpen.php?challenge_id", $idp) ;
      $data = $data ."<hr/><div class='row-fluid'><div class='col-md-5'>
					<span class='icon-hand-up' style='cursor: pointer;' onclick='like(\"".$idp ."\", 1)'> <b>Push</b>
                        <input type='submit' class='btn-link' id='likes_".$idp ."' value='".$likes."'/> |</span> &nbsp;&nbsp;&nbsp;
                    <span class='icon-hand-down' style='cursor: pointer;' onclick='dislike(\"".$idp ."\", 2)'> <b>Pull</b>
                        <input type='submit' class='btn-link' id='dislikes_".$idp ."' value='".$dislikes."'/>&nbsp;</span></div></div><hr/>
                        <div class='comments_".$idp."'></div>
					<div id='step15' class='comments clearfix'>
						<div class='pull-left lh-fix'>
							<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
						</div>
						<input type='text' class='input-block-level' STYLE='width: 83.0%;' id='own_ch_response_".$idp."'
						 placeholder='Want to know your comment....'/>
						<button type='submit' class='btn btn-primary' onclick='comment(\"".$idp."\", 1)' style='margin-bottom: 10px;'>
						<span class='icon-chevron-right'></span></button>
					</div></div> </div> " ;
	if(mysqli_error($db_handle)) { echo "Failed to Post Video!"; }
	else { echo "Posted succesfully!"."|+"."2"."|+".$data ; }
} 
else { echo "Invalid parameters!"; }
mysqli_close($db_handle);
?>
