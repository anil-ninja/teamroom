<div class='footer' id='talkprForm' style='margin-left: 1000px; margin-right: 50px; margin-bottom: 30px; height: 300px; overflow-y: auto; overflow-x: hidden;'>  
       <?php 
       echo "<div class='list-group'>
				<div class='list-group-item'>
				<div id = 'newtalks' >" ;
$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '5')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '5') ORDER BY response_pr_creation ASC;");
while ($displayrowc = mysqli_fetch_array($displayb)) {
    $frstnam = $displayrowc['first_name'];
    $lnam = $displayrowc['last_name'];
    $username_pr_comment = $displayrowc['username'];
    $ida = $displayrowc['response_pr_id'];
    $idb = $displayrowc['response_pr_creation'];
    $projectres = $displayrowc['stmt'];
    echo "<div id='commentscontainer'>
            <div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username_pr_comment.jpg'  onError=this.src='img/default.gif'>
                </div>
                <div class='comment-text'>
                    <small>" . $projectres . "</small>
                </div>
            </div> 
        </div>";
}
echo "</div><div class='comments clearfix'>
			<div class='pull-left lh-fix'>
				<img src='uploads/profilePictures/".$username.".jpg'  onError=this.src='img/default.gif'>&nbsp
			</div>
				<input type='hidden' id='talkid' value='".$pro_id."'>
				<input type='text' STYLE='border: 1px solid #bdc7d8; width: 65%; height: 30px;' id ='pr_resptalk' placeholder='Whats on your mind about this project' />
				<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' id ='resp_projecttalk' ></button>
		</div>
	</div>
</div><input type='hidden' id='inlasttalkid' value='". $idb."'/>" ;
?>
</div>
