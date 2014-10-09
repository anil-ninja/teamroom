function del_project_comment(href){
    
    if(confirm("Do u really want to delete this comment?")){
        var dataString = 'comment_projectID='+ href;
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
                var dataString = 'commentID='+ href;
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