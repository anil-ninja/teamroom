function chatform(userid , username){
			$("#chatform").show();
			$("#chatformdata").show();
			$("#chatformin").show();
			$("#chatformdata").scrollTop($('#chatformdata').height()) ;
			//var username = $("#friendname").val() ;
			//var userid = parseInt($("#friendid").val()) ;
			//alert (userid) ;
			var dataString = 'name='+ username + '&fid='+ userid ;
			$.ajax({
				type: "POST",
				url: "ajax/chatting.php",
				data: dataString,
				cache: false,
				success: function(result){
					var notice = result.split("+") ;
					var neid = parseInt(notice['2']) ;
					document.getElementById("showchatting").innerHTML = notice['0'];
					document.getElementById("showchattingform").innerHTML = notice['1'];
					//document.getElementById("lastchatid").innerHTML = neid+='';
					$("#lastchatid").val(neid+='') ;
				}
			});
			setInterval(function(){ getnewmessages(userid , username) },3000)();
		}; 
$(document).ready(function() {
    $('#chattalk').keydown(function(event) {
        if (event.keyCode == 13) {
            newchat(userid , username);
            return false;
         }
    });
});  
function newchat(userid , username) {
	//var uid = parseInt($("#friendid").val()) ;
	var chat = $("#chattalk").val() ;
	var dataString = 'friendid='+ userid + '&message='+ chat ;
	if (chat == "") {
		alert('enter something') ;
		}
		else {
			$.ajax({
				type: "POST",
				url: "ajax/submitchat.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					if (result == "Posted Successfully!") {
						$("#chattalk").val("") ;
						getnewmessages(userid , username) ;
					}
				}
			});
		}
} ;

function getnewmessages(userid , username) {
	var uid = parseInt($("#lastchatid").val()) ;
	//alert(uid) ;
	//var username = $("#friendname").val() ;
	//var userid = parseInt($("#friendid").val()) ;
	//alert(userid) ;
	var dataString = 'getnew='+ uid + '&name='+ username + '&fid='+ userid;
			$.ajax({
				type: "POST",
				url: "ajax/getnewmessages.php",
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result) ;
					var notice = result.split("+") ;
					var neid = parseInt(notice['1']) ;
					//alert(neid) ;
					$('.newmassages').append(notice['0']);
					//$("#chatformdata").scrollTop($('#chatformdata').height()) ;
					if (neid != 0) {
							$("#lastchatid").val(neid+='') ;
						}
				}
			}); 
		}
