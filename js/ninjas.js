function replaceAll(find, replace, str) {
return str.replace(new RegExp(find, 'g'), replace);
}
function url_domain(data) {
  var    a      = document.createElement('a');
         a.href = data;

  return a.hostname;
}
function getVedioId(str) {
    return str.split('v=')[1];
}

function refineVedioId(str){
	if(str.indexOf('&') === -1){
		return str;
		}
		return str.split('&')[0];
}

	$(document).ready(function(){
    
		$("#submit_ch").click(function(){
      		$("#submit_ch").attr('disabled','disabled');
			var challenge = $("#challange").val() ;
			var domain = url_domain(challenge);
			//alert(domain);
			if (domain == "www.youtube.com"){
				var linkId = refineVedioId(getVedioId(challenge));
				//alert(linkId);
				challenge = "<iframe class=\"youtube\" src=\"//www.youtube.com/embed/";
				challenge = challenge.concat(linkId);
				challenge = challenge.concat(" \"frameborder=\"0\" allowfullscreen ></iframe>");
			}
			//alert(challenge);
			var challenge_title = $("#challange_title").val() ;
			var open_time = parseInt($("#open_time").val());
			var open = parseInt($("#open").val());
			var opentime = parseInt(open_time*60+open) ;
			var eta = parseInt($("#c_eta").val());
			var etab = parseInt($("#c_etab").val());
			var etac = parseInt($("#c_etac").val());
			var etad = parseInt($("#c_etad").val());
			var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br>',challenge)) + '&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + 
			'&challange_eta='+ (challange_eta+='') ;
			//alert(dataString);
			if(challenge==''){
				alert("Please Enter Something !!!");
			}
			else if(challenge_title==''){
				alert("Please Enter Something !!!");
			}
			else
			{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "ajax/submit_chalange.php",
				data: dataString,
				cache: false,
				success: function(result){
					alert(result);
					if(result=='Challange posted succesfully!'){
						$("#challange").val("");
						$("#challange_title").val("");
						$("#open_time").val("");
						$("#open").val("");
						$("#c_eta").val("");
						$("#c_etab").val("");
						$("#c_etac").val("");
						$("#c_etad").val("");
					 location.reload();
					}
				}
			});
			}
      $("#submit_ch").removeAttr('disabled');
			return false;
		});
});

 function getDateTime() {
    var now     = new Date(); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    if(month.toString().length == 1) {
        var month = '0'+month;
    }
    if(day.toString().length == 1) {
        var day = '0'+day;
    }   
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }   
    var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;   
     return dateTime;
}

function startTime() {
    document.getElementById('demo').innerHTML = String(getDateTime());
    t = setTimeout(function () {
        startTime()
    }, 500);
}
