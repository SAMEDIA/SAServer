<?php
	/*$cache_time = 3600 * 24 * 10;  // Time in seconds to keep a page cached  
	$cache_folder = '/home/songabou/public_html/cache/artist/'; // Folder to store cached files (no trailing slash)  
	$cache_filename = $cache_folder.md5($_SERVER['REQUEST_URI']); // Location to lookup or store cached file  
	//Check to see if this file has already been cached  
	// If it has get and store the file creation time  
	$cache_created  = (file_exists($cache_filename)) ? filemtime($this->filename) : 0;  

	clearstatcache();
	if(file_exists($cache_filename) === true) {
		$cache_created = filemtime($cache_filename);
	} else {
		$cache_created = 0;
	}	
	 
	if ((time() - $cache_created) < $cache_time) {  
	 readfile($cache_filename); // The cached copy is still valid, read it into the output buffer  
	 die();  
	} else {
		ob_start();
	}*/

	require_once '../songabout_lib/models/SongAboutUser.php';
	require_once '../songabout_lib/models/SongAboutArtist.php';	
	require_once '../songabout_lib/models/SongAboutVerifiedArtist.php';	

	session_start();

	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "artist_detail";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '../lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
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


	if(isset($_GET["artistID"])) {
		$artistID = $_GET["artistID"];
	} 
	
	if(isset($_GET["artistName"])) {
		$artistName = $_GET["artistName"];
	} 
	
	$artistArray = array("/Beyoncee/","/Beyoncé/");
	$artistArrayTrans = array("Beyonce","Beyonce");

	$artistName = preg_replace($artistArray,$artistArrayTrans, $artistName);
	

	if(isset($_GET["letter"])) {
		$currentLetterTag = $_GET["letter"];
	} else {
		$currentLetterTag = 'All';
	}
	
	if(isset($artistName)) {
		$artistDetail = $songAboutEchonest->getArtistApi()->setName($artistName);
	}
	
	if(isset($artistID)) {
		$artistDetail = $songAboutEchonest->getArtistApi()->setId($artistID);
	}	
	
	if(isset($artistDetail)) {	
		$artistProfile = $artistDetail->getProfile(array('bucket' => "images"));
		$artistProfileGenre = $artistDetail->getProfile(array('bucket' => "genre"));
		$artistSearchString = str_replace(" ","+",$artistProfile["name"]);
		$artistSimilar = $artistDetail->getSimilar('5', '5', '0', array("images"), '1.0', '0.0', '1.0',  '0.0','false', 'false', NULL);
		//if(isset($artistSimilar[0]["id"])) {
			//$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => $artistSimilar[0]["id"], 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		//} else {
			//$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => 'SORMQAA135C3593DCB', 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		//}
		
		$artistAudio = getCurlData('http://ws.audioscrobbler.com/2.0/?method=artist.gettopalbums&artist=' . $artistSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=4');
	} else {
		// Add redirect code
	}

?>
<?php 	include 'includes/header.php'; ?>
<?php
$SongAboutArtistObj = new SongAboutArtist($artistProfile["name"]);
if(isset($_SESSION['activeUser']) && $_SESSION['activeUser']->user_id) {
	if(isset($SongAboutArtistObj->artist_id)) {
		$songAboutVerifiedArtistObj = new SongAboutVerifiedArtist();
		
		$allVerifiedArtist = $songAboutVerifiedArtistObj->fetchAllVerfied(1, 30, ' and status="Verified" and sa.artist_id = ' . $SongAboutArtistObj->artist_id . ' and su.user_id= ' . $_SESSION['activeUser']->user_id, $orderBySQL = "  artist_name DESC");
		
		if(count($allVerifiedArtist)) {
			$isVerifiedForPage = true;	
		}
		
	} else {
		$isVerifiedForPage = false;	
	}
} else {
	$isVerifiedForPage = false;
}
?> 
 
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
			<div id="" class="left col-1"> 
                <?php 	include 'includes/sidebar-suggested-songs.php'; ?>           
                
                <?php 	include 'includes/sidebar-suggested-artist.php'; ?> 		              		
            </div>
			<div id="col-2" class="left col-2"> 
			
                <div class="artistDetailBox"> 
                    <div class="artistItemImg">
                      <?php 
							$foundImage = false;
							foreach ($artistProfile["images"] as &$artistImage) {
								if(isset($artistImage["url"])  && url_exists($artistImage["url"])) {
									echo '<img src="' . $artistImage["url"] .'" height="125" width="125" border="0">';
									$foundImage = true;
									break;
								} 
							}														
							if(!$foundImage){
								echo '<img src="/images/noSGcover.png" height="125" width="125" border="0">';
							}
						?>  
                    </div>
                    <div id="artistItemSocialIcons" class="right">
                    	<div id="artistItemSocialFB"><a href="#"></a></div>
                        <div id="artistItemSocialTwitter"><a href="#"></a></div>
                        <div id="artistItemSocialShare"><a href="#"></a></div>
                    </div>
    				<div class="artistItemDetailText">
                    	<?php echo $artistProfile["name"]; ?>
                       <br />
                       <?php
						   $genreCount = 0;
						   foreach ($artistProfileGenre["genres"] as &$artisGenre) {
							   echo $artisGenre["name"];
							   $genreCount++;
							   if($genreCount > 2) {
									break;   
							   } else {
									echo ', ';   
							   }
						   }
					   ?>
                    </div> 
                   <div class="artistItemDetailMenu left">
						<?php 
                            if($isVerifiedForPage) {
                                echo'<div class="left" id="buttonEditPlayVideo"><a href="#"></a></div>';
                            } else {
                                echo'<div class="left" id="buttonPlayVideo"><a href="#"></a></div>';
                            }
                        ?>
                        <div class="left" id="buttonClaimPage"><a href="#"></a></div>
                        <div class="left" id="buttonArtistBio"><a href="/artist/<?php echo $artistName ?>/bio"></a></div>
                        <input type="hidden" name="artistNameInput" value="<?php echo $artistName ?>" />
                    </div>                           
                </div>
                
                <br />
                
                <div id="artistDetailSongs">
                    <div id="topArtistPageTitle" class="center">
                        TOP ARTIST ALBUMS                 
                    </div>
					<?php
						//require_once '/home/songabou/public_html/SevenDigital.php';
						//$sd = new SevenDigital();
						//$response = $sd->request('artist', 'search', array('q' => 'daft punk', 'sort' => 'score desc'));
						//echo var_dump($response);
						
						//$testtest = getCurlData('http://api.7digital.com/1.2/artist/search?q=pink&sort=score%20desc&oauth_consumer_key=7dteruqxmwun');
						//echo var_dump($testtest);
						
						$artistAudioJOSN = json_decode($artistAudio);

						//var_dump($artistAudioJOSN->topalbums->album);
						$count = 0;
						
						if(count($artistAudioJOSN->topalbums->album) > 1) {
							foreach ($artistAudioJOSN->topalbums->album as &$artistTopAlbum) {	
								if($artistTopAlbum->name != "" and $artistTopAlbum->name !== NULL) {
									$artistAlbumsHtml .= '<div id="suggestedArtist-' . $artistTopAlbum->mbid  . '" class="left suggestedArtistAlbum">';
										$artistAlbumsHtml .= '<div class="albumDetails left">';
											$artistAlbumsHtml .= '<div class="songItemImg left">';
												if($artistTopAlbum->image[1]->{'#text'} != "") {
													$artistAlbumsHtml .= '<img src="' . $artistTopAlbum->image[1]->{'#text'} . '" height="60" width="60">';
												} else {
													$artistAlbumsHtml .= '<img src="/images/noSGcover.png" height="60" width="60">';
												}
											$artistAlbumsHtml .= '</div>'; 
											$artistAlbumsHtml .= '<div class="songItemTitle left">';
												$artistAlbumsHtml .= $artistTopAlbum->name . '<br>';
											$artistAlbumsHtml .= '</div>'; 
										$artistAlbumsHtml .= '</div>'; 
										
										$albumSetList = getCurlData('http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=2b79d5275013b55624522f2e3278c4e9&artist=' .  str_replace(" ","+",$artistTopAlbum->artist->name). '&album=' . str_replace(" ","+",rawurlencode($artistTopAlbum->name)) . '&format=json');
										$albumSetListJSON = json_decode($albumSetList);
										$artistAlbumsHtml .= '<div id="artistAlbumSetList" class="left">'; 	
											$trackCount = 0;
											// The API somtimes returns multiples this code attempts to fix this. 
											$lastSongTitle = "";
											if(count($albumSetListJSON->album->tracks->track) > 1) {
												foreach ($albumSetListJSON->album->tracks->track as &$albumTrack) {
													if($albumTrack->name != "" and $albumTrack->name != $lastSongTitle) {
														$lastSongTitle = $albumTrack->name;
														$cleanSongString = preg_replace("~[\\\\/:*?'().<>|]~","",str_replace(" ","-",$albumTrack->name));
														$cleanArtistString = preg_replace("~[\\\\/:*?'()<>|]~","",str_replace(" ","-",$artistProfile["name"]));	
														$trackCount++;
														$artistAlbumsHtml .= '<div class="artistAlbumTrack left">';
															$artistAlbumsHtml .= '<div class="playButton left" onclick="">';
																 $artistAlbumsHtml .='<a href="/artist/' .  str_replace("+","-",urlencode($artistProfile["name"])) . '/song/' .  str_replace("+","-",urlencode($albumTrack->name)) . '"><img src="/images/buttons/playButton.png" height="27" width="27" border="0"></a>';
															$artistAlbumsHtml .= '</div>';
															$artistAlbumsHtml .= '<div class="albumTrackItemTitle left">';
																$artistAlbumsHtml .= $trackCount . ') <a href="/artist/' .  str_replace("+","-",urlencode($cleanArtistString)) . '/song/' .  str_replace("+","-",urlencode($cleanSongString)) . '">' . $albumTrack->name . '</a>';
															$artistAlbumsHtml .= '</div>';									
														$artistAlbumsHtml .= '</div>'; 
													}
												}
											} else {
												// Single	
$artistAlbumsHtml .= '<div class="artistAlbumTrack left">';
												$artistAlbumsHtml .= '<div class="playButton left" onclick="">';
													 $artistAlbumsHtml .='<a href="/artist/' .  str_replace("+","-",urlencode($artistProfile["name"])) . '/song/' .  str_replace("+","-",urlencode($albumSetListJSON->album->tracks->track->name)) . '"><img src="/images/buttons/playButton.png" height="27" width="27" border="0"></a>';
												$artistAlbumsHtml .= '</div>';
												$artistAlbumsHtml .= '<div class="albumTrackItemTitle left">';
													$artistAlbumsHtml .= '1) <a href="/artist/' .  str_replace("+","-",urlencode($artistProfile["name"])) . '/song/' .  str_replace("+","-",urlencode($albumSetListJSON->album->tracks->track->name)) . '">' . $albumSetListJSON->album->tracks->track->name . '</a>';
												$artistAlbumsHtml .= '</div>';									
											$artistAlbumsHtml .= '</div>'; 												
											}
											$artistAlbumsHtml .= '<span class="clear"></span>'; 
										$artistAlbumsHtml .= '</div>'; 	
										$artistAlbumsHtml .= '<span class="clear"></span>'; 								 
									$artistAlbumsHtml .= '</div>';	
									$count++;
									if($count >= 80) {
										break;	
									}	
								}
							}
						} else {
							$artistAlbumsHtml .= '<div id="suggestedArtist-' . $artistAudioJOSN->topalbums->album->mbid  . '" class="left suggestedArtistAlbum">';
								$artistAlbumsHtml .= '<div class="albumDetails left">';
									$artistAlbumsHtml .= '<div class="songItemImg left">';
										if($artistAudioJOSN->topalbums->album->image[1]->{'#text'} != "") {
											$artistAlbumsHtml .= '<img src="' . $artistAudioJOSN->topalbums->album->image[1]->{'#text'} . '" height="60" width="60">';
										} else {
											$artistAlbumsHtml .= '<img src="/images/noSGcover.png" height="60" width="60">';
										}
									$artistAlbumsHtml .= '</div>'; 
									$artistAlbumsHtml .= '<div class="songItemTitle left">';
										$artistAlbumsHtml .= $artistAudioJOSN->topalbums->album->name . '<br>';
									$artistAlbumsHtml .= '</div>'; 
								$artistAlbumsHtml .= '</div>'; 
								
								// fixes & issue issue 
								$albumSetList = getCurlData('http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=2b79d5275013b55624522f2e3278c4e9&artist=' .  str_replace(" ","+",$artistAudioJOSN->topalbums->album->artist->name). '&album=' . str_replace(" ","+",rawurlencode($artistAudioJOSN->topalbums->album->name)) . '&format=json');						
								$albumSetListJSON = json_decode($albumSetList);
								$artistAlbumsHtml .= '<div id="artistAlbumSetList" class="left">'; 	
									$trackCount = 0;
									if(is_array($albumSetListJSON->album->tracks->track)) {
										foreach ($albumSetListJSON->album->tracks->track as &$albumTrack) {
											$trackCount++;
											$artistAlbumsHtml .= '<div class="artistAlbumTrack left">';
												$artistAlbumsHtml .= '<div class="playButton left" onclick="">';
													 $artistAlbumsHtml .='<a href="/artist/' .  str_replace("+","-",urlencode($artistProfile["name"])) . '/song/' .  str_replace("+","-",urlencode($albumTrack->name)) . '"><img src="/images/buttons/playButton.png" height="27" width="27" border="0"></a>';
												$artistAlbumsHtml .= '</div>';
												$artistAlbumsHtml .= '<div class="albumTrackItemTitle left">';
													$artistAlbumsHtml .= $trackCount . ') <a href="/artist/' .  str_replace("+","-",urlencode($artistProfile["name"])) . '/song/' .  str_replace("+","-",urlencode($albumTrack->name)) . '">' . $albumTrack->name . '</a>';
												$artistAlbumsHtml .= '</div>';									
											$artistAlbumsHtml .= '</div>'; 
										}
									} else {									
										$artistAlbumsHtml .= '<div class="artistAlbumTrack left">';
											$artistAlbumsHtml .= '<span style="padding-top: 12px; font-weight: 900; font-size: 15px; padding-left: 17px; float:left;">Tracklist not available yet.</span>';
										$artistAlbumsHtml .= '</div>';										
									}
				
									$artistAlbumsHtml .= '<span class="clear"></span>'; 
								$artistAlbumsHtml .= '</div>'; 	
								$artistAlbumsHtml .= '<span class="clear"></span>'; 								 
							$artistAlbumsHtml .= '</div>';	
						}
						echo $artistAlbumsHtml; 					
					?>                    
                </div>
                 <span class="clear"></span>
            </div>                		
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
    <script src="/scripts/soundmanager/soundmanager2.js"></script>
    <script src="/scripts/soundmanager/songabout-hook.js"></script>
    <div id="artistVideoPop" <?php if(isset($SongAboutArtistObj) and $SongAboutArtistObj->youtube_video_emb != "") { echo 'class="sgEmbedVideo"'; } ?> >   
    	<?php if(isset($SongAboutArtistObj) and $SongAboutArtistObj->youtube_video_emb != "") { ?>
			<div><?php echo $SongAboutArtistObj->youtube_video_emb ?></div>
		<?php } else { ?>
			 <img src="/images/noSGcover.png" width="125" height="125" style="float:left;"/>
            <div style="float:float:left; margin-left:15px; height:125px; width: 229px; font-size: 14px;">Artist has yet to add a video.</div>			
		<?php } ?>
        
    </div>   
<?php 	include 'includes/footer.php'; ?>
<?php
	/*file_put_contents($cache_filename, ob_get_contents());  
	ob_end_flush();*/
?>