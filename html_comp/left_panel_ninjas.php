<div class="bs-component">
              
                      <p align="center"><font size="4">Your Projects</font></p>
                      
                    <div class="well">
                       <?php
                            $project_title_display = mysqli_query($db_handle, ("(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.project_creation FROM teams as a join projects 
                                                                                as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '1')  
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE user_id = '$user_id' and project_type= '1');"));
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
								$starttimestr = (string) $p_time ;
								$initialtime = strtotime($starttimestr) ;
								$totaltime = $initialtime+($eta*60) ;
								$completiontime = time() ;
						if ($completiontime > $totaltime) { 
							$remaining_time_own = "Closed" ; }
						else {	$remainingtime = ($totaltime-$completiontime) ;
								$day = floor($remainingtime/(24*60*60)) ;
								$daysec = $remainingtime%(24*60*60) ;
								$hour = floor($daysec/(60*60)) ;
								$hoursec = $daysec%(60*60) ;
								$minute = floor($hoursec/60) ;
								$remaining_time_own = "Remaining Time : ".$day." Days :".$hour." Hours :".$minute." Min " ;
						}
                                $time_for_project =  $day." Days :".$hour." Hours :".$minute." Min" ;
                                echo "<form method='POST' action=''>
                                <input type='hidden' name='project_title' value='".$p_title."'/>
                                <input type='hidden' name='project_id' value='".$project_title_displayRow['project_id']."'/>
                                <p align='left'><button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                                data-placement='bottom' data-original-title='".$title."' style='white-space: pre-line;font-size:14px;'><b>".ucfirst($p_title)."</b><br/><p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>".$remaining_time_own."</p></button></p></form>" ;
                            }
                           echo "<a data-toggle='modal' class='btn btn-link' data-target='#createProject' style='cursor:pointer;'><i class='glyphicon glyphicon-plus'></i> Project</a>" ;
                        ?>
                    </div>
                    
              </div>
