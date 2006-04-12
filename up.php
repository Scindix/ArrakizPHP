<?php
	$allowedExts = array("scp", "package", "scindix");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	$uploadFilename = str_replace(":",".",$_POST["version"]);
	$fileName = "$_POST[uid]-$uploadFilename".".scindix";

	if (/*($_FILES["file"]["type"] == "application/zip")
	&&*/ ($_FILES["file"]["size"] < 200000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}
		else
		{
			echo "Upload: " . $fileName . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
			echo $_POST['title'];
			if (!file_exists("./user/$_POST[user]"))
				mkdir("./user/$_POST[user]", 0700);
			if (file_exists("./user/$_POST[user]/" . $fileName))
			{
				echo $fileName . " already exists. ";
				exit;
			}
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"./user/$_POST[user]/" . $fileName);
				echo "Stored in: " . "user/$_POST[user]/" . $fileName;
			}
		}
	}
	else
	{
		echo "Invalid file";
		exit;
	}
	
$username="scindix_repo";
$password="scindix";
$database="scindix_repo";

$con=mysqli_connect(localhost,$username,$password,$database);
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql="INSERT INTO repository_main (PackageType, UID, Version, Title, Description, ShortDescription, Author, License, `Change`, Download, Homepage, FileSize, User, ReleaseDate) VALUES ($_POST[packageType],'$_POST[uid]','$_POST[version]','$_POST[title]','$_POST[description]','$_POST[short]','$_POST[author]','$_POST[license]','$_POST[change]','./user/$_POST[user]/$_POST[uid]-$uploadFilename".".scindix"."','$_POST[homepage]',".$_FILES["file"]["size"].",'$_POST[user]','$_POST[release]')";

if (!mysqli_query($con,$sql))
{
	die('Error: ' . mysqli_error($con));
}
echo "1 record added";

mysqli_close($con);
?> 
