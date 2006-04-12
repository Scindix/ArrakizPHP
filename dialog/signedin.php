<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
require_once('signin.php');
class _Dialog extends Dialog
{
	function __construct()
	{
		$currentSession = getSession();
		$currentUserName = $currentSession['Name'];
		$currentSessionTimeout = $currentSession['SessionTimeOut'];
		parent::__construct();
		$this->dialogName = "formSignedin";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("
				Login successful!<br>
				You're now signed in as $currentUserName<br>
				Your Session lasts until $currentSessionTimeout")),
				new CH\Btn("", "Close","closeDialogue('formSignedin')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
