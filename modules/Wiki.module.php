<?php
use \CodeHelper as CH;
	class ModWiki extends Module
	{
		function __construct() {
			$this->title = "WikiOld";
			$this->titleTooltip = "Wiki";
			$pc = (new CH\PageContent(new CH\PaddingContainer(new CH\TextNode("Under construction!"))));
						
$this->content = $pc->printOut();
		}
	}
?>
