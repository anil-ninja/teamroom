	$(document).ready(function(){
				$(".edit_tr").click(function(){
					if(var ID=$(this).attr('id')) {
					if ( ID != null){
						$("#project_"+ID).hide();
						$("#project_input_"+ID).show();
					} }
					if (var ID_res=$(this).attr('id_res')) {
						if(ID_res !=null){
							$("#projectres_"+ID_res).hide();
							$("#projectres_input_"+ID_res).show();
						}	}					
						if(var ID_res=$(this).attr('cha_smt')) {
							if(ID_res !=null){
							$("#cha_smt_"+ID_res).hide();
							$("#cha_smt_input_"+ID_res).show();
							} }
							if(var ID_res=$(this).attr('id_res')) {
								if(ID_res !=null){
								$("#challengeres_"+ID_res).hide();
								$("#challengeres_input_"+ID_res).show();
							}	}
					
						}).change(function(){
								if(var ID=$(this).attr('id')) {
								if ( ID != null){
									var project=$("#project_input_"+ID).val();
								
									var dataString = 'id='+ ID +'&projectsmt='+project;
									$("#project_"+ID).html('<img src="load.gif" />'); // Loading image

									if(project.length>0){

										$.ajax({
										type: "POST",
										url: "ajax/edit_project_stmt.php",
										data: dataString,
										cache: false,
										success: function(html){
										$("#project_"+ID).html(project);
										
										}
										});
										}} }
								 if (var ID_res=$(this).attr('id_res')) {
										if (ID_res != null){
											var projectres=$("#projectres_input_"+ID_res).val();
									
									var dataString = 'id='+ ID_res +'&projectsmt='+projectres;
									$("#projectres_"+ID_res).html('<img src="load.gif" />'); // Loading image

									if(projectres.length>0){

										$.ajax({
										type: "POST",
										url: "ajax/edit_project_res_stmt.php",
										data: dataString,
										cache: false,
										success: function(html){
										$("#projectres_"+ID_res).html(projectres);
										
										}
											});
											}}
											else
										alert('Enter something.');
									}
									 if(var ID_res=$(this).attr('cha_smt')) {
										//challange
										if (ID_res != null){
											var projectres=$("#cha_smt_input_"+ID_res).val();
											var dataString = 'id='+ ID_res +'&projectsmt='+projectres;
											$("#cha_smt_"+ID_res).html('<img src="load.gif" />'); // Loading image

											if(projectres.length>0){

												$.ajax({
													type: "POST",
													url: "ajax/edit_cha_smt_stmt.php",
													data: dataString,
													cache: false,
													success: function(html){
													$("#cha_smt_"+ID_res).html(projectres);
												
													}
												});
											}}
											else alert('Enter something.');
										}
									
									 if(var ID_res=$(this).attr('id_res')) {
										//challange
										if (ID_res != null){
											var challengeres=$("#challengeres_input_"+ID_res).val();
											var dataString = 'id='+ ID_res +'&projectsmt='+projectres;
											$("#challengeres_"+ID_res).html('<img src="load.gif" />'); // Loading image

											if(projectres.length>0){

												$.ajax({
													type: "POST",
													url: "ajax/edit_challengeres_stmt.php",
													data: dataString,
													cache: false,
													success: function(html){
													$("#challengeres_"+ID_res).html(projectres);
												
													}
												});
											} }
											else alert('Enter something.');
										}
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
		
