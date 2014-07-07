<?
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'YTEIFSAM5TAJZ4JBR';
	require_once '/home/songabou/lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	

	if(isset($_GET["artistID"])) {
		$artistID = $_GET["artistID"];
	} 
	
	if(isset($_GET["artistName"])) {
		$artistName = $_GET["artistName"];
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
		$artistSearchString = str_replace(" ","+",$artistProfile["name"]);
		$artistSimilar = $artistDetail->getSimilar('15', '15', '0', array("images"), '1.0', '0.0', '1.0',  '0.0','false', 'false', NULL);
		//$artistSimilarSongs = $artistDetail->getSimilar('15', '15', '0', array("songs"), '1.0', '0.0', '1.0',  '0.0','false', 'false', NULL);
		//http://developer.echonest.com/api/v4/playlist/static?api_key=YTEIFSAM5TAJZ4JBR&song_id=SORMQAA135C3593DCB&format=json&results=20&type=song-radio&bucket=id:7digital-US&bucket=tracks
		
		$artistSimilarSongs = $echonest->getPlaylistApi(array('song_id' => 'SORMQAA135C3593DCB', 'results' => '8', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		//$artistAudio = $artistDetail->getSongs();
		//http://developer.echonest.com/api/v4/playlist/static?api_key=YTEIFSAM5TAJZ4JBR&song_id=SORMQAA135C3593DCB&format=json&results=20&type=song-radio
		$artistAudio = $songAboutEchonest->getSongApi()->search(array('artist' => $artistSearchString, 'results' => '100', 'sort' => 'song_hotttnesss-desc', 'bucket' => array("id:7digital-US", "tracks")));
		//http://developer.echonest.com/api/v4/song/search?api_key=FILDTEOIK2HBORODV&artist=daft+punk&results=100&sort=song_hotttnesss-desc&bucket=id:7digital-US&bucket=tracks
		//$artistReviews = $artistDetail->search(array('sort' => 'hotttnesss-desc', 'results' => '25', 'bucket' => array("id:7digital-US", "reviews")));
		$artistSugSongs = $artistDetail->getSongs();
		
		//$artistReviews = $artistDetail->getReviews();
		//$artistBio = $artistDetail->getBiographies();
	} else {
		// Add redirect code
	}
?>
<? 	include '/home/songabou/www/includes/header.php'; ?>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
			<div id="" class="left col-1"> 
                <div id="artistDetailSuggestedSongs" class="left">
					<div id="topArtistTitle" class="center">
                        SUGGESTED SONGS
                        <?
							$count = 0;
							/*foreach ($artistSimilarSongs as &$artistSugSong) {
								if($artistSugSong["images"]["0"]["url"] != "") {
									$suggestedArtistSongSugHtml .= '<div id="suggestedArtist-' . $artistSugSong["id"]  . '" class="songItem left">';
										$suggestedArtistSongSugHtml .= '<div class="songItemImg left">';
											$suggestedArtistSongSugHtml .= '<img src="' . $artistSugSong["images"]["0"]["url"] . '" height="60" width="60">';
										$suggestedArtistSongSugHtml .= '</div>'; 
										$suggestedArtistSongSugHtml .= '<div class="songItemTitle left">';
											$suggestedArtistSongSugHtml .= $artistSugSong["name"] . '<br>';
										$suggestedArtistSongSugHtml .= '</div>';   
									$suggestedArtistSongSugHtml .= '</div>';	
									$count++;
									if($count >= 5) {
										break;	
									}
								}										
							}
							echo $suggestedArtistSongSugHtml;*/
							echo var_dump($artistSimilarSongs);	
						?>
                    </div>               				
                </div>	
                <div id="artistDetailSuggestedArtist" class="left">
                	<div id="topArtistTitle" class="center">
                        SUGGESTED ARTISTS                       
                    </div>
                    <div id="suggestedArtistList">
                        <?
							$count = 0;
							foreach ($artistSimilar as &$artistSimilar) {
								if($artistSimilar["images"]["0"]["url"] != "") {
									$suggestedArtistHtml .= '<div id="suggestedArtist-' . $artistSimilar["id"]  . '" class="songItem left">';
										$suggestedArtistHtml .= '<div class="songItemImg left">';
											$suggestedArtistHtml .= '<img src="' . $artistSimilar["images"]["0"]["url"] . '" height="60" width="60">';
										$suggestedArtistHtml .= '</div>'; 
										$suggestedArtistHtml .= '<div class="songItemTitle left">';
											$suggestedArtistHtml .= $artistSimilar["name"] . '<br>';
										$suggestedArtistHtml .= '</div>';   
									$suggestedArtistHtml .= '</div>';	
									$count++;
									if($count >= 5) {
										break;	
									}
								}										
							}
							echo $suggestedArtistHtml 						
						?>
                    </div> 
                </div>	                		
            </div>
			<div id="col-2" class="left col-2"> 
				<div class="artistItemImg">
                	<? if(isset($artistImages[0]["url"]) && $artistImages[0]["url"] != "") {
						echo '<img src=" ' . $artistProfile["images"][0]["url"].'" height="125" width="125" border="0">';
					} else {
						echo '<img src=" ' . $artistProfile["images"][0]["url"].'" height="125" width="125" border="0">';
					} ?>
                    
                </div>

				<?php echo $artistProfile["name"]; ?>
                
                <br />
                
                <div id="artistDetailSongs">
 					<div id="topArtistTitle" class="center">
                        TOP ARTISTS SONGS                 
                    </div>
                	<?  //var_dump($artistAudio) ?>
                </div>
                 <span class="clear"></span>
            </div>                		
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<? 	include '/home/songabou/www/includes/footer.php'; ?>
