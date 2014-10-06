 <div class="bs-component">
              <div class="modal">
                  <div class="modal-content">
                    <div class="modal-header">
                      <p align="center"><font size="5"  color="silver">Your Teams</font></p>
                    </div>  
                    <div class="modal-body">
						<div class="well">
							<ul class="nav">
								
                        <?php 
                            $teams_name_display = mysqli_query($db_handle, ("select team_name from teams where user_id= '$user_id' ;")) ;
                            while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                                    $team_name = $teams_name_displayRow['team_name'] ;
                                    echo " <li>
												<label class='tree-toggle nav-header btn btn-default' style='white-space: normal; align:center;'>".ucfirst($team_name)."<br/></label>
													<ul class='nav tree' style='display: none;'><br/>" ;
                                                                                        
								$teams_names_display = mysqli_query($db_handle, ("select b.first_name, b.last_name,a.team_name,b.email,b.contact_no,b.rank from teams as a join user_info
                                                                                    as b where a.team_name = '$team_name' AND a.user_id = b.user_id and a.member_status = '1';"));
                                    while ($teams_names_displayRow = mysqli_fetch_array($teams_names_display)) {
                                                    $firstname = $teams_names_displayRow['first_name'] ;
                                                    $lastname = $teams_names_displayRow['last_name'] ;
                                                    $email = $teams_names_displayRow['email'] ;
                                                    $phone = $teams_names_displayRow['contact_no'] ;
                                                    $rank = $teams_names_displayRow['rank'] ;
                                                    $profile = $email." "."Phone No. : ".$phone." "."Rank : ".$rank ;
                                            echo "<li><p align='center' ><input type='submit' class='btn btn-default' name='projectphp' data-toggle='tooltip' 
                                                  data-placement='bottom' data-original-title='".$profile."' value='".ucfirst($firstname)." ".ucfirst($lastname)."' 
                                                  style='white-space: normal;'/></p></li><br/>" ;
                                    }
                                    echo "</ul></li><br/>" ;
                            }
                          ?>
                        </ul></div> 
                       </div>
                    <div class="modal-footer">
                  </div>
                </div>
              </div>
            </div>
