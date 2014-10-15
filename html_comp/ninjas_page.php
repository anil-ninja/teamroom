        
				   <div class='list-group'>
				<div class='list-group-item'>
                  <form>
						<div class="input-group-addon">
                        <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte"/>
                         </div><br>
                        <div class="input-group-addon">
                        <textarea rows="3" class="form-control" placeholder="Details of Challange" id='challange'></textarea>
                        </div><br>
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
                    </form><br/>
                </div></div>
		<?php
	$user_id = $_SESSION['user_id'];
	$open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.username from challenges as a join user_info as b where a.challenge_type = '1'
                                             and blob_id = '0' and a.user_id = b.user_id and a.challenge_status = '1')
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_open_time, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
											WHERE a.challenge_type = '1' and a.blob_id = c.blob_id and a.user_id = b.user_id and a.challenge_status = '1') ORDER BY challenge_creation DESC ;");
	while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
		$chelange = str_replace("<s>","&nbsp;",$open_chalangerow['stmt']) ;
		$ETA = $open_chalangerow['challenge_ETA'] ;
		$ch_title = $open_chalangerow['challenge_title'] ;
		$frstname = $open_chalangerow['first_name'] ;
		$lstname = $open_chalangerow['last_name'] ;
                $username_ch_ninjas = $open_chalangerow['username'];
		$chelangeid = $open_chalangerow['challenge_id'] ;
		$times = $open_chalangerow['challenge_creation'] ;
		$timeopen = $open_chalangerow['challenge_open_time'] ;
		$eta = $ETA*60 ;
		$day = floor($eta/(24*60*60)) ;
		$daysec = $eta%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
		$remaining_time = $day." Days :".$hour." Hours :".$minute." Min" ;
		$starttimestr = (string) $times ;
		$open = $timeopen*60 ;
        $initialtime = strtotime($starttimestr) ;
		$totaltime = $initialtime+$eta+$open ;
		$completiontime = time() ;
if ($completiontime > $totaltime) { 
	$remaining_time_own = "Closed" ; }
