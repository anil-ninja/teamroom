<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if ($_POST['talks']) {
    $user_id = $_SESSION['user_id'];
    $id = $_POST['talks'] ;
    $pro_id = $_POST['project_id'];
    $data = "" ;
$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id, a.response_pr_creation, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.response_pr_id > '$id' and a.response_pr_id != '$id' and a.user_id = b.user_id and a.blob_id = '0' and a.status = '5')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.response_pr_id > '$id' and a.response_pr_id != '$id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '5') ;");
while ($displayrowc = mysqli_fetch_array($displayb)) {
		$ida = $displayrowc['response_pr_id'];
		$idb = $displayrowc['username'];
		$projectres = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $displayrowc['stmt'])))));
		$data.= "<b>".$idb."</b>:	<small>" . $projectres . "</small><br/>";
	}
	if (mysqli_num_rows($displayb) != 0) {
			echo $data."|+".$ida ;
	}
	else {
		echo $data."|+0" ;
	}
}
mysqli_close($db_handle);
?>
