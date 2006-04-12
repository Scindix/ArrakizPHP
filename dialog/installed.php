<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "installationSuccess";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("
				Congratulations!<br>
				Your installation is complete now.<br>
				Please make sure that you click on the registration link in the mail you recieved to activate your admin account.<br>")),
				new CH\Btn("", "Close","closeDialogue('installationSuccess')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
