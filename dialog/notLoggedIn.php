<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "notLoggedIn";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("Illegal action!<br>
				You are not allowed to open the settings,<br>because you are not logged in!")),
				new CH\Btn("", "Close","closeDialogue('notLoggedIn')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
