<br/>
<?php 
	$usertype = mysqli_query($db_handle, "select * from user_info where user_id = '$user_id' ;") ;
	$usertypeRow = mysqli_fetch_array($usertype) ;
	$TypeUser = $usertypeRow['user_type'] ;
    if (isset($_SESSION['user_id'])) {
        echo "<a id='step6' class='btn btn-primary' data-toggle='modal' data-target='#createProject' style='cursor:pointer;'>  
                <i class='icon-plus'></i>Create Projects
			 </a>";
    }
    else {
        echo "<a id='step6' class='btn btn-primary' data-toggle='modal' data-target='#SignIn' style='cursor:pointer;> 
                <i class='icon-plus'></i>Create Projects
			  </a>";
    }
?>
<br/><br/>
    <nav class="sidebar light" id='user1project'>
    <ul>
		<div class='bs-component' style='max-height:150px;'>       
<?php 
    if (isset($_SESSION['user_id'])) {              
 		echo "<li class='title'>Classified Projects</li>";   
        $project_title_display = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.creation_time, b.stmt 
                                                            FROM teams as a join projects as b WHERE a.user_id = '$user_id' 
                                                            AND a.project_id = b.project_id AND b.project_type = '2')  
                                                            UNION 
                                                            (SELECT DISTINCT project_id, project_title, project_ETA, creation_time, stmt 
                                                            FROM projects WHERE user_id = '$user_id' AND project_type= '2');");
        
        if (mysqli_num_rows($project_title_display) == 0) {
			echo " <li class='stick'>No any projects to display,<br>
					<a class='active' data-toggle='modal' data-target='#createProject' style='cursor:pointer;'>
							<i class='icon-plus'>&nbsp; Create Project</i>
					</a></li>";
        } 
        else {
            while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
                $p_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_title_displayRow['project_title'])))) ;
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
				$ProjectPic = "<img src='".resize_image($ProjectPicLink2, 15, 15, 1)."' onError=this.src='img/default.gif' style='height:15px;width:15px;'>" ;
				
                if (strlen($p_title) > 35) {
                    $prtitle = substr(ucfirst($p_title),0,35)."...";
                } 
                else {
                    $prtitle = ucfirst($p_title) ;
                }								   
                $p_eta = $project_title_displayRow['project_ETA'] ;
                $p_time = $project_title_displayRow['creation_time'] ;
                $timefunc = date("j F, g:i a",strtotime($p_time));
                $title =  strtoupper($p_title)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefunc ;
                // $remaining_time_own = remaining_time($p_time, $p_eta);
                echo "<li class='stick'>
							<a href = 'project.php?project_id=".$idpro."' style='white-space:nowrap;'>".$ProjectPic ." ". $prtitle."</a>
					  </li>";
            }
        }  
    ?> 
    </div>
    </ul>
    </nav>
    <nav class="sidebar light" id='user2project'>
    <ul>
		<div class='bs-component' style='max-height:150px;'>       
