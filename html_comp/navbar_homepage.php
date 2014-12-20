<?php
    $linktologout = 'http://'.$_SERVER['HTTP_HOST'] ;
    $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $requestedPage = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-inner" >
        <div class="container" >
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" style="font-size:16pt; color: #fff; font-weight: bold; font-family: 'Open Sans', sans-serif;" href="index.php">
                 <img src ='img/collap.gif' style="width:35px;">collap
            </a>
            <div class="nav-collapse collapse navbar-responsive-collapse pull-left">
               <script> 
                             (function() { 
                                 var cx = '007811515162108704212:nlk9cflmqvg'; 
                                 var gcse = document.createElement('script'); 
                                 gcse.type = 'text/javascript'; gcse.async = true; 
                                 gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//www.google.com/cse/cse.js?cx=' + cx; 
                                 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s); 
                             })(); 
                        </script> 

                        <gcse:searchbox></gcse:searchbox>
            </div>
    
        
            <div class="nav-collapse collapse navbar-responsive-collapse pull-right">
                
                <ul class="nav">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                            if ($requestedPage == "project.php") {
                            echo "<li class='dropdown'>
                                    <a href='#' class='dropdown-toggle' data-toggle='dropdown' style='color: #fff'>
                                        Teams
                                        <b class='caret'></b>
                                    </a>

                                    <ul class='dropdown-menu'>";

                                    //team name with related project       
                            $teams_name_display = mysqli_query($db_handle, ("SELECT DISTINCT team_name, project_id 
                                                                                FROM teams 
                                                                                WHERE user_id = '$user_id' 
                                                                                    AND project_id ='$pro_id';"
                                                                            )
                                                                );

                            while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                                $team_name = $teams_name_displayRow['team_name'];
                                $team_project_id = $teams_name_displayRow['project_id'];

                                echo "  <li>
                                            <a class='btn-link pull-left' style='color: #fff; font-size:12px;' href='teams.php?project_id=$team_project_id&team_name=$team_name'><strong>" . ucfirst($team_name) . "</strong></a>
                                        </li>";
                                }
                            echo "  </ul>
                                    
                                </li>";
                            }
                    ?>
                       
      
                    <li>
                        <p class="navbar-text" style='cursor: pointer;color: #fff;'>
                            <b> Rank :  
                                <?php 
                                    $rank = $_SESSION['rank'];
                                    echo $rank; ?>
                            </b>
                        </p>
                    </li>
                    
                    <li>
                        <a style="cursor: pointer;color: #fff;" id="demo"></a>
                    </li>
                    
                    <li>
                        <div id='notifications'></div>
                        <div id='notificationlastid'></div>
                    </li>

                    <li class="dropdown">
                       <a href='#' class="dropdown-toggle" data-toggle="dropdown" style='color: #fff;'>
                           <?php
                                $username = $_SESSION['username'];
                                $name = $_SESSION['first_name'];
                                echo "<img style='width: 25px; height: 25px;' src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp &nbsp<b>".ucfirst($name)."</b>&nbsp"; 
                            ?>
                            <b class="caret"></b>
                        </a>

                        <ul class='dropdown-menu'>
                            <li>
                                <a class='btn-link' href="profile.php?username=<?=$username ?>">View Profile</a>
                            </li>
                            
                            <li>
                                <a href="settings.php" class="btn-link" ><span class="glyphicon glyphicon-cog"></span> Settings </a>
                            </li>
                            
                            <li>
                                <a><button type='submit' class="btn-link" onclick='confLogout()' name="logout" ><span class="glyphicon glyphicon-off"></span> Log out </button></a> 
                            </li>
                            
                        </ul>
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
    </div>
