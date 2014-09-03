<?php 
	$pageTitle = "SongAbout.FM | Discover what a song is about - Artist Bio";
	$page = "song-detail";
	$showSearch = true;
	
	// Song Detail page Caching Objects
	$cache_time = 86400; // Time in seconds to keep a page cached
	  $cache_folder = 'cache/song/'; // Folder to store cached files (no trailing slash)  
	$cache_filename = $cache_folder.md5(str_replace("?cache=true", "", $_SERVER['REQUEST_URI'])); // Location to lookup or store cached file  
	//Check to see if this file has already been cached  
	// If it has get and store the file creation time  
?>
<?php include 'includes/headertest.php'; ?>
<?php	
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
	
	/*if ((time() - $cache_created) < $cache_time) {  
	 readfile($cache_filename); // The cached copy is still valid, read it into the output buffer  
	 die();
	} else {	
		ob_start("sanitize_output");
	}*/

	//ob_start("sanitize_output");

	require_once '../songabout_lib/models/SongAboutMeaningPiece.php';	
	require_once '../songabout_lib/models/SongAboutUser.php';
	require_once '../songabout_lib/models/UserFacebook.php';	
	require_once '../songabout_lib/models/SongAboutArtist.php';	
	require_once '../songabout_lib/models/SongAboutVerifiedArtist.php';	
	require_once '../songabout_lib/models/SongAboutArtistStore.php';

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
		
		$artistSimilar = $artistDetail->getSimilar('5', '5', '0', array("images"), '1.0', '0.0', '1.0',  '0.0','false', 'false', NULL);
		/*if(isset($songPreviewJSON->response->songs[0]->id)) {
			$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => $songPreviewJSON->response->songs[0]->id, 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		} else {
			$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => 'SORMQAA135C3593DCB', 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		}*/
		
		$songLyrics = getCurlData('http://test.lyricfind.com/api_service/lyric.do?apikey=7500cc6251b190a18374131c56a0b7f2&reqtype=default&trackid=artistname:' . $artistSearchString .',trackname:'. $songSearchString .'&output=json&useragent=' . $_SERVER['HTTP_USER_AGENT']);
						
		$songLyricsJSON = json_decode($songLyrics);	
		$SongAboutArtistObj = new SongAboutArtist($artistProfile["name"]);		
		$SongAboutArtistStoreObj = new SongAboutArtistStore(strtolower($artistProfile["name"]));
	} else {
		// Add redirect code
	}	
?>
<style>
	#songPlayer div {
		position: relative;
		display: block;
	}
	@media (min-width: 800px) {
		#songPlayer {
			top: 100px;
		}
	}
	@media (max-width: 800px) {
		#songPlayer {
			top: 150px;
		}
	}
	#songPlayer {
		border: none;
		background: transparent;
	}
</style>
<div id="songPlayer" class = "navbar navbar-inverse navbar-fixed-top">
	<div class="col-md-2 col-sm-0 col-xs-12"></div>
	<div class="col-md-8 col-sm-12 col-xs-12"><a class="" id="songPlayerCoverImgPlayer" data-width="100%" data-bop-link href="http://www.bop.fm/embed/<?php echo $artistName ?>/<?php echo $songName ?>"><?php echo $artistName ?> - <?php echo $songName ?></a> </div>
  <div class="col-md-2 col-sm-0 col-xs-12"></div>
</div>
        <script async src="http://assets.bop.fm/embed.js"></script>
        <?php
								if(isset($_SESSION['user_id'])) {
									if(isset($SongAboutArtistObj->artist_id)) {
										$songAboutVerifiedArtistObj = new SongAboutVerifiedArtist();
										$allVerifiedArtist = $songAboutVerifiedArtistObj->fetchAllVerfied(1, 30, ' and status="Verified" and sa.artist_id = ' . $SongAboutArtistObj->artist_id . ' and su.user_id= ' . $_SESSION['user_id'], $orderBySQL = "  artist_name DESC");
																				
										if(count($allVerifiedArtist)) {
											$isVerifiedForPage = true;	
										}
										
									} else {
										$isVerifiedForPage = false;	
									}
									//Admin check
									if($_SESSION['user_id'] == 8 || $_SESSION['user_id'] == 1) {
										$isVerifiedForPage = true;	
									}
								
								} else {
									$isVerifiedForPage = false;
								}

                            ?>

 <?php 
		$foundImage = false;
		foreach ($artistProfile["images"] as &$artistImage) {
			if(isset($artistImage["url"])  && url_exists($artistImage["url"])) {
				echo '<div id="artistTop" style="background-image: url(&#39;'. $artistImage["url"] .'&#39;);background-size: cover;width: 100%;background-position: 0 10%;">';
				echo '<div style="background: url(&#39;images/backgrounds/sprinkles.png&#39;);width: 100%;opacity:0.4">';
				echo '<img width="50%" class="lazy artistTopImg" data-original="' . $artistImage["url"] .'" src="'. $artistImage["url"] .'">';
				$foundImage = true;
				break;
			} 
		}														
		if(!$foundImage){
			echo '<div id="artistTop" style="background-image: url(&#39;images/notes2.jpg&#39;);background-size: cover;width: 100%;">';
			echo '<div style="background: url(&#39;images/backgrounds/sprinkles.png&#39;);width: 100%;opacity:0.4">';
			echo '<img width="35%" data-original="images/noSGcover.png" src="images/noSGcover.png">';
		}
	?>
	</div>
	 </div>

