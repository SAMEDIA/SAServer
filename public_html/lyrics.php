<?php
	$cache_time = 1800; // Time in seconds to keep a page cached  
	$cache_folder = 'cache/pages/'; // Folder to store cached files (no trailing slash)  
	$cache_filename = $cache_folder.md5($_SERVER['REQUEST_URI']); // Location to lookup or store cached file  
	//Check to see if this file has already been cached  
	// If it has get and store the file creation time  
	$cache_created  = (file_exists($cache_file_name)) ? filemtime($this->filename) : 0;  
	 
	if ((time() - $cache_created) < $cache_time) {  
	 //readfile($cache_filename); // The cached copy is still valid, read it into the output buffer  
	 //die();  
	} 

	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;	
		
	// Homepage Caching Objects
	require_once '../songabout_lib/models/PopularArtistCache.php';
	require_once '../songabout_lib/models/PopularSongCache.php';
	require_once '../songabout_lib/models/PopularAlbumCache.php';
	
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
	
	require_once 'includes/staffPicksVar.php';

	$topSongObj = new PopularSongCache();
	$topSongs = $topSongObj->fetchAllSongs(1, 27, 'All', '', '', '  day_rating DESC');
?>
<?php 	include 'includes/header.php'; ?>
	<!-- Non animated slider but added code so that a slider can be added later -->
    <div id="contentHeaderWrapper" class="grayBG left"> 
    	<div id="contentHeader" class="center">  			
			      
        </div>
    </div>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">       
		<div class="contentFooterWrapperWidget left"> 
        <div id="topLyricsContentFooterWidget" class="contentFooterWidget center">  
        	<div class="sectionTitles left">
            	Top Lyrics
             </div>
                <?php
					$count = 0;
					// The APIs return duplicates at time this is a double check to make sure they are not displaed.
					$lastSongTitle = "";
					
					foreach ($topSongs as &$song) {
						$artistSearchString = preg_replace("~[\\\\/:*?'().<>|]~","",str_replace(" ","-",$song->artist_name));
						$songSearchString = preg_replace("~[\\\\/:*?'().<>|]~","",str_replace(" ","-",$song->song_title));						
						if($songSearchString != $lastSongTitle) {
							$lastSongTitle = $songSearchString;
							$songLyrics = getCurlData('http://test.lyricfind.com/api_service/lyric.do?apikey=d8a05b1cf5bd9e2a5761abf57543b013&reqtype=default&trackid=artistname:' . $artistSearchString .',trackname:'. $songSearchString .'&output=json&useragent=X');
							$songLyricsJSON = json_decode($songLyrics);
							$songPieces = explode('<br />', nl2br($songLyricsJSON->track->lyrics));
							if(isset($songLyrics) && $songLyrics != "" && count($songPieces) > 1) {					
								$topLyricHtml .= '<div id="songLyric-' . $song->song_id  . '" class="songLyricItem left" onclick="javascript:document.location.href=\'http://www.songabout.fm/artist/' . $artistSearchString . '/song/' . $songSearchString . '\'">';
								$countBoxes = 0;
									$topLyricHtml .= '<p>';
									foreach ($songPieces as &$songPiece) {
										$countBoxes++;					
										
										$topLyricHtml .= $songPiece . '<br><br>';
										if($countBoxes >= 3) {
											break;
										}			
									}	
									$topLyricHtml .= '</p>';
									$count++;	
									$topLyricHtml .= '<div class="songLyricsClass" onclick="javascript:document.location.href=\'http://www.songabout.fm/artist/' . $artistSearchString . '/song/' . $songSearchString . '\'">';
										$topLyricHtml .= '<div class="songItemTitle left">';
											$topLyricHtml .= $song->song_title . '<br>';
											$topLyricHtml .= '<span class="songItemLyricTitleFootnote">' . $song->artist_name . "</span>";
										$topLyricHtml .= '</div>';	
										$topLyricHtml .= '<div class="songItemImg left">';
											$topLyricHtml .= '<img src="' . $song->cover_image_url . '" height="60" width="60" border="0">';
										$topLyricHtml .= '</div>';	
									$topLyricHtml .= '</div>';											
								$topLyricHtml .= '</div>';	
							}
						}
					}
					echo $topLyricHtml;
				?>          
            </div>
        </div>
    </div>      
    <span class="clear"></span>
    
<?php 	
	function getCurlData($url) {
	  $ch = curl_init();
	  $timeout = 5;
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}  	
	
	include 'includes/footer.php'; 
?>
<?php
	file_put_contents($cache_filename, ob_get_contents());  
	ob_end_flush();
?>