<br/>
<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
    <ul class="nav nav-tabs">
        <li id='step6' class="active" >
<?php 
    if (isset($_SESSION['user_id'])) {
        echo "<a class='btn-link' data-toggle='modal' data-target='#createProject' style='cursor:pointer;padding :5px;color:#000;'> 
                <b> Projects </b>
                <font size='1'> &nbsp;&nbsp;&nbsp;
                    <i class='icon-plus'></i>Add
                </font>
			 </a>";
    }
    else {
        echo "
            <a class='btn-link' data-toggle='modal' data-target='#SignIn' style='cursor:pointer;padding :5px ;color:#000;'> 
                <b> Projects </b>
                <font size='1'> &nbsp;&nbsp;&nbsp;
                    <i class='icon-plus'></i>Add
                </font>
			 </a>";
    }
?>
        </li>
    </ul>

    <div class='list-group-item' style="padding-left: 0px; padding-right: 0px;">
        
<?php 
    if (isset($_SESSION['user_id'])) {              
 		echo "
			<div class='panel panel-default'>
				<div class='panel-heading' style ='padding: 0px 0px 0px 5px;'>
					<font size='2'><b>Classified Projects</b></font>
                </div>
				<div class='bs-component' style='max-height:130px; overflow-y:scroll;'>
				<table><tbody>";   
        $project_title_display = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.creation_time, b.stmt 
                                                            FROM teams as a join projects as b WHERE a.user_id = '$user_id' 
                                                            AND a.project_id = b.project_id AND b.project_type = '2')  
                                                            UNION 
                                                            (SELECT DISTINCT project_id, project_title, project_ETA, creation_time, stmt 
                                                            FROM projects WHERE user_id = '$user_id' AND project_type= '2');");
        
        if (mysqli_num_rows($project_title_display) == 0) {
			echo " <tr><td><i>No any projects to display,</i><br>
					<a class='active' data-toggle='modal' data-target='#createProject' style='cursor:pointer;'> 
						<font size='1'> 
							<i class='icon-plus'>&nbsp; Create Project</i>
						</font>
					</a></td></tr>";
        } 
        else {
            while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
                $p_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_title_displayRow['project_title']))) ;
                $idpro = $project_title_displayRow['project_id'] ;
                $Prostmt =  $project_title_displayRow['stmt'] ;
                //echo $Prostmt;
                if(substr($Prostmt, 0, 4) == '<img') {
					$ProjectPicFull = strstr($Prostmt, '<br/>' , true) ;
				}
				else {
					$ProjectPicFull = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
				}
				$ProjectPicLink2 =explode("\"",$ProjectPicFull)[1] ; 			
				$ProjectPic = "<img src='".resize_image($ProjectPicLink2, 15, 15)."' onError=this.src='img/default.gif' style='height:15px;width:15px;'>" ;
				
                if (strlen($p_title) > 15) {
                    $prtitle = substr(ucfirst($p_title),0,15)." ...";
                } 
                else {
                    $prtitle = ucfirst($p_title) ;
                }								   
                $p_eta = $project_title_displayRow['project_ETA'] ;
                $p_time = $project_title_displayRow['creation_time'] ;
                $timefunc = date("j F, g:i a",strtotime($p_time));
                $title =  strtoupper($p_title)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefunc ;
                // $remaining_time_own = remaining_time($p_time, $p_eta);
                echo "<tr>
						<td style='padding-left: 5px;'>
							<a href = 'project.php?project_id=".$idpro."'>".$ProjectPic ."</a>
						</td>
						<td><a href = 'project.php?project_id=".$idpro."'>". $prtitle."</a></td>
					  </tr>";
            }
        }  
        echo "</tbody></table></div>
            </div>";
    ?>
			<div class='panel panel-default'>
				<div class='panel-heading' style ='padding: 0px 0px 0px 5px;'>
					<font size='2'><b>Public Projects</b></font>
                </div>
				<div class='bs-component' style='max-height:130px;overflow-y:scroll;'>
					<table><tbody>
        <?php
            $project_public_title_display = mysqli_query($db_handle, "SELECT * FROM projects WHERE user_id = '$user_id' and project_type = '1' ;") ;
            
            if (mysqli_num_rows($project_public_title_display) == 0) {
                echo "<tr><td><i>No any projects to display,</i><br>
					<a data-toggle='modal' data-target='#createProject' style='cursor:pointer;'> 
						<font size='1'> 
							<i class='icon-plus'>&nbsp; Create Project</i>
						</font>
					</a></td></tr>";
            } 
            else {
                while ($project_public_title_displayRow = mysqli_fetch_array($project_public_title_display)) {
    				$public_pr_titlep = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_public_title_displayRow['project_title']))) ;
    				$idproject = $project_public_title_displayRow['project_id'] ;
    				$Prostmt2 =  $project_public_title_displayRow['stmt'] ;
					if(substr($Prostmt2, 0, 4) == '<img') {
						$ProjectPicFull2 = strstr($Prostmt2, '<br/>' , true) ;
					}
					else {
						$ProjectPicFull2 = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
					}
					$ProjectPicLink =explode("\"",$ProjectPicFull2)[1] ; 				
					$ProjectPic2 = "<img src='".resize_image($ProjectPicLink, 15, 15)."' onError=this.src='img/default.gif' style='height:15px;width:15px;'>" ;

    				if (strlen($public_pr_titlep) > 15) {
    					   $prtitlep = substr(ucfirst($public_pr_titlep),0,15)." ...";
    					} 
                    else {
    					$prtitlep = ucfirst($public_pr_titlep) ;
    				}								   
    				$p_etap = $project_public_title_displayRow['project_ETA'] ;
    				$p_timep = $project_public_title_displayRow['creation_time'] ;
    				$timefuncp = date("j F, g:i a",strtotime($p_timep));
    				$titlep =  strtoupper($public_pr_titlep)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefuncp ;
    				// $remaining_time_ownp = remaining_time($p_timep, $p_etap);	
        		echo "<tr>
						<td style='padding-left: 5px;'>
							<a href = 'project.php?project_id=".$idproject."'>".$ProjectPic2 ."</a>
						</td>
						<td><a href = 'project.php?project_id=".$idproject."'>". $prtitlep."</a></td>
					  </tr>";
                }
            } 
        ?>      </tbody></table>
                </div>
            </div>
            <div class='panel panel-default'>
				<div class='panel-heading' style ='padding: 0px 0px 0px 5px;'>
					<font size='2'><b>Joined Projects</b></font>
                </div>
				<div class='bs-component' style='max-height:130px;overflow-y:scroll;'>
					<table><tbody>
        <?php
            $allJoinedProjects = mysqli_query($db_handle, "SELECT DISTINCT project_id FROM teams WHERE project_id NOT IN 
																	  (SELECT project_id FROM projects WHERE user_id = '$user_id' and 
																	  (project_type = '1' or project_type = '2')) and user_id = '$user_id' ;") ;
            
            if (mysqli_num_rows($allJoinedProjects) == 0) {
                echo "<tr><td><i>No any projects to display,</i><br>
                      <a data-toggle='modal' data-target='#createProject' style='cursor:pointer;'> 
                          <font size='1'> 
                             <i class='icon-plus'>&nbsp; Create Project</i>
                          </font>
                      </a></td></tr>";
            } 
            else {
                while ($allJoinedProjectsRow = mysqli_fetch_array($allJoinedProjects)) {
					$idproject = $allJoinedProjectsRow['project_id'] ;
					$joinedPublicProjects = mysqli_query($db_handle, "SELECT * FROM projects WHERE project_id = '$idproject';") ;
					$joinedPublicProjectsRow = mysqli_fetch_array($joinedPublicProjects) ;
					$typeProject = $joinedPublicProjectsRow['project_type'] ;
					$publicID = $joinedPublicProjectsRow['project_id'] ;
    				$public_titlep = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $joinedPublicProjectsRow['project_title']))) ;
    				$Prostmt3 =  $joinedPublicProjectsRow['stmt'] ;
					if(substr($Prostmt3, 0, 4) == '<img') {
						$ProjectPicFull3 = strstr($Prostmt3, '<br/>' , true) ;
					}
					else {
						$ProjectPicFull3 = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
					}
					$ProjectPicLink3 =explode("\"",$ProjectPicFull3)[1] ; 				
					$ProjectPic3 = "<img src='".resize_image($ProjectPicLink3, 15, 15)."' onError=this.src='img/default.gif' style='height:15px;width:15px;'>" ;

    				if (strlen($public_titlep) > 15) {
    					   $publicTitle = substr(ucfirst($public_titlep),0,15)." ...";
    					} 
                    else {
    					$publicTitle = ucfirst($public_titlep) ;
    				}								   
    				$publicEta = $joinedPublicProjectsRow['project_ETA'] ;
    				$publicTime = $joinedPublicProjectsRow['creation_time'] ;
    				$publicTimeFunction = date("j F, g:i a",strtotime($publicTime));
    				$publicTitleTooltip =  strtoupper($publicTitle)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$publicTimeFunction ;
    				// $remaining_time_ownp = remaining_time($p_timep, $p_etap);
    				if($typeProject == 1){	
						echo "<tr>
								<td style='padding-left: 5px;'>
									<a href = 'project.php?project_id=".$publicID."'>".$ProjectPic3 ."</a>
								</td>
								<td><a href = 'project.php?project_id=".$publicID."'>". $publicTitle."</a></td>
							  </tr>";
                     }
                }
            } 
        ?>       </tbody></table>
                </div>
            </div>
        <?php
    }
            // recommended project function defined in functions/delete_comment for use in profile page joined project tab
                recommended_project ($db_handle);
            // function call here ends
        ?>
        </div>	
    </div>
