<?php
require_once('signin.php');
require_once("$Settings[MyDir]/class/util.class.php");
$redirect = array("page" => $_GET['redirect']);
if($_GET['type']=="signin")
{
	if(login($_GET['user'], $_GET['password']))
		//echo "Login was successful";
		header("location: ".Util::genURI(array("prompt" => "signedin"), $redirect));
	else
		//echo "Login failed";
		header("location: ".Util::genURI(array("prompt" => "signedinFail"), $redirect));
}
elseif($_GET['type']=="signout")
{
	if(logout())
		//echo "Logout was successful";
		header("location: ".Util::genURI(array("prompt" => "signedOut"), $redirect));
	else
		//echo "Logout failed";
		header("location: ".Util::genURI(array("prompt" => "signedOutFail"), $redirect));
}
elseif($_GET['type']=="check")
{
	if(getSession()["Status"]>0)
	{
		echo "You're logged in<br>";
		print_r(getSession());
	}
	else
		echo "You're not logged in";
}
elseif($_GET['type']=="userexists")
{
	if(userExists($_GET['user']))
		echo "User exists";
	else
		echo "User doesn't exist";
}
elseif($_GET['type']=="delete")
{
	if(deleteCurrentUser($_GET['user']))
		echo "User deleted";
	else
		echo "User deletion failed";
}
elseif($_GET['type']=="signup")
{
	if(signup($_GET['name'], $_GET['user'],  $_GET['password']))
		//echo "registration successful";
		header("location: ".Util::genURI(array("prompt" => "registrationValidation"), $redirect));
	else
		//echo "registration failed";
		header("location: ".Util::genURI(array("prompt" => "registrationValidationFail"), $redirect));
}




?>
