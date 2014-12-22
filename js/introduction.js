function check_page_url(url) {
	var dataString = 'url=' + url ;
	$.ajax({
		type: "POST",
		url: "ajax/check.php",
		data: dataString,
		cache: false,
		success: function(result){
			if(result == 1) {
				profile_intro() ;
				}
		}
	});
}

function profile_intro() {
	alert('hiii') ;
	}
