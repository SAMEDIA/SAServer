<?
// Include Models
	require_once '/home/songabou/songabout_lib/models/SongAboutUser.php';
	require_once '/home/songabou/songabout_lib/models/SongAboutVerifiedArtist.php';	
	
	session_start();

	if(!isset($_SESSION['user_id'])) {
		header('Location: http://www.songabout.fm/');
		exit;
	} else if($_SESSION['user_id'] != 8) {
		header('Location: http://www.songabout.fm/');
		exit;
	}

	$action = stripslashes($_GET["action"]);
	$verified_artist_id = stripslashes($_GET["verifiedArtistId"]);

	// Add code to lock down this section to only ED has access to the dash

	if(isset($action)) {
		if(isset($verified_artist_id)) {
			if($action == 'delete') {
				$songAboutVerifiedArtist = new SongAboutVerifiedArtist($verified_artist_id);
				$songAboutVerifiedArtist->deleteFromDB();
				
				header("Location: http://utah.stormfrontproductions.net/~songabou/dashboard/"); 
				exit;
			} else if ($action == 'approve') {
				$songAboutVerifiedArtist = new SongAboutVerifiedArtist($verified_artist_id);
				$songAboutVerifiedArtist->status='Verified';
				
				$songAboutVerifiedArtist->save();	
				// if need be add code to send emails to user
				
				header("Location: http://utah.stormfrontproductions.net/~songabou/dashboard/"); 
				exit;
			} else if ($action == 'deny') {
				$songAboutVerifiedArtist = new SongAboutVerifiedArtist($verified_artist_id);
				$songAboutVerifiedArtist->status='Denied';					
				
				$songAboutVerifiedArtist->save();	
				// if need be add code to send emails to user
				
				header("Location: http://utah.stormfrontproductions.net/~songabou/dashboard/"); 
				exit;
			}
		}
	}
?>