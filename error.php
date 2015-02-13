<?php
include_once 'lib/db_connect.php';
include_once 'functions/image_resize.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>not exists</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Challenges, Projects, Problem solving, problems">
        <meta name="author" content="Rajnish">
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body>
<?php 
    include_once 'html_comp/navbar_homepage.php'; 
?>
        <div class="row-fluid" style='margin-top: 50px;'>
            <div class="span1"></div>
            <div class="span7">
                <?php
                    $top_challenges = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.blob_id, a.challenge_title, a.creation_time, a.challenge_type, a.challenge_status, a.stmt, b.first_name, b.last_name, b.username from challenges as a join user_info as b 
                                        WHERE a.project_id = 0 AND a.challenge_type != 2 AND challenge_type != 5 AND blob_id = '0' AND challenge_status ='1' and a.user_id=b.user_id)
                                    UNION
                                        (SELECT DISTINCT a.challenge_id, a.blob_id, a.challenge_title, a.creation_time, a.challenge_type, a.challenge_status, c.stmt, b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
                                        WHERE a.project_id = 0 AND a.challenge_type != 2 AND challenge_type != 5 AND  challenge_status ='1' AND a.blob_id = c.blob_id and a.user_id=b.user_id ) ORDER BY creation_time DESC LIMIT 10;");
                   while ($top_challengesRow = mysqli_fetch_array($top_challenges)) {
                       $challenge_type_id = $top_challengesRow['challenge_id'];
                       $challenge_type_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $top_challengesRow['challenge_title'])))));
                       $challenge_type_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $top_challengesRow['stmt']))))) ;
                       $challenge_type_first = $top_challengesRow['first_name'];
                       $challenge_type_last = $top_challengesRow['last_name'];
                       $challenge_type_username = $top_challengesRow['username'];
                       $challenge_type_type = $top_challengesRow['challenge_type'];
                       $challenge_type_status = $top_challengesRow['challenge_status'];
                       $challenge_type_time = $top_challengesRow['creation_time'];
                       $time_display = date("j F, g:i a", strtotime($challenge_type_time));
                       
        $display_tilte_ch = "
                <span style='font-family: Tenali Ramakrishna, sans-serif;'><b> 
                    <a style='color:#3B5998;font-size: 26px;' href='challengesOpen.php?challenge_id=".$challenge_type_id."' target='_blank'>"
                        .ucfirst($challenge_type_title)."
                    </a></b>
                </span><br/>";
        $display_fname_likes = "
                            <span style= 'color: #808080'> &nbspBy: 
                                <a href ='profile.php?username=" . $challenge_type_username . "' style= 'color: #808080'>"
                                    .ucfirst($challenge_type_first)." ".ucfirst($challenge_type_last)."
                                </a> | ".$time_display."</span>
                            <hr/><span style='font-size: 14px;'>".$challenge_type_stmt."</span><br/>
                        </div>";
        echo "  <div class='list-group'>";
        if ($challenge_type_type == 1) {
            if ($challenge_type_status == 1 || $challenge_type_status == 2 || $challenge_type_status == 4 || $challenge_type_status == 5) {
                echo "<div class='list-group-item'>";     
                echo $display_tilte_ch."
                        <span class='icon-question-sign'></span>".$display_fname_likes;
            } 
        }
        else if ($challenge_type_type == 7) {
            echo "<div class='list-group-item'>";
            echo $display_tilte_ch."
                        <span class='icon-book'></span>".$display_fname_likes;
        }
        else if ($challenge_type_type == 4) {
            echo "  <div class='list-group-item'>";
            echo $display_tilte_ch."
                        <span class='icon-lightbulb'></span>".$display_fname_likes;
        } 
        else if ($challenge_type_type == 3) {
            echo "  <div class='list-group-item'>";
            echo $display_tilte_ch."
                        <span class='icon-question-sign'></span>".$display_fname_likes;
        }
        echo "  </div>";
        }
        ?>
            </div>
            <div class="span3">
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll" style="margin: 20px -15px;">
                    <ul class="nav nav-tabs">
                        <li class="active" >
                            <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Explore Public Projects </b></span></a>
                        </li>
                    </ul>
                    <div class="tab-content" >
                        <div role="tabpanel" class="row tab-pane active">
            <?php
                $projects = mysqli_query($db_handle, "(SELECT DISTINCT project_id, project_title, LEFT(stmt, 200) as stmt FROM projects 
                                                        WHERE project_type = '1' AND blob_id = '0')  
                                                    UNION 
                                                    (SELECT DISTINCT a.project_id, a.project_title, LEFT(b.stmt, 200) as stmt FROM projects as a JOIN blobs as b 
                                                        WHERE a.blob_id = b.blob_id AND project_type= '1') ORDER BY rand() LIMIT 10 ;");
                while($projectsRow = mysqli_fetch_array($projects)) {
                    $project_id_display = $projectsRow['project_id'];
                    $project_title_display = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", str_replace("<an>", "+",$projectsRow['project_title']))));
                    $project_title_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $projectsRow['stmt']))));
                        echo " 
                            <div class ='row' style='margin: 4px 0px 4px 0px;background : rgb(240, 241, 242);'>
                                <a href='project.php?project_id=$project_id_display'>
                                    <b>
                                        <p style='font-family: Sans-serif; font-size:14px; word-wrap: break-word;color:#3B5998;'>"
                                            .ucfirst($project_title_display)."
                                        </p>
                                    </b>
                                    <p style='word-wrap: break-word;'>"
                                        .$project_title_stmt."
                                    </p>
                                </a>
                            </div>";
                    }
            ?>
                        </div>
                    </div>
                </div>
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll" style="margin: 20px -15px;">
                    <ul class="nav nav-tabs">
                        <li class="active" >
                            <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Top Users</b></span></a>
                        </li>
                    </ul>
                    <div class="tab-content" >
                        <div role="tabpanel" class="row tab-pane active">
            <?php
                //echo "<br><hr><font size='4'><h3 class='panel-title'><p>Top Users</p></h3></font><hr>";
                $top_users = mysqli_query($db_handle, "SELECT first_name, last_name, username FROM user_info ORDER BY rand() LIMIT 10 ;");
                while($top_usersRow = mysqli_fetch_array($top_users)) {
                    $top_user_first = $top_usersRow['first_name'];
                    $top_user_last = $top_usersRow['last_name'];
                    $top_user_username = $top_usersRow['username'];
                    echo "  <div class ='row' style='border-width: 1px; border-style: solid;margin: 4px 0px 4px 0px;background : rgb(240, 241, 242); color:rgba(69, 69, 69, 0);'>
                                <a href ='profile.php?username=" . $top_user_username . "'>
                                    <b>
                                        <p style='font-family: Sans-serif; font-size:14px; word-wrap: break-word;color:#3B5998;'>"
                                            .ucfirst($top_user_first)."&nbsp ".ucfirst($top_user_last)."
                                        </p>
                                    </b>
                                </a>
                            </div>";
                }
            ?>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
 include_once 'html_comp/signup.php' ; 
 include_once 'lib/html_inc_footers.php'; 
 include_once 'html_comp/login_signup_modal.php';
 mysqli_close($db_handle); ?>
<div class='footer'>
		<a href='www.dpower4.com' target = '_blank' ><b>Powered By: </b> Dpower4</a>
		 <p>Making World a Better Place, because Heritage is what we pass on to the Next Generation.</p>
</div>
    </body>
</html>
