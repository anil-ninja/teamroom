function bootstrap_alert(elem, message, timeout,type) {
  $(elem).show().html('<div class="alert '+type+'" role="alert" style="overflow: hidden; position: fixed; left: 50%;transition: transform 0.3s ease-out 0s; width: auto;  z-index: 1050; top: 50px;  transition: left 0.6s ease-out 0s;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
  if (timeout || timeout === 0) {
    setTimeout(function() { 
      $(elem).show().html('');
    }, timeout);    
  }
};

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
		//ilink is like of image or the file
		if (ilink != "") {
		var res = ilink.split(".");
		//alert (res['1']);
			if ((res['1'] == "jpg") || (res['1'] == "jpeg") || (res['1'] == "png") || (res['1'] == "gif")){
				var imgTx = "<img src=\""+ilink+"\" style=\"max-width: 100%;\" onError=\"this.src=\"img/default.gif\"\" />";
			}
				else {
					var imgTx = ilink+"" ;
					}
			if (imgTx.length < 30) { bootstrap_alert(".alert_placeholder", imgTx, 5000,"alert-warning"); }
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
			async: false ,
			cache: false,
			success: function(result){
				if(result=='Posted succesfully!'){
				bootstrap_alert(".alert_placeholder", result, 5000,"alert-success");
				//alert("succesfully");
				location.reload();
				}
				else {
					bootstrap_alert(".alert_placeholder", result, 5000,"alert-warning");
					//alert("failed");
					location.reload();
				}
			}
		});

		//alert("failed");

		}		
function convertSpecialChar(str){
		return str.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
	}		
		function create_challange_pb_pr(){
			//alert("i am geting fucked");
			var challenge = convertSpecialChar($("#challangepr").val()) ;
			var challenge_title = convertSpecialChar($("#challange_title").val()) ;
			//var open_time = parseInt($("#open_time").val());
			//var open = parseInt($("#open").val());
			//var opentime = parseInt(open_time*60+open) ;
			//var eta = parseInt($("#cc_eta").val());
			//var etab = parseInt($("#cc_etab").val());
			//var etac = parseInt($("#cc_etac").val());
			//var etad = parseInt($("#cc_etad").val());
			//var challange_eta = parseInt(((eta*30+etab)*24+etac)*60+etad) ;
			var type = $("#type").val();
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'challange='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',challenge)))) + 
			'&challenge_title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',challenge_title)))) + '&type='+ type ;//+ '&opentime='+ (opentime+='') + '&challange_eta='+ (challange_eta+='') ;
			//alert(dataString);
			if(challenge==''){
				bootstrap_alert(".alert_placeholder", "Challenge can not be empty", 5000,"alert-warning");
				return false ;
			}
			else if(challenge_title==''){
				bootstrap_alert(".alert_placeholder", "Title can not be empty", 5000,"alert-warning");
				return false ;
			}
			else {
				//file upload
			var _file = document.getElementById('_fileChallengepr');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"projectchalPic",String(dataString),"ajax/submit_chalange_project.php");
			}
		}
	
		function create_notes(){
			var notes = convertSpecialChar($("#notestmt").val()) ;
			var notes_title = convertSpecialChar($("#notes_title").val()) ;
			// Returns successful data submission message when the entered information is stored in database.
			var dataString = 'notes='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',notes)))) + '&notes_title='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',notes_title)))) ;
			//alert(dataString);
			if(notes==''){
				bootstrap_alert(".alert_placeholder", "Notes can not be empty", 5000,"alert-warning");
				return false ;
			}
			else {
				//file upload
			var _file = document.getElementById('_fileNotes');
			//alert(uploadFile(_file,"articlePic"));
			uploadFile(_file,"projectnotesPic",String(dataString),"ajax/submit_notes.php");
			}
		}
		
		$("#answerch").click(function(){
			$("#answerch").attr('disabled','disabled');
			var answerchal = convertSpecialChar($("#answerchal").val()) ;
			var answercid = $("#answercid").val() ;
			var pid = $("#prcid").val() ;
			// Returns successful data submission message when the entered information is stored in database.
			if(answerchal==''){
				bootstrap_alert(".alert_placeholder", "Answer can not be empty", 5000,"alert-warning");
				$("#answerch").removeAttr('disabled');
				return false ;
			}
			else {
				var dataString = 'answer='+ replaceAll('  ',' <s>',replaceAll('\n','<br/> ',replaceAll("'",'<r>',replaceAll('&','<a>',answerchal))))
								+ '&cid='+ answercid + '&case=' + pid  ;
				//alert(dataString);
				var _file = document.getElementById('_fileanswer');
				//alert(uploadFile(_file,"articlePic"));
				uploadFile(_file,"answerPic",String(dataString),"ajax/submit_answer.php");
			}
		});
	$(document).ready(function(){
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
function show_form(type){
	var dataString = 'form_type=' + type ;
	$.ajax({
		type: "POST",
		url: "ajax/forms.php",
		data: dataString,
		async: false ,
		cache: false,
		success: function(result){
			$("#selecttext").hide();
			document.getElementById("invitation").innerHTML = result ;
		}
	});
}
function show_form_pro(type, title, ID) {
	var dataString = 'form_type=' + type ;
	$.ajax({
		type: "POST",
		url: "ajax/forms.php",
		data: dataString,
		async: false ,
		cache: false,
		success: function(result){
			$("#selecttext").hide();
			document.getElementById("invitation").innerHTML = result ;
			elf(title, ID) ;
		}
	});
}
function elf(title, ID){
	var temp = title + "_" + ID ;
    var elf = $('#elfinder').elfinder({
		url : 'php/connector.php?project_fd='+temp  // connector URL (REQUIRED)
       // lang: 'ru',             // language (OPTIONAL)
    }).elfinder('instance');
}
function show_form_h(type){
	var dataString = 'form_type=' + type ;
	$.ajax({
		type: "POST",
		url: "ajax/forms.php",
		data: dataString,
		async: false ,
		cache: false,
		success: function(result){
			$("#textForm").hide();
			document.getElementById("remindervalue").innerHTML = result ;
		}
	});
}
	$(document).ready(function(){
//allPanels
$("#eye_open").click(function(){
  	$(".sign").show(1000);
  	$(".deciduous").show(1000);
  	$(".pushpin").show(1000);
  	$(".videofilm").show(1000);
  	$(".flag").show(1000);
  });
$("#sign").click(function(){
  	$(".pushpin").hide(1000);
  	$(".deciduous").hide(1000);
  	$(".videofilm").hide(1000);
  	$(".flag").hide(1000);
    $(".sign").show(1000);
  });
  $("#deciduous").click(function(){
  	$(".sign").hide(1000);
  	$(".pushpin").hide(1000);
  	$(".videofilm").hide(1000);
  	$(".flag").hide(1000);
    $(".deciduous").show(1000);
  });
  $("#pushpin").click(function(){
  	$(".sign").hide(1000);
  	$(".deciduous").hide(1000);
  	$(".videofilm").hide(1000);
  	$(".flag").hide(1000);
    $(".pushpin").show(1000);
  });
  $("#flag").click(function(){
  	$(".sign").hide(1000);
  	$(".flag").show(1000);
  	$(".videofilm").hide(1000);
  	$(".pushpin").hide(1000);
  	$(".deciduous").hide(1000);
  });
  $("#filmprj").click(function(){
  	$(".sign").hide(1000);
  	$(".flag").hide(1000);
  	$(".videofilm").show(1000);
  	$(".pushpin").hide(1000);
  	$(".deciduous").hide(1000);
  });
});	
