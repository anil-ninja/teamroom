<div class="bs-component">
                
                   
                <!-- <form action="lib/upload_file.php" method="post" enctype="multipart/form-data">
                    <label for="file">Upload file:</label>
                    <input class="btn btn-default btn-sm" type="file" name="file" id="file" style ="width: 100px;"><br>
                    <input class="btn btn-default btn-sm" type="submit" name="submit" value="Submit"><br>
                </form>
 -->                <a data-toggle="modal" class="btn btn-link" data-target="#managefiles" style="cursor:pointer;"><i class="glyphicon glyphicon-hdd"></i> Manage Files</a><br/>
                <?php 
                if($creater_id == $user_id) {
				echo "<a data-toggle='modal' class='btn btn-link' data-target='#assigntask' style='cursor:pointer;'><i class='glyphicon glyphicon-pushpin'></i> Assign Tasks</a><br/>";	
					}
					?>
                <a data-toggle="modal" class="btn btn-link" data-target="#createnotes" style="cursor:pointer;"><i class="glyphicon glyphicon-pencil"></i> Enter Notes</a><br/>
                <a data-toggle="modal" class="btn btn-link" data-target="#createChallenge" style="cursor:pointer;"><i class="glyphicon glyphicon-globe"></i> Create Challenge</a><br/>
                <a data-toggle="modal" class="btn btn-link" data-target="#create_team_new" style="cursor:pointer;"><i class="glyphicon glyphicon-phone-alt"></i> Create Team</a><br/>
                </div>  
                <a class="tree-toggle btn btn-link" style="cursor:pointer;"><i class ="glyphicon glyphicon-user"></i>Your Teams</a><br/>
                     <?php
                            $pro_id = $_SESSION['project_id'];
                            $team = mysqli_query($db_handle, ("SELECT DISTINCT team_name FROM teams where  project_id = '$pro_id' ;"));
                            while ($teamrow = mysqli_fetch_array($team)) {
                                $teams = $teamrow['team_name'];
                                echo "<ul class='nav tree' style='display: none;'>
										<li><form role='form' method='POST' action = ''>
                                        <input type='hidden' name='team_name' value='" . $teams . "'/>
                                        <input type='hidden' name='project_id' value='" . $pro_id . "'/>
                                        <p align='center' ><input type='submit' class='btn btn-default' name='view' value='".ucfirst($teams)."' style='white-space: normal;'/></p></form></li></ul>";
                            }
                            ?>
   
                      <?php
                            if (isset($_POST['view'])) {
                                $teamname = $_POST['team_name'] ;
                                $pro_id = $_POST['project_id'] ;
                                $teamowners = mysqli_query($db_handle, ("SELECT DISTINCT team_owner FROM teams where  team_name = '$teamname' and team_owner != '0' ;")) ;
                                 $teamownersrow = mysqli_fetch_array($teamowners) ;
                                 $owner = $teamownersrow['team_owner'] ;
								 echo "Team Name : <p align='center' style='white-space: normal;' >".ucfirst($teamname)."</p><br/>
										<div class='dropdown'>
                                          <input class='btn btn-success btn-xs dropdown-toggle' id='dropdownMenu1' value='Add Member' data-toggle='dropdown'/>
                                            <ul class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu1'>
                                            <li>
                                                <form role='form' method='POST' action = ''>
                                                    <input type='email' class='form-control' name='email' placeholder='Enter member Email'>
                                                    <input type='hidden' name='team_name' value='" .$teamname. "'/>
                                                    <input type='hidden' name='project_id' value='" .$pro_id. "'/>
                                                    <input type='submit' class='btn-success btn-sm' name='member' value='Add '/>
                                                </form>
                                            </li></ul></div><br/><p align='center'>Members</p><br/>" ;
                               
                               if ($owner == $user_id) { 
                               
                                $member = mysqli_query($db_handle, ("SELECT DISTINCT a.id, a.user_id, a.member_status,b.username, b.last_name,b.rank, b.first_name, b.contact_no, b.email FROM teams as a join user_info as b where
                                                                    a.team_name = '$teamname' and a.member_status = '1' and a.user_id = b.user_id ;")) ;
                                while ($memberrow = mysqli_fetch_array($member)) {
                                    $memid = $memberrow['id'] ;
                                    $memberid = $memberrow['user_id'] ;
                                    $firstname = $memberrow['first_name'] ;
									$lastname = $memberrow['last_name'] ;
									$email = $memberrow['email'] ;
                                                                        $username_profile = $memberrow['username'];
									$phone = $memberrow['contact_no'] ;
									$rank = $memberrow['rank'] ;
									$profile = $email." "."Phone No. : ".$phone." "."Rank : ".$rank ;
							echo "<form role='form' method='POST' onsubmit=\"return confirm('Really, Remove this Friend !!!')\">
                                   <a data-toggle='tooltip' data-placement='bottom' data-original-title='".$profile."'>
                                    <p align='center' style='white-space: normal;'><a href ='profile.php?username=".$username_profile."'>".ucfirst($firstname)." ".ucfirst($lastname)."</a></p></a>
                                     <input type='hidden' name='deleteid' value='".$memid."'/>
                                     <input type='hidden' name='delid' value='".$memberid."'/>
                                     <button type='submit' class='btn btn-warning btn-sm' name='delete'>
                                          <span class='glyphicon glyphicon-trash'></span>
                                              </button>
                                            <br/><br/>
                                        </form></p>" ;

                                    //header('Location: project.php');
                                }
                                 }
                                  else { 
                                $member = mysqli_query($db_handle, ("SELECT DISTINCT a.id, a.user_id, a.member_status, b.first_name, b.contact_no, b.email FROM teams as a join user_info as b where
                                                                    a.team_name = '$teamname' and a.member_status = '1' and a.user_id = b.user_id ;")) ;
                                while ($memberrow = mysqli_fetch_array($member)) {
                                     $memid = $memberrow['id'] ;
                                    $memberid = $memberrow['user_id'] ;
                                    $firstname = $memberrow['first_name'] ;
									$lastname = $memberrow['last_name'] ;
									$email = $memberrow['email'] ;
									$phone = $memberrow['contact_no'] ;
									$rank = $memberrow['rank'] ;
									$profile = $email." "."Phone No. : ".$phone." "."Rank : ".$rank ;
							echo "<a data-toggle='tooltip' data-placement='bottom' data-original-title='".$profile."'>
                                    <p align='center' style='white-space: normal;'>".ucfirst($firstname)." ".ucfirst($lastname)."</p></a><br/><br/>" ;
							}
						 }
                        }
                            if (isset($_POST['delete'])) {
                                $memid = $_POST['deleteid'] ;
                                $memberid = $_POST['delid'] ;
                              if ($memberid == $user_id) { 
								  echo "<script>alert('Can't Delete Team Owner !!!')</script>" ;
								   }
							else {	  
                                $a = date("y-m-d H:i:s") ;
                                mysqli_query($db_handle,"UPDATE teams SET member_status='2', leave_team='$a' WHERE id = '$memid' ; ") ;
                                //header('Location: project.php');
                                }
							}
                            if (isset($_POST['member'])) {
                                $team_name = $_POST['team_name'];
                                $email = $_POST['email'];
                                $pro_id = $_POST['project_id'] ;
                                $respo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE email = '$email';");
                                $row = mysqli_num_rows($respo);
                                if ($row == 1) {
                                        $responserow = mysqli_fetch_array($respo);
                                        $uid = $responserow['user_id'];
                                        mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, project_id) VALUES ('$uid', '$team_name', '$pro_id');");
                                        //header('Location: projct.php');
                                } 
                                else { 
                                    echo "Member Not Registered Yet" ;
                                }
                                 }
                                ?>
        


<div class="modal fade" id="managefiles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:900px; height:550px">
        
            
            <div class="modal-body">
                <div id="elfinder"></div>
            </div>
            
        
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="createnotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header"><div class='alert_placeholder'></div>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Notes</h4>
            </div>
            <div class="modal-body">
                <form >
                        <input type='text' class="form-control" id="notes_title" placeholder="Title"/><br>
                        <textarea rows="3" class="form-control" id="notes" placeholder="Notes about Project or Importent Things about Project"></textarea><br><br>
                        <input type='hidden' name='project_id' value="<?php echo $pro_id; ?>"/>
                        <input type="button" value="Post" class="btn btn-success" id="create_notes"/>
                </form>
            </div>
            <div class="modal-footer">
                <button name="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end modle-->
<!-- Modal -->
<div class="modal fade" id="assigntask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class='alert_placeholder'></div>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Assign Tasks</h4>
            </div>
            <div class="modal-body">
                <form >
					 <div class="input-group" >
                        <span class="input-group-addon">Assign To : </span>
                         <input type="email" class="form-control" id="email" placeholder="Enter email">
                      </div><br/>
                      <div class="input-group" >
                        <span class="input-group-addon">Title : </span>						
                        <input type="text" class="form-control" id="title" placeholder="Tilte"/>
                       </div><br>
                       <div class="input-group" >
                        <span class="input-group-addon">Task : </span>						
                        <textarea rows="3" class="form-control" id="taskdetails" placeholder="Details of Tasks"></textarea>
                        </div><br>
                    <div class="inline-form">
                        ETA : 
                        <select class="btn btn-default btn-xs" id = "c_eta" >	
                            <option value='0' selected >Month</option>
                            <?php
                            $m = 1;
                            while ($m <= 11) {
                                echo "<option value='" . $m . "' >" . $m . "</option>";
                                $m++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "c_etab" >	
                            <option value='0' selected >Days</option>
                            <?php
                            $d = 1;
                            while ($d <= 30) {
                                echo "<option value='" . $d . "' >" . $d . "</option>";
                                $d++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "c_etac" >	
                            <option value='0' selected >hours</option>
                            <?php
                            $h = 1;
                            while ($h <= 23) {
                                echo "<option value='" . $h . "' >" . $h . "</option>";
                                $h++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "c_etad" >	
                            <option value='15' selected >minute</option>
                            <option value='30' >30</option>
                            <option value='45'  >45</option>
                        </select>
                        </div><br/><br/>
                         <input type='hidden' id='project_id' value="<?php echo $pro_id; ?>"/>
                        <input type="button" value="Assign" class="btn btn-success" id="task"/>
                </form>
            </div>
            <div class="modal-footer">
                <button name="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end modle-->
<!-- Modal -->
<div class="modal fade" id="createChallenge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class='alert_placeholder'></div>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Challenge</h4>
            </div>
            <div class="modal-body">
                <form >
                        <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte"/><br>
                        <textarea rows="3" class="form-control" id="challange" placeholder="Details of Challange"></textarea><br>
                    <div class="inline-form">
                        Challange Open For : <select class="btn btn-default btn-xs" id= "open_time" >	
                            <option value='0' selected >hour</option>
                            <?php
                            $o = 1;
                            while ($o <= 24) {
                                echo "<option value='" . $o . "' >" . $o . "</option>";
                                $o++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id = "open" >	
                            <option value='10' selected >minute</option>
                            <option value='20'  >20</option>
                            <option value='30' >30</option>
                            <option value='40'  >40</option>
                            <option value='50' >50</option>
                        </select><br/><br/>ETA : 
                        <select class="btn btn-default btn-xs" id = "cc_eta" >	
                            <option value='0' selected >Month</option>
                            <?php
                            $m = 1;
                            while ($m <= 11) {
                                echo "<option value='" . $m . "' >" . $m . "</option>";
                                $m++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "cc_etab" >	
                            <option value='0' selected >Days</option>
                            <?php
                            $d = 1;
                            while ($d <= 30) {
                                echo "<option value='" . $d . "' >" . $d . "</option>";
                                $d++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "cc_etac" >	
                            <option value='0' selected >hours</option>
                            <?php
                            $h = 1;
                            while ($h <= 23) {
                                echo "<option value='" . $h . "' >" . $h . "</option>";
                                $h++;
                            }
                            ?>
                        </select>
                        <select class="btn btn-default btn-xs" id= "cc_etad" >	
                            <option value='15' selected >minute</option>
                            <option value='30' >30</option>
                            <option value='45'  >45</option>
                        </select>
                        </div><br/><br/>
                        <div class="input-group">Challenge Type : 
                            <select class='btn-default btn-xs' id="type" >
                                <option value=" 1" >Public</option>
                                <option value=" 2" selected >Private</option>
                            </select>
                        </div>
                        <br>
                        <input type='hidden' name='project_id' value="<?php echo $pro_id; ?>"/>
                        <input type="button" value="Create Challenge" class="btn btn-success" id="create_challange_pb_pr"/>
                </form>
            </div>
            <div class="modal-footer">
                <button name="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end modle-->           
<!-- Modal -->
<div class="modal fade" id="create_team_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Your New Team</h4>
            </div>
            <div class="modal-body"  >

                <form role="form" method="POST">
                    <div class="input-group" >
                        <span class="input-group-addon">Team Name</span>
                        <input type="text" class="form-control" name="team_name" placeholder="Enter your team name">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon">Create Team with (Email)</span>
                        <input type="email" class="form-control" name="email" placeholder="Enter First team member Email">
                    </div>
                    <br>
                    <input type="submit" class="btn btn-success" name = "create_team" value = "Create New Team" >
                </form>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end modle--> 
