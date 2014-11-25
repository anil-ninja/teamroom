<?php
include_once 'lib/db_connect.php';
include_once 'functions/profile_page_function.php';
$UserName = $_GET['username'];
session_start();
$userInfo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE username = '$UserName';");
$userInfoRows = mysqli_num_rows($userInfo);

if ($userInfoRows == 0) {
    include_once 'error.php';
    exit;
}
if (isset($_POST['logout'])) {
    header('Location: profile.php?username='."$UserName");
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    session_destroy();
    exit;
}
if(isset($_POST['projectphp'])){
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['first_name'];
    $username = $_SESSION['username'];
    $rank = $_SESSION['rank'];
    $email = $_SESSION['email'];
        header('location: project.php') ;   
        $_SESSION['user_id'] = $user_id;
        $_SESSION['first_name'] = $name;
        $_SESSION['project_id'] = $_POST['project_id'] ;
        $_SESSION['rank'] = $rank;
        exit ;
}
$user_InformationRow = mysqli_fetch_array($userInfo);
$profileViewFirstName = $user_InformationRow['first_name'];
$profileViewLastName = $user_InformationRow['last_name'];
$profileViewEmail = $user_InformationRow['email'];
$profileViewPhone = $user_InformationRow['contact_no'];
$profileViewUserID = $user_InformationRow['user_id'];

