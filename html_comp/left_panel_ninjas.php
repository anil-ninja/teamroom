<br/>
<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
<ul class="nav nav-tabs">
            <li class="active" >
               
                    
                        <?php 
                if (isset($_SESSION['user_id'])) {
                    echo "<a class='pull-right active' data-toggle='modal' data-target='#createProject' style='cursor:pointer; padding-top: 4px; padding-bottom: 4px;'> 
                           
                            <span><b>PROJECTS</b></span><font size='1'> +Add</font></a>";
                }
                else {
                    echo "<a class='pull-right active' data-toggle='modal' data-target='#SignIn' style='cursor:pointer; padding-top: 4px; padding-bottom: 4px;'> 
                            <span><b>PROJECTS</b></span> <font size='1'> +Add</font></a>";
                }
            ?>
                    
                

            </li>
</ul>

	
    <div class='list-group-item' style="padding-left: 0px; padding-right: 0px;">
        
		
        <?php 
            if (isset($_SESSION['user_id'])) {              
 		echo "<div class='nav nav-tabs'>
 				<div class='panel panel-default'>
 					<div class='panel-heading' style ='padding-top: 0px; padding-bottom: 0px;'>
 						<font size='2'>Classified</font>
                    </div>
 					<div class='bs-component'>
			    	    <table>
                            ";   
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
                            echo "<tr><td>
                                        <a href = 'project.php?project_id=".$idpro."'>
                                            <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                                            data-placement='bottom' data-original-title=' ".$title."' style='color:#000;font-size:11px;text-align: left;'>
                                            </b>".$prtitle."</b>
                                            " ;
                            
                            echo "</button></td></tr>" ;
                            }  
                            echo "</table>
                                </div>";
            echo "</div>";
                    }
                    ?>
				
 				<div class='panel panel-default'>
 					<div class='panel-heading'style ='padding-top: 0px; padding-bottom: 0px;'>
 						<font size='2'>Public</font></div>
 						<div class='bs-component'>
                    <?php 
                    echo "<table>
								";
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
								$timefuncp = date("j F, g:i a",strtotime($p_timep));
								$titlep =  strtoupper($public_pr_titlep)."&nbsp;&nbsp;&nbsp;&nbsp;  Project Created ON : ".$timefuncp ;
								// $remaining_time_ownp = remaining_time($p_timep, $p_etap);	
					echo "<tr><td>
                            <a href = 'project.php?project_id=".$idproject."' >
								<button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
								data-placement='bottom' data-original-title='".$titlep."' style='color:#000;font-size:11px;text-align: left;'>
								".$prtitlep."
								" ;
								
					echo "</button></a></td></tr>" ;
			
					} 
					echo "</table>
                                </div></div>";

                    // recommended project function defined in functions/delete_comment for use in profile page joined project tab
                        recommended_project ($db_handle);
                    // function call here ends
	         ?>
    </div>	
</div>
