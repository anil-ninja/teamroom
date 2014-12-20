<!--CReate Project Modal starts here -->

<div id="createProject" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span8 offset2">

            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="index.html#panel6-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Add Project</span></a></li>
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
                            <textarea class="input-block-level" id="project_stmt" placeholder="Details about Project"></textarea>
                            
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
                            <a href='collap.com'><p style='font-family: Sans-serif; font-size:26px;text-align:center;'><img src ='img/collap.gif' style="width:50px; height:40px;">Collap</p></a>
                            <h4><i class="icon-user"></i>&nbsp;&nbsp;Let's Collaborate</h4>
                            <p style='font-family: Sans-serif; font-size:14px;margin-top:20px;text-align:center; word-wrap: break-word;color:#3B5998;'>
                                Collap is exodus to make collaboration strong. Lets work together to do more... 
                            </p>
                            <label>Enter Email</label>
                            <input type="email" class="input-block-level" id='subscriptionid' placeholder='Enter Email-ID'/>
                            <br>
                            <a href="#" class=" btn " onclick='Subscribe()'>Subscribe&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                            <a href="#" class="btn btn-primary pull-right" onclick='test2()'>Sign up</a>
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
                        <textarea class="input-block-level" id='answerchal' placeholder="Submit your answer"></textarea>
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