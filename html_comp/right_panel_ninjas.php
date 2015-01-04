<br/>
<div class="bs-component">
            <div id='step2' class="panel panel-default">
                <div class="panel-heading" style="padding: 5px;" role="tab" id="headingOne">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                      <i class='icon-bell'></i> &nbsp;Add Reminder<i class='icon-chevron-down pull-right'></i>
                    </a>
                </div>
            </div>
            <div id='collapseOne' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne'>   
                <div class="panel-body" style="padding: 1px; background : rgb(240, 241, 242);">
                    
                        To : <select class="btn-default btn-xs" style='width: 70%; margin-top: 5px;' id= "self_remind" >
                                <option value="<?= $user_id ; ?>" selected >Self</option>
                                    <?php
                                      $friends = mysqli_query($db_handle, "SELECT * FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b where
                                                                            a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id') as b where a.user_id=b.user_id;");
                                             while ($friendsrow = mysqli_fetch_array($friends)) {
                                                echo "<option value='" . $friendsrow['user_id'] . "' >" . $friendsrow['first_name'] . "</option>";
                                            }
                                    ?>
                            </select><br/><br/>
                        Time :
                            <input type="text" id ="datepick" style='width: 72%;' placeholder='Reminder Time & Date'><br/><br/>
                            <textarea style='width: 92%;' class="form-control" id="reminder_message" placeholder="Type your message here"></textarea><br/><br/>
                            <input type="submit" class="btn btn-primary btn-sm pull-right" onclick = "set_remind()" value = "Set"><br/>  
                </div>
            </div>
        
<br/>
        <div id='step3' class="panel panel-default">
            <div class="panel-heading" style="padding: 5px;" role="tab" id="headingTwo">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <i class='icon-eye-open'></i> &nbsp;All Reminder<i class='icon-chevron-down pull-right'></i>
                </a>
            </div>
        </div>

        <div id='collapseTwo' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>   
            <div id='allreminders' ></div>
                <?php
                    echo "<input type='hidden' id='lastreminderid' value='".$idb."'/>";
                ?>
        </div>
    
<br/>
        <div id='step4' class="panel panel-default">
            <div class="panel-heading" style="padding: 5px;" role="tab" id="headingThree">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class='icon-bullhorn'></i>&nbsp;
                    To Do
                    <i class='icon-chevron-down pull-right'></i>
                </a>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body" style="padding: 1px;">
            <?php
                $titles = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.creation_time, c.user_id, b.first_name, 
                                    b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE c.user_id = '$user_id' 
                                    AND a.challenge_type = '5' AND a.user_id = b.user_id AND a.challenge_id = c.challenge_id)
                                    UNION
                                    (SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.creation_time, c.user_id, b.first_name, b.last_name, 
                                    b.username FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE c.user_id = '$user_id' AND 
                                    (a.challenge_type = '1' OR a.challenge_type = '2') and a.challenge_status = '2' AND a.user_id = b.user_id AND
                                     a.challenge_id = c.challenge_id) ;");
                
                if (mysqli_num_rows($titles) == 0) {
                    echo "<i>No pending task to do</i>";
                } 
                else {
                    while ($titlesrow = mysqli_fetch_array($titles)) {
                        $title = $titlesrow['challenge_title'];
                        if (strlen($title) > 25) {
                            $chtitle = substr(ucfirst($title), 0, 26) . "....";
                        } else {
                            $chtitle = ucfirst($title);
                        }
                        $time = $titlesrow['creation_time'];
                        $timefun = date("j F, g:i a", strtotime($time));
                        $eta = $titlesrow['challenge_ETA'];
                        $fname = $titlesrow['first_name'];
                        $lname = $titlesrow['last_name'];
                        $challengeOpen_pageID = $titlesrow['challenge_id'];
                        $remaining_time_own = remaining_time($time, $eta);
                        $tooltip = "Assigned By : " . ucfirst($fname) . " " . ucfirst($lname) . " On " . $timefun;
                        echo " <a href='challengesOpen.php?challenge_id=" . $challengeOpen_pageID . "'> 
                                <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                                    data-placement='bottom' data-original-title='" . $tooltip . 
                                    "'style='text-align: left;'>" . $chtitle ;
                                    //. "<p style='font-size:8pt; color:rgba(161, 148, 148, 1); text-align: left;'>" . $remaining_time_own . "</p>
                         echo "</button></a><br/>";
                    }
                }
                ?>
              </div>
                </div>
              </div>
     <br/>
              <div id='step5' class="panel panel-default">
                <div class="panel-heading" style="padding: 5px;"role="tab" id="headingThree">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                      <i class='icon-tasks'></i>&nbsp;
                           Get Done
                        <i class='icon-chevron-down pull-right'></i>
                    </a>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body" style="padding: 1px;">
                    <?php
                $titlesass = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.creation_time, c.user_id, b.first_name, 
                                                        b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE
                                                         a.user_id = '$user_id' AND a.challenge_type = '5' AND c.user_id = b.user_id AND a.challenge_id = c.challenge_id ;");
                
                if (mysqli_num_rows($titles) == 0) {
                    echo "<i>You have not assigned any task to anyone.</i>";
                } 
                else {
                    while ($titlesrowass = mysqli_fetch_array($titlesass)) {
                        $titleas = $titlesrowass['challenge_title'];
                        if (strlen($titleas) > 25) {
                            $chtitleas = substr(ucfirst($titleas), 0, 26) . "....";
                        } else {
                            $chtitleas = ucfirst($titleas);
                        }
                        $timeas = $titlesrowass['creation_time'];
                        $timefunas = date("j F, g:i a", strtotime($timeas));
                        $etaas = $titlesrowass['challenge_ETA'];
                        $fnameas = $titlesrowass['first_name'];
                        $lnameas = $titlesrowass['last_name'];
                        $challenge_pageID = $titlesrowass['challenge_id'];
                        $remaining_time_ownas = remaining_time($timeas, $etaas);
                        $tooltipas = "Assigned To : " . ucfirst($fnameas) . " " . ucfirst($lnameas) . " On " . $timefunas;
                        echo "<a href='challengesOpen.php?challenge_id=" . $challenge_pageID . "'> 
                                <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
                                    data-placement='bottom' data-original-title='" . $tooltipas .
                                     "'style='text-align: left;'>" . $chtitleas ;
                                     //."<p style='font-size:8pt; color:rgba(161, 148, 148, 1);text-align: left;'>" . $remaining_time_ownas . "</p>
                             echo "</button></a><br/>";
                    }
                }
                ?>
                   </div>
                </div>
              </div>
   
    </div>
