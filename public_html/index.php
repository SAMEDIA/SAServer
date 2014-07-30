<?php
	$cache_time = 1800; // Time in seconds to keep a page cached  
	$cache_folder = 'cache/pages/'; // Folder to store cached files (no trailing slash)  
	$cache_filename = $cache_folder.md5($_SERVER['REQUEST_URI']); // Location to lookup or store cached file  
	//Check to see if this file has already been cached  
	// If it has get and store the file creation time  
	$cache_created  = (file_exists($cache_file_name)) ? filemtime($this->filename) : 0;  
	 
	if ((time() - $cache_created) < $cache_time) {  
	 readfile($cache_filename); // The cached copy is still valid, read it into the output buffer  
	 die();  
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
			
?>
<?php 	include 'includes/header.php'; ?>
	<!-- Non animated slider but added code so that a slider can be added later -->
    <div id="songaboutSlideWrapper" class="left">
        <div id="songaboutSlideItem" class="center">
        
        </div>
        <div id="songaboutSlideSearch" class="center">
            <div id="songaboutSlideSearchMenu" class="right">
                <div id="alphaSearch">
                    <?php include 'includes/alphabetWidget.php'; ?>
                </div>
                <div id="searchBox">
                    <input type="text" id="searchSongAboutTxtHome" name="searchSongAboutTxtHome" size="38" maxlength="255">
                    <div id="searchSongButton"><a href="#"></a></div>
                </div>   
            </div>               
            <div id="songaboutSlideSearchContent" class="left;">
           		Discover what a song is all about.
            </div>                       
        </div>
    </div>	
    <div id="contentHeaderWrapper" class="grayBG left"> 
    	<div id="contentHeader" class="center">  			
			<?php
                $topAlbumArtists = $songAboutEchonest->getArtistApi()->search(array('sort' => 'hotttnesss-desc', 'results' => '25', 'bucket' => array("id:7digital-US", "reviews")));
                //echo var_dump($topAlbumArtists);
                
                $songCount = 0;
                $topAlbumHtml ="";
                $topAlbumHtml = '<div id="topAlbums" class="center">';
                    $topAlbumHtml .= '<div id="topAlbumsTitle" class="center">';
                        $topAlbumHtml .= 'FEATURED ALBUMS';
                    $topAlbumHtml .= '</div>';
						foreach ($topAlbumArtists as &$artistAlbum) {
                            //Fix to remove all symbols to keep links safe.
							if(!preg_match('/[^A-Za-z0-9]/',str_replace(" ","",$artistAlbum["reviews"][0]["release"])) && !preg_match('/[^A-Za-z0-9]/',str_replace(" ","",$artistAlbum["name"]))) {
								if($artistAlbum["reviews"][0]["image_url"] != "" && $artistAlbum["reviews"][0]["release"] !="") {
									
									//Malware Check 								
									if(!strpos($artistAlbum["reviews"][0]["image_url"], 'www.theaureview.com')) {
										$topAlbumHtml .= '<div id="topAlbum-' . $artistAlbum["id"] . '" class="albumItem left">';
											$topAlbumHtml .= '<div class="albumItemImg">';									
													$topAlbumHtml .= '<a href="/artist/' . str_replace("+","-",urlencode($artistAlbum["name"])) . '/album/' . str_replace("+","-",urlencode($artistAlbum["reviews"][0]["release"])) . '"><img src="' . $artistAlbum["reviews"][0]["image_url"]  . '" height="125" width="125" border="0"></a>';											
											$topAlbumHtml .= '</div>';
											$topAlbumHtml .= '<span class="albumItemTitleFootnote"><strong><a href="/artist/' . str_replace("+","-",urlencode($artistAlbum["name"])) . '/album/' . str_replace("+","-",urlencode($artistAlbum["reviews"][0]["release"])) . '">' . $artistAlbum["name"] . '</a></strong><br>' . $artistAlbum["reviews"][0]["release"] . "</span>";
										$topAlbumHtml .= '</div>';
										$songCount++;
									}
								}
							}
                            
                            //$artistSong = $songAboutEchonest->getArtistApi()->identify(array('sort' => 'hotttnesss-desc', 'bucket' => array("songs")));
                            //echo var_dump($artistSong) . '<br>';
                            
                            /*if(isset($artistAlbum["id"]) && $artistAlbum["id"] != "") {				
                                $artistSong = $songAboutEchonest->getSongApi()->search(array('artist_id' => $artistAlbum["id"], 'results' => '1', 'sort' => 'song_hotttnesss-desc', 'bucket' => array("id:7digital-US", "tracks")));
                                if(isset($artistSong[0]["tracks"]["release_image"]) && $artistSong[0]["tracks"]["release_image"] != "") {
                                $songCount++;
                                //$artistSong = $songAboutEchonest->getTrackApi()->search(array('artist_id' => $artistAlbum["id"], 'results' => '1', 'sort' => 'song_hotttnesss-desc', 'bucket' => array("id:7digital-US", "tracks", "song_type")));
                                //echo var_dump($artistSong);
                                    echo var_dump($artistSong[0]["tracks"][0]) . ' ' . var_dump($artistSong[0]["tracks"]["release_image"]) . '<br>';
                                    echo '<img src="' . $artistSong[0]["tracks"][0]["release_image"]  . '" height="125" width="125">';
                                }
                            }*/
                            
                            if($songCount >= 5) {
                                    break;
                            }
                        }
                    $topAlbumHtml .= '</div>';
                echo $topAlbumHtml;			
			?>       
        </div>
    </div>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
			<?php	       
				//$topArtists = $songAboutEchonest->getArtistApi()->search(array('results' => '6', 'sort' => 'hotttnesss-desc', 'bucket' => array("images", "hotttnesss")));	
				
				$topArtistsObj = new PopularArtistCache();
				//$topArtistsObj->updateDailyData();	
				$topArtists = $topArtistsObj->fetchAllArtist(1, 6, 'All', '', '', '  day_rating DESC');

				$artistHtml = '<div id="topArtist" class="right">';
                    $artistHtml .= '<div id="topArtistTitle" class="center">';
                        $artistHtml .= 'POPULAR ARTISTS';
                    $artistHtml .= '</div>';

                    foreach ($topArtists as &$artist) {
                        // Some artist names need to be replaced
						$artistArray = array("/Beyoncee/","/Beyoncé/");
						$artistArrayTrans = array("Beyonce","Beyonce");
						
						$artist->artist_name = preg_replace($artistArray,$artistArrayTrans, $artist->artist_name);
						
						if(isset($artist->profile_image_url) && $artist->profile_image_url != "") {
                            $artistHtml .= '<div id="artist-' . $artist->id . '" class="artistItem left">';
                                $artistHtml .= '<div class="artistItemImg">';      									
									$artistHtml .= '<a href="/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>,|]~","",$artist->artist_name)))  . '"><img src="' . $artist->profile_image_url . '" height="125" width="125" border="0"></a>';
                                $artistHtml .= '</div>';
                                $artistHtml .= '<div class="artistItemTitle">';
                                    $artistHtml .= '<a href="/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>,|]~","",$artist->artist_name)))  . '">' . $artist->artist_name . '</a>';
                                $artistHtml .= '</div>';
                            $artistHtml .= '</div>';
                        }
                    }
                    $artistHtml .= '<span class="clear"></span>';
                $artistHtml .= '</div>';
				
                /*$artistHtml = '<div id="topArtist" class="right">';
                    $artistHtml .= '<div id="topArtistTitle" class="center">';
                        $artistHtml .= 'POPULAR ARTIST';
                    $artistHtml .= '</div>';
                    foreach ($topArtists as &$artist) {
                        if(isset($artist["images"][0]["url"]) && $artist["images"][0]["url"] != "") {
                            $artistHtml .= '<div id="artist-' . $artist["id"] . '" class="artistItem left">';
                                $artistHtml .= '<div class="artistItemImg">';
                                    $artistHtml .= '<img src="' . $artist["images"][0]["url"] . '" height="125" width="125">';
                                $artistHtml .= '</div>';
                                $artistHtml .= '<div class="artistItemTitle">';
                                    $artistHtml .= $artist["name"];
                                $artistHtml .= '</div>';
                            //echo  var_dump($artist["images"][0]["url"]) . $artist["name"] . ' id:' . $artist["id"] . '<br><br>';
                            $artistHtml .= '</div>';
                        }
                    }
                    $artistHtml .= '<span class="clear"></span>';
                $artistHtml .= '</div>';*/
                echo $artistHtml;
                //$topSongs = $songAboutEchonest->getSongApi()->search(array('results' => '40', 'sort' => 'song_hotttnesss-desc', 'bucket' => array("id:7digital-US", "tracks", "song_hotttnesss")));

				
				$topSongObj = new PopularSongCache();
				//$topSongObj->updateDailyData();
				$topSongs = $topSongObj->fetchAllSongs(1, 12, 'All', '', '', '  day_rating DESC');

                $songHtml = '<div id="topSongs" class="left">';
                    $songHtml .= '<div id="topSongTitle" class="center">';
                        $songHtml .= 'POPULAR SONGS';
                    $songHtml .= '</div>';
                    $songCount = 0;
                    foreach ($topSongs as &$song) {		
                        if(isset($song->cover_image_url) && $song->cover_image_url != "") {
                            $songCount++;
                            $songHtml .= '<div id="song-' . $song->song_id  . '" class="songItem left">';
                                $songHtml .= '<div class="songItemImg left">';
                                    //clean the string as much as possible removing of characters such as ? and encoding the rest.
									$songHtml .= '<a href="/artist/' . str_replace("+","-",urlencode(preg_replace('~[\\\\/:*?"<>,|]~',"",$song->artist_name))) . '/song/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>,|]~","",$song->song_title))) . '"><img src="' . $song->cover_image_url . '" height="60" width="60" border="0"></a>';
                                $songHtml .= '</div>';
                                $songHtml .= '<div class="songItemTitle left">';
                                    $songHtml .= '<a href="/artist/' . str_replace("+","-",urlencode(preg_replace('~[\\\\/:*?"<>,|]~',"",$song->artist_name))) . '/song/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>,|]~","",$song->song_title))) . '">' . stripslashes($song->song_title) . '</a><br>';
                                    $songHtml .= '<span class="songItemTitleFootnote">' . stripslashes($song->artist_name) . "</span>";
                                $songHtml .= '</div>';
                            //echo  var_dump($artist["images"][0]["url"]) . $artist["name"] . ' id:' . $artist["id"] . '<br><br>';
                            $songHtml .= '</div>';
                        }
                        if($songCount >= 12) {
                            break;
                        }
                    }
                    $songHtml .= '<span class="clear"></span>';
                $songHtml .= '</div>';
                echo $songHtml;			
            ?>
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
	
    <?php /*
    <div class="contentFooterWrapperWidget grayBG left"> 
    	<div id="staffPicksContentFooterWidget" class="contentFooterWidget center">  
        	<div id="sgStaffPicks" class="left">
            	<div class="sectionTitles left">
                	Staff Picks          
                </div>
				<?php
					$staffHtml = "";
					$homepageStaffPicksJSON = json_decode($homepageStaffPicks);
					foreach($homepageStaffPicksJSON->staffPicks as $pickItem) {
						$staffHtml .= '<div id="song-' . $pickItem->id . '" class="songItem left">';
							$staffHtml .= '<div class="songItemImg left">';
								$staffHtml .= '<a href="' . $pickItem->url . '">';
									$staffHtml .= '<img src="' . $pickItem->imageUrl . '" height="60" width="60" border="0">';
								$staffHtml .= '</a>';	
							$staffHtml .= '</div>';
							$staffHtml .= '<div class="songItemTitle left">';
								$staffHtml .= $pickItem->title . '<br>';
								$staffHtml .= '<span class="songItemTitleFootnote">' . $pickItem->artist . "</span>";
							$staffHtml .= '</div>';
						//echo  var_dump($artist["images"][0]["url"]) . $artist["name"] . ' id:' . $artist["id"] . '<br><br>';
						$staffHtml .= '</div>';						
					}
				echo $staffHtml;
				?>
            </div>
        </div>
    </div>    
	*/ ?>
	<div class="contentFooterWrapperWidget left"> 
        <div id="topLyricsContentFooterWidget" class="contentFooterWidget center">  
        	<div class="sectionTitles left">
            	Top Lyrics
             </div>
                <?php
					$count = 0;
					foreach ($topSongs as &$song) {
						$artistSearchString = preg_replace("~[\\\\/:*?'()<>|]~","",str_replace(" ","-",$song->artist_name));
						$songSearchString = preg_replace("~[\\\\/:*?'()<>|]~","",str_replace(" ","-",$song->song_title));						
						
						$songLyrics = getCurlData('http://test.lyricfind.com/api_service/lyric.do?apikey=7500cc6251b190a18374131c56a0b7f2&reqtype=default&trackid=artistname:' . $artistSearchString .',trackname:'. $songSearchString .'&output=json&useragent=' . $_SERVER['HTTP_USER_AGENT']);
//echo 'http://test.lyricfind.com/api_service/lyric.do?apikey=d8a05b1cf5bd9e2a5761abf57543b013&reqtype=default&trackid=artistname:' . $artistSearchString .',trackname:'. $songSearchString .'&output=json&useragent=' . $_SERVER['HTTP_USER_AGENT'];
						$songLyricsJSON = json_decode($songLyrics);
						$songPieces = explode('<br />', nl2br($songLyricsJSON->track->lyrics));
						if(isset($songLyrics) && $songLyrics != "" && count($songPieces) > 1) {					
							$topLyricHtml .= '<div id="songLyric-' . $song->song_id  . '" class="songLyricItem left"><a style="color:black; text-decoration:none;" href="/artist/' . $artistSearchString . '/song/' . $songSearchString . '">';
							$countBoxes = 0;
								$topLyricHtml .= '<p>';
								foreach ($songPieces as &$songPiece) {
									$countBoxes++;					
									
									$topLyricHtml .= $songPiece . '<br><br>';
									if($countBoxes >= 3) {
										break;
									}			
								}	
								$topLyricHtml .= '</p></a>';
								$count++;	
								$topLyricHtml .= '<div class="songLyricsClass"><a style="color:black; text-decoration:none;" href="/artist/' . $artistSearchString . '/song/' . $songSearchString . '">';
									$topLyricHtml .= '<div class="songItemTitle left">';
										$topLyricHtml .= $song->song_title . '<br>';
										$topLyricHtml .= '<span class="songItemLyricTitleFootnote">' . $song->artist_name . "</span>";
									$topLyricHtml .= '</div>';	
									$topLyricHtml .= '<div class="songItemImg left">';
										$topLyricHtml .= '<img src="' . $song->cover_image_url . '" height="60" width="60" border="0">';
									$topLyricHtml .= '</div>';	
								$topLyricHtml .= '</a></div>';											
							$topLyricHtml .= '</div>';	
						}
						if($count >= 6) {
							break;
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