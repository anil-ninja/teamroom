<div class="bs-component">
    <a data-toggle="modal" class="btn btn-link" data-target="#managefiles" style="cursor:pointer;"><i class="glyphicon glyphicon-hdd"></i> Manage Files</a><br/>
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
								 echo "Team Name : <p align='center' style='white-space: normal;' >".ucfirst($teamname)."</p>
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
                                            </li></ul></div><br/><p align='center'>Members</p>" ;
                               
                               if ($owner == $user_id) { 
                               
                                $member = mysqli_query($db_handle, ("SELECT DISTINCT a.id, a.user_id, a.member_status,b.username, b.last_name,b.rank, b.first_name, b.contact_no, b.email FROM teams as a join user_info as b where
                                                                    a.team_name = '$teamname' and a.member_status = '1' and a.user_id = b.user_id ;")) ;
                                while ($memberrow = mysqli_fetch_array($member)) {
                                    $memid = $memberrow['id'] ;
                                    $memberid = $memberrow['user_id'] ;
                                    $firstname = $memberrow['first_name'] ;
									$lastname = $memberrow['last_name'] ;
                                    $username_profile = $memberrow['username'];
							echo "<form role='form' method='POST' class='inline-form' onsubmit=\"return confirm('Really, Remove this Friend !!!')\">
                                    <a href ='profile.php?username=".$username_profile."'>".ucfirst($firstname)." ".ucfirst($lastname)."</a>
                                     <input type='hidden' name='deleteid' value='".$memid."'/>
                                     <input type='hidden' name='delid' value='".$memberid."'/><p align='right'><button type='submit' class='inline-form btn btn-warning btn-sm' name='delete'><span class='glyphicon glyphicon-trash'></span></button></p>
                                        </form></p>" ;

                                    //header('Location: project.php');
                                }
                                 }
                                  else { 
                                $member = mysqli_query($db_handle, "SELECT DISTINCT a.id, a.user_id, a.member_status, b.first_name, b.contact_no, b.email FROM teams as a join user_info as b where
                                                                    a.team_name = '$teamname' and a.member_status = '1' and a.user_id = b.user_id ;") ;
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
                                        involve_in($db_handle,$user_id,"15",$pro_id)
                                        events($db_handle,$user_id,"15",$pro_id)
                                        //header('Location: projct.php');
                                } 
                                else { 
                                    echo "Member Not Registered Yet" ;
                                }
                                 }
                                ?>
  
