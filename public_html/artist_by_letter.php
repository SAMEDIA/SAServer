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
			
?>
<? 	include '/home/songabou/www/includes/header.php'; ?>
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
	<?
			//$topArtists = $songAboutEchonest->getArtistApi()->search(array('fuzzy_match' => true, 'name' => 'd%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%', 'results' => '100', 'sort' => 'hotttnesss-desc', 'rank_type' => 'familiarity'));
			//echo var_dump($topArtists);
			
			//exit;
			$topArtists = $songAboutEchonest->getArtistApi()->search(array('results' => '100', 'sort' => 'hotttnesss-desc'));
			$topArtistsCall1 = $songAboutEchonest->getArtistApi()->search(array('results' => '100', 'sort' => 'hotttnesss-desc'));
			$topArtistsCall2 = $songAboutEchonest->getArtistApi()->search(array('start' => 100, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));
			$topArtistsCall3 = $songAboutEchonest->getArtistApi()->search(array('start' => 200, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));
			$topArtistsCall4 = $songAboutEchonest->getArtistApi()->search(array('start' => 300, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));
			$topArtistsCall5 = $songAboutEchonest->getArtistApi()->search(array('start' => 400, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));		
			$topArtistsCall6 = $songAboutEchonest->getArtistApi()->search(array('start' => 500, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));
			$topArtistsCall7 = $songAboutEchonest->getArtistApi()->search(array('start' => 600, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));
			$topArtistsCall8 = $songAboutEchonest->getArtistApi()->search(array('start' => 700, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));
			$topArtistsCall9 = $songAboutEchonest->getArtistApi()->search(array('start' => 800, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));
			$topArtistsCall10 = $songAboutEchonest->getArtistApi()->search(array('start' => 900, 'results' => '100', 'sort' => 'hotttnesss-desc', 'bucket' => array("images")));


			$topArtistsCall11 = $songAboutEchonest->getArtistApi()->search(array('start' => 600, 'results' => '100', 'sort' => 'hotttnesss-desc', 'artist_start_year_before' => 1970, 'artist_end_year_after' => 1980, 'bucket' => array("images")));
			$topArtistsCall12 = $songAboutEchonest->getArtistApi()->search(array('start' => 700, 'results' => '100', 'sort' => 'hotttnesss-desc', 'artist_start_year_before' => 1980, 'artist_end_year_after' => 1990, 'bucket' => array("images")));
			$topArtistsCall13 = $songAboutEchonest->getArtistApi()->search(array('start' => 800, 'results' => '100', 'sort' => 'hotttnesss-desc', 'artist_start_year_before' => 1990, 'artist_end_year_after' => 2000, 'bucket' => array("images")));
			$topArtistsCall114 = $songAboutEchonest->getArtistApi()->search(array('fuzzy_match' => true, 'name' => 'd%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%', 'results' => '100', 'sort' => 'hotttnesss-desc', 'rank_type' => 'familiarity', 'bucket' => array("images")));

			$topArtistsUnFilted = array_merge((array)$topArtistsCall1, (array)$topArtistsCall2);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall3);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall4);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall5);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall6);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall7);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall8);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall9);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall10);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall11);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall12);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall13);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall14);

			function compare_lastname($a, $b)
			{
				$a = strtolower($a['name']);
				$b = strtolower($b['name']);
				
				return strnatcmp($a, $b);
			}

			function filterArray($value){
				return (strtolower($value["name"][0]) == "d");
			}			
			// sort alphabetically by name
			$topArtists = array_filter($topArtistsUnFilted, 'filterArray');
			
			usort($topArtists, 'compare_lastname');
					
			//echo var_dump($topAlbumArtists);
			
			echo 'test Count: ' . count($topArtists);
	
			$songCount = 0;
			$topAlbumHtml ="";
			$topAlbumHtml = '<div id="topAlbums" class="center">';
				$topAlbumHtml .= '<div id="topAlbumsTitle" class="center">';
					$topAlbumHtml .= 'Top D Artist:';
				$topAlbumHtml .= '</div>';	
					$currentLetter = "";
					foreach ($topArtists as &$artist) {                  												
						$topAlbumHtml  .= "Insert into songabout_artist(echonest_id, artist_name, profile_image_url) values ('" . $artist["id"] . "', '" . $artist["name"] . "', '" . $artist["images"][0]["url"] . "'); <br>";
						/*
						if(isset($artist["name"][0]) && $artist["name"][0] == "D") {
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
                       }*/	
					   					
					}
				$topAlbumHtml .= '</div>';
			echo $topAlbumHtml;			
		?>     		
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<? 	include '/home/songabou/www/includes/footer.php'; ?>
