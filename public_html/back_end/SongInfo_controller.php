<?php
if (!isset($_SESSION)) { session_start(); }

require_once "SongInfo.php";

if (!empty($_POST['action'])) {

	switch ($_POST['action']) {

		case 'submitInfo':
	    if (!empty($_POST['artist']) && !empty($_POST['trackname']) && !empty($_POST['infoType']) && !empty($_POST['userID'])) {
	    	//echo $_POST['artist'] . $_POST['trackname'] . $_POST['infoType'] . $_POST['info'] . $_POST['userID'];
	    	if ($_POST['infoType'] != "image" && !empty($_POST['info'])) {
	    		echo SongInfo::submitInfo($_POST['artist'], $_POST['trackname'], $_POST['infoType'], $_POST['info'], $_POST['userID']);
	    	}
	    	else {
	    		// upload image
	    		if (!empty($_FILES['image'])) {
					$imagesPath = "/Applications/XAMPP/xamppfiles/htdocs/SAServer/public_html/back_end/images/";

					$allowedExts = array("gif", "jpeg", "jpg", "png");
					$extension = strtolower(end(explode(".", $_FILES["image"]["name"])));

					if ((($_FILES["image"]["type"] == "image/gif")
					|| ($_FILES["image"]["type"] == "image/jpeg")
					|| ($_FILES["image"]["type"] == "image/jpg")
					|| ($_FILES["image"]["type"] == "image/png"))
					&& ($_FILES["image"]["size"] < 1000000)
					&& in_array($extension, $allowedExts)) {
						if ($_FILES["image"]["error"] > 0) {
							echo "Error: " . $_FILES["image"]["error"] . "<br>";
						}
						else {
							echo "Upload: " . $_FILES["image"]["name"] . "<br>";
							echo "Type: " . $_FILES["image"]["type"] . "<br>";
							echo "Size: " . ($_FILES["image"]["size"] / 1024) . " kB<br>";
							echo "Temp File: " . $_FILES["image"]["tmp_name"]."<br>";
							
							$imageFile = uniqid() . "." . $extension;

							if (file_exists($imagesPath . $imageFile)) {
							  	echo $_FILES["image"]["name"] . " already exists. "; // ask user to upload again
							}
							else {
							  	move_uploaded_file($_FILES["image"]["tmp_name"], $imagesPath . $imageFile);

							  	// store info in database
							  	echo "Database: " . SongInfo::submitInfo($_POST['artist'], $_POST['trackname'], $_POST['infoType'], $imageFile, $_POST['userID'])."<br>";

							  	echo "Stored in: " . $imagesPath . $imageFile;
							}
						}
					}
					else {
						echo "invalid_file";
					}
				}
	    	}
	    }
	    break;

	    case 'verifyInfo':
	    if (!empty($_POST['accept']) && !empty($_POST['submissionID'])) {
	    	echo SongInfo::verifyInfo($_POST['accept'], $_POST['submissionID']);
	    }
	    break;

	    case 'submitMeta':
	    if (!empty($_POST['artist']) && !empty($_POST['trackname'])) {
	    	echo SongInfo::submitMeta($_POST['artist'], $_POST['trackname']);
	    }

	    case 'adminSignIn':
	    if (!empty($_POST['password']))
	    	echo SongInfo::adminSignIn($_POST['password']);
	    break;

	    case 'adminSignOut':
	    echo SongInfo::adminSignOut();
	    break;

	  	default:
	    break;
	}	
}

// image upload



?>