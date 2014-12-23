<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
    <ul class="nav nav-tabs">
        <li class="active" >
               
                    
              <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Recommended</b></span></a>

        </li>
	</ul>

	<div class="tab-content" >
	    <div role="tabpanel" class="row tab-pane active" id="tabCreatedProjects">


<?php 
	if (isset($_SESSION['user_id'])) {
		
	
		$Recommended = mysqli_query($db_handle, "SELECT * FROM user_info where user_id NOT IN (SELECT a.user_id FROM user_info as a join 
												(SELECT DISTINCT b.user_id FROM teams as a join teams as b where a.user_id = '$user_id' and 
												a.team_name = b.team_name ) as b where a.user_id = b.user_id) and user_id NOT IN (select a.user_id 
												FROM user_info as a join known_peoples as b where b.requesting_user_id = '$user_id' and 
												a.user_id = b.knowning_id and b.status != '4' and b.status != '3')
												and user_id NOT IN (select a.user_id FROM user_info as a join known_peoples as b
												where b.knowning_id = '$user_id' and a.user_id = b.requesting_user_id and b.status = '2')
												 ORDER by rand() limit 0, 5 ;");
		while ($RecommendedRow = mysqli_fetch_array($Recommended)) {
			$friendFirstNamer = $RecommendedRow['first_name'];
			$friendLastNamer = $RecommendedRow['last_name'];
			$usernameFriendsr = $RecommendedRow['username'];
			$useridFriendsr = $RecommendedRow['user_id'];
			$friendRankr = $RecommendedRow['rank'];	     
			echo "<div class ='row' style='border-width: 1px; margin: 4px -15px 4px -15px; background : rgb(240, 241, 242);'>
					<div class ='span2' style='padding:1px;'>
						<img src='uploads/profilePictures/$usernameFriendsr.jpg'  onError=this.src='img/default.gif' style='height:40px' class='img-responsive'>
					</div>
					<div id='demo9' class = 'span6' style='font-size:12px;padding: 1px;'>
						<span class='color pull-left' id='new_added'>
							<a href ='profile.php?username=" . $usernameFriendsr. "'>" 
								.ucfirst($friendFirstNamer)." ".ucfirst($friendLastNamer)."
							</a>
						</span>
						<br/>
						<span style='font-size:10px;'>".$friendRankr."</span>
					</div>";
			if (isset($_SESSION['user_id'])) {
				echo "	<div id='demo8' class = 'span3' style='font-size:12px;padding-left: 1px; padding-right: 0px;'>
							<input type = 'submit' class = 'btn btn-success' onclick='knownperson(".$useridFriendsr.")' value = 'Link'/>
						</div>";
				}
			echo "</div>";
			}
	} 
?>
</div>
</div>
</div>
