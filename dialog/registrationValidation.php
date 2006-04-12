<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "formRegistrationValidation";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("Your Registration is almost complete!<br>
				Just wait a few minutes for the validation mail and follow the instructions.")),
				new CH\Btn("", "Close","closeDialogue('formRegistrationValidation')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
