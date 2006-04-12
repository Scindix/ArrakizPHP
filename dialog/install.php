<?php
if(!@include_once("./settings.php"))
	require_once("./settings.fallback.php");
use \CodeHelper as CH;
require_once("$Settings[MyDir]/class/Dialog.class.php");
class _Dialog extends Dialog
{
	function __construct()
	{
		global $Settings;
		parent::__construct();
		$this->dialogTitle = "Installation";
		$this->dialogName = "formInstall";
		$this->globalNotice = "info";
		$this->icon = "$Settings[MyServer]/css/img/configure.png";
		$action = "$Settings[MyServerSec]/install.php";
		$this->dialogBeginTag = "form action=\"$action\" method=\"post\" enctype=\"multipart/form-data\"";
		$this->setContent(new CH\TagContainer("div", 
				new CH\BasicText("redirect", "", "", "hidden"),
				new CH\BasicText("action", "performInstallation", "", "hidden"),
				new CH\BasicText("debug", "true", "", "hidden"),			//standard, don't change unless you know what you're doing
				new CH\BasicText("synchronized", "array()", "", "hidden"),	//currently not fully supported
				new CH\TabbedDialogContent(new CH\TabbedContainer("installation", "", true,
				"Website Info", new CH\Listing(	
											new CH\Label("Basics"), new CH\Text("name", "", "name of your homepage"),
											new CH\Label(""), new CH\Text("description", "", "description of your homepage"),
											new CH\Label(""), new CH\Text("keys", "", "keys that describe this site (comma seperated list)"),
											new CH\Label(""), new CH\Check("useDNT", new CH\TextNode("Respect the HTTP header field 'Do not track'"), true),
											new CH\Label(""), new CH\Select("https", 
												new CH\Option("never", new CH\TextNode("Never use 'https://'")),
												new CH\Option("secuity", new CH\TextNode("Use 'https://' for private data")),
												new CH\Option("all", new CH\TextNode("Always use 'https://'"))
											),
											new CH\Label(""), new CH\Btn('', "Next", "setTab('installation', 'Database')")),
				"Database", new CH\Listing(	new CH\Label("MySQL login"), new CH\Text("db_user", "", "database user"),
											new CH\Label(""), new CH\Text("db_password", "", "your password", "password"),
											new CH\Label(""), new CH\Text("db_name", "", "name of the database"),
											new CH\Label(""), new CH\Text("db_prefix", "", "prefix for your tables"),
											new CH\Label(""), new CH\Btn('', "Next", "setTab('installation', 'Contact-and-Admin')")),
				"Contact and Admin", new CH\Listing(	
											new CH\Label("Contact"), new CH\Text("author_mail", "", "contact e-Mail adress"),
											new CH\Label(""), new CH\Text("author_name", "", "your contact name"),
											new CH\Label("Master"), new CH\Label("The master can view errors and logs even when the database is down!"),
											new CH\Label(""), new CH\Text("trusted_user", "", "your master user name"),
											new CH\Label(""), new CH\Text("trusted_password", "", "your master password", "password"),
											new CH\Label(""), new CH\Text("trusted_password2", "", "repeat password", "password"),
											new CH\Label("Admin"), new CH\Text("initial_mail", "", "your e-Mail adress"),
											new CH\Label(""), new CH\Text("initial_user", "", "your user name"),
											new CH\Label(""), new CH\Text("initial_password", "", "your password", "password"),
											new CH\Label(""), new CH\Text("initial_password2", "", "repeat password", "password"),
											new CH\Label(""), new CH\Btn('', "Next", "setTab('installation', 'Initial-setup')")),
				"Initial setup", new CH\Listing(
											new CH\Label(""), new CH\Check("createInitial", new CH\TextNode("Create sample data")),
											new CH\Label(""), new CH\Submit('formInstall', "Install", "important dialog"))
				))));
	}
}
?>
