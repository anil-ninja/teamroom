<div class="bs-component">
    <br/><b>
    <a data-toggle='modal' class='btn btn-link' style='cursor:pointer;'><i class='glyphicon glyphicon-bell'></i>
      <font size="2"><b>Tasks -- to do</b></font></a><hr>
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
				
                </a>
                <p style='font-size:8pt; color:rgba(161, 148, 148, 1); text-align: left;'>" . $remaining_time_own . "</p></button><br/>";
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
                </a>
                <p style='font-size:8pt; color:rgba(161, 148, 148, 1);text-align: left;'>" . $remaining_time_ownas . "</p>  </button><br/>";
    }
    ?>
</div>
