<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
    <ul class="nav nav-tabs">
        <li class="active" >
           <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>About </b></span></a>
        </li>
    </ul>
    <div class="tab-content" >
        <div role="tabpanel" class="row tab-pane active" id="tabCreatedProjects"></div>
	<?php
	$user_id = $_SESSION['user_id'] ;
	$project_id = mysqli_query($db_handle, "(SELECT a.project_type, a.project_title, a.creation_time, a.stmt, b.first_name, b.last_name, b.username FROM
											projects as a join user_info as b WHERE a.project_id = '$pro_id' and a.blob_id = '0' and a.user_id = b.user_id )
											UNION
											(SELECT a.project_type, a.project_title, a.creation_time, b.stmt, c.first_name, c.last_name, c.username FROM projects as a
											join blobs as b join user_info as c WHERE a.project_id = '$pro_id' and a.blob_id = b.blob_id and a.user_id = c.user_id ) ;");
	$project_idrow = mysqli_fetch_array($project_id) ; 
	$stmt =  $project_idrow['stmt'] ;
	$title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_idrow['project_title']))) ;
	$time = $project_idrow['creation_time'] ;
	$ownerfname = $project_idrow['first_name'] ;
	$ownerlname = $project_idrow['last_name'] ;
	$owneruname = $project_idrow['username'] ;
	$project_type = $project_idrow['project_type'] ;
	$timfunct = date("j F, g:i a", strtotime($time));
	if($project_type == 1) {
		$type = "Public" ;
	}
	else {
		$type = "Private" ;
	}
	if(substr($stmt, 0, 4) == '<img') {
		$cha = strstr($stmt, '<br/>' , true) ;
	}
	else if(substr($stmt, 0, 5) == ' <img') {
		$cha = strstr($stmt, '<br/>' , true) ;
	}
	else {
		$cha = "<img src='fonts/project.jpg'  onError=this.src='img/default.gif'>" ;
	}
	$collaborators = mysqli_query($db_handle, "select DISTINCT user_id from teams where project_id = '$pro_id' and member_status = '1' ;") ;
	$collaboratorNo = mysqli_num_rows($collaborators) ;
	echo $cha."<br/><br/>
		<div class ='row-fluid' style='margin: 4px;'><span class='color strong' style= 'font-size: 14pt;'>
			".ucfirst($title)."</span>
		</div><br/>
		<div class ='row-fluid' style='margin: 4px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Owner</b>
			</div>
			<div class='span7 offset1' >
				: <a href ='profile.php?username=".$owneruname."'>
					".ucfirst($ownerfname)." ".ucfirst($ownerlname)."
				</a>
			</div>
		</div> 
		<div class ='row-fluid' style='margin: 4px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Created On</b>
			</div>
			<div class='span7 offset1' >
				: ".$timfunct."
			</div>
		</div> 
		<div class ='row-fluid' style='margin: 4px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Type</b> 
			</div>
			<div class='span7 offset1' >
				: ".$type."
			</div>
		</div>
		<div class ='row-fluid' style='margin: 4px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Collaborators</b>
			</div>
			<div class='span7 offset1' >
				: ".$collaboratorNo."
			</div>
		</div> 
		<div class ='row-fluid' style='margin: 4px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Funded</b> 
			</div>
			<div class='span7 offset1' >
				: No
			</div>
		</div><br/>" ;
	if($project_type == 1) {
		$user_exist = mysqli_query($db_handle, "select DISTINCT user_id from teams where project_id = '$pro_id' and user_id = '$user_id' ;") ;
		$user_existNo = mysqli_num_rows($user_exist) ;
		if($user_existNo == 0) {
			echo "<button class='btn-link' onclick='joinproject(".$pro_id.")'>Join</button>" ;
			if(isset($_SESSION['user_id'])) {
				echo "<button id='demo2' class='btn-primary pull-right' onclick='toggle()'> Message</button>" ;
			}
		}
		else {
			echo "<button id='demo2' class='btn-primary pull-right' onclick='toggle()'> Message</button>" ;
		}
	}
	else {
		echo "<button id='demo2' class='btn-primary pull-right' onclick='toggle()'> Message</button>" ;
	}
	?>
</div>
</div><br/>
<div id='step12' class="panel panel-default">
		<div class="panel-heading" style="padding: 5px;" role="tab" id="headingThree">
			<a class="" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				<i class='icon-zoom-in'></i>&nbsp;
				Eagle Eye View
				<i class='icon-chevron-down pull-right'></i>
			</a>
		</div>
		<div id="collapseFive" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingThree">
		<div class="panel-body" style="padding: 1px;">
			<li><button class='btn-link' style='color: #000' id='sign' ><span class='icon-question-sign'></span> Open challenges</button></li>
			<li><button class='btn-link' style='color: #000' id='deciduous' ><span class='icon-leaf'></span> Notes </button></li>
			<li><button class='btn-link' style='color: #000' id='pushpin' ><span class='icon-pushpin'></span> Tasks</button></li>
			<li><button class='btn-link' style='color: #000' id='filmprj' ><span class='icon-film'></span> Videos</button></li>
			<li><button class='btn-link' style='color: #000' id='flag' ><span class='icon-flag'></span> Completed challenges </button></li>
		</div>
	</div>
    </div>
