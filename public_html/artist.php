<?php
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '../lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	

	if(isset($_GET["letter"])) {
		$currentLetterTag = $_GET["letter"];
	} else {
		$currentLetterTag = 'All';
	}
	
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
								if($currentLetterTag == 'All' || strtoupper($currentLetterTag) == strtoupper($currentLetter)) {
									$topAlbumHtml .=  '<span class="alphaPgBreak left">' . $currentLetter .'</span>';	
								}
							}
							
							if($currentLetterTag == 'All' || strtoupper($currentLetterTag) == strtoupper($currentLetter)) {
								$topAlbumHtml .= '<div id="artist-' . $artist["id"] . '" class="artistItem left">';
									$topAlbumHtml .= '<div class="artistItemImg">';
										$topAlbumHtml .= '<a href="/artist/' . urlencode($artist["name"]) . '"><img src="' . $artist["images"][0]["url"] . '" height="125" width="125" border="0"></a>';
									$topAlbumHtml .= '</div>';
									$topAlbumHtml .= '<div class="artistItemTitle">';
										$topAlbumHtml .= $artist["name"];
									$topAlbumHtml .= '</div>';
								//echo  var_dump($artist["images"][0]["url"]) . $artist["name"] . ' id:' . $artist["id"] . '<br><br>';
								$topAlbumHtml .= '</div>';
							}
                        }
					
						
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
