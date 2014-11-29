<div class="bs-component">
    <div class='list-group'  style="background-color: rgba(240, 240, 240, 0.32);style = 'font-size:10px'">
  <div class="panel-group" id="accordion" role="tablist" >
  <div class="panel panel-default">
    <div class="panel-heading" style="padding: 5px;" role="tab" id="headingOne">
         <a data-toggle='modal' data-target="#myreminder" class='btn-link'><i class='glyphicon glyphicon-bell'></i>
          &nbsp;Add Reminder
          </a>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" style="padding: 5px;"role="tab" id="headingTwo">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <i class='glyphicon glyphicon-eye-open'></i> &nbsp;All Reminder
        </a>
    </div>
    <div id='collapseTwo' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>   
            <div id='allreminders' ></div><?php echo "<input type='hidden' id='lastreminderid' value='".$idb."'/>" ; ?>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" style="padding: 5px;" role="tab" id="headingThree">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          <i class='btn-link glyphicon glyphicon-bullhorn'></i>&nbsp;
            To Do</a>
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
    ?>
          </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" style="padding: 5px;"role="tab" id="headingThree">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
          <i class='btn-link glyphicon glyphicon-tasks'></i>&nbsp;
               Get Done
        </a>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body" style="padding: 1px;">
        <?php
    $titlesass = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.creation_time, c.user_id, b.first_name, 
                                            b.last_name, b.username FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE
                                             a.user_id = '$user_id' AND a.challenge_type = '5' AND c.user_id = b.user_id AND a.challenge_id = c.challenge_id ;");
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
    ?>
       </div>
    </div>
  </div>
   
</div>
</div>
</div>
 <!-- Modal -->
            <div class="modal fade" id="myreminder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel"><font size="5" >Add Reminder</font></h4>
                        </div><div class='alert_placeholder'></div>
                        <div class="modal-body">
                        To : <select class="btn-default btn-xs"  id= "self" >
							<option value="<?= $user_id ; ?>" selected >Self</option>
				<?php
                  $friends = mysqli_query($db_handle, "SELECT * FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b where
														a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id') as b where a.user_id=b.user_id;");
                         while ($friendsrow = mysqli_fetch_array($friends)) {
                            echo "<option value='" . $friendsrow['user_id'] . "' >" . $friendsrow['first_name'] . "</option>";
                        }
                        ?>
                    </select> &nbsp;&nbsp;&nbsp;&nbsp; Time : 
                                <input type="text" id ="datepick" placeholder='Reminder Time & Date'>
                                <input type="submit" class="btn btn-primary btn-sm pull-right" id = "remind" value = "Set"><br/><br/>
								<textarea row='3' class="form-control" id="reminder" placeholder="Type your message here"></textarea><br/>	
                        </div>
                    </div>
                </div>
            </div>
            <!--end modle-->
<!-- Modal -->
            <div class="modal fade" id="changeremindervalues" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel"><font size="5" >Change Reminder</font></h4>
                        </div><div class='alert_placeholder'></div>
                        <div class="modal-body">
							To : <select class="btn-default btn-xs"  id= "selfremind" >
							<option value="<?= $user_id ; ?>" selected >Self</option>
				<?php
                  $friends = mysqli_query($db_handle, "SELECT * FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b where
														a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id') as b where a.user_id=b.user_id;");
                         while ($friendsrow = mysqli_fetch_array($friends)) {
                            echo "<option value='" . $friendsrow['user_id'] . "' >" . $friendsrow['first_name'] . "</option>";
                        }
                        ?> 
                        </select> &nbsp;&nbsp;&nbsp;&nbsp; Time : 
                                <input type="text" id ="datepicker" placeholder='Reminder Time & Date'>
                                 <input type="submit" class="btn btn-primary btn-sm pull-right" id = "changeremindervalue" value = "Set"><br/><br/>
                        		<textarea row='3' class="form-control" id="newremindervalue" placeholder="Type your message here"></textarea><br/>
                              	<input type="hidden" id ="datepickervalue" value="0">
                              	<input type="hidden" id ="valueuserid" value="0">
                           
                        </div>
                    </div>
                </div>
            </div>
            <!--end modle-->
<script type="text/javascript">
	$(function(){
		$('#datepick').appendDtpicker();
	});
	$(function(){
		$('#datepicker').appendDtpicker();
	});
</script>

<link type="text/css" href="jquery.simple-dtpicker.css" rel="stylesheet" />
