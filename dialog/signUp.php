<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "formSignUp";
		global $POST;
		global $Settings;
		$action = "$Settings[MyServer]/simReg.php";
		$this->dialogBeginTag = "form action=\"$action\" method=\"get\" enctype=\"multipart/form-data\"";
		$this->content = new CH\TagContainer("div", new CH\BasicText("redirect", "$POST[redirect]", "", "hidden"),
				new CH\TabbedDialogContent(new CH\TabbedContainer("signInUp", "", false,
				"Sign In", new CH\Listing(	new CH\Label(""), new CH\Text("user", "", "e-Mail adress"),
											new CH\Label(""), new CH\Text("password", "", "your password", "password"),
											"hidden", new CH\TagContainer("span"), new CH\Text("type", "signin")),
				"Sign Up", new CH\Listing(	new CH\Label(""), new CH\Text("user", "", "e-Mail adress"),
											new CH\Label(""), new CH\Text("name", "", "your user name"),
											new CH\Label(""), new CH\Text("password", "", "your password", "password"),
											"hidden", new CH\TagContainer("span"), new CH\Text("type", "signup"))
				)),
				new CH\Group(
					new CH\Btn("", "Close","closeDialogue('formSignUp')"),
					new CH\Submit('formSignUp', "Submit", "important dialog")));
	}
}
$d = (new _Dialog());
		$d->init();

/*if($_GET['get']=="script")
{
	echo "loadDialogueById('formSignUp');";
} elseif($_GET['get']=="dialogue")
{
	echo "<form id=\"formSignUp\" class=\"dialogue\" action=\"simReg.php\" method=\"get\" enctype=\"multipart/form-data\">";
	echo "<div id=\"signInUp\" data-re-align=\"formSignUp\" class=\"tabbed\" data-tabs=\"SignIn SignUp\">
			<div class=\"tabContent\">
				<table id=\"tabContent-SignIn\" class=\"dialogueContent\">
					<tbody>
					<tr>
						<td><label for=\"user\">E-mail adress:</label></td><td>
						<input id=\"inuser\" type=\"text\" name=\"user\"></td>
					</tr>
					<tr>
						<td><label for=\"password\">Your Password:</label></td>
						<td><input id=\"inpassword\" type=\"password\" name=\"password\" onkeydown=\"if (event.keyCode == 13) { document.getElementById('formSignUp').submit(); return false; }\"></td>
					</tr>
					<tr style=\"display: none;\">
						<td><input id=\"intype\" type=\"text\" value=\"signin\" name=\"type\"></td>
					</tr>
					</tbody>
				</table>
				<table id=\"tabContent-SignUp\" class=\"dialogueContent\">
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
				<div id=\"tab-SignIn\" class=\"tab\">Sign In</div>
				<div id=\"tab-SignUp\" class=\"tab\">Sign Up</div>
			</div>
		</div>";
	$cont = new CH\Group(new CH\Btn());
	echo "<div onclick=\"closeDialogue('formSignUp')\" class=\"btn btn-left\">Cancel</div><div onclick=\"document.getElementById('formSignUp').submit()\" class=\"btn btn-right btn-dialogue btn-important\">Submit</div>
		</form>";
}



 
			<table class=\"dialogueContent\">
				<tr>
					<td><label for=\"user\">E-mail adress:</label></td>
					<td><input type=\"text\" name=\"user\" id=\"inuser\"></td>
				</tr>
				<tr>
					<td><label for=\"name\">Your user name:</label>
					<td><input type=\"text\" name=\"name\" id=\"inname\"></td>
				</tr>
				<tr>
					<td><label for=\"password\">Your Password:</label>
					<td><input type=\"password\" name=\"password\" id=\"inpassword\"></td>
				</tr>
				<tr style=\"display: none;\">
					<td><input id=\"intype\" type=\"text\" name=\"type\" value=\"signup\"></td>
				</tr>
			</table>*/?>
