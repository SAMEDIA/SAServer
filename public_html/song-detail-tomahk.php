<?php
	$cache_time = 3600 * 12; // Time in seconds to keep a page cached  
	$cache_folder = '/home/songabou/public_html/cache/songs/'; // Folder to store cached files (no trailing slash)  
	$cache_filename = $cache_folder.md5($_SERVER['REQUEST_URI']); // Location to lookup or store cached file  
	//Check to see if this file has already been cached  
	// If it has get and store the file creation time  
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
	}

	require_once '../songabout_lib/models/SongAboutMeaningPiece.php';	
	require_once '../songabout_lib/models/SongAboutUser.php';
	require_once '../songabout_lib/models/UserFacebook.php';	
	require_once '../songabout_lib/models/SongAboutArtist.php';	
	require_once '../songabout_lib/models/SongAboutVerifiedArtist.php';	
	require_once '../songabout_lib/models/SongAboutArtistStore.php';	

	session_start();
	
	$pageTitle = "SongAbout.FM | Discover what a song is about - Artist Bio";
	$page = "song-detail";
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
	} else {
		$artistName = "";
	}
	
	if(isset($_GET["songID"])) {
		$songID = $_GET["songID"];
	} 
	
	if(isset($_GET["songName"])) {
		$songName = $_GET["songName"];
	} 	

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
		$artistNameReplace = array('Avicii' => 'Tim Bergling');
		if(isset($artistNameReplace[$artistProfile["name"]])) {
			$artistSearchStringLastFM = str_replace(" ","+",$artistNameReplace[$artistProfile["name"]]);
		} else {
			$artistSearchStringLastFM = str_replace(" ","+",$artistProfile["name"]);
		}
		
		$artistSearchString = str_replace(" ","+",$artistProfile["name"]);
		$songSearchString = str_replace(" ","+",$songName);
		$songSearchStringLastFM = str_replace("-","+",$songSearchString);
		
		/*
		$songDetailInfo = getCurlData('http://ws.audioscrobbler.com/2.0/?method=track.search&artist=' . $artistSearchStringLastFM .'&track='. $songSearchStringLastFM .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=1');
		$songDetailInfoJSON = json_decode($songDetailInfo);
		*/
		
		/*
		$songPreview = getCurlData('http://developer.echonest.com/api/v4/song/search?api_key='. $echoNestAPIKey .'&format=json&results=1&artist='. $artistSearchString  .'&title=' . $songSearchString  . '&bucket=id:7digital-US&bucket=tracks');
		$songPreviewJSON = json_decode($songPreview);
		*/
		$artistSimilar = $artistDetail->getSimilar('5', '5', '0', array("images"), '1.0', '0.0', '1.0',  '0.0','false', 'false', NULL);
		/*if(isset($songPreviewJSON->response->songs[0]->id)) {
			$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => $songPreviewJSON->response->songs[0]->id, 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		} else {
			$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => 'SORMQAA135C3593DCB', 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		}*/
		
		$songLyrics = getCurlData('http://test.lyricfind.com/api_service/lyric.do?apikey=d8a05b1cf5bd9e2a5761abf57543b013&reqtype=default&trackid=artistname:' . $artistSearchString .',trackname:'. $songSearchString .'&output=json&useragent=X');
				
		$songLyricsJSON = json_decode($songLyrics);	
		$SongAboutArtistObj = new SongAboutArtist($artistProfile["name"]);		
		$SongAboutArtistStoreObj = new SongAboutArtistStore(strtolower($artistProfile["name"]));
	} else {
		// Add redirect code
	}
