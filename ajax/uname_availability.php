<?php
$username=$_REQUEST['username'];
if(preg_match("/[^a-z0-9]/",$username))
{
print "<span style=\"color:red;\">Username contains illegal charaters.</span>";
exit;
}
include_once "../lib/db_connect.php";
$sql="SELECT * FROM user_info where username='$username'";
$data=mysqli_query($db_handle,$sql);
if(mysqli_num_rows($data)>0)
{
print "<span style=\"color:red;\">Username already exists</span>";
}
else
{
print "<span style=\"color:green;\">Username is available</span>";
}
?>