<?php 
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;
	// Homepage Caching Objects
	require_once '../songabout_lib/models/PopularArtistCache.php';
	require_once '../songabout_lib/models/PopularSongCache.php';
	require_once '../songabout_lib/models/PopularAlbumCache.php';	
?>
<?php include 'includes/headertest.php'; ?>
<div id="features"> <!--<img class="lazy" data-original="images/aboutHeaderImage.png" width="100%">--> 
<img class="lazy" data-original="images/notes3.jpg" width="100%">
</div>
<div class="main-content">
<div class="container-fluid">
<div id="left-main" class="col-md-8">
<div id="trendingLyrics">
  <h2 class="sub-header">Trending on SongAbout</h2>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
  8- 10 constantly updated songs<br/>
</div>
<div id="topAlbums">
  <h2 class="sub-header">Featured Albums</h2>
  <?php
                $topAlbumArtists = $songAboutEchonest->getArtistApi()->search(array('sort' => 'hotttnesss-desc', 'results' => '25', 'bucket' => array("id:7digital-US", "reviews")));
                //echo var_dump($topAlbumArtists);
                
                $songCount = 0;
						foreach ($topAlbumArtists as &$artistAlbum) {
                            //Fix to remove all symbols to keep links safe.
							if(!preg_match('/[^A-Za-z0-9]/',str_replace(" ","",$artistAlbum["reviews"][0]["release"])) && !preg_match('/[^A-Za-z0-9]/',str_replace(" ","",$artistAlbum["name"]))) {
								if($artistAlbum["reviews"][0]["image_url"] != "" && $artistAlbum["reviews"][0]["release"] !="") {
									
									//if (strpos($artistAlbum["reviews"][0]["image_url"], 'www.popmatters.com')!=0) continue;
									//Malware Check 								
									if(!strpos($artistAlbum["reviews"][0]["image_url"], 'www.theaureview.com')) {
										$topAlbumHtml .= '<div id="topAlbum-' . $artistAlbum["id"] . '" class="albumItem col-md-2 col-sm-4 col-xs-6">';								
													$topAlbumHtml .= '<a href="/artist/' . str_replace("+","-",urlencode($artistAlbum["name"])) . '/album/' . str_replace("+","-",urlencode($artistAlbum["reviews"][0]["release"])) . '"><div class="albumImg"><img class="lazy" data-original="' . $artistAlbum["reviews"][0]["image_url"]  . '" border="0"></div></a>';
											$topAlbumHtml .= '<span class="albumItemTitleFootnote"><strong><a href="/artist/' . str_replace("+","-",urlencode($artistAlbum["name"])) . '/album/' . str_replace("+","-",urlencode($artistAlbum["reviews"][0]["release"])) . '">' . $artistAlbum["name"] . '</a></strong><br>' . $artistAlbum["reviews"][0]["release"] . "</span>";
										$topAlbumHtml .= '</div>';
										$songCount++;
									}
								}
							}
                            if($songCount >= 6) {
                                    break;
                            }
                        }
                echo $topAlbumHtml;			
			?>
</div>
</div>
  
  <div id="popSongs" class="col-md-4">
  <h2 class="sub-header">Popular Songs</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
        </tr>
      </thead>
      <tbody>
      <?php
      	$topSongObj = new PopularSongCache();
		//$topSongObj->updateDailyData();
		$topSongs = $topSongObj->fetchAllSongs(1, 10, 'All', '', '', '  day_rating DESC');
                    $songCount = 0;
                    foreach ($topSongs as &$song) {	
                                    //clean the string as much as possible removing of characters such as ? and encoding the rest.
                                    $songHtml .= '<tr>
									<td>'.($songCount + 1).'</td>';
							//		$songHtml .= '<td><a id="songPlayerCoverImgPlayer" data-width="600" data-bop-link href="http://www.bop.fm/embed/' . $song->artist_name .'/'.$song->song_title.'">'.$song->artist_name.' - '.$song->song_title.'</a></td>';
							$songHtml .= '<td><a href="/artist/' . str_replace("+","-",urlencode(preg_replace('~[\\\\/:*?"<>,|]~',"",$song->artist_name))) . '/song/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>,|]~","",$song->song_title))) . '"><img src="' . $song->cover_image_url . '" height="60" width="60" border="0"></a></td>'; 
$songHtml .= '<td><a href="/artist/' . str_replace("+","-",urlencode(preg_replace('~[\\\\/:*?"<>,|]~',"",$song->artist_name))) . '/song/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>,|]~","",$song->song_title))) . '">' . stripslashes($song->song_title) . '</a>';
                                    $songHtml .= '<p class="songItemTitleFootnote">' . stripslashes($song->artist_name) . "</p></td></tr>";
									$songCount++;
				        if($songCount >= 12) {
                            break;
                    	}
					}
                echo $songHtml;
		?>
      </tbody>
    </table>
  </div>
</div>
<!----
<div id="popArtists" class="col-md-6">
  <h2 class="sub-header">Popular Artists</h2>
  <?php  /*     
				//$topArtists = $songAboutEchonest->getArtistApi()->search(array('results' => '6', 'sort' => 'hotttnesss-desc', 'bucket' => array("images", "hotttnesss")));	
				
				$topArtistsObj = new PopularArtistCache();
				//$topArtistsObj->updateDailyData();	
				$topArtists = $topArtistsObj->fetchAllArtist(1, 6, 'All', '', '', '  day_rating DESC');

				$artistHtml = '<div id="topArtist">';

                    foreach ($topArtists as &$artist) {
                        // Some artist names need to be replaced
						$artistArray = array("/Beyoncee/","/Beyoncé/");
						$artistArrayTrans = array("Beyonce","Beyonce");
						
						$artist->artist_name = preg_replace($artistArray,$artistArrayTrans, $artist->artist_name);
						
						if(isset($artist->profile_image_url) && $artist->profile_image_url != "") {
                            $artistHtml .= '<div class="artistItem col-md-6 col-sm-4 col-xs-6">';     									
									list($width, $height) = getimagesize($artist->profile_image_url);
									$artistHtml .= '<a href="/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>,|]~","",$artist->artist_name)))  . '"><div id="artistImg-' . $artist->id . '" class="artistImg" >' . '<img class="lazy" ';
									if($width > $height)
									$artistHtml .= 'name="width" '; 
									else
									$artistHtml .= 'name="height" ';
									$artistHtml .= 'width="100%" ';
									$artistHtml .= 'data-original="' . $artist->profile_image_url . '" border="0"></div></a>';
                                    $artistHtml .= '<strong><a href="/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>,|]~","",$artist->artist_name)))  . '">' . $artist->artist_name . '<br><br></a></strong>';
                            $artistHtml .= '</div>';
                        }
                    }
                    $artistHtml .= '<span class="clear"></span>';
                $artistHtml .= '</div>';
                echo $artistHtml;		*/
            ?>
</div>
---->

<div id="topLyrics">
  <h2 class="sub-header">Top Lyrics</h2>
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
?>
</div>

</div>
</div>
<?php include 'includes/footertest.php'; ?>