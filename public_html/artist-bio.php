<?php
	$pageTitle = "SongAbout.FM | Discover what a song is about - Artist Bio";
	$page = "Homepage";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '../lib/EchoNest/Autoloader.php';
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
		$artistProfileGenre = $artistDetail->getProfile(array('bucket' => "genre"));
		$artistSearchString = str_replace(" ","+",$artistProfile["name"]);
		$artistSimilar = $artistDetail->getSimilar('15', '15', '0', array("images"), '1.0', '0.0', '1.0',  '0.0','false', 'false', NULL);
		if(isset($artistProfile["id"])) {
			$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('artist_id' => $artistProfile["id"], 'results' => '5', 'type' => 'artist-radio', 'bucket' => array("id:7digital-US", "tracks")));
		} else {
			$artistSimilarSongs = $songAboutEchonest->getPlaylistApi()->getStatic(array('song_id' => 'SORMQAA135C3593DCB', 'results' => '5', 'type' => 'song-radio', 'bucket' => array("id:7digital-US", "tracks")));
		}	
		$artistBioInfo = getCurlData('http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=' . $artistSearchString . '&api_key=2b79d5275013b55624522f2e3278c4e9&format=json');
		
	} else {
		// Add redirect code
	}
?>
<?php 	include 'includes/header.php'; ?>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
			<div id="" class="left col-1"> 
                <?php 	include 'includes/sidebar-suggested-songs.php'; ?>           
                
                <?php 	include 'includes/sidebar-suggested-artist.php'; ?> 		           		
            </div>
			<div id="col-2" class="left col-2"> 
				<div class="artistDetailBox"> 
                    <div class="artistItemImg">
                        <?php 
							$foundImage = false;
							foreach ($artistProfile["images"] as &$artistImage) {
								if(isset($artistImage["url"])  && url_exists($artistImage["url"])) {
									echo '<img src="' . $artistImage["url"] .'" height="125" width="125" border="0">';
									$foundImage = true;
									break;
								} 
							}														
							if(!$foundImage){
								echo '<img src="/~songabou/images/noSGcover.png" height="125" width="125" border="0">';
							}
						?>                     
                    </div>
                    <div id="artistItemSocialIcons" class="right">
                    	<div id="artistItemSocialFB"><a href="#"></a></div>
                        <div id="artistItemSocialTwitter"><a href="#"></a></div>
                        <div id="artistItemSocialShare"><a href="#"></a></div>
                    </div>
    				<div class="artistItemDetailText">
                    	<?php echo $artistProfile["name"]; ?>
                       <br />
                       <span style="font-size:12px; font-weight: 200;">
						   <?php
                               $genreCount = 0;
                               foreach ($artistProfileGenre["genres"] as &$artisGenre) {
                                   echo $artisGenre["name"];
                                   $genreCount++;
                                   if($genreCount > 2) {
                                        break;   
                                   } else {
                                        echo ', ';   
                                   }
                               }			
                           ?>
                       </span>
                    </div>
                    <div class="artistItemDetailMenu left">
                      	<div class="left" id="buttonToMusic"><a href="/~songabou/artist/<?php echo $artistName ?>"></a></div>
                        <div class="left" id="buttonClaimPage"><a href="#"></a></div>
                       	<input type="hidden" name="artistNameInput" value="<?php echo $artistName ?>" />
                    </div>        
                </div>
                <br />
                <div id="artistDetailOwnWords" class="left">
					<div id="ownWordsTitle" class="left">
                        <div id="artistOwnWordsTitleText">IN THE ARTIST'S OWN WORDS</div><br /><br />
                        <div id="ownWordsTitleDetails">
                        	Artist has yet to enter thier own words.  
                        </div>                
                    </div>
                </div>

                <div id="artistDetailBio" class="left grayBG">
					<div id="artistBioTitle" class="left">
                        <div id="artistBiotitleText">BIO</div><br /><br />    
                        <?php
							if(isset($artistBioInfo) && $artistBioInfo != "") {
								$artistAudioJSON = json_decode($artistBioInfo);
								//var_dump($artistAudioJSON->artist->bio->content);		
							}	
							if(isset($artistBioInfo) && $artistBioInfo != "") {
								$artistAudioJSON = json_decode($artistBioInfo);
								if(isset($artistAudioJSON->artist->bio->content) && $artistAudioJSON->artist->bio->content != "") {	
									echo nl2br($artistAudioJSON->artist->bio->content);
								} else {
								 	echo 'Artist Bio is Blank';
								}
							} else {
								echo 'Artist Bio could not be found.';
							}
							//var_dump($artistBioInfo);
						?>				                 
                    </div>
                </div>
                 <span class="clear"></span>
            </div>                		
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<?php 	include 'includes/footer.php'; ?>
