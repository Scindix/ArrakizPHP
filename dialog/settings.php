<?php
require_once('signin.php');
$userSession = getSession();
if(!$userSession)
{
	require_once("notLoggedIn.php");
	die;
}
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		$userSession = getSession();
		parent::__construct();
		$this->dialogName = "formSettings";
		$this->dialogBeginTag = "form action=\"../nirwana\" method=\"get\" enctype=\"multipart/form-data\"";
		$this->content = new CH\TagContainer("div",
				new CH\TabbedDialogContent(new CH\TabbedContainer("settings", "formSettings", false,
				"Basic Information", new CH\SplitContainer23(new CH\TagContainer("div", new CH\TagContainer("div",new CH\Img(getFile($userSession['Avatar']), "avatar-middle"))/*$userSession['Avatar'], "avatar-middle")*/,
										new CH\TagContainer("div",	new CH\Group(
											new CH\Text("firstName", $userSession['Firstname'], "Firstname", "fill"),
											new CH\Text("lastName", $userSession['Lastname'], "Lastname", "fill")
										))),
										new CH\TextArea("about-me", $userSession['About'])
									),
				"User Interface", new CH\Listing(	new CH\Label("E-mail adress:"), new CH\Text("user"),
											new CH\Label("Your user name:"), new CH\Text("name"),
											new CH\Label("Your Password:"), new CH\Text("password", "", "", "password"),
											"hidden", new CH\TagContainer("span"), new CH\Text("type", "signup"))
				)),
				new CH\Group(
					new CH\Btn("", "Close","closeDialogue('formSettings')"),
					new CH\Submit('formSettings', "Submit", "important dialog")));
	}
}
$d = (new _Dialog());
		$d->init();


/*

				"Basic Information", new CH\SplitContainer23(
							new CH\TagContainer("div",	new CH\Img($userSession['Avatar'], "avatar-middle"),
														new CH\SplitContainer(
															new CH\Text("firstName", $userSession['Firstname'], "Firstname", "fill"),
															new CH\Text("lastName", $userSession['Lastname'], "Lastname", "fill"))),
							new CH\TagContainer("div",	new CH\TextArea("about-me", $userSession['About']))
				),






if($_GET['get']=="script")
{
	echo "loadDialogueById('formSettings');";
} elseif($_GET['get']=="dialog")
{
	echo "<form id=\"formSettings\" class=\"dialogue\" action=\"someweirdAdress.php\" method=\"get\" enctype=\"multipart/form-data\">";
	echo "<div id=\"UserSettings\" data-re-align=\"formSettings\" class=\"tabbed\" data-tabs=\"basic ui myPackages installed\">
			<div class=\"tabContent\">
				<div id=\"tabContent-basic\" class=\"dialogueContent\">
					<div class=\"split-2-3\">
						<div class=\"split\">
							<img class=\"avatar-middle\" src=\"$userSession[Avatar]\">
							<div class=\"split-2\"><div class=\"split\">
							<input id=\"firstName\" class=\"fill\" type=\"text\" value=\"$userSession[Firstname]\"></div><div class=\"split\"><input id=\"lastName\" class=\"fill\" type=\"text\" value=\"$userSession[Lastname]\"></div></div>
						</div>
						<div class=\"split\">
							<textarea name=\"about-me\" cols=\"40\" rows=\"8\">$userSession[About]</textarea>
						</div>
					</div>
				</div>
				<table id=\"tabContent-ui\" class=\"dialogueContent\">
					<tbody>
					<tr>
						<td><label for=\"user\">E-mail adress:</label></td>
						<td><input id=\"inuser\" type=\"text\" name=\"user\"></td>
					</tr>
					<tr>
						<td><label for=\"name\">Your user name:</label></td>
						<td><input id=\"inname\" type=\"text\" name=\"name\"></td>
					</tr>
					<tr>
						<td><label for=\"password\">Your Password:</label></td>
						<td><input id=\"inpassword\" type=\"password\" name=\"password\" onkeydown=\"if (event.keyCode == 13) { document.getElementById('formSignUp').submit(); return false; }\"></td>
					</tr>
					<tr style=\"display: none;\">
						<td><input id=\"intype\" type=\"text\" value=\"signup\" name=\"type\"></td>
					</tr>
					</tbody>
				</table>
				<table id=\"tabContent-myPackages\" class=\"dialogueContent\">
					<tbody>
					<tr>
						<td><label for=\"user\">E-mail adress:</label></td>
						<td><input id=\"inuser\" type=\"text\" name=\"user\"></td>
					</tr>
					<tr>
						<td><label for=\"name\">Your user name:</label></td>
						<td><input id=\"inname\" type=\"text\" name=\"name\"></td>
					</tr>
					<tr>
						<td><label for=\"password\">Your Password:</label></td>
						<td><input id=\"inpassword\" type=\"password\" name=\"password\" onkeydown=\"if (event.keyCode == 13) { document.getElementById('formSignUp').submit(); return false; }\"></td>
					</tr>
					<tr style=\"display: none;\">
						<td><input id=\"intype\" type=\"text\" value=\"signup\" name=\"type\"></td>
					</tr>
					</tbody>
				</table>
				<table id=\"tabContent-installed\" class=\"dialogueContent\">
					<tbody>
					<tr>
						<td><label for=\"user\">E-mail adress:</label></td>
						<td><input id=\"inuser\" type=\"text\" name=\"user\"></td>
					</tr>
					<tr>
						<td><label for=\"name\">Your user name:</label></td>
						<td><input id=\"inname\" type=\"text\" name=\"name\"></td>
					</tr>
					<tr>
						<td><label for=\"password\">Your Password:</label></td>
						<td><input id=\"inpassword\" type=\"password\" name=\"password\" onkeydown=\"if (event.keyCode == 13) { document.getElementById('formSignUp').submit(); return false; }\"></td>
					</tr>
					<tr style=\"display: none;\">
						<td><input id=\"intype\" type=\"text\" value=\"signup\" name=\"type\"></td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class=\"tabs\">
				<div id=\"tab-basic\" class=\"tab\">Basic Information</div>
				<div id=\"tab-ui\" class=\"tab\">User Interface</div>
				<div id=\"tab-myPackages\" class=\"tab\">My Packages</div>
				<div id=\"tab-installed\" class=\"tab\">Installed Packages</div>
			</div>
		</div>";
	echo "<div onclick=\"closeDialogue('formSettings')\" class=\"btn btn-left\">Cancel</div><div onclick=\"document.getElementById('formSettings').submit()\" class=\"btn btn-right btn-dialogue btn-important\">Submit</div>
		</form>";
}*/
?>
