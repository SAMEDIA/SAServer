<?php
require_once '/home/songabou/songabout_lib/models/SongAboutUser.php';
require_once '/home/songabou/songabout_lib/models/UserFacebook.php';	
require_once '/home/songabou/songabout_lib/models/SongAboutArtist.php';	
require_once '/home/songabou/songabout_lib/models/SongAboutVerifiedArtist.php';	
require_once '/home/songabou/songabout_lib/models/SongAboutMeaningPiece.php';	


session_start();

$artistID = stripslashes($_POST["artistID"]);
$songPieceId = stripslashes($_POST["songPieceId"]);
$songPiece = stripslashes($_POST["songPiece"]);
$songId = stripslashes($_POST["songId"]);
$songPieceNum = stripslashes($_POST["songPieceNum"]);
$songMeaning = $_POST["songMeaning"];

if(isset($_SESSION['activeUser']) && $_SESSION['activeUser']->user_id) {
	$newArtist = new SongAboutArtist($artistID);
	if($newArtist) {
		// create new artist
		if(isset($newArtist->artist_id)) {
			if(isset($songPieceId)) {
				$SongAboutMeaningPiece = new SongAboutMeaningPiece($songPieceId);
			} else {
				$SongAboutMeaningPiece = new SongAboutMeaningPiece();
			}
			
			$SongAboutMeaningPiece->song_id = $songId;
			$SongAboutMeaningPiece->piece_number = str_replace("songPiece-","",$songPieceNum);
			$SongAboutMeaningPiece->meanting_text = $songMeaning;
			$SongAboutMeaningPiece->user_who_entered = $_SESSION['activeUser']->user_id;	

			$SongAboutMeaningPiece->save();	
		} else {
			echo $artistID  . ' false ' . $newArtist->artist_id;	
		}
	} else {
		echo 'false';
	}
} else {
	echo 'false';
}
?>