$challengeCreated = mysqli_query($db_handle, "SELECT COUNT(challenge_id) FROM challenges WHERE user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeCreated);
$totalChallengeCreated = $counter["COUNT(challenge_id)"];

$challengeProgress = mysqli_query($db_handle, "SELECT COUNT(status) FROM challenge_ownership WHERE status = 1 and user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeProgress);
$totaLChallengeProgress = $counter["COUNT(status)"];

$challengeCompleted = mysqli_query($db_handle, "SELECT COUNT(status) FROM challenge_ownership WHERE status = 2 and user_id = $profileViewUserID;");
$counter = mysqli_fetch_assoc($challengeCompleted);
$totalChallengeCompleted = $counter["COUNT(status)"];

$projectCreated = mysqli_query($db_handle, "SELECT COUNT(project_id) FROM projects WHERE user_id = $profileViewUserID AND (project_type!=3 OR  project_type!=5);");
$counter = mysqli_fetch_assoc($projectCreated);
$totalProjectCreated = $counter["COUNT(project_id)"];

$projectJoined = mysqli_query($db_handle, "SELECT count(project_id) FROM projects WHERE projects.project_id IN( SELECT teams.project_id from teams where teams.user_id = $profileViewUserID)AND projects.user_id != $profileViewUserID and projects.project_type != 5 and projects.project_type!=3;");
$counter = mysqli_fetch_assoc($projectJoined);
$projectsJoined = $counter["count(project_id)"];

$projectProgress = mysqli_query($db_handle, "SELECT COUNT(project_id) FROM projects WHERE project_id IN (SELECT DISTINCT project_id FROM teams WHERE user_id = $profileViewUserID) and project_type != '3' and project_type != '5';");
$counter = mysqli_fetch_assoc($projectProgress);
$totalprojectProgress = $counter["COUNT(project_id)"];

include_once 'models/profile.php';
$obj = new profile($UserName);
//echo $obj->first_name."hi";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title><?= $profileViewFirstName." ".$profileViewLastName; ?></title>

        <link rel="stylesheet" href="css/profile_page_style.css">

        <meta name="author" content="Anil">
        <!-- for Google -->
        <meta name="keywords" content="Challenges, Projects, Problem solving, problems" />
        <meta name="author" content="<?= $obj->first_name." ".$obj->last_name; ?>" />
        <meta name="copyright" content="true" />
        <meta name="application-name" content="Article" />

        <!-- for Facebook -->          
        <meta property="og:image" content="<?= $obj->getImage(); ?>" />
        <meta property="og:url" content="" />
        
        <!-- for Twitter -->          
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:image" content="<?= $obj->getImage(); ?>" />
        
        
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.css">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	
	<link href="css/font-awesome.css" rel="stylesheet">
	<script src="js/jquery.js"> </script>
	<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery.autosize.js"></script>
<!-- script fro challenge comment delete, it is common for all challenges comments.  -->
	<script src="js/delete_comment_challenge.js" type="text/javascript"> </script>
	<script src="js/ninjas.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/signupValidation.js"></script>
	<script type="text/javascript" src="js/loginValidation.js"></script>
    </head>

    <body style="background:#F0F1F2;">
        <?php include_once 'html_comp/navbar_homepage.php'; ?>
         
        <div class="" style="padding-top: 50px;">
        <div class="col-md-3">
        <?php
            echo "<br/><img src='uploads/profilePictures/$UserName.jpg'  style='width:75%' onError=this.src='img/default.gif' class='img-circle img-responsive'>"; 
            if ((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) {
                echo "<a data-toggle='modal' class = 'btn btn-default btn-xs'style='cursor: pointer' data-target='#uploadPicture'>Change Pic</a>
                    <div class='alert_placeholder'> </div>";
            
            echo "<br/><hr/><span class='glyphicon glyphicon-user'></span><strong> <span id='first_name'>" 
                        . ucfirst($profileViewFirstName)."</span> <span id='last_name'>".ucfirst($profileViewLastName)."</span></strong>
                            <button onclick='showMsg();' id='showEdit' class='glyphicon glyphicon-pencil'></button>";
                            echo "<div id='editName'>
                                <form class='inline-form'>
                                    <input type ='text' id='edit_first' value=".ucfirst($profileViewFirstName).">
                                    <input type ='text' id='edit_last' value=".ucfirst($profileViewLastName).">
                                </form>
                            </div>
                            <button onclick='hideMsg();' id='showUpdate'>Update</button>";
            } 
            else {
                echo "<br/><hr/><span class='glyphicon glyphicon-user'><strong> " . ucfirst($profileViewFirstName) . " " . ucfirst($profileViewLastName) . "</strong>";
            } 
             echo "<br/>&nbsp;&nbsp;(".$_SESSION['rank'].")</span>
                  <br/><span class='glyphicon glyphicon-envelope' id='email' style='cursor: pointer'>&nbsp;" . $profileViewEmail . "</span>
                  <br/><span class='glyphicon glyphicon-earphone' id='phone' style='cursor: pointer'>&nbsp;" . $profileViewPhone . "<br/></span>
                  <br/><span><br/>Skills:";
            $skill_display = mysqli_query($db_handle, "SELECT b.skill_name from user_skills as a join skill_names as b WHERE a.user_id = $profileViewUserID AND a.skill_id = b.skill_id ;");
            while ($skill_displayRow = mysqli_fetch_array($skill_display)) {
                echo "<span class='tags'>".$skill_displayRow['skill_name']."</span> ";
                }
            echo "<br/></span>";
                                
                   
            if((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] == $profileViewUserID)) { 
                echo "
                        <a data-toggle='modal' class='btn-xs btn-primary ' data-target='#addskill' style='cursor:pointer;'>
                            <i class='glyphicon glyphicon-plus'></i>
                            Skill
                        </a><br/>";
                }
                        
                        // echo "<span>
                        //     <select class='btn-xs' id='remove'>
                        //     <option value='0' selected></option>";  
                        //         $skill_remove_names= mysqli_query($db_handle, "SELECT b.skill_id, b.skill_name FROM user_skills as a join skill_names as b
                        //                                                         WHERE a.user_id = $profileViewUserID AND a.skill_id = b.skill_id;");
                        //        while ($skill_remove_namesRow = mysqli_fetch_array($skill_remove_names)) {
                        //             echo "<option value= '".$skill_remove_namesRow['skill_id']."'>".$skill_remove_namesRow['skill_name']."</option>";
                        //        }
                        // echo "</select>&nbsp
                        //     <input id='remove_skill' class='btn-xs btn-primary' type='submit' value='Remove Skill'/>
                        // </span>";
            ?>
            
        </div>
          <div class="col-md-7" style="background-color:#FEFEFE;">
            <div>
              <ul class="nav nav-tabs" role="tablist" style="font-size:17px">
                  <li role="presentation" class="active">
                    <a href="#tabProjects" role="tab" data-toggle="tab">Projects</a></li>
                  <li role="presentation">
                    <a href="#tabArticles" role="tab" data-toggle="tab">Articles</a></li>
                  <li role="presentation">
                    <a href="#tabChallanges" role="tab" data-toggle="tab">Challanges</a></li>
                  <li role="presentation">
                    <a href="#tabIdeas" role="tab" data-toggle="tab">Ideas</a></li>
              </ul>
            </div>
            <div class="tab-content" >
              <div role="tabpanel" class="row tab-pane active" id="tabProjects" >
                <div class="col-md-6">
                  <div class='col-md-12 pull-left list-group-item'>
                      <strong>Created(<?php echo $totalProjectCreated;?>)</strong>
                  </div>
                   
                                         
                  <?php
                  $project_created_display = mysqli_query($db_handle, "(SELECT project_id, project_title, stmt FROM projects WHERE user_id = $profileViewUserID AND blob_id=0 AND (project_type!=3 OR project_type!=5))
                                                                        UNION 
                                                                       (SELECT a.project_id, a.project_title, b.stmt FROM projects as a JOIN blobs as b WHERE a.user_id = $profileViewUserID AND a.blob_id=b.blob_id AND (a.project_type!=3 OR a.project_type!=5));");
                  while($project_table_displayRow = mysqli_fetch_array($project_created_display)) {
                  $project_title_table = $project_table_displayRow['project_title'];
                  $project_stmt_table = $project_table_displayRow['stmt'];
                  $project_stmt_table = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_stmt_table)));
                  $project_id_table = $project_table_displayRow['project_id'];
                  //project title created by profile user
                  echo  "<div class='col-md-12 text-left list-group-item'>
                         <a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$project_id_table."'><strong> "                          
                       .$project_title_table.":&nbsp<br/></strong></a>
                        "
                       .substr($project_stmt_table,0, 70).
                       "
                       </left></div>";
                    }
                    ?>   
                    </div>
                    <div class="col-md-6">
                      <div class='col-md-12 pull-right list-group-item'>
                          <strong>Joined(<?php echo $projectsJoined;?>)</strong>
                      </div>
                      <?php
                      $project_joined_display = mysqli_query($db_handle, "(SELECT project_id, project_title, stmt FROM projects WHERE projects.project_id IN (SELECT teams.project_id from teams where teams.user_id = $profileViewUserID)AND projects.user_id != $profileViewUserID and projects.project_type != 4 and project_type!=3 and project_type!=5 AND blob_id = 0)
                                                                          UNION 
                                                                      (SELECT a.project_id, a.project_title, b.stmt FROM projects as a JOIN blobs as b WHERE a.project_id IN( SELECT teams.project_id from teams where teams.user_id = $profileViewUserID)AND a.user_id != $profileViewUserID and a.project_type != 4 and a.project_type!=3 and a.project_type!=5 AND a.blob_id = b.blob_id);");
                      while($project_joined_displayRow = mysqli_fetch_array($project_joined_display)) {
                      $project_joined_title = $project_joined_displayRow['project_title'];
                      $project_joined_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",$project_joined_displayRow['stmt'])));
                      $project_joined_id = $project_joined_displayRow['project_id'];
                      //project title created by profile user
                      echo  "<div class='col-md-12 text-left list-group-item' >
                             <a class='btn-link' style='color:#3B5998;' href='project.php?project_id=".$project_joined_id."'> <strong>"                          
                           .$project_joined_title.": &nbsp<br/></strong></a>
                           "
                           .substr($project_joined_stmt,0,70).
                           "
                           </left></div>";

                      }
                      ?>           
                    </div>
                    </div>
                  <div role="tabpanel" class="tab-pane" id="tabArticles">
                    <div class="col-md-12">
                      <?php user_articles($db_handle,$profileViewUserID); ?>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="tabChallanges">
                      <div class="col-md-12">
                        <?php user_challenges($db_handle,$profileViewUserID); ?>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="tabIdeas">
                    <div class="col-md-12">
                      <?php user_idea($db_handle,$profileViewUserID); ?>
                    </div>
                  </div>
                </div>
                </div>
                <div class ="col-md-2">
					<?php include_once 'html_comp/known.php' ?>
                </div>
                </div>

<div id="InfoBox"></div>
        <script src="js/add_remove_skill.js"> </script>
            <!---Modal --->
            <div class="modal fade" id="uploadPicture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:300px; height:auto">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
                        <div class='alert_placeholder'></div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <input class="btn btn-default btn-sm" type="file" id="_fileprofilepic" style ="width: auto;"><br>
                        </div>
                        <input class="btn btn-primary btn-sm" type="submit" id="upload_image"  value="Change"><br>
                    </div>
                </div>
            </div>
        </div>
      <!---      <form action="lib/upload_file.php" method="post" enctype="multipart/form-data">
                  
            </form> --->
            <!---End OF Modal --->
            <!---Modal --->
            <div class="modal fade" id="addskill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:300px; height:auto;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Add Skills</h4>
                        <div class='alert_placeholder'></div>
                    </div>
                    <div class="modal-body">
						Select Skill : &nbsp;&nbsp;&nbsp;&nbsp;
                        <select class="inline-form" id = "skills" >	
                            <option value='0' selected >Default (none)</option>
                            <?php
                            $m = mysqli_query($db_handle, "select * from skill_names where 1 = 1 ;") ;
                            while ($n = mysqli_fetch_array($m)) {
								$id = $n['skill_id'] ;
								$sn = $n['skill_name'] ;
                                echo "<option value='" . $id . "' >" . $sn . "</option>";
                            }
                            ?>
                        </select>
                        <br/><br/>OR<br/><br/>
                         Enter your Skill  &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='text' class="inline-form" id="insert" placeholder="Enter your Skill"/><br/><br/>
                        <input type="button" value="Add" class="btn btn-success" id="addskills"/>
                       
                        </div>
                     <div class="modal-footer">
                <button name="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
                </div>
            </div>
        </div>
            <!---End OF Modal --->            
        <div class="modal fade" id="SignIn" style="z-index: 2000;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:350px; height:auto">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Collaborations</h4>
                        
                        <div class='alert_placeholder'></div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon">Username</span>
                            <input type="text" style="font-size:10pt" class="form-control" id="username" placeholder="Enter email or username">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon">Password</span>
                            <input type="password" style="font-size:10pt" class="form-control" id="passwordlogin" placeholder="Password">
                        </div><br/>
                        <button type="submit" class="btn btn-success" name="request" value='login' onclick="validateLoginFormOnSubmit()">Log in</button>
                        
                    </div>

                    <div class  ="modal-footer">
						<button class="btn btn-primary" data-toggle='modal' data-target='#SignUp'>Sign Up</button>
                    </div>
                </div>
            </div>
        </div>

        <!--end modle-->
         
        <!-- Modal -->
        <div class="modal fade" id="SignUp" style="z-index: 9000;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                
                <div class="modal-content" style="width:390px; height:500px">
                   
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                         
                        <h4 class="modal-title" id="myModalLabel">New User Registration</h4>
                    </div>
                    <div class="modal-body">
                            <div class="inline-form">					
                                <input type="text" class="inline-form" id="firstname" placeholder="First name" onkeyup="nospaces(this)"/>	
                                <input type="text" class="inline-form" id="lastname" placeholder="Last name" onkeyup="nospaces(this)"/>					
                            </div><br/>	
                            <div class="inline-form">				
                                <input type="text" class="inline-form" id="email" placeholder="Email" onkeyup="nospaces(this)" /> <span id="status_email"></span>
                                <input type="text" class="inline-form" id="phone" placeholder="Mobile Number" onkeyup="nospaces(this)"/>
                            </div><br/>					
                            <input type="text" class="form-control" id="usernameR" placeholder="user name" onkeyup="nospaces(this)"/> <span id="status"></span>
                            <input type="password" class="form-control" id="passwordR" placeholder="password"/>
                            <input type="password" class="form-control" id="password2R" placeholder="Re-enter password"/><br/><br/>

                            <input type="submit" class="btn btn-primary" name = "request" value = "Signup" onclick="validateSignupFormOnSubmit()">
                    </div>
                    <div class  ="modal-footer">
                        <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end modle-->
        
        <script src="js/jquery.js"></script>
        <script src="js/ajaxupload-v1.2.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootswatch.js"></script>
        <script src="js/date_time.js"></script>
    <!---   <script src="js/uploadpic.js"></script> --->
        <script src="js/project.js"></script>
        
        <script src="js/custom.js"></script>

        

        <script type="text/javascript" src="js/loginValidation.js"></script>
        <script type="text/javascript" src="js/signupValidation.js"></script>
        <script>
            var hiddenFirst = document.getElementById("first_name");
            var hiddenLast = document.getElementById("last_name");
            var hideEdit = document.getElementById("showEdit");
            var hideUpdate = document.getElementById("showUpdate");
            var element = document.getElementById("editName");
            element.style.visibility = "hidden";
            hideUpdate.style.visibility = "hidden";
            
            function showMsg(){
                element.style.visibility = "visible";
                hiddenFirst.style.visibility = "hidden";
                hiddenLast.style.visibility = "hidden";
                hideEdit.style.visibility = "hidden";
                hideUpdate.style.visibility = "visible";
            }
            
            function hideMsg() {
                var edited_first = document.getElementById("edit_first").value;
                var edited_last = document.getElementById("edit_last").value;
                var dataString = 'new_first=' + edited_first + ('&new_last=') + edited_last;
                alert(dataString);
                if (edited_first == "") {
                    bootstrap_alert(".alert_placeholder", "First name can not be empty", 5000,"alert-warning");
                }
                else if (edited_first.length > 11) {
                    bootstrap_alert(".alert_placeholder", "First name can not be more than 11", 5000,"alert-warning");
                } 
                if (edited_last == "") {
                    bootstrap_alert(".alert_placeholder", "Last name can not be empty", 5000,"alert-warning");
                }
                else if (edited_last.length > 11) {
                    bootstrap_alert(".alert_placeholder", "Last name can not be more than 11", 5000,"alert-warning");
                }
                else {
                    $.ajax ({
                        type: "POST",
                        url: "ajax/editNameProfile.php",
                        data: dataString,
                        cache: false,
                        success: function(result){
                            bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
                            if(result=='Updated successfuly'){
                                //location.reload();
                                document.getElementById("first_name").innerHTML = edited_first;
                                document.getElementById("last_name").innerHTML = edited_last;
                                hiddenFirst.style.visibility = "visible";
                                hiddenLast.style.visibility = "visible";
                                hideEdit.style.visibility = "visible";
                            }
                        }
                    });
                }
                element.style.visibility = "hidden";
                hideUpdate.style.visibility = "hidden";
            }
        </script>
        <script>
            function bootstrap_alert(elem, message, timeout,type) {
                $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; right: 20%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

                if (timeout || timeout === 0) {
                    setTimeout(function() { 
                    $(elem).show().html('');
                    }, timeout);    
                }
            };
        </script>
        <script type="text/javascript">
            function checkForm() {
                if (document.getElementById('password_1').value == document.getElementById('password_2').value) {
                    return true;
                }
                else {
                    alert("Passwords don't match");
                    return false;
                }
            }
        </script>
        <script type="text/javascript">
            function nospaces(t){
                if(t.value.match(/\s/g)){
                    alert('Sorry, you are not allowed to enter any spaces');
                    t.value=t.value.replace(/\s/g,'');
                }
            }
        </script>
        <script type="text/javascript" src="js/username_email_check.js"></script>
    </body>
</html>
