               <div class="panel-body">
                  <form ><br/>
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
                        </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ETA
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
                <div class='content'>
		<?php
				$user_id = $_SESSION['user_id'];
				$open_chalange = mysqli_query($db_handle, "select a.challenge_id,a.challenge_creation, a.challenge,a.user_id,a.challenge_ETA,a.challenge_status,b.first_name,b.last_name, b.contact_no,b.email
															from challenges as a join user_info as b where a.user_id = b.user_id
															and a.challenge_type = '1' ORDER BY challenge_creation DESC;");
			while ($open_chalangerow = mysqli_fetch_array($open_chalange)){
					$chelange = str_replace("<s>","&nbsp;",$open_chalangerow['challenge']) ;
					$ETA = $open_chalangerow['challenge_ETA'] ;
					$frstname = $open_chalangerow['first_name'] ;
					$lstname = $open_chalangerow['last_name'] ;
					$eid = $open_chalangerow['email'] ;
					$phoneno = $open_chalangerow['contact_no'] ;
					$chelangeid = $open_chalangerow['challenge_id'] ;
					$times = $open_chalangerow['challenge_creation'] ;
					$challenge_status = $open_chalangerow['challenge_status'];
					$eta = $ETA*60 ;
					$day = floor($eta/(24*60*60)) ;
					$daysec = $eta%(24*60*60) ;
					$hour = floor($daysec/(60*60)) ;
					$hoursec = $daysec%(60*60) ;
					$minute = floor($hoursec/60) ;
					$sec = $hoursec%60 ;
					$remaining_time = $day.":".$hour.":".$minute.":".$sec." "."Minutes" ;
			
				echo "<div class='panel-body'>
						<div class='list-group'>";
				echo "<div class='list-group-item'>";
				switch($challenge_status){
				case 1:
						echo "<font color = '#F1AE1E'> Created by &nbsp <span class='color strong' style= 'color :#CAF11E;'>" . ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </span> &nbsp Created On : ".$times. "<br/> ETA : ".$remaining_time."</font>" ;
						echo "<form method='POST' class='inline-form' onsubmit=\"return confirm('Really, Accept challenge !!!')\">
								<input type='hidden' name='challenge_id' value='" . $chelangeid . "'/>
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
							  </form>";
								
					break;
			
				case 2:
					   echo "<font color = '#F1AE1E'> Created by &nbsp <span class='color strong' style= 'color :#CAF11E;'>" . ucfirst($frstname). '&nbsp'. ucfirst($lstname). " </span> &nbsp This challenge is already owned </font>";
						
					break;
			}
				echo "<tr><br> <br>";
				echo $chelange. "<br> <br>";
					$commenter = mysqli_query ($db_handle, ("SELECT a.response_ch, a.challenge_id, a.user_id, b.first_name, b.last_name	FROM response_challenge as a
															JOIN user_info as b WHERE a.challenge_id = $chelangeid AND a.user_id = b.user_id ORDER BY response_ch_creation ASC;"));
						while($commenterRow = mysqli_fetch_array($commenter)) {
								echo "<div id='commentscontainer'>
										<div class='comments clearfix'>
											<div class='pull-left lh-fix'>
												<img src='img/default.gif'>
											</div>
											<div class='comment-text'><span class='pull-left color strong'>";
								echo "&nbsp".ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) ."</span> ";
								echo str_repeat('&nbsp;', 2) .$commenterRow['response_ch'] ."
											</div>
										</div>
									</div>";
								}
								echo "<div class='comments clearfix'>
								       <div class='pull-left lh-fix'>
										<img src='img/default.gif'>
									   </div>
										<form action='' method='POST'>
										<table>
											<tr><td><input type='hidden' name='user_id' value='$user_id'/></td></tr>
											<tr><td><input type='hidden' value='".$chelangeid."' name='public_challen_id' /></td></tr>
											<tr><td><input type='text' STYLE='border: 1px solid #bdc7d8; height: 30px; padding: 3px; width: 350px;' name='public_ch_response' placeholder='Whats on your mind about this Challenge'/></td></tr>
											<tr><td> <br/><input type='submit' style='display:none;' class='btn btn-success btn-sm' name='public_chl_response' value='Post'></td></tr>
										</table>
										</form>
										</div>";
					echo "</tr> </div> </div></div> ";
				}
			?>
			
