<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "savingPageFail";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("Unfortunately, saving the Page failed!")),
				new CH\Btn("", "Close","closeDialogue('savingPageFail')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
