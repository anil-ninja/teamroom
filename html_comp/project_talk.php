<div style="bottom: 0px; right: 20px; display: block;" class="chatbox" id="chatbox_<?= $pro_id ?>">
<div class="chatboxhead">
	<div class="chatboxtitle">Project Conversation</div>
	<div class="chatboxoptions">
		<a onclick="toggle()" style ='cursor: pointer;'>-</a> 
	</div>
	<br clear="all"/>
</div>
<div class="chatboxcontent" id="project_chat_data">
<?php 
     echo "<div id='newtalks'></div>			   
			<input type='hidden' id='lastprchatid' value='".$idb."'/>" ;
?>
</div>
<div class="chatboxinput" id="project_chat_form">
	<?php 
     echo "<div id='showtalkingform'></div>" ;
?>
</div> 
</div>
