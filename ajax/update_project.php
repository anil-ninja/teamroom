<?php
session_start();
include_once "../lib/db_connect.php";
if($_POST['id']){
	$user_id = $_SESSION['user_id'];
	$id= mysql_escape_String($_POST['id']);
	$image = $_POST['img'] ;
	$myquery = mysqli_query($db_handle,"(select stmt from projects where project_id='$id' and blob_id = '0')
										UNION 
										(select b.stmt from projects as a join blobs as b where a.project_id='$id' and a.blob_id = b.blob_id);") ;
	$myqueryRow = mysqli_fetch_array($myquery) ;
	$stmt = $myqueryRow['stmt'] ;
	if (strlen($image) < 30 ) {
		$challange = $stmt ;
	}
	else {
		$challange = $image." ".strstr($stmt, '<br/>') ;
		}
	$time = date("Y-m-d H:i:s") ;
	if(strlen($challange) < 1000) {
			mysqli_query($db_handle,"update projects set stmt='$challange' where project_id='$id';") ;
			}
			else {
				$myquery1 = mysqli_query($db_handle,"select blob_id from projects where project_id='$id';") ;
				$myquery1Row = mysqli_fetch_array($myquery1) ;
				$blob = $myquery1Row['blob_id'] ;
				mysqli_query($db_handle,"update blobs set stmt='$challange' where blob_id='$blob';") ;
				}
	echo $challange ;
	mysqli_close($db_handle);
} 
else echo "Invalid parameters!";
?>