<div class="bs-component">
  <a data-toggle='modal' class='btn btn-link' data-target='#createProject' style='cursor:pointer;'><i class='glyphicon glyphicon-plus'></i>
	  <font size="2"><b>Private Projects</b></font></a><hr>
	   <?php
			$project_title_display = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.project_creation FROM teams as a join projects 
																as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '2')  
																UNION (SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE user_id = '$user_id' and project_type= '2');");
				while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
				$p_title = $project_title_displayRow['project_title'] ;
				if (strlen($p_title) > 40) {
				$prtitle = substr(ucfirst($p_title),0,40)."...";
				} else {
					$prtitle = ucfirst($p_title) ;
				}								   
				$p_eta = $project_title_displayRow['project_ETA'] ;
				$p_time = $project_title_displayRow['project_creation'] ;
				$timefunc = date("j F, g:i a",strtotime($p_time));
				$title =  strtoupper($p_title)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefunc ;
				$remaining_time_own = remaining_time($p_time, $p_eta);
		echo "<form method='POST' action=''>
				<input type='hidden' name='project_id' value='".$project_title_displayRow['project_id']."'/>
				<button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
				data-placement='bottom' data-original-title=' ".$title."' style='height: 15px;font-size:11px;'>
				<b>".$prtitle."</b></button>
				<p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>&nbsp;&nbsp;&nbsp;".$remaining_time_own."</p><br/></form>" ;
			
				
			}
		?><hr/>
	   <a data-toggle='modal' class='btn btn-link' data-target='#createProject' style='cursor:pointer;'><i class='glyphicon glyphicon-plus'></i>
	  <font size="2"><b>Public Projects</b></font></a><hr>
	   <?php 
			$project_public_title_display = mysqli_query($db_handle, "SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE project_type= '1';");
		
		while ($project_public_title_displayRow = mysqli_fetch_array($project_public_title_display)) {
				$public_pr_titlep = $project_public_title_displayRow['project_title'] ;
			if (strlen($public_pr_titlep) > 25) {
				$prtitlep = substr(ucfirst($public_pr_titlep),0,26)."....";
				} else {
					$prtitlep = ucfirst($public_pr_titlep) ;
				}								   
				$p_etap = $project_public_title_displayRow['project_ETA'] ;
				$p_timep = $project_public_title_displayRow['project_creation'] ;
				$timefuncp = date("j F, g:i a",strtotime($p_time));
				$titlep =  strtoupper($public_pr_titlep)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefuncp ;
				$remaining_time_ownp = remaining_time($p_timep, $p_etap);	
	echo "<form method='POST' action=''>
			<input type='hidden' name='project_id' value='".$project_public_title_displayRow['project_id']."'/>
			<button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
			data-placement='bottom' data-original-title='".$titlep."' style='height: 20px;font-size:14px;'><b>
			".$prtitlep."</b></button>
			<br/><p style='font-size:8pt; color:rgba(161, 148, 148, 1);'>&nbsp;&nbsp;&nbsp;".$remaining_time_ownp."</p></form>" ;
					
				
			} 
		?><hr/>
</div>
