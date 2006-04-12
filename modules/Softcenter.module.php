<?php
use \CodeHelper as CH;
	class ModSoftcenter extends Module
	{
		function __construct() {
			global $Settings;
			$this->title = "SoftCenter";
			$this->titleTooltip = "SoftCenter";
			
	global $Settings;
	$out = "";
	$searchID=isset($_GET['q'])?($_GET['q']):("");

	$btnViewShort = "";
	$btnViewTile = "";
	$btnViewDetail = "";

	$viewClass = "";
	if(!isset($_GET['view']) || $_GET['view'] == "view-tile")
		$viewClass = " tile-view";
	elseif($_GET['view'] == "view-short")
		$viewClass = " short-view";
	elseif($_GET['view'] == "view-detail")
		$viewClass = " detail-view";

		if($searchID == "")
			$resultTable = SQL::getTable("apps");
		else
			$resultTable = SQL::getTable("apps", "UID='$searchID'");

		$numEntries = SQL::getRowCount($resultTable);
		
		$cont = new CH\ToolBar(
		new CH\Btn("btn-upload", "Add a Package", "loadDialogue('upload')", "icon"),
		new CH\Group(
			new CH\OptionBtn("view-detail", "view", "icon-only"),
			new CH\OptionBtn("view-short", "view", "icon-only"),
			new CH\OptionBtn("view-tile", "view", "icon-only", true)
		),
		new CH\Group(
			new CH\Text("text-element", "", "search"),
			new CH\Btn("btn-search", "search",
						"self.location='$Settings[MyServer]/!q='+document.getElementById('intext-element').value+'/Softcenter'")
		));
		$out .= $cont->printOut();
		$dim = ($viewClass==" detail-view")?(50):(($viewClass==" short-view")?(37):(80));
		while ($entry = SQL::getRow($resultTable)){
			$addViewClass = "";
			if($entry['Downloads']>10)
			{
				$addSlideView = true;
				$slideView = new CH\AlbumView($entry["Slider"], "10000");
				$addViewClass .= " big-tile-view";
			} else
				$addSlideView = false;
			$packageReplacement = array("0" => "s", "1" => "p", "2" => "c", "3" => "a");
			$packageT = str_replace(array_keys($packageReplacement), $packageReplacement, $entry['PackageType']."");
			$out .=  "<div class=\"gradient previewEntry$viewClass $addViewClass\">";
			$out .=  "<div class=\"previewContainer\">";
			//$out .= "<div class=\"previewLogo\">"
			$out .= "<img class=\"previewLogo\" src=\"$Settings[MyServer]/media.php?type=img_crop_fixed_x&img=".getFile($entry['Logo'])."&dim=$dim\">";
			//$out .= "</div>"
			$out .=  "<div class=\"previewLeft\">";
				$out .=  "<div class=\"previewTitle\">".$entry['Title']."</div>";
				$out .=  "<div class=\"previewDescription\">".$entry['ShortDescription']."</div>";
			$out .=  "</div>";
			$out .=  "<div class=\"previewRight\">";
				$out .=  "<div onclick=\"Goto('".$entry['Download']."')\" class=\"btn group-left btn-important\">Download</div>";
				$out .=  "<div onclick=\"loadDialogue('down&uid=".$entry['UID']."&p=".$packageT."&v=".$entry['Version']."&u=".$entry['Maintainer']."')\" class=\"btn group-right\">More</div>";
			$out .=  "</div>";
			$out .=  "</div>";
			if($addSlideView&&$viewClass==" tile-view")
				$out .= $slideView->printOut();
			$out .=  "</div>";
		}
		$pc = (new CH\PageContent(new CH\HTMLNode($out)));
		$this->content = $pc->printOut();
}
	}
?>
