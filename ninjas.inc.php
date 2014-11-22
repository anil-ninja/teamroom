<?php
include_once 'lib/db_connect.php';
include_once 'functions/delete_comment.php';
session_start();
if(!isset($_SESSION['user_id'])) {
	header('Location:index.php') ;
	} 
    $user_id = $_SESSION['user_id'];
$name = $_SESSION['first_name'];
$username = $_SESSION['username'];
$rank = $_SESSION['rank'];
$email = $_SESSION['email'];

if(isset($_POST['submitchlnin'])) {
	$id = $_POST['id'] ;
	echo "<div style='display: block;' class='modal fade in' id='answerForm' tabindex='-1' role='dialog' aria-labelledby='shareuserinfo' aria-hidden='false'>
			<div class='modal-dialog'> 
				<div class='modal-content'>
					<div class='modal-header'> 
						<a href = 'ninjas.php' type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></a>
						<h4 class='modal-title' id='myModalLabel'>Submit Answer</h4> 
					</div> 
					<div class='modal-body'><form>  
						<div class='input-group-addon'>
							<textarea row='5' id='answerchal' class='form-control' placeholder='submit your answer'></textarea>
						</div>
						<br/>
						<input class='btn btn-default btn-sm' type='file' id='_fileanswer' style ='width: auto;'>
						<br/>
						<input type='hidden' id='answercid' value='".$id."'>
						<button type='submit' class='btn btn-success btn-sm' id='answerch' >Submit</button> 
					</form></div> 
					<div class='modal-footer'>
						<a type='button' href = 'ninjas.php' class='btn btn-default' data-dismiss='modal'>Close</a>
					</div>
				</div> 
			</div>
		  </div>" ;
}

if (isset($_POST['closechallenge'])) {
		$chalange = $_POST['cid'] ;
		$user_id = $_SESSION['user_id'];
	events($db_handle,$user_id,"6",$chalange);
    involve_in($db_handle,$user_id,"6",$chalange);
    mysqli_query($db_handle,"UPDATE challenges SET challenge_status='5' WHERE challenge_id = $chalange ; ") ;
}
if(isset($_POST['own_chl_response'])) {
    $user_id = $_SESSION['user_id'];
    $own_challenge_id_comment = $_POST['own_challen_id'] ;
    $own_ch_response = $_POST['own_ch_response'] ;
    events($db_handle,$user_id,"3",$own_challenge_id_comment);
    involve_in($db_handle,$user_id,"3",$own_challenge_id_comment);
    if (strlen($own_ch_response)>1) {
	if (strlen($own_ch_response)<1000) {	
    mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) 
                                VALUES ('$user_id', '$own_challenge_id_comment', '$own_ch_response');") ;
    header('Location: #');
}
else { mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt) 
                                VALUES (default, '$own_ch_response');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt, blob_id) 
                                VALUES ('$user_id', '$own_challenge_id_comment', ' ', '$id');") ;
    header('Location: #');
	}
} 
else { echo "<script>alert('Is your mind empty!')</script>"; }
}

