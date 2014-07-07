<?php
	$cache_time = 3600; // Time in seconds to keep a page cached  
	$cache_folder = '/home/songabou/public_html/cache/albums/'; // Folder to store cached files (no trailing slash)  
	$cache_filename = $cache_folder.md5($_SERVER['REQUEST_URI']); // Location to lookup or store cached file  
	//Check to see if this file has already been cached  
	// If it has get and store the file creation time  
	$cache_created  = (file_exists($cache_file_name)) ? filemtime($this->filename) : 0;  
	 
	if ((time() - $cache_created) < $cache_time) {  
	 readfile($cache_filename); // The cached copy is still valid, read it into the output buffer  
	 die();  
	}  else {
		ob_start();
	}

	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "album-detail";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '/home/songabou/lib/EchoNest/Autoloader.php';
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
	
	if(isset($_GET["albumName"])) {
		$albumName = $_GET["albumName"];
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
		$artistSearchString = str_replace("-","+",$artistSearchString);
		$albumSearchString = str_replace(" ","+",$albumName);
		$albumSearchString = str_replace("-","+",$albumSearchString );
		
		$artistSimilar = $artistDetail->getSimilar('5', '5', '0', array("images"), '1.0', '0.0', '1.0',  '0.0','false', 'false', NULL);
		$artistAlbum = getCurlData('http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=2b79d5275013b55624522f2e3278c4e9&artist=' . $artistSearchString .'&album=' . $albumSearchString .'&format=json');
		$artistAlbumJSON = json_decode($artistAlbum);
		if(isset($artistProfile["id"])) {
			$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('artist_id' => $artistProfile["id"], 'results' => '5', 'type' => 'artist-radio', 'bucket' => array("id:7digital-US", "tracks")));
		} else {
			$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => 'SORMQAA135C3593DCB', 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		}
	} else {
		// Add redirect code
	}

