<div class="bs-component">
    <div class="panel-group" id="collapChat" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" style="padding: 5px;"role="tab" id="collapChatHead">
                <a class="collapsed" data-toggle="collapse" data-parent="#collapChat" href="#collapChatBody" aria-expanded="false" aria-controls="collapseFive"> 
                    <p class="glyphicon glyphicon-comment">
                        collap chat</p>
                </a>
            </div>
            <div id='collapChatBody' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='collapChatHead'>   
                <div class="panel-body" style="padding: 1px;">
                    <?php
                        $idb = 0 ;

    $userProjects = mysqli_query($db_handle, "(SELECT a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
											where a.user_id = '$user_id' and a.team_name = b.team_name and b.user_id != '$user_id')
											as b where a.user_id = b.user_id )
											UNION
											(select a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join known_peoples as b
											where b.requesting_user_id = '$user_id' and a.user_id = b.knowning_id and b.status != '4')
											UNION
											(select a.first_name, a.last_name, a.username, a.user_id FROM user_info as a join known_peoples as b
											where b.knowning_id = '$user_id' and a.user_id = b.requesting_user_id and b.status = '2') ;");
    while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
            $friendFirstName = $userProjectsRow['first_name'];
            $friendLastName = $userProjectsRow['last_name'];
            $usernameFriends = $userProjectsRow['username'];
            $useridFriends = $userProjectsRow['user_id'];
            $tooltip = ucfirst($friendFirstName)." ".ucfirst($friendLastName);

            echo "<div class ='row' style=' margin:4px; background : rgb(240, 241, 242);'>
                            <a href=\"javascript:void(0)\" onclick=\"javascript:chatWith('".$usernameFriends."')\">
                            <div class ='col-md-2 ' style='padding:1px;'>
                                    <img src='uploads/profilePictures/$usernameFriends.jpg'  style='width:30px; height:30px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
                            </div>
                            <div class = 'col-md-9' style='font-size:10px;padding-top: 5px;'>"
                            .ucfirst($friendFirstName)." ".ucfirst($friendLastName)."
                            </div>
                    </a>
                    </div>";
    }
    ?>
    </div>
            </div>
        </div>
