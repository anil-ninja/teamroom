<!-- Modal  -->

<div id="createProject" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span8 offset2">

            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="index.html#panel6-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Add Project</span></a></li>
                    <li><a href="index.html#close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active" id="panel6-1">
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
                                <a href="index.html#" class=" btn " id = "create_project">Create Project&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   


<div class="modal fade" id="createProject_old" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Create New Project</h4>
            </div>
            <div class="modal-body">
                <form >
                    <input type="text" class="form-control" id="project_title" placeholder="Enter Project Title"><br>
                    <input class="btn btn-default btn-sm" type="file" id="_fileProject" style ="width: auto;"><br/>
                    <textarea rows="3" class="form-control" id="project_stmt" placeholder="Details about Project"></textarea><br/>
                 <!--   Estimated Time (ETA)
                    <select id = "eta" >    
                        <option value='0' selected >Month</option>
                        <?php /*
                        $m = 1;
                        while ($m <= 11) {
                            echo "<option value='" . $m . "' >" . $m . "</option>";
                            $m++;
                        }
                        ?>
                    </select>&nbsp;<select id = "etab" >    
                        <option value='0' selected >Days</option>
                        <?php
                        $d = 1;
                        while ($d <= 30) {
                            echo "<option value='" . $d . "' >" . $d . "</option>";
                            $d++;
                        }
                        ?>
                    </select>&nbsp;<select id = "etac" >    
                        <option value='0' selected >hours</option>
                        <?php
                        $h = 1;
                        while ($h <= 23) {
                            echo "<option value='" . $h . "' >" . $h . "</option>";
                            $h++;
                        } */
                        ?>
                    </select>&nbsp;<select id= "etad" > 
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select>
                    <br/><br/> -->Project Type 
                    <select id= "type" >    
                        <option value='2' selected >Classified</option>
                        <option value='1' >Public</option>
                    </select>
                    <br/><br/>
                    <input type="button" class="btn btn-primary" id = "create_project" value = "Create Project" >
                </form>
            </div>
            <div class="modal-footer">
                <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="signupwithoutlogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content" style='border: 10px solid #DDD ;margin-top: 100px; position:fixed; margin-left: 200px; width:400px; height:300px;'>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <a href='collap.com'><p style='font-family: Sans-serif; font-size:26px;text-align:center;'><img src ='img/collap.gif' style="width:50px; height:40px;">Collap</p></a>
                <h4 class="modal-title" id="myModalLabel"><p style='font-family: Sans-serif; font-size:20px;margin-top:10px;text-align:center; word-wrap: break-word;'>Let's Collaborate</p></h4>
                <p style='font-family: Sans-serif; font-size:14px;margin-top:20px;text-align:center; word-wrap: break-word;color:#3B5998;'>
                Collap is exodus to make collaboration strong. Lets work together to do more... </p><br/><br/>
                <div class='row'>
                    <div class='col-md-8'>
                        <input type='email' class='form-control' style='width: 105%;' id='subscriptionid' placeholder='Enter Email-ID'/>
                    </div>
                    <div class='col-md-3'>
                        <input type='submit' class='btn btn-success' onclick='Subscribe()' value='Subscribe'/><br/>
                    </div>
                </div><br/>
                <button class="btn btn-primary pull-right" style='margin-right:10px;' onclick='test2()'>Sign up</button>
        </div>
    </div>
</div>
<div class='modal fade' id='answerForm' tabindex='-1' role='dialog' aria-labelledby='myModalLabel1' aria-hidden='true'>
    <div class='modal-dialog'> 
        <div class='modal-content'>
            <div class='modal-header'> 
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class='modal-title' id='myModalLabel'>Submit Answer</h4> 
            </div> 
            <div class='modal-body'>
                <form>  
                    <div class='input-group-addon'>
                        <textarea row='5' id='answerchal' class='form-control' placeholder='submit your answer'></textarea>
                    </div>
                    <br/>
                    <input class='btn btn-default btn-sm' type='file' id='_fileanswer' style ='width: auto;'>
                    <br/>
                    <input type='hidden' id='answercid' value=''>
                    <input type='hidden' id='prcid' value=''>
                    <button type='submit' class='btn btn-success btn-sm' id='answerch' >Submit</button> 
                </form>
            </div> 
            <div class='modal-footer'>
                <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div> 
    </div>
</div>