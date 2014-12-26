<?php if(isset($_SESSION['user_id'])) { 
    $user_id = $_SESSION['user_id'] ?> 	
		<div id="nav">
            <div id='step16' class="nav-btn"><p class="icon-chevron-left"></p><p class="icon-comment"></p>
            </div>
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
	if (mysqli_num_rows($userProjects) != 0 ) {
    while ($userProjectsRow = mysqli_fetch_array($userProjects)) {
            $friendFirstName = $userProjectsRow['first_name'];
            $friendLastName = $userProjectsRow['last_name'];
            $usernameFriends = $userProjectsRow['username'];
            $useridFriends = $userProjectsRow['user_id'];
            $online = mysqli_query($db_handle,"select * from user_info where user_id = '$useridFriends';") ;
            $onlineRow = mysqli_fetch_array($online) ;
            $status =  $onlineRow['last_login'] ;
            $time = time() - strtotime($status) ;
            $tooltip = ucfirst($friendFirstName)." ".ucfirst($friendLastName);

            echo "  <div class ='row' style=' margin:4px; background : rgb(240, 241, 242);'>
                        <a href=\"javascript:void(0)\" onclick=\"javascript:chatWith('".$usernameFriends."')\">
                            <div class ='col-md-2'>
                                    <img src='uploads/profilePictures/$usernameFriends.jpg'  style='margin-left:-10px;width:30px; height:35px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
                            </div>
                            <div class = 'col-md-7' style='font-size:10px;'>"
                            .ucfirst($friendFirstName)." ".ucfirst($friendLastName) ;
                 if($time < 6000) { echo "<br/>
                            online 
                            <span class='badge' style ='color: #4EC67F ;background-color: #4EC67F;padding: 0px 0px 0px 10px;'>.</span>" ; }           
                    else { 
                        echo "<br/>
                                offline 
                                <span class='badge' style ='color: #6F746F ;background-color: #6F746F;padding: 0px 0px 0px 10px;'>.</span>" ; }        
                 echo "     </div>
                        </a>
                    </div>";
		}
	}
	else {  
        include_once 'recommended.php'; 
    }
    ?>
    </div>
    </div>
    <?php } 
    include_once 'footer.php';
    ?>
   <script>
	$(".text").show();
	$(".editbox").hide();
	
	$(function() {
	$('#nav').stop().animate({'margin-right':'-170px'},1000);

function toggleDivs() {
    var $inner = $("#nav");
    if ($inner.css("margin-right") == "-170px") {
        $inner.animate({'margin-right': '0'});
		$(".nav-btn").html('<p class="icon-chevron-right"></p><p class="icon-comment"></p>')
    }
    else {
        $inner.animate({'margin-right': "-170px"}); 
		$(".nav-btn").html('<p class="icon-chevron-left"></p><p class="icon-comment"></p>')
    }
}
$(".nav-btn").bind("click", function(){
    toggleDivs();
});

});
	</script>            