else {	$remainingtime = ($totaltime-$completiontime) ;
		$day = floor($remainingtime/(24*60*60)) ;
		$daysec = $remainingtime%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
		$remaining_time_own = "Remaining Time : ".$day." Days :".$hour." Hours :".$minute." Min " ;
}
		echo "<div class='list-group'>
				<div class='list-group-item'>" ;
				
		dropDown_challenge($db_handle, $chelangeid, $user_id, $remaining_time_own);
		echo "Created by &nbsp 
				<span class='color strong' style= 'color :lightblue;'><a href ='profile.php?username=".$username_ch_ninjas."'>" 
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </a></span>
					<form method='POST' class='inline-form pull-right'>
						<input type='hidden' name='id' value='".$chelangeid."'/>
						<input class='btn btn-primary btn-sm' type='submit' name='accept' value='Accept'/>
					</form>
				 &nbsp&nbsp&nbsp On : ".$times. "&nbsp&nbsp&nbsp&nbsp ETA : ".$remaining_time."<br/>".$remaining_time_own.
			  "</div>
			  <div class='list-group-item'><p align='center' style='font-size: 14pt; color :lightblue;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
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
					<img src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=".$username_comment_ninjas."'>".ucfirst($commenterRow['first_name'])." ". ucfirst($commenterRow['last_name']) ."</a></span>
						&nbsp&nbsp&nbsp".$commenterRow['stmt'] ."";
				
                dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
         echo "</div></div></div>";
		}
		echo "<div class='comments clearfix'>
                  <div class='pull-left lh-fix'>
                     <img src='img/default.gif'>
                  </div>
                  <div class='comment-text'>
                      <form action='' method='POST' class='inline-form'>
							<input type='hidden' value='".$chelangeid."' name='own_challen_id' />
							<input type='text' STYLE='border: 1px solid #bdc7d8; width: auto; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
							<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
						</form>
                  </div>
             </div>";
          echo " </div> </div> ";    
  }
  $owned_challenges = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.stmt, c.user_id, c.ownership_creation, c.comp_ch_ETA, 
											b.first_name, b.last_name, b.username from challenges as a join user_info as b join challenge_ownership 
											as c where a.challenge_type = '1' and blob_id = '0' and c.user_id = b.user_id and a.challenge_id = c.challenge_id
											 and a.challenge_status = '2' ORDER BY challenge_creation DESC )
											  UNION
										 (SELECT DISTINCT a.challenge_id, a.challenge_title, c.stmt, d.user_id, d.ownership_creation, d.comp_ch_ETA, b.first_name,
										  b.last_name, b.username from challenges as a join user_info as b join blobs as c join challenge_ownership
										   as d WHERE a.challenge_type = '1' and a.challenge_id = d.challenge_id and a.blob_id = c.blob_id and
										    d.user_id = b.user_id and a.challenge_status = '2' ORDER BY challenge_creation DESC);");
  
   while ($owned_challengesRow = mysqli_fetch_array($owned_challenges)) {
			$eta = $owned_challengesRow['comp_ch_ETA'];
			$stmt = str_replace("<s>","&nbsp;",$owned_challengesRow['stmt']) ;
			$ch_title = $owned_challengesRow['challenge_title'];
			$ch_id = $owned_challengesRow['challenge_id'];
			$id = $owned_challengesRow['user_id'];
			$namefirst = $owned_challengesRow['first_name'];
			$namelast = $owned_challengesRow['last_name'];
                        $username_owned_ch_ninjas = $owned_challengesRow['username'];
			$time = $owned_challengesRow['ownership_creation'];
			$ETA = $eta*60 ;
			$day = floor($ETA/(24*60*60)) ;
			$daysec = $ETA%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remainingtime = "to accomplish in : ".$day." Days :".$hour." Hours :".$minute." Min" ;
			$starttimestr = (string) $time ;
			$initialtime = strtotime($starttimestr) ;
			$totaltime = $initialtime+$ETA ;
			$completiontime = time() ;
		if ($completiontime > $totaltime) { 
			$remaining_time_own = "Time over" ; }
	else {	$remaintime = ($totaltime-$completiontime) ;
			$day = floor($remaintime/(24*60*60)) ;
			$daysec = $remaintime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remaining_time_own = $day." Days :".$hour." Hours :".$minute." Min " ;
		}
  echo "<div class='list-group'>
				<div class='list-group-item'>" ;
	echo  "Owned By : <span class='color strong' style= 'color :lightblue;'><a href ='profile.php?username=".$username_owned_ch_ninjas."'>"
			  .ucfirst($namefirst). '&nbsp'. ucfirst($namelast)."</a></span> &nbsp&nbsp".$remainingtime. "&nbsp&nbsp&nbsp Remaining Time : ".$remaining_time_own.
			  "<br/></div><div class='list-group-item'><p align='center' style='font-size: 14pt; color :lightblue;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
			   $stmt."<br/><br/> </font>";
		$commenter = mysqli_query ($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username FROM response_challenge as a
													JOIN user_info as b WHERE a.challenge_id = '$ch_id' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$ch_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");
	while($commenterRow = mysqli_fetch_array($commenter)) {
              $comment_id = $commenterRow['response_ch_id'];
              $username_comment_owned_ch_ninjas = $commenterRow['username'];
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp<a href ='profile.php?username=".$username_comment_owned_ch_ninjas."'>".ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) ."</a></span>
						&nbsp&nbsp&nbsp".$commenterRow['stmt'] ."";
						dropDown_delete_comment_challenge($db_handle, $comment_id, $user_id);
          echo "</div></div></div>";
		}
		echo "<div class='comments clearfix'>
                  <div class='pull-left lh-fix'>
                     <img src='img/default.gif'>&nbsp
                  </div>
                  <div class='comment-text' class='inline-form'>
                     <form action='' method='POST' class='inline-form'>
							<input type='hidden' value='".$ch_id."' name='own_challen_id' />
							<input type='text' STYLE='border: 1px solid #bdc7d8; width: auto; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
							<button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
						</form>
                  </div>
             </div>";
          echo " </div></div> ";
	  }
?>
