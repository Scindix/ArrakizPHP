<?php
if(!isset($Settings) && !@include_once("./settings.php"))
	require_once("./settings.fallback.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class Error_Dialog extends Dialog
{
	function __construct()
	{
		global $Settings;
		parent::__construct();
		$this->dialogTitle = "Internal Software Error!";
		$this->dialogName = "error";
		$this->globalNotice = "error";
		$this->icon = "$Settings[MyServer]/css/img/warning.png";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("
				Login Failed!<br>
				Perhaps you're not registered?<br>
				Please contact us at info@scindix.tk for this problem.")),
				new CH\Btn("", "Close","closeDialogue('formSignedInFail')", "dialog"));
	}
}
?>
