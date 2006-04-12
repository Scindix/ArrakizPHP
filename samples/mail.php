<?php
$mail = "cedric@wehrumnet.de";
$name = "cedric";
$authormail = "info@arrakiz.org";
$Settings['MyMailHost'] = substr($authormail, strpos($authormail, "@")+1);
/*$recipient = $mail;
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$header .= "From: [Name] registration robot <no-reply@[MyHost]>" . "\r\n";
		$header .= "To: [Name] <$mail>" . "\r\n";
		$header .= "Reply-To: Admin <$authormail>" . "\r\n";
		$subject = "Your registration at [Name]";
		$message = "<html><head><title>Your registration at [Name]</title></head><body>
Hello $name,<br>Your registration at [Name] ([MyServer]) was successful. If you can't remeber registering at this website, please just ignore this e-mail We won't bother you again'.<br>To complete the registration process you have to click on the link below. If your mail program doesn't resolve this URL as weblink, you can also paste and copy it to the adress bar of your favourite browser.<br><br>Link for completion of your registration:<br><a href=\"[MyServer]/endRegistration.php?user=$mail&session=[newSessionHash]\">[MyServer]/endRegistration.php?user=$mail&session=[newSessionHash]</a></body></html>";
		mail($recipient, $subject, $message, $header);*/




// mehrere Empfänger
$recipient  = $mail;

// Betreff
$subject = "Your registration at [Name]";

// Nachricht
$message = 
"<html><head><title>Your registration at [Name]</title></head><body>
Hello $name,<br>Your registration at [Name] ([MyServer]) was successful. If you can't remeber registering at this website, please just ignore this e-mail We won't bother you again.<br>To complete the registration process you have to click on the link below. If your mail program doesn't resolve this URL as weblink, you can also paste and copy it to the adress bar of your favourite browser.<br><br>Link for completion of your registration:<br><a href=\"[MyServer]/endRegistration.php?user=$mail&session=[newSessionHash]\">[MyServer]/endRegistration.php?user=$mail&session=[newSessionHash]</a></body></html>";

// für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
$header  = 'MIME-Version: 1.0' . "\r\n";
$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// zusätzliche Header
$header .= "To: $name <$mail>" . "\r\n";
$header .= "From: [Name] registration robot <no-reply@$Settings[MyMailHost]>" . "\r\n";
$header .= "Reply-To: Admin <$authormail>" . "\r\n";
//$header .= 'Cc: geburtstagsarchiv@example.com' . "\r\n";
//$header .= 'Bcc: geburtstagscheck@example.com' . "\r\n";

// verschicke die E-Mail
mail($recipient, $subject, $message, $header);
?>
