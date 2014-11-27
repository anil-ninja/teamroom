$(document).ready(function(){
	$(".edit_tr").click(function(){
		var ID=$(this).attr('id') ;
		if ( ID != null){
			$("#challenge_"+ID).hide();
			$("#challenge_input_"+ID).show();
			}
			else { return false; } 				
			}).change(function(){
					var ID=$(this).attr('id') ;
					if ( ID != null){
						var project=$("#challenge_input_"+ID).val();
					
						var dataString = 'id='+ ID +'&projectsmt='+project;
						$("#project_"+ID).html('<img src="load.gif" />'); // Loading image

						if(project.length>0){

							$.ajax({
							type: "POST",
							url: "ajax/edit_cha_stmt.php",
							data: dataString,
							cache: false,
							success: function(html){
							$("#challenge_"+ID).html(project);
							}
							});
							}
							} }) ;
						});

			// Edit input box click action
			$(".editbox").mouseup(function(){
			return false
			});

			// Outside click action
			$(document).mouseup(function(){
			$(".editbox").hide();
			$(".text").show();
			});
		
