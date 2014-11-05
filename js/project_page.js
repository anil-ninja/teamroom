function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};
	$(document).ready(function(){	
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

	function uploadFile(_file,typeOfPic,data1,url1){
		var _progress = document.getElementById('_progress');
		
		if(_file.files.length === 0){
				submitCreateArticle("",data1,url1);
				return false ;
		} else {

		var data = new FormData();
		data.append('file', _file.files[0]);

		var request = new XMLHttpRequest();
		var responceTx = "";
		request.onreadystatechange = function(){
			if(request.readyState == 4){
				responceTx = request.response;
				submitCreateArticle(responceTx,data1,url1);
				//alert(responceTx);
				//alert(request.response);
				//return request.response;
				}
			};
		}

		request.upload.addEventListener('progress', function(e){
        _progress.style.width = Math.ceil(e.loaded/e.total) * 100 + '%';
		}, false);
		
		request.open('POST', 'ajax/upload_file.php?typeOfPic='+typeOfPic);
		request.send(data);
		//alert(request.response);
		//alert(responceTx);
		//return responceTx;
		
	}
	function submitCreateArticle(ilink,data,url){
		//alert(ilink) ;
		if (ilink != "") {
		var imgTx = "<img src=\""+ilink+"\" style=\"max-width: 100%;\" />";
		var dataString = data + '&img='+ imgTx ;
		//alert(dataString) ;
		}
			else {
				var	dataString =  data ;
				//alert(dataString) ;			
				}
			$.ajax({
				type: "POST",
				url: url,
				data: dataString,
				cache: false,
				success: function(result){
					//alert(result);
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
					if(result=='Posted succesfully!'){
					location.reload();
					}
				}
			}); 
		}
		$("#create_challange_pb_pr").click(function(){
			$("#create_challange_pb_pr").attr('disabled','disabled');
			//alert("i am geting fucked");
			var challenge = $("#challangepr").val() ;
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
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',challenge)))) + '&challenge_title='+ challenge_title + '&opentime='+ (opentime+='') + 
			'&challange_eta='+ (challange_eta+='') + '&type='+ type ;
			//alert(dataString);
			if(challenge==''){
				bootstrap_alert(".alert_placeholder", "Challenge can not be empty", 5000,"alert-warning");
			}
			else if(challenge_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
			}
			else {
				//file upload
			var _file = document.getElementById('_fileChallengepr');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"projectchalPic",String(dataString),"ajax/submit_chalange_project.php");
			}
		});
	
		$("#create_notes").click(function(){
			$("#create_notes").attr('disabled','disabled');
			var notes = $("#notestmt").val() ;
			var notes_title = $("#notes_title").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'notes='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',notes)))) + '&notes_title='+ notes_title ;
			//alert(dataString);
			if(notes==''){
				bootstrap_alert(".alert_placeholder", "Notes can not be empty", 5000,"alert-warning");
			}
			else {
				//file upload
			var _file = document.getElementById('_fileNotes');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"projectnotesPic",String(dataString),"ajax/submit_notes.php");
			}
		});
		
		$("#answerch").click(function(){
			$("#answerch").attr('disabled','disabled');
			var answerchal = $("#answerchal").val() ;
			var answercid = $("#answercid").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'answer='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',answerchal)))) + '&cid='+ answercid ;
			//alert(dataString);
			if(answerchal==''){
				bootstrap_alert(".alert_placeholder", "Answer can not be empty", 5000,"alert-warning");
			}
			else {
				//file upload
			var _file = document.getElementById('_fileanswer');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"answerPic",String(dataString),"ajax/submit_answer.php");
			}
		});
	});
	$(document).ready(function(){
		$("#response").click(function(){
			var notes = $("#pr_resp").val() ;
			var id = $("#challenge_id").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'notes='+ replaceAll('  ',' <s>',replaceAll('\n','<br/>',replaceAll("'",'<r>',replaceAll('&','<a>',notes)))) + '&id='+ id ;
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

//allPanels
		$("#eye_open").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".sign").show(1000);
  	$(".deciduous").show(1000);
  	$(".pushpin").show(1000);
  	$(".flag").show(1000);
  });
$("#sign").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".pushpin").hide(1000);
  	$(".deciduous").hide(1000);
  	$(".flag").hide(1000);
    $(".sign").show(1000);
  });
  $("#deciduous").click(function(){
	 // alert("I am pencil!!! :)");
  	$(".sign").hide(1000);
  	$(".pushpin").hide(1000);
  	$(".flag").hide(1000);
    $(".deciduous").show(1000);
  });
  $("#pushpin").click(function(){
  	$(".sign").hide(1000);
  	$(".deciduous").hide(1000);
  	$(".flag").hide(1000);
    $(".pushpin").show(1000);
  });
  $("#flag").click(function(){
  	$(".sign").hide(1000);
  	$(".flag").show(1000);
  	$(".pushpin").hide(1000);
  	$(".deciduous").hide(1000);
  });
});	
