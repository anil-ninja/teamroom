<?php 
function dropDown_delete($deleteid) {
                                echo  "<div class='pull-right'>
                                        <a class='dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                                        <ul class='dropdown-menu' aria-labelledby='themes'>
                                            <li><a href='http://bootswatch.com/default/'>Edit Challenge</a></li>
                                            <li><a href='#' id='deleteComment' commentID='".$deleteid."' onclick='delcomment(".$deleteid.");' class='delete color'>Delete</a></li>
                                            <li><a href='http://bootswatch.com/cosmo/'>Report Spam</a></li>
                                        </ul>
                                    </div>";
}
?>