?>
<?php 	include 'includes/header.php'; ?>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
			<div id="" class="left col-1"> 
                <?php 	//include 'includes/sidebar-suggested-songs.php'; ?>           
                
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
                    	<?php echo strtoupper($artistProfile["name"]); ?>
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
                    	<div class="left" id="buttonToMusic"><a href="/~songabou/artist/<?php echo $artistName ?>"></a></div>
                        <div class="left" id="buttonClaimPage"><a href="#"></a></div>
                        <div class="left" id="buttonArtistBio"><a href="/~songabou/artist/<?php echo $artistName ?>/bio"></a></div>
                        <input type="hidden" name="artistNameInput" value="<?php echo $artistName ?>" />
                    </div>       
                </div>
                <br />
                <?php //if(0 == 0) { ?>
                    <div id="songPlayerWrapper" class="left">
                    	<div id="songPlayerSongDetails"> 
                            <div id="songPlayerCoverImg" class="songPlayerCoverImg left">
								<?php
								 // Removed per new song preview addition kept just in case that new preview fails
								 /* if(isset($songDetailInfoJSON->results->trackmatches->track->image[1]) && $songDetailInfoJSON->results->trackmatches->track->image[1]->{'#text'} != "") {
                                    echo '<img src=" ' . $songDetailInfoJSON->results->trackmatches->track->image[1]->{'#text'} .'" height="125" width="125" border="0">';
                                } else {
                                    echo '<img src="http://utah.stormfrontproductions.net/~songabou/images/noSGcover.png" height="125" width="125" border="0">';
                                } */?> 
                                <img src="http://utah.stormfrontproductions.net/~songabou/images/noSGcover.png" height="125" width="125" border="0">                      
                            </div>
                            <?php
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
                    	
                            <div class="songPlayerAction left">
                                <div class="songPlayerSongTitle left">
                                    <?php echo  strtoupper(str_replace("-"," ",$songName)); ?> 
                                </div>
                                <div class="songPlayerSongActionArea left">
									<?php /* Taking out but saving just in case other song preview dies out.
                                    <div id="playerPlayButton" class="playerPlay left"><a href="#" onclick="playPreviewSong('<?php echo $songPreviewJSON->response->songs[0]->tracks[0]->preview_url ?>'); return false;"><img src="http://utah.stormfrontproductions.net/~songabou/images/buttons/buttonPlayPlayer.png" height="11" width="7" border="0"></a></div>
                                    <div id="playerPauseButton" class="playerPause left"><a href="#" onclick="pausePreviewSong(); return false;"><img src="http://utah.stormfrontproductions.net/~songabou/images/buttons/buttonPausePlayer.png" height="11" width="7" border="0"></a></div>
									*/ ?>
                                </div>
                                
                                
                                </code></pre>
                                
                                <div id="controls" style="display:none;">
                                    <!---<button onclick="track.play()">track.play()</button>
                                    <button onclick="track.play('SoundCloud')">track.play('SoundCloud')</button> --->                         
                                </div>
                                <div id="log"></div>
                                
                                <div id="player"></div>
                                
                                
                                
                            </div>
                        </div>
                        <div class="songPlayerFooterMenu left">
                            <?php 
								if($isVerifiedForPage) {
									echo'<div class="left" id="buttonEditPlayVideo"><a href="#"></a></div>';
								} else {
									echo'<div class="left" id="buttonPlayVideo"><a href="#"></a></div>';
								}
							?>
                            
                            <div class="right" id="buttonBuySong"><a href="#"></a></div>
                            <?php if(isset($SongAboutArtistStoreObj) and $SongAboutArtistStoreObj->artist_store_url != "") { ?>
								<div class="right" id="buttonBuyRingtone"><a href="<?php echo $SongAboutArtistStoreObj->artist_store_url; ?>" target="_blank"></a></div>
								
							<?php } ?>
                        </div>
                        
                        <div id="songDetailLyrics" class="left">
                            <div id="songDetailLyricsTitle" class="left">  
                            	
								<?php 
									
									$songPieces = explode('<br />', nl2br($songLyricsJSON->track->lyrics));
									//echo nl2br($songLyricsJSON->track->lyrics);
									$count = 0;
									$songPiecesHtml ="";								
									
									if(isset($songLyricsJSON->track->amg) && $songLyricsJSON->track->amg != "") {
										$songMeaningsObj = new SongAboutMeaningPiece();
										$songMeaningsArray = $songMeaningsObj->fetchAllBySong($songLyricsJSON->track->amg);
									}
									
									// Makes sure there are actual lyrics not a null songs should have more then 2 lyrics
									//$songPiecesHtml .= '<div style="font-family: HelveticaNeue-Light, Helvetica Neue Light, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif; font-weight: 200; font-size: 15px; float: left;"><a href="http://www.lyricfind.com"><span class="slink">Lyrics Provided by LyricFind</span></a>&nbsp;<a href="lyrics_terms.asp?lyricprovider=lyricfind" rel="nofollow">Terms</a></div><br>';
									if(count($songPieces) >= 2) {																														
										foreach ($songPieces as &$songPiece) {
											$count++;
											$songPiecesHtml .= '<div id="songPiece-' . $count . '" class="songPiece">';
												if($songPiece == "\n" || $songPiece == "\n\r" || $songPiece == "\r\n" || strlen($songPiece) == 0) {
													$songPiecesHtml .= '<br>';
												} else {
													$songPiecesHtml .=  '<span>' . $songPiece . '</span>';
												}
												$songPiecesHtml .= '<div id="songPiece-' . $count . 'PopUp" class="songPiecePopUp">';
													$songPiecesHtml .= '<span class="songPieceLyricPop" class="left">"' . trim($songPiece) . '"</span>';
													
													if($isVerifiedForPage) {
															$songPiecesHtml .= '<textarea cols="10" rows="4" class="songPieceInput" id="songPieceInput-' . $count . '">';
																if(isset($songMeaningsArray[$count]) && $songMeaningsArray[$count] != "") {
																	$songPiecesHtml .= $songMeaningsArray[$count]->meaning_text;
																} else {
																	$songPiecesHtml .= 'Meaning yet to be entered';
																}
															
															$songPiecesHtml .= '</textarea>';
															$songPiecesHtml .= '<div class="right" id="buttonClaimSubmit"><a href="#"  onclick="meaningSubmit(\'songPiece-' . $count . '\', ' . $count . ', ' . $songLyricsJSON->track->amg . '); return false;"></a></div>';
													} else {
														if(isset($songMeaningsArray[$count]) && $songMeaningsArray[$count] != "") {
															$songPiecesHtml .= '<span class="songPieceLyricMeaningPop" class="left">' . $songMeaningsArray[$count]->meaning_text . '</span>';
														} else {
															$songPiecesHtml .= '<span class="songPieceLyricMeaningPop" class="left">Meaning yet to be entered</span>';
														}
													}
												$songPiecesHtml .= '</div>';
											$songPiecesHtml .= '</div>';
										}									
										if($isVerifiedForPage) {
											$songPiecesHtml .= '<script language="javascript">';
												$songPiecesHtml .= 'function meaningSubmit(songPiece, songPieceNum, songId) {';
													//$songPiecesHtml .= "alert($('#songPieceInput-' + songPieceNum).val());";
													$songPiecesHtml .= "var songMeaningtxt = $('#songPieceInput-' + songPieceNum).val();";
													$songPiecesHtml .= '$.ajax({';
													  $songPiecesHtml .= 'url: "http://utah.stormfrontproductions.net/~songabou/ajax/claimItSongAjax.php",';
													  $songPiecesHtml .= 'type: "POST", ';
													  $songPiecesHtml .= 'data: { artistID: ' . $SongAboutArtistObj->artist_id . ', songPiece : songPiece, songPieceNum: songPieceNum, songId: songId, songMeaning: songMeaningtxt }';
													$songPiecesHtml .= '});';
												$songPiecesHtml .= '} ';
											$songPiecesHtml .= '</script>';
										} 
									} else {
										$songPiecesHtml .= '<div>Lyrics are not yet available for this song.</div>';
									}
									echo $songPiecesHtml;
								?>                
                            </div>                            
                        </div>                        
                        <span class="clear"></span>
                    </div>
                    <?php /* <center><a href="http://www.lyricfind.com"><span class="slink">Lyrics Provided by LyricFind</span></a>&nbsp;<a href="lyrics_terms.asp?lyricprovider=lyricfind" rel="nofollow">Terms</a></center><br>
                } else { ?>
					<div id="songPlayerWrapper" class="left" style="height: 40px; padding-left: 20px; padding-bottom:19px;">
                    	<h3>No song details at this time.</h3>
					</div>
				<?php } */?>
                
                <div id="songDetailComments" class="left">
					<div id="songDetailCommentsTitle" class="left">  
                        Leave Comments                 
                    </div>
                    <div id="songDetailCommentFB">
                    	<div class="fb-comments" data-href="http://utah.stormfrontproductions.net/~songabou/artist/<?php echo $artistName ?>/song/<?php echo $songName ?>" data-width="600"></div>
                    </div>
                </div>
                <span class="clear"></span>                
            </div>                		
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
    <script src="http://utah.stormfrontproductions.net/~songabou/scripts/soundmanager/soundmanager2.js"></script>
    <script src="http://utah.stormfrontproductions.net/~songabou/scripts/soundmanager/songabout-hook.js"></script>
    <script src="http://toma.hk/api.js?v=1"></script>
	<script>
	var playerEl = document.getElementById("songPlayerCoverImg");
	var track;	
	renderTrack = function() {
		track = window.tomahkAPI.Track("<?php echo str_replace("-"," ",$songName) ?>","<?php echo $artistProfile["name"] ?>", {
			width: 125,
			height: 125,
			disabledResolvers: [
				"Youtube",
				"Exfm"
				// options: "SoundCloud", "Officialfm", "Lastfm", "Jamendo", "Youtube", "Rdio", "SpotifyMetadata", "Deezer", "Exfm"
			],
			handlers: {
				onloaded: function() {
					console.log(track.connection+":\n  api loaded");
				},
				onended: function() {
					console.log(track.connection+":\n  Song ended: "+track.artist+" - "+track.title);
				},
				onplayable: function() {
					console.log(track.connection+":\n  playable");
				},
				onresolved: function(resolver, result) {
					console.log(track.connection+":\n  Track found: "+resolver+" - "+ result.track + " by "+result.artist);
					$('#songPlayerCoverImg').children('img').hide();
				},
				ontimeupdate: function(timeupdate) {
					var currentTime = timeupdate.currentTime;
					var duration = timeupdate.duration;
					currentTime = parseInt(currentTime);
					duration = parseInt(duration);
		
					console.log(track.connection+":\n  Time update: "+currentTime + " "+duration);
				}
			}
		});
		playerEl.appendChild(track.render());
	}
    </script>    
    <div id="artistVideoPop" <?php if(isset($SongAboutArtistObj) and $SongAboutArtistObj->youtube_video_emb != "") { echo 'class="sgEmbedVideo"'; } ?> >   
    	<?php if(isset($SongAboutArtistObj) and $SongAboutArtistObj->youtube_video_emb != "") { ?>
			<div><?php echo $SongAboutArtistObj->youtube_video_emb ?></div>
		<?php } else { ?>
			 <img src="http://utah.stormfrontproductions.net/~songabou/images/noSGcover.png" width="125" height="125" style="float:left;"/>
            <div style="float:left; margin-left:15px; height:125px; width: 229px; font-size: 14px;">Artist has yet to add a video.</div>			
		<?php } ?>
        
    </div>     
<?php 	include 'includes/footer.php'; ?>
<?php
	file_put_contents($cache_filename, ob_get_contents());  
	ob_end_flush();
?>