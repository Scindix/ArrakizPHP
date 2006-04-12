<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "formRegistrationSuccess";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("Your Registration has completed!<br>
				You can now sign in.")),
				new CH\Btn("", "Close","closeDialogue('formRegistrationSuccess')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
