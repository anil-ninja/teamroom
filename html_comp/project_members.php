<div class="bs-component">
	<div style="padding-top:20px;">
<?php
$pro_id = $_GET['project_id'] ;
//echo $pro_id ;
$userProjects = mysqli_query($db_handle, "SELECT DISTINCT user_id FROM teams where user_id != '$user_id' and project_id = '$pro_id' ;");
while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
	$useridFriends = $userProjectsRow['user_id'];
	//echo $useridFriends ;
	$projectmembers = mysqli_query($db_handle, "SELECT first_name, last_name, username FROM user_info where user_id = '$useridFriends' ;");
	$projectmembersRow = mysqli_fetch_array($projectmembers) ;
	$friendFirstName = $projectmembersRow['first_name'];
	$friendLastName = $projectmembersRow['last_name'];
	$usernameFriends = $projectmembersRow['username'];
	
	$tooltip = ucfirst($friendFirstName)." ".ucfirst($friendLastName);
	//echo $tooltip ;	   
	echo "
			<input type='hidden' id='friendname' value = '".$usernameFriends."'/>
		  <input type='hidden' id='friendid' value = '".$useridFriends."'/>
		  <button class='btn-link' data-toggle='tooltip' onclick = 'chatform(\"".$useridFriends."\",\"".$usernameFriends."\")' data-placement='bottom' data-original-title='".$tooltip."'>
				<img src='uploads/profilePictures/$usernameFriends.jpg'  style='width:30px; height:30px; margin-bottom:5px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
		  </button>";
}
?>
</div>
</div>
<div class='footer' id='chatform' style='margin-left: 1000px; margin-right: 50px; margin-bottom: 50px; height: 300px; display: none ;'><span class='badge' style='margin-right: 0; cursor: pointer; margin-bottom: 345px; margin-left: 280px;' onclick='closechat()'>x</span></div>  
<div class='footer' id='chatformdata' style='margin-left: 1005px; margin-right: 65px; margin-bottom: 65px; height: 270px; padding-top : 0; overflow-y: auto; overflow-x: hidden; display: none ;'>  
<?php 
     echo "<div id='showchatting'></div>			   
			<input type='hidden' id='lastchatid' value='".$idb."'/>" ;
?>
</div>
<div class='footer' id='chatformin' style='margin-left: 1000px; margin-right: 50px; margin-bottom: 0; height: 50px; display: none ;'>
<?php 
     echo "<div id='showchattingform'></div>" ;
?>
</div>
