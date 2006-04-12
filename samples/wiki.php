<?php
error_reporting(-1);
require_once("../settings.php");
require_once("$Settings[MyDir]/class/CodeHelper.class.php");
use \CodeHelper as CH;

?>

<!doctype html>
<html>
<head>
	<style type="text/css">
 		<?php
	 		if(!isset($_GET["nocss"]))
	 		{
		 		require_once('../css/reset_css.php');
		 		require_once('../css/style_css.php');
		 		require_once('../css/user_css.php');
		 		echo "body{text-align:left;}";
		 	}
 		?>
	</style>
</head>
<body>
<?php
echo file_get_contents("./wikitext.txt");
$a=new CH\WikiNode2(file_get_contents("./wikitext.txt")); echo $a->printOut();?>
</body>
</html>
