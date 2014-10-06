<div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Your Owned Challenges</h3>
                            </div>
                        </div>
                        
                            <?php 
                                $owned_challenges = mysqli_query($db_handle, ("SELECT a.challenge_id, a.challenge, a.user_id, b.ownership_creation, b.comp_ch_ETA, c.first_name, c.last_name
                                                                        FROM challenges as a 
                                                                            JOIN challenge_ownership as b 
                                                                                JOIN user_info as c 
                                                                                    where (a.challenge_id = b.challenge_id AND b.user_id = $user_id) AND a.user_id =c.user_id ORDER BY challenge_creation DESC;"));
                                while ($owned_challengesRow = mysqli_fetch_array($owned_challenges)) {
									$eta = $owned_challengesRow['comp_ch_ETA'];
									$time = $owned_challengesRow['ownership_creation'] ;
									$ETA = $eta*60 ;
									$day = floor($ETA/(24*60*60)) ;
									$daysec = $ETA%(24*60*60) ;
									$hour = floor($daysec/(60*60)) ;
									$hoursec = $daysec%(60*60) ;
									$minute = floor($hoursec/60) ;
									$remainingtime = $day." Days :".$hour." Hours :".$minute." Min" ;
									$starttimestr = (string) $time ;
									$initialtime = strtotime($starttimestr) ;
									$totaltime = $initialtime+$ETA ;
									$completiontime = time() ;
								if ($completiontime > $totaltime) { 
									$remaining_time = "Time over" ; }
							else {	$remainingtime = ($totaltime-$completiontime) ;
									$day = floor($remainingtime/(24*60*60)) ;
									$daysec = $remainingtime%(24*60*60) ;
									$hour = floor($daysec/(60*60)) ;
									$hoursec = $daysec%(60*60) ;
									$minute = floor($hoursec/60) ;
									$sec = $hoursec%60 ;
									$remaining_time = $day." Days :".$hour." Hours :".$minute." Min :".$sec." "."Secs" ;
								}
                            echo "<div class='panel-body'>
                                    <div class='list-group'>";
                                    echo '<tr>'. "<div class='list-group-item'>";
                            echo "<font color = '#F1AE1E'> Challenge by &nbsp <span class='color strong' style= 'color :#CAF11E;'>" .ucfirst($owned_challengesRow['first_name']). '&nbsp'. ucfirst($owned_challengesRow['last_name']). " </span> &nbsp on &nbsp".$time. " &nbsp to accomplish in &nbsp".$remainingtime. "&nbsp&nbsp&nbsp&nbsp&nbsp Remaining Time : ".$remaining_time."</font>" ;       

                            echo "<td> <br> <br>". str_replace("<s>","&nbsp;",$owned_challengesRow['challenge']). "</td> <br> <br>";
                            echo '</tr>';
                            $commenter = mysqli_query ($db_handle, ("SELECT a.response_ch, a.challenge_id, a.user_id, b.first_name, b.last_name 
                                                                    FROM response_challenge as a 
                                                                    JOIN user_info as b 
                                                                    WHERE a.challenge_id = ".$owned_challengesRow['challenge_id']." AND a.user_id = b.user_id ORDER BY response_ch_creation ASC;"));
                            while($commenterRow = mysqli_fetch_array($commenter)) {
                            echo "
                                    <div id='commentscontainer'>
                                            <div class='comments clearfix'>
                                                    <div class='pull-left lh-fix'>
                                                            <img src='img/default.gif'>
                                                    </div>
                                                    <div class='comment-text'>
                                                            <span class='pull-left color strong'>";
                                                                echo "&nbsp". ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) .
                                                            "</span> ";
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
                                                    <tr><td><input type='hidden' value='$user_id'/></td></tr>
                                                    <tr><td><input type='hidden' value='".$owned_challengesRow['challenge_id']."' name='own_challen_id' /></td></tr>
                                                    <tr><td><input type='text' STYLE='border: 1px solid #bdc7d8; width: 350px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/></td></tr>
                                                    <tr><td><input type='submit' style='display:none;' name='own_chl_response' value='Post'></td></tr>
                                                </table>
                                            </form>
                                    </div>
                                ";
                            echo '</tr> </div> </div> </div>';

                            }
                            ?>
                        
