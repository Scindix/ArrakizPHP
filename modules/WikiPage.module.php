<?php
use \CodeHelper as CH;
	class ModWikiPage extends Module
	{
		function __construct() {
			$this->title = "Wiki";
			$this->titleTooltip = "Wiki";
			$table = \SQL::getTable("pages", "ORDER BY Timestamp DESC", "Name=\"".\SQL::escape("$_GET[page]")."\"");
			if(\SQL::getRowCount($table)>0)
			{
				$result = \SQL::getRow($table);
				$URIview = \Util::genURI(array("action" => "view"));
				$URIedit = \Util::genURI(array("action" => "edit"));
				$URIdisc = \Util::genURI(array("action" => "discuss"));
				$pageTabs = new CH\HTMLNode("<div class=\"page-tabs\">
											<a href=\"$URIview\" id=\"page-tab-view\" class=\"page-tab\">View</a>
											<a href=\"$URIedit\" id=\"page-tab-edit\" class=\"page-tab\">Edit</a>
											<a href=\"$URIdisc\" id=\"page-tab-discuss\" class=\"page-tab\">Discussion</a>
											</div>");
				$pc = new CH\TagContainer("div class=\"page-container\"", $pageTabs, new CH\PageContent(new CH\WikiNode(substr($result["Content"],1,-1))));
				
				if(isset($_GET["action"])&&$_GET["action"]=="edit")
					$pc = new CH\TagContainer("div class=\"page-container\"", $pageTabs, new CH\PageContent(new CH\TagContainer("div class=\"edit-container\"", new CH\BasicText("edit-title", $result["Title"], "Title", "text edit"), new CH\TextArea("EditArea", substr($result["Content"],1,-1)), new CH\TagContainer("div class=\"align-right\"", new CH\Group(new CH\Btn("preview", "Preview", "loadPreview('inEditArea')"), new CH\Btn("save", "Save", "loadDialogue('saveWikiPage', 'wikipage=$result[Name]&title=$result[Title]', document.getElementById('inEditArea').value)", "important"))))));
					
				if(isset($_GET["action"])&&$_GET["action"]=="discuss")
					$pc = new CH\TagContainer("div class=\"page-container\"", $pageTabs, new CH\PageContent(new CH\Stream($result["Stream"])));
			}
			else
			{
				$currentSession = getSession();
				$onloggedin = new CH\TagContainer("span");
				if($currentSession["Status"]===0)
					$onloggedin = new CH\TagContainer("span", new CH\HTMLNode("You're not logged in. So your IP-Adress will be saved and may be viewable publicly!<br>You can also "), new CH\Anchor("#", "sign in", "loadDialogue('signUp');"), new CH\HTMLNode("<br>"));
				$pc = (new CH\PageContent(new CH\PaddingContainer(new CH\HTMLNode("<b>Page ('$_GET[page]') does not exist !</b> But you can create it.<br>"), $onloggedin, new CH\TagContainer("div class=\"edit-container\"", new CH\BasicText("edit-title", "", "Title", "text edit"), new CH\TextArea("EditArea", ""), new CH\TagContainer("div class=\"align-right\"", new CH\Group(new CH\Btn("preview", "Preview", "loadPreview('inEditArea')"), new CH\Btn("save", "Save", "loadDialogue('saveWikiPage', 'wikipage=/$_GET[page]&title='+document.getElementById('inedit-title').value, document.getElementById('inEditArea').value)", "important")))))));
			}
			//$pc = (new CH\PageContent(new CH\PaddingContainer(new CH\TextNode("Under construction!"))));
						
$this->content = $pc->printOut();
		}
	}
?>
