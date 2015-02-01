<?php
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';

if($_POST['id']){
	$id = mysqli_real_escape_string($db_handle, $_POST['id']);
	$projectsmt = $_POST['projectsmt'];
	$project = $_POST['title'];
	$user_id = $_SESSION['user_id'] ;
	$video = $_POST['video'];
	$time = date("Y-m-d H:i:s") ;
	$myquery = mysqli_query($db_handle,"(select stmt from projects where project_id='$id' and blob_id = '0')
										UNION 
										(select b.stmt from projects as a join blobs as b where a.project_id='$id' and a.blob_id = b.blob_id);") ;
	$myqueryRow = mysqli_fetch_array($myquery) ;
	$stmt = $myqueryRow['stmt'] ;
	events($db_handle,$user_id,"33",$id) ;
	involve_in($db_handle,$user_id,"33",$id) ;
	if($video == '') {
		if(substr($stmt, 0, 1) == '<') {
			$newstmt = strstr($stmt, '<br/>' , true)." <br/> ".$projectsmt ;
		}
		else {
			$newstmt = $projectsmt ;
		}
		if(strlen($newstmt) < 1000) {
			mysqli_query($db_handle,"update projects set stmt= '$newstmt', project_title='$project' where project_id='$id';") ;
		}
		else {
			$myquery1 = mysqli_query($db_handle,"select blob_id from projects where project_id='$id';") ;
			$myquery1Row = mysqli_fetch_array($myquery1) ;
			$blob = $myquery1Row['blob_id'] ;
			if($blob != '0') {
				mysqli_query($db_handle,"update blobs set stmt='$newstmt' where blob_id='$blob';") ;
				mysqli_query($db_handle,"update projects set project_title='$project' where project_id='$id';") ;
			}
			else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt)	VALUES (default, '$newstmt');");
				$idb = mysqli_insert_id($db_handle);
				mysqli_query($db_handle,"update projects set project_title='$project', blob_id = '$idb' where project_id='$id' ;") ;
			}
		}
		echo showLinks($newstmt) ;
	}
	else {
		$chaaa = $video."<br/> ".$projectsmt ;
		if(strlen($chaaa) < 1000) {
			mysqli_query($db_handle,"update projects set stmt='$chaaa', project_title='$project' where project_id='$id';") ;
		}
		else {
			$myquery1 = mysqli_query($db_handle,"select blob_id from projects where project_id='$id';") ;
			$myquery1Row = mysqli_fetch_array($myquery1) ;
			$blob = $myquery1Row['blob_id'] ;
			if($blob != '0') {
				mysqli_query($db_handle,"update blobs set stmt='$newstmt' where blob_id='$blob';") ;
				mysqli_query($db_handle,"update projects set project_title='$project' where project_id='$id';") ;
			}
			else {
				mysqli_query($db_handle, "INSERT INTO blobs (blob_id, stmt)	VALUES (default, '$newstmt');");
				$idb = mysqli_insert_id($db_handle);
				mysqli_query($db_handle,"update projects set project_title='$project', blob_id = '$idb' where project_id='$id' ;") ;
			}
		}
		echo showLinks($chaaa) ;
	}
	mysqli_query($db_handle,$sql);
}
?>