if(isset($_POST['accept'])) {
	$id = $_POST['id'] ;
	echo "<div style='display: block;' class='modal fade in' id='eye' tabindex='-1' role='dialog' aria-labelledby='shareuserinfo' aria-hidden='false'>
			<div class='modal-dialog'> 
				<div class='modal-content'>
				 <div class='modal-header'> 
				   <a href = 'ninjas.php' type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></a>
				   <h4 class='modal-title' id='myModalLabel'>Accept Challenge</h4> 
				 </div> 
				 <div class='modal-body'> 
				  <form method='POST' class='inline-form' onsubmit=\"return confirm('Really, Accept challenge !!!')\"><br/>
				    Your ETA : 
				      <select class='btn btn-default btn-xs' name = 'y_eta' ><option value='0' selected >Month</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option></select>
				      <select class='btn btn-default btn-xs' name = 'y_etab' ><option value='0' selected >Days</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option></select>
				      <select class='btn btn-default btn-xs' name = 'y_etac' ><option value='0' selected >hours</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option></select>&nbsp;
				      <select class='btn btn-default btn-xs' name = 'y_etad' ><option value='15' selected >minute</option><option value='30' >30</option><option value='45' >45</option></select>
				    <input type='hidden' name='cid' value='".$id."'><br/><br/>
				    <input type='submit' class='btn btn-success btn-sm' name='chlange' value = 'Accept' >
				  </form>
				</div> 
				<div class='modal-footer'>
				   <a type='button' href = 'ninjas.php' class='btn btn-default' data-dismiss='modal'>Close</a>
				</div>
			</div> 
		</div>
	</div>" ;
}
if(isset($_POST['accept_pub'])) {
	$id = $_POST['id'] ;
	$user_id = $_SESSION['user_id'];
	events($db_handle,$user_id,"4",$id);
    involve_in($db_handle,$user_id,"4",$id);
	mysqli_query($db_handle,"UPDATE challenges SET challenge_status='2' WHERE challenge_id = '$id' ; ") ;
		mysqli_query($db_handle,"INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)
									VALUES ('$user_id', '$id', '1');") ;
header('Location: #');
}
if (isset($_POST['logout'])) {
    header('Location: index.php');
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    session_destroy();
    exit ;
}
if (isset($_POST['joinproject'])) {
	$user_id = $_SESSION['user_id'];
	$idpt = $_POST['project_id'] ;
	events($db_handle,$user_id,"13",$idpt);
    involve_in($db_handle,$user_id,"13",$idpt);
	mysqli_query($db_handle, "INSERT INTO teams (user_id, project_id, team_name) VALUES ('$user_id', '$idpt', 'defaultteam') ;") ;
	echo "<script>alert('Joined Successfully')</script>" ;
	header('Location: #');
}   
if(isset($_POST['spem'])) {
	$id = $_POST['spem'] ;
	$user_id = $_SESSION['user_id'];
	mysqli_query($db_handle,"insert into spems (user_id, spem_id, type) VALUES ('$user_id', '$id', '2');") ;
	mysqli_query($db_handle,"UPDATE response_challenge SET status='4' WHERE response_ch_id = '$id'; ") ;
	header('Location: #');
	}
if(isset($_POST['spem_prresp'])) {
	$id = $_POST['spem_prresp'] ;
	$user_id = $_SESSION['user_id'];
	mysqli_query($db_handle,"insert into spems (user_id, spem_id, type) VALUES ('$user_id', '$id', '3');") ;
	mysqli_query($db_handle,"UPDATE response_project SET status='4' WHERE response_pr_id = '$id'; ") ;
	header('Location: #');
	}
if(isset($_POST['pr_spem'])) {
	$idch = $_POST['pr_spem'] ;
	$user_id = $_SESSION['user_id'];
	events($db_handle,$user_id,"7",$idch);
    involve_in($db_handle,$user_id,"7",$idch);
	mysqli_query($db_handle,"insert into spems (user_id, spem_id, type) VALUES ('$user_id', '$idch', '1');") ;
	mysqli_query($db_handle,"UPDATE challenges SET challenge_status='7' WHERE challenge_id = '$idch'; ") ;
	header('Location: #');
	}
/* if(isset($_POST['eta'])) {
	$id = $_POST['id'] ;
	echo "<div style='display: block;' class='modal fade in' id='asd' tabindex='-1' role='dialog' aria-labelledby='shareuserinfo' aria-hidden='false'>
			<div class='modal-dialog'> 
				<div class='modal-content'>
				 <div class='modal-header'> 
				   <a href = 'ninjas.php' type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></a>
				   <h4 class='modal-title' id='myModalLabel'>Change Estimated Time</h4> 
				 </div> 
				 <div class='modal-body'> 
				  <form method='POST' class='inline-form' onsubmit=\"return confirm('Can not beat deadline in given ETA !!!')\"><br/>
				    New ETA : 
				      <select class='btn btn-default btn-xs' name = 'y_eta' ><option value='0' selected >Month</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option></select>
				      <select class='btn btn-default btn-xs' name = 'y_etab' ><option value='0' selected >Days</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option></select>
				      <select class='btn btn-default btn-xs' name = 'y_etac' ><option value='0' selected >hours</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option></select>&nbsp;
				      <select class='btn btn-default btn-xs' name = 'y_etad' ><option value='15' selected >minute</option><option value='30' >30</option><option value='45' >45</option></select>
				    <input type='hidden' name='cid' value='".$id."'><br/><br/>
				    <input type='submit' class='btn btn-success btn-sm' name='change_eta' value = 'Change' >
				  </form>
				</div> 
				<div class='modal-footer'>
				   <a type='button' href = 'ninjas.php' class='btn btn-default' data-dismiss='modal'>Close</a>
				</div>
			</div> 
		</div>
	</div>" ;
}
*/
if (isset($_POST['chlange'])) {
		$user_id = $_SESSION['user_id'];
		$chalange = $_POST['cid'] ;
		$youreta = $_POST['y_eta'] ;
		$youretab = $_POST['y_etab'] ;
		$youretac = $_POST['y_etac'] ;
		$youretad = $_POST['y_etad'] ;
		$your_eta = 1 ;//(($youreta*30+$youretab)*24+$youretac)*60+$youretad ;
		events($db_handle,$user_id,"4",$chalange);
    involve_in($db_handle,$user_id,"4",$chalange);
		mysqli_query($db_handle,"UPDATE challenges SET challenge_status='2' WHERE challenge_id = $chalange ; ") ;
		mysqli_query($db_handle,"INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)
									VALUES ('$user_id', '$chalange', '$your_eta');") ;
header('Location: #');
}
if (isset($_POST['closechal'])) {
		$chalange = $_POST['cid'] ;
		$user_id = $_SESSION['user_id'];
	events($db_handle,$user_id,"6",$chalange);
    involve_in($db_handle,$user_id,"6",$chalange);
    mysqli_query($db_handle,"UPDATE challenges SET challenge_status='5' WHERE challenge_id = $chalange ; ") ;
}
/*if (isset($_POST['change_eta'])) {
		$user_id = $_SESSION['user_id'];
		$a = date("y-m-d H:i:s") ;
		$chalange = $_POST['cid'] ;
		$youreta = $_POST['y_eta'] ;
		$youretab = $_POST['y_etab'] ;
		$youretac = $_POST['y_etac'] ;
		$youretad = $_POST['y_etad'] ;
		$your_eta = (($youreta*30+$youretab)*24+$youretac)*60+$youretad ;
		mysqli_query($db_handle,"UPDATE challenges SET challenge_ETA='$your_eta', challenge_creation='$a' WHERE challenge_id = $chalange ; ") ;
header('Location: #');
} */
function checkProject($projectID, $userId, $db_handle){
	//returns true in case of public
	$type = mysqli_query($db_handle,"select project_type from projects where project_id = '$projectID' ;") ;
	$typerow = mysqli_fetch_array($type) ;
	if ($typerow['project_type'] == 1) {
			return true ;
		}
		else if(!isset($_SESSION['user_id'])) return false;
	else if ($typerow['project_type'] == 2) {
		$access = mysqli_query($db_handle,"(select user_id from projects where project_id = '$projectID' and user_id = '$userId')
											UNION 
											(SELECT DISTINCT a.user_id FROM teams as a join projects as b WHERE a.user_id = '$userId' and a.project_id = b.project_id and b.project_id = '$projectID');") ;
	if (mysqli_num_rows($access) > 0) {
		return true ;
		}
	 return false ;
	}
	else {
		return false ;
		}
	//check user have access if access the return true
	
	}

if(isset($_GET['projectphp'])){
	$projt_id = $_GET['project_id'];
	if(checkProject($projt_id,$user_id,$db_handle)) {
		 header("location: project.php?project_id=$projt_id") ;		
		exit ;
	} else {
		header("location: ninjas.php") ;
		}
	}
?>
