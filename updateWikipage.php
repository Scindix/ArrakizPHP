<?php
header('content-type: text/html; charset=ISO-8859-1');
require_once('signin.php');
$currentSession = "";
if(getSession())
{
	$currentSession = getSession();
}
require_once("settings.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
    global $POST;
    global $POST_DATA;
    SQL::insert("pages", array(	"Title"=>"'".SQL::escape("$POST[title]")."'",
    										"Name"=>"'".SQL::escape("$POST[wikipage]")."'",
    										"Content"=>"'".SQL::escape($POST_DATA)."'",
    										"Timestamp"=>"".time()));
    echo "success";
?>
