<?php
global $getLastCommentOnly;
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/SQL.class.php");
require_once("$Settings[MyDir]/class/file.class.php");
require_once('signin.php');
$currentSession = "";
$currentUserName = "";
$currentSessionTimeout = "";
global $POST;
$GET=$POST;
if(isset($getLastCommentOnly)&&$getLastCommentOnly==true)
{
	$GET["p"] = $importP;
	$GET["uid"] = $importUID;
	$GET["v"] = $importV;
	$GET["u"] = $importU;
}
if(getSession())
{
	$currentSession = getSession();
	$currentUserName = $currentSession['Name'];
	$currentSessionTimeout = $currentSession['SessionTimeOut'];
}

$replacement = array(	"s" => "0", "p" => "1", "c" => "2", "a" => "3",
						"scindix" => "0", "patch" => "1", "core" => "2", "apps" => "3");
$packageNum = str_replace(array_keys($replacement), $replacement, $GET["p"]);
$package = $GET["p"];

$uid = $GET["uid"];

$version = $GET["v"];
if($version == "l")
	$version = "latest";

$user = $GET["u"];

$replacement = array("title" => "T", "description" => "D", "short" => "S", "author" => "A", "license" => "L", "change" => "C", "homepage" => "H", "filesize" => "Z", "releasedate" => "E", "info" => "I", "recent" => "R", "file" => "F", "media" => "M", "search" => "Q");

$type = isset($GET["t"])?($GET["t"]):("");
$type = str_replace(array_keys($replacement), $replacement, $type);

$table = SQL::getTable("apps", "PackageType=$packageNum", "UID='$uid'", "Version='$version'", "Maintainer='$user'");

$imgTable = SQL::getTable("img", "Purpose='package'", "Destiny='$packageNum/$user/$uid/$version'");
$previewImgS = "";
$noImages = true;
while ($entry = SQL::getRow($imgTable)){
	$noImages = false;
	$previewImgS .= "<img src=\"$Settings[MyServer]/media.php?type=img_crop_dynamic_x&img=$entry[Path]&dim=90\">";
}
if($noImages)
	$previewImgS = "<div class=\"notice\">No media available!</div>";

