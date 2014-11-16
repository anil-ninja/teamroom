<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['talks']) {
    $user_id = $_SESSION['user_id'];
    $id = $_POST['talks'] ;
    $time = $_POST['time'] ;
$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '5')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '5') ;");
while ($displayrowc = mysqli_fetch_array($displayb)) {
    $frstnam = $displayrowc['first_name'];
    $lnam = $displayrowc['last_name'];
    $username_pr_comment = $displayrowc['username'];
    $ida = $displayrowc['response_pr_id'];
    $idb = $displayrowc['response_pr_creation'];
    $projetres = $displayrowc['stmt'];
        echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
						<img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'> 
						<small>".$projetres."</small>
					</div>
				</div> 
			</div>";
}
}
?>
