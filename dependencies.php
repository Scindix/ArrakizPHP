<?php
	$ExtDependencies = array(
		"mysqli"	=> array("lib" => "mysqli.so",	"title" => "MySQLi"),
		"gd" 		=> array("lib" => "gd.so",		"title" => "GD Graphics Library"),
	);
	$DataDependencies = array(
		"album_data" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Album"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Title"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Description"		=> array("Type" => "text",			"Key" => "",	"Extra" => ""),
			"Image"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
		),
		"files" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Path"				=> array("Type" => "varchar(256)",	"Key" => "",	"Extra" => ""),
			"Owner"				=> array("Type" => "varchar(200)",	"Key" => "",	"Extra" => ""),
			"Mime"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
		),
		"img" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Purpose"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Destiny"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Path"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
		),
		"apps" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"UID"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Downloads"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Slider"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"PackageType"		=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Logo"				=> array("Type" => "varchar(256)",	"Key" => "",	"Extra" => ""),
			"Title"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"ShortDescription"	=> array("Type" => "text",			"Key" => "",	"Extra" => ""),
			"Description"		=> array("Type" => "mediumtext",	"Key" => "",	"Extra" => ""),
			"Download"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Version"			=> array("Type" => "varchar(32)",	"Key" => "",	"Extra" => ""),
			"Maintainer"		=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Author"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"License"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Change"			=> array("Type" => "text",			"Key" => "",	"Extra" => ""),
			"Homepage"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Filesize"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"ReleaseDate"		=> array("Type" => "date",			"Key" => "",	"Extra" => ""),
		),
		"mime" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"MimeID"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Logo"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"WebApp"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"LogoFile"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
		),
		"pages" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Name"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Timestamp"			=> array("Type" => "date",			"Key" => "",	"Extra" => ""),
			"Title"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Content"			=> array("Type" => "longtext",		"Key" => "",	"Extra" => ""),
			"Stream"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
		),
		"review" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Destiny"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"UserID"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Title"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Time"				=> array("Type" => "date",			"Key" => "",	"Extra" => ""),
			"Rating"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Content"			=> array("Type" => "mediumtext",	"Key" => "",	"Extra" => ""),
		),
		"stream" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"StreamID"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"PostBlock"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"UserID"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Title"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Time"				=> array("Type" => "date",			"Key" => "",	"Extra" => ""),
			"Rating"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Content"			=> array("Type" => "mediumtext",	"Key" => "",	"Extra" => ""),
		),
		"user" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Name"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Mail"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Status"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Password"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"SessionID"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"SessionTimeOut"	=> array("Type" => "date",			"Key" => "",	"Extra" => ""),
			"InstalledPackages"	=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Avatar"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Firstname"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Lastname"			=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"About"				=> array("Type" => "mediumtext",	"Key" => "",	"Extra" => ""),
			"Skills"			=> array("Type" => "text",			"Key" => "",	"Extra" => ""),
		),
		"project" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Name"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Maintainer"		=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"RootProject"		=> array("Type" => "int(11)",		"Key" => "",	"Extra" => "")
		),
		"project_apps" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Project"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"App"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => "")
		),
		"project_user" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Project"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"User"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => "")
		),
		"album" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"Title"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Author"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => "")
		),
		"file_read_permission" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"File"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"User"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => "")
		),
		"file_write_permission" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"File"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"User"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => "")
		)/*,
		"menu" => array(
			"ID"				=> array("Type" => "int(11)",		"Key" => "PRI",	"Extra" => "auto_increment"),
			"RootMenu"			=> array("Type" => "int(11)",		"Key" => "",	"Extra" => ""),
			"Title"				=> array("Type" => "varchar(128)",	"Key" => "",	"Extra" => ""),
			"Page"				=> array("Type" => "int(11)",		"Key" => "",	"Extra" => "")
		)*/
	);
	$InitialDataDependencies = array(
		"mime" => array(
			array("data" => array("MimeID" => "'image/png'",				"Logo" => "1",  "WebApp" => "2", "LogoFile" => "1"), "need" => "required", "file" => "(.*)\.png"),
			array("data" => array("MimeID" => "'application/octet-stream'",	"Logo" => "0",  "WebApp" => "0", "LogoFile" => "1"), "need" => "required", "file" => "$^"),
			array("data" => array("MimeID" => "'folder'",					"Logo" => "9",  "WebApp" => "1", "LogoFile" => "1"), "need" => "required", "file" => "$^"),
			array("data" => array("MimeID" => "'text/plain'",				"Logo" => "11", "WebApp" => "3", "LogoFile" => "1"), "need" => "required", "file" => "(.*)\.txt")
		),
		"files" => array(
			array("data" => array("Path" => "'data/commons/1/ui_items.png'",			"Owner" => "'public'",		"Mime" => "'image/png'"),				"need" => "required"),
			array("data" => array("Path" => "'data/standard/standard_package.png'",		"Owner" => "'public'",		"Mime" => "'image/png'"),				"need" => "required"),
			array("data" => array("Path" => "'data/standard/standard_profile.png'",		"Owner" => "'public'",		"Mime" => "'image/png'"),				"need" => "required"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide1.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide2.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide3.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide4.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide5.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide6.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide7.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide8.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide9.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/promo/slide10.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/2/album/logo/Freecraft.png'","Owner" => "'project/2'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/album/logo/arrakiz.png'",	"Owner" => "'project/1'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/1/downloads/arrakiz-1.0.0043.arrakiz'",	
																						"Owner" => "'project/1'",	"Mime" => "'application/octet-stream'"),"need" => "optional"),
			array("data" => array("Path" => "'data/project/2/album/promo/1.png'",		"Owner" => "'project/2'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/2/album/promo/2.png'",		"Owner" => "'project/2'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/2/album/promo/3.png'",		"Owner" => "'project/2'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/2/album/promo/4.png'",		"Owner" => "'project/2'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/2/album/promo/5.png'",		"Owner" => "'project/2'",	"Mime" => "'image/png'"),				"need" => "optional"),
			array("data" => array("Path" => "'data/project/2/album/promo/6.png'",		"Owner" => "'project/2'",	"Mime" => "'image/png'"),				"need" => "optional")
		),
		"album_data" => array(
			array("data" => array("Album" => "1",	"Title" => "'Arrakiz is cool'",		"Description" => "'It really is!'",							"Image" => "4"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'Huge Interfaces'",		"Description" => "'It can be used to make huge interfaces'","Image" => "5"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'Simply geniuous'",		"Description" => "'It is genious in every aspect'",			"Image" => "6"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'Open Source'",			"Description" => "'The Source Code is open to everyone'",	"Image" => "7"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'Power of CSS and XML'","Description" => "'Make used of powerful Web-Technologies'","Image" => "8"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'Modularity'",			"Description" => "'Everything is made of modules!'",		"Image" => "9"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'Easy to use'",			"Description" => "'Intuitive and well documented GUI'", 	"Image" => "10"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'Build games'",			"Description" => "'Use Arrakiz as a gane engine'",			"Image" => "11"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'And publish'",			"Description" => "'Use the soft center to publish apps'",	"Image" => "12"),	"need" => "optional"),
			array("data" => array("Album" => "1",	"Title" => "'Lorem ipsum'",			"Description" => "'Lorem ipsum dolor sit amet, conset ...'","Image" => "13"),	"need" => "optional"),
			array("data" => array("Album" => "2",	"Title" => "'Freecraft FTW!'",		"Description" => "'It\'s a block based game. "
																														."Similar to Minecraft.'",	"Image" => "17"),	"need" => "optional"),
			array("data" => array("Album" => "2",	"Title" => "'Extensible'",			"Description" => "'The game is moddable through plugins'",	"Image" => "18"),	"need" => "optional"),
			array("data" => array("Album" => "2",	"Title" => "'High end Graphics'",	"Description" => "'High end graphics because of the use of"
																														."the Arrakiz game engine'","Image" => "19"),	"need" => "optional"),
			array("data" => array("Album" => "2",	"Title" => "'Public Server'",		"Description" => "'Play with others on our public servers'","Image" => "20"),	"need" => "optional"),
			array("data" => array("Album" => "2",	"Title" => "'Texturing'",			"Description" => "'Use Texture Packs to customize"
																																	."Freecraft'",	"Image" => "21"),	"need" => "optional"),
			array("data" => array("Album" => "2",	"Title" => "'Lorem ipsum'",			"Description" => "'Lorem ipsum dolor sit amet, conset ...'","Image" => "22"),	"need" => "optional")
		),
		"album" => array(
			array("data" => array("Title" => "'Arrakiz Promo'",		"Author" => "1"),	"need" => "optional"),
			array("data" => array("Title" => "'Freecraft Promo'",	"Author" => "1"),	"need" => "optional")
		),
		"apps" => array(
			array("data" => array("UID" => "'org.cedric.arrakiz'", "Downloads" => "20", "Slider" => "1", "PackageType" => "3", "Logo" => "15", "Title" => "'Arrakiz'", "ShortDescription" => "'Arrakiz is cool!'", "Description" => "'It is a framework, game engine, database and app store.'", "Download" => "16", "Version" => "'1.0.0043'", "Maintainer" => "1", "Author" => "'Cedric Wehrum'", "License" => "'GPLv3'", "Change" => "'Initial commit'", "Homepage" => "'http://www.arrakiz.org'", "Filesize" => "112640", "ReleaseDate" => "'2015-06-01'"),	"need" => "optional"),
			array("data" => array("UID" => "'org.cedric.freecraft'", "Downloads" => "8", "Slider" => "2", "PackageType" => "3", "Logo" => "14", "Title" => "'Freecraft'", "ShortDescription" => "'a block game!'", "Description" => "'An open world game, based on voxel graphics.'", "Download" => "16", "Version" => "'1.0.0086'", "Maintainer" => "1", "Author" => "'Cedric Wehrum'", "License" => "'MIT'", "Change" => "'Initial commit'", "Homepage" => "'http://www.example.com'", "Filesize" => "112640", "ReleaseDate" => "'2015-06-01'"),	"need" => "optional")
		),
		"project" => array(
			array("data" => array("Name" => "'Arrakiz'",	"Maintainer" => "1", "RootProject" => "0"),	"need" => "optional"),
			array("data" => array("Name" => "'Freecraft'",	"Maintainer" => "1", "RootProject" => "1"),	"need" => "optional")
		),
		"project_apps" => array(
			array("data" => array("Project" => "1",	"App" => "1"),	"need" => "optional"),
			array("data" => array("Project" => "2",	"App" => "2"),	"need" => "optional")
		),
		"project_user" => array(
			array("data" => array("Project" => "1",	"User" => "1"),	"need" => "optional"),
			array("data" => array("Project" => "2",	"User" => "1"),	"need" => "optional")
		),
		"file_read_permission" => array(
			array("data" => array("File" => "1",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "2",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "3",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "4",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "5",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "6",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "7",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "8",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "9",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "10",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "11",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "12",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "13",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "14",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "15",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "16",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "17",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "18",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "19",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "20",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "21",	"User" => "0"),	"need" => "optional"),
			array("data" => array("File" => "22",	"User" => "0"),	"need" => "optional")
		)
	);
	global $ExtDependencies;
	global $DataDependencies;
	global $InitialDataDependencies;
?>
