<?php 
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;
	// Homepage Caching Objects
	require_once '../songabout_lib/models/PopularArtistCache.php';
	require_once '../songabout_lib/models/PopularSongCache.php';
	require_once '../songabout_lib/models/PopularAlbumCache.php';
	require_once '../songabout_lib/models/SongAboutMeaningPiece.php';	
?>
<?php include 'includes/headertest.php'; ?>
<div class="features">
	<ul>
	<?php	       
				//$topArtists = $songAboutEchonest->getArtistApi()->search(array('results' => '6', 'sort' => 'hotttnesss-desc', 'bucket' => array("images", "hotttnesss")));	
				
				$topArtistsObj = new PopularArtistCache();
				$topArtistsObj->updateDailyData();	
				$artistHtml = 0;
				$topArtists = $topArtistsObj->fetchAllArtist(1, 5, 'All', '', '', '  day_rating DESC');
				$topArtistCount = 0;
                    foreach ($topArtists as &$artist) {
                        // Some artist names need to be replaced
                        if($topArtistCount == 0)
                        	$artistHtml .= '<li id = "lPanel">';
                        elseif($topArtistCount == 4)
                        	$artistHtml .= '<li id = "rPanel">';
                        else
                        	$artistHtml .= '<li>';
						$artistArray = array("/Beyoncee/","/Beyoncé/");
						$artistArrayTrans = array("Beyonce","Beyonce");
						
						$artist->artist_name = preg_replace($artistArray,$artistArrayTrans, $artist->artist_name);
						
						if(isset($artist->profile_image_url) && $artist->profile_image_url != "") {									
									$artistHtml .= '<a href="/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>,|]~","",$artist->artist_name)))  . '"><img class="lazy feature-panel" data-original=' . $artist->profile_image_url . ' src="'. $artist->profile_image_url .'"></a>';
                        }
                        $artistHtml .= '<div class="image_title col-md-3 col-sm-3 col-xs-6"><a href="#">'. $artist->artist_name . '</a></div></li>';
                        $topArtistCount++;
                        if($topArtistCount >= 5)
                        	break;
                    }
                echo $artistHtml;
		?>
	</ul>
	<!--
	<ul>
		<li id = "lPanel">
			<a href="#">
				<img class="lazy feature-panel" data-original="images/homecoming2013.jpg">
			</a>
            <div class="image_title col-md-3 col-sm-3 col-xs-6">
				<a href="#">KungFu Panda</a>
			</div>
		</li>
		<li>
			<a href="#">
				<img class="lazy feature-panel" data-original="images/homecoming2013.jpg">
			</a>
			<div class="image_title col-md-3 col-sm-3 col-xs-6">
				<a href="#">Toy Story 2</a>
			</div>
		</li>
		<li>
			<a href="#">
				<img class="lazy feature-panel" data-original="images/homecoming2013.jpg">
			</a>
            
			<div class="image_title col-md-3 col-sm-3 col-xs-6">
				<a href="#">Wall-E</a>
			</div>
		</li>
		<li>
			<a href="#">
				<img class="lazy feature-panel" data-original="images/homecoming2013.jpg">
			</a>
            
			<div class="image_title col-md-3 col-sm-3 col-xs-6">
				<a href="#">Up</a>
			</div>
		</li>
		<li id = "rPanel">
			<a href="#">
				<img class="lazy feature-panel" data-original="images/homecoming2013.jpg">
			</a>
			<div class="image_title col-md-3 col-sm-3 col-xs-6">
				<a href="#">Cars 2</a>
			</div>
		</li>
	</ul>-->
</div>

