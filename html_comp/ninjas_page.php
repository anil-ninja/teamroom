        <script>
$(document).ready(function(){
	$("#challegeForm").toggle();
  $("#challenge").click(function(){
  	$("#ArticleForm").hide(1500);
  	$("#PictureForm").hide(1500);
  	$("#VideoForm").hide(1500);
    $("#challegeForm").toggle(3000);
  });

  $("#ArticleForm").toggle();
  $("#artical").click(function(){
  	$("#challegeForm").hide(1500);
  	$("#PictureForm").hide(1500);
  	$("#VideoForm").hide(1500);
    $("#ArticleForm").toggle(3000);
  });
  $("#PictureForm").toggle();
  $("#picture").click(function(){
  	$("#challegeForm").hide(1500);
  	$("#PictureForm").toggle(1500);
  	$("#VideoForm").hide(1500);
    $("#ArticleForm").hide(3000);
  });
  $("#VideoForm").toggle();
  $("#video").click(function(){
  	$("#challegeForm").hide(1500);
  	$("#PictureForm").hide(1500);
  	$("#VideoForm").toggle(1500);
    $("#ArticleForm").hide(3000);
  });
});
</script>
				   <div class='list-group'>
				   <div class='list-group-item'><span class="glyphicon glyphicon-pencil" id='challenge'> Challenge</span> | &nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-globe" id='artical'> Artical</span> | &nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-picture" id='picture'> Photos</span> | &nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-film" id='video'> Videos</span></div>
				<div class='list-group-item'>
				<div id='challegeForm'>
                  <form>
                        <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte"/>
                         <br>
                        <textarea rows="3" class="form-control" placeholder="Details of Challange" id='challange'></textarea>
                        <br>
                        <div class="inline-form">
                        Challenge Open For 
                        <select class="btn-info btn-xs"  id= "open_time" >	
                            <option value='0' selected >hour</option>
                            <?php
                                $o = 1 ;
                                while ($o <= 24){
                                    echo "<option value='".$o."' >".$o."</option>" ;
                                    $o++ ;
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
                                $m = 1 ;
                                while ($m <= 11){
                                    echo "<option value='".$m."' >".$m."</option>" ;
                                    $m++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn-info btn-xs" id= "c_etab" >	
                            <option value='0' selected >Days</option>
                            <?php
                                $d = 1 ;
                                while ($d <= 30){
                                    echo "<option value='".$d."' >".$d."</option>" ;
                                    $d++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn-info btn-xs" id= "c_etac" >	
                            <option value='0' selected >hours</option>
                                <?php
                                    $h = 1 ;
                                    while ($h <= 23){
                                        echo "<option value='".$h."' >".$h."</option>" ;
                                        $h++ ;
                                    }
                                ?>
                        </select>&nbsp;
                        <select class="btn-info btn-xs" id= "c_etad" >	
                            <option value='15' selected >minute</option>
                            <option value='30' >30</option>
                            <option value='45'  >45</option>
                        </select><br/><br/>                          
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
                        <textarea rows="3" class="form-control" id="article" placeholder="Upload Videos"></textarea><br><br>
                        <input type="button" value="Post" class="btn btn-success" id="create_article"/>
                    </div><br/>
                </div></div>
		<?php
	$open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.username from challenges as a join user_info as b where a.challenge_type = '1'
                                             and blob_id = '0' and a.user_id = b.user_id)
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.challenge_status, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE a.challenge_type = '1' and a.blob_id = c.blob_id and a.user_id = b.user_id ) ORDER BY challenge_creation DESC ;");
	while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
		$chelange = str_replace("<s>","&nbsp;",$open_chalangerow['stmt']) ;
		$ETA = $open_chalangerow['challenge_ETA'] ;
		$ch_title = $open_chalangerow['challenge_title'] ;
		$frstname = $open_chalangerow['first_name'] ;
		$lstname = $open_chalangerow['last_name'] ;
        $username_ch_ninjas = $open_chalangerow['username'];
		$chelangeid = $open_chalangerow['challenge_id'] ;
		$status = $open_chalangerow['challenge_status'] ;
		$times = $open_chalangerow['challenge_creation'] ;
		$timefunction = date("j F, g:i a",strtotime($times));
		$timeopen = $open_chalangerow['challenge_open_time'] ;
		$day = floor($ETA/(24*60)) ;
		$daysec = $ETA%(24*60) ;
		$hour = floor($daysec/(60)) ;
		$minute = $daysec%(60) ;
		if($ETA > 1439) {
			$sutime = $day." days" ;
		}
		else {
			if(($ETA < 1439) AND ($ETA > 59)) {
				$sutime = $hour." hours" ;	
			}
			else { $sutime = $minute." mins" ; }
		}
		$starttimestr = (string) $times ;
        $initialtime = strtotime($starttimestr) ;
		$totaltime = $initialtime+($ETA+$timeopen)*60 ;
		$completiontime = time() ;
if ($completiontime > $totaltime) { 
	$remaining_time_own = "Closed" ; }
else {	$remainingtime = ($totaltime-$completiontime) ;
		$day = floor($remainingtime/(24*60*60)) ;
		$daysec = $remainingtime%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
	if ($totaltime > ((24*60*60)-1)) {
		if($hour != 0) {
		$remaining_time_own = $day." Days and ".$hour." Hours" ;
		} else {
			$remaining_time_own = $day." Days" ;
			}
	} else {
			if (($totaltime < ((24*60*60)-1)) AND ($totaltime > ((60*60)-1))) {
				$remaining_time_own = $hour." Hours and ".$minute." Mins" ;
				} else {
					$remaining_time_own = $minute." Mins" ;
					}
		}
			
}
		echo "<div class='list-group'>
				<div class='list-group-item'>" ;
				
		if($status == 1) {
		echo "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_ch_ninjas."'>" 
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </a></span>" ;		 		
				dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
			echo "<form method='POST' class='inline-form pull-right'>
						<input type='hidden' name='id' value='".$chelangeid."'/>
						<input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
					</form>
				 &nbsp&nbsp&nbsp On : ".$timefunction."&nbsp&nbsp&nbsp with ETA : ".$sutime."<br/>".$remaining_time_own."</div>";
		}
		else {
			$ownedby = mysqli_query($db_handle,"SELECT DISTINCT a.user_id, a.comp_ch_ETA ,a.ownership_creation, b.first_name, b.last_name,b.username
												from challenge_ownership as a join user_info as b where a.challenge_id = '$chelangeid' and b.user_id = a.user_id ;") ;
			$ownedbyrow = mysqli_fetch_array($ownedby) ;
			$owneta = $ownedbyrow['comp_ch_ETA'] ;
			$owntime = $ownedbyrow['ownership_creation'] ;
			$timefunct = date("j F, g:i a",strtotime($owntime));
			$ownfname = $ownedbyrow['first_name'] ;
			$ownlname = $ownedbyrow['last_name'] ;
			$ownname = $ownedbyrow['username'] ;
			$dayo = floor($owneta/(24*60)) ;
		$dayseco = $owneta%(24*60) ;
		$houro = floor($daysec/(60)) ;
		$minuteo = $daysec%(60) ;
		if($owneta > 1439) {
			$timeo = $dayo." days" ;
		}
		else {
			if(($owneta < 1439) AND ($owneta > 59)) {
				$timeo = $houro." hours" ;	
			}
			else { $timeo = $minuteo." mins" ; }
		}
		$starttimestro = (string) $owntime ;
        $initialtimeo = strtotime($starttimestro) ;
		$totaltimeo = $initialtimeo+($owneta*60) ;
		$completiontimeo = time() ;
if ($completiontimeo > $totaltimeo) { 
	$remaining_time_owno = "Closed" ; }
else {	$remainingtimeo = ($totaltimeo-$completiontimeo) ;
		$dayow = floor($remainingtimeo/(24*60*60)) ;
		$daysecow = $remainingtimeo%(24*60*60) ;
		$hourow = floor($daysecow/(60*60)) ;
		$hoursecow = $daysecow%(60*60) ;
		$minuteow = floor($hoursecow/60) ;
	if ($totaltimeo > ((24*60*60)-1)) {
		if($hourow != 0) {
		$remaining_time_owno = $dayow." Days and ".$hourow." Hours" ;
		} else {
			$remaining_time_owno = $dayow." Days" ;
			}
	} else {
			if (($totaltimeo < ((24*60*60)-1)) AND ($totaltimeo > ((60*60)-1))) {
				$remaining_time_owno = $hourow." Hours and ".$minuteow." Mins" ;
				} else {
					$remaining_time_owno = $minuteow." Mins" ;
					}
		}
			
}
			echo "Created by &nbsp 
				<span class='color strong'><a href ='profile.php?username=".$username_ch_ninjas."'>"
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </a></span>&nbsp&nbsp On : ".$timefunction."<br/>
				Owned By  <span class='color strong'><a href ='profile.php?username=".$ownname."'>"
				. ucfirst($ownfname). '&nbsp'. ucfirst($ownlname). " </a></span>&nbsp&nbsp On : ".$timefunct." and ETA Taken : ".$timeo." <br/> Time Remaining : ".$remaining_time_owno."</div>" ;
			}
			 echo "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
			   $chelange. "<br/><br/>";
		$commenter = mysqli_query ($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
													JOIN user_info as b WHERE a.challenge_id = $chelangeid AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$chelangeid' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
	while($commenterRow = mysqli_fetch_array($commenter)) {
              $comment_id = $commenterRow['response_ch_id'];
              $challenge_ID = $commenterRow['challenge_id'];
              $username_comment_ninjas = $commenterRow['username'];
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=".$username_comment_ninjas."'>".ucfirst($commenterRow['first_name'])." ". ucfirst($commenterRow['last_name']) ."</a></span>
						&nbsp&nbsp&nbsp".$commenterRow['stmt'] ."";
				
                dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
         echo "</div></div></div>";
		}
		echo "<div class='comments clearfix'>
                  <div class='pull-left lh-fix'>
                     <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>
                  </div>
                  <div class='comment-text' >
                      <form action='' method='POST' class='inline-form'>
							<input type='hidden' value='".$chelangeid."' name='own_challen_id' />
							<input type='text' STYLE='border: 1px solid #bdc7d8; width: 93.3%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
							<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
						</form>
                  </div>
             </div>";
          echo " </div> </div> ";    
  }
