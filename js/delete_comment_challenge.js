function del_project_comment(href){
    if(confirm("Do u really want to delete this comment?")){
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
function delArticle(href) {
    if(confirm("Do u really want to delete this Article?")){
        
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
function delIdea(href) {
    if(confirm("Do u really want to delete this Idea?")){
        
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
function delProject(href) {
    if(confirm("Do u really want to delete this Project? Challenges no longer will be there!!!")){
        
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
