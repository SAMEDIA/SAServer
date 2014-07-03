<?
require_once '/home/songabou/songabout_lib/models/SongAboutUser.php';
require_once '/home/songabou/songabout_lib/models/UserFacebook.php';	
require_once '/home/songabou/songabout_lib/models/SongAboutArtist.php';	
require_once '/home/songabou/songabout_lib/models/SongAboutVerifiedArtist.php';	

session_start();
if($_POST["artistName"]) {
	$artistNameToClaim = stripslashes($_POST["artistName"]);
} else {
	$artistNameToClaim = "";
}

if($_GET["artistName"]) {
	$artistNameToClaim = stripslashes($_GET["artistName"]);
} else {
	$artistNameToClaim = "";
}

$artistNameToClaim = stripslashes($artistNameToClaim);
$artistNameToClaim = str_replace("-"," ",$artistNameToClaim);
$artistNameToClaim = str_replace("-"," ",$artistNameToClaim );

$newArtist = new SongAboutArtist($artistNameToClaim);	
if(isset($_SESSION['activeUser']) && $_SESSION['activeUser']->user_id) {
	if($newArtist) {
		// create new artist
		if(isset($newArtist->artist_id)) {
			$songAboutVerifiedArtist = new SongAboutVerifiedArtist();
			
			$songAboutVerifiedArtist->artist_id = $newArtist->artist_id;
			$songAboutVerifiedArtist->user_id = $_SESSION['activeUser']->user_id;

			$songAboutVerifiedArtist->save();	
			
			echo 'true';
			exit;
		} else {		
			$echoNestAPIKey = 'YTEIFSAM5TAJZ4JBR';
			require_once '/home/songabou/lib/EchoNest/Autoloader.php';
			EchoNest_Autoloader::register();
			$songAboutEchonest = new EchoNest_Client();
			$songAboutEchonest->authenticate($echoNestAPIKey);	
			
			$artistDetail = $songAboutEchonest->getArtistApi()->setName(str_replace("-"," ",$artistNameToClaim));	
			$artistProfile = $artistDetail->getProfile(array('bucket' => "images"));
			
			if($artistProfile) {
				$newArtist = new SongAboutArtist();
				$newArtist->echonest_id = $artistProfile["id"];
				$newArtist->artist_name = $artistProfile["name"];
				$newArtist->profile_image_url = $artistProfile["images"][0]["url"];		
				
				$newArtist->save();
				echo 'true';
				exit;	
			}
			echo 'false';	
			exit;
		}
	} else {
		echo 'false';
		exit;
	}
} else {
	echo 'false';
	exit;
}
?>