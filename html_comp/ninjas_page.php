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
		<p style="color: grey;"><I>Please Select Post Type From Above ......</I></p>
        <div id='challegeForm'>
            <form>

                <input type="text" class="form-control" id="challange_title" placeholder="Challenge Tilte"/><br/>
                <input id="_fileChallenge" class="btn btn-primary" type="file" title="Upload Photo" label="Add photos to your post" style ="width: auto;">
                <br/>
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
                    <input type="checkbox" id="Chall_type" value='off' /> Always Open<br/>
                    </div><br/>
                    <input id="submit_ch" class="btn btn-primary" type="button" value="Create Challange"/>
               </form>
        </div>
        <div id='ArticleForm'>
            <input type='text' class="form-control" id="article_title" placeholder="Title"/><br>
            <input class="btn btn-default btn-sm" type="file" id="_fileArticle" style ="width: auto;">
            <textarea rows="3" class="form-control" id="articlech" placeholder="article"></textarea><br><br>
            <input type="submit" value="Post" class="btn btn-success" id="create_article"/>
        </div>
        <div id='PictureForm'>
            <input type='text' class="form-control" id="picture_title" placeholder="Title"/><br>
            <input class="btn btn-default btn-sm" type="file" id="_filePhotos" style ="width: auto;">
            <textarea rows="3" class="form-control" id="picturech" placeholder="About picture"></textarea><br><br>
            <input type="button" value="Post" class="btn btn-success" id="create_picture"/>
        </div>
        <div id='VideoForm'>
            <input type='text' class="form-control" id="video_title" placeholder="Title"/><br>
            <input type='text' class="form-control" id="videosub" placeholder="Add Youtube URL"><br>
            <textarea rows="3" class="form-control" id="videodes" placeholder="About Video"></textarea><br><br>
            <input type="button" value="Post" class="btn btn-success" id="create_video"/>
        </div>
        <div id='IdeaForm'>
            <input type='text' class="form-control" id="idea_titleA" placeholder="Title"/><br>
            <input class="btn btn-default btn-sm" type="file" id="_fileIdea" style ="width: auto;">
            <textarea rows="3" class="form-control" id="ideaA" placeholder="About Idea"></textarea><br><br>
            <input type="submit" value="Post" class="btn btn-success" id="create_idea"/>
        </div><br/>
    </div></div>
