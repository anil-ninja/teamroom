function del_project_comment(href){
    
    if(confirm("Do u really want to delete this comment?")){
        var dataString = 'project_comment_ID='+ href;
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
}
function delcomment(href) {
              if(confirm("Do u really want to delete this comment?")){
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
            }
function delChallenge(href) {
    if(confirm("Do u really want to delete this challenge?")){
        
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
}
function delNote(href) {
    if(confirm("Do u really want to delete this Note?")){

    var dataString = 'noteID='+ href;
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
}