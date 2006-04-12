<?php
use \CodeHelper as CH;
	class ModContact extends Module
	{
		function __construct() {
			$this->title = "Contact";
			$this->titleTooltip = "Contact";
			$out =  "<div class=\"gradient previewEntry detail-view\">
				<div class=\"previewLeft\">
					<div class=\"previewTitle\">Cedric Wehrum - website maintainer | scindix developer | CMS developer</div>
					<div class=\"previewDescription\">cedric@wehrumnet.de</div>
				</div>
				<div class=\"previewRight\">
					<div onclick=\"goto('mailto:cedric@wehrumnet.de')\" class=\"btn btn-important\">Mail me</div>
				</div>
			</div>
			<div class=\"gradient previewEntry detail-view\">
				<div class=\"previewLeft\">
					<div class=\"previewTitle\">Sebastian Lang - community</div>
					<div class=\"previewDescription\">flightgear.longfly@gmail.com</div>
				</div>
				<div class=\"previewRight\">
					<div onclick=\"goto('mailto:flightgear.longfly@gmail.com')\" class=\"btn btn-important\">Mail me</div>
				</div>
			</div>";
			$pc = (new CH\PageContent(new CH\HTMLNode($out)));
						
$this->content = $pc->printOut();
		}
	}
?>
