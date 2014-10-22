function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};
$(document).ready(function(){
            $("#addskills").click(function(){
      		$("#addskills").attr('disabled','disabled');
			var insert = $("#insert").val() ;
			var skills = $("#skills").val() ;
			
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'skills=' + skills + '&insert=' + insert ;
			//alert(dataString);
			// AJAX Code To Submit Form.
                        if ((insert =='') AND (skills == '0'))
                            {
                                bootstrap_alert(".alert_placeholder", "Skills can not be empty", 5000,"alert-warning");
                            }
                          else if ((insert =='insert') AND (skills == 'skills'))
                            {
                                bootstrap_alert(".alert_placeholder", "Either select OR enter", 5000,"alert-warning");
                            }
                        else {
			$.ajax({
				type: "POST",
				url: "ajax/add_remove_skill.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Skill added succesfully!'){
                                            $("#skills").val("");
                                            $("#insert").val("");
                                            location.reload();
                                        }
				}
			});
                            }
			
                        $("#addskills").removeAttr('disabled');
                                            return false;
		});
        $("#remove_skill").click(function(){
      		$("#remove_skill").attr('disabled','disabled');
			var skill_id = $("#remove").val() ;
                      // Returns successful data submission message when the entered information is stored in database.
			var dataString = 'skill_id='+skill_id;
			//alert(dataString);
			// AJAX Code To Submit Form.
                        if (skill_id == '0') {
                             bootstrap_alert(".alert_placeholder", "Please Select a skill", 5000,"alert-warning");
                        }
                        else {
			$.ajax({
				type: "POST",
				url: "ajax/add_remove_skill.php",
				data: dataString,
				cache: false,
				success: function(result){
                                    //alert(result);
                                    bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
                                    if(result=='Skill removed succesfully!'){
                                        $("#remove").val("");
                                    }
				}
			});
                        }
      $("#remove_skill").removeAttr('disabled');
			return false;
		});    
        });
