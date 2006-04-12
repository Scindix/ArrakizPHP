<?php
error_reporting(E_ALL);

date_default_timezone_set('Europe/Berlin');

require_once('PHPMailer/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
//str_replace(array_keys($replacement), $replacement, $_GET["p"]);
function user_mail($recipient, $recipientName, $subject, $message, $replacements)
{
	//$this->smtp_conn = 0;
	//$this->smtp_conn = @fsockopen('smtp.gmail.com', 465, $errno, $errstr, 30);
	//$useServer = true;
	//if($useServer)
		server_mail($recipient, $recipientName, $subject, $message, $replacements);
	//else
		//smtp_mail($recipient, $recipientName, $subject, $message, $replacements);
}
function server_mail($recipient, $recipientName, $subject, $message, $replacements)
{
	$body             = file_get_contents('PHPMailer/mail.html');
	$body             = eregi_replace("[\]",'',$body);
	$body             = str_replace(array_keys($replacements), $replacements, $body);
	 
	$header  = "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
	 
	$header .= "From: scindix@bplaced.net\r\n";
	$header .= "Reply-To: support@scindix.tk\r\n";
	// $header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll
	$header .= "X-Mailer: PHP ". phpversion();
	 
	mail( "$recipientName <$recipient>",
		  $subject,
		  $body,
		  $header);
}
function smtp_mail($recipient, $recipientName, $subject, $message, $replacements)
{
	$mail             = new PHPMailer();

	$body             = file_get_contents('PHPMailer/mail.html');
	$body             = eregi_replace("[\]",'',$body);
	$body             = str_replace(array_keys($replacements), $replacements, $body);

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "smtp.gmail.com"; // SMTP server
	$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
		                                       // 1 = errors and messages
		                                       // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "wehrum.cedric@gmail.com";   // GMAIL username
	$mail->Password   = "hab84analytics";            // GMAIL password

	$mail->SetFrom('info@scindix.tk', 'Scindix Information Service');

	$mail->AddReplyTo("support@scindix.tk","Scindix Support Service");

	$mail->Subject    = $subject;

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

	$mail->MsgHTML($body);

	$address = $recipient;
	$mail->AddAddress($address, $recipientName);

	$mail->AddAttachment("scindix90.png");      // attachment

	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  echo "Message sent!";
	}
}
?>
