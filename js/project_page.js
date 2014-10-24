function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};
	$(document).ready(function(){
	 $(window).scroll(function(event) {
	    if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
         event.preventDefault();
		var dataString = 'proch=10' ;
			  $.ajax({
				type: "POST",
				url: "ajax/next_proch.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					$('#prch').append(result);
					}
			});
		}
});	
var $table = $('table.scroll'),
    $bodyCells = $table.find('tbody tr:first').children(),
    colWidth;

// Adjust the width of thead cells when window resizes
$(window).resize(function() {
    // Get the tbody columns width array
    colWidth = $bodyCells.map(function() {
        return $(this).width();
    }).get();
    
    // Set the width of thead columns
    $table.find('thead tr').children().each(function(i, v) {
        $(v).width(colWidth[i]);
    });    
}).resize();


	
		$("#create_challange_pb_pr").click(function(){
			$("#create_challange_pb_pr").attr('disabled','disabled');
			var challenge = $("#challange").val() ;
			var challenge_title = $("#challange_title").val() ;
			var open_time = parseInt($("#open_time").val());
			var open = parseInt($("#open").val());
			var opentime = parseInt(open_time*60+open) ;
			var eta = parseInt($("#cc_eta").val());
			var etab = parseInt($("#cc_etab").val());
			var etac = parseInt($("#cc_etac").val());
			var etad = parseInt($("#cc_etad").val());
			var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			var type = $("#type").val();
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',challenge)) + '&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + 
			'&challange_eta='+ (challange_eta+='') + '&type='+ type ;
			//alert(dataString);
			if(challenge==''){
				bootstrap_alert(".alert_placeholder", "Challenge can not be empty", 5000,"alert-warning");
			}
			else if(challenge_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
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
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
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
			$("#create_challange_pb_pr").removeAttr('disabled');
			return false;
		});
	});
	$(document).ready(function(){
		$("#create_notes").click(function(){
			$("#create_notes").attr('disabled','disabled');
			var notes = $("#notes").val() ;
			var notes_title = $("#notes_title").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'notes='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',notes)) + '&notes_title='+ notes_title ;
			//alert(dataString);
			if(notes==''){
				bootstrap_alert(".alert_placeholder", "Notes can not be empty", 5000,"alert-warning");
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
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Notes posted succesfully!'){
						$("#notes").val("");
						location.reload();
					}
				}
			});
			}
			$("#create_notes").removeAttr('disabled');
			return false;
		});
	});
	$(document).ready(function(){
		$("#response").click(function(){
			var notes = $("#pr_resp").val() ;
			var id = $("#challenge_id").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'notes='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',notes)) + '&id='+ id ;
			//alert(dataString);
			if(notes==''){
				bootstrap_alert(".alert_placeholder", "Notes can not be empty", 5000,"alert-warning");
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
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
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
	$(document).ready(function(){
		$("#challegeprForm").toggle();
  $("#challengepr").click(function(){
  	$("#taskForm").hide(1500);
  	$("#teamForm").hide(3000);
  	$("#notesForm").hide(1500);
  	$("#manageForm").hide(1500);
    $("#challegeprForm").toggle(3000);
  });

  $("#taskForm").toggle();
  $("#task").click(function(){
  	$("#challegeprForm").hide(1500);
  	$("#taskForm").toggle(1500);
  	$("#teamForm").hide(3000);
  	$("#notesForm").hide(1500);
  	$("#manageForm").hide(1500);
  });
  $("#teamForm").toggle();
  $("#team").click(function(){
  	$("#challegeprForm").hide(1500);
  	$("#taskForm").hide(1500);
  	$("#notesForm").hide(1500);
  	$("#manageForm").hide(3000);
  	$("#teamForm").toggle(1500);
  });
  $("#notesForm").toggle();
  $("#notes").click(function(){
  	$("#challegeprForm").hide(1500);
  	$("#taskForm").hide(1500);
  	$("#teamForm").hide(1500);
  	$("#manageForm").hide(1500);
    $("#notesForm").toggle(3000);
  });
  $("#manageForm").toggle();
  $("#files").click(function(){
  	$("#challegeprForm").hide(1500);
  	$("#taskForm").hide(1500);
  	$("#teamForm").hide(1500);
  	$("#notesForm").hide(1500);
    $("#manageForm").toggle(3000);
  });
});	
