<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>

<?php
	//session_start();
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '../lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
	// LyricFind API
	$LFDisplayAPI = 'd8a05b1cf5bd9e2a5761abf57543b013';
	$LFSearcAPIh = '55df723c07e5f02e52efd263c3a0d070'; 
	$LFMetadataAPI = 'fa00dc1d536580b258963f1dedef189b';
	$LFChartsAPI = '9b90fb74bdc84213310b43e7642b133e';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title><?php echo $pageTitle ?></title>
<!-- Bootstrap core CSS -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="styles/main2.css" rel="stylesheet">
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script><!--<script async src="http://assets.bop.fm/embed.js"></script>-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div id="mainNav" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
  <a id="logoPic" href="http://www.songabout.fm"><img class="navbar-brand" src="images/logos/SALogo.png"/></a> <a id="logoText" class="navbar-brand" style="color:#FFF; padding-left: 0;" href="http://www.songabout.fm">SONGABOUT</a>
  <ul id="quickNav" class="nav navbar-nav navbar-left navbar-collapse collapse">
    <li><a href="#">LYRICS</a></li>
    <li><a href="#">ARTISTS</a></li>
    <li><a href="#">ALBUMS</a></li>
    <li><a href="#">REVIEWS</a></li>
    <!--FOR FUTURE USE
            <li><a href="#">CONCERTS</a></li>-->
  </ul>
  <ul id="memberNav" class="nav navbar-nav navbar-right navbar-collapse collapse">
    <li><a href="#">SIGN IN</a></li>
    <li><a href="#">REGISTER</a></li>
  </ul>
	<div id="searchForm" class="navbar-right">
  <span style="display:none"><?php include 'includes/alphabetWidget.php'; ?></span>
  <form class="navbar-form" action="search.php">
    <input id="search" name="search" class="form-control" placeholder="Search for artists, albums, lyrics..." type="text">
    <input type="hidden" name="category" value="all">
    <button id="hidden"></button>
    <button id="button" class="btn glyphicon glyphicon-search"></button>
  </form>
  </div>
</div>