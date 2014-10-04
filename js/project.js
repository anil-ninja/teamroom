	function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
	
	$(document).ready(function(){
		$("#create_project").click(function(){
			var project_title = $("#project_title").val() ;
			var project_stmt = $("#project_stmt").val();
			var eta = $("#eta").val();
			var etab = $("#etab").val();
			var etac = $("#etac").val();
			var etad = $("#etad").val();
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'project_title='+ project_title + '&project_stmt='+ replaceAll(' ','<s>',replaceAll('\n','<br>',project_stmt)) + 
			'&project_eta='+ (((eta*30+etab)*24+etac)*60+etad) ;
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
					
					}
				}
			});
			}
			return false;
		});
	});
