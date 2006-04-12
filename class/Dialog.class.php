<?php
error_reporting(E_ALL);
	require_once("$Settings[MyDir]/class/CodeHelper.class.php");
	require_once("$Settings[MyDir]/class/util.class.php");
	
	abstract class Dialog
	{
		protected $dialogName;
		protected $dialogTitle;
		protected $dialogBeginTag;
		protected $dialogEndTag;
		protected $script;
		protected $scriptBefore;
		protected $scriptAfter;
		protected $content;
		protected $globalNotice;
		protected $icon;
		function __construct()
		{
			$this->dialogBeginTag = "div";
			$this->dialogName = "";
			$this->scriptBefore = "";
			$this->script = "";
			$this->scriptAfter = "";
			$this->dialogTitle = "Dialog";
			$this->globalNotice = "";
			$this->icon = "";
		}
		public function init()
		{
			global $POST;
			$this->dialogBeginTag .= " id=\"$this->dialogName\"";
			if(!strpos($this->dialogBeginTag, " class=")===false && $globalNotice == "")
				$this->dialogBeginTag = str_replace("class=\"", "class=\"dialogue ", $this->dialogBeginTag);
			elseif($this->globalNotice == "")
				$this->dialogBeginTag .= " class=\"dialogue\"";
			elseif(!strpos($this->dialogBeginTag, " class=")===false)
				$this->dialogBeginTag = str_replace("class=\"", "class=\"global-notice-back $this->globalNotice\" ", $this->dialogBeginTag);
			else
				$this->dialogBeginTag .= " class=\"global-notice-back $this->globalNotice\"";
				
			
			$this->script = "loadDialogueById('$this->dialogName');";
			if(isset($POST['get']) && $POST['get']=="script")
			{
				echo $this->getScript();
			} elseif(isset($POST['get']) && $POST['get']=="dialog")
			{
				echo $this->getContent();
			}
		}
		public function getScript()
		{
			return $this->scriptBefore.$this->script.$this->scriptAfter;
		}
		public function getContent()
		{
			if($this->globalNotice != "")
			{
				$out = new CodeHelper\TagContainer($this->dialogBeginTag, 
					new CodeHelper\TagContainer("div class=\"global-notice\"", 
						new CodeHelper\TagContainer("div class=\"global-notice-caption\"", 
							new CodeHelper\Img($this->icon, "global-notice-icon"), 
							new CodeHelper\TagContainer("p style=\"vertical-align: middle; display: inline;\"", 
								new CodeHelper\TextNode($this->dialogTitle)
							)
						),
					$this->content)
				);
			} else
			{
				$titleBar = new CodeHelper\TagContainer("div class=\"titleBar\"", new CodeHelper\TextNode($this->dialogTitle));
				$out = new CodeHelper\TagContainer($this->dialogBeginTag, $titleBar, $this->content);
			}
			return $out->printOut();
		}
		public function setContent($con)
		{
			$this->content = $con;
			$this->init();
		}
	}
?>
