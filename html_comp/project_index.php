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
</div><br/><br/>
<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
    <ul class="nav nav-tabs">
        <li class="active" >
           <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Outlines </b></span></a>
        </li>
    </ul>
    <div class="tab-content" >
        <div role="tabpanel" class="row tab-pane active" id="tabCreatedProjects"></div>
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
		$chTitle = $shallengesRow['challenge_title'] ;
		if (strlen($chTitle) > 55) {
			$title = substr(ucfirst($chTitle),0,55)."...";
		} 
		else {
			$title = ucfirst($chTitle) ;
		}
		if($type == '1' || $type == '2') {
			$prshallenges.= "<li><a style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
		else if ($type == '5') {
			$tasks.= "<li><a style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
		else if ($type == '6') {
			$notes.= "<li><a style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
		else if ($type == '9') {
			$issues.= "<li><a style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
		else {
			$videos.= "<li><a style='color:#3B5998;' href='challengesOpen.php?challenge_id=".$chId."' target='_blank'>".$title."</a></li>" ;
		}
	}
	if ($prshallenges != "") {
		echo "<span style='font-size:16px;' >Challenges : </span><br/><br/>
				<ul>".$prshallenges."</ul> " ;
	}
	if ($tasks != "") {
		echo "<span style='font-size:16px;' >Tasks : </span><br/><br/>
				<ul>".$tasks."</ul> " ;
	}
	if ($notes != "") {
		echo "<span style='font-size:16px;' >Notes : </span><br/><br/>
				<ul>".$notes."</ul> " ;
	}
	if ($issues != "") {
		echo "<span style='font-size:16px;' >Issues : </span><br/><br/>
				<ul>".$issues."</ul> " ;
	}
	if ($videos != "") {
		echo "<span style='font-size:16px;' >Videos : </span><br/><br/>
				<ul>".$videos."</ul> " ;
	}
	?>
	</div>
</div>

