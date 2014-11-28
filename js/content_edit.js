function edit_content(ID) {
		if ( ID != null){
			$("#challenge_"+ID).hide();
			$("#challenge_input_"+ID).show();
			$("#doneedit_"+ID).show();
			$("#challenge_inputaa_"+ID).show();
			}
			else { return false; }
			} ;	
function saveedited(ID)  {				
		var project = convertSpecialChar($("#challenge_input_"+ID).val());
		var dataString = 'id='+ ID +'&projectsmt='+replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',project))));
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
	$(".editbox").hide();
	$(".edit-button").hide();
	$(".text").show(); 
} ;
function convertSpecialChar(str){
		return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
	}
			// Edit input box click action
			$(".editbox").mouseup(function(){
			return false
			});

			// Outside click action
			$(document).mouseup(function(){
			$(".editbox").hide();
			$(".edit-button").hide();
			$(".edit_pic_video_file").hide();
			$(".text").show();
			});
