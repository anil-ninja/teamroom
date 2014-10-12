<?php
include_once 'lib/db_connect.php';

session_start();
$user_id = $_SESSION['user_id'];
$name = $_SESSION['first_name'];
$rank = $_SESSION['rank'];
$email = $_SESSION['email'];

if (!isset($_SESSION['first_name'])) {
    header('Location: index.php');
}
if(isset($_POST['public_chl_response'])) {
    $user_id = $_SESSION['user_id'];
    $challenge_id_comment = $_POST['public_ch_id'] ; 
    $ch_response = $_POST['public_ch_response'] ;
   if(strlen($ch_response)>1){
    mysqli_query($db_handle,"INSERT INTO response_challenge (user_id, challenge_id, stmt) 
                                VALUES ('$user_id', '$challenge_id_comment', '$ch_response');") ;
    header('Location: #');
   }
   else{ echo "<script>alert('Is your mind empty!')</script>";
}
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
				    <input type='submit' class='btn btn-success btn-sm' name='chlange' value = 'Accept' ></small>
				  </form>
				</div> 
				<div class='modal-footer'>
				   <a type='button' href = 'ninjas.php' class='btn btn-default' data-dismiss='modal'>Close</a>
				</div>
			</div> 
		</div>
	</div>" ;
}
if (isset($_POST['logout'])) {
    header('Location: index.php');
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    session_destroy();
    exit ;
}   
if(isset($_POST['eta'])) {
	$id = $_POST['id'] ;
	echo "<div style='display: block;' class='modal fade in' id='eye' tabindex='-1' role='dialog' aria-labelledby='shareuserinfo' aria-hidden='false'>
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
				    <input type='submit' class='btn btn-success btn-sm' name='change' value = 'Change' ></small>
				  </form>
				</div> 
				<div class='modal-footer'>
				   <a type='button' href = 'ninjas.php' class='btn btn-default' data-dismiss='modal'>Close</a>
				</div>
			</div> 
		</div>
	</div>" ;
}

if (isset($_POST['chlange'])) {
		$user_id = $_SESSION['user_id'];
		$chalange = $_POST['cid'] ;
		$youreta = $_POST['y_eta'] ;
		$youretab = $_POST['y_etab'] ;
		$youretac = $_POST['y_etac'] ;
		$youretad = $_POST['y_etad'] ;
		$your_eta = (($youreta*30+$youretab)*24+$youretac)*60+$youretad ;
		mysqli_query($db_handle,"UPDATE challenges SET challenge_status='2' WHERE challenge_id = $chalange ; ") ;
		mysqli_query($db_handle,"INSERT INTO challenge_ownership (user_id, challenge_id, comp_ch_ETA)
									VALUES ('$user_id', '$chalange', '$your_eta');") ;
header('Location: ninjas.php');
}
if(isset($_POST['projectphp'])){
		 header('location: project.php') ;   
		$_SESSION['user_id'] = $user_id;
		$_SESSION['email'] = $email;
		$_SESSION['first_name'] = $name;
		$_SESSION['project_title'] = $_POST['project_title'] ;
		$_SESSION['project_id'] = $_POST['project_id'] ;
		$_SESSION['rank'] = $rank;
		exit ;
	}

?>
