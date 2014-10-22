$(document).ready(function(){
            $("#add_skill").click(function(){
      		$("#add_skill").attr('disabled','disabled');
			var skill_id = $("#add").val() ;
			
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'skill_id='+skill_id;
			//alert(dataString);
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/add_skill_user.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Skill added succesfully!'){
                                            $("#add").val("");
                                        }
				}
			});
			
      $("#add_skill").removeAttr('disabled');
			return false;
		});
            });