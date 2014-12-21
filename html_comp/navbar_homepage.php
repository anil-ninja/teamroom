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
            <div class="nav-collapse collapse navbar-responsive-collapse navbar-search span3">
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
                                            <a class='btn-link' href='teams.php?project_id=$team_project_id&team_name=$team_name'><strong>" . ucfirst($team_name) . "</strong></a>
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
                                <a class='btn-link' href="profile.php?username=<?=$username ?>"><i class='icon-user'></i> View Profile</a>
                            </li>
                            
                            <li>
                                <a href="settings.php" class="btn-link" ><span class="icon-cog"></span> Settings </a>
                            </li>
                            
                            <li>
                                <a type='submit' class="btn-link" onclick='confLogout()' name="logout" >
                                <span class="icon-off"></span> Log out </a> 
                            </li>
                            
                        </ul>
                    </li>
    <?php
    } else {
        echo "<li>
                <p class='navbar-text' style='cursor: pointer'>
                    <b> 
                        <a data-toggle='modal' data-target='#SignIn' style='color: #fff;'>Sign In</a> 
                    </b>
                </p>
            </li>";
        
        echo "<li>
                <p class='navbar-text' style='cursor: pointer'>
                    <a data-toggle='modal' data-target='#SignUp' style='color: #fff;'>
                        <b>Sign Up</b>
                    </a>
                </p>
            </li>";
    }
    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- sub nav bar-->
<?php
if (isset($_SESSION['user_id'])) {
if ($requestedPage == "project.php") {
    
 echo " 
        <div class='navbar-subnav'> 
        <div class='navbar-inner-subnav'>
            <div class='container' >
                <div class='span8 offset2'>
                <ul class='inline' >
                    <li><button class='btn-link' style='color:#fff;' id='sign' ><span class='icon-question-sign'></span> Open challenges</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='deciduous' ><span class='icon-tree-deciduous'></span> Notes </button></li>
                    <li><button class='btn-link' style='color:#fff;' id='pushpin' ><span class='icon-pushpin'></span> Tasks</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='flag' ><span class='icon-flag'></span> Closed challenges</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='filmprj' ><span class='icon-film'></span> Videos</button></p></li>
                </ul>
                </div>
            </div>
         
        </div>
        </div>" ;
}
    else if ($requestedPage == "ninjas.php"){
        echo "     
        <div class='navbar-subnav'>
        <div class='navbar-inner-subnav' >
            <div class='container' >
                <div class='span8 offset2'>
                <ul class='inline' >
                    <li><button class='btn-link' style='color:#fff;' id='allPanels' ><span class='icon-eye-open'></span> All</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='pencil' ><span class='icon-question-sign'></span> Open challenges</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='globe' ><span class='icon-book'></span> Articles</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='tree' ><span class='icon-magnet'></span> Ideas</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='okch' ><span class='icon-flag'></span> Closed challenges</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='filmnin' ><span class='icon-film'></span> Videos</button></li>
                    <li><button class='btn-link' style='color:#fff;' id='picch' ><span class='icon-picture'></span> Pics</button></li>
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
