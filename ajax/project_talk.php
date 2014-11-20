<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['prtalk']) {
    $user_id = $_SESSION['user_id'];
    $pro_id = $_SESSION['project_id'];
    $data = "" ;
    $data2 = "" ;
	$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '5')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '5') ORDER BY response_pr_creation ASC;");
	while ($displayrowc = mysqli_fetch_array($displayb)) {
		$ida = $displayrowc['response_pr_id'];
		$idb = $displayrowc['username'];
		$projectres = $displayrowc['stmt'];
		$data.= "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
						<img src='uploads/profilePictures/$idb.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<small>" . $projectres . "</small>
					</div>
				</div> 
			</div>";
	}
	$data = $data ."</div><div class='newtalkspr'></div>" ;
	$data2 .= "<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
						<img src='uploads/profilePictures/".$username.".jpg'  onError=this.src='img/default.gif'>&nbsp
					</div>
					<input type='text' STYLE='border: 1px solid #bdc7d8; width: 65%; height: 30px;' id ='pr_resptalk' placeholder='Whats on your mind about this project' />
					<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' onclick='submittalk()' ></button>
				</div>" ;
	echo $data."+".$data2."+".$ida ;
mysqli_close($db_handle);
}
?>
