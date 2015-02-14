<?php 
session_start();
$user_id = $_SESSION['user_id'] ;
$pro_id = $_GET['project_id'] ;
	$project = mysqli_query($db_handle, "(SELECT a.user_id, a.stmt, a.project_type FROM projects as a join user_info as b WHERE a.project_id = '$pro_id' and a.blob_id = '0' 
										and a.user_id = b.user_id AND a.project_type != '3' and a.project_type != '5')
										UNION
										(SELECT a.user_id, b.stmt, a.project_type FROM projects as a join blobs as b join user_info as c WHERE a.project_id = '$pro_id' 
										and a.blob_id = b.blob_id and a.user_id = c.user_id AND a.project_type != '3' AND a.project_type != '5' );");
$project_row = mysqli_fetch_array($project);
$p_uid = $project_row['user_id'];
$projectType = $project_row['project_type'];
$projectstmt = str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $project_row['stmt']))));
if(substr($projectstmt, 0, 4) == '<img'){
	$projectstmt2 = substr(strstr($projectstmt, "<br/>" ), 5 ) ; 
	$projectst =showLinks($projectstmt2) ;
}
else {
	$projectst =showLinks($projectstmt) ;
}
echo "<div class='list-group'>
      <div class='list-group-item'>";
if ($p_uid == $user_id) {
    echo "<div class='dropdown pull-right'>
			  <a class='dropdown-toggle' data-toggle='dropdown' href='#' id='themes'><span class='caret'></span></a>
			  <ul class='dropdown-menu'>
				<li><a class='btn-link' href='#' onclick='editproject(".$pro_id.")'>Edit Project</a></li>
				<li><a class='btn-link' href='#' onclick='delChallenge(\"".$pro_id."\", 4)'>Delete Project</a></li>
				<li><a data-toggle='modal' class='btn-link' data-target='#project_order'>Sort Order</a></li>
			  </ul>
         </div>";
}
if($projectType == 1) {
	if(isset($_SESSION['user_id'])){
		$user_exist = mysqli_query($db_handle, "select * from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status='1' ;") ;
		$user_existNo = mysqli_num_rows($user_exist) ;
		if($user_existNo == 0) {
				echo "<button class='btn btn-primary pull-right joinproject' id='joinproject' onclick='joinproject(".$pro_id.")'>Join</button>" ;
		}
	}
	else {
		echo "<button class='btn btn-primary pull-right' onclick='test3()'>Join</button>" ;
		}
	}
echo "<span id='project_".$pro_id."' class='text' style='line-height:22px; font-size: 14px;'>".$projectst."</span><br/><hr/>
	<ul class='inline'>
	<li>
		<a href='https://twitter.com/share' class='twitter-share-button' data-url='http://collap.com/project.php?project_id=".$pro_id."' data-size='medium' data-related='collapcom' data-count='none' data-hashtags='digitalcollaboration'>Tweet</a>
	</li>
	<li>
	<div id='fb-root'></div>
	<div class='fb-share-button' data-href='http://collap.com/project.php?project_id=".$pro_id."' data-layout='button'></div>
	</li><li>
	<!-- Place this tag where you want the share button to render. -->
	<div class='g-plus' data-action='share' data-annotation='none'></div>
	</li><li>
	<script type='IN/Share'></script>
	</li>
	</ul>";
	
   echo editproject($projectstmt, $pro_id) ;
$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.user_id, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '1')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.user_id, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");
while ($displayrowc = mysqli_fetch_array($displayb)) {
    $frstnam = $displayrowc['first_name'];
    $lnam = $displayrowc['last_name'];
    $username_pr_comment = $displayrowc['username'];
    $ida = $displayrowc['response_pr_id'];
    $idb = $displayrowc['user_id'];
    $projectres = showLinks(str_replace("<s>", "&nbsp;", str_replace("<r>", "'", str_replace("<a>", "&",str_replace("<an>", "+", $displayrowc['stmt'])))));
    echo "<div id='commentscontainer'>
            <div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='".resize_image("uploads/profilePictures/$username_pr_comment.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp;&nbsp;&nbsp;
                </div>" ;
     if (isset($_SESSION['user_id'])) {
       dropDown_delete_comment_pr($ida, $user_id, $idb) ;
    }
           echo "<div class='comment-text'>
                    <span class='pull-left color strong'><a href ='profile.php?username=" . $username_pr_comment . "'>" . ucfirst($frstnam) . " 
                    " . ucfirst($lnam) . "</a>&nbsp</span> 
                    <small>" . $projectres . "</small>";
    echo "</div>
         </div> 
        </div>";
}
echo "<div class='comments_".$pro_id."'></div><div class='comments clearfix'>
			<div class='pull-left lh-fix'>
				<img src='".resize_image("uploads/profilePictures/$username.jpg", 30, 30, 2)."'  onError=this.src='img/default.gif'>&nbsp
			</div>";
if (isset($_SESSION['user_id'])) {
    echo "<input type='text' class='input-block-level' STYLE='width: 83%;' id='own_ch_response_".$pro_id."' placeholder='Want to know your comment....' />
          <button type='submit' onclick='comment(\"".$pro_id."\", 2)' class='btn btn-primary' style='margin-bottom: 10px;'>
            <i class='icon-chevron-right'></i>
          </button>";
} else {
    echo "<input type='text' class='input-block-level' STYLE='width: 83%;' placeholder='Want to know your comment....'/>
		  <a data-toggle='modal' data-target='#SignIn'>
			<button type='submit' class='btn btn-primary' name='login_comment' style='margin-bottom: 10px;'>
				<i class='icon-chevron-right'></i>
			</button>
		  </a>";
}
echo "</div>
</div>";
?>
