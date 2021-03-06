function show_search_results(challenges){
   var resp = "<div class='list-group'><div class='list-group-item'> <p style='line-height: 20.50px;font-size: 15px'>Search Results</p></div>";
   for (var i = 0; i < challenges.length; i++) {
      var resultNumber = i+1;
      resp = resp +"<div class='list-group-item'><div class ='row'><div class='col-md-1' style = 'width : 1%;'>"+"</div><div class ='col-md-9'> <a class='btn btn-link' style='color:#3B5998;' href='challengesOpen.php?challenge_id="+challenges[i].challenge_id+"'>"+challenges[i].challenge_title+"</a><br>&nbsp;&nbsp;"+challenges[i].stmt+"..</br></div></div></div>"; 
   }
   return resp+"</div>";
}

function show_search_results_id(challenges){
   var id = "";
   for (var i = 0; i < challenges.length; i++) {
      id = id + challenges[i].challenge_id+"<br/>" ; 
   }
   return id;
}

$(document).ready(function() {
   $('#searchfor').keydown(function(event) {
       if (event.keyCode == 13) {
          searchingform();
          return false;
       }
   });
});

(function() {showUp();})();

function showUp() {
	var dataString = 'notice=true' ;
	$.ajax({
		type: "POST",
		url: "ajax/notifications.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			var notice = result.split("|+") ;
			document.getElementById("notifications").innerHTML = notice['0'];
			document.getElementById("notificationlastid").innerHTML = notice['1'];
		}
	});
}

function timeStamp() {
// Create a date object with the current time
	var now = new Date();
 
// Create an array with the current month, day and time
	var date = [ now.getFullYear(), now.getMonth() + 1, now.getDate() ];
 
// Create an array with the current hour, minute and second
	var time = [ now.getHours(), now.getMinutes(), now.getSeconds()];
 
// If seconds and minutes are less than 10, add a zero
	for ( var i = 0; i < 3; i++ ) {
		if ( time[i] < 10 ) {
			time[i] = "0" + time[i];
		}
	}
// Return the formatted string
	return date.join("/") + " " + time.join(":") ;
}

setInterval(function(){
	var eid = $("#lasteventid").val() ;
	var time = timeStamp() ;
	//alert (time + "," + eid) ;
	getnewnote(time, eid) ;
},300000);

function getnewnote(time, lid) {	
	var dataString = 'time='+ time + '&lid=' + lid ;
	//alert(dataString) ;
	$.ajax({
		type: "POST",
		url: "ajax/newnote.php",
		async: false ,
		data: dataString,
		cache: false,
		success: function(result){
			if(result == "no new notification") { 
			}
			else {
				var notice = result.split("|+") ;
				$('.newnotices').append(notice['0']);
				var num = document.getElementById("countnotice").innerHTML ;
				var newnum = parseInt(parseInt(num)+parseInt(notice['1'])) ;
				var neid = parseInt(notice['2']) ;
				if (neid+='' != 0) {
					document.getElementById("countnotice").innerHTML = newnum ;
				}
				if (newnum+='' != 0) {
					$("#lasteventid").val(neid+='') ;
				}
			}
		}
	});
}

function getallnotices() {
	$('#allnotices').append("<div class='loading'><center><img src='img/loading.gif' /></center></div>");
	var dataString = 'all=true' ; 
	$.ajax({
		type: "POST",
		url: "ajax/allnotices.php",
		data: dataString,
		cache: false,
		success: function(result){
			document.getElementById("allnotices").innerHTML = result ;
			$('.loading').remove();
		}
	});
} 

function searchingform() {
	var keyword1 = $("#searchfor").val() ;
	var dataString = 'keyword='+ keyword1 ;
	if(replaceAll('\\s', '',keyword1)==''){
		alert("Please Enter Something !!!");
	}	
	else {
		$.ajax({
			type: "GET",
			url: "search.php",
			data: dataString,
			cache: false,
			success: function(result){
				challenges = JSON.parse(result);
				document.getElementById("home-ch").innerHTML = show_search_results(challenges);			
			}
		});
	}
};
