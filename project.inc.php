<?php 
include_once 'ninjas.inc.php';

if (!isset($_SESSION['first_name'])) {
    header('Location: index.php');
}

$title = $_SESSION['project_title'] ;
$user_id = $_SESSION['user_id'] ;
$name = $_SESSION['first_name'];
$rank = $_SESSION['rank'] ;
if (isset($_SESSION['project_id'])) 
    $pro_id = $_SESSION['project_id'] ;
else 
    header ('location: ninjas.php');
$email = $_SESSION['email'] ;


$project_id = mysqli_query($db_handle, "SELECT * FROM projects WHERE project_id = '$pro_id' ;");
$project_idrow = mysqli_fetch_array($project_id) ;
$eta = $project_idrow['project_ETA'] ;
$starttime = $project_idrow['project_creation'] ;
$starttimestr = (string) $starttime ;
$initialtime = strtotime($starttimestr) ;
$ETA = $eta*60 ;
$totaltime = $initialtime+$ETA ;
$completiontime = time() ;
if ($completiontime > $totaltime) { 
	$remaining_time = "Time over" ; }
else {	$remainingtime = ($totaltime-$completiontime) ;
		$day = floor($remainingtime/(24*60*60)) ;
		$daysec = $remainingtime%(24*60*60) ;
		$hour = floor($daysec/(60*60)) ;
		$hoursec = $daysec%(60*60) ;
		$minute = floor($hoursec/60) ;
		$sec = $hoursec%60 ;
		$remaining_time = $day." Days :".$hour." Hours :".$minute." Min :".$sec." "."Secs" ;
}		

if(isset($_POST['response'])) {
    $user_id = $_SESSION['user_id'];
    $challenge_id_comment = $_POST['challenge_id'] ; 
    $ch_response = $_POST['pr_resp'] ;
   if(strlen($ch_response)>1){
    mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) 
                                VALUES ('$user_id', '$challenge_id_comment', '$ch_response');") ;
    header('Location: #');
   }
   else{ echo "<script>alert('Is your mind empty!')</script>";
}
}
if (isset($_POST['resp_project'])) {
	$user_id = $_SESSION['user_id'] ;
	$pro_id = $_SESSION['project_id'] ;
	$pr_respon = $_POST['pr_resp'] ;
  if(strlen($pr_respon)>1) {
	mysqli_query($db_handle,"INSERT INTO response_project (user_id, project_id, stmt) VALUES ('$user_id', '$pro_id', '$pr_respon') ; ") ;
	header('Location: #');
	} else { echo "<script>alert('Enter something!')</script>"; }
}

