<?php
require_once("settings.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		parent::__construct();
		$this->dialogName = "formUploadPackage";
		$this->dialogTitle = "Upload a package";
		$this->dialogBeginTag = "form action=\"up.php\" method=\"post\" enctype=\"multipart/form-data\"";
		$this->content = new CH\TagContainer("div",
				new CH\DialogContent(new CH\TagContainer("div class=\"list\"",
					new CH\Text("file", "", "Upload a file", "file"),
					new CH\Text("packageType", "", "Package Type"),
					new CH\Text("uid", "", "Unique Name"),
					new CH\Text("version", "", "Version"),
					new CH\Text("title", "", "Title"),
					new CH\Text("description", "", "Description"),
					new CH\Text("short", "", "Short Description"),
					new CH\Text("author", "", "Author"),
					new CH\Text("user", "", "Distributor"),
					new CH\Text("license", "", "License"),
					new CH\Text("change", "", "Changes and Bugs"),
					new CH\Text("homepage", "", "Hompage"),
					new CH\Text("release", "", "Release Date"))),
				new CH\Group(
					new CH\Btn("", "Close","closeDialogue('formUploadPackage')", ""),
					new CH\Submit('formUploadPackage', "Upload", "important dialog")));
	}
}
$d = (new _Dialog());
		$d->init();
/*if($_GET['get']=="dialogue")
{
	echo "<form id=\"formUploadPackage\" class=\"dialogue\" action=\"up.php\" method=\"post\" enctype=\"multipart/form-data\">
			<table class=\"dialogueContent\">
				<tr>
					<td><label for=\"file\">Filename:</label></td>
					<td><input type=\"file\" name=\"file\" id=\"infile\"></td>
				</tr>
				<tr>
					<td><label for=\"packageType\">Package Type:</label>
					<td><input type=\"text\" name=\"packageType\" id=\"inpackageType\"></td>
				</tr>
				<tr>
					<td><label for=\"uid\">Unique Name:</label>
					<td><input type=\"text\" name=\"uid\" id=\"inuid\"></td>
				</tr>
				<tr>
					<td><label for=\"version\">Version:</label>
					<td><input type=\"text\" name=\"version\" id=\"inversion\"></td>
				</tr>
				<tr>
					<td><label for=\"title\">Title:</label>
					<td><input type=\"text\" name=\"title\" id=\"intitle\"></td>
				</tr>
				<tr>
					<td><label for=\"description\">Description:</label>
					<td><input type=\"text\" name=\"description\" id=\"indescription\"></td>
				</tr>
				<tr>
					<td><label for=\"short\">Short Description:</label>
					<td><input type=\"text\" name=\"short\" id=\"inshort\"></td>
				</tr>
				<tr>
					<td><label for=\"author\">Author:</label>
					<td><input type=\"text\" name=\"author\" id=\"inauthor\"></td>
				</tr>
				<tr>
					<td><label for=\"user\">Distributor:</label>
					<td><input type=\"text\" name=\"user\" id=\"inuser\"></td>
				</tr>
				<tr>
					<td><label for=\"license\">License:</label>
					<td><input type=\"text\" name=\"license\" id=\"inlicense\"></td>
				</tr>
				<tr>
					<td><label for=\"change\">Changes and Bugs:</label>
					<td><input type=\"text\" name=\"change\" id=\"inchange\"></td>
				</tr>
				<tr>
					<td><label for=\"homepage\">Hompage:</label>
					<td><input type=\"text\" name=\"homepage\" id=\"inhomepage\"></td>
				</tr>
				<tr>
					<td><label for=\"release\">Release Date:</label>
					<td><input type=\"text\" name=\"release\" id=\"inrelease\"></td>
				</tr>
			</table>
			<div onclick=\"closeDialogue('formUploadPackage')\" class=\"btn btn-left\">Cancel</div><div onclick=\"document.getElementById('formUploadPackage').submit()\" class=\"btn btn-right btn-dialogue btn-important\">Submit</div>
		</form>";
} elseif($_GET['get']=="script")
{
	echo "loadDialogueById('formUploadPackage');";
}
	</body>
</html>*/
?> 