</div>
<div class="main-content">
<div class="container-fluid">
<div id="left-main" class="col-md-8 col-sm-12 col-xs-12">
<div id="trendingLyrics">
  <h2 class="sub-header">Trending on SongAbout</h2>
  	<?php
  				$trendingSongsObj = new SongAboutMeaningPiece();
  				$trendingSongs = $trendingSongsObj->fetchRecentSongs(1, 10, '', '', " song_piece_id DESC");
  				//$songAboutEchonest->getSongApi()->
  				$trendSongsCount = 0;
  				$trendSongHtml;
  				
  				foreach ($trendingSongs as $song) {
  					$trendSongs = getCurlData('http://api.lyricfind.com/metadata.do?apikey=b28335795d6084b72f6666247ffaa09d&reqtype=metadata&displaykey=7500cc6251b190a18374131c56a0b7f2&trackid=amg:'.$song->song_id .'&output=json&useragent=' . $_SERVER);
  					$trendSongsJSON = json_decode($trendSongs);
  					$songTitle = explode('<br />', nl2br($trendSongsJSON->track->title));
  					$songArtist = explode('<br />', nl2br($trendSongsJSON->track->artist->name));
  					$tsongPieces = explode('<br />', nl2br($trendSongsJSON->track->snippet));
  					$countBoxes = 0;
  					$trendSongHtml .= '<div class="col-md-6 col-sm-4 col-xs-6"><p>A new meaning has been added to:</p><p>';
  							foreach ($songTitle as $title) {
									$trendSongHtml .= $title . '<br/>';		
							}
							foreach ($songArtist as $artist) {
									$trendSongHtml .= $artist . '<br/>';		
							}
							/*
							foreach ($tsongPieces as $tsongPiece) {
								$countBoxes++;
								$trendSongHtml .= $tsongPiece . '<br>';	
								if($countBoxes >= 3)
									break;	
							}
							*/
					$trendSongHtml .= '</p></div>';	
  					$trendSongsCount++;
  					if(trendSongsCount >= 10)
  						break;
  				}
  				echo $trendSongHtml;
  	?>
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
  
  <div id="popSongs" class="col-md-4 col-sm-12 col-xs-12">
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
		$topSongObj->updateDailyData();
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
				        if($songCount >= 10) {
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
							$topLyricHtml .= '<div id="songLyric-' . $song->song_id  . '" class="col-md-2 col-sm-4 col-xs-6"><a style="color:black; text-decoration:none;" href="/artist/' . $artistSearchString . '/song/' . $songSearchString . '">';
							$countBoxes = 0;
								$topLyricHtml .= '<a style="color:black; text-decoration:none;" href="/artist/' . $artistSearchString . '/song/' . $songSearchString . '">';
									$topLyricHtml .= '<p>';
										$topLyricHtml .= $song->song_title . '<br>';
										$topLyricHtml .= '<span>' . $song->artist_name . "</span>";
									$topLyricHtml .= '</p>';	
								$topLyricHtml .= '</a>';

								$topLyricHtml .= '<p>';
								foreach ($songPieces as &$songPiece) {
									$countBoxes++;					
									
									$topLyricHtml .= $songPiece . '<br>';
									if($countBoxes >= 3) {
										break;
									}			
								}	
								$topLyricHtml .= '</p></a>';
								$count++;									
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

<script>
	$(window).load(function() {
		wH = $(window).height();
		wW = $(window).width();
		ResizeFeatures(wW, wH);
		$(window).resize(function() {
			nwH = $(window).height();
			nwW = $(window).width();
			ResizeFeatures(nwW, nwH);
		});
	});
	
	function ResizeFeatures(winWidth, winHeight) {
		/*
		$(".feature-panel").css("width", "220%");
		$(".feature-panel").css("height", "auto");

		featureWidth = $(".feature-panel").width();
		featureHeight = $(".feature-panel").height();
		
		$(".feature-panel").css("width", featureWidth);
		$(".feature-panel").css("height", featureHeight);
		
		
		$(".features ul").css("width", "112%");
		$(".features ul").css("height", featureHeight);
		
		
		$(".features ul:hover li").css("height", featureHeight);
		$(".features ul li:hover").css("height", featureHeight);
		
		$(".main-content").css("margin-top", 25);
		*/
		$("#lPanel img").css("width", .4*winWidth);
		$("#lPanel img").css("height", "auto");

		featureWidth = $("#lPanel img").width();
		featureHeight = $("#lPanel img").height();
		
		$(".feature-panel").css("width", featureWidth * 1.2);
		$(".feature-panel").css("height", featureHeight);
		$("#rPanel img").css("width", featureWidth);
		$("#rPanel img").css("height", featureHeight);
		
		
		$(".features ul").css("width", "112%");
		$(".features ul").css("height", featureHeight);
		
		
		$(".features ul:hover li").css("height", featureHeight);
		$(".features ul li:hover").css("height", featureHeight);
		
		$(".main-content").css("margin-top", 25);
	}
</script>