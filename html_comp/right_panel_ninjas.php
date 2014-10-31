<div class="bs-component">
    <br/><b>
    <a data-toggle='modal' class='btn btn-link' style='cursor:pointer;'><i class='glyphicon glyphicon-bell'></i>
      <font size="2"><b>Tasks -- to do</b></font></a> | <a data-toggle='modal' data-target="#myreminder" class='btn btn-link' style='cursor:pointer;'><i class='glyphicon glyphicon-bullhorn'></i>
      <font size="2"><b> Add Reminder </b></font></a><hr>
    <?php
    $titles = mysqli_query($db_handle, "(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.challenge_creation, c.user_id, b.first_name, 
						b.last_name, b.username	FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE c.user_id = '$user_id' 
						AND a.challenge_type = '5' AND a.user_id = b.user_id AND a.challenge_id = c.challenge_id)
						UNION
                		(SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.challenge_creation, c.user_id, b.first_name, b.last_name, 
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
        $time = $titlesrow['challenge_creation'];
        $timefun = date("j F, g:i a", strtotime($time));
        $eta = $titlesrow['challenge_ETA'];
        $fname = $titlesrow['first_name'];
        $lname = $titlesrow['last_name'];
        $challengeOpen_pageID = $titlesrow['challenge_id'];
        $remaining_time_own = remaining_time($time, $eta);
        $tooltip = "Assigned By : " . ucfirst($fname) . " " . ucfirst($lname) . " On " . $timefun;
        echo "<a href='challengesOpen.php?challenge_id=" . $challengeOpen_pageID . "'> 
                <button type='submit' class='btn-link' name='projectphp' data-toggle='tooltip' 
				    data-placement='bottom' data-original-title='" . $tooltip . 
                    "' style='height: 25px;font-size:12px;text-align: left;height: 37px'><b>" . $chtitle . "</b>
                <p style='font-size:8pt; color:rgba(161, 148, 148, 1); text-align: left;'>" . $remaining_time_own . "</p></button></a><br/>";
    }
    ?><br/>
    <a data-toggle='modal' class='btn btn-link' style='cursor:pointer;'><i class='glyphicon glyphicon-tasks'></i>
      <font size="2"><b>Tasks -- get done</b></font></a><hr>
    <?php
    $titlesass = mysqli_query($db_handle, "SELECT DISTINCT a.challenge_id, a.challenge_title, a.challenge_ETA, a.challenge_creation, c.user_id, b.first_name, 
											b.last_name, b.username	FROM challenges AS a JOIN user_info AS b JOIN challenge_ownership AS c WHERE
											 a.user_id = '$user_id' AND a.challenge_type = '5' AND c.user_id = b.user_id AND a.challenge_id = c.challenge_id ;");
    while ($titlesrowass = mysqli_fetch_array($titlesass)) {
        $titleas = $titlesrowass['challenge_title'];
        if (strlen($titleas) > 25) {
            $chtitleas = substr(ucfirst($titleas), 0, 26) . "....";
        } else {
            $chtitleas = ucfirst($titleas);
        }
        $timeas = $titlesrowass['challenge_creation'];
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
                     "'style='height: 37px;font-size:13px;text-align: left;'><b>" . $chtitleas ."</b>
                <p style='font-size:8pt; color:rgba(161, 148, 148, 1);text-align: left;'>" . $remaining_time_ownas . "</p></button></a><br/>";
    }
    ?>
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
                        Reminder To : <select class="btn-info btn-xs"  id= "self" >
							<option value="<?= $user_id ; ?>" selected >Self</option>
				<?php
                  $friends = mysqli_query($db_handle, "SELECT * FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b where
														a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id') as b where a.user_id=b.user_id;");
                         while ($friendsrow = mysqli_fetch_array($friends)) {
                            echo "<option value='" . $friendsrow['user_id'] . "' >" . $friendsrow['first_name'] . "</option>";
                        }
                        ?>
                    </select><br/><br/>
								<textarea row='3' class="form-control" id="reminder" placeholder="Type your message here"></textarea><br/>	
                               	<div class="inline-form">
                    Set Date and Time :  
                    <select class="btn-info btn-xs"  id= "month" >	
                        <option value='0' selected >Month</option>
                        <?php
                        $m = 1;
                        while ($m <= 12) {
                            echo "<option value='" . $m . "' >" . $m . "</option>";
                            $m++;
                        }
                        ?>
                    </select>&nbsp;&nbsp;
                    <select class="btn-info btn-xs"  id= "date" >	
                        <option value='0' selected >Date</option>
                        <?php
                        $d = 1;
                        while ($d <= 30) {
                            echo "<option value='" . $d . "' >" . $d . "</option>";
                            $d++;
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;
                    <select class="btn-info btn-xs"  id= "hour" >	
                        <option value='0' selected >hour</option>
                        <?php
                        $h = 1;
                        while ($h <= 23) {
                            echo "<option value='" . $h . "' >" . $h . "</option>";
                            $h++;
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;
                    <select class="btn-info btn-xs"  id= "minute" >	
                        <option value='0' selected >minute</option>
                        <?php
                        $o = 1;
                        while ($o <= 59) {
                            echo "<option value='" . $o . "' >" . $o . "</option>";
                            $o++;
                        }
                        ?>
                    </select>				
                       </div><br/><br/>     	
                            <input type="submit" class="btn btn-primary btn-sm" id = "remind" value = "Set"><br/><br/>
                        </div>
                        <div class="modal-footer">
							<button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
						</div>
                    </div>
                </div>
            </div>
            <!--end modle-->
