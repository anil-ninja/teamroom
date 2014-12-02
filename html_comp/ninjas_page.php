<div class='list-group'>
    <div class='list-group-item' >
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
		<div id='selecttext' ><p style="color: grey;"><I>Please Select Post Type From Above ......</I></p></div>
		<div id='remindervalue'></div>
        <div id='challegeForm'>
            <form>

                <input type="text" class="form-control" id="challange_title" placeholder="Challenge Tilte .."/><br/>
                <input id="_fileChallenge" class="btn btn-default" type="file" title="Upload Photo" label="Add photos to your post" style ="width: auto;">
                <br/>
                <textarea rows="3" class="form-control" placeholder="Description .. " id='challange'></textarea>
                <br>
			<!---	 <div class="inline-form">
                    Challenge Open For 
                    <select class="btn-info btn-xs"  id= "open_time" >	
                        <option value='0' selected >hour</option>
                        <?php  /*
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
                        } */
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "c_etad" >	
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select><br/><br/></div><br/> --->
                    <input type="hidden" id="Chall_type" value='on' /><br/>
                    
                    <input id="submit_ch" class="btn btn-primary" type="button" value="Create Challange"/>
               </form>
        </div>
        <div id='ArticleForm'>
            <input type='text' class="form-control" id="article_title" placeholder="Heading .."/><br>
            <input class="btn btn-default btn-sm" type="file" id="_fileArticle" style ="width: auto;">
            <textarea rows="3" class="form-control" id="articlech" placeholder="Article text.."></textarea><br><br>
            <input type="submit" value="Post" class="btn btn-success" id="create_article"/>
        </div>
        <div id='PictureForm'>
            <input type='text' class="form-control" id="picture_title" placeholder="Picture caption .."/><br>
            <input class="btn btn-default btn-sm" type="file" id="_filePhotos" style ="width: auto;">
            <textarea rows="3" class="form-control" id="picturech" placeholder="Description .."></textarea><br><br>
            <input type="button" value="Post" class="btn btn-success" id="create_picture"/>
        </div>
        <div id='VideoForm'>
            <input type='text' class="form-control" id="video_title" placeholder="Vedio title .."/><br>
            <input type='text' class="form-control" id="videosub" placeholder="Add Youtube URL"><br>
            <textarea rows="3" class="form-control" id="videodes" placeholder="Description.."></textarea><br><br>
            <input type="button" value="Post" class="btn btn-success" id="create_video"/>
        </div>
        <div id='IdeaForm'>
            <input type='text' class="form-control" id="idea_titleA" placeholder="Idea heading .."/><br>
            <input class="btn btn-default btn-sm" type="file" id="_fileIdea" style ="width: auto;">
            <textarea rows="3" class="form-control" id="ideaA" placeholder="Description .."></textarea><br><br>
            <input type="submit" value="Post" class="btn btn-success" id="create_idea"/>
        </div><br/>
    </div></div>
<?php
$open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b where a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE a.project_id='0' and a.challenge_status != '3' and a.challenge_status != '7' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											UNION
											(SELECT DISTINCT a.challenge_id, c.project_title, a.challenge_title, a.challenge_status, a.user_id, 
											a.challenge_ETA, a.challenge_type, a.stmt, a.creation_time, b.first_name, b.last_name, b.username from challenges
										   as a join user_info as b join projects as c where a.project_id = c.project_id and c.project_type='1' and a.challenge_type !='5' and a.challenge_status != '3' and a.challenge_status != '7' 
										   and a.blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, d.project_title, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.challenge_type, c.stmt, a.creation_time,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c join projects as d
											WHERE a.project_id = d.project_id and d.project_type='1' and a.challenge_status != '3' and a.challenge_status != '7' and a.challenge_type !='5' and a.blob_id = c.blob_id and a.user_id = b.user_id )
											 ORDER BY creation_time DESC LIMIT 0, 10;");
