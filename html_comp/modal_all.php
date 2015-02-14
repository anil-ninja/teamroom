<!--CReate Project Modal starts here -->

<div id="createProject" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style='position:absolute;'>
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
                            <select id= "type" onchange='projectinfo()' >    
                                <option value='0' selected >Default</option>
                                <option value='2' >Classified</option>
                                <option value='1' >Public</option>
                                <option value='4' >Private</option>
                            </select>
                            <br/><br/>
                            <div class='aboutfunding'>
                            <input type="checkbox" data-toggle="button" class="btn btn-mini custom-checkbox" id ='fundProject' onclick='aboutfund()' /> Fund Needed <br/><br/>
                            <div class='aboutfund'>
                            <input type="number" class="input-block-level" id="project_value" min="1" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" style="width:30%;" placeholder="Enter Project Value in dollers"/> <strong>$ (Project Value)</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="number" class="input-block-level" id="project_fundneed" min="1" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" style="width:30%;" placeholder="Enter Fund Needed in dollers"/> <strong>$ (Fund Needed)</strong><br/><br/>
                            </div></div>
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
							<div class='span6 teamAddModal' style='max-height:150px;overflow-y:scroll;margin: 4px; background-color:#f2f2f2;'>
							</div>
                        </div><br/>
                        <input type='submit' class='btn btn-primary' id='create_team' onclick='create_team()' value='Create New Team'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Team member modal -->
<div id="AddMember" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style='position:absolute;'>
    <div class="row-fluid">
        <div class="span6 offset3">
            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-user"></i>&nbsp;<span>Add Member</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active" id='add_member_modal'>
                        <div class="row-fluid"><br/>
							<div class='span6' style='margin: 4px;'>
								<label>Team Name</label> 
								<div id='teamname'></div><br/>
								<div class='TeamMembers' id='TeamMembers'></div>                  
								<input type='email' class='input-block-level' id='email_add_member' placeholder='Enter team member Email'><br/>
							</div>
							<label>Add Friends</label>
							<div class='span6 membersAddModal' style='max-height:150px;overflow-y:scroll;margin: 4px; background-color:#f2f2f2;'>
							</div>
                        </div><br/>
                        <input type='submit' class='btn btn-primary' id='add_member' onclick='add_member()' value='Add'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Invest In Project Modal --->
<div id="Investment" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span5 offset4">
            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Invest in Project</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <div class="row-fluid">
                            <h4>&nbsp;&nbsp;&nbsp;<i class="icon-user"></i>&nbsp;&nbsp;Invest in Project </h4>
                            <label>&nbsp;&nbsp;&nbsp; Amount You want to Invest (In Dollers)</label>
                            &nbsp;&nbsp;&nbsp; <input type="number" class="input-block-level" id="fund_amount" min="1" onkeypress="return IsNumeric(event);" ondrop="return false;" 
                            onpaste="return false;" style="width:80%;" placeholder="Enter Amount in dollers"/><span style='font-size:28px;'>$</span><br/><br/>
                            &nbsp;&nbsp; <a href="#" class=" btn btn-primary" id = "invest" onclick='invest()'>Invest &nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<!--Join Project Modal starts here -->

<div id="joinProject" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style='position:absolute;'>
    <div class="row-fluid">
        <div class="span10 offset1">
            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Join Projects</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <div class="row-fluid">
                            <h4>&nbsp;&nbsp;<i class="icon-user"></i>&nbsp; Join New Projects </h4>
                            <div class='span12 insertprojects' style=' margin:4px;'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<!--Join Project Modal ends here -->
<script>
	$(".TeamName").hide();
	$(".aboutfund").hide();
	$(".aboutfunding").hide();
	function aboutfund() {
		$(".aboutfund").toggle();
	}
</script>