if (isset($_POST['invite'])) {
    $fname = $_POST['fname'];
   if (strlen($fname)>0) { 
    $sname = $_POST['sname'];
    if (strlen($sname)>0) {  
    $email = $_POST['email'];
    if (strlen($email)>0) {  
    $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);;
    
    mysqli_query($db_handle,"INSERT INTO user_info
                                    (first_name, last_name, email, username, password) 
                                    VALUES 
                                    ('$fname', '$sname', '$email', '$password', '$password') ; ") ;
    
    if(mail($email,$name+" have share bill with you.","Hi,\n ".$name." have share bill with you.\n
            To know details login to http://54.64.1.52/Mybill/.\n
            Username: ".$email."\n
            Password: ".$password)){
            header('Location: project.php');
           echo "<script>alert('User was not registered, we have invited the user!')</script>";
    }
    else{
            header('Location: project.php');
            echo "<script>alert('An error occured, Sorry try again!')</script>";
            }
            }  else { echo "<script>alert('Enter First name!')</script>"; }
            }  else { echo "<script>alert('Enter something!')</script>"; }
     }  else { echo "<script>alert('Enter Email-ID!')</script>"; }
}	
		
if (isset($_POST['create_team'])) {
    $team_name = $_POST['team_name'];
   if (strlen($team_name)>0) {
    $emailid = $_POST['email'];
  if ($emailid == $email) {  
	  echo "<script>alert('Please, Enter friends Email !!!')</script>";
  } else {
    $pro_id = $_SESSION['project_id'] ;
    $respo = mysqli_query($db_handle, "SELECT * FROM user_info WHERE email = '$emailid';");
    $row = mysqli_num_rows($respo);
    if ($row == 1) {
        $responserow = mysqli_fetch_array($respo);
        $uid = $responserow['user_id'];
        mysqli_query($db_handle, "INSERT INTO teams (user_id, team_name, team_owner, project_id) VALUES ('$uid', '$team_name', '0', '$pro_id'),('$user_id','$team_name', '$user_id', '$pro_id');");
        header('Location: project.php');
    } else {
       echo "<div style='display: block;' class='modal fade in' id='eye' tabindex='-1' role='dialog' aria-labelledby='shareuserinfo' aria-hidden='false'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <a href = 'project.php' type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></a>
                            <h4 class='modal-title' id='myModalLabel'>
                                Hi, It looks like s/he is not here. Lets intivite her/him. 
                            </h4>
                        </div>
                        <div class='modal-body'>
                            <form role='form' method='POST' action = ''>
                                
                                    <div class='input-group'>
                                        <span class='input-group-addon'>His/Her First Name</span> 
                                        <input type='text' class='form-control' name='fname' placeholder='His First Name'> 
                                    </div><br/>
                                    <div class='input-group'>
                                        <span class='input-group-addon'>His/Her Second Name</span> 
                                        <input type='text' class='form-control' name='sname' placeholder='His Second Name'> 
                                    </div><br/>
                                    <div class='input-group'>
                                        <span class='input-group-addon'>His Email ID</span> 
                                        <input type='text' class='form-control' name='email' value='".$email."' /> 
                                    </div>
                                <br><br>
                                <input type='submit' class='btn btn-success' name='invite'  value='Invite Him/Her' />
                            </form>
                        </div>
                        <div class='modal-footer'>
                            <a type='button' href = 'project.php' class='btn btn-default' data-dismiss='modal'>Close</a>
                        </div>
                    </div>
                </div>
            </div>";
        } 
       } 
	}  else { echo "<script>alert('Enter Team Name!')</script>"; }
}	
if(isset($_POST['submitchl'])) {
	$id = $_POST['id'] ;
	echo "<div style='display: block;' class='modal fade in' id='asd' tabindex='-1' role='dialog' aria-labelledby='shareuserinfo' aria-hidden='false'>
			<div class='modal-dialog'> 
				<div class='modal-content'>
				 <div class='modal-header'> 
				   <a href = 'project.php' type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></a>
				   <h4 class='modal-title' id='myModalLabel'>Submit Answer</h4> 
				 </div> 
				 <div class='modal-body'> 
				  <form method='POST' ><br/>
				  <div class='input-group-addon'>
				  <textarea row='5' name='answer' class='form-control' placeholder='submit your answer'></textarea>
				  </div><br/>
				    <input type='hidden' name='cid' value='".$id."'>
				    <input type='submit' class='btn btn-success btn-sm' name='answerch' value = 'Submit' ></small>
				  </form>
				</div> 
				<div class='modal-footer'>
				   <a type='button' href = 'project.php' class='btn btn-default' data-dismiss='modal'>Close</a>
				</div>
			</div> 
		</div>
	</div>" ;
}
if (isset($_POST['answerch'])) {
		$user_id = $_SESSION['user_id'];
		$chalange = $_POST['cid'] ;
		$answer = $_POST['answer'] ;
		$a = date("y-m-d H:i:s") ;
	if (strlen($answer) > 1) { 
		mysqli_query($db_handle,"UPDATE challenges SET challenge_type='4' WHERE challenge_id = $chalange ; ") ;
		mysqli_query($db_handle,"UPDATE challenge_ownership SET status='2', time='$a' WHERE challenge_id = $chalange ; ") ;
	 if (strlen($answer) < 1000) {
        mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, status) VALUES ('$user_id', '$chalange', '$answer', '2'); ") ;
	}
	else {
        mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$challange');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO response_challenge (user_id, challenge_id, blob_id, stmt, status) VALUES ('$user_id', '$chalange', '$id', '$answer', '2');");
}
header('Location:project.php') ;
}	
	else { echo "<script>alert('Enter Your Answer!')</script>"; }
 
}
$contact = mysqli_query($db_handle, "SELECT * FROM user_info WHERE user_id = '$user_id';");
$contactrow = mysqli_fetch_array($contact) ;
$con_no = $contactrow['contact_no'] ;
$email = $contactrow['email'] ;
?>
