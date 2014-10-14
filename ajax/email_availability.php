<?php
$email=$_REQUEST['email'];

include_once "../lib/db_connect.php";
//echo 'dkugdfkgfjfdkhgfkjdvgfvgjhdfvgjdfghjgjhgvjdhvghjvgjhdsvgdskjvgkjgkjGKgjr';
$sql="SELECT * FROM user_info where email='$email'";
$data=mysqli_query($db_handle,$sql);
if(mysqli_num_rows($data)>0)
{
print "<span style=\"color:red;\">Email already exists :(</span>";
}
else
{
print "<span style=\"color:green;\">Email is available :)</span>";
}
?>