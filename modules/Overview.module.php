<?php
use \CodeHelper as CH;
class ModOverview extends Module
{
	function __construct() {
		$this->title = "Overview";
		$this->titleTooltip = "Overview";
		$pc = new CH\IntroContent(new CH\AlbumView("1", "10000"));
		$this->content = $pc->printOut();
	}
}
?>
