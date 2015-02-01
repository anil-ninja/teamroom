<?php
include_once "../lib/db_connect.php";
include_once "../functions/delete_comment.php";
if($_POST['id']){
	$id=mysql_escape_String($_POST['id']);
	$projectsmt = $_POST['projectsmt'];
	$project = $_POST['title'];
	$video = $_POST['video'];
	$time = date("Y-m-d H:i:s") ;
	$myquery = mysqli_query($db_handle,"(select stmt from challenges where challenge_id='$id' and blob_id = '0')
										UNION 
										(select b.stmt from challenges as a join blobs as b where a.challenge_id='$id' and a.blob_id = b.blob_id);") ;
	$myqueryRow = mysqli_fetch_array($myquery) ;
	$stmt = $myqueryRow['stmt'] ;
	if($video == '') {
		if(substr($stmt, 0, 1) == '<') {
			$newstmt = strstr($stmt, '<br/>' , true)."<br/>".$projectsmt ;
		}
		else {
			$newstmt = $projectsmt ;
		}
		if(strlen($newstmt) < 1000) {
			mysqli_query($db_handle,"update challenges set stmt='$newstmt', challenge_title='$project', last_update = '$time' where challenge_id='$id';") ;
		}
		else {
			$myquery1 = mysqli_query($db_handle,"select blob_id from challenges where challenge_id='$id';") ;
			$myquery1Row = mysqli_fetch_array($myquery1) ;
			$blob = $myquery1Row['blob_id'] ;
			if($blob != '0') {
				mysqli_query($db_handle,"update blobs set stmt='$newstmt' where blob_id='$blob';") ;
				mysqli_query($db_handle,"update challenges set challenge_title='$project', last_update = '$time' where challenge_id='$id';") ;
			}
			else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt)	VALUES (default, '$newstmt');");
				$idb = mysqli_insert_id($db_handle);
				mysqli_query($db_handle,"update challenges set challenge_title='$project', blob_id = '$idb', last_update = '$time' where challenge_id='$id';") ;
			}
		}
		echo showLinks($newstmt) ;
	}
	else {
		$chaaa = $video."<br/> ".$projectsmt ;
		if(strlen($chaaa) < 1000) {
			mysqli_query($db_handle,"update challenges set stmt='$chaaa', challenge_title='$project', last_update = '$time' where challenge_id='$id';") ;
		}
		else {
			$myquery1 = mysqli_query($db_handle,"select blob_id from challenges where challenge_id='$id';") ;
			$myquery1Row = mysqli_fetch_array($myquery1) ;
			$blob = $myquery1Row['blob_id'] ;
			if($blob != '0') {
				mysqli_query($db_handle,"update blobs set stmt='$newstmt' where blob_id='$blob';") ;
				mysqli_query($db_handle,"update challenges set challenge_title='$project', last_update = '$time' where challenge_id='$id';") ;
			}
			else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt)	VALUES (default, '$newstmt');");
				$idb = mysqli_insert_id($db_handle);
				mysqli_query($db_handle,"update challenges set challenge_title='$project', blob_id = '$idb', last_update = '$time' where challenge_id='$id';") ;
			}
		}
		echo showLinks($chaaa) ;
	}
	mysqli_close($db_handle);
}
?>
