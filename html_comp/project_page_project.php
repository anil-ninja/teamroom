 <div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Project : <?php echo $title ; ?></h3>
	</div>
</div>
				
 <?php
	   $title = $_SESSION['project_title'] ;
	   $project_id = mysqli_query($db_handle, "(SELECT user_id, project_id, project_ETA, project_creation, stmt FROM projects WHERE project_title = '$title' and project_blob_id = '0')
                                                            UNION
                                                    (SELECT a.user_id, a.project_id, a.project_ETA, a.project_creation, b.stmt FROM projects as a
                                                    join projects_blob as b WHERE a.project_title = '$title' and a.project_blob_id = b.project_blob_id);");
	   $project_idrow = mysqli_fetch_array($project_id) ;
		$p_id = $project_idrow['project_id'] ;
		$projectst = $project_idrow['stmt'];
		$project_own_id = $project_idrow['user_id'];
		$projecteta = $project_idrow['project_ETA'];
		$day = floor(($projecteta*60)/(24*60*60)) ;
		$daysec = ($projecteta*60)%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
		$projectETA = $day." Days :".$hour." Hours :".$minute." Min" ;
					
	echo "<div class='panel-body'>
			<div class='list-group'>
				<div class='list-group-item'>";
    // dropdown functionalities for challenge of project added with function
        dropDown_project($p_id);					   
		 $project_own_user = mysqli_query ($db_handle, ("SELECT * FROM user_info WHERE user_id = ".$project_own_id.";"));      
	while ($project_own_userRow = mysqli_fetch_array($project_own_user)) {
			echo "<font color = '#F1AE1E'> Created by &nbsp <span class='color strong' style= 'color :#CAF11E;'>" 
					.ucfirst($project_own_userRow['first_name']). '&nbsp'.ucfirst($project_own_userRow['last_name'])
					. " </span> &nbsp on &nbsp".$starttime. " &nbsp with ETA in &nbsp".$projectETA. "&nbsp 
					Days</font> <br> <br>";
                        echo "<tr id='".$p_id."' class='edit_tr'>
					<td class='edit_td'>
						<span id='project_".$p_id."' class='text' ><small>".str_replace("<s>","&nbsp;",$projectst)."</small></span>
						<input type='text' value='".$projectst."' class='editbox' id= 'project_input_".$p_id."' />
					</td>
				</tr><br> <br>";
}
		$displayb = mysqli_query($db_handle, "SELECT DISTINCT a.stmt, a.response_pr_id, a.response_pr_creation, b.first_name,b.contact_no,b.email 
									from response_project as a join user_info as b where a.project_id = '$p_id' and a.user_id = b.user_id  ;");	
	while ( $displayrowc = mysqli_fetch_array($displayb)) {
			$frstnam = $displayrowc['first_name'] ;
			$phonenum = $displayrowc['contact_no'] ;
			$emailid = $displayrowc['email'] ;
			$ida = $displayrowc['response_pr_id'] ;
			$projectres = $displayrowc['stmt'] ;
			$projectrestime = $displayrowc['response_pr_creation'] ;
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>".ucfirst($frstnam)."&nbsp</span> 
							<table>
								<tr id_res='".$ida."' class='edit_tr'>
									<td class='edit_td'>
										<span id='projectres_".$ida."' class='text' ><small>".$projectres."</small></span>
										<input type='text' value='".$projectres."' class='editbox' id= 'projectres_input_".$ida."' />
									</td>
								</tr>
							</table>
					</div>
				</div> 
			</div>";
	}
	echo "<div class='comments clearfix'>
			<div class='pull-left lh-fix'>
			<img src='img/default.gif'>&nbsp
			</div>
			
				<form method='POST' class='inline-form'>
					<input type='text' STYLE='border: 1px solid #bdc7d8; width: 300px; height: 30px;' name='pr_resp' placeholder='Whats on your mind about this project' />
					<button type='submit' class='btn-success btn-sm glyphicon glyphicon-play' name='resp_project' ></button>
			  </form>
			
		</div></div></div> </div>"								  
	
?><br/><br/>

 <div class="panel panel-info">
     <div class="panel-heading">    
        <h3 class="panel-title">Important Notes about Project</h3>
      </div>
 </div>          
<?php
		 $display = mysqli_query($db_handle, "select DISTINCT a.challenge_title,a.challenge_id, a.user_id, a.stmt, b.first_name, b.last_name from challenges as a 
												join user_info as b where a.project_id = '$p_id' and a.challenge_type = '6'	and a.user_id = b.user_id 
												ORDER BY challenge_creation DESC;");
          while ($displayrow = mysqli_fetch_array($display)) {
			  $notes = str_replace("<s>","&nbsp;",$displayrow['stmt']) ;
			  $title = $displayrow['challenge_title'] ;
			  $fname = $displayrow['first_name'] ;
			  $lname = $displayrow['last_name'] ;
			  echo "<div class='panel-body'>
						<div class='list-group'>
							<div class='list-group-item'>
							<p align='center' style='font-size: 14pt;'>".$title."</p>
							<span class='pull-left color strong' style= 'color :#CAF11E;'>".ucfirst($fname)." ".ucfirst($lname)."&nbsp&nbsp&nbsp</span> 
							<small>".$notes."</small><br/><br/>";
			$displaya = mysqli_query($db_handle, "select DISTINCT a.challenge_id, b.user_id, b.stmt, b.response_ch_id, b.response_ch_creation, c.first_name,
										c.last_name FROM challenges as a join response_challenge as b join user_info as c where a.project_id = '$p_id' and
										 a.challenge_id = b.challenge_id and b.challenge_id = ".$displayrow['challenge_id']." and b.user_id = c.user_id ;");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
				$lstname = $displayrowb['last_name'] ;
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
				
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp". ucfirst($fstname)." ".ucfirst($lstname)."&nbsp</span> 
						<table>
							<tr id_res='".$idc."' class='edit_tr'>
								<td class='edit_td'>
									<span id='challengeres_".$idc."' class='text' ><small>".$chalangeres."</small></span>
									<input type='text' value='".$chalangeres."' class='editbox' id= 'challengeres_input_".$idc."' />
								</td>
							</tr>
						</table>
					</div>
				</div> 
			</div>";
		}
		echo "<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='img/default.gif'>&nbsp
				</div>
				<form class='inline-form' action='' method='POST'>
                                    <input type='hidden' value='".$displayrow['challenge_id']."' name='challenge_of_project_id' />
                                    <input type='text' STYLE=' border: 1px solid #bdc7d8; width: 300px; height: 30px' id='challenge_of_pr_resp' placeholder='Whats on your mind about this challenge'/>
                                    <button type='submit' class='btn-success btn-sm glyphicon glyphicon-play' id='challenge_of_project_response'> </button>
				</form>
			</div></div></div></div>" ;
	}
?>
