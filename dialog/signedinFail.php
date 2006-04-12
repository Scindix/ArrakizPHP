<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "formSignedInFail";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("
				Login Failed!<br>
				Perhaps you're not registered?<br>
				Please contact us at info@scindix.tk for this problem.")),
				new CH\Btn("", "Close","closeDialogue('formSignedInFail')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
