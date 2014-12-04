<?php 
    include_once 'challengesOpen.inc.php'; 
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php chOpen_title($challenge_page_title); ?></title>
        <meta name="author" content="">
        
        <!-- for Google -->
        <meta name="description" content="<?= $obj->getDiscription(); ?>" />
        <meta name="keywords" content="Challenges, Projects, Problem solving, problems" />
        <meta name="author" content="<?= $obj->first_name." ".$obj->last_name; ?>" />
        <meta name="copyright" content="true" />
        <meta name="application-name" content="Article" />

        <!-- for Facebook -->          
        <meta property="og:title" content="<?= $obj->challenge_title; ?>" />
        <meta property="og:type" content="article"/>
        <meta property="og:image" content="<?= $obj->url; ?>" />
        <meta property="og:url" content="<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>" />
        <meta property="og:description" content="<?= $obj->getDiscription(); ?>" />

        <!-- for Twitter -->          
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="<?= $obj->challenge_title; ?>" />
        <meta name="twitter:description" content="<?= $obj->getDiscription(); ?>" />
        <meta name="twitter:image" content="<?= $obj->url; ?>" />
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body>
      <?php include_once 'html_comp/navbar_homepage.php'; ?>
       <div class=" media-body" style="padding-top: 50px;">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <?php
                
                    challenge_display($db_handle, $challengeSearchID);
                
                ?>
                <div class="panel">
                <?php 
                    echo "<div class='col-lg-4'>
                            <img src='uploads/profilePictures/$ch_username.jpg'  style='width:75%' onError=this.src='img/default.gif' class='img-circle img-responsive'>
                        </div>";
                    $about_author = mysqli_query($db_handle, "SELECT about_user FROM about_users WHERE user_id = $challengeSearch_user_ID;");
                    $no_data = mysqli_num_rows($about_author);
                    if ($no_data == 0){
                        echo "<div class='panel-body'>
                            <span class='color strong' style= 'color :lightblue;'>
                                    <a href ='profile.php?username=" . $ch_username . "'>"
                                    .ucfirst($challengeSearch_first) . '&nbsp' . ucfirst($challengeSearch_last) . " 
                                    </a>
                            </span><br>
                                No information is available about this user
                            </div>";
                    } else {
                        $about_authorRow = mysqli_fetch_array($about_author);
                        echo "<div class='panel-body'>
                                <span class='color strong' style= 'color :lightblue;'>
                                    <a href ='profile.php?username=" . $ch_username . "'>"
                                    .ucfirst($challengeSearch_first) . '&nbsp' . ucfirst($challengeSearch_last) . " 
                                    </a>
                            </span><br>";
                                    echo $about_authorRow['about_user'];
                        echo "</div>";
                    }
                ?>  
                    </div>
                </div>
        <div class="col-md-3">
           <?php 
                echo "<div class='bs-component'>
                        <font size='4'><h3 class='panel-title'><p> Explore more </p></h3></font><hr>";
                $challenge_user = mysqli_query($db_handle, "(SELECT DISTINCT challenge_id, challenge_title, LEFT(stmt, 200) as stmt FROM challenges 
                                                        WHERE challenge_type != '2' AND (challenge_status !='3' AND challenge_status != '7') AND challenge_id != $challengeSearchID AND blob_id = '0')  
                                                    UNION 
                                                    (SELECT DISTINCT a.challenge_id, a.challenge_title, LEFT(b.stmt, 200) as stmt FROM challenges as a JOIN blobs as b 
                                                        WHERE a.blob_id = b.blob_id AND challenge_type != '2' AND (challenge_status !='3' AND challenge_status != '7') AND challenge_id != $challengeSearchID) ORDER BY rand() LIMIT 10 ;");
                while($challenge_userRow = mysqli_fetch_array($challenge_user)) {
                    $challenge_user_chID = $challenge_userRow['challenge_id'];
                    $challenge_user_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $challenge_userRow['challenge_title'])));
                    $challenge_user_stmt = $stmt_task = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $challenge_userRow['stmt'])));
                    //echo $challenge_user_stmt;
                    echo "<p style='white-space: pre-line;height: 20px; font-size:14px;'><b>
                    <a href='challengesOpen.php?challenge_id=$challenge_user_chID'>".ucfirst($challenge_user_title)."</a></b><br></p>";
                    if (substr($challenge_user_stmt, 0, 4) == "<img") {
                        $arrayStmt = explode(">", $challenge_user_stmt);
                        echo $arrayStmt[1]."<br>";
                    } else {
                        echo $challenge_user_stmt."<br>";
                    }
                }
                echo "<br><hr><font size='4'><h3 class='panel-title'><p>Projects</p></h3></font><hr>";
                $projects = mysqli_query($db_handle, "(SELECT DISTINCT project_id, project_title, LEFT(stmt, 200) as stmt FROM projects 
                                                        WHERE project_type = '1' AND blob_id = '0')  
                                                    UNION 
                                                    (SELECT DISTINCT a.project_id, a.project_title, LEFT(b.stmt, 200) as stmt FROM projects as a JOIN blobs as b 
                                                        WHERE a.blob_id = b.blob_id AND project_type= '1') ORDER BY rand() LIMIT 3 ;");
                while($projectsRow = mysqli_fetch_array($projects)) {
                    $project_id = $projectsRow['project_id'];
                    $project_title_display = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $projectsRow['project_title'])));
                    $project_title_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $projectsRow['stmt']))); 
                echo "<p style='white-space: pre-line;height: 20px; font-size:14px;'><b>
                    <a href='project.php?project_id=".$project_id."'>"
                    .ucfirst($project_title_display)."</a></b></p>"
                    .$project_title_stmt."<br>";
                }
            ?>
            
            </div>
    </div>
       </div>
      <?php include_once 'html_comp/signup.php' ; ?>
        <?php include_once 'lib/html_inc_footers.php'; ?>
        <?php include_once 'html_comp/login_signup_modal.php'; ?>
       
    </body>
</html>
