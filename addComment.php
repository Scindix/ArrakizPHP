<?php
require_once("settings.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
require_once('signin.php');
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/CodeHelper.class.php");
$currentSession = "";
$time = date('Y-m-d',time());

$currentSession = getSession();
if($currentSession["Status"]==0)
	die();
sleep(10);
$postBlock = ($_GET["postBlock"] == "-1")?(SQL::max("stream", "PostBlock", "StreamID=$_GET[streamID]")):($_GET["postBlock"]);
$result = SQL::insert("stream", array(	"UserID"=>"$currentSession[ID]",
													"Title"=>"'$_GET[title]'",
													"Content"=>"'$_GET[comment]'",
													"Rating"=>"$_GET[rating]",
													"Time"=>"'$time'",
													"StreamID"=>"$_GET[streamID]",
													"PostBlock"=>"$postBlock"));
//echo "success $currentSession[ID]";
		$table = SQL::getTable("review", "StreamID=$_GET[streamID]", "PostBlock=$_GET[postBlock]");
		$comment = array();
		$i=0;
		while ($entryc = SQL::getRow($table)){
			$userTable = SQL::getTable("user", "ID=$entryc[UserID]");
			$entryu = SQL::getRow($userTable);
			if($entryu)
			{
				$username = $entryu["Name"];
				$useravatar = $entryu["Avatar"];
			}
			else
			{
				$username = "user deleted";
				$useravatar = "img/standard/standard_profile.png";
			}
			$comment[$i++] = new CH\TagContainer("div id=\"comment\" class=\"comment-new\"",
			new CH\Listing(
				new CH\HTMLNode("<img id=\"comment-image\" src=\"../media.php?type=img_crop_fixed_x&img=$useravatar&dim=50\">"), new CH\TagContainer("div",
					new CH\HTMLNode("<div id=\"comment-header\">$entryc[Title]</div>"),
					new CH\HTMLNode("<div id=\"comment-time\">$entryc[Time]</div>"),
					new CH\HTMLNode("<br>"),
					new CH\HTMLNode("<div class=\"comment-rating\">
										<div class=\"rating-fore\" style=\"width: ".($entryc["Rating"]*7.5)."px;\"></div>
										<div class=\"rating-back\"></div>
									</div>"),
					new CH\HTMLNode("<div id=\"comment-author\">by $username</div>"),
					new CH\HTMLNode("<br>"),
					new CH\HTMLNode("<div id=\"comment-content\">$entryc[Content]</div>"))));
		}
		echo $comment[count($comment)-1]->printOut();
		SQL::close();
		die();
?>
