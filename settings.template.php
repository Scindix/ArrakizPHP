<?php
	//User-defined Settings
	//Database
	$Settings['DB_Name'] = "<:db_name:>";
	$Settings['DB_User'] = "<:db_user:>";
	$Settings['DB_Password'] = "<:db_password:>";
	$Settings['DB_Prefix'] = "<:db_prefix:>";
	//Owner
	$Settings['authorMail'] = "<:author_mail:>";
	$Settings['authorName'] = "<:author_name:>";
	$Settings['trustedUser'] = "<:trusted_user:>";
	$Settings['trustedPassword'] = '<:trusted_password:>';
	//Website
	$Settings['Name'] = "<:name:>";
	$Settings['description'] = "<:description:>";
	$Settings['keys'] = "<:keys:>";
	$Settings['useDNT'] = <:useDNT:>;
	$Settings['https'] = "<:https:>";//never|security|everywhere
	//Other
	$Settings['debug'] = <:debug:>;
	$Settings['synchronized'] = <:synchronized:>;
	
	//Generic Settings:
	//Server Paths
	$Settings['MyDir'] = str_replace("/settings.php", "",__FILE__);
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
	$Settings['page'] = isset($_GET['page'])?($_GET['page']):("Home");
	$Settings['dnt'] = $Settings['useDNT'] and isset($_SERVER['HTTP_DNT']) and $_SERVER['HTTP_DNT'] == 1;
	
	//Make global
	global $Settings;
?>
