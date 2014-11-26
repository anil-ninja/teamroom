<?php
$requestedPage = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>
<div class="navbar navbar-default navbar-fixed-top">
  <div class="row">
    <div class="col-md-2 navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-responsive-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="brand" style='font-size:15pt; color: #fff; font-weight: bold;' href="index.php">
              <img src ='img/collap.gif' style="width:50px;">collap</a>
        </div>
        <script src="js/search.js" type="text/javascript"></script>
         <div class="collapse navbar-collapse" id="navbar-responsive-collapse" style='background : #4EC67F;'>
                <ul class="col-md-3 nav navbar-nav navbar-left navbar-responsive">
                    <li class='navbar-text' >
                     <div class="input-group">
                             <input type="text"  id="searchfor" placeholder="search" style="height : 26px;padding-bottom: 0px; padding-top: 0px;" class="form-control">
                             <span class="input-group-btn">
                                 <button type="submit" id="keyword" onclick="searchingform()" class="btn btn-default" style="height : 26px;">
                                    <p class="glyphicon glyphicon-search">
                                 </button>
                             </span>
                     </div>
                    </li>
                </ul>
                <ul class='ccol-md-9 nav navbar-nav navbar-right' style='margin-right: 0px;'>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        if ($requestedPage == "challenges.php") {
                            echo "<li><p class='navbar-text' style ='cursor: pointer; text-decoration: none;'>
                                    <a data-toggle='modal' style='color: #fff;' data-target='#createChallenge'><i class='glyphicon glyphicon-edit'>
                                    </i><b>Create Challenge</b></a></p>    
                                </li>";
                        }
                            if ($requestedPage == "project.php") {
                            echo "<li>
                                    <div class='dropdown'>
                                        <a data-toggle='dropdown'><p class='navbar-text' style ='cursor: pointer; color: #fff;'><b>Teams</b>
                                        <span class='caret'></span></p></a>
                                        <ul class='dropdown-menu' role='menu' style='background-color: rgba(79, 183, 121, 0.8);color: #fff;'>";
                                    //team name with related project       
                                            $teams_name_display = mysqli_query($db_handle, ("select DISTINCT team_name, project_id from teams where user_id= '$user_id' AND project_id='$pro_id';"));
                                            while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                                                $team_name = $teams_name_displayRow['team_name'];
                                                $team_project_id = $teams_name_displayRow['project_id'];

                                                echo "<li>
                                                        <a class='btn-link pull-left' style='color: #fff; font-size:12px;' href='teams.php?project_id=$team_project_id&team_name=$team_name'><strong>" . ucfirst($team_name) . "</strong></a>
                                                    </li><hr style='margin-top: 26px'/>";
                                            }
                                    echo "</ul>
                                    </div>
                                </li>";
                            }
                        ?>
                       
                        <li><p class="navbar-text" style ="text-decoration: none;"> <a href="challenges.php" style='color: #fff;'><b>Challenges</b></a></p></li>
                        <li><p class="navbar-text" style='cursor: pointer;color: #fff;'><b> Rank :  <?php $rank = $_SESSION['rank'];
                                echo $rank; ?></b>
                            </p>
                        </li>
                        <li><b><p class="navbar-text" style='cursor: pointer;color: #fff;' id="demo"></p></b></li>
                        <li><div id='notifications'></div><div id='notificationlastid'></div></li>
               </li>
                <li><div class="dropdown">
                        <a data-toggle='dropdown'><p class='navbar-text' style ="cursor: pointer; color: #fff;">
                                <?php
                                    $username = $_SESSION['username'];
                                    $name = $_SESSION['first_name'];
                              echo "<img style='width: 25px; height: 25px' src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp &nbsp<b>".ucfirst($name)."</b>&nbsp"; 
                                    ?></p></a>
                        <ul class='dropdown-menu' role='menu' style="background-color: rgba(79, 183, 121, 0.8);color: #fff;">
                            <li>
                                <form method='GET' action='profile.php'>
                                    <b><button type='submit' name='username' class='btn-link' style="color: #fff;" value='<?php echo $username; ?>'>View Profile</button></b>
                                </form>
                            </li>
                            <hr/>
                            <li>
                                <b><a href="settings.php" class="btn-link" style="color: #fff;"><span class="glyphicon glyphicon-cog"></span> Settings </a></b>
                            </li>
                            <hr/>
                            <li>
                                <form method="POST" onsubmit="return confirm('Meet you soon!!!!');">
                                    <b><button type="submit" class="btn-link " name="logout" style="color: #fff;"><span class="glyphicon glyphicon-off"></span> Log out </button></b>
                                </form>  
                            </li>
                            
                        </ul>
                    </div>
                </li>
    <?php
    } else {
        echo "<li><p class='navbar-text' style='cursor: pointer'><b> <a data-toggle='modal' data-target='#SignIn' style='color: #fff;'>Sign In</a> </b></p></li>";
        echo "<li><p class='navbar-text' style='cursor: pointer'><a data-toggle='modal' data-target='#SignUp' style='color: #fff;'><b>Sign Up</b></a></p></li>";
    }
    ?>
        </ul>
        </div>
   </div>

 


