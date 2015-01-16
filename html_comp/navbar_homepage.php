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
            <a class="brand" style="font-size:16pt; color: #fff; font-weight: bold; font-family: Courgette, cursive;" href="index.php">
                 <img src ='img/collap.gif' style="width:35px;"/><i>collap</i>
            </a>
            <div id='step8' class="nav-collapse collapse navbar-responsive-collapse navbar-search span4">
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
               <!---<li><a style="cursor: pointer;color: #fff;" id="demo"></a></li> --->
                    <li id='step10' style='cursor:pointer;'><li id='notifications' class='dropdown' ></li><li id='notificationlastid'></li></li>
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
