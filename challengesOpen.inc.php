<?php
session_start();
include_once 'functions/delete_comment.php';
include_once 'lib/db_connect.php';
include_once 'models/challenge.php';
$obj = new challenge($_GET['challenge_id']);
$challengeSearchID = $_GET['challenge_id'];
$challengeSearchIDR = $_GET['challenge_id'];
if (isset($_POST['logout'])) {
    header('Location: challengesOpen.php?challenge_id=' . "$challengeSearchID");
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    session_destroy();
    exit;
}
$private_check = mysqli_query($db_handle, "SELECT challenge_type FROM challenges WHERE challenge_id = $challengeSearchID");
$private_checkRow = mysqli_fetch_array($private_check);
$private_ch_type = $private_checkRow['challenge_type'];
if (!isset($_SESSION['user_id']) AND $private_ch_type == 2) {
    include_once 'error.php';
    exit;
} 
elseif (isset($_SESSION['user_id']) AND $private_ch_type == 2) {
    $userID = $_SESSION['user_id'];
    $private_ch_fn = private_challenge_access($db_handle, $userID, $challengeSearchID);
    if ($private_ch_fn == 0) {
        include_once 'error.php';
        exit;
    }
}
$open_chalange = mysqli_query($db_handle, "SELECT DISTINCT challenge_id from challenges 
            WHERE challenge_status != 3 AND challenge_status != 7 AND challenge_id='$challengeSearchID';");
$emptySearch = mysqli_num_rows($open_chalange);
if ($emptySearch == 0) {
    include_once 'error.php';
    exit;                       //echo "no longer exists";
}
function private_challenge_access($db_handle, $user_id, $challenge_id) {
    $public_Private = mysqli_query($db_handle, "SELECT user_id FROM challenges WHERE challenge_id = $challenge_id AND user_id = $user_id AND challenge_type = 2;");
    $public_PrivateRow = mysqli_num_rows($public_Private);
    return $public_PrivateRow;
}
$challengeSearch_user = mysqli_query($db_handle, "SELECT a.user_id, b.username from challenges as a JOIN user_info as b WHERE a.challenge_id = $challengeSearchID AND a.user_id=b.user_id;");
$challengeSearch_user_IDRow = mysqli_fetch_array($challengeSearch_user);
$challengeSearch_user_ID = $challengeSearch_user_IDRow['user_id'];
$ch_username = $challengeSearch_user_IDRow['username'];

if (isset($_POST['own_chl_response'])) {
    $user_id = $_SESSION['user_id'];
    $own_challenge_id_comment = $_POST['own_challen_id'];
    $own_ch_response = $_POST['own_ch_response'];
    if (strlen($own_ch_response) > 1) {
        if (strlen($own_ch_response) < 1000) {
            mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, stmt) 
                                    VALUES ('$user_id', '$own_challenge_id_comment', '$own_ch_response');");
            header('Location: #');
        } else {
            mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                    VALUES (default, '$own_ch_response');");
            $id = mysqli_insert_id($db_handle);
            mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, stmt, blob_id) 
                                    VALUES ('$user_id', '$own_challenge_id_comment', ' ', '$id');");
            header('Location: #');
        }
    }
}
if (isset($_POST['accept'])) {
    $id = $_POST['id'];
    echo "<div style='display: block;' class='modal fade in' id='eye' tabindex='-1' role='dialog' aria-labelledby='shareuserinfo' aria-hidden='false'>
            <div class='modal-dialog'> 
                <div class='modal-content'>
                    <div class='modal-header'> 
                        <a href ='challengesOpen.php?challenge_id=" . $challengeSearchID . "' type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></a>
                        <h4 class='modal-title' id='myModalLabel'>Accept Challenge</h4> 
                    </div> 
                    <div class='modal-body'> 
                        <form method='POST' class='inline-form' onsubmit=\"return confirm('Really, Accept challenge !!!')\"><br/>
                            Your ETA : 
                            <select class='btn btn-default btn-xs' name = 'y_eta' ><option value='0' selected >Month</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option></select>
                            <select class='btn btn-default btn-xs' name = 'y_etab' ><option value='0' selected >Days</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option></select>
                            <select class='btn btn-default btn-xs' name = 'y_etac' ><option value='0' selected >hours</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option></select>&nbsp;
                            <select class='btn btn-default btn-xs' name = 'y_etad' ><option value='15' selected >minute</option><option value='30' >30</option><option value='45' >45</option></select>
                            <input type='hidden' name='cid' value='" . $id . "'><br/><br/>
                            <input type='submit' class='btn btn-success btn-sm' name='chlange' value = 'Accept' ></small>
                        </form>
                    </div> 
                    <div class='modal-footer'>
                        <a href ='challengesOpen.php?challenge_id=" . $challengeSearchID . "' type='button' class='btn btn-default' data-dismiss='modal'>Close</a>
                    </div>
                </div> 
            </div>
	</div>";
}
if (isset($_POST['chlange'])) {
    $user_id = $_SESSION['user_id'];
    $chalange = $_POST['cid'];
    $youreta = $_POST['y_eta'];
    $youretab = $_POST['y_etab'];
    $youretac = $_POST['y_etac'];
    $youretad = $_POST['y_etad'];
    $your_eta = (($youreta * 30 + $youretab) * 24 + $youretac) * 60 + $youretad;
    mysqli_query($db_handle, "UPDATE challenges SET challenge_status='2' WHERE challenge_id = $chalange ; ");
    mysqli_query($db_handle, "INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)	
    								VALUES ('$user_id', '$chalange', '$your_eta');");
    header('Location: #');
}
if (isset($_POST['projectphp'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['first_name'];
    $username = $_SESSION['username'];
    $rank = $_SESSION['rank'];
    $email = $_SESSION['email'];
    header('location: project.php');
    $_SESSION['user_id'] = $user_id;
    $_SESSION['first_name'] = $name;
    $_SESSION['project_id'] = $_POST['project_id'];
    $_SESSION['rank'] = $rank;
    exit;
}
function challenge_display($db_handle, $challengeSearchID) {
        $open_chalange = mysqli_query($db_handle, "(SELECT DISTINCT a.project_id, a.challenge_id, a.blob_id, a.challenge_title, a.challenge_open_time, a.challenge_creation, a.challenge_ETA, a.challenge_type, a.challenge_status, a.stmt, b.first_name, b.last_name, b.username from challenges as a join user_info as b 
                            WHERE a.challenge_status != 3 AND a.challenge_status != 7 AND blob_id = '0' and a.user_id = b.user_id AND a.challenge_id='$challengeSearchID')
                        UNION
                            (SELECT DISTINCT a.project_id, a.challenge_id, a.blob_id, a.challenge_title, a.challenge_open_time, a.challenge_creation, a.challenge_ETA, a.challenge_type, a.challenge_status, c.stmt, b.first_name, b.last_name, b.username from challenges as a join user_info as b join blobs as c 
                            WHERE a.challenge_status != 3 AND a.challenge_status != 7 AND a.blob_id = c.blob_id and a.user_id = b.user_id AND a.challenge_id='$challengeSearchID');");
        while ($open_chalangerow = mysqli_fetch_array($open_chalange)) {
            $chellange_open_stmt = str_replace("<s>", "&nbsp;", $open_chalangerow['stmt']);
            $ETA = $open_chalangerow['challenge_ETA'];
            $ch_title = $open_chalangerow['challenge_title'];
            $frstname = $open_chalangerow['first_name'];
            $lstname = $open_chalangerow['last_name'];
            $username_ch_ninjas = $open_chalangerow['username'];
            $chelangeid = $open_chalangerow['challenge_id'];
            $times = $open_chalangerow['challenge_creation'];
            $timeopen = $open_chalangerow['challenge_open_time'];
            $challenge_status = $open_chalangerow['challenge_status'];
            $challenge_type = $open_chalangerow['challenge_type'];
            $eta = $ETA * 60;
            $day = floor($eta / (24 * 60 * 60));
            $daysec = $eta % (24 * 60 * 60);
            $hour = floor($daysec / (60 * 60));
            $hoursec = $daysec % (60 * 60);
            $minute = floor($hoursec / 60);
            $remaining_time = $day . " Days :" . $hour . " Hours :" . $minute . " Min";
            $starttimestr = (string) $times;
            $open = $timeopen * 60;
            $initialtime = strtotime($starttimestr);
            $totaltime = $initialtime + $eta + $open;
            $completiontime = time();
            $owned_or_not = mysqli_query($db_handle, "SELECT a.comp_ch_ETA, a.ownership_creation, b.first_name, b.last_name, b.username 
                                            FROM challenge_ownership as a JOIN user_info as b 
                                            WHERE a.challenge_id = '$challengeSearchID' and a.user_id = b.user_id;");
            while ($owned_or_notRow = mysqli_fetch_array($owned_or_not)) {
                $owned_f_name = $owned_or_notRow['first_name'];
                $owned_l_name = $owned_or_notRow['last_name'];
                $owned_username = $owned_or_notRow['username'];
                $own_created = $owned_or_notRow['ownership_creation'];
            }
            if ($completiontime > $totaltime) {
                $remaining_time_own = "Closed";
            } else {
                $remainingtime = ($totaltime - $completiontime);
                $day = floor($remainingtime / (24 * 60 * 60));
                $daysec = $remainingtime % (24 * 60 * 60);
                $hour = floor($daysec / (60 * 60));
                $hoursec = $daysec % (60 * 60);
                $minute = floor($hoursec / 60);
                $remaining_time_own = "Remaining Time : " . $day . " Days :" . $hour . " Hours :" . $minute . " Min ";
            }
            $timefunction = date("j F, g:i a", strtotime($times));
            echo "<div class='list-group'>
                    <div class='list-group-item'>";
                        $challenge_createdBY = "
                        <div class='pull-left lh-fix'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>
                        <div style='line-height: 16.50px;'>
                        <span class='color strong' style= 'color :lightblue;'>
                                <a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " 
                                </a>
                        </span><br>" . $timefunction . "<br>".$remaining_time_own."
                    </div>";
            switch ($challenge_status) {
                case 1:
                    if (isset($_SESSION['user_id'])) {
                        dropDown_challenge($db_handle, $chelangeid, $user_ID, $remaining_time_own);
                        echo "<form method='POST' class='inline-form pull-right'>
                            <input type='hidden' name='id' value='" . $chelangeid . "'/>
                            <input class='btn btn-primary btn-sm' type='submit' id = 'accept_challenge' name='accept' value='Accept'>
                        </form>";
                        echo $challenge_createdBY;
                    } else {
                        echo"<a data-toggle='modal' data-target='#SignIn'>
                            <button class='btn btn-primary btn-sm pull-right' >Accept</button>
                        </a>";
                    }
                    break;
                case 2:
                    if (isset($_SESSION['user_id'])) {
                    echo "<div class='pull-left lh-fix' style='line-height: 16.50px;'>     
                            <span class='glyphicon glyphicon-question-sign'></span>
                            <img src='uploads/profilePictures/$username_ch_ninjas.jpg'  onError=this.src='img/default.gif' style='width: 50px; height: 50px'>&nbsp &nbsp
                        </div>

                        <span class='color strong' style= 'color :lightblue;'>
                                <a href ='profile.php?username=" . $username_ch_ninjas . "'>"
                                .ucfirst($frstname) . '&nbsp' . ucfirst($lstname) . " 
                                </a>
                            </span>on &nbsp" . $timefunction."<br>";
                        echo "Owned by &nbsp
                        <span class='color strong' style= 'color :lightblue;'>
                            <a href ='profile.php?username=" . $owned_username . "'>"
                        . "$owned_f_name" . "&nbsp" . $owned_l_name . "
                            </a>
                        </span>&nbsp on &nbsp" . $own_created."<br>". $remaining_time_own;
                    } else {
                        echo $challenge_createdBY;
                        echo"<a data-toggle='modal' data-target='#SignIn'>
                            <button class='btn btn-primary btn-sm pull-right' >Accept</button>
                        </a>";
                    }
            }

            echo "<br><br></div>";
            echo "<div class='list-group-item'><p align='center' style='font-size: 14pt; color :#3B5998;'><b>" . ucfirst($ch_title) . "</b></p><br/>" .
            $chellange_open_stmt . "<br/><br/>";
            $commenter = mysqli_query($db_handle, " (SELECT DISTINCT a.stmt, a.challenge_id, a.response_ch_id, a.user_id,a.response_ch_creation, b.first_name, b.last_name, b.username FROM response_challenge as a
                                    JOIN user_info as b WHERE a.challenge_id = $challengeSearchID AND a.user_id = b.user_id and a.blob_id = '0' and a.status = '1')
                                UNION
                                    (SELECT DISTINCT a.challenge_id, a.response_ch_id,a.response_ch_creation, a.user_id, b.first_name, b.last_name, b.username, c.stmt FROM response_challenge as a
                                    JOIN user_info as b JOIN blobs as c WHERE a.challenge_id = '$challengeSearchID' AND a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '1') ORDER BY response_ch_creation ASC;");

            while ($commenterRow = mysqli_fetch_array($commenter)) {
                $comment_id = $commenterRow['response_ch_id'];
                $challenge_ID = $commenterRow['challenge_id'];
                $username_comment_ninjas = $commenterRow['username'];
                echo "<div id='commentscontainer'>
                    <div class='comments clearfix'>
                        <div class='pull-left lh-fix'>
                            <img src='uploads/profilePictures/$username_comment_ninjas.jpg'  onError=this.src='img/default.gif'>
                        </div>
                    <div class='comment-text'>
                    <span class='pull-left color strong'>&nbsp<a href ='profile.php?username=" . $username_comment_ninjas . "'>" . ucfirst($commenterRow['first_name']) . " " . ucfirst($commenterRow['last_name']) . "</a></span>
                        &nbsp&nbsp&nbsp" . $commenterRow['stmt'] . "";
                if (isset($_SESSION['user_id'])) {
                    $userID = $_SESSION['user_id'];
                    dropDown_delete_comment_challenge($db_handle, $comment_id, $userID);
                }
                echo "</div>
                </div>
            </div>";
            }
            echo "<div class='comments clearfix'>
                <div class='pull-left lh-fix'>
                    <img src='uploads/profilePictures/$username.jpg'  onError=this.src='img/default.gif'>&nbsp
                </div>
                <div class='comment-text'>";
            if (isset($_SESSION['user_id'])) {
                $userID = $_SESSION['user_id'];
                echo "<form action='' method='POST' class='inline-form'>
                            <input type='hidden' value='" . $chelangeid . "' name='own_challen_id' />
                            <input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' name='own_ch_response' placeholder='Whats on your mind about this Challenge'/>
                            <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='own_chl_response' ></button>
                        </form>";
            } else {
                echo "<form action='' method='POST' class='inline-form'>
                        <input type='text' STYLE='border: 1px solid #bdc7d8; width: 86%; height: 30px;' placeholder='Whats on your mind about this Challenge'/>
                            <a data-toggle='modal' data-target='#SignIn'>
                                <button type='submit' class='btn-primary btn-sm glyphicon glyphicon-play' name='login_comment'></button>
                            </a>
                        </form>";
            }
            echo "</div>
            </div>";
            echo " </div></div>";
        }
    }

//echo "title Id ".$challengeSearchIDR;

?>
