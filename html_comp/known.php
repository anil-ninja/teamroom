<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
    <ul class="nav nav-tabs">
        <li class="active" >
               
                    
              <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Collaborating With </b></span></a>

        </li>
    </ul>

    <div id='demo7' class="tab-content" >
        <div role="tabpanel" class="row tab-pane active" id="tabCreatedProjects">

 <div>
	<?php
	$user_id = $_SESSION['user_id'] ;
	$userProjects = mysqli_query($db_handle, "(SELECT a.first_name, a.last_name, a.username, a.user_id, a.rank FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
												where a.user_id = '$profileViewUserID' and a.team_name = b.team_name )
											    as b where a.user_id = b.user_id and b.user_id != '$profileViewUserID' and b.user_id != '$user_id')
											    UNION
											    (select a.first_name, a.last_name, a.username, a.user_id, a.rank FROM user_info as a join known_peoples as b
											    where b.requesting_user_id = '$profileViewUserID' and b.knowning_id != '$user_id' and a.user_id = b.knowning_id and b.status != '4' and b.status != '3')
											    UNION
											    (select a.first_name, a.last_name, a.username, a.user_id, a.rank FROM user_info as a join known_peoples as b
											    where b.knowning_id = '$profileViewUserID' and b.requesting_user_id != '$user_id' and a.user_id = b.requesting_user_id and b.status = '2');");
    if (mysqli_num_rows($userProjects) == 0) {
        echo "<div class ='row' style='margin: 4px -15px 4px -15px; background : rgb(240, 241, 242);'>
                <i>You are not Collaborating with anyone, Send link for Collaboration</i>
            </div>";
    } 
    else {
    	while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
    		$friendFirstName = $userProjectsRow['first_name'];
    		$friendLastName = $userProjectsRow['last_name'];
    		$usernameFriends = $userProjectsRow['username'];
    		$useridFriends = $userProjectsRow['user_id'];
    		$friendRank = $userProjectsRow['rank'];
    			
    		$firends = mysqli_query($db_handle, "(SELECT a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
                                                  where a.user_id = '$user_id' and a.team_name = b.team_name )
                                                  as b where a.user_id = b.user_id and b.user_id != '$user_id' and b.user_id != '$profileViewUserID')
                                                  UNION
    											  (select a.user_id FROM user_info as a join known_peoples as b
    											  where b.requesting_user_id = '$user_id' and b.knowning_id != '$profileViewUserID' and a.user_id = b.knowning_id and b.status != '4' and b.status != '3')
    											  UNION
    											  (select a.user_id FROM user_info as a join known_peoples as b
    											  where b.knowning_id = '$user_id' and b.requesting_user_id != '$profileViewUserID' and a.user_id = b.requesting_user_id and b.status = '2') ;");
    		while($firendsRow = mysqli_fetch_array($firends)) {
                        $firendsuserid = $firendsRow['user_id'];
                        if ($firendsuserid == $useridFriends) {	
                            $flag = 1;
                            break;
                        }		   
    		}
    		if ($flag) {			
                        echo "<div class ='row' style='margin: 4px -15px 4px -15px; background : rgb(240, 241, 242);'>
                                <div class ='span3 ' style='padding:1px;'>
                                    <img src='uploads/profilePictures/$usernameFriends.jpg'  onError=this.src='img/default.gif' style='height:35px; width: 35px;' class='img-responsive'>
                                </div>
                                <div class = 'span8' style='font-size:12px;padding: 1px;'><span class='color pull-left' id='new_added'><a href ='profile.php?username=" . $usernameFriends. "'>" 
                                    .ucfirst($friendFirstName)." ".ucfirst($friendLastName)."</a></span><br/><span style='font-size:10px;'>"
                                    .$friendRank."</span>
                                </div><br/>
                            </div>";
                    }		   
                    else {
                        echo "<div class ='row' style='margin: 4px -15px 4px -15px;background : rgb(240, 241, 242);'>
                                <div class ='span3' style='padding:1px;'>
                                    <img src='uploads/profilePictures/$usernameFriends.jpg'  onError=this.src='img/default.gif' style='height:35px; width: 35px;' class='img-responsive'>
                                </div>
                                <div class = 'span6' style='font-size:12px;padding: 1px;'>
                                    <span class='color pull-left' id='new_added'><a href ='profile.php?username=" . $usernameFriends. "'>" 
                                        .ucfirst($friendFirstName)." ".ucfirst($friendLastName)."</a>
                                    </span><br/>
                                    <span style='font-size:10px;'>".$friendRank."</span>
                                </div>";
                        if (isset($_SESSION['user_id'])) {
                            echo "<div class = 'span3' style='font-size:12px;padding-left: 1px; padding-right: 0px;'>
                                        <input type = 'submit' class = 'btn-success' onclick='knownperson(".$useridFriends.")' value = 'Link'/>
                                </div>";
                        }
                        echo "</div>";
                    }
                    $flag = 0;
            }
        }  
	?>
</div>
</div>
</div>

<br/>
<?php include_once 'recommended.php'; ?>
