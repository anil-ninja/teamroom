<div class="bs-component">
              
                      <p align="center"><font size="4">Your Projects</font></p><hr/>
                       <?php
                            $project_title_display = mysqli_query($db_handle, ("(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.project_creation FROM teams as a join projects 
                                                                                as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '1')  
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE user_id = '$user_id' and project_type= '1');"));
                                while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
                                $p_title = $project_title_displayRow['project_title'] ;
                            if (strlen($p_title) > 25) {
								$prtitle = substr($p_title,0,26)."....";
								} else {
									$prtitle = $p_title ;
								}								   
                                $p_eta = $project_title_displayRow['project_ETA'] ;
                                $p_time = $project_title_displayRow['project_creation'] ;
                                $timefunc = date("j F, g:i a",strtotime($p_time));
                                $eta = $p_eta*60 ;
								$day = floor($eta/(24*60*60)) ;
								$daysec = $eta%(24*60*60) ;
								$hour = floor($daysec/(60*60)) ;
								$hoursec = $daysec%(60*60) ;
								$minute = floor($hoursec/60) ;
								$remaining_time = "ETA : ".$day." Days :".$hour." Hours :".$minute." Min" ;
								$title =  strtoupper($p_title)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefunc ;	
								$starttimestr = (string) $p_time ;
								$initialtime = strtotime($starttimestr) ;
								$totaltime = $initialtime+($eta*60) ;
								$completiontime = time() ;
						if ($completiontime > $totaltime) { 
							$remaining_time_own = "Closed" ; 
						} else {	
								$remainingtime = ($totaltime-$completiontime) ;
								$day = floor($remainingtime/(24*60*60)) ;
								$daysec = $remainingtime%(24*60*60) ;
								$hour = floor($daysec/(60*60)) ;
								$hoursec = $daysec%(60*60) ;
								$minute = floor($hoursec/60) ;
						if ($totaltime > ((24*60*60)-1)) {
		if($hour != 0) {
		$remaining_time_own = $day." Days and ".$hour." Hours" ;
		} else {
			$remaining_time_own = $day." Days" ;
			}
	} else {
			if (($totaltime < ((24*60*60)-1)) AND ($totaltime > ((60*60)-1))) {
				$remaining_time_own = $hour." Hours and ".$minute." Mins" ;
				} else {
					$remaining_time_own = $minute." Mins" ;
					}
		}
						}
                                $time_for_project = $day." Days :".$hour." Hours :".$minute." Min" ;
                                echo "<form method='POST' action=''>
                                <input type='hidden' name='project_id' value='".$project_title_displayRow['project_id']."'/>
                                <button type='submit' class='btn btn-link' name='projectphp' data-toggle='tooltip' 
                                data-placement='bottom' data-original-title='".$title."' style='height: 20px;font-size:12px;'>
                                ".$prtitle."</button>
                                <br/><p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>&nbsp;&nbsp;&nbsp;&nbsp;".$remaining_time_own."</p></form>" ;
                            }
                        ?><hr/><hr/>
                        <a data-toggle='modal' class='btn btn-link' data-target='#createProject' style='cursor:pointer;'><i class='glyphicon glyphicon-plus'></i> Project</a>
              </div>
