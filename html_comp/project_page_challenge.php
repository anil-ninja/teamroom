<div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Remaining Time : <?php echo $remaining_time ; ?></h3>
                        </div>
                    </div>
<?php                                                                                  
      $display = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b where
											a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and blob_id = '0' and
											a.challenge_status != '2' and a.user_id = b.user_id ORDER BY challenge_creation DESC )
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c WHERE a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and 
											a.blob_id = c.blob_id and  a.challenge_status != '2'  and a.user_id = b.user_id ORDER BY challenge_creation DESC) ;");
      while ($displayrow = mysqli_fetch_array($display)) {
			$chalangest = $displayrow['stmt'] ;
			$chalangetime = $displayrow['challenge_creation'] ;
			$idb = $displayrow['challenge_id'] ;
			$ch_title = $displayrow['challenge_title'] ;
			$ETA = $displayrow['challenge_ETA'] ;
			$fname = $displayrow['first_name'] ;
			$lname = $displayrow['last_name'];
			$phonenom = $displayrow['contact_no'] ;
			$eid = $displayrow['email'] ;							
			$eta = $ETA*60 ;
			$day = floor($eta/(24*60*60)) ;
			$daysec = $eta%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remainingtime = $day." Days :".$hour." Hours :".$minute." Min" ;
			$starttimestr = (string) $chalangetime ;
			$initialtime = strtotime($starttimestr) ;
			$totaltime = $initialtime+$eta ;
			$completiontime = time() ;
		if ($completiontime > $totaltime) { 
			$remaining_time = "Time over" ; }
	else {	$remaintime = ($totaltime-$completiontime) ;
			$day = floor($remaintime/(24*60*60)) ;
			$daysec = $remaintime%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$sec = $hoursec%60 ;
			$remaining_time = $day." Days :".$hour." Hours :".$minute." Min :".$sec." "."Secs" ;
		}	
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
	  echo "<font color = '#F1AE1E'> Created by &nbsp <span class='color strong' style= 'color :#CAF11E;'>
				: ".ucfirst($fname). '&nbsp'.ucfirst($lname)." </span>&nbsp&nbsp&nbsp ETA : ".$remainingtime." &nbsp Challenge Created 
				ON :".$chalangetime. "&nbsp and Remaining Time : ".$remaining_time."</font><br/>";
          
	  echo "<form method='POST' class='inline-form' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
		<input type='hidden' name='challenge_id' value='" . $idb . "'/><br/>
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
	  </form><br/>";
		echo "<p align='center' style='font-size: 14pt;'  ><span style= 'color :#CAF11E;'><b>".ucfirst($ch_title)."</b></span></p><br/>
				<small>".str_replace("<s>","&nbsp;",$chalangest)."</small><br> <br>";
		$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$idb' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1' ORDER BY response_ch_creation ASC)
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$idb' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1' ORDER BY response_ch_creation ASC);");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp". ucfirst($fstname)."&nbsp".
					"</span><small>".$chalangeres."</small>
					<div class='list-group-item pull-right'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>
                     <li><a class='btn btn-default' href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                     <li><a class='btn btn-default' id='delChallenge' cID='".$comment_id."' onclick='delChallenge(".$comment_id.");'>Delete Challenge</a></li>                   
                     <li><a class='btn btn-default' >Report Spam</a></li>
                   </ul>
              </div>
				</div>
			</div> 
		</div>";
		}
		echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='img/default.gif'> &nbsp
                        </div>
			<form class='inline-form' action='' method='POST'>
                            <input type='hidden' value='".$displayrow['challenge_id']."' name='challenge_of_project_id' />
                            <input type='text' STYLE=' border: 1px solid #bdc7d8; width: 300px; height: 30px;' id='challenge_of_pr_resp' placeholder='Whats on your mind about this challenge'/>
                            <button type='submit' class='btn-success btn-sm glyphicon glyphicon-play' id='challenge_of_project_response'></button>
			</form>
                    </div>";
	echo "</div> </div> </div>";
	}
	 $displayd = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, a.stmt, a.challenge_creation,
                                            b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b where
											a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and blob_id = '0' and
											a.challenge_status = '2' and a.user_id = b.user_id ORDER BY challenge_creation DESC )
											UNION
											(SELECT DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, c.stmt, a.challenge_creation,
											b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b
											join blobs as c WHERE a.project_id = '$p_id' and (a.challenge_type = '1' OR a.challenge_type = '2') and 
											a.blob_id = c.blob_id and  a.challenge_status = '2'  and a.user_id = b.user_id ORDER BY challenge_creation DESC) ;");
      while ($displayrowd = mysqli_fetch_array($displayd)) {
			$stmt = $displayrowd['stmt'] ;
			$chalangetime = $displayrowd['challenge_creation'] ;
			$idd = $displayrowd['challenge_id'] ;
			$ch_title = $displayrowd['challenge_title'] ;
			$ETA = $displayrowd['challenge_ETA'] ;
			$fnamer = $displayrowd['first_name'] ;
			$lnamer = $displayrowd['last_name'];
			$eta = $ETA*60 ;
			$day = floor($eta/(24*60*60)) ;
			$daysec = $eta%(24*60*60) ;
			$hour = floor($daysec/(60*60)) ;
			$hoursec = $daysec%(60*60) ;
			$minute = floor($hoursec/60) ;
			$remainingtimer = $day." Days :".$hour." Hours :".$minute." Min" ;
			$starttimestr = (string) $chalangetime ;
			$initialtime = strtotime($starttimestr) ;
			$totaltime = $initialtime+$eta ;
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
	  echo "<font color = '#F1AE1E'> Created by &nbsp <span class='color strong' style= 'color :#CAF11E;'>
				: ".ucfirst($fname). '&nbsp'.ucfirst($lname)." </span>&nbsp&nbsp&nbsp ETA : ".$remainingtime." &nbsp Challenge Created 
				ON :".$chalangetime. "<br/>Owned By : <span class='color strong' style= 'color :#CAF11E;'>"
			  .ucfirst($fnamer). '&nbsp'. ucfirst($lnamer)."</span> &nbsp&nbsp".$remainingtimer. "&nbsp&nbsp&nbsp Remaining Time : ".$remaining_time_own.
			  "</font><br/><br/><p align='center' style='font-size: 14pt; color :#CAF11E;'  ><b>".ucfirst($ch_title)."</b></p><br/>".
			   $stmt. "</font><br/>" ;
			   
		$displaya = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name FROM response_challenge as a
												JOIN user_info as b WHERE a.challenge_id = '$idd' AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1' ORDER BY response_ch_creation ASC)
												   UNION
												   (SELECT DISTINCT a.challenge_id, a.response_ch_id, a.user_id, b.first_name, b.last_name, c.stmt FROM response_challenge as a
													JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$idd' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1' ORDER BY response_ch_creation ASC);");		
		while ($displayrowb = mysqli_fetch_array($displaya)) {	
				$fstname = $displayrowb['first_name'] ;
				$idc = $displayrowb['response_ch_id'] ;
				$chalangeres = $displayrowb['stmt'] ;
		echo "
		<div id='commentscontainer'>
			<div class='comments clearfix'>
				<div class='pull-left lh-fix'>
					<img src='img/default.gif'>
				</div>
				<div class='comment-text'>
					<span class='pull-left color strong'>
						&nbsp". ucfirst($fstname)."&nbsp".
					"</span><small>".$chalangeres."</small>
					<div class='list-group-item pull-right'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'' id='themes'><span class='caret'></span></a>
					<ul class='dropdown-menu' aria-labelledby='dropdown'>
                     <li><a class='btn btn-default' href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                     <li><a class='btn btn-default' id='delChallenge' cID='".$comment_id."' onclick='delChallenge(".$comment_id.");'>Delete Challenge</a></li>                   
                     <li><a class='btn btn-default' >Report Spam</a></li>
                   </ul>
              </div>
				</div>
			</div> 
		</div>";
		}
		echo "<div class='comments clearfix'>
                        <div class='pull-left'>
                            <img src='img/default.gif'> &nbsp
                        </div>
			<form class='inline-form' action='' method='POST'>
                            <input type='hidden' value='".$displayrow['challenge_id']."' name='challenge_of_project_id' />
                            <input type='text' STYLE=' border: 1px solid #bdc7d8; width: 300px; height: 30px;' id='challenge_of_pr_resp' placeholder='Whats on your mind about this challenge'/>
                            <button type='submit' class='btn-success btn-sm glyphicon glyphicon-play' id='challenge_of_project_response'></button>
			</form>
                    </div>";
	echo "</div> </div> </div>";
	}
?>

