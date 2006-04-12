<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "previewWiki";
		$this->dialogTitle = "Preview";
		global $POST_DATA;
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\TagContainer("div class=\"pagePreviewContainer\"", new CH\WikiNode($POST_DATA))),
				
					new CH\Btn("", "Close", "closeDialogue('previewWiki')", "dialog"));
	}
}
$d = (new _Dialog());
		$d->init();
?>
