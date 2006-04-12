<?php
if(!@include_once("./settings.php"))
	require_once("./settings.fallback.php");
require_once("$Settings[MyDir]/class/Error.class.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
require_once("$Settings[MyDir]/class/HTML.class.php");
require_once("$Settings[MyDir]/class/util.class.php");
require_once("$Settings[MyDir]/dialog/install.php");
require_once("$Settings[MyDir]/signin.php");
require_once("$Settings[MyDir]/dependencies.php");
use \CodeHelper as CH;
$Settings['page']="Installation";

if(file_exists("$Settings[MyDir]/.install-lock"))
{
	$date = file_get_contents("$Settings[MyDir]/.install-lock");
	Error::assert("The installation already took place at ".date("j<\s\up>S</\s\up> F Y, G:i:s",$date).". If you want to install again, first remove the file '.install-lock'. (This is a security feature.)", Error::getLastError());
}

if(!isset($_POST["action"]) || $_POST["action"] != "performInstallation")
{
	$d = (new _Dialog());
	HTML::header("installation", "Installation program", false);
	echo $d->getContent();
	echo "<script>".$d->getScript()."</script>";
	HTML::footer();
} else
{
	$file = file_get_contents("$Settings[MyDir]/settings.template.php");
	$trans = array();
	foreach($_POST as $key => $value)
	{
		$trans["<:$key:>"] = $value;
	}
	$out = strtr($file, $trans);
	file_put_contents("$Settings[MyDir]/settings.backup.php", file_get_contents("$Settings[MyDir]/settings.php"));
	file_put_contents("$Settings[MyDir]/settings.php", $out);
	file_put_contents("$Settings[MyDir]/.install-lock", time());
	require_once("./settings.php");
	foreach($DataDependencies as $table => $scheme)
		SQL::createTable($table, $scheme);
	signup($_POST["initial_user"], $_POST["initial_mail"], $_POST["initial_password"]);
	foreach($InitialDataDependencies as $table => $entries)
	{
		foreach($entries as $entry)
		{
			if($entry["need"] == "required" || ($_POST["createInitial"] == "true" && $entry["need"] == "optional"))
				SQL::insert($table, $entry["data"]);
		}
	}
	header("location: ".Util::genURI(array("prompt" => "installed"), array("page" => $_POST['redirect'])));
}
?>
