<?php

require_once('settings.php');
function searchCode()
{
	global $Settings;
	$out = "";
	$db_username=$Settings['DB_User'];
	$db_password=$Settings['DB_Password'];
	$db_database=$Settings['DB_Name'];
	$searchID=isset($_GET['q'])?($_GET['q']):("");

	$btnViewShort = "";
	$btnViewTile = "";
	$btnViewDetail = "";

	$viewClass = "";
	if(!isset($_GET['view']))
	{
		$btnViewDetail = " btn-option-active";		
	}
	elseif($_GET['view'] == "short")
	{
		$btnViewShort = " btn-option-active";
		$viewClass = " short-view";
	}
	elseif($_GET['view'] == "tile")
	{
		$btnViewTile = " btn-option-active";
		$viewClass = " tile-view";
	}
	else
		$btnViewDetail = " btn-option-active";

	mysql_connect('localhost',$db_username,$db_password);

	@mysql_select_db($db_database) or die("Unable to select database");
		if($searchID == "")
			$query="SELECT * FROM main";
		else
			$query="SELECT * FROM main WHERE UID='$searchID'";

		$result=mysql_query($query);
		//$num=mysql_numrows($result);
		//$title = mysql_result($result, $num-1, "Title");
		$numEntries = mysql_num_rows($result);
		$out .=  "<div id=\"searchHeader\"><!--<div id=\"numEntries\">Number of found packages for '$searchID': ".$numEntries."</div>-->";
		$out .=  "<div class=\"btn btn-icon\" id=\"btn-upload\" onclick=\"loadDialogue('upload.php')\">Add a Package</div>";
	
		$out .=  "<div class=\"btn btn-left btn-icon-only btn-option$btnViewDetail\" id=\"btn-view-detail\" onclick=\"self.location='Softcenter&subpage=search&q=$searchID&view=detail'\"></div>";
		$out .=  "<div class=\"btn btn-middle btn-icon-only btn-option$btnViewShort\" id=\"btn-view-short\" onclick=\"self.location='Softcenter&subpage=search&q=$searchID&view=short'\"></div>";
		$out .=  "<div class=\"btn btn-right btn-icon-only btn-option$btnViewTile\" id=\"btn-view-tile\" onclick=\"self.location='Softcenter&subpage=search&q=$searchID&view=tile'\"></div>";
	
		$out .=  "<form action=\"Softcenter\" method=\"get\" id=\"searchForm\" onsubmit=\"return formGoto('Softcenter&subpage=search&q='+document.getElementById('searchElement').value)\" >";
			$out .=  "<input class=\"textLeft\" type=\"text\" name=\"searchFile\" id=\"searchElement\">";
			$out .=  "<input  id=\"btn-search\" class=\"btn btn-right\" onclick=\"self.location='softcenter&subpage=search&q='+document.getElementById('searchElement').value\" type=\"submit\" name=\"submitSearch\" value=\"search\">";
		$out .=  "</form></div>";
		while ($entry = mysql_fetch_array($result)){
			$packageT = "";
			switch ($entry['PackageType']) {
				case 0:
					$packageT = "s";
					break;
				case 1:
					$packageT = "p";
					break;
				case 2:
					$packageT = "c";
					break;
				case 3:
					$packageT = "a";
					break;
			}
			$out .=  "<div class=\"previewEntry$viewClass\">";
			$out .=  "<div class=\"previewLeft\">";
				$out .=  "<div class=\"previewTitle\">".$entry['Title']."</div>";
				$out .=  "<div class=\"previewDescription\">".$entry['ShortDescription']."</div>";
			$out .=  "</div>";
			$out .=  "<div class=\"previewRight\">";
				$out .=  "<div onclick=\"goto('".$entry['Download']."')\" class=\"btn btn-left btn-important\">Download</div>";
				$out .=  "<div onclick=\"loadDialogue('down.php&uid=".$entry['UID']."&p=".$packageT."&v=".$entry['Version']."&u=".$entry['User']."')\" class=\"btn btn-right\">More</div>";
			$out .=  "</div>";
			$out .=  "</div>";
		}
		return $out;
}
?>
