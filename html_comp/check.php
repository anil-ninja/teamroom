<?php
session_start() ;
$user_id = $_SESSION['user_id'] ;
if(isset($_SESSION['user_id'])) {
	$username = $_SESSION['username'] ;
	$url = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$check = mysqli_query($db_handle, "SELECT id FROM user_access_records WHERE user_id = '$user_id' and page_url like '%$url%' ;" ) ;
	if($url == "profile.php") {
		$newusername = $_GET['username'];
		if($username == $newusername) {
			$check2 = mysqli_query($db_handle, "SELECT id FROM user_access_records WHERE user_id = '$user_id' and page_url = '$actual_link' ;" ) ;
			if (mysqli_num_rows($check2) == 0) {
				?>
				<script type="text/javascript">profile_intro();</script>
				<?php
			}
		}
	}
	else if ($url == "project.php") {
		if (mysqli_num_rows($check) == 0) {
			?>
			<script type="text/javascript">project_intro() ;</script>
			<?php
		}
	}
	else if ($url == "ninjas.php") {
		if (mysqli_num_rows($check) == 0) {
			?>
			<script type="text/javascript"> ninjas_intro().done(projectToJoin); </script>
			<?php
		}
	}
	else if ($url == "challengesOpen.php") {
		if (mysqli_num_rows($check) == 0) {
			?>
			<script type="text/javascript">challengesOpen_intro() ;</script>
			<?php
		}
	}
	else {
		exit ;
	}
}
?>
