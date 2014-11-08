<?php

function user_articles ($db_handle, $user_id) {
    $user_articles_display = mysqli_query($db_handle, "(SELECT challenge_id, challenge_title, LEFT(stmt, 500) as stmt FROM challenges WHERE challenge_type=7 AND user_id=$user_id AND (challenge_status!=3 OR challenge_status!=7) AND blob_id=0)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, LEFT(b.stmt, 500) as stmt FROM challenges as a JOIN blobs as b WHERE a.challenge_type=7 AND a.user_id=$user_id AND (a.challenge_status!=3 OR a.challenge_status!=7) AND a.blob_id=b.blob_id) ORDER BY challenge_id DESC;");
    while($user_articles_displayRow= mysqli_fetch_array($user_articles_display)) {
        $article_id=$user_articles_displayRow['challenge_id'];
        $article_title = $user_articles_displayRow['challenge_title'];
        $article_stmt = $user_articles_displayRow['stmt'];
        echo "<div class='col-md-12 text-left list-group-item'>
               <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$article_id."' target='_blank'><strong> "                          
                        .$article_title.":&nbsp</strong></a>
                <font size=2px>".$article_stmt.".....</font>
             </div>";
    }
}
function user_challenges ($db_handle, $user_id) {
    $user_challenges_display = mysqli_query($db_handle, "(SELECT a.challenge_id,a.challenge_title,b.user_id, LEFT(a.stmt, 200) as stmt FROM challenges as a JOIN challenge_ownership as b WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_id AND b.user_id=$user_id AND (a.challenge_status!=3 OR a.challenge_status!=7) AND a.blob_id=0 AND a.project_id=0)
                                                        UNION
                                                        (SELECT a.challenge_id,a.challenge_title,c.user_id, LEFT(b.stmt, 200) as stmt FROM challenges as a JOIN blobs as b JOIN challenge_ownership as c WHERE (a.challenge_type=1 OR a.challenge_type=3) AND a.user_id=$user_id AND c.user_id=$user_id AND (a.challenge_status!=3 OR a.challenge_status!=7) AND a.blob_id=b.blob_id AND a.project_id=0) ORDER BY challenge_id DESC;");
    while($user_challenges_displayRow= mysqli_fetch_array($user_challenges_display)) {
        $challenge_id=$user_challenges_displayRow['challenge_id'];
        $challenge_title = $user_challenges_displayRow['challenge_title'];
        $challenge_stmt = $user_challenges_displayRow['stmt'];
        $you_owned_or_not = $user_challenges_displayRow['user_id'];
        echo "<div class='col-md-12 text-left list-group-item'>
                 <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$challenge_id."' target='_blank'><strong> "                          
                 .$challenge_title.":&nbsp</strong></a><br/>
                 <font size=2px>"
                 .$challenge_stmt.".....</font>
              </div>";
    }
}
function user_idea ($db_handle, $user_id) {
    $user_idea_display = mysqli_query($db_handle, "(SELECT challenge_id, challenge_title, LEFT(stmt, 200) as stmt FROM challenges WHERE challenge_type=4 AND user_id=$user_id AND (challenge_status!=3 OR challenge_status!=7) AND blob_id=0)
                                                        UNION
                                                        (SELECT a.challenge_id, a.challenge_title, LEFT(b.stmt, 200) as stmt FROM challenges as a JOIN blobs as b WHERE a.challenge_type=4 AND a.user_id=$user_id AND (a.challenge_status!=3 OR a.challenge_status!=7) AND a.blob_id=b.blob_id)ORDER BY challenge_id DESC;");
    while($user_idea_displayRow= mysqli_fetch_array($user_idea_display)) {
        $idea_id= $user_idea_displayRow['challenge_id'];
        $idea_title = $user_idea_displayRow['challenge_title'];
        $idea_stmt = $user_idea_displayRow['stmt'];
         echo "<div class='col-md-12 text-left list-group-item'>
                 <a class='btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$idea_id."' target='_blank'><strong> "                          
                 .$idea_title.":&nbsp</strong></a><br/>
                 <font size=2px>"
                 .$idea_stmt.".....</font>
              </div>";
    }
}
?>