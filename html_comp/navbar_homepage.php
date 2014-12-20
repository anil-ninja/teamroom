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
                 <img src ='img/collap.gif' style="width:35px;"><i>collap</i>
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
