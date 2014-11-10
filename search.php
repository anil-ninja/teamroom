<?php
include_once 'lib/db_connect.php';

$keyword = $_GET['keyword'] ;
$searchResults = mysqli_query($db_handle, ("SELECT challenge_id, challenge_title, LEFT(stmt, 300) as stmt 
	FROM challenges 
	WHERE challenge_type != '2' and challenge_status != '3' and challenge_status != '7'
	AND ((challenge_title like '%$keyword%' And stmt NOT LIKE '<iframe%') 
	OR (stmt like '%$keyword%' And stmt NOT LIKE '<iframe%') 
	);"));

$data = array();
while($row = $searchResults->fetch_assoc()){
    $data[] = $row;
}
echo json_encode($data);
?>
