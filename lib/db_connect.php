<?php
require_once('ConnectionProperties.class.php');
$db_handle = mysqli_connect(ConnectionProperty::getHost(), ConnectionProperty::getUser(), ConnectionProperty::getPassword(),ConnectionProperty::getDatabase());
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}		
?>
