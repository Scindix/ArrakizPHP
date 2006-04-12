<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "formSignedOut";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("
				Successfully logged out!")),
				new CH\Btn("", "Close","closeDialogue('formSignedOut')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
