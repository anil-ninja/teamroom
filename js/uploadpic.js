$(document).ready(function(){
			
var _submit = document.getElementById('upload_image'), 
_file = document.getElementById('_file'), 
_progress = document.getElementById('_progress');

var upload = function(){

    if(_file.files.length === 0){
        return;
    }

    var data = new FormData();
    data.append('file', _file.files[0]);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4){
            
            alert(request.response);
        }
    };

    request.upload.addEventListener('progress', function(e){
        _progress.style.width = Math.ceil(e.loaded/e.total) * 100 + '%';
    }, false);

    request.open('POST', 'ajax/upload_file.php?typeOfPic=profilepic');
    request.send(data);
}

upload_image.addEventListener('click', upload);

});
