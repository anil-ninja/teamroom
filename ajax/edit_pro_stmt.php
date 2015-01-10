<?php
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';

if($_POST['id']){
	$id=mysql_escape_String($_POST['id']);
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
	events($db_handle,$user_id,"33",$pro_id) ;
	involve_in($db_handle,$user_id,"33",$pro_id) ;
	if($video == '') {
		if(substr($stmt, 0, 1) == '<') {
			$newstmt = strstr($stmt, '<br/>' , true)."<br/>".$projectsmt ;
			}
			else {
				$newstmt = $projectsmt ;
				}
		if(strlen($newstmt) < 1000) {
			mysqli_query($db_handle,"update projects set stmt='$newstmt', project_title='$project' where project_id='$id';") ;
			}
			else {
				mysqli_query($db_handle,"update projects set project_title='$project' where project_id='$id';") ;
				$myquery1 = mysqli_query($db_handle,"select blob_id from projects where project_id='$id';") ;
				$myquery1Row = mysqli_fetch_array($myquery1) ;
				$blob = $myquery1Row['blob_id'] ;
				mysqli_query($db_handle,"update blobs set stmt='$newstmt' where blob_id='$blob';") ;
				}
				echo showLinks($newstmt) ;
		}
		else {
			$chaaa = $video."<br/> ".$projectsmt ;
			if(strlen($chaaa) < 1000) {
				mysqli_query($db_handle,"update projects set stmt='$chaaa', project_title='$project' where project_id='$id';") ;
			}
			else {
				mysqli_query($db_handle,"update projects set project_title='$project' where project_id='$id';") ;
				$myquery1 = mysqli_query($db_handle,"select blob_id from projects where project_id='$id';") ;
				$myquery1Row = mysqli_fetch_array($myquery1) ;
				$blob = $myquery1Row['blob_id'] ;
				mysqli_query($db_handle,"update blobs set stmt='$chaaa' where blob_id='$blob';") ;
				}
				echo showLinks($chaaa) ;
			}
	mysqli_query($db_handle,$sql);
}
?>
