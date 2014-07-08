<?php
	require_once '../songabout_lib/models/SongAboutVerifiedArtist.php';	
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "verified-artist";
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
                   Artist's! posting song meanings is as easy as 123. Have a facebook or twitter account ?  Become verified now via your facebook official artist page on songabout.fm and our team will authenticate your account.
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
			//$topAlbumArtists = $songAboutEchonest->getArtistApi()->search(array('sort' => 'hotttnesss-desc', 'results' => '25', 'bucket' => array("id:7digital-US", "reviews")));
			$songAboutVerifiedArtistObj = new SongAboutVerifiedArtist();
			$allVerifiedArtist = $songAboutVerifiedArtistObj->fetchAllVerfied(1, 30, ' and status="Verified" ', $orderBySQL = "  artist_name DESC");
			
			$songCount = 0;
			$topAlbumHtml ="";
			$topAlbumHtml = '<div id="topAlbums" class="center">';
				$topAlbumHtml .= '<div id="topAlbumsTitle" class="center">';
					$topAlbumHtml .= 'VERIFIED ARTIST';
				$topAlbumHtml .= '</div>';
					foreach ($allVerifiedArtist as &$artistVerified) {					
						$topAlbumHtml .= '<div id="topAlbum-' . $artistAlbum["id"] . '" class="albumItem left">';
							$topAlbumHtml .= '<div class="albumItemImg">';
								$topAlbumHtml .= '<a href="/~songabou/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>|]~","",$artistVerified->artist_name)))  . '"><img src="' . $artistVerified->profile_image_url  . '" height="125" width="125"></a>';
							$topAlbumHtml .= '</div>';
							$topAlbumHtml .= '<span class="albumItemTitleFootnote"><strong>' . $artistVerified->artist_name . '</strong></span>';
						$topAlbumHtml .= '</div>';
					}
				$topAlbumHtml .= '</div>';
			echo $topAlbumHtml;			
		?>     		
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<?php 	include 'includes/footer.php'; ?>
