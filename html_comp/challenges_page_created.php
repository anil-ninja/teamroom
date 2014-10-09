
<div class="panel panel-info" >
                            <div class="panel-heading" >
                                <h3 class="panel-title" >Your Challenges</h3>
                            </div>
                        </div>
                        
                            <?php 
                               
                                $challange_display = mysqli_query($db_handle, ("SELECT * FROM challenges WHERE user_id=$user_id and challenge_type = '1' ORDER BY challenge_creation DESC;"));
                                while($challange_displayRow = mysqli_fetch_array($challange_display)) {
                                    echo "<div class='panel-body'>
                                            <div class='list-group'>";
                                                $chall_id = $challange_displayRow['challenge_id'];
                                                $ch_title = $challange_displayRow['challenge_title'];
                                                $challenge_owner_status = $challange_displayRow['challenge_status'];
                                                echo "<div class='list-group-item'>";
                                               
                                                    $challange_owned = mysqli_query($db_handle, ("SELECT * FROM challenge_ownership WHERE challenge_id = ".$challange_displayRow['challenge_id'].";"));
                                                    while ($challange_ownedRow = mysqli_fetch_array($challange_owned)) {
                                                        $challenge_owner = $challange_ownedRow['user_id'];
                                                        $ch_eta = $challange_ownedRow['comp_ch_ETA'] ;
                                                        $ETA = $ch_eta*60 ;
														$day = floor($ETA/(24*60*60)) ;
														$daysec = $ETA%(24*60*60) ;
														$hour = floor($daysec/(60*60)) ;
														$hoursec = $daysec%(60*60) ;
														$minute = floor($hoursec/60) ;
														$remainingtime = $day." Days :".$hour." Hours :".$minute." Min" ;
                                                        $challange_own_user = mysqli_query($db_handle, ("Select * from user_info where user_id = '$challenge_owner';"));
                                                        $challange_own_userRow = mysqli_fetch_array($challange_own_user);
                                                        echo "<font color = '#F1AE1E'> Owned by &nbsp <span class='color strong' style= 'color :#CAF11E;'>" .ucfirst($challange_own_userRow['first_name']). '&nbsp'. ucfirst($challange_own_userRow['last_name']). " </span> &nbsp on &nbsp".$challange_ownedRow['ownership_creation']. " &nbsp with ETA in &nbsp".$remainingtime. " </font>" ;
                                                    }
                                                if ($challenge_owner_status == '1') {
                                                        echo "<font color = '#F1AE1E'> Ownership is not claimed till now </font> ";
                                                    }
                                        echo "<tr> <br><p align='center' style='font-size: 14pt;'  ><span style= 'color :#CAF11E;'><b>".ucfirst($ch_title)."</b></span></p><br/>";
                                        echo str_replace("<s>","&nbsp;",$challange_displayRow['stmt']). "<br> <br>";
                                        $commenter = mysqli_query ($db_handle, ("SELECT a.stmt,a.response_ch_id, a.challenge_id, a.user_id, b.first_name, b.last_name 
                                                                                FROM response_challenge as a 
                                                                                JOIN user_info as b 
                                                                                WHERE a.challenge_id = $chall_id AND a.user_id = b.user_id ORDER BY response_ch_creation ASC;"));
                                            while($commenterRow = mysqli_fetch_array($commenter)) {
                                                $comment_id = $commenterRow['response_ch_id'];
                                            echo "<div id='commentscontainer'>
                                                    <div class='comments clearfix'>
                                                        <div class='pull-left lh-fix'>
                                                            <img src='img/default.gif'>
                                                        </div>
                                                        <div class='comment-text'>
                                                            <span class='pull-left color strong'>";
                                                                echo "&nbsp".ucfirst($commenterRow['first_name'])."&nbsp". ucfirst($commenterRow['last_name']) .
                                                            "</span> ";
                                                                if ($commenterRow['user_id'] == $user_id) {
                                                    dropDown_delete_challenge($comment_id);
                                                    }
                                                                echo str_repeat('&nbsp;', 2) .$commenterRow['stmt'] ."
                                                        </div>
                                                    </div> 
                                                </div>";
                                        }
                                    echo "<div class='comments clearfix'>
                                            <div class='pull-left lh-fix'>
                                                <img src='img/default.gif'>
                                            </div>
                                            <form action='' method='POST'>
                                                <table>
                                                    <tr><td><input type='hidden' value='".$chall_id."' name='challen_id' /></td></tr>
                                                    <tr><td><input type='text' STYLE='border: 1px solid #bdc7d8; width: 350px;' name='ch_response' placeholder='Whats on your mind about this Challenge'/></td></tr>
                                                    <tr><td><input type='submit' style='display:none;' name='chl_response' value='Post'></td></tr>
                                                </table>
                                            </form>
                                        </div>";
                                    echo '</tr> </div> </div> </div>';
                                    }
                                ?>
                            
