	function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
	
	$(document).ready(function(){
		$("#create_project").click(function(){
			var project_title = $("#project_title").val() ;
			var project_stmt = $("#project_stmt").val();
			var eta = parseInt($("#eta").val());
			var etab = parseInt($("#etab").val());
			var etac = parseInt($("#etac").val());
			var etad = parseInt($("#etad").val());
			var project_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'project_title='+ project_title + '&project_stmt='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',project_stmt)) + 
			'&project_eta='+ (project_eta+='') ;
			//alert(dataString);
			if(project_title==''){
				alert("Please Enter Something !!!");
			}
			else if(project_stmt==''){
				alert("Please Enter Something !!!");
			}
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_project.php",
				data: dataString,
				cache: false,
				success: function(result){
					alert(result);
					if(result=='Project posted succesfully!'){
						$("#project_title").val("");
						$("#project_stmt").val("");
						$("#eta").val("");
						$("#etab").val("");
						$("#etac").val("");
						$("#etad").val("");
						location.reload();
					}
				}
			});
			}
			return false;
		});
	});
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});	

	function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
	
	$(document).ready(function(){
		$("#submit_ch").click(function(){
			$("#submit_ch").attr('disabled','disabled');
			var challenge = $("#challange").val() ;
			var challenge_title = $("#challange_title").val() ;
			var open_time = parseInt($("#open_time").val());
			var open = parseInt($("#open").val());
			var opentime = parseInt(open_time*60+open) ;
			var eta = parseInt($("#c_eta").val());
			var etab = parseInt($("#c_etab").val());
			var etac = parseInt($("#c_etac").val());
			var etad = parseInt($("#c_etad").val());
			var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',challenge)) + '&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + 
			'&challange_eta='+ (challange_eta+='') ;
			//alert(dataString);
			if(challenge==''){
				alert("Please Enter Something !!!");
			}
			else if(challenge_title==''){
				alert("Please Enter Something !!!");
			}
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_chalange.php",
				data: dataString,
				cache: false,
				success: function(result){
					alert(result);
					if(result=='Challange posted succesfully!'){
						$("#challange").val("");
						$("#challange_title").val("");
						$("#open_time").val("");
						$("#open").val("");
						$("#c_eta").val("");
						$("#c_etab").val("");
						$("#c_etac").val("");
						$("#c_etad").val("");
					location.reload();
					}
				}
			});
			}
			return false;
		});
	});
