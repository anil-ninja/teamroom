<?php
$linktologout = 'http://'.$_SERVER['HTTP_HOST'] ;
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$requestedPage = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>

<?php
/*
<div class="navbar navbar-default navbar-fixed-top">
  <div class="row">
    <div class="col-md-3 navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-responsive-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="brand" style='font-size:15pt; color: #fff; font-weight: bold;' href="index.php">
              <img src ='img/collap.gif' style="width:50px;">collap</a>
        </div>
        
         <div class="collapse navbar-collapse" id="navbar-responsive-collapse" style='background : #4EC67F;'>
                <ul class="col-md-3 nav navbar-nav navbar-left navbar-responsive" style= "margin-left:15px;">
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
                </ul>
                <ul class='ccol-md-9 nav navbar-nav navbar-right' style='margin-right: 0px;'>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        // if ($requestedPage == "challenges.php") {
                        //     echo "<li><p class='navbar-text' style ='cursor: pointer; text-decoration: none;'>
                        //             <a data-toggle='modal' style='color: #fff;' data-target='#createChallenge'><i class='glyphicon glyphicon-edit'>
                        //             </i><b>Create Challenge</b></a></p>    
                        //         </li>";
                        // }
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
                       
                       <!--  <li><p class="navbar-text" style ="text-decoration: none;"> <a href="challenges.php" style='color: #fff;'><b>Challenges</b></a></p></li> -->
                        <li><p class="navbar-text" style='cursor: pointer;color: #fff;'><b> Rank :  <?php $rank = $_SESSION['rank'];
                                echo $rank; ?></b>
                            </p>
                        </li>
                        <li><b><p class="navbar-text" style='cursor: pointer;color: #fff;' id="demo"></p></b></li>
                        <li><div id='notifications'></div><div id='notificationlastid'></div></li>
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
                                <b><button type='submit' class="btn-link" onclick='confLogout()' name="logout" style="color: #fff;"><span class="glyphicon glyphicon-off"></span> Log out </button></b>  
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
*/
?>

<div class="navbar navbar-default navbar-fixed-top" >
        <div class="navbar-inner" >
            <div class="container" >
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" style="font-size:16pt; color: #fff; font-weight: bold; font-family: 'Open Sans', sans-serif;" href="index.php">
                 <img src ='img/collap.gif' style="width:35px;">collap</a>
                <div class="nav-collapse collapse navbar-responsive-collapse">

<a href="index.html#panel1" data-toggle="tab" class=" btn pull-right active">Sign In&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                                
                </div>
                <!-- /.nav-collapse -->
            </div>
        </div>
        <!-- /navbar-inner -->
    </div>



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
                    <li><p><button type='submit' class='btn-link' style='color:#fff;' id='picch' ><span class='glyphicon glyphicon-picture'></span> Pics</button></p></li>
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
