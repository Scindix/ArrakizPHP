<?php
	require_once("$Settings[MyDir]/class/CodeHelper.class.php");
	require_once("$Settings[MyDir]/class/util.class.php");
	
abstract class HTML
{
	public static function header($keys, $description, $social)
	{
		global $Settings;
?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;" charset="UTF-8"><!--ISO-8859-1-->
		<link href="http://fonts.googleapis.com/css?family=Ubuntu:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
		<link type="image/x-icon" href=" <?= $Settings['MyServer'] ?>/favicon.png" rel="icon">
		<title><?= $Settings['Name'] ?> - <?= $Settings['page'] ?></title>
		<meta content="<?=strtolower($Settings['Name']) ?>,<?=strtolower($Settings['page']) ?>,<?=strtolower($keys)?>,<?=strtolower($Settings['keys'])?>" name="keywords">
		<meta name="author" content="<?=$Settings['authorName']?>">
		<meta name="description" content="<?=$description.$Settings['description']?>">
		<style type="text/css">
<?php
 			require_once("$Settings[MyDir]/css/css.php");
?>
		</style>
		<!--[if gte IE 9]>
			<style type="text/css">
				.gradient {
				   filter: none;
				}
				.ie-hidden {
					display: block;
				}
			</style>
		<![endif]-->
		<script type="text/javascript">
		//<![CDATA[
			function Settings(){}
			Settings.MyServer = '<?= $Settings["MyServer"] ?>';
			Settings.Page = '<?= isset($_GET["page"])?$_GET["page"]:"" ?>';
<?php
			require_once('js/user.js');
			require_once('js/ui.js');
			require_once('js/ajax.js');
?>
			window.setTimeout(init, 10);
			function init()
			{
				initUser();
<?php if(isset($_GET['prompt']) && $_GET['prompt']!=""){ ?>
				loadDialogue('$_GET[prompt]');
<?php } ?>
			}
		//]]>
		</script>
		
		
<?php if($social){ ?>
		<link href="https://plus.google.com/116158881678073648601" rel="publisher" />
		<script type="text/javascript">
		/* <![CDATA[ */
			(function() {
				var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
				s.type = 'text/javascript';
				s.async = true;
				s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
				t.parentNode.insertBefore(s, t);
			})();
		/* ]]> */
		</script>
<?php } ?>
	</head>
	<body onload=""><?php
	}
	public static function footer()
	{
		global $Settings;
?>
	</body>
</html><?php
	}
}
?>
