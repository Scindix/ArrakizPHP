<?php
if(!isset($Settings) && !@include_once("./settings.php"))
	require_once("./settings.fallback.php");
//require_once("PHPMailer/mail.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
require_once("$Settings[MyDir]/class/Cryptography.class.php");
global $globalSession;
$globalSession = NULL;
function login($user, $password)
{
	global $Settings;
	$table = SQL::getTable("user", "Mail='$user'");
	$userData = SQL::getRow($table);
	$passwordHash = $userData['Password'];
	if (Cryptography::validate($password, $passwordHash) && $userData['Status']>0) {
		$newSessionHash = generateHash();
		$newSesionTimeout = time()+432000;//5 days
		$updateResult = SQL::update("user","SessionID='".Cryptography::hash($newSessionHash)."'", "Mail='$user'");
		$updateResult = SQL::update("user","SessionTimeout='".date('Y-m-d', $newSesionTimeout)."'", "Mail='$user'");
		//echo $userData['Mail'];
		setcookie("id", $userData['Mail'], $newSesionTimeout);//, $base_directory, $base_domain, 1);
		setcookie("session", $newSessionHash, $newSesionTimeout);//, $base_directory, $base_domain, 1);
		SQL::close();
		return true;
	}
	else
	{
		SQL::close();
		return false;
	}
}
function getGuestSession()
{
	$newSessionHash = (isset($_COOKIE['session']))?($_COOKIE['session']):(generateHash());
	$newSesionTimeout = time()+432000;//5 days
	return array("ID" => 0,
				"Name" => "Guest",
				"Mail" => "",
				"Status" => 0,
				"Password" => "",
				"SessionID" => Cryptography::hash($newSessionHash),
				"SessionTimeout" => date('Y-m-d', $newSesionTimeout),
				"InstalledPackages" => "",
				"Avatar" => 1,
				"Firstname" => "Guest",
				"Lastname" => "",
				"About" => "",
				"Skills" => ""
	);
	setcookie("id", "guest", $newSesionTimeout);//, $base_directory, $base_domain, 1);
	setcookie("session", $newSessionHash, $newSesionTimeout);//, $base_directory, $base_domain, 1);
}
function getSession()
{
	global $globalSession;
	//if($globalSession)
		//return $globalSession;
	if(!isset($_COOKIE['id']) || !isset($_COOKIE['session']))
		return getGuestSession();
	$cookieID = $_COOKIE['id'];
	$cookieSession = $_COOKIE['session'];
	$table = SQL::getTable("user", "Mail='$cookieID'");
	if(!$table)
		return getGuestSession();
	$userData = SQL::getRow($table);
	$passwordHash = $userData['SessionID'];
	if (Cryptography::validate($cookieSession, $passwordHash) && $userData['Status']>0) {
		SQL::close();
		$globalSession = $userData;
		return $userData;
	}
	else
	{
		SQL::close();
		$globalSession = getGuestSession();
		return $globalSession;
	}
}

function logout()
{
	$cookieID = (isset($_COOKIE['id']))?$_COOKIE['id']:"";
	$cookieSession = (isset($_COOKIE['session']))?$_COOKIE['session']:"";
	
	$table = SQL::getTable("user", "Mail='$cookieID'");
	$userData = SQL::getRow($table);
	$passwordHash = $userData['SessionID'];
	if (Cryptography::validate($cookieSession, $passwordHash)) {
		setcookie ("session", "", time()-3600);
		setcookie ("id", "", time()-3600);
		SQL::close();
		return true;
	}
	else
	{
		SQL::close();
		return false;
	}
}

function userExists($user) {
	$table = SQL::getTable("user", "Mail='$user'");
	return SQL::getRowCount($table)>0;
}

function generateHash() {
	$result = "";
	$charPool = '0123456789abcdefghijklmnopqrstuvwxyz';
	for($p = 0; $p<15; $p++)
		$result .= $charPool[mt_rand(0,strlen($charPool)-1)];
	return sha1(md5(sha1($result)));
}

function endRegistration($user, $sessionID) {
	$table = SQL::getTable("user", "Mail='$user'");
	$userData = SQL::getRow($table);
	$sessionHash = $userData['SessionID'];
	if (Cryptography::validate($sessionID, $sessionHash)) {
		SQL::update("user", "Status=1", "Mail='$user'");
		SQL::close();
		return true;
	}
	else
	{
		SQL::close();
		return false;
	}
}

function deleteCurrentUser() {
	$currentSession = getSession();
	if($currentSession && userExists($currentSession['Mail']))
	{
		SQL::delete("user", "Mail='$currentSession[Mail]'");
		SQL::close();
		return true;
	} else
	{
		return false;
	}
}

function signup($name, $mail, $password) {
	global $Settings;
	if(!userExists($mail))
	{
		$newSessionHash = generateHash();
		$newSesionTimeout = time()+432000;//5 days
		$cryptedPasswd = Cryptography::hash($password);
		SQL::insert("user", array(
			"Name"				=> "'$name'",
			"Mail"				=> "'$mail'",
			"Status"			=> "0",
			"Password"			=> "'$cryptedPasswd'",
			"SessionID"			=> "'".Cryptography::hash($newSessionHash)."'",
			"SessionTimeout"	=> "'".date('Y-m-d', $newSesionTimeout)."'",
			"Avatar"			=> "3",
		));
		$recipient = $mail;
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$header .= "From: $Settings[Name] registration robot <no-reply@$Settings[MyMailHost]>" . "\r\n";
		$header .= "To: $Settings[Name] <$mail>" . "\r\n";
		$header .= "Reply-To: Admin <$Settings[authorMail]>" . "\r\n";
		$subject = "Your registration at $Settings[Name]";
		$message = "<html><head><title>Your registration at $Settings[Name]</title></head><body>
Hello $name,<br>Your registration at $Settings[Name] ($Settings[MyServer]) was successful. If you can't remeber registering at this website, please just ignore this e-mail We won't bother you again.<br>To complete the registration process you have to click on the link below. If your mail program doesn't resolve this URL as weblink, you can also paste and copy it to the adress bar of your favourite browser.<br><br>Link for completion of your registration:<br><a href=\"$Settings[MyServer]/endRegistration.php?user=$mail&session=$newSessionHash\">$Settings[MyServer]/endRegistration.php?user=$mail&session=$newSessionHash</a></body></html>";
		mail($recipient, $subject, $message, $header);
		SQL::close();
		return true;
	} else
	{
		SQL::close();
		return false;
	}
}
?>
