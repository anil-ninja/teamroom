               <div class="panel-body">
                  <form >
						<div class="input-group-addon">
                        <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte"/>
                         </div><br>
                        <div class="input-group-addon">
                        <textarea rows="3" class="form-control" placeholder="Details of Challange" id='challange'></textarea>
                        </div><br>
                        <div class="inline-form">
                        Challenge Open For 
                        <select class="btn btn-default btn-xs"  id= "open_time" >	
                            <option value='0' selected >hour</option>
                            <?php
                                $o = 1 ;
                                while ($o <= 24){
                                    echo "<option value='".$o."' >".$o."</option>" ;
                                    $o++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "open" >	
                            <option value='10' selected >minute</option>
                            <option value='20'  >20</option>
                            <option value='30' >30</option>
                            <option value='40'  >40</option>
                            <option value='50' >50</option>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ETA
                        <select class="btn btn-default btn-xs" id= "c_eta" >	
                            <option value='0' selected >Month</option>
                            <?php
                                $m = 1 ;
                                while ($m <= 11){
                                    echo "<option value='".$m."' >".$m."</option>" ;
                                    $m++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etab" >	
                            <option value='0' selected >Days</option>
                            <?php
                                $d = 1 ;
                                while ($d <= 30){
                                    echo "<option value='".$d."' >".$d."</option>" ;
                                    $d++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etac" >	
                            <option value='0' selected >hours</option>
                                <?php
                                    $h = 1 ;
                                    while ($h <= 23){
                                        echo "<option value='".$h."' >".$h."</option>" ;
                                        $h++ ;
                                    }
                                ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etad" >	
                            <option value='15' selected >minute</option>
                            <option value='30' >30</option>
                            <option value='45'  >45</option>
                        </select><br/><br/>                          
                        <input id="submit_ch" class="btn btn-success" type="button" value="Create Challange"/>
                        </div>
                    </form><br/><br/>
                </div>
              </div>
                <div class='panel-body'>
		<?php
	$user_id = $_SESSION['user_id'];
	$open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name from challenges as a join user_info as b where a.challenge_type = '1'
                                             and blob_id = '0' and a.user_id = b.user_id and a.challenge_status = '1' ORDER BY challenge_creation DESC )
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name from challenges as a join user_info as b join blobs as c 
											WHERE a.challenge_type = '1' and a.blob_id = c.blob_id and a.user_id = b.user_id and a.challenge_status = '1' ORDER BY challenge_creation DESC) ;");
	while ($open_chalangerow = mysqli_fetch_array($open_chalange)){
		$chelange = str_replace("<s>","&nbsp;",$open_chalangerow['stmt']) ;
		$ETA = $open_chalangerow['challenge_ETA'] ;
		$ch_title = $open_chalangerow['challenge_title'] ;
		$frstname = $open_chalangerow['first_name'] ;
		$lstname = $open_chalangerow['last_name'] ;
		$chelangeid = $open_chalangerow['challenge_id'] ;
		$times = $open_chalangerow['challenge_creation'] ;
		$eta = $ETA*60 ;
		$day = floor($eta/(24*60*60)) ;
		$daysec = $eta%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
		$remaining_time = $day." Days :".$hour." Hours :".$minute." Min" ;

		echo "<div class='panel-body'>
			<div class='list-group'>
				<div class='list-group-item'>";	
		echo "<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>
                     <li><a class='btn btn-default' href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                     <li><a class='btn btn-default' id='delChallenge' cID='".$chelangeid."' onclick='delChallenge(".$chelangeid.");'>Delete Challenge</a></li>
                     <li><a class='btn btn-default' >Change ETA</a></li>                    
                     <li><a class='btn btn-default' >Report Spam</a></li>
                   </ul>
              </div>
            </div>";
		
		echo "<font color = '#F1AE1E'> 
				Created by &nbsp 
				<span class='color strong' style= 'color :#CAF11E;'>" 
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). " 
				</span> &nbsp&nbsp&nbsp On : ".$times. "&nbsp&nbsp&nbsp&nbsp ETA : ".$remaining_time.
			  "</font><br/>
			<form method='POST' class='inline-form' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
					<input type='hidden' name='challenge_id' value='" . $chelangeid . "'/><br/>
									Your ETA : 
										<select class='btn btn-default btn-xs' name = 'y_eta' >	
											<option value='0' selected >Month</option>
											<option value='1'>1</option>
											<option value='2'>2</option>
											<option value='3'>3</option>
											<option value='4'>4</option>
											<option value='5'>5</option>
											<option value='6'>6</option>
											<option value='7'>7</option>
											<option value='8'>8</option>
											<option value='9'>9</option>
											<option value='10'>10</option>
											<option value='11'>11</option>
                            			</select>
										<select class='btn btn-default btn-xs' name = 'y_etab' >	
											<option value='0' selected >Days</option>
											<option value='1'>1</option>
											<option value='2'>2</option>
											<option value='3'>3</option>
											<option value='4'>4</option>
											<option value='5'>5</option>
											<option value='6'>6</option>
											<option value='7'>7</option>
											<option value='8'>8</option>
											<option value='9'>9</option>
											<option value='10'>10</option>
											<option value='11'>11</option>
											<option value='12'>12</option>
											<option value='13'>13</option>
											<option value='14'>14</option>
											<option value='15'>15</option>
											<option value='16'>16</option>
											<option value='17'>17</option>
											<option value='18'>18</option>
											<option value='19'>19</option>
											<option value='20'>20</option>
											<option value='21'>21</option>
											<option value='22'>22</option>
											<option value='23'>23</option>
											<option value='24'>24</option>
											<option value='25'>25</option>
											<option value='26'>26</option>
											<option value='27'>27</option>
											<option value='28'>28</option>
											<option value='29'>29</option>
											<option value='30'>30</option>
									</select>
									<select class='btn btn-default btn-xs' name = 'y_etac' >
											<option value='0' selected >hours</option>
											<option value='1'>1</option>
											<option value='2'>2</option>
											<option value='3'>3</option>
											<option value='4'>4</option>
											<option value='5'>5</option>
											<option value='6'>6</option>
											<option value='7'>7</option>
											<option value='8'>8</option>
											<option value='9'>9</option>
											<option value='10'>10</option>
											<option value='11'>11</option>
											<option value='12'>12</option>
											<option value='13'>13</option>
											<option value='14'>14</option>
											<option value='15'>15</option>
											<option value='16'>16</option>
											<option value='17'>17</option>
											<option value='18'>18</option>
											<option value='19'>19</option>
											<option value='20'>20</option>
											<option value='21'>21</option>
											<option value='22'>22</option>
											<option value='23'>23</option>
                                      </select>&nbsp;
									  <select class='btn btn-default btn-xs' name = 'y_etad' >	
											<option value='15' selected >minute</option>
											<option value='30' >30</option>
											<option value='45' >45</option>
									  </select>
								<input type='submit' class='btn btn-success btn-sm' name = 'chlange' value = 'Accept' ></small>
							  </form>
			  </div>
			  <div class='list-group-item'><p align='center' style='font-size: 14pt; color :#CAF11E;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
			   $chelange. "</div><div class='list-group-item'>";
		$commenter = mysqli_query ($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name FROM response_challenge as a
													JOIN user_info as b WHERE a.challenge_id = $chelangeid AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1' ORDER BY response_ch_creation ASC)
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$chelangeid' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1' ORDER BY response_ch_creation ASC);");
	while($commenterRow = mysqli_fetch_array($commenter)) {
              $comment_id = $commenterRow['response_ch_id'];
		echo "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp".ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) ."</span>
						&nbsp&nbsp&nbsp".$commenterRow['stmt'] ."
						<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>
                     <li><a class='btn btn-default' href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                     <li><a class='btn btn-default' id='delChallenge' cID='".$comment_id."' onclick='delChallenge(".$comment_id.");'>Delete Challenge</a></li>                   
                     <li><a class='btn btn-default' >Report Spam</a></li>
                   </ul>
              </div>
            </div></div></div></div>";
		}
		echo "<div class='comments clearfix'>
                  <div class='pull-left lh-fix'>
                     <img src='img/default.gif'>
                  </div>
                  <div class='comment-text'>
                      <form action='' method='POST' class='inline-form'>
                          <input type='hidden' value='".$chelangeid."' name='public_challen_id' />
						  <input type='text' class='form-control' name='public_ch_response' placeholder='Whats on your mind about this Challenge'/>
                          <input type='submit' class='btn btn-success btn-sm' name='public_chl_response' value='Post'>
                      </form>
                  </div>
             </div>";
          echo " </div> </div></div> ";    
  }
  $owned_challenges = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.stmt, c.user_id, c.ownership_creation, c.comp_ch_ETA, 
											b.first_name, b.last_name from challenges as a join user_info as b join challenge_ownership 
											as c where a.challenge_type = '1' and blob_id = '0' and c.user_id = b.user_id and a.challenge_id = c.challenge_id
											 and a.challenge_status = '2' ORDER BY challenge_creation DESC )
											  UNION
										 (SELECT DISTINCT a.challenge_id, a.challenge_title, c.stmt, d.user_id, d.ownership_creation, d.comp_ch_ETA, b.first_name,
										  b.last_name from challenges as a join user_info as b join blobs as c join challenge_ownership
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
			$time = $owned_challengesRow['last_name'] ;
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
			$sec = $hoursec%60 ;
			$remaining_time_own = $day." Days :".$hour." Hours :".$minute." Min :".$sec." "."Secs" ;
		}
  echo "<div class='panel-body'>
			<div class='list-group'>
				<div class='list-group-item'>";	
		
		echo "<font color = '#F1AE1E'> 
				Created by &nbsp 
				<span class='color strong' style= 'color :#CAF11E;'>" 
				. ucfirst($frstname). '&nbsp'. ucfirst($lstname). "</span> &nbsp&nbsp&nbsp Created On : ".$times. "&nbsp&nbsp&nbsp ETA : ".$remaining_time. 
			  "<br/>Owned By : <span class='color strong' style= 'color :#CAF11E;'>"
			  .ucfirst($namefirst). '&nbsp'. ucfirst($namelast)."</span> &nbsp&nbsp".$remainingtime. "&nbsp&nbsp&nbsp Remaining Time : ".$remaining_time_own.
			  "</font><br/><br/><p align='center' style='font-size: 14pt; color :#CAF11E;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
			   $stmt. "</div>";
		$commenter = mysqli_query ($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name FROM response_challenge as a
													JOIN user_info as b WHERE a.challenge_id = $ch_id AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1' ORDER BY response_ch_creation ASC)
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$ch_id' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1' ORDER BY response_ch_creation ASC);");
	while($commenterRow = mysqli_fetch_array($commenter)) {
              $comment_id = $commenterRow['response_ch_id'];
		echo "<div class='list-group-item'>
			   <div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<span class='pull-left color strong'>&nbsp".ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) ."</span>
						&nbsp&nbsp&nbsp".$commenterRow['stmt'] ."
						<div class='pull-right'>
				<div class='list-group-item'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>
                     <li><a class='btn btn-default' href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                     <li><a class='btn btn-default' id='delChallenge' cID='".$comment_id."' onclick='delChallenge(".$comment_id.");'>Delete Challenge</a></li>                   
                     <li><a class='btn btn-default' >Report Spam</a></li>
                   </ul>
              </div>
            </div></div></div></div>";
		}
		echo "<div class='comments clearfix'>
                  <div class='pull-left lh-fix'>
                     <img src='img/default.gif'>
                  </div>
                  <div class='comment-text'>
                      <form action='' method='POST' class='inline-form'>
                          <input type='hidden' value='".$ch_id."' name='public_challen_id' />
						  <input type='text' class='form-control' name='public_ch_response' placeholder='Whats on your mind about this Challenge'/>
                          <input type='submit' class='btn btn-success btn-sm' name='public_chl_response' value='Post'>
                      </form>
                  </div>
             </div>";
          echo " </div> </div></div> ";
	  }
?>
