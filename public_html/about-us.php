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
	
	require_once '/home/songabou/www/includes/staffPicksVar.php';
	require_once '/home/songabou/songabout_lib/models/PopularArtistCache.php';
	require_once '/home/songabou/songabout_lib/models/PopularSongCache.php';
	require_once '/home/songabou/songabout_lib/models/PopularAlbumCache.php';
	
	$topSongObj = new PopularSongCache();
	//$topSongObj->updateDailyData();
	$topSongs = $topSongObj->fetchAllSongs(1, 12, 'All', '', '', '  day_rating DESC');		
?>
<? 	include '/home/songabou/www/includes/header.php'; ?>
	<div id="aboutUsContentHeaderWrapper" class="left sg-borderless"> 
        <div id="contentHeader" class="center">  
            <div id="aboutUsBox">
                <img src="/~songabou/images/aboutHeaderImageNew.png" width="975" height="187">
            	<p><strong>Songabout.fm</strong> is the world’s platform for creative music artists explaining what there songs are about on a unified verified platform. We aim at connecting artists to there dedicated fan bases establishing that deep connection to their songs and lyrics on a higher level.  Artists can reach fans by using our platform to collaborate, grow their audience and by connecting to there fans. Fans choose Songabout.fm to engage in a dialogue with other fans in an entertaining, relevant and credible context. <br><br>For all general inquiries and partnerships you can reach us as follows: <a href="mailto:info@songabout.fm" style="color:#ffffff;">info@songabout.fm</a></p>
            </div>
        </div>
    </div>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
            <div id="songAboutBase" class="center">
                <div class="sectionTitles left">
                	Top Lyrics
                </div>
                <?
                    $count = 0;
                    foreach ($topSongs as &$song) {
						$artistSearchString = preg_replace("~[\\\\/:*?'()<>|]~","",str_replace(" ","-",$song->artist_name));
                        $songSearchString = preg_replace("~[\\\\/:*?'()<>|]~","",str_replace(" ","-",$song->song_title));						
                        
						$songLyrics = getCurlData('http://api.lyricfind.com/lyric.do?apikey=d8a05b1cf5bd9e2a5761abf57543b013&reqtype=default&trackid=artistname:' . $artistSearchString .',trackname:'. $songSearchString .'&output=json&useragent=X');
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
                                        $topLyricHtml .= $song->artist_name . count($songPieces) . '<br>';
                                        $topLyricHtml .= '<span class="songItemLyricTitleFootnote">' . $song->artist_name . "</span>";
                                    $topLyricHtml .= '</div>';	
                                    $topLyricHtml .= '<div class="songItemImg left">';
                                        $topLyricHtml .= '<img src="' . $song->cover_image_url . '" height="60" width="60" border="0">';
                                    $topLyricHtml .= '</div>';	
                                $topLyricHtml .= '</div>';											
                            $topLyricHtml .= '</div>';	
                        }
                        if($count >= 6) {
                            break;
                        }
                    }
                    echo $topLyricHtml;
                ?>        


<?	       
				
				$topAlbumArtists = $songAboutEchonest->getArtistApi()->search(array('sort' => 'hotttnesss-desc', 'results' => '25', 'bucket' => array("id:7digital-US", "reviews")));
				
				$artistHtml = '<div id="topArtist" class="right">';
                    $artistHtml .= '<div id="topArtistTitle" class="center">';
                        $artistHtml .= 'TOP ALBUMS';
                    $artistHtml .= '</div>';

                    foreach ($topAlbumArtists as &$artistAlbum) {					
						if(!preg_match('/[^A-Za-z0-9]/',str_replace(" ","",$artistAlbum["reviews"][0]["release"])) && !preg_match('/[^A-Za-z0-9]/',str_replace(" ","",$artistAlbum["name"]))) {
								if($artistAlbum["reviews"][0]["image_url"] != "" && $artistAlbum["reviews"][0]["release"] !="") {
								$artistHtml .= '<div id="artist-' . $artistAlbum["id"] . '" class="artistItem left">';
									$artistHtml .= '<div class="artistItemImg">';      									
										$artistHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode($artistAlbum["name"])) . '/album/' . str_replace("+","-",urlencode($artistAlbum["reviews"][0]["release"])) . '"><img src="' . $artistAlbum["reviews"][0]["image_url"] . '" height="125" width="125" border="0"></a>';
									$artistHtml .= '</div>';
									$artistHtml .= '<div class="artistItemTitle">';
										$artistHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode($artistAlbum["name"])) . '/album/' . str_replace("+","-",urlencode($artistAlbum["reviews"][0]["release"])) . '">' . $artistAlbum["name"] . '</a>';
									$artistHtml .= '</div>';
								$artistHtml .= '</div>';
							}
						}
                    }
                    $artistHtml .= '<span class="clear"></span>';
                $artistHtml .= '</div>';
				
               
                echo $artistHtml;				
				$topArtistsObj = new PopularArtistCache();
				//$topArtistsObj->updateDailyData();	
				$topArtists = $topArtistsObj->fetchAllArtist(1, 28, 'All', '', '', '  day_rating DESC');

                $topArtistHtml = '<div id="topSongs" class="left">';
                    $topArtistHtml .= '<div id="topSongTitle" class="center">';
                        $topArtistHtml .= 'TOP ARTIST';
                    $topArtistHtml .= '</div>';
                    $songCount = 0;
                    foreach ($topArtists as &$artist) {		
                        if(isset($artist->profile_image_url) && $artist->profile_image_url != "") {
                            $songCount++;
                            $topArtistHtml .= '<div id="song-' . $song->song_id  . '" class="songItem left">';
                                $topArtistHtml .= '<div class="songItemImg left">';
                                    //clean the string as much as possible removing of characters such as ? and encoding the rest.
									$topArtistHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>|]~","",$artist->artist_name)))  . '"><img src="' . $artist->profile_image_url . '" height="60" width="60" border="0"></a>';
                                $topArtistHtml .= '</div>';
                                $topArtistHtml .= '<div class="songItemTitle left">';
                                    $topArtistHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>|]~","",$artist->artist_name)))  . '">' . stripslashes($artist->artist_name) . '</a><br>';
                                $topArtistHtml .= '</div>';
                            //echo  var_dump($artist["images"][0]["url"]) . $artist["name"] . ' id:' . $artist["id"] . '<br><br>';
                            $topArtistHtml .= '</div>';
                        }
                        if($songCount >= 21) {
                            break;
                        }
                    }
                    $topArtistHtml .= '<span class="clear"></span>';
                $topArtistHtml .= '</div>';
                echo $topArtistHtml;			
            ?>

           </div>
           
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<? 	
	include '/home/songabou/www/includes/footer.php'; 
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
?>
