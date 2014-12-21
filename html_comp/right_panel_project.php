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
	$project_id = mysqli_query($db_handle, "SELECT * FROM projects as a join user_info as b WHERE a.project_id = '$pro_id' and a.user_id = b.user_id ;");
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
	else {
		$cha = "<img src='fonts/project.gif'  onError=this.src='img/default.gif'>" ;
	}
	$collaborators = mysqli_query($db_handle, "select DISTINCT user_id from teams where project_id = '$pro_id' ;") ;
	$collaboratorNo = mysqli_num_rows($collaborators) ;
	echo $cha."<br/><br/>
		<div class ='row-fluid' style='margin: 4px -15px 4px -15px;font-size: 20px; color: blue;'>
			".ucfirst($title)."
		</div><br/>
		<div class ='row-fluid' style='margin: 4px -15px 4px -15px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Owner</b>
			</div>
			<div class='span7 offset1' >
				: <a href ='profile.php?username=".$owneruname."'>
					".ucfirst($ownerfname)." ".ucfirst($ownerlname)."
				</a>
			</div>
		</div> 
		<div class ='row-fluid' style='margin: 4px -15px 4px -15px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Created On</b>
			</div>
			<div class='span7 offset1' >
				: ".$timfunct."
			</div>
		</div> 
		<div class ='row-fluid' style='margin: 4px -15px 4px -15px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Type</b> 
			</div>
			<div class='span7 offset1' >
				: ".$type."
			</div>
		</div>
		<div class ='row-fluid' style='margin: 4px -15px 4px -15px; background : rgb(240, 241, 242);'>
			<div class='span4'>
				<b>Collaborators</b>
			</div>
			<div class='span7 offset1' >
				: ".$collaboratorNo."
			</div>
		</div> 
		<div class ='row-fluid' style='margin: 4px -15px 4px -15px; background : rgb(240, 241, 242);'>
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
			echo "<button class='btn-link' onclick='joinproject(".$idproject2.")'>Join</button>" ;
			if(isset($_SESSION['user_id'])) {
				echo "<button class='btn-primary' onclick='toggle()'> Message</button>" ;
			}
		}
		else {
			echo "<button class='btn-primary' onclick='toggle()'> Message</button>" ;
		}
	}
	else {
		echo "<button class='btn-primary' onclick='toggle()'> Message</button>" ;
	}
	?>
</div>
</div>
