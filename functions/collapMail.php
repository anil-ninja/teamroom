<?php
function collapMail($to, $subject, $body){
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';
	$headers[] = "From: Collap.com Support <support@collap.com>";
	$headers[] = "Bcc: ";
	$headers[] = "Reply-To: Collap.com Support <support@collap.com>";
	$headers[] = "X-Mailer: PHP/".phpversion();
	
	mail($to, $subject, $body, implode("\r\n", $headers));
}
?>
