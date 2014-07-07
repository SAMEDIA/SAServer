<?php

	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '../lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
	//$topArtists = $songAboutEchonest->getArtistApi()->search(array('results' => '100', 'sort' => 'hotttnesss-asc'));
			$topArtistsCall1 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));
			$topArtistsCall2 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 100, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));
			$topArtistsCall3 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 200, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));
			$topArtistsCall4 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 300, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));
			$topArtistsCall5 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 400, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));		
			$topArtistsCall6 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 500, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));
			$topArtistsCall7 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 600, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));
			$topArtistsCall8 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 700, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));
			$topArtistsCall9 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 800, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));
			$topArtistsCall10 = $songAboutEchonest->getArtistApi()->search(array('max_familiarity' => '.50', 'min_familiarity' => '.00', 'start' => 900, 'results' => '100', 'sort' => 'hotttnesss-asc', 'bucket' => array("images")));


			/*$topArtistsCall11 = $songAboutEchonest->getArtistApi()->search(array('start' => 600, 'results' => '100', 'sort' => 'hotttnesss-asc', 'artist_start_year_before' => 1970, 'artist_end_year_after' => 1980, 'bucket' => array("images")));
			$topArtistsCall12 = $songAboutEchonest->getArtistApi()->search(array('start' => 700, 'results' => '100', 'sort' => 'hotttnesss-asc', 'artist_start_year_before' => 1980, 'artist_end_year_after' => 1990, 'bucket' => array("images")));
			$topArtistsCall13 = $songAboutEchonest->getArtistApi()->search(array('start' => 800, 'results' => '100', 'sort' => 'hotttnesss-asc', 'artist_start_year_before' => 1990, 'artist_end_year_after' => 2000, 'bucket' => array("images")));
			$topArtistsCall114 = $songAboutEchonest->getArtistApi()->search(array('fuzzy_match' => true, 'name' => 'd%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%', 'results' => '100', 'sort' => 'hotttnesss-asc', 'rank_type' => 'familiarity', 'bucket' => array("images")));*/

			$topArtistsUnFilted = array_merge((array)$topArtistsCall1, (array)$topArtistsCall2);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall3);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall4);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall5);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall6);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall7);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall8);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall9);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall10);
			/*$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall11);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall12);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall13);
			$topArtistsUnFilted = array_merge((array)$topArtistsUnFilted, (array)$topArtistsCall14);*/

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
			//$topArtists = array_filter($topArtistsUnFilted, 'filterArray');
			
			//usort($topArtists, 'compare_lastname');
					
			//echo var_dump($topAlbumArtists);
			$topArtists = $topArtistsUnFilted;
			
			echo 'test Count: ' . count($topArtists) . '<br><br>';
			
			foreach ($topArtists as &$artist) {                  												
					if($artist["images"][0]["url"] != "") {
						$topAlbumHtml  .= "Insert into songabout_artist(echonest_id, artist_name, profile_image_url) values ('" . $artist["id"] . "', '" . str_replace("'", "\'", $artist["name"]) . "', '" . $artist["images"][0]["url"] . "'); <br>";
					}
			}
			
			echo $topAlbumHtml;