<!-- sub nav bar-->
<?php
if (isset($_SESSION['user_id'])) {
if ($requestedPage == "project.php") {
    
 echo "  <div class='navbar-inner-subnav'>
            <div class='container' >
                <div class='span7 offset3'>
                <ul class='nav' >
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='eye_open' ><span class='glyphicon glyphicon-eye-open'></span> All</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='sign' ><span class='glyphicon glyphicon-question-sign'></span> Open challenges</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='deciduous' ><span class='glyphicon glyphicon-tree-deciduous'></span> Notes </button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='pushpin' ><span class='glyphicon glyphicon-pushpin'></span> Tasks</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='flag' ><span class='glyphicon glyphicon-flag'></span> Closed challenges</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='filmprj' ><span class='glyphicon glyphicon-film'></span> Videos</button></p></li>
                </ul>
                </div>
            </div>
         
        </div>" ;
}
    else if ($requestedPage == "ninjas.php"){
        echo "     
        <div class='navbar'>
        <div class='navbar-inner-subnav' >
            <div class='container' >
                <div class='span7 offset3'>
                <ul class='nav' >
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='allPanels' ><span class='glyphicon glyphicon-eye-open'></span> All</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='pencil' ><span class='glyphicon glyphicon-question-sign'></span> Open challenges</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='globe' ><span class='glyphicon glyphicon-book'></span> Articles</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='tree' ><span class='glyphicon glyphicon-flash'></span> Ideas</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='okch' ><span class='glyphicon glyphicon-flag'></span> Closed challenges</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='filmnin' ><span class='glyphicon glyphicon-film'></span> Videos</button></p></li>
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='picch' ><span class='glyphicon glyphicon-picture'></span> Pics</button></p></li>
                 </ul>
                 </div>
            </div>
         </div>
        </div>" ;
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
  <script>
  function confLogout(){
        bootbox.confirm("Meet You Soon !", function(result) {
        //Example.show("Confirm result: "+result);
        if(result){
            //call logout wall
             window.location='<?=$linktologout ; ?>'+'/logout.php?url='+'<?=$actual_link ; ?>' ;
            }
        });
    } ;
  </script>
 
<!-- Modal  -->

<div id="createProject" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span8 offset2">

            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="index.html#panel6-1" data-toggle="tab" class="active "><i class="icon-lock"></i>&nbsp;<span>Add Project</span></a></li>
                    <li><a href="index.html#close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active" id="panel6-1">
                        <div class="row-fluid">
                            
                                <h4><i class="icon-user"></i>&nbsp;&nbsp;Create New Project </h4>

                                <label>Project Title</label>
                                <input type="text" class="input-block-level" id="project_title" placeholder="Enter Project Title"/>
                                <label>Upload File</label>
                                <input type="file" id="_fileProject"/>
                                
                                <label>Details about Project</label>
                                <textarea class="input-block-level" id="project_stmt" placeholder="Details about Project"></textarea>
                                
                                <br />
                                <label>Project Type</label> 
                                <select id= "type" >    
                                    <option value='2' selected >Classified</option>
                                    <option value='1' >Public</option>
                                </select>
                                <br/><br/>
                                <a href="index.html#" class=" btn " id = "create_project">Create Project&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   


<div class="modal fade" id="createProject_old" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                 <!--   Estimated Time (ETA)
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
                    <br/><br/> -->Project Type 
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
<div class="modal fade" id="signupwithoutlogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content" style='border: 10px solid #DDD ;margin-top: 100px; position:fixed; margin-left: 200px; width:400px; height:300px;'>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <a href='collap.com'><p style='font-family: Sans-serif; font-size:26px;text-align:center;'><img src ='img/collap.gif' style="width:50px; height:40px;">Collap</p></a>
                <h4 class="modal-title" id="myModalLabel"><p style='font-family: Sans-serif; font-size:20px;margin-top:10px;text-align:center; word-wrap: break-word;'>Let's Collaborate</p></h4>
                <p style='font-family: Sans-serif; font-size:14px;margin-top:20px;text-align:center; word-wrap: break-word;color:#3B5998;'>
                Collap is exodus to make collaboration strong. Lets work together to do more... </p><br/><br/>
                <div class='row'>
                    <div class='col-md-8'>
                        <input type='email' class='form-control' style='width: 105%;' id='subscriptionid' placeholder='Enter Email-ID'/>
                    </div>
                    <div class='col-md-3'>
                        <input type='submit' class='btn btn-success' onclick='Subscribe()' value='Subscribe'/><br/>
                    </div>
                </div><br/>
                <button class="btn btn-primary pull-right" style='margin-right:10px;' onclick='test2()'>Sign up</button>
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
            <div class='modal-body'>
                <form>  
                    <div class='input-group-addon'>
                        <textarea row='5' id='answerchal' class='form-control' placeholder='submit your answer'></textarea>
                    </div>
                    <br/>
                    <input class='btn btn-default btn-sm' type='file' id='_fileanswer' style ='width: auto;'>
                    <br/>
                    <input type='hidden' id='answercid' value=''>
                    <input type='hidden' id='prcid' value=''>
                    <button type='submit' class='btn btn-success btn-sm' id='answerch' >Submit</button> 
                </form>
            </div> 
            <div class='modal-footer'>
                <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div> 
    </div>
</div>