?>
<?php 	include '/home/songabou/www/includes/header.php'; ?>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
			<div id="" class="left col-1"> 
                <?php 	include '/home/songabou/www/includes/sidebar-suggested-songs.php'; ?>           
                
                <?php 	include '/home/songabou/www/includes/sidebar-suggested-artist.php'; ?> 		
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
								echo '<img src="/~songabou/images/noSGcover.png" height="125" width="125" border="0">';
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
                       <span style="font-size:12px; font-weight: 200;">
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
                       </span>
                    </div>
                    <div class="artistItemDetailMenu left">
                        <div class="right" id="buttonArtistBio"><a href="/~songabou/artist/<?php echo $artistSearchString ?>/bio"></a></div>
                        <div class="right" id="buttonClaimPage"><a href="#"></a></div>
                       	<input type="hidden" name="artistNameInput" value="<?php echo $artistName ?>" />
                    </div>        
                </div>
                
                <br />
                
                <div id="artistDetailSongs">
					<?php
						//require_once '/home/songabou/public_html/SevenDigital.php';
						//$sd = new SevenDigital();
						//$response = $sd->request('artist', 'search', array('q' => 'daft punk', 'sort' => 'score desc'));
						//echo var_dump($response);
						
						//$testtest = getCurlData('http://api.7digital.com/1.2/artist/search?q=pink&sort=score%20desc&oauth_consumer_key=7dteruqxmwun');
						//echo var_dump($testtest);

						//var_dump($artistAlbumJSON->topalbums->album);
						$count = 0;
						//echo var_dump($artistAlbumJSON);
						//foreach ($artistAlbumJSON->album as &$artistTopAlbum) {
							if($artistAlbumJSON->album->image[1]->{'#text'} != "") {
								$artistAlbumsHtml .= '<div id="suggestedArtist-' . $artistAlbumJSON->album->mbid  . '" class="left">';
									$artistAlbumsHtml .= '<div class="albumDetails left">';
										$artistAlbumsHtml .= '<div class="songItemImg left">';
											if(url_exists($artistAlbumJSON->album->image[1]->{'#text'})) {
												$artistAlbumsHtml .= '<img src="' . $artistAlbumJSON->album->image[1]->{'#text'} . '" height="60" width="60">';
											} else {
												$artistAlbumsHtml .= '<img src="/~songabou/images/noSGcover.png" height="60" width="60" border="0">';
											} 
										$artistAlbumsHtml .= '</div>'; 
										$artistAlbumsHtml .= '<div class="songItemTitle left">';
											$artistAlbumsHtml .= $artistAlbumJSON->album->name . '<br>';
										$artistAlbumsHtml .= '</div>'; 
									$artistAlbumsHtml .= '</div>'; 

									$artistAlbumsHtml .= '<div id="artistAlbumSetList" class="left">'; 	
										$trackCount = 0;
										if(isset($artistAlbumJSON->album->tracks->track)) {
											foreach ($artistAlbumJSON->album->tracks->track as &$albumTrack) {
												$trackCount++;
												$artistAlbumsHtml .= '<div class="artistAlbumTrack left">';
													$artistAlbumsHtml .= '<div class="playButton left">';
														$artistAlbumsHtml .='<a href="/~songabou/artist/' .  str_replace("+","-",urlencode($artistProfile["name"])) . '/song/' .  str_replace("+","-",urlencode($albumTrack->name)) . '"><img src="http://www.songabout.fm/images/buttons/playButton.png" height="27" width="27" border="0"></a>';;
													$artistAlbumsHtml .= '</div>';
													$artistAlbumsHtml .= '<div class="albumTrackItemTitle left">';
														$artistAlbumsHtml .= $trackCount . ') <a href="/~songabou/artist/' .  str_replace("+","-",urlencode($artistProfile["name"])) . '/song/' .  str_replace("+","-",urlencode($albumTrack->name)) . '">' . $albumTrack->name . '</a>';
													$artistAlbumsHtml .= '</div>';									
												$artistAlbumsHtml .= '</div>'; 
											}
											$artistAlbumsHtml .= '<span class="clear"></span>'; 
										} else {
											$artistAlbumsHtml .= '<div class="artistAlbumTrack left">';
												$artistAlbumsHtml .= '<div class="albumTrackItemTitle left">';
													$artistAlbumsHtml .= 'Cannot pull album information at this time.';
												$artistAlbumsHtml .= '</div>';
											$artistAlbumsHtml .= '</div>';
										}
									$artistAlbumsHtml .= '</div>'; 	
									$artistAlbumsHtml .= '<span class="clear"></span>'; 								 
								$artistAlbumsHtml .= '</div>';	
								$count++;
								if($count >= 80) {
									break;	
								}
							}										
						//}
						echo $artistAlbumsHtml; 					
					?>                    
                </div>
                 <span class="clear"></span>
            </div>                		
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
    <script src="http://www.songabout.fm/scripts/soundmanager/soundmanager2.js"></script>
    <script src="http://www.songabout.fm/scripts/soundmanager/songabout-hook.js"></script>
    <div id="artistVideoPop" <?php if(isset($SongAboutArtistObj) and $SongAboutArtistObj->youtube_video_emb != "") { echo 'class="sgEmbedVideo"'; } ?> >   
    	<?php if(isset($SongAboutArtistObj) and $SongAboutArtistObj->youtube_video_emb != "") { ?>
			<div><?php echo $SongAboutArtistObj->youtube_video_emb ?></div>
		<?php } else { ?>
			 <img src="http://www.songabout.fm/images/noSGcover.png" width="125" height="125" style="float:left;"/>
            <div style="float:float:left; margin-left:15px; height:125px; width: 229px; font-size: 14px;">Artist has yet to add a video.</div>			
		<?php } ?>
        
    </div>    
<?php 	include '/home/songabou/www/includes/footer.php'; ?>
<?php
	file_put_contents($cache_filename, ob_get_contents());  
	ob_end_flush();
?>