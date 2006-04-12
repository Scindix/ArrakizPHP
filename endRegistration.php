<?php
require_once('signin.php');
if(endRegistration($_GET['user'], $_GET['session']))
	//echo "registration process successfull!";
	header("location: !prompt=registrationSuccess/Home");
else
	//echo "registration process failed!";
	header("location: !prompt=registrationFail/Home");
	


die;

?>