<div class="main-content" clas="" style="position: relative; top: -250px;">
  <div class="container-fluid">

    <div id="" class="left col-1">
      <?php 	//include 'includes/sidebar-suggested-artist.php'; ?>
    </div>
    <div id="col-2" class="left col-2">
      <div class="artistDetailBox">
        <div id="artistItemSocialIcons" class="right">
        	<a href="#"><img width="50px" class="lazy" data-original="images/icons/songaboutIconFB.png" src="images/icons/songaboutIconFB.png"></a>
        	<a href="#"><img width="50px" class="lazy" data-original="images/icons/songaboutIconTwitter.png" src="images/icons/songaboutIconTwitter.png"></a>
        	<a href="#"><img width="50px" class="lazy" data-original="images/icons/songaboutIconShare.png" src ="images/icons/songaboutIconShare.png"></a>
      </div>
      <div class="artistItemDetailText">
        <h2><?php echo strtoupper($artistProfile["name"]); ?></h2>
        <br />
        <?php
						   $genreCount = 0;
						   /*
						   <span style="font-size:12px; font-weight: 200;">
						   foreach ($artistProfileGenre["genres"] as &$artisGenre) {
							   echo $artisGenre["name"];
							   $genreCount++;
							   if($genreCount > 2) {
									break;   
							   } else {
									echo ', ';   
							   }
						   }
                       </span>
 						   */?>
      </div>
      <div class="artistItemDetailMenu left">
        <div class="left" id="buttonToMusic"><a href="/artist/<?php echo $artistName ?>"></a></div>
        <div class="left" id="buttonClaimPage"><a href="#"></a></div>
        <div class="left" id="buttonArtistBio"><a href="/artist/<?php echo $artistName ?>/bio"></a></div>
        <input type="hidden" name="artistNameInput" value="<?php echo $artistName ?>" />
      </div>
    </div>
    <br />
    <?php //if(0 == 0) { ?>
    <div id="songPlayerWrapper" class="left">
      <div id="songPlayerSongDetails">
        <?php //<div id="songPlayerCoverImg" class="songPlayerCoverImg left">
								
								 // Removed per new song preview addition kept just in case that new preview fails
								 /* if(isset($songDetailInfoJSON->results->trackmatches->track->image[1]) && $songDetailInfoJSON->results->trackmatches->track->image[1]->{'#text'} != "") {
                                    echo '<img src=" ' . $songDetailInfoJSON->results->trackmatches->track->image[1]->{'#text'} .'" height="125" width="125" border="0">';
                                } else {
                                    echo '<img src="http://www.songabout.fm/images/noSGcover.png" height="125" width="125" border="0">';
                                }                     
                            </div>*/?>
        <div class="songPlayerAction left">
          <div class="songPlayerSongTitle left"> <?php echo  strtoupper(str_replace("-"," ",$songName)); ?> </div>
          <div class="songPlayerSongActionArea left">
            <?php /* Taking out but saving just in case other song preview dies out.
                                    <div id="playerPlayButton" class="playerPlay left"><a href="#" onclick="playPreviewSong('<?php echo $songPreviewJSON->response->songs[0]->tracks[0]->preview_url ?>'); return false;"><img src="http://www.songabout.fm/images/buttons/buttonPlayPlayer.png" height="11" width="7" border="0"></a></div>
                                    <div id="playerPauseButton" class="playerPause left"><a href="#" onclick="pausePreviewSong(); return false;"><img src="http://www.songabout.fm/images/buttons/buttonPausePlayer.png" height="11" width="7" border="0"></a></div>
									*/ ?>
          </div>
          </code>
          </pre>
          <?php /*<div id="controls" style="display:none;">
                                    <!---<button onclick="track.play()">track.play()</button>
                                    <button onclick="track.play('SoundCloud')">track.play('SoundCloud')</button> --->                         
                                </div>
                                <div id="log"></div>                               
                                <div id="player"></div>   */?>
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
        <?php /*<div class="right" id="buttonBuySong"><a href="#"></a></div> */ ?>
        <?php if(isset($SongAboutArtistStoreObj) and $SongAboutArtistStoreObj->artist_store_url != "") { ?>
        <div class="right" id="buttonBuyShirt"><a href="<?php echo $SongAboutArtistStoreObj->artist_store_url; ?>" target="_blank"></a></div>
        <?php } ?>
      </div>
      <?php
							$songPieces = explode('<br />', nl2br($songLyricsJSON->track->lyrics));
							$count = 0;
							$songPiecesHtml ="";								
							
							if(isset($songLyricsJSON->track->amg) && $songLyricsJSON->track->amg != "") {
								$songMeaningsObj = new SongAboutMeaningPiece();
								$songMeaningsArray = $songMeaningsObj->fetchAllBySong($songLyricsJSON->track->amg);
							}						
						?>
      <div id="songDetailLyrics" class="left">
        <div id="songDetailLyricsTextArea">
          <?php if($isVerifiedForPage) { ?>
          <textarea cols="65" rows="8" id="songPieceInput-0" name="songMeaningTextArea" placeholder="Enter Song Meaning"><?php if($songMeaningsArray[0] != "") { echo $songMeaningsArray[0]->meaning_text;}?>
</textarea>
          <div class="right" id="buttonClaimSubmit"><a href="#"  onclick="meaningSubmit('songPiece-0', 0, '<?php echo $songLyricsJSON->track->amg ?>'); return false;"></a></div>
          <?php } else if($songMeaningsArray[0] != "") { ?>
          <div id="songLyric-0" class="songLyricItem left songLyricItemBox"><?php echo $songMeaningsArray[0]->meaning_text; ?></div>
          <?php } else { ?>
          <div id="songLyric-0" class="songLyricItem left songLyricItemBox">No song meaning at this time.</div>
          <?php } ?>
          <span class="clear"></span> </div>
        <div id="songDetailLyricsTitle" class="left">
          <?php 
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
													$songPiecesHtml .= '<span class="songPieceLyricPop">"' . trim($songPiece) . '"</span>';										
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
												$songPiecesHtml .= '</div></div>';
										}									
										if($isVerifiedForPage) {
											$songPiecesHtml .= '<script language="javascript">';
												$songPiecesHtml .= 'function meaningSubmit(songPiece, songPieceNum, songId) {';
													$songPiecesHtml .= "var songMeaningtxt = $('#songPieceInput-' + songPieceNum).val();";
													$songPiecesHtml .= '$.ajax({url: "/ajax/claimItSongAjax.php",type: "POST", data: { artistID: ' . $SongAboutArtistObj->artist_id . ', songPiece : songPiece, songPieceNum: songPieceNum, songId: songId, songMeaning: songMeaningtxt }, success: function(){window.location.href += "?cache=true";}});';
												$songPiecesHtml .= '} ';
											$songPiecesHtml .= '</script>';
										} 
									} else {
										$songPiecesHtml .= '<div>Lyrics are not yet available for this song.</div>';
									}
									echo $songPiecesHtml;
								?>
          <?php if(isset($songLyricsJSON->track->writer)): ?>
          <br>
          <strong>Song Writer</strong>: <br>
          <?php echo $songLyricsJSON->track->writer; ?>
          <?php endif; ?>
          <?php if(isset($songLyricsJSON->track->copyright)): ?>
          <br>
          <strong>Copyright</strong>: <br>
          <?php echo $songLyricsJSON->track->copyright; ?>
          <?php endif; ?>
          <br>
          Lyrics licensed by <a href="http://www.lyricfind.com/licensing/" target="_blank">lyricfind</a> </div>
      </div>
    </div>
    <?php /* <center><a href="http://www.lyricfind.com"><span class="slink">Lyrics Provided by LyricFind</span></a>&nbsp;<a href="lyrics_terms.asp?lyricprovider=lyricfind" rel="nofollow">Terms</a></center><br>
                } else { ?>
					<div id="songPlayerWrapper" class="left" style="height: 40px; padding-left: 20px; padding-bottom:19px;">
                    	<h3>No song details at this time.</h3>
					</div>
				<?php } */?>
    <div id="songComments">
      <h2>Leave Comments</h2>
      <div class="fb-comments" data-href="http://www.songabout.fm/artist/<?php echo $artistName ?>/song/<?php echo $songName ?>" data-width="600"></div>
    </div>
<script src="http://www.songabout.fm/scripts/soundmanager/soundmanager2.js"></script> 
<script src="http://www.songabout.fm/scripts/soundmanager/songabout-hook.js"></script>
<div id="artistVideoPop" <?php if(isset($SongAboutArtistObj) and $SongAboutArtistObj->youtube_video_emb != "") { echo 'class="sgEmbedVideo"'; } ?> >
  <?php if(isset($SongAboutArtistObj) and $SongAboutArtistObj->youtube_video_emb != "") { ?>
  <div><?php echo $SongAboutArtistObj->youtube_video_emb ?></div>
  <?php } else { ?>
  <img src="http://www.songabout.fm/images/noSGcover.png" width="125" height="125" style="float:left;"/>
  <div style="float:left; margin-left:15px; height:125px; width: 229px; font-size: 14px;">Artist has yet to add a video.</div>
  <?php } ?>
</div>
<?php
	file_put_contents($cache_filename, sanitize_output(ob_get_contents())); 
?>
</div>
</div>
<?php include 'includes/footertest.php'; ?>
<?php
	//ob_end_flush();
?>