<?php             
 		echo "<li class='title'>Private Projects</li>";
		$private_project_display = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.creation_time, b.stmt 
															FROM teams as a join projects as b WHERE a.user_id = '$user_id' 
															AND a.project_id = b.project_id AND b.project_type = '4')  
															UNION 
															(SELECT DISTINCT project_id, project_title, project_ETA, creation_time, stmt 
															FROM projects WHERE user_id = '$user_id' AND project_type= '4');");
        if (mysqli_num_rows($private_project_display) == 0) {
			echo " <li class='stick'>No any projects to display,<br>
					<a class='active' data-toggle='modal' data-target='#createProject' style='cursor:pointer;'>
							<i class='icon-plus'>&nbsp; Create Project</i>
					</a></li>";
        } 
        else {
            while ($private_project_displayRow = mysqli_fetch_array($private_project_display)) {
                $pp_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $private_project_displayRow['project_title'])))) ;
                $pidpro = $private_project_displayRow['project_id'] ;
                $ProstmtPr =  $private_project_displayRow['stmt'] ;
                //echo $Prostmt;
                if(substr($ProstmtPr, 0, 4) == '<img') {
					$PProjectPicFull = strstr($ProstmtPr, '<br/>' , true) ;
				}
				else {
					$PProjectPicFull = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
				}
				$PProjectPicLink =explode("\"",$PProjectPicFull)[1] ; 			
				$ProjectPicP = "<img src='".resize_image($PProjectPicLink, 15, 15, 1)."' onError=this.src='img/default.gif' style='height:15px;width:15px;'>" ;
				
                if (strlen($pp_title) > 35) {
                    $pprtitle = substr(ucfirst($pp_title),0,35)."...";
                } 
                else {
                    $pprtitle = ucfirst($pp_title) ;
                }								   
                $pp_eta = $private_project_displayRow['project_ETA'] ;
                $pp_time = $private_project_displayRow['creation_time'] ;
                $ptimefunc = date("j F, g:i a",strtotime($pp_time));
                $ptitle =  strtoupper($pp_title)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$ptimefunc ;
                // $remaining_time_own = remaining_time($p_time, $p_eta);
                echo "<li class='stick'>
							<a href = 'project.php?project_id=".$pidpro."' style='white-space:nowrap;'>".$ProjectPicP ." ". $pprtitle."</a>
					  </li>";
            }
        }  
    ?> 
    </div>
    </ul>
    </nav>
    <nav class="sidebar light" id='user3project'>
    <ul>
		<div class='bs-component' style='max-height:150px;'> 
		<li class='title'>Public Projects</li>
        <?php
            $project_public_title_display = mysqli_query($db_handle, "SELECT * FROM projects WHERE user_id = '$user_id' and project_type = '1' ;") ;
            
            if (mysqli_num_rows($project_public_title_display) == 0) {
                echo "<li class='stick'>No any projects to display,<br>
					<a data-toggle='modal' data-target='#createProject' style='cursor:pointer;'>
							<i class='icon-plus'>&nbsp; Create Project</i>
					</a></li>";
            } 
            else {
                while ($project_public_title_displayRow = mysqli_fetch_array($project_public_title_display)) {
    				$public_pr_titlep = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $project_public_title_displayRow['project_title'])))) ;
    				$idproject = $project_public_title_displayRow['project_id'] ;
    				$Prostmt2 =  $project_public_title_displayRow['stmt'] ;
					if(substr($Prostmt2, 0, 4) == '<img') {
						$ProjectPicFull2 = strstr($Prostmt2, '<br/>' , true) ;
					}
					else {
						$ProjectPicFull2 = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
					}
					$ProjectPicLink =explode("\"",$ProjectPicFull2)[1] ; 				
					$ProjectPic2 = "<img src='".resize_image($ProjectPicLink, 15, 15, 1)."' onError=this.src='img/default.gif' style='height:15px;width:15px;'>" ;

    				if (strlen($public_pr_titlep) > 35) {
    					   $prtitlep = substr(ucfirst($public_pr_titlep),0,35)."...";
    					} 
                    else {
    					$prtitlep = ucfirst($public_pr_titlep) ;
    				}								   
    				$p_etap = $project_public_title_displayRow['project_ETA'] ;
    				$p_timep = $project_public_title_displayRow['creation_time'] ;
    				$timefuncp = date("j F, g:i a",strtotime($p_timep));
    				$titlep =  strtoupper($public_pr_titlep)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefuncp ;
    				// $remaining_time_ownp = remaining_time($p_timep, $p_etap);	
        		echo "<li class='stick'>
							<a href = 'project.php?project_id=".$idproject."' style='white-space:nowrap;'>".$ProjectPic2 ." ". $prtitlep."</a>
					  </li>";
                }
            }
        ?> 
        </div>
        </ul>
    </nav>
    <nav class="sidebar light" id='user4project'>
    <ul>
		<div class='bs-component' style='max-height:150px;'>  
        <li class='title'>Joined Projects</li>
        <?php
            $allJoinedProjects = mysqli_query($db_handle, "SELECT DISTINCT project_id FROM teams WHERE project_id NOT IN 
																	  (SELECT project_id FROM projects WHERE user_id = '$user_id' and 
																	  (project_type = '1' or project_type = '2')) and user_id = '$user_id' ;") ;
            
            if (mysqli_num_rows($allJoinedProjects) == 0) {
                echo "<li class='stick'> No any projects to display</li>";
            } 
            else {
                while ($allJoinedProjectsRow = mysqli_fetch_array($allJoinedProjects)) {
					$idproject = $allJoinedProjectsRow['project_id'] ;
					$joinedPublicProjects = mysqli_query($db_handle, "SELECT * FROM projects WHERE project_id = '$idproject';") ;
					$joinedPublicProjectsRow = mysqli_fetch_array($joinedPublicProjects) ;
					$typeProject = $joinedPublicProjectsRow['project_type'] ;
					$publicID = $joinedPublicProjectsRow['project_id'] ;
    				$public_titlep = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $joinedPublicProjectsRow['project_title'])))) ;
    				$Prostmt3 =  $joinedPublicProjectsRow['stmt'] ;
					if(substr($Prostmt3, 0, 4) == '<img') {
						$ProjectPicFull3 = strstr($Prostmt3, '<br/>' , true) ;
					}
					else {
						$ProjectPicFull3 = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
					}
					$ProjectPicLink3 =explode("\"",$ProjectPicFull3)[1] ; 				
					$ProjectPic3 = "<img src='".resize_image($ProjectPicLink3, 15, 15, 1)."' onError=this.src='img/default.gif' style='height:15px;width:15px;'>" ;

    				if (strlen($public_titlep) > 35) {
    					   $publicTitle = substr(ucfirst($public_titlep),0,35)."...";
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
						echo "<li class='stick'>
								<a href = 'project.php?project_id=".$publicID."' style='white-space:nowrap;'>".$ProjectPic3 ." ". $publicTitle."</a>
							  </li>";
                     }
                }
            }
		} 
            ?>
		</div>
		</ul>
		</nav>
		<?php
    if($TypeUser == "invester" || $TypeUser == "collaboraterInvester" || $TypeUser == "fundsearcherInvester" || $TypeUser == "collaboraterinvesterfundsearcher"){
        
			$invester_recommended = mysqli_query($db_handle, "SELECT  a.project_id, b.project_title, b.project_ETA, b.creation_time, b.stmt FROM 
															  project_funding_info as a join projects as b where a.project_id NOT IN 
															  (SELECT project_id FROM investment_info WHERE user_id = '$user_id') 
															  and a.project_id = b.project_id AND (b.project_type = '1' OR b.project_type = '4')  ;");
			
			if(mysqli_num_rows($invester_recommended) != 0){
				echo "<nav class='sidebar light' id='user5project'>
						<ul>
						<div class='bs-component' style='max-height:150px;'>
							<li class='title'>Fund Needed Projects</li>" ;
				while($invester_recommendedRow = mysqli_fetch_array($invester_recommended)) {
					$invester_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $invester_recommendedRow['project_title'])))) ;
    				$idprojectIN = $invester_recommendedRow['project_id'] ;
    				$ProstmtIN =  $invester_recommendedRow['stmt'] ;
					if(substr($ProstmtIN, 0, 4) == '<img') {
						$ProjectPicIN = strstr($ProstmtIN, '<br/>' , true) ;
					}
					else {
						$ProjectPicIN = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
					}
					$ProjectPicLinkIN =explode("\"",$ProjectPicIN)[1] ; 				
					$ProjectPicInvester = "<img src='".resize_image($ProjectPicLinkIN, 15, 15, 1)."' onError=this.src='img/default.gif' style='height:15px;width:15px;'>" ;

    				if (strlen($invester_title) > 35) {
    					   $prtitleIN = substr(ucfirst($invester_title),0,35)."...";
    					} 
                    else {
    					$prtitleIN = ucfirst($invester_title) ;
    				}								   
    				$p_etapIN = $invester_recommendedRow['project_ETA'] ;
    				$p_timepIN = $invester_recommendedRow['creation_time'] ;
    				$timefuncIN = date("j F, g:i a",strtotime($p_timepIN));
    				$titlep =  strtoupper($invester_title)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefuncIN ;
    				// $remaining_time_ownp = remaining_time($p_timep, $p_etap);	
					echo "<li class='stick'>
								<a href = 'project.php?project_id=".$idprojectIN."' style='white-space:nowrap;'>".$ProjectPicInvester ." ". $prtitleIN."</a>
						  </li>";
				}
				echo "</div></ul></nav>";
			}
	}
    echo "<nav id='user6project' class='sidebar light'>
    <ul>" ;
    if(isset($_SESSION['user_id'])) {
		echo "<div class='bs-component' style='max-height:200px;'> " ;
	}
	else { echo "<div class='bs-component' style='max-height:350px;'> " ; }
            // recommended project function defined in functions/delete_comment for use in profile page joined project tab
                recommended_project ($db_handle);
            // function call here ends
      echo "</div></ul></nav>" ;
        ?>
