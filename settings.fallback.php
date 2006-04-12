<?php
	//User-defined Settings
	//Database
	$Settings['DB_Name'] = "arrakiz";
	$Settings['DB_User'] = "arrakiz";
	$Settings['DB_Password'] = "arrakiz";
	$Settings['DB_Prefix'] = "arrakiz_";
	//Owner
	$Settings['authorMail'] = "info@arrakiz.org";
	$Settings['authorName'] = "Cedric Wehrum";
	$Settings['trustedUser'] = "cedric";
	$Settings['trustedPassword'] = 'test';
	//Website
	$Settings['Name'] = "Arrakiz";
	$Settings['description'] = "Arrakiz is a framework for Games";
	$Settings['keys'] = "arrakiz, framework, game, games, engine";
	$Settings['useDNT'] = true;
	$Settings['https'] = "never";//never|security|everywhere
	//Other
	$Settings['debug'] = true;
	$Settings['synchronized'] = array();

	//Generic Settings:
	//Server Paths
	$Settings['MyDir'] = str_replace("/settings.fallback.php", "",__FILE__);
	$Settings['MyServer'] = (($Settings['https']=="all")?"https":"http").
								"://$_SERVER[SERVER_NAME]".str_replace(getenv("DOCUMENT_ROOT"), "",$Settings['MyDir']);
	$Settings['MyServerSec'] = (($Settings['https']=="security" or $Settings['https']=="all")?"https":"http").
								"://$_SERVER[SERVER_NAME]".str_replace(getenv("DOCUMENT_ROOT"), "",$Settings['MyDir']);
	$Settings['MyHost'] = $_SERVER["SERVER_NAME"];
	if(strpos($Settings['MyHost'], "www.") === 0)
		$Settings['MyHost'] = substr($Settings['MyHost'], 4);
	$Settings['MyMailHost'] = substr($Settings['authorMail'], strpos($Settings['authorMail'], "@")+1);
	$Settings['DataDir'] = $Settings['MyDir']."/data";
	//OtherD
	$Settings['page'] = isset($_GET['page'])?($_GET['page']):("Overview");
	$Settings['dnt'] = $Settings['useDNT'] and isset($_SERVER['HTTP_DNT']) and $_SERVER['HTTP_DNT'] == 1;

	//Make global
	global $Settings;
?>