$webonly = true;

	$entry = SQL::getRow($table);
	
	SQL::close();
	if(!$webonly)
	{
		if(!(strpos($type,'T')===false) || !(strpos($type,'I')===false))
			echo "title:" . $entry['Title'] . "<br>";
		if(!(strpos($type,'D')===false) || !(strpos($type,'I')===false))
			echo "description:" . $entry['Description'] . "<br>";
		if(!(strpos($type,'S')===false) || !(strpos($type,'I')===false))
			echo "short description:" . $entry['ShortDescription'] . "<br>";
		if(!(strpos($type,'A')===false) || !(strpos($type,'I')===false))
			echo "author:" . $entry['Author'] . "<br>";
		if(!(strpos($type,'L')===false) || !(strpos($type,'I')===false))
			echo "license:" . $entry['License'] . "<br>";
		if(!(strpos($type,'C')===false) || !(strpos($type,'I')===false))
			echo "changes:" . $entry['Change'] . "<br>";
		if(!(strpos($type,'F')===false) || !(strpos($type,'I')===false))
			echo "download:" . $entry['Download'] . "<br>";
		if(!(strpos($type,'H')===false) || !(strpos($type,'I')===false))
			echo "homepage:" . $entry['Homepage'] . "<br>";
		if(!(strpos($type,'Z')===false) || !(strpos($type,'I')===false))
			echo "file-size:" . $entry['FileSize'] . "<br>";
		if(!(strpos($type,'E')===false) || !(strpos($type,'I')===false))
			echo "release date:" . $entry['ReleaseDate'] . "<br>";
	}
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
	if(!(strpos($type,'W')===false)||$webonly)
	{
		
		require_once("$Settings[MyDir]/class/Dialog.class.php");
		$table = SQL::getTable("review", "Destiny='$packageNum/$user/$uid/$version'");
		$comment = array();
		$i=0;
		while ($entryc = SQL::getRow($table)){
			$userTable = SQL::getTable("user", "ID=$entryc[UserID]");
			$entryu = SQL::getRow($userTable);
			if($entryu)
			{
				$username = $entryu["Name"];
				$useravatar = getFile($entryu["Avatar"]);
			}
			else
			{
				$username = "user deleted";
				$useravatar = getFile(1);;
			}
			$comment[$i++] = new CH\TagContainer("div id=\"comment\"",
			new CH\Listing(
				new CH\HTMLNode("<img id=\"comment-image\" src=\"$Settings[MyServer]/media.php?type=img_crop_fixed_x&img=$useravatar&dim=50\">"), new CH\TagContainer("div",
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
		if(isset($getLastCommentOnly)&&$getLastCommentOnly==true)
		{
			echo $comment[count($comment)-1]->printOut();
			die();
		}
		if($currentSession["Status"]>0)
		{
			$entryu = $currentSession;
			$username = $entryu["Name"];
			$useravatar = getFile($entryu["Avatar"]);
			$comment[$i++] = new CH\TagContainer("div id=\"comment\"",
			new CH\Listing(
				new CH\HTMLNode("<img id=\"comment-image\" src=\"$Settings[MyServer]/media.php?type=img_crop_fixed_x&img=$useravatar&dim=50\">"), new CH\TagContainer("div",
					new CH\Text("new-comment-title", "", "title", "edit"),
					new CH\Btn("btnAddReview", "post", "addComment(document.getElementById('innew-comment-title').value, document.getElementById('innew-comment-content').value, parseInt(parseInt(document.getElementById('btnAddReview').parentNode.getElementsByClassName('rating-fore-new')[0].style.width,10)/7.5,10),'$packageNum/$user/$uid/$version', loopUpTo(document.getElementById('btnAddReview'),'comment'))", "icon-anim stop-animation", "0", "7", "500", "23"),
					new CH\HTMLNode("<br>"),
					new CH\HTMLNode("<div class=\"comment-rating comment-rating-new\">
										<div class=\"rating-fore-new\" style=\"0px;\"  data-rating=\"0px;\"></div>
										<div class=\"rating-back\"></div>
									</div>"),
					new CH\HTMLNode("<br>"),
					new CH\TextArea("new-comment-content"))));
		} else
		{
			$comment[$i++] = new CH\TagContainer("div id=\"comment\"", new CH\Anchor("#", "Sign In", "loadDialogue('signUp');"),new CH\HTMLNode(" to post reviews!"));
		}
		$comments = new CH\TagContainer("div id=\"comments\"", new CH\HTMLNode("<div id=\"comment\">All reviews</div>"));
		$comments->addByArray($comment);
		$rating = intval(SQL::avg('review', 'Rating', "Destiny='$packageNum/$user/$uid/$version'"))*25;
		SQL::close();
		class _Dialog extends Dialog
		{
			function __construct($entry, $previewImgS, $comments, $rating)
			{
				global $Settings;
				parent::__construct();
				$this->dialogTitle = "Package Information";
				$this->dialogName = "packageDescription-$entry[PackageType]-$entry[UID]-$entry[Version]-$entry[Maintainer]";
				$this->content = new CH\TagContainer("div",
						new CH\DialogContent(
							new CH\Img("$Settings[MyServer]/media.php?type=img_crop_fixed_x&img=".getFile($entry['Logo'])."&dim=50", "packageLogo"),
							new CH\TagContainer("div id=\"title\" class=\"content\"", new CH\HTMLNode($entry['Title'])),
							new CH\TagContainer("div id=\"short\" class=\"content\"", new CH\HTMLNode($entry['ShortDescription'])),
							new CH\TagContainer("div id=\"sideNote\"",
								new CH\TagContainer("a href=\"".getFile($entry['Download'])."\" id=\"download\"", new CH\HTMLNode("Download Package<br>" . divi("filesize", "file-size: " . $entry['Filesize'])))),
							new CH\TagContainer("div id=\"description\" class=\"content\"", new CH\HTMLNode($entry['Description']), $comments),
								new CH\TagContainer("div id=\"rightContainer\"", new CH\HTMLNode("
									<div id=\"image-container\">
										<div id=\"image-inner-shadow\"></div>
										<div id=\"image-container-inner\">
											$previewImgS
										</div>
									</div>
								<div class=\"rating\">
									<div class=\"rating-fore\" style=\"width: ".$rating."px;\"></div>
									<div class=\"rating-back\"></div>
								</div>"), new CH\HeadedListing("","bold",
									new CH\TextNode("author"),		new CH\TextNode($entry['Author']),
									new CH\TextNode("license"),		new CH\TextNode($entry['License']),
									new CH\TextNode("changes"),		new CH\TextNode($entry['Change']),
									new CH\TextNode("homepage"),	new CH\Anchor($entry['Homepage']),
									new CH\TextNode("release"),		new CH\TextNode($entry['ReleaseDate'])))),
						new CH\Btn("", "Close","closeDialogue('$this->dialogName')", "dialog"));
			}
		}
		$d = (new _Dialog($entry, $previewImgS, $comments, $rating));
		$d->init();

	}
?>
