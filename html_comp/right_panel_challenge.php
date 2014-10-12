<?php
	include_once 'project.inc.php';
?>

 <div class="bs-component">
              <div class="modal">
                  <div class="modal-content">
                    <div class="modal-header">
                      <p align="center"><font color="silver">
						  <a data-toggle="modal" class="btn btn-default btn-sm" data-target="#createChallenge" style="cursor:pointer;"><i class="glyphicon glyphicon-edit"></i>Create Challenge</a><br/><br/>
						  <a data-toggle="modal" class="btn btn-default btn-sm" data-target="#createProject" style="cursor:pointer;"><i class="glyphicon glyphicon-edit"></i>Create Project</a><br/>
					 </font></p>
                    </div>  
                    <div class="modal-body">
						<div class="well">
							<ul class="nav">
								<label class='tree-toggle nav-header btn-default btn-xs' ><p align="center">Your Projects</p><br/></label>
								<ul class='nav tree' style='display: none;'>
                        <?php
                            $project_title_display = mysqli_query($db_handle, ("(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.project_creation FROM teams as a join projects 
                                                                                as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '1')  
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE user_id = '$user_id' and project_type = '1');"));
                            while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
                                $p_title = $project_title_displayRow['project_title'] ;
                                $p_eta = $project_title_displayRow['project_ETA'] ;
                                $p_time = $project_title_displayRow['project_creation'] ;
                                $eta = $p_eta*60 ;
								$day = floor($eta/(24*60*60)) ;
								$daysec = $eta%(24*60*60) ;
								$hour = floor($daysec/(60*60)) ;
								$hoursec = $daysec%(60*60) ;
								$minute = floor($hoursec/60) ;
								$remaining_time = "ETA : ".$day." Days :".$hour." Hours :".$minute." Min" ;
								$title = "Project Created ON : ".$p_time." ".$remaining_time ;			
                                echo "<li><form method='POST' action=''>
                                <input type='hidden' name='project_title' value='".$p_title."'/>
                                <input type='hidden' name='project_id' value='".$project_title_displayRow['project_id']."'/>
                                <p align='center' ><input type='submit' class='btn btn-default' name='projectphp' data-toggle='tooltip' 
                                data-placement='bottom' data-original-title='".$title."' value='".ucfirst($p_title)."' style='white-space: normal;'/></p></form></li>" ;
                            }
                        ?>
                        </ul></div>
                       </div>
                    <div class="modal-footer">
                  </div>
                </div>
              </div>
            </div>


    <!-- Modal -->
    <div class="modal fade" id="createChallenge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create Challenge</h4>
                </div>
                <div class="modal-body">
                          <form >
                        <div class="input-group-addon">
                        <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte"/>
                         </div><br>
                        <div class="input-group-addon">
                        <textarea rows="3" class="form-control" placeholder="Details of Challange" id='challange'></textarea>
                        </div><br>
                        <div class="inline-form">
                        Challenge Open For 
                        <select class="btn btn-default btn-xs"  id= "open_time" >	
                            <option value='0' selected >hour</option>
                            <?php
                                $o = 1 ;
                                while ($o <= 24){
                                    echo "<option value='".$o."' >".$o."</option>" ;
                                    $o++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "open" >	
                            <option value='10' selected >minute</option>
                            <option value='20'  >20</option>
                            <option value='30' >30</option>
                            <option value='40'  >40</option>
                            <option value='50' >50</option>
                        </select><br/><br/>ETA
                        <select class="btn btn-default btn-xs" id= "c_eta" >	
                            <option value='0' selected >Month</option>
                            <?php
                                $m = 1 ;
                                while ($m <= 11){
                                    echo "<option value='".$m."' >".$m."</option>" ;
                                    $m++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etab" >	
                            <option value='0' selected >Days</option>
                            <?php
                                $d = 1 ;
                                while ($d <= 30){
                                    echo "<option value='".$d."' >".$d."</option>" ;
                                    $d++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etac" >	
                            <option value='0' selected >hours</option>
                                <?php
                                    $h = 1 ;
                                    while ($h <= 23){
                                        echo "<option value='".$h."' >".$h."</option>" ;
                                        $h++ ;
                                    }
                                ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etad" >	
                            <option value='15' selected >minute</option>
                            <option value='30' >30</option>
                            <option value='45'  >45</option>
                        </select><br/><br/>                          
                        <input id="submit_ch" class="btn btn-success" type="button" value="Create Challange"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div></div>
    <!--end modle-->

<!-- Modal -->
                <div class="modal fade" id="createProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Create New Project</h4>
                            </div>
                            <div class="modal-body">
                                <form >
                                    <div class="input-group-addon" >
                                        <input type="text" class="form-control" id="project_title" placeholder="Enter Project Title">
                                    </div>
                                    <br>
                                    <div class="input-group-addon">
                                        <textarea rows="3" class="form-control" id="project_stmt" placeholder="Details about Project"></textarea>
                                    </div>
                                    <br/>
                                        Estimated Time (ETA)
                                           <select id = "eta" >	
												<option value='0' selected >Month</option>
                                        <?php
											$m = 1 ;
                                        while ($m <= 11){
											echo "<option value='".$m."' >".$m."</option>" ;
											$m++ ;
                                              }
                                        ?>
                                    </select>&nbsp;<select id = "etab" >	
												<option value='0' selected >Days</option>
                                        <?php
											$d = 1 ;
                                        while ($d <= 30){
											echo "<option value='".$d."' >".$d."</option>" ;
											$d++ ;
                                              }
                                        ?>
                                    </select>&nbsp;<select id = "etac" >	
												<option value='0' selected >hours</option>
                                        <?php
											$h = 1 ;
                                        while ($h <= 23){
											echo "<option value='".$h."' >".$h."</option>" ;
											$h++ ;
                                              }
                                        ?>
                                    </select>&nbsp;<select id= "etad" >	
												<option value='15' selected >minute</option>
												<option value='30' >30</option>
												<option value='45'  >45</option>
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
        <!--end modle-->

