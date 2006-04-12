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
require_once("$Settings[MyDir]/class/Dialog.class.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		$userSession = getSession();
		parent::__construct();
		$this->dialogTitle = "Yoyager";
		$this->dialogName = "cloud";
		global $POST;
		/*$userID = getSession()["ID"];
		$root = strrev($POST["root"]);
		$root = ($root{0}=="/")?($POST["root"]):("$POST[root]/");
		$table = SQL::getTable("files", "Owner='user/$userID'", "Path Like '$root%'");
		$listItems = array();
    	global $POST;
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
		foreach ($files as $file){
			$title = substr($file["Path"], strrpos($file["Path"], '/')+1);
			$title = substr($title, 0, strrpos($title, '.'));
			$owner["id"] = substr($file["Owner"], strrpos($file["Owner"], "/")+1);
			$path = $file["Path"];
			$mime = getMime($file["Mime"]);
			$mimelogo = getFile($mime["LogoFile"]);
			$item = new CH\ListItem($title, $path, "../media.php?type=img_map_x_y&img=$mimelogo&base=10&num=$mime[Logo]");
			array_push($listItems, $item);
		}
		$list = new CH\AdvancedList("detail-view");
		$list->addByArray($listItems);*/
		$this->content = new CH\TagContainer("div",
				new CH\UnborderedDialogContent(
					//$list
					new CH\Frame("voyager", "voyager-0", "root#$POST[root]")
				), new CH\Btn("", "Close","closeDialogue('cloud')", "dialog"));
		
		$this->scriptAfter = "loadFrame('voyager-0', 'root=$POST[root]')";
	}
}
$d = (new _Dialog());
		$d->init();
?>