</div>
</div></div></div>

<!--Change reminder Modal starts here -->

<div id="changeremindervalues" class="modal hide fade modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="span6 offset2">

            <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" data-toggle="tab" class="active "><i class="icon-pencil"></i>&nbsp;<span>Change Reminder</span></a></li>
                    <li><a href="#" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>&nbsp;<span></span></a></li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active">
                        <div class="row-fluid">
                            <h4><i class="icon-user"></i>&nbsp;&nbsp;Change Reminder </h4>
                            <br>
                            To: 
                            <select id= "selfremind" >    
                                <option value="<?= $user_id ; ?>" selected >Self</option>
                            <?php
                                $friends = mysqli_query($db_handle, "SELECT * FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b where
                                                        a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id') as b where a.user_id=b.user_id;");
                                while ($friendsrow = mysqli_fetch_array($friends)) {
                                    echo "<option value='" . $friendsrow['user_id'] . "' >" . $friendsrow['first_name'] . "</option>";
                                }
                            ?> 
                            </select>
                            &nbsp; &nbsp;

                            Set Time: 
                            <input type="text" id ="datepicker" placeholder='Reminder Time & Date' />
                            <input type="hidden" id ="datepickervalue" value="0" />
                            <input type="hidden" id ="valueuserid" value="0" />
                            <label>Enter your message</label>
                            <textarea row='3' class="input-block-level" id="newremindervalue" placeholder="Type your message here"></textarea>
                                
                            <br/><br/>
                            <a href="#" class=" btn btn-primary" id = "changeremindervalue">Update&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<!--Change reminder Modal ends here -->


<script type="text/javascript">
	$(function(){
		$('#datepick').appendDtpicker();
	});
	$(function(){
		$('#datepicker').appendDtpicker();
	});
</script>

<link type="text/css" href="jquery.simple-dtpicker.css" rel="stylesheet" />
