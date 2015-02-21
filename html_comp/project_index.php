<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
    <ul class="nav nav-tabs">
        <li class="active" >
           <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Outlines </b></span></a>
        </li>
    </ul>
    <div class="panel-default">
	<?php
	$user_id = $_SESSION['user_id'] ;
	$prshallenges = "";
	$tasks = "";
	$notes = "";
	$issues = "";
	$videos = "";
	$shallenges = mysqli_query($db_handle, "select challenge_type, challenge_id, challenge_title from challenges where project_id = '$pro_id' and challenge_status != '3' and challenge_status != '7' ;") ;
	while ($shallengesRow = mysqli_fetch_array($shallenges)) {
		$type = $shallengesRow['challenge_type'] ;
		$chId = $shallengesRow['challenge_id'] ;
		$chTitle = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $shallengesRow['challenge_title'])))) ;
		if (strlen($chTitle) > 55) {
			$title = substr(ucfirst($chTitle),0,55)."...";
		} 
		else {
			$title = ucfirst($chTitle) ;
		}
		if($type == '1' || $type == '2') {
			$prshallenges.= "<li style='padding-left:10px;'><a href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
		else if ($type == '5') {
			$tasks.= "<li style='padding-left:10px;'><a href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
		else if ($type == '6') {
			$notes.= "<li style='padding-left:10px;'><a href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
		else if ($type == '9') {
			$issues.= "<li style='padding-left:10px;'><a href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
		else {
			$videos.= "<li style='padding-left:10px;'><a href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
	}
	if(mysqli_num_rows($shallenges) != '0') {
		if ($prshallenges != "") {
			echo "<nav class='sidebar light'>
					<ul>
						<div class='bs-component' style='max-height:150px;'>
						<li class='title'>Challenges </li>
						".$prshallenges."
						</div>
					</ul>
				</nav> " ;
		}
		if ($tasks != "") {
			echo "<nav class='sidebar light'>
					<ul>
						<div class='bs-component' style='max-height:150px;'>
						<li class='title'>Tasks </li>
						".$tasks."
						</div>
					</ul>
				</nav> " ;
		}
		if ($notes != "") {
			echo "<nav class='sidebar light'>
					<ul>
						<div class='bs-component' style='max-height:150px;'>
						<li class='title'>Notes </li>
						".$notes."
						</div>
					</ul>
				</nav> " ;
		}
		if ($issues != "") {
			echo "<nav class='sidebar light'>
					<ul>
						<div class='bs-component' style='max-height:150px;'>
						<li class='title'>Issues </li>
						".$issues."
						</div>
					</ul>
				</nav> " ;
		}
		if ($videos != "") {
			echo "<nav class='sidebar light'>
					<ul>
						<div class='bs-component' style='max-height:150px;'>
						<li class='title'>Videos </li>
						".$videos."
						</div>
					</ul>
				</nav> " ;
		}
	}
	else {
		echo "No Data Available";
	}
	?>
	</div>
</div><br/><br/>
<div id='step12' class="panel panel-default">
	<div class="panel-heading" style="padding: 5px;" role="tab" id="headingThree">
		<a class="" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
			<i class='icon-zoom-in'></i>&nbsp;	Eagle Eye View <i class='icon-chevron-down pull-right'></i>
		</a>
	</div>
	<div id="collapseFive" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingThree">
		<div class="panel-body" style="padding: 1px;">
			<button class='btn-link' style='color: #000' id='eye_open' ><span class='icon-eye-open'></span> ALL</button><br/>
			<button class='btn-link' style='color: #000' id='sign' ><span class='icon-question-sign'></span> Open challenges</button><br/>
			<button class='btn-link' style='color: #000' id='deciduous' ><span class='icon-leaf'></span> Notes </button><br/>
			<button class='btn-link' style='color: #000' id='pushpin' ><span class='icon-pushpin'></span> Tasks</button><br/>
			<button class='btn-link' style='color: #000' id='filmprj' ><span class='icon-film'></span> Videos</button><br/>
			<button class='btn-link' style='color: #000' id='flag' ><span class='icon-flag'></span> Completed challenges </button><br/>
			<button class='btn-link' style='color: #000' id='asterisk' ><span class='icon-asterisk'></span> Issues </button>
		</div>
	</div>
</div>
