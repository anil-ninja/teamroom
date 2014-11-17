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

function updatetime() {
	var update = "update" ;
	var dataString = 'update='+ update ;
	setTimeout(function(){
			$.ajax({
				type: "POST",
				url: "ajax/updatetime.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					if (result == "Updated Successfully") {
						location.reload() ;
						}
				}
			}); 
			} , 10000) ;
		}
setInterval(function(){
		var time = $("#sessiontime").val() ;
		var uid = $("#noteiceid").val() ;
		var eid = $("#lasteventid").val() ;
		//alert (eid) ;
		getnewnote(time, uid, eid) ;
},60000)();
function getnewnote(unix, id, lid) {	
	//alert (unix) ;
	var dataString = 'time='+ unix + '&uid=' + id + '&eid=' + lid ;
			$.ajax({
				type: "POST",
				url: "ajax/newnote.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					var notice = result.split("+") ;
					//alert (notice['0']) ;
					//document.getElementById("newtalks").innerHTML = result ;
					$('.newnotices').append(notice['0']);
					var num = $("#countnotice").val() ;
					var newnum = parseInt(parseInt(num)+parseInt(notice['1'])) ;
					var neid = parseInt(notice['2']) ;
					//alert(notice['1']) ;
					$("#countnotice").val(newnum+='') ;
					$("#lasteventid").val(neid+='') ;
				}
			});
}
     function searchingform() {
            var keyword1 = $("#searchfor").val() ;
            //alert(keyword1);
            var dataString = 'keyword='+ keyword1 ;
            //alert(dataString);
            if(keyword1==''){
                alert("Please Enter Something !!!");
            }	else {
                $.ajax({
                    type: "GET",
                    url: "search.php",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        //alert(result);
                        challenges = JSON.parse(result);
                        //alert(challenges);
                        //alert(show_search_results(challenges));
                        document.getElementById("home-ch").innerHTML = show_search_results(challenges);
                        //document.getElementById("home").innerHTML = show_search_results_id(challenges);
                        //alert(show_search_results(challenges));
                        //alert(challenges[0].stmt);			
                    }
                });
            }
        };
