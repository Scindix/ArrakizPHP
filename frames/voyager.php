<?php
require_once('signin.php');
$userSession = getSession();
if(!$userSession)
{
	require_once("notLoggedIn.php");
	die;
}
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Frame.class.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
class Voyager extends Frame
{
	function __construct()
	{
		$userSession = getSession();
		parent::__construct();
		$this->frameClass = "voyager";
		global $POST;
		$n = isset($POST["num"])?($POST["num"]):("0");
		$this->frameName = "voyager-$n";
		$userID = getSession()["ID"];
		$root = strrev($POST["root"]);
		$root = ($root{0}=="/")?($POST["root"]):("$POST[root]/");
		$table = SQL::getTable("files", "Owner='user/$userID'", "Path Like '$root%'");
		$listItems = array();
    	global $POST;
    	$files = array();
    	while ($entry = SQL::getRow($table)){
    		$e = $entry;
    		$e["Path"] = substr($e["Path"], strlen($root));
    		if(strpos($e["Path"], "/")===false)
    		{
    			$files[] = $e;
			} else
			{
				$folder = substr($e["Path"], 0, strpos($e["Path"], '/'));//$e["Path"];//substr($e["Path"], strpos($e["Path"], '/'));
				$files[$folder] = $e;
				$files[$folder]["Path"] = $folder;
				$files[$folder]["Mime"] = "folder";
			}
		}
		$brCrs = explode("/", $root);
		$breadCrs = array();
		foreach ($brCrs as $i => $brCr){
			if($brCr=="")
				break;
			$brPath = "";
			for($j=0; $j<=$i; $j++)
				$brPath .= $brCrs[$j]."/";
			$mode = "";
			if($brPath==$root)
				$mode = "active";
			$breadCrs[$i] = new CH\BreadCrumb($brCr, "loadFrame('voyager-$n', 'root=$brPath')", $mode);
		}
		$group = new CH\Group();
		$group->addByArray($breadCrs);
		$breadCrumbs = new CH\BreadCrumbs();
		$breadCrumbs->add($group);
		
		foreach ($files as $file){
			$title = substr($file["Path"], strrpos($file["Path"], '/')+1);
			$title = substr($title, 0, strrpos($title, '.'));
			$owner["id"] = substr($file["Owner"], strrpos($file["Owner"], "/")+1);
			$path = $file["Path"];
			$mime = getMime($file["Mime"]);
			$mimelogo = getFile($mime["LogoFile"]);
			$item = new CH\ListItem($title, $path, "./media.php?type=img_map_x_y&img=$mimelogo&base=10&num=$mime[Logo]", array(), "folder", "loadFrame('voyager-$n', 'root=$root$file[Path]/')");
			array_push($listItems, $item);
		}
		$list = new CH\AdvancedList("detail-view");
		$list->addByArray($listItems);
		$div = new CH\TagContainer("div", $breadCrumbs, $list);
		$this->newContent($div);
	}
}
$f = (new Voyager());
		$f->init();
?>
