<?php
session_start();
include_once "../lib/db_connect.php";
include_once '../functions/delete_comment.php';
if ($_POST['prtalk']) {
    $user_id = $_SESSION['user_id'];
    $pro_id = $_POST['project_id'];
    $data = "" ;
	$displayb = mysqli_query($db_handle, "(SELECT DISTINCT a.stmt, a.response_pr_id,a.response_pr_creation, b.username from response_project as a join user_info as b 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = '0' and	a.status = '5')
                                        UNION
                                        (SELECT DISTINCT c.stmt, a.response_pr_id, a.response_pr_creation, b.username from response_project as a join user_info as b join blobs as c 
                                        where a.project_id = '$pro_id' and a.user_id = b.user_id and a.blob_id = c.blob_id and a.status = '5') ORDER BY response_pr_creation ASC;");
	while ($displayrowc = mysqli_fetch_array($displayb)) {
		$ida = $displayrowc['response_pr_id'];
		$username = $displayrowc['username'];
		$projectres = showLinks(str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $displayrowc['stmt'])))));
		$data .= "<b>".$username."</b>:	<small>" . $projectres . "</small><br/>";
	}
	$data = $data ."<div class='newtalkspr'></div>" ;
	$data2 = "<textarea class='chatboxtextarea' onkeydown='javascript:return submittalk(event,this);'></textarea>" ;
	echo $data."+".$data2."+".$ida ;
mysqli_close($db_handle);
}
?>
