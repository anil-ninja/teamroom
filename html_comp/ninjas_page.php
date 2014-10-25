<div class='list-group'>
    <div class='list-group-item'>
        <span class="glyphicon glyphicon-question-sign" id='challenge' style="cursor: pointer"> Challenge</span>
        &nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-book" id='artical' style="cursor: pointer"> Article</span>
        &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-picture" id='picture' style="cursor: pointer"> Photos</span>
        &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-film" id='video' style="cursor: pointer"> Videos</span>
        &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-flash" id='idea' style="cursor: pointer"> Ideas</span></div>
    <div class='list-group-item'>
        <div id='challegeForm'>
            <form>
                <input type="text" class="form-control" id="challange_title" placeholder="Challenge Tilte"/>
                <br>
                <textarea rows="3" class="form-control" placeholder="Details" id='challange'></textarea>
                <br>
                <div class="inline-form">
                    Challenge Open For 
                    <select class="btn-info btn-xs"  id= "open_time" >	
                        <option value='0' selected >hour</option>
                        <?php
                        $o = 1;
                        while ($o <= 24) {
                            echo "<option value='" . $o . "' >" . $o . "</option>";
                            $o++;
                        }
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "open" >	
                        <option value='10' selected >minute</option>
                        <option value='20'  >20</option>
                        <option value='30' >30</option>
                        <option value='40'  >40</option>
                        <option value='50' >50</option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ETA
                    <select class="btn-info btn-xs" id= "c_eta" >	
                        <option value='0' selected >Month</option>
                        <?php
                        $m = 1;
                        while ($m <= 11) {
                            echo "<option value='" . $m . "' >" . $m . "</option>";
                            $m++;
                        }
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "c_etab" >	
                        <option value='0' selected >Days</option>
                        <?php
                        $d = 1;
                        while ($d <= 30) {
                            echo "<option value='" . $d . "' >" . $d . "</option>";
                            $d++;
                        }
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "c_etac" >	
                        <option value='0' selected >hours</option>
                        <?php
                        $h = 1;
                        while ($h <= 23) {
                            echo "<option value='" . $h . "' >" . $h . "</option>";
                            $h++;
                        }
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "c_etad" >	
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select><br/><br/> 
                    <input type="checkbox" id="Chall_type" value='off' /> Always Open<br/><br/>                          
                    <input id="submit_ch" class="btn btn-primary" type="button" value="Create Challange"/>
                </div>
            </form>
        </div>
        <div id='ArticleForm'>
            <input type='text' class="form-control" id="article_title" placeholder="Title"/><br>
            <textarea rows="3" class="form-control" id="article" placeholder="article"></textarea><br><br>
            <input type="submit" value="Post" class="btn btn-success" id="create_article"/>
        </div>
        <div id='PictureForm'>
            <input type='text' class="form-control" id="picture_title" placeholder="Title"/><br>
            <textarea rows="3" class="form-control" id="picture" placeholder="picture"></textarea><br><br>
            <input type="button" value="Post" class="btn btn-success" id="create_picture"/>
        </div>
        <div id='VideoForm'>
            <input type='text' class="form-control" id="article_title" placeholder="Title"/><br>
            <textarea rows="3" class="form-control" id="article" placeholder="Add Youtube URL"></textarea><br><br>
            <input type="button" value="Post" class="btn btn-success" id="create_article"/>
        </div>
        <div id='IdeaForm'>
            <input type='text' class="form-control" id="idea_titleA" placeholder="Title"/><br>
            <textarea rows="3" class="form-control" id="ideaA" placeholder="About Idea"></textarea><br><br>
            <input type="submit" value="Post" class="btn btn-success" id="create_idea"/>
        </div><br/>
    </div></div>
<?php
$open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.username from challenges as a join user_info as b where (a.challenge_type = '1' or a.challenge_type = '9' or a.challenge_type = '10' or a.challenge_type = '11')
                                             and blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE (a.challenge_type = '1' or a.challenge_type = '9' or a.challenge_type = '10' or a.challenge_type = '11') and a.blob_id = c.blob_id and a.user_id = b.user_id )
											 ORDER BY challenge_creation DESC LIMIT 0, 10;");
