<?php
require_once("$Settings[MyDir]/class/SQL.class.php");
function getFile($i)
{
	$table = SQL::getTable("files", "ID=$i");
	if(SQL::getRowCount($table)>0)
		$result = SQL::getRow($table);
	else
		return "file (ID=$i) not found";
	return $result['Path'];
}
function getMime($i)
{
	$table = SQL::getTable("mime", "MimeID='$i'");
	if(SQL::getRowCount($table)>0)
		$result = SQL::getRow($table);
	else
	{
		$result = array("MimeID"  => "application/unknown",
						"Logo"     =>  0,
						"WebApp"   => -1,
						"LogoFile" =>  17);
	
	}
	return $result;
}
?>
