<?
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
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
	
	if(isset($_GET["search"])) {
		$currentSearchString = str_replace(" ","+",$_GET["search"]);
		$currentSearchStringEchonest = str_replace(" ","-",$_GET["search"]);
	} else if(isset($_POST["search"])) {
		$currentSearchString = str_replace(" ","+",$_POST["search"]);
		$currentSearchStringEchonest = str_replace(" ","-",$_POST["search"]);
	} 
	
	if(isset($currentSearchString)) {

		$artistSearchResults = getCurlData('http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=' . $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=10');
		$artistSearchResultsJSON = json_decode($artistSearchResults);
		// If artist search does not return results loop through the search string spaces to find artist
		if(isset($artistSearchResultsJSON->results->{'opensearch:totalResults'}) && is_numeric($artistSearchResultsJSON->results->{'opensearch:totalResults'}) && $artistSearchResultsJSON->results->{'opensearch:totalResults'} != 0) {
			$artistResultCount = $artistSearchResultsJSON->results->{'opensearch:totalResults'};
			//echo $artistResultCount;
		} else {
			$artistSearchStrings = explode("+", $currentSearchString);
			foreach($artistSearchStrings as $artistSearchString) {
				$artistSearchResults = getCurlData('http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=' . $artistSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=10');
				$artistSearchResultsJSON = json_decode($artistSearchResults);
				if(isset($artistSearchResultsJSON->results->{'opensearch:totalResults'}) && is_numeric($artistSearchResultsJSON->results->{'opensearch:totalResults'})) {
					$artistResultCount = $artistSearchResultsJSON->results->{'opensearch:totalResults'};
					break;	
				}
			}
		}
		
		$albumSearchResults = getCurlData('http://ws.audioscrobbler.com/2.0/?method=album.search&album=' . $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=10');
		$albumSearchResultsJSON = json_decode($albumSearchResults);
		
		$songSearchResults = getCurlData('http://ws.audioscrobbler.com/2.0/?method=track.search&track='. $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=10');
		$songSearchResultsJSON = json_decode($songSearchResults);

		
		try {
		$artistDetail = $songAboutEchonest->getArtistApi()->setName($currentSearchStringEchonest);
		//$artistProfile = $artistDetail->getProfile(array('bucket' => "images"));
		$artistSimilar = $artistDetail->getSimilar('5', '5', '0', array("images"), '1.0', '0.0', '1.0',  '0.0','false', 'false', NULL); 
		
		} 
		catch (Exception $e) {	

		}


		if(isset($artistProfile["id"])) {
			//$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('artist_id' => $artistProfile["id"], 'results' => '5', 'type' => 'artist-radio', 'bucket' => array("id:7digital-US", "tracks")));
		} else {
			//$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => 'SORMQAA135C3593DCB', 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		}
				
	} else {
		// Add redirect code
	}
?>
<? 	include '/home/songabou/www/includes/header.php'; ?>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
			<div id="" class="left col-1"> 
                <? 	include '/home/songabou/www/includes/sidebar-suggested-songs.php'; ?>           
                
                <? 	include '/home/songabou/www/includes/sidebar-suggested-artist.php'; ?> 		       		
            </div>
			<div id="col-2" class="left col-2"> 
 				<div id="artistSearchResults" class="left">
                	<div class="searchResultsTitle left">
                        ARTISTS                     
                    </div>
                    <div class="searchResultsCount right">
						                                          
                    </div>
                    <div id="artistSearchResultsList" class="clear">
						<?
							$count = 0;
							if(isset($artistResultCount) && $artistResultCount > 0) {
								foreach ($artistSearchResultsJSON->results->artistmatches->artist as &$artistSearchResultItem) {
									$currentArtistName = $artistSearchResultItem->name;
									
									if($artistResultCount == 1 and isset($artistSearchResultsJSON->results->artistmatches->artist->name)) {
										$currentArtistName = $artistSearchResultsJSON->results->artistmatches->artist->name;
									}
									if($currentArtistName != "") {
										//$ts = array("/[è-ë]/","/[ì-ï]/","/ð/","/ñ/","/[ò-öø]/","/÷/","/[ù-ü]/","/[ý-ÿ]/");
										//$tn = array("e","i","d","n","o","x","u","y");

										// first you need the convert the string to the proper charset
										//$artistSearchResultItem->name = preg_replace($ts,$tn, $artistSearchResultItem->name);
										
										// Some artist names need to be replaced
										$artistArray = array("/Beyoncee/");
										$artistArrayTrans = array("Beyonce");
										
										$currentArtistName = preg_replace($artistArray,$artistArrayTrans, $currentArtistName);
																				
										$artistResultHtml .= '<div id="suggestedArtist-' . $artistSearchResultItem->id  . '" class="left suggestedArtistItem">';
											$artistResultHtml .= '<div class="songItemImg left">';
												$artistResultHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>|]~","",$currentArtistName))) . '">';
													if($artistSearchResultItem->image[1]->{'#text'} != "") {
														$artistResultHtml .= '<img src="' . $artistSearchResultItem->image[1]->{'#text'} . '" height="60" width="60" border="0">';
													} else {
														$artistResultHtml .= '<img src="/~songabou/images/noSGcover.png" height="60" width="60" border="0">';
													}
												$artistResultHtml .= '</a>';	
											$artistResultHtml .= '</div>'; 
											$artistResultHtml .= '<div class="songItemTitle left">';
												$artistResultHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>|]~","",$currentArtistName))) . '">';
												$artistResultHtml .=  $currentArtistName . '</a><br>';
											$artistResultHtml .= '</div>';
											$artistResultHtml .= '<span class="clear"></span>'; 								 
										$artistResultHtml .= '</div>';	
										$count++;
										if($count >= 1) {
											break;	
										}
									}										
								}
								echo $artistResultHtml; 	
							} else {
								echo 'No results returned for artist';	
							}
						?>
                    </div> 
                </div>	
<div id="songSearchResults" class="left">
                	<div class="searchResultsTitle left">
                        SONGS                     
                    </div>
                    <div class="searchResultsCount right">
						<?
							if(isset($songSearchResultsJSON->results->{'opensearch:totalResults'}) && is_numeric($songSearchResultsJSON->results->{'opensearch:totalResults'})) {
								$songResultCount = $songSearchResultsJSON->results->{'opensearch:totalResults'};
								//echo $songResultCount;
							} else {
								//echo '0';	
							}
						?>  
                    </div> 
                    <div id="artistSearchResultsList" class="clear">
						<?
							$count = 0;
							if(isset($songResultCount) && $songResultCount > 0) {
								foreach ($songSearchResultsJSON->results->trackmatches->track as &$songSearchResultItem) {
									if($songSearchResultItem->image[1]->{'#text'} != "") {
										$artistSongsHtml .= '<div id="suggestedArtist-' . $songSearchResultItem->id  . '" class="left suggestedArtistItem">';
											$artistSongsHtml .= '<div class="songItemImg left">';
												$artistSongsHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>|]~","",$songSearchResultItem->artist))) . '/song/' .str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>|]~","",$songSearchResultItem->name))) . '">';
													$artistSongsHtml .= '<img src="' . $songSearchResultItem->image[1]->{'#text'} . '" height="60" width="60">';
												$artistSongsHtml .= '</a>';
											$artistSongsHtml .= '</div>'; 
											$artistSongsHtml .= '<div class="songItemTitle left">';
												$artistSongsHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>|]~","",$songSearchResultItem->artist))) . '/song/' .str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>|]~","",$songSearchResultItem->name))) . '">';
												$artistSongsHtml .= $songSearchResultItem->name . '</a><br>';
												$artistSongsHtml .= '<span class="songItemTitleFootnote">'. $songSearchResultItem->artist .'</span>';
											$artistSongsHtml .= '</div>';
											$artistSongsHtml .= '<span class="clear"></span>'; 								 
										$artistSongsHtml .= '</div>';	
										$count++;
										if($count >= 80) {
											break;	
										}
									}										
								}
								echo $artistSongsHtml; 	
							} else {
								echo 'No results returned for artist';	
							}
						?>
                    </div>
                </div>                
 				<div id="albumSearchResults" class="left">
                	<div class="searchResultsTitle left">
                       ALBUMS                 
                    </div>
                    <div class="searchResultsCount right">
						<?
							if(isset($albumSearchResultsJSON->results->{'opensearch:totalResults'}) && is_numeric($albumSearchResultsJSON->results->{'opensearch:totalResults'})) {
								$albumResultCount = $albumSearchResultsJSON->results->{'opensearch:totalResults'};
								//echo $albumResultCount;
							} else {
								//echo '0';	
							}
						?>
                    </div> 
                    <div id="artistSearchResultsList" class="clear">
						<?
							$count = 0;
							if(isset($albumResultCount) && $albumResultCount > 0) {
								foreach ($albumSearchResultsJSON->results->albummatches->album as &$artistSearchAlbumResultItem) {
									if($artistSearchAlbumResultItem->image[1]->{'#text'} != "") {
										$artistAlbumsHtml .= '<div id="suggestedArtist-' . $artistSearchAlbumResultItem->id  . '" class="left suggestedArtistItem">';				
											$artistAlbumsHtml .= '<div class="songItemImg left">';
												$artistAlbumsHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>|]~","",$artistSearchAlbumResultItem->artist))) .  '/album/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>|]~","",$artistSearchAlbumResultItem->name))) . '">';
													$artistAlbumsHtml .= '<img src="' . $artistSearchAlbumResultItem->image[1]->{'#text'} . '" height="60" width="60">';
												$artistAlbumsHtml .= '</a>';
											$artistAlbumsHtml .= '</div>'; 
											$artistAlbumsHtml .= '<div class="songItemTitle left">';
												$artistAlbumsHtml .= $artistSearchAlbumResultItem->name . '<br>';
												$artistAlbumsHtml .= '<span class="songItemTitleFootnote">'. $artistSearchAlbumResultItem->artist .'</span>';
											$artistAlbumsHtml .= '</div>';
											$artistAlbumsHtml .= '<span class="clear"></span>'; 								 
										$artistAlbumsHtml .= '</div>';	
										$count++;
										if($count >= 80) {
											break;	
										}
									}										
								}
								echo $artistAlbumsHtml; 	
							} else {
								echo 'No results returned for albums';	
							}
						?>
                    </div>
                </div>		                                				
            </div>                		
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<? 	include '/home/songabou/www/includes/footer.php'; ?>
