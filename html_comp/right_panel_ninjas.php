<div class="bs-component">
              
                      <p align="center"><font size="5"  color="silver">Your Projects</font></p>
                      
                    <div class="well">
                       <?php
                            $project_title_display = mysqli_query($db_handle, ("(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.project_creation FROM teams as a join projects 
                                                                                as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id)  
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE user_id = '$user_id');"));
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
                                echo "<form method='POST' action=''>
                                <input type='hidden' name='project_title' value='".$p_title."'/>
                                <input type='hidden' name='project_id' value='".$project_title_displayRow['project_id']."'/>
                                <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                                data-placement='bottom' data-original-title='".$title."' style='white-space: pre-line;'>".$p_title."</button><br/><br/></form>" ;
                            }
                        ?>
                    </div>
                    
              </div>
<!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
