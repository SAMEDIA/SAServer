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
                    $topAlbumArtists = $songAboutEchonest->getArtistApi()->search(array('sort' => 'hotttnesss-desc', 'results' => '100', 'bucket' => array("id:7digital-US", "reviews")));
					
					$songCount = 0;
					$topAlbumHtml ="";
					$topAlbumHtml = '<div id="topAlbums" class="center">';
						$topAlbumHtml .= '<div id="topAlbumsTitle" class="center">';
							$topAlbumHtml .= 'Top Albums';
						$topAlbumHtml .= '</div>';
							foreach ($topAlbumArtists as &$artistAlbum) {
								if(strpos($artistAlbum["reviews"][0]["image_url"], "popmatters.com") == 0 and strpos($artistAlbum["reviews"][0]["image_url"], "upload.wikimedia.org") == 0) {					
									if($artistAlbum["reviews"][0]["image_url"] != "" && $artistAlbum["reviews"][0]["release"] !="") {
										//if (file_exists($artistAlbum["reviews"][0]["image_url"])) {
											$topAlbumHtml .= '<div id="topAlbum-' . $artistAlbum["id"] . '" class="albumItem left">';
												$topAlbumHtml .= '<div class="albumItemImg">';
													$topAlbumHtml .= '<a href="/artist/' . str_replace("+","-",urlencode($artistAlbum["name"])) . '/album/' . str_replace("+","-",urlencode($artistAlbum["reviews"][0]["release"])) . '"><img src="' . $artistAlbum["reviews"][0]["image_url"]  . '" height="125" width="125"></a>';
												$topAlbumHtml .= '</div>';
												$topAlbumHtml .= '<span class="albumItemTitleFootnote"><strong><a href="/artist/' . str_replace("+","-",urlencode($artistAlbum["name"])) . '/album/' . str_replace("+","-",urlencode($artistAlbum["reviews"][0]["release"])) . '">' . $artistAlbum["name"] . '</a></strong><br>' . $artistAlbum["reviews"][0]["release"] . "</span>";
											$topAlbumHtml .= '</div>';
											$songCount++;
										//}
									}
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
