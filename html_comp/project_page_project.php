 <div class="panel panel">
	<div class="panel-heading">
		<h3 class="panel-title"><font color="silver">Project : <?php echo $title ; ?></font></h3>
	</div>
</div>
				
 <?php
	   $title = $_SESSION['project_title'] ;
	   $project_id = mysqli_query($db_handle, "(SELECT a.user_id, a.project_id, a.project_ETA, a.project_creation, a.stmt, b.first_name, b.last_name FROM
												projects as a join user_info as b WHERE a.project_id = '$pro_id' and blob_id = '0' and a.user_id = b.user_id AND a.project_type = '1')
                                                UNION
                                                (SELECT a.user_id, a.project_id, a.project_ETA, a.project_creation, b.stmt, c.first_name, c.last_name FROM projects as a
                                                join blobs as b join user_info as c WHERE a.project_id = '$pro_id' AND a.project_type = '1' and a.blob_id = b.blob_id and a.user_id = c.user_id);");
	   $project_idrow = mysqli_fetch_array($project_id) ;
		$p_id = $project_idrow['project_id'] ;
		$projectst = $project_idrow['stmt'];
		$fname = $project_idrow['first_name'];
		$lname = $project_idrow['last_name'];
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

      echo "<div class='pull-right'>
            <div class='list-group-item'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdown'>";
                    $project_dropdown_display = mysqli_query($db_handle, ("SELECT user_id FROM projects WHERE project_id = '$p_id' AND user_id='$user_id';"));
                    $project_dropdown_displayRow = mysqli_fetch_array($project_dropdown_display);
                    $project_dropdown_userID = $project_dropdown_displayRow['user_id'];
                    if($project_dropdown_userID == $user_id) {
                        echo "
                        <li><button class='btn-link' href='#'>Edit Project</button></li>
                        <li><button class='btn-link' pID='".$p_id."' onclick='delProject(".$p_id.");'>Delete Project</button></li>
                        <li><form method='POST' class='inline-form'>";                    
                        if($projectETA == 'Time over') {        
                            echo "<input type='hidden' name='id' value='".$p_id."'/>
                                <input class='btn-link' type='submit' name='eta_project_change' value='Change ETA'/>";
                            }                                    
                       echo "</form></li>";
                    }
                    else {
                       echo "<li><button class='btn-link' >Report Spam</button></li>";
                    } 
               echo "</ul>
              </div>
            </div>";
	echo "Created by &nbsp <span class='color strong' style= 'color :lightblue;'>".ucfirst($fname). '&nbsp'.ucfirst($lname)."
			</span> &nbsp on &nbsp".$starttime. " &nbsp with ETA in &nbsp".$projectETA. " <br> <br>".str_replace("<s>","&nbsp;",$projectst)."<br/><br/>" ;
					
	$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.first_name, b.last_name from response_project as a join user_info as b 
											where a.project_id = '$p_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '1')
											UNION
											(SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.first_name, b.last_name from response_project as a join user_info as b join blobs as c 
											where a.project_id = '$p_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_pr_creation ASC;");	
	while ( $displayrowc = mysqli_fetch_array($displayb)) {
			$frstnam = $displayrowc['first_name'] ;
			$lnam = $displayrowc['last_name'] ;
			//$emailid = $displayrowc['email'] ;
			$ida = $displayrowc['response_pr_id'] ;
			$projectres = $displayrowc['stmt'] ;
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>".ucfirst($frstnam)." ".ucfirst($lnam)."&nbsp</span> 
						<small>".$projectres."</small>";
				dropDown_delete_comment_project($db_handle, $ida, $user_id);
       
				echo "</div>
				</div> 
			</div>";
	}
	echo "<div class='comments clearfix'>
			<div class='pull-left lh-fix'>
			<img src='img/default.gif'>&nbsp
			</div>
			
				<form method='POST' class='inline-form'>
					<input type='text' STYLE='border: 1px solid #bdc7d8; width: 300px; height: 30px;' name='pr_resp' placeholder='Whats on your mind about this project' />
					<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='resp_project' ></button>
			  </form>
			
		</div></div></div> </div>"								  
	
?><br/><br/>

 <div class="panel panel">
     <div class="panel-heading">    
        <h3 class="panel-title">Important Notes about Project</h3>
      </div>
 </div>          
<?php
		 $display = mysqli_query($db_handle, "(select DISTINCT a.challenge_title,a.challenge_id, a.challenge_creation, a.user_id, a.stmt, b.first_name, b.last_name from challenges as a 
												join user_info as b where a.project_id = '$p_id' and a.challenge_type = '6' and a.blob_id = '0' and a.user_id = b.user_id 
												)
												UNION
												(select DISTINCT a.challenge_title,a.challenge_id,a.challenge_creation, a.user_id, c.stmt, b.first_name, b.last_name from challenges as a 
												join user_info as b join blobs as c where a.project_id = '$p_id' and a.challenge_type = '6' and a.blob_id = c.blob_id and a.user_id = b.user_id 
												) ORDER BY challenge_creation DESC;");
          while ($displayrow = mysqli_fetch_array($display)) {
			  $notes = str_replace("<s>","&nbsp;",$displayrow['stmt']) ;
			  $title = $displayrow['challenge_title'] ;
			  $fname = $displayrow['first_name'] ;
			  $lname = $displayrow['last_name'] ;
              $note_ID = $displayrow['challenge_id'];
			  echo "<div class='panel-body'>
						<div class='list-group'>
							<div class='list-group-item'>
							   <div class='pull-right'>
								<div class='list-group-item'>
									<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
									<ul class='dropdown-menu' aria-labelledby='dropdown'>
									 <li><a class='btn btn-default' href='#'>Edit Note</a></li>
									 <li><a class='btn btn-default' noteID='".$note_ID."' onclick='delNote(".$note_ID.");'>Delete Note</a></li>                  
									 <li><a class='btn btn-default' >Report Spam</a></li>
								   </ul>
							  </div>
							</div>
							<p align='center' style='font-size: 14pt;'>".$title."</p>
							<span class='pull-left color strong' style= 'color :lightblue;'>".ucfirst($fname)." ".ucfirst($lname)."&nbsp&nbsp&nbsp</span> 
							<small>".$notes."</small><br/><br/>";
			$displaya = mysqli_query($db_handle, "(select DISTINCT a.user_id, a.stmt, a.response_ch_id, a.response_ch_creation, b.first_name, b.last_name 
													FROM response_challenge as a join user_info as b where a.challenge_id = ".$displayrow['challenge_id']." 
													and a.user_id = b.user_id and a.blob_id = '0')
													UNION
													(select DISTINCT a.user_id, c.stmt, a.response_ch_id, a.response_ch_creation, b.first_name, b.last_name
													 FROM response_challenge as a join user_info as b join blobs as c where a.challenge_id = ".$displayrow['challenge_id']."
													  and a.user_id = b.user_id and a.blob_id = c.blob_id);");		
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
						".$chalangeres."";
                 dropDown_delete_comment_challenge($db_handle, $idc, $user_id);
						
				echo "</div>
				</div> 
			</div>";
		}
		echo "<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='img/default.gif'>&nbsp
				</div>
				<form class='inline-form' action='' method='POST'>
                                    <input type='hidden' value='".$note_ID."' id='challenge_id' />
                                    <input type='text' STYLE=' border: 1px solid #bdc7d8; width: 300px; height: 30px' id='pr_resp' placeholder='Whats on your mind about this challenge'/>
                                    <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' id='response'> </button>
				</form>
			</div></div></div></div>" ;
	}
?>
