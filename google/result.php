<?php session_start(); ?>
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
			<td align="left" style="padding:20px; font-family: Trebuchet MS; font-size: 12pt; line-height:110%" valign="top">
<?php
//setting parameters

include('config.php');

$authcode		= $_GET["code"];



$fields=array(
'code'=>  urlencode($authcode),
'client_id'=>  urlencode($clientid),
'client_secret'=>  urlencode($clientsecret),
'redirect_uri'=>  urlencode($redirecturi),
'grant_type'=>  urlencode('authorization_code') );

//url-ify the data for the POST

$fields_string = '';

foreach($fields as $key=>$value){ $fields_string .= $key.'='.$value.'&'; }

$fields_string	=	rtrim($fields_string,'&');

//open connection
$ch = curl_init();

curl_setopt($ch,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token'); //set the url, number of POST vars, POST data

curl_setopt($ch,CURLOPT_POST,5);

curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set so curl_exec returns the result instead of outputting it.

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to trust any ssl certificates

$result = curl_exec($ch); //execute post

curl_close($ch); //close connection

//print_r($result);

//extracting access_token from response string

$response   =  json_decode($result);

$accesstoken = $response->access_token;


if( $accesstoken!='')

$_SESSION['token']= $accesstoken;

//passing accesstoken to obtain contact details

$xmlresponse=  file_get_contents('https://www.google.com/m8/feeds/contacts/default/full?max-results='.$maxresults.'&oauth_token='. $_SESSION['token']);

//reading xml using SimpleXML

$xml=  new SimpleXMLElement($xmlresponse);

$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');

$result = $xml->xpath('//gd:email');

$count = 0;
foreach ($result as $title) {
	$count++;
	
	echo $count.". ".$title->attributes()->address . "<br><br>";

}

?>

&nbsp;</td>
		</tr>
	</table>
</div>
</body>