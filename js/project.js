	function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};	
	$(document).ready(function(){
		$("#create_project").click(function(){
			$("#create_project").attr('disabled','disabled');
			var project_title = $("#project_title").val() ;
			var project_stmt = $("#project_stmt").val();
			var type = $("#type").val();
			var eta = parseInt($("#eta").val());
			var etab = parseInt($("#etab").val());
			var etac = parseInt($("#etac").val());
			var etad = parseInt($("#etad").val());
			var project_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'project_title='+ project_title + '&project_stmt='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',project_stmt)) + 
			'&project_eta='+ (project_eta+='') + '&type='+ type ;
			//alert(dataString);
			if(project_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else if(project_stmt==''){
				bootstrap_alert(".alert_placeholder", "Project can not be empty", 5000,"alert-warning");
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
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
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
			$("#create_project").removeAttr('disabled');
			return false;
		});
	});
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});	

	function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
