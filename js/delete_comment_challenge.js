function del_project_comment(href){
    bootbox.confirm("Do u really want to delete this comment?", function(result) {
	if(result){
        var dataString = 'pID='+ href;
        $.ajax({
            type: "POST",
            url: "ajax/ajax.php",
            data: dataString,
            cache: false,
            success: function(result){
                alert(result);
                location.reload();
				}
			});
		}
	});
}
function delcomment(href) {
	bootbox.confirm("Do u really want to delete this comment?", function(result) {
	if(result){
		var dataString = 'cID='+ href;
		$.ajax({
			type: "POST",
			url: "ajax/ajax.php",
			data: dataString,
			cache: false,
			success: function(result){
				alert(result);
				location.reload();
				}
			});
       }
   });
 }
function delChallenge(href) {
    bootbox.confirm("Do u really want to delete?", function(result) {
	if(result){ 
		var dataString = 'cID='+ href;
		$.ajax({
			type: "POST",
			url: "ajax/delete_chalange.php",
			data: dataString,
			cache: false,
			success: function(result){
				alert(result);
				location.reload();
				}
			});
		}
    });
}
function delProject(href) {
	bootbox.confirm("Do u really want to delete this Project?", function(result) {
	if(result){
		var dataString = 'pID='+ href;
		$.ajax({
			type: "POST",
			url: "ajax/delete_chalange.php",
			data: dataString,
			cache: false,
			success: function(result){
				alert(result);
				location.reload();
				}
			});
		}
    });
}
