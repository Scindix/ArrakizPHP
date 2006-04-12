<?php
error_reporting(E_ALL);
	require_once("$Settings[MyDir]/class/CodeHelper.class.php");
	require_once("$Settings[MyDir]/class/util.class.php");
	
	class ImageView extends Dialog
	{
		$images = array();
		function __construct()
		{
			parent::__construct();
			
		}
		public function init()
		{
			$this->dialogBeginTag .= " id=\"$this->dialogName\" class=\"image-view\"";
			if(! strpos($this->dialogBeginTag, " class=")===false)
				$this->dialogBeginTag = str_replace("class=\"", "class=\"dialogue ", $this->dialogBeginTag);
			else
				$this->dialogBeginTag .= "class=\"dialogue\"";
			
			$this->script = "loadDialogueById('$this->dialogName');";
			if($_GET['get']=="script")
			{
				echo $this->getScript();
			} elseif($_GET['get']=="dialog")
			{
				echo $this->getContent();
			}
		}
		public function getContent()
		{
			$titleBar = new CodeHelper\TagContainer("div class=\"titleBar\"", new CodeHelper\TextNode($this->dialogTitle));
			$out = new CodeHelper\TagContainer($this->dialogBeginTag, $titleBar, $this->content);
			return $out->printOut();
		}
	}
?>
