<?php 
  $requestedPage = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>
<div class="navbar navbar-default navbar-fixed-top">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="ninjas.php">Collgo</a>
  </div>
  
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
		<li><form method="POST" class="navbar-text" action = "">
          <input type="text" placeholder="search"/>
            <button type="submit" name="search" class="glyphicon glyphicon-search btn-primary btn-xs">
            </button>
        </form></li>
    </ul>
    <ul class='nav navbar-nav navbar-right'>
    <?php
    if($requestedPage == "ninjas.php"){
    echo "<li>
		  <div class='dropdown'>
            <a data-toggle='dropdown'><p class='navbar-text'>Your Teams<span class='caret'></span></p></a>
    		<ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>" ;
    		 
		$teams_name_display = mysqli_query($db_handle, ("select team_name from teams where user_id= '$user_id' ;")) ;
		while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
				$team_name = $teams_name_displayRow['team_name'] ;
				echo " <li class='dropdown-submenu'>
						<a style='white-space: normal;'>".ucfirst($team_name)."<br/></a>
								<ul class='dropdown-menu'>" ;
																	
			$teams_names_display = mysqli_query($db_handle, ("select b.first_name, b.last_name,a.team_name,b.email,b.contact_no,b.rank from teams as a join user_info
																as b where a.team_name = '$team_name' AND a.user_id = b.user_id and a.member_status = '1';"));
				while ($teams_names_displayRow = mysqli_fetch_array($teams_names_display)) {
								$firstname = $teams_names_displayRow['first_name'] ;
								$lastname = $teams_names_displayRow['last_name'] ;
						echo "<li><p align='center' ><form method='GET' value='".$username."' action='profile.php'><input type='submit' class='btn-link' value='".ucfirst($firstname)." ".ucfirst($lastname)."' 
							  style='white-space: normal;'/></form></p></li>" ;
				}
				echo "</ul></li>" ;
			}
			echo "</ul></div></li>";
			}
			?>
			
		<li>
		  <div class='dropdown'>
            <a data-toggle='dropdown'><p class='navbar-text'>Your Projects<span class='caret'></span></p></a>
    		<ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>
			   <?php
                            $project_title_display = mysqli_query($db_handle, ("(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.project_creation FROM teams as a join projects 
                                                                                as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '1')  
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE user_id = '$user_id' and project_type= '1');"));
                                while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
                                $p_title = $project_title_displayRow['project_title'] ;		
                                echo "<li><form method='POST' action=''>
                                <input type='hidden' name='project_title' value='".$p_title."'/>
                                <input type='hidden' name='project_id' value='".$project_title_displayRow['project_id']."'/>
                                <button type='submit' class='btn-link' name='projectphp' style='white-space: pre-line;'>".$p_title."</button><br/><br/></form></li>" ;
                            }
                        ?>
                        </ul>
                      </div>
                  </li>      
      <li><form method="POST" > 
          <p class="navbar-text"><a data-toggle="modal" class="btn-link" data-target="#createProject"><i class="glyphicon glyphicon-edit"></i>Create Project</a></p>
          <p class="navbar-text"><a href="challenges.php" style='cursor:pointer;'>Your Challenges</a></p>
          <p class="navbar-text">&nbsp;Your rank :  <?php echo $rank ; ?></p>
          <p class="navbar-text"><span class="glyphicon glyphicon-user"></span><a href="profile.php"> Hello <?php echo ucfirst($name); ?></a></p>                              
          <p class="navbar-text"><button type="submit" class="btn btn-danger btn-sm" name="logout" ><span class="glyphicon glyphicon-off"></span></button></p></form>
      </li>
    </ul>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Create New Project</h4>
            </div>
            <div class="modal-body">
                <form >
                    <div class="input-group-addon" >
                        <input type="text" class="form-control" id="project_title" placeholder="Enter Project Title">
                    </div>
                    <br>
                    <div class="input-group-addon">
                        <textarea rows="3" class="form-control" id="project_stmt" placeholder="Details about Project"></textarea>
                    </div>
                    <br/>
                    Estimated Time (ETA)
                    <select id = "eta" >	
                        <option value='0' selected >Month</option>
                        <?php
                        $m = 1;
                        while ($m <= 11) {
                            echo "<option value='" . $m . "' >" . $m . "</option>";
                            $m++;
                        }
                        ?>
                    </select>&nbsp;<select id = "etab" >	
                        <option value='0' selected >Days</option>
                        <?php
                        $d = 1;
                        while ($d <= 30) {
                            echo "<option value='" . $d . "' >" . $d . "</option>";
                            $d++;
                        }
                        ?>
                    </select>&nbsp;<select id = "etac" >	
                        <option value='0' selected >hours</option>
                        <?php
                        $h = 1;
                        while ($h <= 23) {
                            echo "<option value='" . $h . "' >" . $h . "</option>";
                            $h++;
                        }
                        ?>
                    </select>&nbsp;<select id= "etad" >	
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select>
                    <br/><br/>
                    <input type="button" class="btn btn-primary" id = "create_project" value = "Create Project" >
                </form>
            </div>
            <div class="modal-footer">
                <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end modle-->


