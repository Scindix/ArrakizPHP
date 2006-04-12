<?php

require_once("$Settings[MyDir]/dialog/error.php");
require_once("$Settings[MyDir]/class/HTML.class.php");
use \CodeHelper as CH;


abstract class Error
{
	public static function assert($error, $debug)
	{
		$errorDialog = new Error_Dialog();		
		$authorized = true; //@todo implement authorization
		global $Settings;
		echo '<style type="text/css">';
		 	require_once("$Settings[MyDir]/css/css.php");
		echo "</style>";
		$debugOut = '';
		if($authorized)
			$debugOut = '<div class="global-notice-footer">'."$error</div>";
		if($authorized && $Settings['debug'])
			$debugOut .= '<div class="global-notice-footer"><b>The following is debug info:</b><br>'."$debug</div>";
		$errorDialog->setContent(new CH\HTMLNode("An internal software error happened. Please contact the administrator via $Settings[authorMail]$debugOut"));
		echo $errorDialog->getContent();
		echo "<script>".$errorDialog->getScript()."</script>";
		
		HTML::footer();
		die();
	}
	public static function getLastError()
	{
		if(error_get_last() != NULL)
			return "<b>PHP error ".error_get_last()["type"].":</b> ".error_get_last()["message"]."<br> in file <b>".error_get_last()["file"].":".error_get_last()["line"]."</b>";
		else
			return "No PHP error!";
	}
}
?>
