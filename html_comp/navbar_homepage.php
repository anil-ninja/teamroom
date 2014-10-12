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
    <a class="navbar-brand" href="ninjas.php">Ninjas</a>
  </div>
  
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
		<li><form method="POST" class="navbar-text" action = "">
          <input type="text" placeholder="search"/>
            <button type="submit" name="search" class="glyphicon glyphicon-search btn-primary btn-xs">
            </button>
        </form></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
		<li><a class='tree-toggle' data-toggle='dropdown'>Your Teams</a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>
				<li>
					<div class="well">
						<ul class="nav">
						<?php 
                            $teams_name_display = mysqli_query($db_handle, ("select team_name from teams where user_id= '$user_id' ;")) ;
                            while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                                    $team_name = $teams_name_displayRow['team_name'] ;
                                    echo " <li>
											<label class='tree-toggle nav-header' style='white-space: normal; align:center;'>".ucfirst($team_name)."<br/></label>
													<ul class='nav tree' style='display: none;'>" ;
                                                                                        
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
                                                  style='white-space: normal;'/></p></li>" ;
                                    }
                                    echo "</ul></li><br/>" ;
                            }
                          ?>
						</ul></div></li></ul>
		</li>
      <li><form method="POST" >
          <?php 
            if($requestedPage == "ninjas.php") 
              echo "<p class='navbar-text'>
                      <a data-toggle='modal'  data-target='#myModal' style='cursor:pointer;'>
                            
                            <i class='glyphicon glyphicon-edit'>
                            </i>Create New Project
						</a>
                    </p>";
          ?>
          <p class="navbar-text"><a href="challenges.php" style='cursor:pointer;'>Your Challenges</a></p>
          <p class="navbar-text">&nbsp;Your rank :  <?php echo $rank ; ?></p>
          <p class="navbar-text"><span class="glyphicon glyphicon-user"></span><a href="profile.php"> Hello <?php echo ucfirst($name); ?></a></p>                              
          <p class="navbar-text"><button type="submit" class="btn btn-danger btn-sm" name="logout" ><span class="glyphicon glyphicon-off"></span></button></p></form>
      </li>
                   <li> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </li>
    </ul>
  </div>
</div>


