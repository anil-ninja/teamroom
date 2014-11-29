<div class="bs-component">
<div style="padding-top:20px;">
<?php
$idb = 0 ;
$userProjects = mysqli_query($db_handle, "SELECT * FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
										where a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id')
										as b where a.user_id = b.user_id ;");
while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
	$friendFirstName = $userProjectsRow['first_name'];
	$friendLastName = $userProjectsRow['last_name'];
	$usernameFriends = $userProjectsRow['username'];
	$useridFriends = $userProjectsRow['user_id'];
	$tooltip = ucfirst($friendFirstName)." ".ucfirst($friendLastName);
		   
	echo "<a href=\"javascript:void(0)\" onclick=\"javascript:chatWith('".$usernameFriends."')\">
			<img src='uploads/profilePictures/$usernameFriends.jpg'  style='width:30px; height:30px; margin-bottom:5px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
		  </a>";
}
?>

</div>
<!---<div class='footer' id='chatform' style='margin-left: 1000px; margin-right: 50px; margin-bottom: 50px; height: 300px; display: none ;'><span class='badge' style='margin-right: 0; cursor: pointer; margin-bottom: 345px; margin-left: 280px;' onclick='closechat()'>x</span></div>  
<div class='footer' id='chatformdata' style='margin-left: 1005px; margin-right: 65px; margin-bottom: 65px; height: 270px; padding-top : 0; overflow-y: auto; overflow-x: hidden; display: none ;'>  
<?php /*
     echo "<div id='showchatting'></div>			   
			<input type='hidden' id='lastchatid' value='".$idb."'/>" ;
?>
</div>
<div class='footer' id='chatformin' style='margin-left: 1000px; margin-right: 50px; margin-bottom: 0; height: 50px; display: none ;'>
<?php 
     echo "<div id='showchattingform'></div>" ;
*/ ?>
</div> --->
</div>
