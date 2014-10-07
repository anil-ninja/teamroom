<div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Remaining Time : <?php echo $remaining_time ; ?></h3>
                        </div>
                    </div>
                    
                        <?php                                                                                  
                            $display = mysqli_query($db_handle, "select DISTINCT a.challenge_id, a.challenge_title, a.user_id, a.challenge_ETA, a.challenge, a.challenge_creation,
                                                                b.first_name, b.last_name, b.contact_no,b.email from challenges as a join user_info as b where
                                                                a.project_id = '$p_id'	and a.user_id = b.user_id ORDER BY challenge_creation DESC;");
                            while ($displayrow = mysqli_fetch_array($display)) {
                                    echo "<div class='panel-body'>
                                                <div class='list-group'>
                                                    <div class='list-group-item'>";
                                        $chalangest = $displayrow['challenge'] ;
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
                              echo "<font color = '#F1AE1E'> Created by &nbsp <span class='color strong' style= 'color :#CAF11E;'>
										: ".ucfirst($fname). '&nbsp'.ucfirst($lname)." </span>&nbsp&nbsp&nbsp ETA : ".$remainingtime." &nbsp Challenge Created 
										ON :".$chalangetime. "&nbsp and Remaining Time : ".$remaining_time."</font> <br>
										<p align='center' style='font-size: 14pt;'  ><span style= 'color :#CAF11E;'><b>".ucfirst($ch_title)."</b></span></p><br/>
										<table>
                                            <tr cha_smt='".$idb."' class='edit_tr'>
                                                <td class='edit_td'>
                                                    <span id='cha_smt_".$idb."' class='text' ><small>".str_replace("<s>","&nbsp;",$chalangest)."</small></span>
                                                    <input type='text' value='".$chalangest."' class='editbox' id= 'cha_smt_input_".$idb."' />
                                                </td>
                                            </tr>
                                        </table> <br> <br>";
                                $displaya = mysqli_query($db_handle, "select DISTINCT a.challenge_id, b.user_id, b.response_ch, b.response_ch_id, b.response_ch_creation,c.first_name,c.contact_no,c.email 
                                                                from challenges as a join response_challenge as b join user_info as c where
                                                                a.project_id = '$p_id' and a.challenge_id = b.challenge_id and b.challenge_id = ".$displayrow['challenge_id']." and b.user_id = c.user_id ;");		
                                while ($displayrowb = mysqli_fetch_array($displaya)) {	
                                        $fstname = $displayrowb['first_name'] ;
                                        $phone_nom = $displayrowb['contact_no'] ;
                                        $e_id = $displayrowb['email'] ;
                                        $idc = $displayrowb['response_ch_id'] ;
                                        $chalangeres = $displayrowb['response_ch'] ;
                                        $responsetime = $displayrowb['response_ch_creation'] ;
                                echo "
                                <div id='commentscontainer'>
                                    <div class='comments clearfix'>
                                        <div class='pull-left lh-fix'>
                                            <img src='img/default.gif'>
                                        </div>
                                        <div class='comment-text'>
                                            <span class='pull-left color strong'>
                                                &nbsp". ucfirst($fstname)."&nbsp".
                                            "</span> 
                                            <table>
                                                <tr id_res='".$idc."' class='edit_tr'>
                                                    <td class='edit_td'>
                                                        <span id='challengeres_".$idc."' class='text' ><small>".$chalangeres."</small></span>
                                                        <input type='text' value='".$chalangeres."' class='editbox' id= 'challengeres_input_".$idc."' />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div> 
                                </div>";
                                }
                                echo "<div class='comments clearfix'>
										<div class='pull-left lh-fix'>
                                            <img src='img/default.gif'> 
										</div>
                                    <form class='inline-form' action='' method='POST'>
                                        <table>
                                            <tr><td><input type='hidden' value='".$displayrow['challenge_id']."' name='challenge_of_project_id' /></td></tr>
                                            <tr><td><input type='text' STYLE=' border: 1px solid #bdc7d8; width: 300px;' name='challenge_of_pr_resp' placeholder='Whats on your mind about this challenge'/></td></tr>
                                            <tr><td> <input type='submit' style='display:none;' name='challenge_of_project_response' value='Post'></td></tr>
                                        </table>
                                    </form>
                                </div>";
                            echo "</div> </div> </div>";
                            }
                        ?>
                    
