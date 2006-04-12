<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "formSignOut";
		global $POST;
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("
				Do you really want to logout?")),
				new CH\Group(
					new CH\Btn("", "Yes", "goto('../simReg.php?type=signout&redirect=$POST[redirect]')", "important"),
					new CH\Btn("", "No", "closeDialogue('formSignOut')", "dialog")));
	}
}
$d = (new _Dialog());
		$d->init();
?>
