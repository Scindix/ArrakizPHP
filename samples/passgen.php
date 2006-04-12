<?php
	echo "Syntax: <b>passgen.php?p=yourPassword</b>";
	echo "<br>";
	$a = "error! no password provided.";
	if(isset($_GET["p"]) && $_GET["p"] != "")
		$a = "'".$_GET["p"]."'";
	echo "The String below is a random Salt and the Hash of: $a";
	echo "<br>";
	echo "<br>";
	if(isset($_GET["p"]) && $_GET["p"] != "")
	{
		echo crypt($_GET["p"]);
		echo "<br><br>Now mail this String to &lt;info AT arrakiz dot org&gt; from your login email address with the subject 'PasswordReset'";
	}
?>