$_SESSION['lastpanel'] = '10';
while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
    $chelange = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['stmt'])));
    $ETA = $open_chalangerow['challenge_ETA'];
    $ch_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['challenge_title'])));
    //$pr_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['project_title'])));
    $ch_id = $open_chalangerow['user_id'];
    $ctype = $open_chalangerow['challenge_type'];
    $frstname = $open_chalangerow['first_name'];
    $lstname = $open_chalangerow['last_name'];
    $username_ch_ninjas = $open_chalangerow['username'];
    $chelangeid = $open_chalangerow['challenge_id'];
    $status = $open_chalangerow['challenge_status'];
    $times = $open_chalangerow['creation_time'];
    $timefunction = date("j F, g:i a", strtotime($times));
    $timeopen = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $open_chalangerow['challenge_open_time'])));
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
	$totallikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$chelangeid' and like_status = '1' ;");
	if (mysqli_num_rows($totallikes) > 0) { $likes = mysqli_num_rows($totallikes) ;}
	else { $likes = '' ; }
	$totaldislikes = mysqli_query($db_handle, "SELECT * from likes where challenge_id = '$chelangeid' and like_status = '2' ;");
	if (mysqli_num_rows($totaldislikes) > 0) { $dislikes = mysqli_num_rows($totaldislikes) ;}
	else { $dislikes = '' ; }
    if ($ctype == 1) {
        if ($status == 1) {
            echo "<div class='list-group challenge'>
                        <div class='list-group-item'>
                        <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-question-sign'></span>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>";
            dropDown_challenge($db_handle, $chelangeid, $user_id, $remaintime);
            
            //if ($remaintime != "Closed") {
                echo "<form method='POST' class='inline-form pull-right'>
                                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                                </form>" ;
                                //. $timefunction . "<br> ETA : " . $sutime . "<br/>" . $remaintime;
            //} else {
               // echo " <br> " . $timefunction."<br>Closed";
            //}
                    echo "<br/>" . $timefunction."<br/><br/></div>
                    </div></div></div>";
        } 
        if ($status == 2) {
            echo "<div class='list-group challenge'>
                    <div class='list-group-item' >
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/><br/>
                                </div>
                                <div class='col-md-5'>    
                                    Accepted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>" ;
                                  //  <br/> Time Remaining : " . $remaintimeown ."<br>
                               echo "</div>
                                <div class='col-md-2 pull-right'>";
            dropDown_delete_after_accept($db_handle, $chelangeid, $user_id);
          if($ownuser == $user_id) {			
			echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>" ;
        }
                    
			echo "</div></div></div>
                            </div>
                            </div>
                        </div>" ;	
        }
        if ($status == 4) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                        <div class='pull-left lh-fix' >     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div class='row' style='line-height: 16.50px;'>
                            <div class='col-md-3'>
                                <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/><br/>
                            </div>
                            <div class='col-md-5'>
                                Submitted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> " . $timecomm ;
                                //. "<br/>  ETA Taken : " . $timeo ."
                           echo "</div>";
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
                    </div></div></div>" ;	
        }
        if ($status == 5) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br> " . $timefunction . "<br/><br/>" ;
                                    // ETA Given : " . $timeo . "
                         echo  "</div>
                                <div class='col-md-5'>
                                    Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> Submitted On : " . $timecomm ;
                                    //. "<br/> ETA Taken : " . $timetakennin . "
                               echo "</div>
                                <div class='col-md-1 pull-right'>";
                                dropDown_delete_after_accept($db_handle, $chelangeid, $user_id);
                            echo "</div>
                                </div></div>
                    </div></div></div>" ;	
            }
    } 
    if($ctype == 2) {
	if ($status == 1) {
            echo "<div class='list-group challenge'>
                        <div class='list-group-item'>
                        <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-question-sign'></span>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>
                            <div style='line-height: 16.50px;'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>";
            dropDown_challenge($db_handle, $chelangeid, $user_id, $remaintime);
            
            //if ($remaintime != "Closed") {
                echo "<form method='POST' class='inline-form pull-right'>
                                    <input type='hidden' name='id' value='" . $chelangeid . "'/>
                                    <input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
                                </form>" ;
                                //. $timefunction . "<br> ETA : " . $sutime . "<br/>" . $remaintime;
            //} else {
               // echo " <br> " . $timefunction."<br>Closed";
            //}
                    echo "<br/>" . $timefunction."<br/><br/></div>
                    </div></div></div>";
        } 
        if ($status == 2) {
            echo "<div class='list-group challenge'>
                    <div class='list-group-item' >
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/><br/>
                                </div>
                                <div class='col-md-5'>    
                                    Accepted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span>" ;
                                  //  <br/> Time Remaining : " . $remaintimeown ."<br>
                               echo "</div>
                                <div class='col-md-2 pull-right'>";
            dropDown_delete_after_accept($db_handle, $chelangeid, $user_id);
          if($ownuser == $user_id) {			
			echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>" ;
        }
                    
			echo "</div></div></div>
                            </div>
                            </div>
                        </div>" ;	
        }
        if ($status == 4) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                        <div class='pull-left lh-fix' >     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div class='row' style='line-height: 16.50px;'>
                            <div class='col-md-3'>
                                <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/><br/>
                            </div>
                            <div class='col-md-5'>
                                Submitted By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> " . $timecomm ;
                                //. "<br/>  ETA Taken : " . $timeo ."
                           echo "</div>";
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
                    </div></div></div>" ;	
        }
        if ($status == 5) {
            echo "<div class='list-group openchalhide'>
                    <div class='list-group-item' >
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-flag'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                    . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br> " . $timefunction . "<br/><br/>" ;
                                    // ETA Given : " . $timeo . "
                         echo  "</div>
                                <div class='col-md-5'>
                                    Owned By  <span class='color strong'><a href ='profile.php?username=" . $ownname . "'>"
                                    . ucfirst($ownfname) . '&nbsp' . ucfirst($ownlname) . " </a></span><br> Submitted On : " . $timecomm ;
                                    //. "<br/> ETA Taken : " . $timetakennin . "
                               echo "</div>
                                <div class='col-md-1 pull-right'>";
                                dropDown_delete_after_accept($db_handle, $chelangeid, $user_id);
                            echo "</div>
                                </div></div></div></div>
                    </div>" ;	
            }
       echo "<div class='list-group-item'><p align='center' style='font-size: 14pt;'>Posted in <b>" . ucfirst($timeopen) . "</b></p></div>" ;		
	}
     if ($ctype == 6) {
        echo "<div class='list-group articlesch'>
				<div class='list-group-item' style='line-height: 24.50px;'>
				<div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-plus'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>";
        dropDown_delete_article($db_handle, $chelangeid, $user_id);
                            echo "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                                    <br> " . $timefunction . "<br/>
                                </div></div></div>";
      echo "<div class='list-group-item'><p align='center' style='font-size: 14pt;'>Posted in <b>" . ucfirst($timeopen) . "</b></p></div>" ;
    }
    if ($ctype == 7) {
        echo "<div class='list-group articlesch'>
				<div class='list-group-item' style='line-height: 24.50px;'>
				<div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-book'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>";
        dropDown_delete_article($db_handle, $chelangeid, $user_id);
                            echo "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                                    <br> " . $timefunction . "<br/><br/>
                                </div></div></div>";
    }
    if ($ctype == 8) {
        echo "<div class='list-group film'>
				<div class='list-group-item' style='line-height: 24.50px;'>
				<div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                                    <div class='pull-left lh-fix'>     
                                        <span class='glyphicon glyphicon-film'></span>
                                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                                    </div>";
        dropDown_delete_article($db_handle, $chelangeid, $user_id);
                            echo "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>
                                    <br> " . $timefunction . "<br/><br/>
                                </div></div></div>";
    } 
     if ($ctype == 4) {
        echo "<div class='list-group idea'>
                        <div class='list-group-item' style='line-height: 24.50px;'></span>
                        <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-flash'></span>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                            </div>";
        dropDown_delete_idea($db_handle, $chelangeid, $user_id);
                    echo "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                        .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br>" . $timefunction . "<br/><br/>
                        </div></div></div>";
    } 
    if ($ctype == 3) {
		if ($status == 1) {
        echo "<div class='list-group challenge'>
                <div class='list-group-item' >
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                            <div class='pull-left lh-fix'>     
                                <span class='glyphicon glyphicon-question-sign'>
                                <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' 
                                style='width: 50px; height: 50px'></span>
                            </div>
                            <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span>" ;
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
                echo "<br/>" . $timefunction."<br/><br/>
                    </div>
                </div>
            </div>";
	}	
		if ($status == 6) {
        echo "<div class='list-group film'>
                <div class='list-group-item' style='line-height: 24.50px;'>
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>
                    <div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-picture'>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' 
                        style='width: 50px; height: 50px'></span>
                    </div>";
                    dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
                   echo "<span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/> " . $timefunction."<br/><br/>" ;
        
        echo "</div></div></div>";
	}
        if ($status == 2) {
            echo "<div class='list-group challenge'>
                    <div class='list-group-item'>
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>";
                        dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
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
                    echo "<div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                        .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>" . $timefunction."<br/><br/>" ;
                echo "</div></div></div>";
            $ownedb = mysqli_query($db_handle, "SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
                                                from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;");
            while ($ownedbrow = mysqli_fetch_array($ownedb)) {
                $owtime = $ownedbrow['ownership_creation'];
                $timfunct = date("j F, g:i a", strtotime($owtime));
                $owfname = $ownedbrow['first_name'];
                $owlname = $ownedbrow['last_name'];
                $owname = $ownedbrow['username'];
                echo "<div class='list-group-item'>";
                if ($ownedbrow['user_id'] == $user_id ) {
                    echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>" ;
                }
                echo "Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                    .ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . " </a></span><br/>" . $timfunct;
                echo "</div>";
            }
        }
        if ($status == 4) {
            echo "<div class='list-group challenge'>
                    <div class='list-group-item'>
                    <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>";
                        dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
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
                 echo"<div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-question-sign'></span>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                        .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>" 
                    .$timefunction."<br/><br/>" ;
        echo "</div></div></div>";
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
                    echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>" ;
                }
                echo "</div>";
			}
			 if  ($owlstatus==2){
                echo "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a></span><br/>" . $timfunct."<br/> Submitted on : " .$owtimesubmit ;
                //." and Time Taken : ".$timetakennin."
                echo "</div>";
			}
            }
        }
        if ($status == 5) {
			echo "<div class='list-group openchalhide'>
                <div class='list-group-item' >
                <div class='row'>
                        <div class='col-md-1 pull-left' style='padding-right: 0px; padding-left: 0px; padding-top: 7px;'>
                            <span class='glyphicon glyphicon-hand-up pull-left' style='cursor: pointer;' onclick='like(".$chelangeid .")'><input type='submit' class='btn-link' id='likes_".$chelangeid ."' value='".$likes."'/></span><br/>
                            <span class='glyphicon glyphicon-hand-down pull-left' style='cursor: pointer;' onclick='dislike(".$chelangeid .")'><input type='submit' class='btn-link' id='dislikes_".$chelangeid ."' value='".$dislikes."'/>&nbsp;</span>
                        </div>    
                        <div class='col-md-11'>";
                        dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
                   echo "<div class='pull-left lh-fix'>     
                        <span class='glyphicon glyphicon-flag'></span>
                        <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                    </div>
                    <span class='color strong'><a href ='profile.php?username=" . $username_ch_ninjas . "'>"
        . ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " </a></span><br/>" . $timefunction."<br/><br/></div></div></div>";
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
                    echo "<input class='btn btn-primary btn-sm pull-right' type='submit' onclick='answersubmit(".$chelangeid.")' value='Submit'/>" ;
                }
                echo "</div>";
			}
			 if  ($owlstatus==2){
                echo "<div class='list-group-item'>
                            Owned By  <span class='color strong'><a href ='profile.php?username=" . $owname . "'>"
                . ucfirst($owfname) . '&nbsp' . ucfirst($owlname) . "</a></span><br/>" . $timfunct."<br/> Submitted on : " .$owtimesubmit ;
                //." and Time Taken : ".$timetakennin."
                echo "</div>";
			}
            }
        }
    
    }
    echo "<div class='list-group-item'><p align='center' style='font-size: 14pt;' id='challenge_ti_".$chelangeid."' class='text' ><b>" . ucfirst($ch_title) . "</b></p>
			<br/><span id='challenge_".$chelangeid."' class='text' >".$chelange."</span>
			<input type='text' class='editbox' style='width : 90%;' id='challenge_title_".$chelangeid."' value='".$ch_title."'/>" ;
	if(isset($_SESSION['user_id'])){
		if(substr($chelange, 0, 1) != '<') {
				echo "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
			}
		else {
			if (substr($chelange, 0, 4) == ' <br') {
				echo "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
				}
			if (substr($chelange, 0, 3) == '<s>') {
				echo "<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_".$chelangeid."' >".$chelange."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveedited(".$chelangeid.")' id='doneedit_".$chelangeid."'/>";
				}
			$chaaa = substr(strstr($chelange, '<br/>'), 5) ;
			$cha = strstr($chelange, '<br/>' , true) ;
			if(substr($chelange, 0, 4) == '<img') {
					echo "<div class='editbox' style='width : 90%;' id='challenge_pic_".$chelangeid."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$chelangeid.")' id='pic_file_".$chelangeid."'/><br/><br/>" ;
					}
			if(substr($chelange, 0, 2) == '<a') {
					echo "<div class='editbox' style='width : 90%;' id='challenge_file_".$chelangeid."' >".$cha."</div>
					<input type='submit' class='btn-success btn-xs editbox' value='Update' onclick='upload_pic_file(".$chelangeid.")' id='pic_file_".$chelangeid."'/><br/><br/>" ;
					}
			if(substr($chelange, 0, 3) == '<if') {
					echo "<div class='editbox' style='width : 90%;' id='challenge_video_".$chelangeid."' >".$cha."</div>
					<input type='text' class='editbox' id='url_video_".$chelangeid."' placeholder='Add You-tube URL'/><br/><br/>" ;
					}
			echo "<input id='_fileChallenge_".$chelangeid."' class='btn btn-default editbox' type='file' title='Upload Photo' label='Add photos to your post' style ='width: auto;'><br/>
					<input type='submit' class='btn-success btn-xs editbox' value='Upload New Photo/File' onclick='save_pic_file(".$chelangeid.")' id='pic_file_save_".$chelangeid."'/>
					<textarea row='5' class='editbox' style='width : 90%;' id= 'challenge_stmt_p_".$chelangeid."' >".$chaaa."</textarea>
						<input type='submit' class='btn-success btn-xs editbox' value='Save' onclick='saveeditedchallenge(".$chelangeid.")' id='doneediting_".$chelangeid."'/>";		
			}
		}
    if ($status == 4 || $status == 5) {
        $answer = mysqli_query($db_handle, "(select stmt from response_challenge where challenge_id = '$chelangeid' and blob_id = '0' and status = '2')
                                            UNION
                                            (select b.stmt from response_challenge as a join blobs as b	where a.challenge_id = '$chelangeid' and a.status = '2' and a.blob_id = b.blob_id);");
        while ($answerrow = mysqli_fetch_array($answer)) {
            echo "<span class='color strong' style= 'color :#3B5998;font-size: 14pt;'>
                    <p align='center'>Answer</p></span>"
					. str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $answerrow['stmt']))) . "<br/>";
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
        $comment_of_ch = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $commenterRow['stmt'])));
        echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
						&nbsp&nbsp&nbsp" . $comment_of_ch;
        dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
        echo "</div></div></div>";
    }
    echo "<div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                        </div>
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 83.0%; height: 30px;' id='own_ch_response_".$chelangeid."'
                             placeholder='Whats on your mind about this'/>
                            <button type='submit' class='btn-primary btn-sm' onclick='comment(".$chelangeid.")' ><span class='glyphicon glyphicon-chevron-right'></span></button>
                    </div>";
    echo "</div> </div> ";
}
?>
