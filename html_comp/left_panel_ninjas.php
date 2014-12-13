<div class="bs-component list-group">
	<div class='list-group-item'style="padding-left: 3px; padding-right: 3px;">
        <div class='panel-heading' style ='padding-top: 4px; padding-bottom: 4px;'><font size="3"> PROJECTS&nbsp;&nbsp;&nbsp;</font>
	        <?php 
		        if (isset($_SESSION['user_id'])) {
		        	echo "<a class='pull-right' data-toggle='modal' data-target='#createProject' style='cursor:pointer; pull-right'> <font size='1'>+Add</font></a>";
				}
				else {
					echo "<a class='pull-right' data-toggle='modal' data-target='#SignIn' style='cursor:pointer; pull-right'> <font size='1'>+Add</font></a>";
				}
			?>
		</div>
		
        <?php 
            if (isset($_SESSION['user_id'])) {              
 		echo "<div class='panel-group' style='margin-bottom: 5px;'>
 				<div class='panel panel-default'>
 					<div class='panel-heading' style ='padding-top: 4px; padding-bottom: 4px;'>
 						<font size='2'> Classified</font></div>
 						<div class='panel-content'>
			    	<table>
                    <tr><td>";   
                            $project_title_display = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.creation_time FROM teams as a join projects 
                                                                                as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '2')  
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, creation_time FROM projects WHERE user_id = '$user_id' and project_type= '2');");
                            while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
                                    $p_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_title_displayRow['project_title']))) ;
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
                                            <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                                            data-placement='bottom' data-original-title=' ".$title."' style='height: 20px;font-size:11px;text-align: left;'>
                                            </b>".$prtitle."</b>
                                            <p style='font-size:6pt; color:rgba(161, 148, 148, 1);text-align: left;'>" ;
                            //echo $remaining_time_own ;
                            echo "</p></button></form>" ;
                            }  
                            echo "</td></tr></table>
                                </div>";
            echo "</div></div>";
                    }
                    ?>
				<div class='panel-group' style='margin-bottom: 5px;'>
 				<div class='panel panel-default'>
 					<div class='panel-heading'style ='padding-top: 4px; padding-bottom: 4px;'>
 						<font size='2'>Public</font></div>
 						<div class='panel-content'>
                    <?php 
                    echo "<table>
								<tr><td>";
                        $project_public_title_display = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.creation_time FROM teams as a join projects 
                                                                                as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '1')  
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, creation_time FROM projects WHERE user_id = '$user_id' and project_type= '1');");

                        while ($project_public_title_displayRow = mysqli_fetch_array($project_public_title_display)) {
								$public_pr_titlep = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_public_title_displayRow['project_title']))) ;
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
					echo "<form method='GET' action=''>
								<input type='hidden' name='project_id' value='".$idproject."'/>
								<button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
								data-placement='bottom' data-original-title='".$titlep."' style='height: 20px;font-size:11px;text-align: left;'>
								".$prtitlep."
								<p style='font-size:6pt; color:rgba(161, 148, 148, 1);text-align: left;'>" ;
								//$remaining_time_ownp.
					echo "</p></button></form>" ;
			
					} 
					echo "</td></tr></table>
                                </div></div></div>";
                        $project_public_title_display2 = mysqli_query($db_handle, "SELECT DISTINCT project_id, project_title, project_ETA, creation_time
																				FROM projects WHERE user_id != '$user_id' and project_type= '1' and project_id NOT
																				IN (SELECT DISTINCT project_id FROM teams WHERE user_id = '$user_id')
																				ORDER BY rand() LIMIT 5;");
						if (mysqli_num_rows($project_public_title_display2) != 0) {	
							echo "<div class='panel-group'style='margin-bottom: 5px;'>
 				<div class='panel panel-default'>
 					<div class='panel-heading' style ='padding-top: 4px; padding-bottom: 4px;'>
 						<font size='2'> Recommended</font></div>
 						<div class='panel-content'>
							<table>";
                        while ($project_public_title_displayRow2 = mysqli_fetch_array($project_public_title_display2)) {
								$public_pr_titlep2 = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_public_title_displayRow2['project_title']))) ;
								$idproject2 = $project_public_title_displayRow2['project_id'] ;
							if (strlen($public_pr_titlep2) > 30) {
								$prtitlep2 = substr(ucfirst($public_pr_titlep2),0,30)." ...";
								} else {
									$prtitlep2 = ucfirst($public_pr_titlep2) ;
								}								   
								$p_etap2 = $project_public_title_displayRow2['project_ETA'] ;
								$p_timep2 = $project_public_title_displayRow2['creation_time'] ;
								$timefuncp2 = date("j F, g:i a",strtotime($p_time2));
								$titlep2 =  strtoupper($public_pr_titlep2)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefuncp2 ;
								// $remaining_time_ownp = remaining_time($p_timep, $p_etap);
					
					echo "<tr><td><form method='GET' action=''>
									<input type='hidden' name='project_id' value='".$idproject2."'/>
									<button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
									data-placement='bottom' data-original-title='".$titlep2."' style='height: 20px;font-size:11px;text-align: left;'>
									".$prtitlep2."
									<p style='font-size:6pt; color:rgba(161, 148, 148, 1);text-align: left;'></p>
								</button></form></td><td>";
									//$remaining_time_ownp.
					if (isset($_SESSION['user_id'])) {
						echo "<button type='submit' class='btn-link' onclick='joinproject(".$idproject2.")' data-toggle='tooltip' 
                                data-placement='bottom' data-original-title='Join This Project' style='height: 20px;font-size:11px;text-align: left;'
                                >Join</button>";
					}
					else {
						echo "<a class='pull-right' data-toggle='modal' data-target='#SignIn' style='cursor:pointer; pull-right'>Join</a>";
					}
					echo "</td></tr>" ;
					}
					echo "</table></div>
					</div>
					</div>";
				}
                    ?>
    </div>	
</div>