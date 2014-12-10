<?php
 $config = parse_ini_file('config.ini', true);
$db_handle = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
		
?>