$_SESSION['lastpanel'] = '10';
while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
    $chelange = str_replace("<s>", "&nbsp;", $open_chalangerow['stmt']);
    $ETA = $open_chalangerow['challenge_ETA'];
    $ch_title = $open_chalangerow['challenge_title'];
    $ch_id = $open_chalangerow['user_id'];
    $ctype = $open_chalangerow['challenge_type'];
    $frstname = $open_chalangerow['first_name'];
    $lstname = $open_chalangerow['last_name'];
    $username_ch_ninjas = $open_chalangerow['username'];
    $chelangeid = $open_chalangerow['challenge_id'];
    $status = $open_chalangerow['challenge_status'];
    $times = $open_chalangerow['challenge_creation'];
    $timefunction = date("j F, g:i a", strtotime($times));
    $timeopen = $open_chalangerow['challenge_open_time'];
    $sutime = eta($ETA);
    $remaintime = remaining_time($times, $ETA);
    $ownedby = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
    $ownedbyrow = mysqli_fetch_array($ownedby);
    $owneta = $ownedbyrow['comp_ch_ETA'];
    $owntime = $ownedbyrow['ownership_creation'];
    $timefunct = date("j F, g:i a", strtotime($owntime));
    $ownfname = $ownedbyrow['first_name'];
    $ownlname = $ownedbyrow['last_name'];
    $ownname = $ownedbyrow['username'];
    $timeo = eta($owneta);
    $remaintimeown = remaining_time($owntime, $owneta);

    if ($ctype == 1) {
        if ($status == 1) {
            echo "<div class='list-group challenge'>
                        <div class='list-group-item'>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-question-sign'></span>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>
                                <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
            . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a>
                                </span>";
            dropDown_challenge($db_handle, $chelangeid, $user_id, $remaintime);
            echo "<form method='POST' class='inline-form pull-right'>
                                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                                </form>
                                <br> " . $timefunction . "&nbsp&nbsp&nbsp";
            if ($remaintime != "Closed") {
                echo "with ETA : " . $sutime . "<br/>" . $remaintime;
            } else {
                echo "<br>Closed";
            }
            echo "</div>
                       </div>";
        } else {
            echo "<div class='list-group challenge'>
				<div class='list-group-item' >
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-question-sign'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>
                                    <div style='line-height: 16.50px;'>
                                        <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
            . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>&nbsp&nbsp On : " . $timefunction . "<br/>
                                        Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
            . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>&nbsp&nbsp On : " . $timefunct . " and
                                        ETA Taken : " . $timeo . " <br/> Time Remaining : " . $remaintimeown . "
                                    </div>
                                </div>";
        }
    } else if ($ctype == 9) {
        echo "<div class='list-group articlesch'>
				<div class='list-group-item' style='line-height: 24.50px;'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-globe'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>
        
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                                        <br> " . $timefunction . "<br/>
                                </div>";
    } else if ($ctype == 11) {
        echo "<div class='list-group idea'>
                        <div class='list-group-item' ></span>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-book'>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>	
                        Purposed by &nbsp
                        <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>&nbsp&nbsp On : " . $timefunction . "<br/>
                        <p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>IDEA</b></p></div>";
    } else {

        echo "<div class='list-group openchalhide'>
				<div class='list-group-item' >
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-question-sign'>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>";
        dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
        if ($status != 5 && $ch_id != $user_id) {
            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
						<input type='hidden' name='id' value='" . $chelangeid . "'/>
						<input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
					</form>
				 &nbsp&nbsp&nbsp On : " . $timefunction . "</div>";
        }
        if ($ch_id == $user_id) {
            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
				   <input type='hidden' name='cid' value='" . $chelangeid . "'/>
				   <button type='submit' class='btn-primary' name='closechal'>Close</button></form></div>";
        }
        if ($status == 3) {
            $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
            while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                $owtime = $ownedbrow['ownership_creation'];
                $timfunct = date("j F, g:i a", strtotime($owtime));
                $owfname = $ownedbrow['first_name'];
                $owlname = $ownedbrow['last_name'];
                $owname = $ownedbrow['username'];
                echo "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span>&nbsp&nbsp On : " . $timfunct;
                if ($ownedbrow['user_id'] == $user_id && $status != 5) {
                    echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
					<input type='hidden' name='id' value='" . $chelangeid . "'/>
					<input class='btn btn-primary btn-sm' type='submit' name='submitchl' value='Submit'/>
					</form>";
                }
                echo "</div>";
            }
        }
    }
    echo "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>" . ucfirst($ch_title) . "</b></p><br/>" .
    $chelange . "<br/><br/>";
    if ($ctype == 9 && $status == 4) {
        $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$chelangeid' and blob_id = '0' and status = '2')
												UNION
												(select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$chelangeid' and a.status = '2' and a.blob_id = b.blob_id);");
        while ($answerrow = mysqli_fetch_array($answer)) {
            echo "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
				<p align='center'>Answer</p></span>"
            . $answerrow['stmt'] . "<br/>";
        }
    }
    $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
													JOIN user_info as b WHERE a.challenge_id = $chelangeid AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$chelangeid' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
    while ($commenterRow = mysqli_fetch_array($commenter)) {
        $comment_id = $commenterRow['response_ch_id'];
        $challenge_ID = $commenterRow['challenge_id'];
        $username_comment_ninjas = $commenterRow['username'];
        echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp&nbsp&nbsp" . $commenterRow['stmt'];
        dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
        echo "</div></div></div>";
    }
    echo "<div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                        <form action='' method='POST' class='inline-form'>
                            <input type='hidden' value='" . $chelangeid . "' name='own_challen_id' />
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 87.0%; height: 30px;' name='own_ch_response'
                             placeholder='Whats on your mind about this'/>
                            <button type='submit' class='btn-sm btn-primary glyphicon glyphicon-chevron-right' name='own_chl_response' ></button>
                        </form>
                    </div>";
    echo "</div> </div> ";
}
?>