<?php
$open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.challenge_creation, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b where a.challenge_type != '2' and a.challenge_type != '5' and a.challenge_type != '6' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE a.challenge_type != '2' and a.challenge_type != '5' and a.challenge_type != '6' and a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											 ORDER BY challenge_creation DESC LIMIT 0, 10;");
$_SESSION['lastpanel'] = '10';
while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
    $chelange = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['stmt'])));
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
    $ownedby = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, a.time, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
    $ownedbyrow = mysqli_fetch_array($ownedby);
    $owneta = $ownedbyrow['comp_ch_ETA'];
    $owntime = $ownedbyrow['ownership_creation'];
    $owntimecom = $ownedbyrow['time'];
    $timecomm = date("j F, g:i a", strtotime($owntimecom));
    $timefunct = date("j F, g:i a", strtotime($owntime));
    $ownfname = $ownedbyrow['first_name'];
    $ownlname = $ownedbyrow['last_name'];
    $ownuser = $ownedbyrow['user_id'];
    $ownname = $ownedbyrow['username'];
    $initialtimen = strtotime($owntime) ;
	$endtimen = strtotime($owntimecom) ;
	$time_taken = ($endtimen-$initialtimen)/60 ;
	
    $timetakennin = eta($time_taken);
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
            
            if ($remaintime != "Closed") {
                echo "<form method='POST' class='inline-form pull-right'>
                                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                                </form>
                                <br> " . $timefunction . "<br> ETA : " . $sutime . "<br/>" . $remaintime;
            } else {
                echo " <br> " . $timefunction."<br>Closed";
            }
                    echo "</div>
                    </div>";
        } 
        if ($status == 2) {
            echo "<div class='list-group challenge'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "
                                </div>
                                <div class='col-md-5'>    
                                    Accepted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br/> Time Remaining : " . $remaintimeown ."<br>
                                </div>
                                <div class='col-md-2 pull-right'>";
            dropDown_delete_after_accept($db_handle, $chelangeid, $user_id);
          if($ownuser == $user_id) {			
			echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
                                <input type='hidden' name='id' value='".$chelangeid."'/>
                                <input class='btn btn-primary btn-sm' type='submit' name='submitchlnin' value='Submit'/>
                            </form>";
        }
                    
			echo "</div>
                            </div>
                            </div>
                        </div>" ;	
        }
        if ($status == 4) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix' >     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div class='row' style='line-height: 16.50px;'>
                            <div class='col-md-3'>
                                <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/>
                            </div>
                            <div class='col-md-5'>
                                Submitted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> " . $timecomm . "<br/>
                                ETA Taken : " . $timeo ."
                            </div>";
          if($ch_id == $user_id) {			
                echo "<div class='col-md-2 pull-right'>
                        <form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                            <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                            <button type='submit' class='btn-primary' name='closechal'>Close</button>
                        </form>
                    </div>";
            }
            dropDown_delete_after_accept($db_handle, $chelangeid, $user_id);
                echo "</div>
                    </div>" ;	
        }
        if ($status == 5) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br> " . $timefunction . "<br/> ETA Given : " . $timeo . "
                                </div>
                                <div class='col-md-5'>
                                    Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> Submitted On : " . $timecomm . "<br/>
                                    ETA Taken : " . $timetakennin . "
                                </div>
                                <div class='col-md-1 pull-right'>";
                                dropDown_delete_after_accept($db_handle, $chelangeid, $user_id);
                            echo "</div>
                                </div></div>
                    </div>" ;	
            }
    } 
     if ($ctype == 7) {
        echo "<div class='list-group articlesch'>
				<div class='list-group-item' style='line-height: 24.50px;'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-book'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>";
        dropDown_delete_article($db_handle, $chelangeid, $user_id);
                            echo "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                                    <br> " . $timefunction . "<br/>
                                </div>";
    }
    if ($ctype == 8) {
        echo "<div class='list-group film'>
				<div class='list-group-item' style='line-height: 24.50px;'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-film'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>";
        dropDown_delete_article($db_handle, $chelangeid, $user_id);
                            echo "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                                    <br> " . $timefunction . "<br/>
                                </div>";
    } 
     if ($ctype == 4) {
        echo "<div class='list-group idea'>
                        <div class='list-group-item' style='line-height: 16.50px;'></span>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-flash'></span>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>";
        dropDown_delete_idea($db_handle, $chelangeid, $user_id);
                    echo "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                        .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/>
                        <div class='row'>
                            <div class='col-md-8'>
                                <p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>IDEA</b></p>
                            </div>
                        </div>
                    </div>";
    } 
    if ($ctype == 3) {
		if ($status == 1) {
        echo "<div class='list-group challenge'>
                <div class='list-group-item' >
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-question-sign'>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' 
                        style='width: 50px; height: 50px'></span>
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>" . $timefunction ;
        dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
        if ($ch_id != $user_id) {
            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                    <input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
                </form>" ;
			}
        else {
            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                    <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                    <button type='submit' class='btn-primary' name='closechallenge'>Close</button>
                </form>";
        }
        echo "</div>";
	}	
		if ($status == 6) {
        echo "<div class='list-group film'>
                <div class='list-group-item' >
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-picture'>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' 
                        style='width: 50px; height: 50px'></span>
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/> " . $timefunction ;
        dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
        echo "<p align='center' style='font-size: 14pt; color :#3B5998;'  >Photo</p></div>";
	}
        if ($status == 2) {
			echo "<div class='list-group challenge'>
                <div class='list-group-item' >
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-question-sign'>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>" . $timefunction ;
        $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
         if ($ch_id != $user_id ) {
			 if(mysqli_num_rows($owneduser) == 0){
            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                    <input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
                </form>" ;
			}
		}
        else {
            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                    <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                    <button type='submit' class='btn-primary' name='closechallenge'>Close</button>
                </form>";
        }
           echo "</div>";
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
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span><br/>" . $timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
                            <input type='hidden' name='id' value='" . $chelangeid . "'/>
                            <input class='btn btn-primary btn-sm' type='submit' name='submitchlnin' value='Submit'/>
                        </form>";
                }
                echo "</div>";
            }
        }
        if ($status == 4) {
			echo "<div class='list-group challenge'>
                <div class='list-group-item' >
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-question-sign'>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>" . $timefunction ;
        $owneduser = mysqli_query($db_handle, "SELECT user_id from challenge_ownership where challenge_id = '$chelangeid' and user_id = '$user_id' ;");
         if ($ch_id != $user_id ) {
			 if(mysqli_num_rows($owneduser) == 0){
            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                    <input class='btn btn-primary btn-sm' type='submit' name='accept_pub' value='Accept'/>
                </form>" ;
			}
		}
        else {
            echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Really Close Challenge !!!')\">
                    <input type='hidden' name='cid' value='" . $chelangeid . "'/>
                    <button type='submit' class='btn-primary' name='closechallenge'>Close</button>
                </form>";
        }
           echo "</div>";
            $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.status, a.comp_ch_ETA, a.time, a.ownership_creation, b.first_name, b.last_name,b.username
                                                from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
            while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                $owtime = $ownedbrow['ownership_creation'];
                $owtimesub = $ownedbrow['time'];
                $timfunct = date("j F, g:i a", strtotime($owtime));
                $owtimesubmit = date("j F, g:i a", strtotime($owtimesub));
                $owfname = $ownedbrow['first_name'];
                $owlstatus = $ownedbrow['status'];
                $owlname = $ownedbrow['last_name'];
                $owname = $ownedbrow['username'];
                $initialtimen = strtotime($owtime) ;
				$endtimen = strtotime($owtimesub) ;
				$time_taken = ($endtimen-$initialtimen)/60 ;
				$timetakennin = eta($time_taken);
              if  ($owlstatus==1){
                echo "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span><br/>" . $timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
                            <input type='hidden' name='id' value='" . $chelangeid . "'/>
                            <input class='btn btn-primary btn-sm' type='submit' name='submitchlnin' value='Submit'/>
                        </form>";
                }
                echo "</div>";
			}
			 if  ($owlstatus==2){
                echo "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a></span><br/>" . $timfunct."<br/> Submitted on : " .$owtimesubmit." and Time
                 Taken : ".$timetakennin."</div>";
			}
            }
        }
        if ($status == 5) {
			echo "<div class='list-group openchalhide'>
                <div class='list-group-item' >
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-flag'>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>" . $timefunction."</div>";
            $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.status, a.comp_ch_ETA, a.time, a.ownership_creation, b.first_name, b.last_name,b.username
                                                from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
            while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                $owtime = $ownedbrow['ownership_creation'];
                $owtimesub = $ownedbrow['time'];
                $timfunct = date("j F, g:i a", strtotime($owtime));
                $owtimesubmit = date("j F, g:i a", strtotime($owtimesub));
                $owfname = $ownedbrow['first_name'];
                $owlstatus = $ownedbrow['status'];
                $owlname = $ownedbrow['last_name'];
                $owname = $ownedbrow['username'];
                $initialtimen = strtotime($owtime) ;
				$endtimen = strtotime($owtimesub) ;
				$time_taken = ($endtimen-$initialtimen)/60 ;
				$timetakennin = eta($time_taken);
              if  ($owlstatus==1){
                echo "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span><br/>" . $timfunct;
                if ($ownedbrow['user_id'] == $user_id ) {
                    echo "<form method='POST' class='inline-form pull-right' onsubmit=\"return confirm('Completed Challenge !!!')\">
                            <input type='hidden' name='id' value='" . $chelangeid . "'/>
                            <input class='btn btn-primary btn-sm' type='submit' name='submitchlnin' value='Submit'/>
                        </form>";
                }
                echo "</div>";
			}
			 if  ($owlstatus==2){
                echo "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a></span><br/>" . $timfunct."<br/> Submitted on : " .$owtimesubmit." and Time
                 Taken : ".$timetakennin."</div>";
			}
            }
        }
    
    }
    echo "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>" . ucfirst($ch_title) . "</b></p>
			<br/>" .$chelange . "<br/><br/>";
    if ($status == 4 || $status == 5) {
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
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' name='own_ch_response'
                             placeholder='Whats on your mind about this'/>
                            <button type='submit' class='btn-sm btn-primary glyphicon glyphicon-chevron-right' name='own_chl_response' ></button>
                        </form>
                    </div>";
    echo "</div> </div> ";
}
?>