<!-- sub nav bar-->
<?php
if (isset($_SESSION['user_id'])) {
if ($requestedPage == "project.php") {
    
 echo "  <div class='nav navbar-inverse' >
            <div class='col-md-offset-3 col-md-9 col-lg-9'>
                <div class='list-inline'style='background:#3BD78C;'>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='eye_open' ><span class='glyphicon glyphicon-eye-open'></span> All</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='sign' ><span class='glyphicon glyphicon-question-sign'></span> Open challenges</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='deciduous' ><span class='glyphicon glyphicon-tree-deciduous'></span> Notes </button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='pushpin' ><span class='glyphicon glyphicon-pushpin'></span> Tasks</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='flag' ><span class='glyphicon glyphicon-flag'></span> Closed challenges</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='filmprj' ><span class='glyphicon glyphicon-film'></span> Videos</button></p></li>
                </div>
            </div>
        </div>" ;
}
	else if ($requestedPage == "ninjas.php"){
		echo "     
        <div class='nav navbar-inverse ' >
            <div class='col-md-offset-3 col-md-9 col-lg-9'>
                <div class='list-inline' style='background:#3BD78C;'>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='allPanels' ><span class='glyphicon glyphicon-eye-open'></span> All</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='pencil' ><span class='glyphicon glyphicon-question-sign'></span> Open challenges</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='globe' ><span class='glyphicon glyphicon-book'></span> Articles</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='tree' ><span class='glyphicon glyphicon-flash'></span> Ideas</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='okch' ><span class='glyphicon glyphicon-flag'></span> Closed challenges</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='filmnin' ><span class='glyphicon glyphicon-film'></span> Videos</button></p></li>
                </div>
            </div>
        </div> " ;
}
else {
	echo "     
        <div class='nav navbar-inverse ' >
            <div class='col-md-offset-3 col-md-9 col-lg-9'>
                <div class='list-inline' style='background:#3BD78C;'>
                </div>
            </div>
        </div> " ;
	}
}
?>
</div>
  </div>
 
<!-- Modal  -->
<div class="modal fade" id="createProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Create New Project</h4>
            </div>
            <div class="modal-body">
                <form >
                    <input type="text" class="form-control" id="project_title" placeholder="Enter Project Title"><br>
                    <input class="btn btn-default btn-sm" type="file" id="_fileProject" style ="width: auto;"><br/>
                    <textarea rows="3" class="form-control" id="project_stmt" placeholder="Details about Project"></textarea><br/>
                 <!---   Estimated Time (ETA)
                    <select id = "eta" >	
                        <option value='0' selected >Month</option>
                        <?php /*
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
                        } */
                        ?>
                    </select>&nbsp;<select id= "etad" >	
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select>
                    <br/><br/> --->Project Type 
                    <select id= "type" >	
                        <option value='2' selected >Classified</option>
                        <option value='1' >Public</option>
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
<div class="modal fade" id="signupwithoutlogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel"><font size="5" >Let's Join</font></h4>
			</div>
			<div class='alert_placeholder'></div>
			<div class="modal-body">
				<div class='row'>
					<div class='col-md-6'>
						<input type='text' class='form-control' style='width: 100%;' id='subscriptionid' placeholder='Enter Email-ID'/>
					</div>
					<div class='col-md-2'>
						<input type='submit' class='btn-success btn-xs' id='Subscribe' value='Subscribe'/><br/>
					</div>
				</div>
				<input type='text' class='form-control' id='' placeholder=''/><br/>
			</div>
			<div class="modal-footer">
				<button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' id='answerForm' tabindex='-1' role='dialog' aria-labelledby='myModalLabel1' aria-hidden='true'>
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
							<textarea row='5' id='answerchal' class='form-control' placeholder='submit your answer'></textarea>
						</div>
						<br/>
						<input class='btn btn-default btn-sm' type='file' id='_fileanswer' style ='width: auto;'>
						<br/>
						<input type='hidden' id='answercid' value=''>
						<button type='submit' class='btn btn-success btn-sm' id='answerch' >Submit</button> 
					</form></div> 
					<div class='modal-footer'>
						<button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</div> 
			</div>
		  </div>
