<?php
if (!isset($_SESSION)) { session_start(); }

require_once "SongInfo.php";

if (!empty($_POST['action'])) {

	switch ($_POST['action']) {

		case 'submitMeaning':
	    if (!empty($_POST['artist']) && !empty($_POST['trackname']) && !empty($_POST['meaning']) && !empty($_POST['userID'])) {
	    	echo SongInfo::submitMeaning($_POST['artist'], $_POST['trackname'], $_POST['meaning'], $_POST['userID']);
	    }
	    break;

		case 'submitLyrics':
	    if (!empty($_POST['artist']) && !empty($_POST['trackname']) && !empty($_POST['lyrics']) && !empty($_POST['userID'])) {
	    	echo SongInfo::submitLyrics($_POST['artist'], $_POST['trackname'], $_POST['lyrics'], $_POST['userID']);
	    }
	    break;

	    case 'verifyMeaning':
	    if (!empty($_POST['accept']) && !empty($_POST['submissionID'])) {
	    	echo SongInfo::verifyMeaning($_POST['accept'], $_POST['submissionID']);
	    }
	    break;

	    case 'verifyLyrics':
	    if (!empty($_POST['accept']) && !empty($_POST['submissionID'])) {
	    	echo SongInfo::verifyLyrics($_POST['accept'], $_POST['submissionID']);
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

?>