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
        <meta name="author" content="<?= $obj->first_name.$obj->last_name; ?>" />
        <meta name="copyright" content="true" />
        <meta name="application-name" content="Article" />

        <!-- for Facebook -->          
        <meta property="og:title" content="<?= $obj->challenge_title; ?>" />
        <meta name="og:author" content="<?= $obj->first_name.$obj->last_name; ?>" />
        <meta property="og:type" content="article"/>
        <?php
			if($obj->video == 0)
				echo "<meta property=\"og:image\" content=\"$obj->url\" />\n";
			else{
				echo "<meta property=\"og:image\" content=\"http://img.youtube.com/vi/".str_replace(' ', '',explode("/embed/", $obj->url)[1])."/hqdefault.jpg\" />";
                echo "<meta property=\"og:video\" 
                                    content=\"http://www.youtube.com/v/"
                                        .explode("/embed/", $obj->url)[1]
                                        ."\" />\n";

            }
        ?>
        <meta property="og:url" content="<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>" />
		<meta property="og:image:type" content="image/jpeg" />

        <meta property="og:description" content="<?= $obj->getDiscription(); ?>" />

        <!-- for Twitter -->          
        <meta name="twitter:card" content="photo" />
        <meta name="twitter:site" content="@collap">
		<meta name="twitter:creator" content="<?= "@".$obj->first_name.$obj->last_name; ?>">
        <meta name="twitter:url" content="<?= "http://collap.com/challengesOpen.php?challenge_id=".$_GET['challenge_id'] ?>" />
        <meta name="twitter:title" content="<?= $obj->challenge_title; ?>" />
        <meta name="twitter:description" content="<?= $obj->getDiscription(); ?>" />
        <meta name="twitter:image" content="<?= $obj->url; ?>" />
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body>
      <?php include_once 'html_comp/navbar_homepage.php'; ?>
        
        <div class="row-fluid" style='margin-top: 50px;'>
            
            <div class="span7 offset1">
                <?php                
                    challenge_display($db_handle, $challengeSearchID);
                ?>
                    <div class="list-group" style="margin: 20px 0px;">
                        <div class="list-group-item">
					<?php
					$data = "" ;
	   $userinfo = mysqli_query($db_handle, "SELECT * from user_info where user_id = '$challengeSearch_user_ID' ;") ;
	   $userinfoRow = mysqli_fetch_array($userinfo) ;
	   $usersFirstname = $userinfoRow['first_name'] ;
	   $usersLastname = $userinfoRow['last_name'] ;
	   $usersUsername = $userinfoRow['username'] ;
	   $usersRank = $userinfoRow['rank'] ;
	   $usersEmail = $userinfoRow['email'] ;
	   $usersPhone = $userinfoRow['contact_no'] ;
	   echo " <div id='demo10' class='row-fluid' style='height:auto;word-wrap: break-word;'>
			<div class='span2' style='margin: 4px 4px 4px 4px;'>
				<img src='uploads/profilePictures/$ch_username.jpg'  style='width:150px; height:150px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
			</div>
			<div class='span9' style=' padding-left:5px;'>
				<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'> 
						<span class='icon-user'></span>
						<strong>
							<a href='profile.php?username=".$usersUsername."' >&nbsp".ucfirst($usersFirstname)." ".ucfirst($usersLastname)."</a>
						</strong>&nbsp;
						<i>(&nbsp;".$usersRank."&nbsp;)</i>
				</div>
				<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
						<span class='icon-envelope' id='email' style='cursor: pointer;'>&nbsp;&nbsp;".$usersEmail."</span>" ;
	  if($usersPhone != 1) {    
			  echo "&nbsp;&nbsp;&nbsp;&nbsp;<span class='icon-phone' id='phone' style='cursor: pointer'>&nbsp;&nbsp;&nbsp;".$usersPhone."</span>";
	  }
	   $usersSkills = mysqli_query($db_handle, "SELECT b.skill_name, a.skill_id from user_skills as a join skill_names as b WHERE 
											a.user_id = '$challengeSearch_user_ID' AND a.skill_id = b.skill_id ;");
	   while($usersSkillsRow = mysqli_fetch_array($usersSkills)) {
		  $usersSkillname = $usersSkillsRow['skill_name'] ;
		  $usersSkillid = $usersSkillsRow['skill_id'] ;
			$data .= "<span class='btn-success'>
						<a href='ninjaSkills.php?skill_id=".$usersSkillid."' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".$usersSkillname."</a>&nbsp
					  </span>&nbsp;";
	   }
	   $usersAbout = mysqli_query($db_handle, "SELECT * FROM about_users WHERE user_id = '$challengeSearch_user_ID' ;") ;
	   $usersAboutRow = mysqli_fetch_array($usersAbout);
	   if (mysqli_num_rows($usersAbout) != 0) {
		echo "</div>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
					<span class='icon-briefcase'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['organisation_name']."&nbsp;&nbsp;&nbsp;&nbsp;
					<span class='icon-home'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['living_town']."
			</div><br/>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
				<i class='icon-screenshot'></i>Skills &nbsp;: &nbsp; ".$data."
			</div><br/>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
				<span class='icon-comment'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['about_user']."
			</div>" ;
		}
		else {
			echo "</div>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
					<span class='icon-briefcase'></span>&nbsp;&nbsp;&nbsp;No Information Available &nbsp;&nbsp;&nbsp;&nbsp;
					<span class='icon-home'></span>&nbsp;&nbsp;&nbsp;No Information Available
			</div><br/>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
				<i class='icon-screenshot'></i>Skills &nbsp;: &nbsp; ".$data."
			</div><br/>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
				<span class='icon-comment'></span>&nbsp;&nbsp;&nbsp;No Information Available
			</div>";
		}
	echo "</div>
		  </div><br/>" ;
              ?> 
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll" style="margin: 20px -15px;">
                    <ul class="nav nav-tabs">
                        <li class="active" >
                            <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Explore More </b></span></a>
                        </li>
                    </ul>
                    <div class="tab-content" >
                        <div role="tabpanel" class="row tab-pane active">
                <?php 
                    $challenge_user = mysqli_query($db_handle, "(SELECT DISTINCT challenge_id, challenge_title, LEFT(stmt, 250) as stmt FROM challenges 
                                                            WHERE challenge_type != '2' and challenge_type != '5' AND challenge_status !='3' AND challenge_status != '7' AND 
                                                            challenge_id != $challengeSearchID AND blob_id = '0')  
    														UNION 
    														(SELECT DISTINCT a.challenge_id, a.challenge_title, LEFT(b.stmt, 250) as stmt FROM challenges as a JOIN blobs as b 
    														WHERE a.blob_id = b.blob_id  and challenge_type != '5' AND a.challenge_type != '2' AND a.challenge_status !='3' AND a.challenge_status != '7'
    														AND a.challenge_id != $challengeSearchID) ORDER BY rand() LIMIT 10 ;");
                    while($challenge_userRow = mysqli_fetch_array($challenge_user)) {
                        $challenge_user_chID = $challenge_userRow['challenge_id'];
                        $challenge_user_title = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $challenge_userRow['challenge_title']))));
                        $challenge_user_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $challenge_userRow['stmt']))));
                        echo "
                            <div class ='row' style='border-width: 1px; border-style: solid;margin: 4px 0px 4px 0px;background : rgb(240, 241, 242); color:rgba(69, 69, 69, 0);'>
    							<a href='challengesOpen.php?challenge_id=$challenge_user_chID'>
                                    <b>
                                        <p style='font-family: Sans-serif; font-size:14px; word-wrap: break-word;color:#3B5998;'>"
                                            .ucfirst($challenge_user_title)."
                                        </p>
                                    </b>
                                    <p style='word-wrap: break-word;'>"
                                        .$challenge_user_stmt."
                                    </p>
                                </a>
                            </div>";
    				}
                    echo "
                        </div>
                    </div>
                </div>
           
                <div class='tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll' style='margin: 20px -15px;'>
                    <ul class='nav nav-tabs'>
                        <li class='active' >
                            <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Explore Public Pojects </b></span></a>
                        </li>
                    </ul>
                    <div class='tab-content' >
                        <div role='tabpanel' class='row tab-pane active'>
                            <div>";
                    $projects = mysqli_query($db_handle, "(SELECT DISTINCT project_id, project_title, LEFT(stmt, 250) as stmt FROM projects 
                                                            WHERE project_type = '1' AND blob_id = '0')  
                                                        UNION 
                                                        (SELECT DISTINCT a.project_id, a.project_title, LEFT(b.stmt, 250) as stmt FROM projects as a JOIN blobs as b 
                                                            WHERE a.blob_id = b.blob_id AND project_type= '1' ) ORDER BY rand() LIMIT 3 ;");
                    while($projectsRow = mysqli_fetch_array($projects)) {
                        $project_id = $projectsRow['project_id'];
                        $project_title_display = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $projectsRow['project_title']))));
                        $project_title_stmt = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $projectsRow['stmt'])))); 
                    echo "  
                            <div class ='row' style='border-width: 1px; border-style: solid;margin: 4px 0px 4px 0px;background : rgb(240, 241, 242); color:rgba(69, 69, 69, 0);'>
    						    <a href='project.php?project_id=".$project_id."'>
                                    <div class='panel-heading' style='padding-left: 0px;'>
                                        <b> 
                                            <p style='font-family: Sans-serif; font-size:14px;word-wrap: break-word;color:#3B5998;'>"
    							                .ucfirst($project_title_display)."
                                            </p>
                                        </b>
                                    </div>
                                    <div class='panel-content'>
                                        <p style='word-wrap: break-word;'>"
                                            .$project_title_stmt."....
                                        </p><br>
                                    </div>
                                </a>
    					    </div>";
                    }
                    echo "
                        </div>";
                ?>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <?php
 echo "<div class='span8 offset1'>
		<div class='panel-body' style=' margin:4px; background : rgb(240, 241, 242);'>
		<p>
		  <a href='www.dpower4.com' target = '_blank' ><b>Powered By: </b> Dpower4</a></p>
		 <p>Making World a Better Place, because Heritage is what we pass on to the Next Generation.</p>
	   </div>
	   </div>" ;
			if(isset($_SESSION['user_id'])) {
				include_once 'html_comp/friends.php';
				}
		?>
        
      <?php include_once 'html_comp/signup.php' ; 
         include_once 'lib/html_inc_footers.php'; 
         include_once 'html_comp/check.php';
         include_once 'html_comp/login_signup_modal.php'; ?>
        <script>
            $(".text").show();
            $(".editbox").hide();
            $(".editbox").mouseup(function(){
            return false
            });
            </script>
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54a9978c1d02a7b3" async="async"></script>
            <?php include_once 'html_comp/insert_time.php'; ?>
    </body>
</html>
