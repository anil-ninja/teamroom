<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['form_type']){
	$user_id = $_SESSION['user_id'];
	$pro_id = $_POST['project_id'];
	$type = $_POST['form_type'] ;
	$member_project = mysqli_query($db_handle, "select * from teams where project_id = '$pro_id' and user_id = '$user_id' and member_status = '1';");
	switch($type){
		case 1:
			if(mysqli_num_rows($member_project) != 0) {
			 echo "<input type='text' class='input-block-level' id='challange_title' placeholder='Challange Tilte ..'/><br>
					<input type='file' id='_fileChallengepr' style ='width: auto;'><br/>
					<textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='challangepr' placeholder='Description .. '></textarea><br>
					<label>Challenge Type : </label> 
						<select class='btn btn-default' id='type' >
						  <option value='1' >Public</option>
						  <option value='2' selected >Private</option>
						</select><br/><br/>
					<input type='button' value='Create Challenge' class='btn btn-primary' id='create_challange_pb_pr' onclick='create_challange_pb_pr()' />" ;
			/* <div class="inline-form">
                    Challenge Open For : <select class="btn btn-default btn-xs" id= "open_time" >	
                        <option value='0' selected >hour</option>
				  <?php
                  $o = 1;
                  while ($o <= 24) {
                  echo "<option value='" . $o . "' >" . $o . "</option>";
                  $o++;
                  }
                  ?>
                  </select>
                  <select class="btn btn-default btn-xs" id = "open" >
                  <option value='10' selected >minute</option>
                  <option value='20'  >20</option>
                  <option value='30' >30</option>
                  <option value='40'  >40</option>
                  <option value='50' >50</option>
                  </select><br/><br/>ETA :
                  <select class="btn btn-default btn-xs" id = "cc_eta" >
                  <option value='0' selected >Month</option>
                  <?php
                  $m = 1;
                  while ($m <= 11) {
                  echo "<option value='" . $m . "' >" . $m . "</option>";
                  $m++;
                  }
                  ?>
                  </select>
                  <select class="btn btn-default btn-xs" id= "cc_etab" >
                  <option value='0' selected >Days</option>
                  <?php
                  $d = 1;
                  while ($d <= 30) {
                  echo "<option value='" . $d . "' >" . $d . "</option>";
                  $d++;
                  }
                  ?>
                  </select>
                  <select class="btn btn-default btn-xs" id= "cc_etac" >
                  <option value='0' selected >hours</option>
                  <?php
                  $h = 1;
                  while ($h <= 23) {
                  echo "<option value='" . $h . "' >" . $h . "</option>";
                  $h++;
                  }
                  ?>
                    </select>
                    <select class="btn btn-default btn-xs" id= "cc_etad" >	
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select>
                </div><br/><br/>
				*/
			} 
			else { 
				if(isset($_SESSION['user_id'])){
				    echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='joinproject(".$pro_id.")'>Join</a>"; 
				}
				else {
					echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='test3()'>Join</a>"; 
				}
			}
			exit ;
			break ;
			
		case 2:
			$owner_project = mysqli_query($db_handle, "select user_id from projects where project_id = '$pro_id';");
            $owner_projectrow = mysqli_fetch_array($owner_project);
            $ownerof_project = $owner_projectrow['user_id'];
            if ($ownerof_project == $user_id) {
                $teams = mysqli_query($db_handle, "select DISTINCT team_name from teams where project_id = '$pro_id' and status = '1';");
                if (mysqli_num_rows($teams) > 0) {
                    $task = "";
                    $task .= "<div class='inline-form'>Assign To : &nbsp;&nbsp;
								<select id = 'teamtask' >
								   <option value='0' selected > Select Team </option>";
                    while ($teamsrow = mysqli_fetch_array($teams)) {
                        $teamsname = $teamsrow['team_name'];
                        $task = $task . "<option value='" . $teamsname . "' >" . $teamsname . "</option>";
                    }
                    $task = $task . "</select>
                                <label></label> Or Select : &nbsp;&nbsp;&nbsp;
              					<select id= 'userstask' >	
									<option value='0' selected >Select Member </option>";
					$users = mysqli_query($db_handle, "select DISTINCT a.user_id, b.username from teams as a join user_info as b where a.project_id = '$pro_id' and 
														a.team_name IN (select DISTINCT team_name from teams where a.project_id = '$pro_id' and a.status = '1') 
														and a.member_status = '1' and a.user_id = b.user_id;");
					while ($userssrow = mysqli_fetch_array($users)) {
						$users_username_task = $userssrow['username'];
						$u_id = $userssrow['user_id'];
						$task = $task . "<option value='" . $u_id . "' >" . $users_username_task . "</option>";
					}
					$task = $task . "</select>
                                <label></label> Or Enter : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type='email' id='emailtask' placeholder='Enter email-id'/>
							  </div><br/>
							  <input type='text' class='input-block-level' id='titletask' placeholder='Tilte ..'/><br/>
						      <input type='file' id='_fileTask' style ='width: auto;'><label></label>
							  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='taskdetails' placeholder='Description .. '></textarea>
							  <br/><input type='button' value='Assign' class='btn btn-primary' id='create_task' onclick='create_task()'/><br/>" ;
					 /* <div class='inline-form'>
                          ETA :
                          <select class='btn btn-default btn-xs' id = 'c_eta' >
                          <option value='0' selected >Month</option>" ;
                          $m = 1;
                          while ($m <= 11) {
                          $task = $task . "<option value='" . $m . "' >" . $m . "</option>";
                          $m++;
                          }
                          $task = $task ." </select>
                          <select class='btn btn-default btn-xs' id= 'c_etab' >
                          <option value='0' selected >Days</option> " ;
                          $d = 1;
                          while ($d <= 30) {
                          $task = $task ."<option value='" . $d . "' >" . $d . "</option>";
                          $d++;
                          }
                          $task = $task ."</select>
                          <select class='btn btn-default btn-xs' id= 'c_etac' >
                          <option value='0' selected >hours</option>" ;
                          $h = 1;
                          while ($h <= 23) {
                          $task = $task ."<option value='" . $h . "' >" . $h . "</option>";
                          $h++;
                          }
                          $task = $task ."</select>
                          <select class='btn btn-default btn-xs' id= 'c_etad' >
                          <option value='15' selected >minute</option>
                          <option value='30' >30</option>
                          <option value='45'  >45</option>
                          </select>
                          </div><br/> */
                    echo $task ;
                } 
                else { echo "You hane no teams, Please create Team First" ; }
			} 
			else  echo "Not authorised, please contact project owner"; 
			exit ;
			break ;
		
		case 4:
			if(mysqli_num_rows($member_project) != 0) {
				echo "<input type='text' class='input-block-level' id='video_titlepr' placeholder='Vedio title ..'/><br>
					  <input type='text' class='input-block-level' id='videoprjt' placeholder='Add Youtube URL'><br>
					  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='videodespr' placeholder='Description ..'></textarea><br>
					  <input type='button' value='Post' class='btn btn-primary' id='create_videopr' onclick='create_videopr(\"".$pro_id."\")'/>" ;
			} 
			else { 
				if(isset($_SESSION['user_id'])){
				    echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='joinproject(".$pro_id.")'>Join</a>"; 
				}
				else {
					echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='test3()'>Join</a>"; 
				}
			}
			exit ;
			break ;
			
		case 5:
			if(mysqli_num_rows($member_project) != 0) {
				echo "<input type='text' class='input-block-level' id='notes_title' placeholder='Heading ..'/><br>
					  <input type='file' id='_fileNotes' ><br/><label></label>
					  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='notestmt' placeholder='Notes about Project or Importent Things about Project'></textarea><br>
					  <input type='button' value='Post' class='btn btn-primary' id='create_notes' onclick='create_notes()'/>" ;
			} 
			else { 
				if(isset($_SESSION['user_id'])){
				    echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='joinproject(".$pro_id.")'>Join</a>"; 
				}
				else {
					echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='test3()'>Join</a>"; 
				}
			}
			exit ;
			break ;
		
		case 6:
			//if(mysqli_num_rows($member_project) != 0) {
				echo "<div id='elfinder'></div>" ;
			//}
			//else  echo "Please Join Project First" ; 
			exit ;
			break ;
			
		case 7:
			echo "<input type='text' class='input-block-level' id='challange_title' placeholder='Challenge Tilte ..'/><br/>
                  <input id='_fileChallenge' type='file' title='Upload Photo' label='Add photos to your post'/><label></label>
                  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' placeholder='Description .. ' id='challange'></textarea><br>
                  <input type='hidden' id='Chall_type' value='on' /><br/>                    
                  <input onclick='submit_ch()' class='btn btn-primary' type='button' id='submit_ch' value='Create Challange'/>" ;
            /*	 <div class="inline-form">
                    Challenge Open For 
                    <select class="btn-info btn-xs"  id= "open_time" >	
                        <option value='0' selected >hour</option>
                        <?php  
                        $o = 1;
                        while ($o <= 24) {
                            echo "<option value='" . $o . "' >" . $o . "</option>";
                            $o++;
                        }
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "open" >	
                        <option value='10' selected >minute</option>
                        <option value='20'  >20</option>
                        <option value='30' >30</option>
                        <option value='40'  >40</option>
                        <option value='50' >50</option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ETA
                    <select class="btn-info btn-xs" id= "c_eta" >	
                        <option value='0' selected >Month</option>
                        <?php
                        $m = 1;
                        while ($m <= 11) {
                            echo "<option value='" . $m . "' >" . $m . "</option>";
                            $m++;
                        }
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "c_etab" >	
                        <option value='0' selected >Days</option>
                        <?php
                        $d = 1;
                        while ($d <= 30) {
                            echo "<option value='" . $d . "' >" . $d . "</option>";
                            $d++;
                        }
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "c_etac" >	
                        <option value='0' selected >hours</option>
                        <?php
                        $h = 1;
                        while ($h <= 23) {
                            echo "<option value='" . $h . "' >" . $h . "</option>";
                            $h++;
                        } 
                        ?>
                    </select>&nbsp;
                    <select class="btn-info btn-xs" id= "c_etad" >	
                        <option value='15' selected >minute</option>
                        <option value='30' >30</option>
                        <option value='45'  >45</option>
                    </select><br/><br/></div><br/> 
                    */ 
			exit ;
			break ;
			
		case 8:
			echo "<input type='text' class='input-block-level' id='article_title' placeholder='Heading ..'/><br>
				  <input type='file' id='_fileArticle'><label></label>
				  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='articlech' placeholder='Article text..'></textarea><br>
				  <input type='submit' value='Post' class='btn btn-primary' id='create_article' onclick='create_article()'/>" ;
			exit ;
			break ;
			
		case 9:
			echo "<input type='text' class='input-block-level' id='picture_title' placeholder='Picture caption ..'/><br>
				  <input type='file' id='_filePhotos'><label></label>
				  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='picturech' placeholder='Description ..'></textarea><br>
				  <input type='button' value='Post' class='btn btn-primary' id='create_picture' onclick='create_picture()'/>" ;
			exit ;
			break ;
			
		case 10:
			echo "<input type='text' class='input-block-level' id='video_title' placeholder='Vedio title ..'/><br>
				  <input type='text' class='input-block-level' id='videosub' placeholder='Add Youtube URL' /><br>
				  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='videodes' placeholder='Description..'></textarea><br>
				  <input type='button' value='Post' class='btn btn-primary' id='create_video' onclick='create_video()'/>" ;
			exit ;
			break ;
			
		case 11:
			echo "<input type='text' class='input-block-level' id='idea_titleA' placeholder='Idea heading ..'/><br>
				  <input type='file' id='_fileIdea'><label></label>
				  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='ideaA' placeholder='Description ..'></textarea><br>
				  <input type='submit' value='Post' class='btn btn-primary' id='create_idea' onclick='create_idea()'/>" ;
			exit ;
			break ;
			
		case 12:
			echo "<br/><input type='text' class='input-block-level' id='sharedlink' placeholder='Share link here ..'/><br>
				  <input type='submit' value='Post' class='btn btn-primary' onclick='create_link()'/>" ;
			exit ;
			break ;
			
		case 13:
			if(mysqli_num_rows($member_project) != 0) {
				echo "<input type='text' class='input-block-level' id='issue_title' placeholder='Heading ..'/><br>
					  <input type='file' id='_fileIssue' ><br/><label></label>
					  <textarea class='input-block-level autoExpand' rows='3' data-min-rows='3' id='issuestmt' placeholder='Issue related to Project'></textarea><br>
					  <input type='button' value='Post' class='btn btn-primary' id='create_issue' onclick='create_issue()'/>" ;
			} 
			else { 
				if(isset($_SESSION['user_id'])){
				    echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='joinproject(".$pro_id.")'>Join</a>"; 
				}
				else {
					echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='test3()'>Join</a>"; 
				}
			}
			exit ;
			break ;
			
		case 14:
			if(mysqli_num_rows($member_project) != 0) {
				echo "<br/><input type='text' class='input-block-level' id='sharedlink' placeholder='Share link here ..'/><br>
				  <input type='submit' value='Post' class='btn btn-primary' onclick='create_link()'/>" ;
			} 
			else { 
				if(isset($_SESSION['user_id'])){
				    echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='joinproject(".$pro_id.")'>Join</a>"; 
				}
				else {
					echo "Please Join Project First"."<a class='btn btn-primary pull-right' onclick='test3()'>Join</a>"; 
				}
			}
			exit ;
			break ;
	}
	mysqli_close($db_handle) ;
}
?>
