<div style="bottom: 0px; right: 20px; display: block;" class="chatbox" id="chatbox_<?= $projttitle ?>">
<div class="chatboxhead">
	<div class="chatboxtitle"><?= $projttitle ?></div>
	<div class="chatboxoptions">
		<a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth('<?= $projttitle ; ?>')">-</a> 
	</div>
	<br clear="all"/>
</div>
<div class="chatboxcontent">
<?php 
     echo "<div id='newtalks'></div>			   
			<input type='hidden' id='lastprchatid' value='".$idb."'/>" ;
?>
</div>
<div class="chatboxinput">
	<?php 
     echo "<div id='showtalkingform'></div>" ;
?>
</div> 
</div>
