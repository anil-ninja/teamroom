<?php 
    function dropDown_delete_comment_challenge($deleteid) {
        echo  "<div class='pull-right'>
                <div class='list-group-item'>
                    <a class='dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                    <ul class='dropdown-menu' aria-labelledby='themes'>
                        <li><a href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                        <li><a href='#' id='deleteComment' commentID='".$deleteid."' onclick='delcomment(".$deleteid.");' class='delete color'>Delete</a></li>
                    </ul>
                </div>
            </div>";
    }
    function dropDown_delete_comment_project($deleteid) {
    echo  "<div class='pull-right'>
            <div class='list-group-item'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
            <ul class='dropdown-menu' aria-labelledby='themes'>
                <li><a href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                <li><a href='#' id='comment_projectID' comment_projectID='".$deleteid."' onclick='del_project_comment(".$deleteid.");' class='delete color'>Delete</a></li>            </ul>
            </div>
        </div>";
}
?>