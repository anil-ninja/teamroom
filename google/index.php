<?php
	include('config.php');
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Invite Friends</title>
</head>

<body link="#0C6182" vlink="#0C6182" alink="#0C6182">
<div align="center">
	<table border="0" width="80%" cellspacing="0" cellpadding="0" style="border: 1px solid #0C6182; padding: 0">
		<tr>
			<td bgcolor="#0D6183" background="images/cell_bg.png">
			<img border="0" src="images/logo.png" width="421" height="82"></td>
		</tr>
		<tr>
			<td style="font-family: Verdana; font-size: 10pt" align="center"><br>
			For more sample programs please visit
			<a target="_blank" href="http://www.a2zwebhelp.com">
			www.a2zwebhelp.com</a></td>
		</tr>
		<tr>
			<td align="center" height="300" style="font-family: Trebuchet MS; font-size: 24pt; text-transform: uppercase; font-weight: bold"><br>
			<br>
			<br>
<a href="https://accounts.google.com/o/oauth2/auth?client_id=<?php print $clientid; ?>&redirect_uri=<?php print $redirecturi; ?>&scope=https://www.google.com/m8/feeds/&response_type=code" style="text-decoration: none">
Invite Friends From Gmail</a>
<br>
			<br>
&nbsp;</td>
		</tr>
	</table>
</div>
</body>

</html>