<?php
error_reporting(E_ALL);
	require_once("$Settings[MyDir]/class/CodeHelper.class.php");
	require_once("$Settings[MyDir]/class/util.class.php");
	require_once("$Settings[MyDir]/class/file.class.php");
	
	abstract class Module
	{
		public static $modules = array();
		protected $title = "";
		protected $titleTooltip = "";
		protected $content = "";
		public static function get($count)
		{
			return Module::$modules[$count];
		}
		public static function init()
		{
			Module::$modules = Util::includeAllCls("modules");
		}
		public function getTitle()
		{
			return $this->title;
		}
		public function getTitleToolTip()
		{
			return $this->titleTooltip;
		}
		public function getContent()
		{
			return $this->content;
		}
	}
	Module::init();
?>
