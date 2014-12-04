<div class="bs-component">
	<div class='list-group'  style='cursor: pointer;'>
 		<div class='list-group-item' style="background-color: rgba(240, 240, 240, 0.32);">
 		<table>
			
 		<tr><td><font size="2"> PROJECTS&nbsp;&nbsp;&nbsp;</font>
                    <?php 
                        if (isset($_SESSION['user_id'])) {
                            echo "<a class='pull-right'data-toggle='modal' data-target='#createProject' style='cursor:pointer; pull-right'> <font size='1'>+Add</font></a> </td>
                </tr>
 		<tr>
                    <td> <font size='2'> Classified</font></td>
	 	</tr>";   
                            $project_title_display = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.creation_time FROM teams as a join projects 
                                                                                                                                    as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '2')  
                                                                                                                                    UNION (SELECT DISTINCT project_id, project_title, project_ETA, creation_time FROM projects WHERE user_id = '$user_id' and project_type= '2');");
                            while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
                                    $p_title = $project_title_displayRow['project_title'] ;
                                    $idpro = $project_title_displayRow['project_id'] ;
                                    if (strlen($p_title) > 30) {
                                    $prtitle = substr(ucfirst($p_title),0,30)." ...";
                                    } else {
                                            $prtitle = ucfirst($p_title) ;
                                    }								   
                                    $p_eta = $project_title_displayRow['project_ETA'] ;
                                    $p_time = $project_title_displayRow['creation_time'] ;
                                    $timefunc = date("j F, g:i a",strtotime($p_time));
                                    $title =  strtoupper($p_title)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefunc ;
                                    // $remaining_time_own = remaining_time($p_time, $p_eta);
                            echo "<form method='GET' action=''>
                                            <input type='hidden' name='project_id' value='".$idpro."'/>
                                            <tr><td>
                                            <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                                            data-placement='bottom' data-original-title=' ".$title."' style='height: 20px;font-size:11px;text-align: left;'>
                                            </b>".$prtitle."</b>
                                            <p style='font-size:6pt; color:rgba(161, 148, 148, 1);text-align: left;'>" ;
                            //echo $remaining_time_own ;
                            echo "</p></td></tr> 
                                    </button></form>" ;


                            }
                        
                    ?>
 		<tr></tr>
                
                <tr>
	 		<td> <font size="2"> <br/>Public</font></td>
		</tr>
                <?php } ?>
		</div>
		<div>
				<table>
					   <?php 
							$project_public_title_display = mysqli_query($db_handle, "SELECT DISTINCT project_id, project_title, project_ETA, creation_time FROM projects WHERE project_type= '1';");
						
						while ($project_public_title_displayRow = mysqli_fetch_array($project_public_title_display)) {
								$public_pr_titlep = $project_public_title_displayRow['project_title'] ;
								$idproject = $project_public_title_displayRow['project_id'] ;
							if (strlen($public_pr_titlep) > 30) {
								$prtitlep = substr(ucfirst($public_pr_titlep),0,30)." ...";
								} else {
									$prtitlep = ucfirst($public_pr_titlep) ;
								}								   
								$p_etap = $project_public_title_displayRow['project_ETA'] ;
								$p_timep = $project_public_title_displayRow['creation_time'] ;
								$timefuncp = date("j F, g:i a",strtotime($p_time));
								$titlep =  strtoupper($public_pr_titlep)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefuncp ;
								// $remaining_time_ownp = remaining_time($p_timep, $p_etap);	
					echo "<tr>
                                                <td>
                                                <form method='GET' action=''>
                                                        <input type='hidden' name='project_id' value='".$idproject."'/>
                                                        <tr><td>
                                                        <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                                                        data-placement='bottom' data-original-title='".$titlep."' style='height: 20px;font-size:11px;text-align: left;'>
                                                        ".$prtitlep."
                                                        <p style='font-size:6pt; color:rgba(161, 148, 148, 1);text-align: left;'>" ;
                                                        //$remaining_time_ownp.
                                                        echo "</p></button></td></form>" ;
					$join =  mysqli_query($db_handle, "select user_id from teams where project_id = '$idproject' and user_id = '$user_id';") ;
					if (mysqli_num_rows($join) == 0 && isset($_SESSION['user_id'])) {		
					echo	"<td>
								<button type='submit' class='btn-link' onclick='joinproject(".$idproject.")' data-toggle='tooltip' 
                                data-placement='bottom' data-original-title='Join This Project' style='height: 20px;font-size:11px;text-align: left;'>Join</button>
                             </td></tr>" ;
						} else {
					echo "</tr>" ;
					}			
					} 
                                    ?>
			</table>
			</div>
	</div>
</div>
<div class='modal fade' id='answerFormpr' tabindex='-1' role='dialog' aria-labelledby='myModalLabel1' aria-hidden='true'>
	<div class='modal-dialog'> 
		<div class='modal-content'>
			<div class='modal-header'> 
				<button type="button" class="close" data-dismiss="modal">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
				<h4 class='modal-title' id='myModalLabel'>Submit Answer</h4> 
			</div> 
			<div class='modal-body'><form>  
				<div class='input-group-addon'>
					<textarea row='5' id='answerchalpr' class='form-control' placeholder='submit your answer'></textarea>
				</div>
				<br/>
				<input class='btn btn-default btn-sm' type='file' id='_fileanswerpr' style ='width: auto;'>
				<br/>
				<input type='hidden' id='answercidpr' value=''>
				<input type='hidden' id='prcid' value=''>
				<button type='submit' class='btn btn-success btn-sm' id='answerchpr' >Submit</button> 
			</form></div> 
			<div class='modal-footer'>
				<button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div> 
	</div>
 </div>
