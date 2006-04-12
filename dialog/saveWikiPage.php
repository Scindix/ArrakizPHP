<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "saveWikiPage";
		$this->dialogTitle = "Saving...";
		global $POST_DATA;
		global $POST;
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\HTMLNode("Please wait while saving...")),
				
					new CH\Btn("", "Close", "closeDialogue('saveWikiPage')", "dialog"));
		$newPage = Util::genURI(array("action" => "view"), array("page" => "$POST[wikipage]"));
		$content = str_replace("'", "\'", json_encode($POST_DATA));
		$this->scriptAfter = "
		ajax.getHTML('updateWikipage',
		function(back)
		{
			if(back.indexOf('success')!=0)
			{
				alert('('+back+')'+' != (success) ???');
				loadDialogue('savingPageFail');
				closeDialogue('saveWikiPage');
			}
			else
				goto('$newPage');
		}, 'wikipage=$POST[wikipage]&title=$POST[title]', '$content');";
	}
}
$d = (new _Dialog());
		$d->init();
?>
