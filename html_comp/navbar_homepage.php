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
                 <img src ='img/collap.gif' style="width:35px;"/><i>collap</i>
            </a>
            <div id='step8' class="nav-collapse collapse navbar-responsive-collapse navbar-search span3">
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
                    ?>
                    <li>
                        <p id='step9' class="navbar-text" style='cursor: pointer;color: #fff;'>
                            <b> Rank :  
                                <?php 
                                    $rank = $_SESSION['rank'];
                                    echo $rank; ?>
                            </b>
                        </p>
                    </li>
                    <li><a style="cursor: pointer;color: #fff;" id="demo"></a></li>
                    <li id='step10' style='cursor:pointer;'><div id='notifications'></div><div id='notificationlastid'></div></li>
                    <li id='step11' class="dropdown">
                       <a href='#' class="dropdown-toggle" data-toggle="dropdown" style='color: #fff;'>
                           <?php
                                $username = $_SESSION['username'];
                                $name = $_SESSION['first_name'];
                                echo "<img style='width: 25px; height: 25px;' src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'/>&nbsp &nbsp".ucfirst($name)."&nbsp"; 
                            ?>
                            <b class="caret"></b>
                        </a>
                        <ul class='dropdown-menu'>
                            <li><a class='btn-link' href="profile.php?username=<?=$username ?>"><i class='icon-user'></i> View Profile</a></li>
                            <li><a href="settings.php" class="btn-link" ><span class="icon-cog"></span> Settings </a></li>
                            <li><a type='submit' class="btn-link" onclick='confLogout()' name="logout" ><span class="icon-off"></span> Log out </a></li>
                        </ul>
                    </li>
    <?php
    } else {
        echo "<li>
                <p class='navbar-text' style='cursor: pointer'>
                    <b><a data-toggle='modal' data-target='#SignIn' style='color: #fff;'>Sign In / Sign Up</a></b>
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

<div class="divider large visible-desktop"></div>
    <div class="divider  hidden-desktop"></div>
<?php
    if (isset($_SESSION['user_id'])) {
        if ($requestedPage == "project.php") {   
            echo "  <div class='navbar-subnav subnavbar-fixed-top'> 
                        <div class='navbar-inner-subnav'>
                            <div class='container' >
                                <div class='span8 offset2'>
                                <ul id='step12' class='inline' style='margin: -2px 0 10px 25px;'>
                                    <li><button class='btn-link' style='color:#fff;' id='sign' ><span class='icon-question-sign'></span> Open challenges</button></li>
                                    <li><button class='btn-link' style='color:#fff;' id='deciduous' ><span class='icon-tree-deciduous'></span> Notes </button></li>
                                    <li><button class='btn-link' style='color:#fff;' id='pushpin' ><span class='icon-pushpin'></span> Tasks</button></li>
                					<li><button class='btn-link' style='color:#fff;' id='filmprj' ><span class='icon-film'></span> Videos</button></li>
                					<li><button class='btn-link' style='color:#fff;' id='flag' ><span class='icon-flag'></span> Completed challenges </button></li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>" ;
        }
        else if ($requestedPage == "ninjas.php"){
            echo "<div class='navbar-subnav subnavbar-fixed-top'>
					<div class='navbar-inner-subnav' >
						<div class='container'>
							<div class='span8 offset2'>
								<ul id='step13' class='inline' >
									<li><button class='btn-link' style='color:#fff;' id='allPanels' ><i class='icon-eye-open'></i> All</button></li>
									<li><a class='btn-link' href='#' style='color:#fff;' id='pencil' ><i class='icon-question-sign'></i> <span>Open challenges</span></a></li>
									<li><button class='btn-link' style='color:#fff;' id='globe' ><span class='icon-book'></span> Articles</button></li>
									<li><button class='btn-link' style='color:#fff;' id='tree' ><span class='icon-lightbulb'></span> Ideas</button></li>
									<li><button class='btn-link' style='color:#fff;' id='okch' ><span class='icon-flag'></span> Completed challenges </button></li>
									<li><button class='btn-link' style='color:#fff;' id='filmnin' ><span class='icon-film'></span> Videos</button></li>
									<li><button class='btn-link' style='color:#fff;' id='picch' ><span class='icon-picture'></span> Pics</button></li>
								 </ul>
							</div>
						</div>
					</div>
				</div>";
        }      
        else { }
    }
?>
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
