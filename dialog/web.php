<?php
//echo "<!doctype html><html><head>";
//head
	//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">";
//echo "</head><body>";
//body
header('content-type: text/html; charset=ISO-8859-1');
if($_GET['get']=="script")
{
	echo "loadDialogueById('packageDescription');";
} elseif($_GET['get']=="dialogue")
{
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\"><div id=\"packageDescription\" class=\"dialogue\">";
		echo "<div class=\"dialogueContent\">";
			echo divic("title", "content", $entry['Title']);
			echo divic("short", "content", $entry['ShortDescription']);
			echo "<div id=\"sideNote\">";
				echo ai("download", $entry['Download'], "Download Package<br>" . divi("filesize", "file-size: " . $entry['FileSize']));
			echo "</div>";
			echo divic("description", "content", $entry['Description']);
			echo "<div id=\"rightContainer\">";	
				echo divic("author", "content", "author: " . $entry['Author']);
				echo divic("license", "content", "license: " . $entry['License']);
				echo divic("changes", "content", "changes: " . $entry['Change']);
				echo divic("homepage", "content", "homepage: " . $entry['Homepage']);
				echo divic("release", "content", "release date: " . $entry['ReleaseDate']);
			echo "</div>";
		echo "</div>";
		echo "<div class=\"btn btn-dialogue\" onclick=\"closeDialogue('packageDescription')\">Close</div>";
	echo "</div>";
}

//echo "</body></html>";





function divc($var, $content)
{
	return "<div class=\"$var\">$content</div>";
}
function divi($var, $content)
{
	return "<div id=\"$var\">$content</div>";
}
function ai($var, $link, $content)
{
	return "<a href=\"$link\" id=\"$var\">$content</a>";
}
function divic($vari, $varc, $content)
{
	return "<div id=\"$vari\" class=\"$varc\">$content</div>";
}
?>
