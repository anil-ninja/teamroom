<!--CReate Project Modal starts here -->

<div id="createProject" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span8 offset2">

            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Add Project</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <div class="row-fluid">
                            <h4><i class="icon-user"></i>&nbsp;&nbsp;Create New Project </h4>

                            <label>Project Title</label>
                            <input type="text" class="input-block-level" id="project_title" placeholder="Enter Project Title"/>
                            <label>Upload File</label>
                            <input type="file" id="_fileProject"/>
                            
                            <label>Details about Project</label>
                            <textarea class='input-block-level autoExpand' data-min-rows='3' id="project_stmt" placeholder="Details about Project"></textarea>
                            
                            <br />
                            <label>Project Type</label> 
                            <select id= "type" >    
                                <option value='2' selected >Classified</option>
                                <option value='1' >Public</option>
                            </select>
                            <br/><br/>
                            <a href="#" class=" btn btn-primary" id = "create_project">Create Project&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<!--CReate Project Modal ends here -->


<!--Subscribe to collap for logout starts here -->
<div id="signupwithoutlogin" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span6 offset3">
            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-unlock"></i>&nbsp;<span>Subscribe</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <div class="row-fluid">
                            <a href='index.php'><p style='font-size:26px;text-align:center;'><img src ='img/collap.gif' style="width:50px; height:40px;">Collap</p></a>
                            <h4><i class="icon-user"></i>&nbsp;&nbsp;Let's Collaborate</h4>
                            <p style='font-size:14px;margin-top:20px;text-align:center; word-wrap: break-word;color:#3B5998;'>
                                Collap is exodus to make collaboration strong. Lets work together to do more... 
                            </p>
                            <label>Enter Email</label>
                            <input type="email" class="input-block-level" id='subscriptionid' placeholder='Enter Email-ID'/>
                            <br>
                            <a href="#" class=" btn " onclick='Subscribe()'>Subscribe&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                            <a class='btn btn-primary pull-right' onclick='test2()'>Sign up/Sign In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Subscribe to collap for logout ends here -->

<!--Submit Answer Modal starts here -->
<div id="answerForm" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span6 offset3">
            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-unlock"></i>&nbsp;<span></span>Answer</a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <h4><i class="icon-user"></i>&nbsp;&nbsp;Submit Answer</h4>

                        <label>Your Answer</label>
                        <textarea class="input-block-level" id='answerchal' placeholder="Submit your answer"></textarea><br>
                        <label>Upload File</label>
                        <input type='file' id='_fileanswer'/>
                        <input type='hidden' id='answercid' value=''>
                        <input type='hidden' id='prcid' value=''>
                        <a href="#" class=" btn btn-primary" id='answerch'>Submit&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<!--Submit Answer Modal ends here -->
<!-- Create Team modal -->
<div id="AddTeam" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style='position:absolute;'>
    <div class="row-fluid">
        <div class="span6 offset3">
            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-user"></i>&nbsp;<span>Create Team</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active" id='create_team_modal'>
                        <div class="row-fluid"><br/>
							<div class='span6' style='margin: 4px;'>
								<label class='TeamName'>Team Name</label> 
								<div id='myteamname'></div>
								<div class='TeamMembers'></div>
								<input type='text' class='input-block-level' id='team_name_A' placeholder='Team name ..'><br/>                  
								<input type='email' class='input-block-level' id='email_team' placeholder='Enter First team member Email'><br/>
							</div>
							<label>Add Friends</label>
							<div class='span6' style='max-height:150px;overflow-y:scroll;margin: 4px; background-color:#f2f2f2;'>
                            <table >
								<tbody>
							<?php
							$userProjects = mysqli_query($db_handle, "(SELECT a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
																		where a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id')
																		as b where a.user_id = b.user_id )
																		UNION
																		(select a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join known_peoples as b
																		where b.requesting_user_id = '$user_id' and a.user_id = b.knowning_id and b.status != '4')
																		UNION
																		(select a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join known_peoples as b
																		where b.knowning_id = '$user_id' and a.user_id = b.requesting_user_id and b.status = '2') ;");
							if (mysqli_num_rows($userProjects) != 0 ) {
								while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
									$friendFirstName = $userProjectsRow['first_name'];
									$friendLastName = $userProjectsRow['last_name'];
									$usernameFriends = $userProjectsRow['username'];
									$useridFriends = $userProjectsRow['user_id'];
									echo "<tr id='username_".$useridFriends."'><td>".$friendFirstName." ".$friendLastName."</td><td style='padding-left:20px;'><button class='btn btn-primary' onclick='CreateTeamMember(\"".$useridFriends."\")'>Add</button></td></tr>" ;
								}
							}
							?>                    
                            </tbody></table>
							</div>
                        </div><br/>
                        <input type='submit' class='btn btn-primary' id='create_team' onclick='create_team()' value='Create New Team'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$(".TeamName").hide();
</script>
