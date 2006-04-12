<?php
require_once("./settings.php");
require_once("./dependencies.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
	function checkServer()
	{
		checkExtensions();
		checkDatabase();	
	}
	
	function checkExtensions()
	{
		global $ExtDependencies;
		foreach($ExtDependencies as $ext => $extDetail)
		{
			if(!extension_loaded($ext) && (!function_exists('dl') || !dl($extDetail["lib"])))
				Error::assert("The extension '$extDetail[title]' is not be loaded. Install it and either load it or allow PHP scripts to load it.", Error::getLastError());
		}
	}
	
	function checkDatabase()
	{
		global $Settings;
		global $DataDependencies;		
		foreach($DataDependencies as $table => $tableDetail)
		{
			if(SQL::tableExists($table))
			{
				$checkScheme = SQL::tableCheckScheme($table, $tableDetail);
				if(gettype($checkScheme)=="array")
					Error::assert("The property '$checkScheme[1]' of column '$checkScheme[0]' in table '$table' is wrong. You might fix this by running the <a href=\"$Settings[MyServer]/install.php\">installation</a> again.", Error::getLastError());
				if(gettype($checkScheme)=="string")
					Error::assert("The column '$checkScheme' in table '$table' is missing. You might fix this by running the <a href=\"$Settings[MyServer]/install.php\">installation</a> again.", Error::getLastError());
			} else
			{
				Error::assert("The table '$table' is missing. You might fix this by running the <a href=\"$Settings[MyServer]/install.php\">installation</a> again.", Error::getLastError());
			}
		}
		
	}
	checkServer();
?>

