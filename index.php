<?php
if(!isset($_GET['page']) || ($_GET['page']==""))
{
	//header("Location: Overview/");
	//die();
	$_GET['page'] = "Overview";
}
if(!@include_once("./settings.php"))
	require_once("./settings.fallback.php");
require_once("$Settings[MyDir]/init.php");
require_once("$Settings[MyDir]/class/SQL.class.php");
require_once("$Settings[MyDir]/class/module.class.php");
require_once("$Settings[MyDir]/class/HTML.class.php");
HTML::header("", "", true);


if($_SERVER['REMOTE_ADDR']!="127.0.0.1" && !isset($_COOKIE['magic480e7f6686e441e75e00bb2de2fe04f1']))
{
	require_once("$Settings[MyDir]/tracking.php");
} ?>
		<div id="social">
			<div class="btn-social" id="btn-gplus">
				<a class="social-link" href="https://plus.google.com/116158881678073648601" rel="publisher">Scindix on Google+</a><br>
				<!-- Place this tag where you want the badgev2 to render. -->
				<div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/116158881678073648601" data-rel="publisher"></div>
				<!-- Place this tag after the last badgev2 tag. -->
				<script type="text/javascript">
				//<![CDATA[
					(function() {
						var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					})();
				//]]>
				</script>
			</div>
			
			<div id="btn-facebook" class="btn-social">
				<a class="social-link" href="https://www.facebook.com/Scindix">Scindix on Facebook</a><br>
				<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FScindix&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;font=arial&amp;colorscheme=dark&amp;action=recommend&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
			</div>
			
			<div class="btn-social" id="btn-twitter">
				<a href="https://www.twitter.com/Scindix" class="social-link">Scindix on Twitter</a><br>
				<a href="https://twitter.com/Scindix" class="twitter-follow-button" data-show-count="false">Follow @Scindix</a>
				<script type="text/javascript">
				//<![CDATA[
					!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
				//]]>
				</script>
			</div>
			
			<div class="btn-social" id="btn-flattr">
				<a href="https://flattr.com/thing/1888118/Scindix" class="social-link">Scindix on Flattr</a><br>
				<a class="FlattrButton" style="display:none;" rev="flattr;button:compact;" href="http://scindix.bplaced.de"></a>
			</div>
		</div>

<?php if(isset($_COOKIE['magic480e7f6686e441e75e00bb2de2fe04f1'])){ ?>
<?php } ?>
<?php
		require_once('header.php');
		$page = $Settings['page'];
?>

<?php if(!isset($_COOKIE['terms-accepted'])){ ?>
		<div id="notification-layer" class="auto-dismiss-5">
			<div id="notification" class="error privacy auto-dismiss-10">
				This site uses cookies and Piwik. By using this website you agree to our terms.
			</div>
		</div>
		<script type="text/javascript">
		//<![CDATA[
			setCookie('terms-accepted', 'yes', 500);
		//]]>				
		</script>
<?php } ?>

<?php
		if(isset(Module::$modules[$page]))
			echo Module::$modules[$page]->getContent();
		else 
			echo Module::$modules["WikiPage"]->getContent();
	HTML::footer();
?>
