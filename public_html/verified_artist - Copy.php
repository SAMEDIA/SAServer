<?php
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'YTEIFSAM5TAJZ4JBR';
	require_once '/home/songabou/lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
	require_once '/home/songabou/www/includes/staffPicksVar.php';
			
?>
<?php 	include '/home/songabou/www/includes/header.php'; ?>
	<div id="contentHeaderWrapper" class="grayBG left"> 
        <div id="contentHeader" class="center">  
            <div id="artistClaimBox">
                <div id="claimArtistText" class="left">
                    Claim your music. Become a Verified Artist now.
                </div>
                <div id="verifyMeButton" class="left">
                    <a href="#"></a>
                </div>
            </div>
        </div>
    </div>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
	<?php
			$topAlbumArtists = $songAboutEchonest->getArtistApi()->search(array('sort' => 'hotttnesss-desc', 'results' => '25', 'bucket' => array("id:7digital-US", "reviews")));
			//echo var_dump($topAlbumArtists);
			
			$songCount = 0;
			$topAlbumHtml ="";
			$topAlbumHtml = '<div id="topAlbums" class="center">';
				$topAlbumHtml .= '<div id="topAlbumsTitle" class="center">';
					$topAlbumHtml .= 'VERIFIED ARTIST';
				$topAlbumHtml .= '</div>';
					foreach ($topAlbumArtists as &$artistAlbum) {
						
						if($artistAlbum["reviews"][0]["image_url"] != "" && $artistAlbum["reviews"][0]["release"] !="") {
							$topAlbumHtml .= '<div id="topAlbum-' . $artistAlbum["id"] . '" class="albumItem left">';
								$topAlbumHtml .= '<div class="albumItemImg">';
									$topAlbumHtml .= '<img src="' . $artistAlbum["reviews"][0]["image_url"]  . '" height="125" width="125">';
								$topAlbumHtml .= '</div>';
								$topAlbumHtml .= '<span class="albumItemTitleFootnote"><strong>' . $artistAlbum["name"] . '</strong><br>' . $artistAlbum["reviews"][0]["release"] . "</span>";
							$topAlbumHtml .= '</div>';
							$songCount++;
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
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<?php 	include '/home/songabou/www/includes/footer.php'; ?>
