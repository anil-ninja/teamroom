
	$(document).ready(function(){
		$("#create_challange_pb_pr").click(function(){
			$("#create_challange_pb_pr").attr('disabled','disabled');
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
			var type = $("#type").val();
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',challenge)) + '&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + 
			'&challange_eta='+ (challange_eta+='') + '&type='+ type ;
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
				url: "ajax/submit_chalange_project.php",
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
						$("#type").val("");
						location.reload();
					}
				}
			});
			}
			return false;
		});
	});
	$(document).ready(function(){
		$("#create_notes").click(function(){
			$("#create_notes").attr('disabled','disabled');
			var notes = $("#notes").val() ;
			var notes_title = $("#notes_title").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'notes='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',notes)) + '&notes_title='+ notes_title ;
			//alert(dataString);
			if(notes==''){
				alert("Please Enter Something !!!");
			}
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_notes.php",
				data: dataString,
				cache: false,
				success: function(result){
					alert(result);
					if(result=='Notes posted succesfully!'){
						$("#notes").val("");
						location.reload();
					}
				}
			});
			}
			return false;
		});
	});
	$(document).ready(function(){
		$("#challenge_of_project_response").click(function(){
			$("#challenge_of_project_response").attr('disabled','disabled');
			var notes = $("#challenge_of_pr_resp").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challenge_of_pr_resp='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',notes)) ;
			//alert(dataString);
			if(challenge_of_pr_resp==''){
				alert("Please Enter Something !!!");
			}
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_project_challenge_response.php",
				data: dataString,
				cache: false,
				success: function(result){
					alert(result);
					if(result=='Comment posted succesfully!'){
						$("#challenge_of_pr_resp").val("");
						location.reload();
					}
				}
			});
			}
			return false;
		});
		     $('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});	
            $('#example')
            .removeClass( 'display' )
            .addClass('table table-striped table-bordered');
            
    function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
	
	});
