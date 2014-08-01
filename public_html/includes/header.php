<?php
	header('Content-type: text/html; charset=utf-8'); 
	
	session_start();
	
	// Include Models
	require_once '../songabout_lib/facebook/facebook.php';
	require_once '../songabout_lib/models/SongAboutUser.php';
	require_once '../songabout_lib/models/UserFacebook.php';	

	//Facebook Login
	$app_id = "155802254626494";
	$app_secret = "393a28507f8ac305dda5267a6816fa33";
	$my_url = "http://www.songabout.fm/";  
	if(!isset($_SESSION['userLoginType'])) {
		$_SESSION['userLoginType'] = null;
	}

	$facebook = new Facebook(array(
	  'appId'  => $app_id,
	  'secret' => $app_secret,
	));
	if(!isset($_SESSION['activeUser'])) {	
		// See if there is a user from a facebook cookie.  This code is essential to hook up php sessions and JS variables
		$user = $facebook->getUser();
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
				$facebook->setExtendedAccessToken();
				$fb_access_token = $_SESSION["fb_". $app_id ."_access_token"];
				$facebook->setAccessToken($fb_access_token);
				//$facebook->setAccessToken($fb_access_token);
				//echo var_dump($fb_access_token) . '<br>';
			} catch (FacebookApiException $e) {
		
			}
		  try {
				// Proceed knowing you have a logged in user who's authenticated.	
				$_SESSION['userLoginType'] = 'fb';
				$returnedUser = $facebook->api('/' . $user);	
				if(!isset($returnedUser["username"])){
					$returnedUser["username"] = str_replace(' ', '_', $returnedUser["name"]);
				}		
			} catch (FacebookApiException $e) {
				//echo 'error: ' . $e;
				$returnedUser = null;
			}
		}
	
		if(!empty($returnedUser)) {	
		// change to generic object
			$facebookUser = new UserFacebook($returnedUser["id"]);	
			if((empty($facebookUser) || empty($facebookUser->user_id)) && $_SESSION['userLoginType'] == 'fb') {
				$newUser = new SongAboutUser();
				if(isset($returnedUser["username"])){
					$cleanUserName = str_replace('.', '', $returnedUser["username"]);			
					$newUser->username = $cleanUserName;
					$newUser->save();
					$newUser = new SongAboutUser($cleanUserName);				
				} else {
					$cleanUserName = str_replace('.', '', $returnedUser["name"]);
					$newUser->username = str_replace(' ', '_', $cleanUserName);
					$newUser->save();
					$newUser = new SongAboutUser(str_replace(' ', '_', $cleanUserName));				
				}
	
				$songAboutUserId = $newUser->user_id;	
				// add exception here if user cannot be inserted
				if (!empty($songAboutUserId) and $songAboutUserId != 0) {		
					$newFacebookUser = new UserFacebook();
					$newFacebookUser->user_id = $songAboutUserId;
					$newFacebookUser->facebook_user_id = $returnedUser["id"];
					$newFacebookUser->oauth_uid = $returnedUser["id"];
					$newFacebookUser->save();
					$activeUser = new SongAboutUser($songAboutUserId);	
					$_SESSION['user_id'] = $songAboutUserId;
				}
			} else {
				// Current Logged in User Object
				if($_SESSION['userLoginType'] == 'fb') {
					$activeUser = new SongAboutUser($facebookUser->user_id);	
					$_SESSION['user_id'] = $facebookUser->user_id;
				} 
			}
		}
		
		if(empty($returnedUser)) {
			//$_SESSION['activeUser'] = NULL;
		} else {
			$_SESSION['activeUser'] = $activeUser;
			$_SESSION['user_id'] = $activeUser->user_id;
		}				

	}
	
	function url_exists($url) {
		if (!$fp = curl_init($url)) 
		{	
			return false;
		}
		curl_setopt($fp,  CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($fp);	
		$httpCode = curl_getinfo($fp, CURLINFO_HTTP_CODE);
		if($httpCode == 404 || $httpCode == 0) {
			return false;
		}		
		return true;
	}	
	
	$artistNameReplace = array('Avicii' => 'Tim Bergling', 'Tim Bergling' => 'Avicii');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
    <title><?php echo $pageTitle ?></title>
    <link rel="shortcut icon" href="" type="image/x-icon" >
    <meta name="robots" content="index, follow" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="Description" content="Where you go to find out about a song." />
    <meta name="Keywords" content="Music, Song Lyrics, Song About, Song Meaning" />
    <meta name="Author" content="SongAbout.fm" />
    <meta property="og:title" content="SongAbout.fm - Where you go to find out about a song." />
    <meta property="og:title" content="Song meanings about artist, songs and albums in the artist's own words." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://www.songabout.fm" />
    <meta property="og:image" content="images/logos/songaboutNavLogo.png" />

    <link rel="shortcut icon" href="http://www.songabout.fm/favicon.ico" type="image/x-icon">
    <link rel="icon" href="http://www.songabout.fm/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" media="all" href="styles/main.css" />
    <link rel="stylesheet" type="text/css" media="all" href="styles/homepageImage.css" />
    <link rel="stylesheet" type="text/css" media="all" href="styles/album.css" />
    <link rel="stylesheet" type="text/css" media="all" href="styles/artist.css" />
    <link rel="stylesheet" type="text/css" media="all" href="styles/song.css" />
    <link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
</head>
<body>
<div id="songAboutWrapper">
    <div id="headerWrapper">    
        <div id="headerMenuBar">
        	<div id="headerMenuWrapper" class="center">  
                <div id="headerLogo" class="left"><a href="http://www.songabout.fm"><img src="images/logos/songaboutNavLogo.png" width="215" height="47" border="0"/></a></div>
                <div id="headerNav" class="left">
                	<div id="navLyrics" class="headerNav"><a  href="lyrics.php"></a></div><div id="navArtists" class="headerNav"><a href="artist.php"></a></div><div id="navAlbums" class="headerNav"><a href="albums.php"></a></div><div id="navVerifiedArtist" class="headerNav"><a href="verified_artist.php"></a></div>
                </div>
                <div id="headerSearch" class="left">
                    <div id="headerSocialMenu" class="right">
                        <div id="socialTwitter" class="socialNav"><a href="https://twitter.com/SongAboutFm" target="_blank"></a></div><div id="socialFacebook" class="socialNav"><a href="#" target="_blank"></a></div><div id="socialInstagram" class="socialNav"><a href="http://instagram.com/songaboutfm" target="_blank"></a></div><div id="socialTumbler" class="socialNav"><a href="http://songaboutfm.tumblr.com/" target="_blank"></a></div>        
                    </div>                	
                    <div id="searchBox"><input type="text" id="searchSongAboutTxt" name="searchSongAboutTxt" size="38" maxlength="255"><div id="searchSongButton"><a href="#"></a></div></div>
                </div>
            </div>
        </div>
    </div>
	
	