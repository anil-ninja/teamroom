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
	$project_id = mysqli_query($db_handle, "(SELECT a.project_type, a.user_id, a.project_title, a.creation_time, a.stmt, b.first_name, b.last_name, b.username FROM
											projects as a join user_info as b WHERE a.project_id = '$pro_id' and a.blob_id = '0' and a.user_id = b.user_id )
											UNION
											(SELECT a.project_type, a.user_id, a.project_title, a.creation_time, b.stmt, c.first_name, c.last_name, c.username FROM projects as a
											join blobs as b join user_info as c WHERE a.project_id = '$pro_id' and a.blob_id = b.blob_id and a.user_id = c.user_id ) ;");
	$project_idrow = mysqli_fetch_array($project_id) ; 
	$stmt =  $project_idrow['stmt'] ;
	$title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&", $project_idrow['project_title']))) ;
	$time = $project_idrow['creation_time'] ;
	$ownerfname = $project_idrow['first_name'] ;
	$owner = $project_idrow['user_id'] ;
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
		$ProjectPic4 = strstr($stmt, '<br/>' , true) ;
	}
	else {
		$ProjectPic4 = "<img src=\"fonts/project.jpg\"  onError=this.src='img/default.gif'>" ;
	}
	$aboutfund = mysqli_query($db_handle, "select * from project_funding_info where project_id = '$pro_id' ;") ;
	if(mysqli_num_rows($aboutfund) == 0) {
		$funded = "No" ;
	}
	else {
		$funded = "Yes" ;
	}
	$ProjectPicLink4 =explode("\"",$ProjectPic4)['1'] ; 				
	$ProjectPic4 = "<img src='".resize_image($ProjectPicLink4, 280, 280, 1)."' onError=this.src='img/default.gif' style='width:100%;'>" ;				
	$collaborators = mysqli_query($db_handle, "select DISTINCT user_id from teams where project_id = '$pro_id' and member_status = '1' and user_id !='0' ;") ;
	$collaboratorNo = mysqli_num_rows($collaborators) ;
	echo $ProjectPic4."<br/><br/>
		<div class ='row-fluid' style='margin: 4px;'><span class='color strong' id='projectTitle_".$pro_id."' style= 'font-family: Tenali Ramakrishna, sans-serif;font-size: 24px;'>
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
				: ".$funded."
			</div>
		</div>";
	if(mysqli_num_rows($aboutfund) != 0) {
		$aboutfundRow = mysqli_fetch_array($aboutfund) ;
		echo "<div class ='row-fluid' style='margin: 4px; background : rgb(240, 241, 242);'>
				<div class='span5'>
					<b>Project Value</b> 
				</div>
				<div class='span5 offset1' style='margin-left: 7px;' >
					: ".$aboutfundRow['project_value']." $
				</div>
			</div>
			<div class ='row-fluid' style='margin: 4px; background : rgb(240, 241, 242);'>
				<div class='span5'>
					<b>Fund Needed</b> 
				</div>
				<div class='span5 offset1'style='margin-left: 7px;' >
					: ".$aboutfundRow['fund_neede']." $
				</div>
			</div>" ;
		$fundraised = mysqli_query($db_handle, "select * from investment_info where project_id = '$pro_id' ;") ;
		if (mysqli_num_rows($fundraised) > 0){
			$total = 0 ;
			while ($fundraisedRow = mysqli_fetch_array($fundraised)) {
				$total += $fundraisedRow['investment'] ;
			}
			echo "<div class ='row-fluid' style='margin: 4px; background : rgb(240, 241, 242);'>
					<div class='span5'>
						<b>Fund Raised</b> 
					</div>
					<div class='span5 offset1' style='margin-left: 7px;' >
						: ".$total." $
					</div>
				</div>" ;
		}
	}	
	echo "<br/>" ;
	if(isset($_SESSION['user_id'])){
		if ($owner != $user_id) {
			if(mysqli_num_rows($aboutfund) != 0) {
				$usertype = mysqli_query($db_handle, "select * from user_info where user_id = '$user_id' ;") ;
				$usertypeRow = mysqli_fetch_array($usertype) ;
				$TypeUser = $usertypeRow['user_type'] ;
				if($TypeUser == "invester" || $TypeUser == "collaboraterInvester" || $TypeUser == "fundsearcherInvester" || $TypeUser == "collaboraterinvesterfundsearcher"){
					$checkperm = mysqli_query($db_handle, "select * from investment_info where user_id = '$user_id' and project_id = '$pro_id' ;") ;
					if (mysqli_num_rows($checkperm) == 0){
						echo "<a data-toggle='modal' class='btn btn-primary' data-target='#Investment'> Invest </a>" ;
					}
				}
			}
		}
	}	
	if($project_type == 1) {
		if(isset($_SESSION['user_id'])){
			$user_exist = mysqli_query($db_handle, "select DISTINCT user_id from teams where project_id = '$pro_id' and user_id = '$user_id' ;") ;
			$user_existNo = mysqli_num_rows($user_exist) ;
			if($user_existNo == 0) {
					echo "<button class='btn btn-primary' onclick='joinproject(".$pro_id.")'>Join</button>
						  <button id='demo2' class='btn btn-primary pull-right' onclick='toggle()'> Message</button>" ;
			}
			else {
				echo "<button id='demo2' class='btn btn-primary pull-right' onclick='toggle()'> Message</button>" ;
			}
		}
		else {
			echo "<button class='btn btn-primary' onclick='test3()'>Join</button>
				  <button id='demo2' class='btn btn-primary pull-right' onclick='test3()'> Message</button>" ;
		}
	}
	else {
		echo "<button id='demo2' class='btn btn-primary pull-right' onclick='toggle()'> Message</button>" ;
	}
	?>
</div>
</div><br/>
