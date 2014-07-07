<?php
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'YTEIFSAM5TAJZ4JBR';
	require_once '../lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
	require_once 'includes/staffPicksVar.php';
			
?>
<?php 	include 'includes/header.php'; ?>
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
			$topArtistsCall1 = $songAboutEchonest->getArtistApi()->search(array('results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images", "hotttnesss")));
			
			$topArtistsCall2 = $songAboutEchonest->getArtistApi()->search(array('start' => 100, 'results' => '50', 'sort' => 'hotttnesss-desc', 'bucket' => array("images", "hotttnesss")));
			
			//$topArtistsCall3 = $songAboutEchonest->getArtistApi()->search(array('start' => 200, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images", "hotttnesss")));
			
			$topArtists = array_merge((array)$topArtistsCall1, (array)$topArtistsCall2);
			$topArtists = array_merge((array)$topArtists, (array)$topArtistsCall3);

			function compare_lastname($a, $b)
			{
				return strnatcmp($a['name'], $b['name']);
			}
			
			// sort alphabetically by name
			usort($topArtists, 'compare_lastname');
					
			//echo var_dump($topAlbumArtists);
			
			$songCount = 0;
			$topAlbumHtml ="";
			$topAlbumHtml = '<div id="topAlbums" class="center">';
				$topAlbumHtml .= '<div id="topAlbumsTitle" class="center">';
					//$topAlbumHtml .= 'VERIFIED ARTIST';
				$topAlbumHtml .= '</div>';	
					$currentLetter = "";
					foreach ($topArtists as &$artist) {                  												
						if(isset($artist["images"][0]["url"]) && $artist["images"][0]["url"] != "") {
							if($artist["name"][0] != $currentLetter) {
								$currentLetter = $artist["name"][0];
								$topAlbumHtml .=  '<span class="alphaPgBreak left">' . $currentLetter .'</span>';					
							}

                            $topAlbumHtml .= '<div id="artist-' . $artist["id"] . '" class="artistItem left">';
                                $topAlbumHtml .= '<div class="artistItemImg">';
                                    $topAlbumHtml .= '<img src="' . $artist["images"][0]["url"] . '" height="125" width="125">';
                                $topAlbumHtml .= '</div>';
                                $topAlbumHtml .= '<div class="artistItemTitle">';
                                    $topAlbumHtml .= $artist["name"];
                                $topAlbumHtml .= '</div>';
                            //echo  var_dump($artist["images"][0]["url"]) . $artist["name"] . ' id:' . $artist["id"] . '<br><br>';
                            $topAlbumHtml .= '</div>';
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
						
						if($songCount >= 100) {
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
<?php 	include 'includes/footer.php'; ?>
