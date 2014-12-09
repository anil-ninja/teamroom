function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');

  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};

function delcomment(ID, type) {
	bootbox.confirm("Do u really want to delete this comment?", function(result) {
	if(result){
		var dataString = 'id='+ ID + '&type=' + type;
		$.ajax({
			type: "POST",
			url: "ajax/delete_chalange.php",
			data: dataString,
			cache: false,
			success: function(result){
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
				location.reload();
				}
			});
       }
   });
 }
function delChallenge(ID, type) {
    bootbox.confirm("Do u really want to delete?", function(result) {
	if(result){ 
		var dataString = 'id='+ ID + '&type=' + type ;
		$.ajax({
			type: "POST",
			url: "ajax/delete_chalange.php",
			data: dataString,
			cache: false,
			success: function(result){
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
				location.reload();
				}
			});
		}
    });
}

function spem(ID, type) {
	bootbox.confirm("Sure To Spam?", function(result) {
	if(result){
		var dataString = 'id='+ ID + '&type=' + type ;
		$.ajax({
			type: "POST",
			url: "ajax/delete_chalange.php",
			data: dataString,
			cache: false,
			success: function(result){
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
				location.reload();
				}
			});
		}
    });
}
