<?php
error_reporting(E_ALL);
	require_once("$Settings[MyDir]/class/CodeHelper.class.php");
	require_once("$Settings[MyDir]/class/util.class.php");
	
	abstract class Frame
	{
		protected $frameName;
		protected $frameClass;
		protected $script;
		protected $scriptBefore;
		protected $scriptAfter;
		protected $content;
		protected $frameBeginTag;
		function __construct()
		{
			$this->frameName = "frame";
			$this->scriptBefore = "";
			$this->script = "";
			$this->scriptAfter = "";
			$this->frameClass = "frame";
		}
		public function init()
		{
			global $POST;
			$fc = $this->frameClass;
			$this->frameBeginTag = "div class=\"frame\" frameClass=\"$fc\" id=\"$this->frameName\"";
			
			$this->script = "";
			if($POST['get']=="script")
			{
				echo $this->getScript();
			} elseif($POST['get']=="frame")
			{
				echo $this->getContent();
			}
		}
		public function getScript()
		{
			return $this->scriptBefore.$this->script.$this->scriptAfter;
		}
		public function newContent()
		{
			//$this->content = new CodeHelper\TagContainer($this->frameBeginTag);
			//$this->content->addByArray(func_get_args());
			$this->content = "";
			$args = func_get_args();
			foreach($args as $arg)
			{
				if(is_array($arg))
				{
					foreach($arg as $a)
					{
						$this->addContent($a);
					}
				} else
				{
					$this->addContent($arg);
				}
			}
		}
		public function addContent($c)
		{
			$this->content .= $c->printOut();
		}
		public function getContent()
		{
			return $this->content;
		}
	}
?>
