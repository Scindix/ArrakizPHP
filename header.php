<?php
use \CodeHelper as CH;
require_once('signin.php');
require_once("./settings.php");
$currentSession = getSession();
echo "<ul id=\"header\">";
	echo "<li><a id=\"brand\" href=\"$Settings[MyServer]\" class=\"gradient\">$Settings[Name]</a></li>";
	
	echo "<li><a ".(($Settings['page']=="Home")?("id=\"activePage\""):(""))." href=\"$Settings[MyServer]/!/Home\">Home</a></li>";
	echo "<li><a ".(($Settings['page']=="Softcenter")?("id=\"activePage\""):(""))." href=\"$Settings[MyServer]/!/Softcenter\">Soft-Center</a></li>";
	echo "<li><a ".(($Settings['page']=="Wiki")?("id=\"activePage\""):(""))." href=\"$Settings[MyServer]/!/Wiki\">Wiki</a></li>";
	echo "<li><a ".(($Settings['page']=="Contact")?("id=\"activePage\""):(""))." href=\"$Settings[MyServer]/!/Contact\">Contact</a></li>";
	echo "<li><a ".(($Settings['page']=="Privacy")?("id=\"activePage\""):(""))." href=\"$Settings[MyServer]/!/Privacy\">Privacy</a></li>";
	if($currentSession["Status"]>0)
	{
		$a = getFile($currentSession["Avatar"]);
		$img = new CH\HTMLNode("<img id=\"profile-image\" src=\"$Settings[MyServer]/media.php?type=img_crop_fixed_x&img=$a&dim=40\">");
		$imgCode = $img->printOut();
		echo "<li><a id=\"signOutLink\" onclick=\"loadDialogue('signOut');\" href=\"#\">Sign out</a></li>";
		echo "<li id=\"userWelcome\">$imgCode Hi $currentSession[Name]</li>";
		echo "<li>
				<a class=\"dropdown\" href=\"#\">more
					<ul class=\"dropdownList\">
						<li id=\"dropdown-user-settings\" class=\"dropdown-icon\" onclick=\"loadDialogue('settings');\">Settings</li>
						<li id=\"dropdown-user-profile\" class=\"dropdown-icon\" onclick=\"alert('not yet implemented');\">Profile</li>
						<li id=\"dropdown-user-files\" class=\"dropdown-icon\" onclick=\"loadDialogue('cloud', 'root=data/profile');\">Files</li>
						<li id=\"dropdown-user-mypackage\" class=\"dropdown-icon\" onclick=\"alert('not yet implemented');\">My Packages</li>						
						<li id=\"dropdown-user-seperator\" class=\"dropdown-icon\"></li>
						<li id=\"dropdown-user-messages\" class=\"dropdown-icon\" onclick=\"alert('not yet implemented');\">Massages</li>
						<li id=\"dropdown-user-notifications\" class=\"dropdown-icon\" onclick=\"alert('not yet implemented');\">Notifications</li>
						<li id=\"dropdown-user-seperator\" class=\"dropdown-icon\"></li>
						<li id=\"dropdown-user-signout\" class=\"dropdown-icon\" onclick=\"loadDialogue('signOut');\">Sign out</li>
					</ul>
				</a>
			</li>";
	}
	else
		echo "<li><a id=\"signLink\" onclick=\"loadDialogue('signUp');\" href=\"#\">Sign in/up</a></li>";	
echo "</ul>";
?>
