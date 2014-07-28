<?php 
	$pageTitle = "SongAbout.FM | Discover what a song is about - Artist Bio";
	$page = "song-detail";
	$showSearch = true;
	
	// Song Detail page Caching Objects
	$cache_time = 864000; // Time in seconds to keep a page cached  10 day cache
	$cache_folder = 'cache/song/'; // Folder to store cached files (no trailing slash)  
	$cache_filename = $cache_folder.md5(str_replace("?cache=true", "", $_SERVER['REQUEST_URI'])); // Location to lookup or store cached file  
	//Check to see if this file has already been cached  
	// If it has get and store the file creation time  
	
	//bust cache
	if(isset($_GET["cache"]) and $_GET["cache"] == "true"){
		if(file_exists($cache_filename) === true) {
			try {
				unlink($cache_filename);
				$cache_time = 0;
			} catch (Exception $e) {
				
			}
			$cache_time = 0;
		}
	}

	clearstatcache();
	if(file_exists($cache_filename) === true) {
		$cache_created = filemtime($cache_filename);
	} else {
		$cache_created = 0;
	}

	function sanitize_output($buffer)
	{
		$search = array(
			'/\>[^\S ]+/s', //strip whitespaces after tags, except space
			'/[^\S ]+\</s', //strip whitespaces before tags, except space
			'/(\s)+/s'  // shorten multiple whitespace sequences
			);
		$replace = array(
			'>',
			'<',
			'\\1'
			);
	  $buffer = preg_replace($search, $replace, $buffer);
		return $buffer;
	}
	/*
	if ((time() - $cache_created) < $cache_time) {  
	 readfile($cache_filename); // The cached copy is still valid, read it into the output buffer  
	 die();
	} else {	
		ob_start("sanitize_output");
	}*/

	require_once '../songabout_lib/models/SongAboutMeaningPiece.php';	
	require_once '../songabout_lib/models/SongAboutUser.php';
	require_once '../songabout_lib/models/UserFacebook.php';	
	require_once '../songabout_lib/models/SongAboutArtist.php';	
	require_once '../songabout_lib/models/SongAboutVerifiedArtist.php';	
	require_once '../songabout_lib/models/SongAboutArtistStore.php';	
?>
<?php include 'includes/headertest.php'; ?>
<div class="main-content">
  <div class="container-fluid"> </div>
</div>
<?php include 'includes/footertest.php'; ?>