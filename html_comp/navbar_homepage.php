<?php
$requestedPage = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
// include_once 'ninjas.inc.php';
?>
<div class="navbar navbar-default navbar-fixed-top" style="line-height: 1.928571;">
    <div class="row">
        <div class="col-md-1">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style='color: #fff;font-size:18pt;' href="ninjas.php"><b>colvade</b></a>
            </div>
        </div>
        <div class="col-md-2">
                <div class="navbar-collapse" style="hieght: auto;">
                    <ul class="nav navbar-nav navbar-left">
                        <li class='navbar-text' >
                        <div class="row">
                         <div class="input-group">
                                 <input type="text"  id="search" placeholder="search" style="height : 28px" class="form-control">
                                 <span class="input-group-btn">
                                     <button type="submit" id="keyword"  class="btn btn-default">
                                        <p class="glyphicon glyphicon-search">
                                     </button>
                                 </span>
                         </div>
                         </div>
                        </li>
                    </ul>
                </div>
            </div>
    <div class="col-md-9">
    <div class="navbar-collapse" style="hieght: auto;">
       
        <ul class='nav navbar-nav navbar-right' >
            <?php
            if (isset($_SESSION['user_id'])) {
                if ($requestedPage == "challenges.php") {
                    echo "<li><p class='navbar-text' style ='cursor: pointer; text-decoration: none;'>
                            <a data-toggle='modal' style='color: #fff;' data-target='#createChallenge'><i class='glyphicon glyphicon-edit'>
                            </i><b>Create Challenge</b></a></p>    
                        </li>";
                }

                if ($requestedPage == "ninjas.php") {
                    echo "<li>
                            <div class='dropdown'>
                                <a data-toggle='dropdown'><p class='navbar-text' style ='cursor: pointer; color: #fff; text-decoration: none;'><b>Teams</b><span class='caret'></span></p></a>
                                <ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>";
                                    $teams_name_display = mysqli_query($db_handle, ("select team_name from teams where user_id= '$user_id' ;"));
                                    while ($teams_name_displayRow = mysqli_fetch_array($teams_name_display)) {
                                        $team_name = $teams_name_displayRow['team_name'];
                                        echo "<li class='dropdown-submenu'>
                                                <a style='white-space: normal;'>" . ucfirst($team_name) . "</a>
                                                    <ul class='dropdown-menu'>";
                                        $teams_names_display = mysqli_query($db_handle, ("select b.first_name, b.username, b.last_name,a.team_name,b.email,b.contact_no,b.rank from teams as a join user_info
                                                                                        as b where a.team_name = '$team_name' AND a.user_id = b.user_id and a.member_status = '1';"));
                                        while ($teams_names_displayRow = mysqli_fetch_array($teams_names_display)) {
                                            $firstname = $teams_names_displayRow['first_name'];
                                            $username = $teams_names_displayRow['username'];
                                            $lastname = $teams_names_displayRow['last_name'];
                                            echo "<li><p align='center' ><a href ='profile.php?username=" . $username . "'>" . ucfirst($firstname) . " " . ucfirst($lastname) . "</a></p></li>";
                                        }
                                    echo "</ul></li>";
                                    }
                            echo "</ul>
                            </div>
                        </li>";
                    }
                ?>
                <li>
                    <div class='dropdown'>
                        <a data-toggle='dropdown'><p class='navbar-text' style ="cursor: pointer; color: #fff; text-decoration: none;"><b>Projects</b><span class='caret'></span></p></a>
                        <ul class='dropdown-menu multi-level' role='menu' style="  max-height:300px; color: #fff; overflow-y: auto; overflow-x: hidden;" aria-labelledby='dropdownMenu'>
                            <?php
                         
                            $user_id = $_SESSION['user_id'];
                                $project_title_display = mysqli_query($db_handle, ("(SELECT DISTINCT a.project_id, b.project_title,b.project_ETA,b.project_creation FROM teams as a join projects 
                                                                                as b WHERE a.user_id = '$user_id' and a.project_id = b.project_id and b.project_type = '1')  
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE user_id = '$user_id' and project_type= '2')
                                                                                UNION (SELECT DISTINCT project_id, project_title, project_ETA, project_creation FROM projects WHERE project_type= '1');"));
                                while ($project_title_displayRow = mysqli_fetch_array($project_title_display)) {
                                    $p_title = $project_title_displayRow['project_title'];
                                    echo "<li>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='project_title' value='" . $p_title . "'/>
                                                <input type='hidden' name='project_id' value='" . $project_title_displayRow['project_id'] . "'/>
                                                <button type='submit' class='btn-link' name='projectphp' style='white-space: pre-line;'>" . $p_title . "
                                                </button><br/><br/>
                                            </form>
                                        </li>";
                                }
                            ?>
                        </ul>
                    </div>
                </li>      
                <li><p class="navbar-text" style ="cursor: pointer; text-decoration: none;"><a data-toggle="modal" style='color: #fff;' data-target="#createProject"><i class="glyphicon glyphicon-edit"></i><b>Create Project</b></a></p></li>
                <li><p class="navbar-text" style ="text-decoration: none;"> <a href="challenges.php" style='color: #fff;'><b>Challenges</b></a></p></li>
                <li><p class="navbar-text" style='cursor: pointer;color: #fff;'>&nbsp;<b> Rank :  <?php $rank = $_SESSION['rank'];
                        echo $rank; ?></b>
                    </p>
                </li>
                <li><b><p class="navbar-text" style='cursor: pointer;color: #fff;' id="demo"></p></b></li>
                <li><div class="dropdown">
                        <a data-toggle='dropdown'><p class='navbar-text' style ="cursor: pointer; color: #fff;">
                                <?php
                                    $username = $_SESSION['username'];
                                    echo "<img style='width: 25px; height: 25px' src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>"."&nbsp &nbsp";
                                    $name = $_SESSION['first_name'];
                                    echo "<b>".ucfirst($name)."</b>&nbsp"; 
                                    ?></p></a>
                        <ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>
                            <li><p class="navbar-text">
                                <form method='GET' action='profile.php'>
                                    <button type='submit' name='username' class='btn btn-link btn-sm' value='<?php $username = $_SESSION['username'];
                                        echo $username; ?>'>View Profile
                                    </button>
                                </form>
                                <p class="navbar-text">
                                <form method="POST" >
                                    <button type="submit" class="btn btn-link btn-xs" name="logout" >Log out&nbsp;<span class="glyphicon glyphicon-off"></span></p></button></form>   
                            </li>
                        </ul>
                    </div>
                </li><li>&nbsp;&nbsp;&nbsp;</li>
            
    <?php
    } else {
        echo "<li><p class='navbar-text' style='cursor: pointer'><b> <a data-toggle='modal' data-target='#SignIn' style='color: #fff;'>Sign In</a> </b></p></li>";
        echo "<li><p class='navbar-text' style='cursor: pointer'><a data-toggle='modal' data-target='#SignUp' style='color: #fff;'><b>Sign Up</b></a></p></li>";
    }
    ?>
        </ul>
    </div></div></div>



    <!-- sub nav bar-->
    <div class="navbar-collapse collapse navbar-responsive-collapse" style="width: 110%;">
        
        <ul class='nav navbar-nav navbar-inverse'>
            <div class="col-md-offset-3 col-md-9 col-lg-9">
                <div class="list-inline">
                    <li><p><button type='submit' class='btn-link btn-xs' style='color:#fff;' id='allPanels' ><span class='glyphicon glyphicon-eye-open'></span> All &nbsp;</button></p></li>
                    <li><p><button type='submit' class='btn-link btn-xs' style='color:#fff;' id='pencil' ><span class='glyphicon glyphicon-question-sign'></span> Open challenges &nbsp;</button></p></li>
                    <li><p><button type='submit' class='btn-link btn-xs' style='color:#fff;' id='globe' ><span class='glyphicon glyphicon-book'></span> Articles &nbsp;</button></p></li>
                    <li><p><button type='submit' class='btn-link btn-xs' style='color:#fff;' id='tree' ><span class='glyphicon glyphicon-flash'></span> Ideas &nbsp;</button></p></li>
                    <li><p><button type='submit' class='btn-link btn-xs' style='color:#fff;' id='ok' ><span class='glyphicon glyphicon-flag'></span> Closed challenges &nbsp;</button></p></li>
                    <li><p><button type='submit' class='btn-link btn-xs' style='color:#fff;' id='film' ><span class='glyphicon glyphicon-film'></span> Videos &nbsp;</button></p></li>
                </div>
            </div>
        </ul>                 
    </div>
</div>
<script>
	
    function show_search_results(challenges){
        var resp = "<div class='list-group'><div class='list-group-item'> <a data-toggle='modal' class='btn btn-link'style='line-height: 20.50px;font-size: 15px'>Search Results</a></b></div>";
        for (var i = 0; i < challenges.length; i++) {
            var resultNumber = i+1;
            
            resp = resp +"<div class='list-group-item'><div class ='row'><div class='col-md-1' style = 'width : 1%;'>"+"</div><div class ='col-md-9'> <a data-toggle='modal' class='btn btn-link' style='color:#3B5998;' href='challengesOpen?challenge_id="+challenges[i].challenge_id+"'>"+challenges[i].challenge_title+"</a><br>&nbsp;&nbsp;"+challenges[i].stmt+"..</br></div></div></div>"; 
        }
        return resp+"</div>";
    }
    function show_search_results_id(challenges){
        var id = "";
        for (var i = 0; i < challenges.length; i++) {
            id = id + challenges[i].challenge_id+"<br/>" ; 
        }
        return id;
    }
    $(document).ready(function(){
        $("#keyword").click(function(){
            var keyword1 = $("#search").val() ;
            //alert(keyword1);
            var dataString = 'keyword='+ keyword1 ;
            //alert(dataString);
            if(keyword1==''){
                alert("Please Enter Something !!!");
            }	else {
                $.ajax({
                    type: "GET",
                    url: "search.php",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        //alert(result);
                        challenges = JSON.parse(result);
                        document.getElementById("home-ch").innerHTML = show_search_results(challenges);
                        //document.getElementById("home").innerHTML = show_search_results_id(challenges);
                        //alert(show_search_results(challenges));
                        //alert(challenges[0].stmt);			
                    }
                });
            }
        });
    });	
</script>
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
                    Estimated Time (ETA)
                    <select id = "eta" >	
                        <option value='0' selected >Month</option>
                        <?php
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
                        }
                        ?>
                    </select>&nbsp;<select id= "etad" >	
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select>
                    <br/><br/>Project Type 
                    <select id= "type" >	
                        <option value='2' selected >Private</option>
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
