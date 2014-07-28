<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>

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
	
	// Homepage Caching Objects
	require_once '../songabout_lib/models/PopularArtistCache.php';
	require_once '../songabout_lib/models/PopularSongCache.php';
	require_once '../songabout_lib/models/PopularAlbumCache.php';	
	
	// LyricFind API
	$LFDisplayAPI = 'd8a05b1cf5bd9e2a5761abf57543b013';
	$LFSearcAPIh = '55df723c07e5f02e52efd263c3a0d070'; 
	$LFMetadataAPI = 'fa00dc1d536580b258963f1dedef189b';
	$LFChartsAPI = '9b90fb74bdc84213310b43e7642b133e';
	
	require_once 'includes/staffPicksVar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="" type="image/x-icon" >
<meta name="robots" content="index, follow" />
<meta name="Description" content="Where you go to find out about a song." />
<meta name="Keywords" content="Music, Song Lyrics, Song About, Song Meaning" />
<meta name="Author" content="SongAbout.fm" />
<meta property="og:title" content="SongAbout.fm - Where you go to find out about a song." />
<meta property="og:title" content="Song meanings about artist, songs and albums in the artist's own words." />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://www.songabout.fm" />
<meta property="og:image" content="images/logos/songaboutNavLogo.png" />
<link rel="shortcut icon" href="http://www.songabout.fm/favicon.ico" type="image/x-icon">
<title><?php echo $pageTitle ?></title>
<!-- Bootstrap core CSS -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="styles/main2.css" rel="stylesheet">
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script async src="http://assets.bop.fm/embed.js"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div id="mainNav" class="navbar navbar-inverse" role="navigation">
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
  <a id="logoPic" href="http://www.songabout.fm"><img class="navbar-brand" src="images/logos/SALogo.png"/></a> <a id="logoText" class="navbar-brand" style="color:#FFF; padding-left: 0;" href="http://www.songabout.fm">SONGABOUT</a>
  <ul id="quickNav" class="nav navbar-nav navbar-left navbar-collapse collapse">
    <li><a href="#">LYRICS</a></li>
    <li><a href="#">ARTISTS</a></li>
    <li><a href="#">ALBUMS</a></li>
    <li><a href="#">REVIEWS</a></li>
    <!---FOR FUTURE USE
            <li><a href="#">CONCERTS</a></li>--->
  </ul>
  <ul id="memberNav" class="nav navbar-nav navbar-right navbar-collapse collapse">
    <li><a href="#">SIGN IN</a></li>
    <li><a href="#">REGISTER</a></li>
  </ul>
	<div id="searchForm" class="navbar-right">
  <span style="display:none"><?php include 'includes/alphabetWidget.php'; ?></span>
  <form class="navbar-form" action="search-results.php?=">
    <input id="search" name="search" class="form-control" placeholder="Search for artists, albums, lyrics..." type="text">
    <button id="hidden"></button>
    <button id="button" class="btn glyphicon glyphicon-search"></button>
  </form>
  </div>
</div>
<div id="features"> <!--<img class="lazy" data-original="images/aboutHeaderImage.png" width="100%">--> 
<img class="lazy" data-original="images/notes3.jpg" width="100%">
</div>
<div class="main-content">
<div class="container-fluid">
<div id="topAlbums" class="col-md-9">
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
<div id="popArtists" class="col-md-3">
  <h2 class="sub-header">Popular Artists</h2>
  <?php       
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
                                    $artistHtml .= '<a href="/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()&<>,|]~","",$artist->artist_name)))  . '">' . $artist->artist_name . '</a>';
                            $artistHtml .= '</div>';
                        }
                    }
                    $artistHtml .= '<span class="clear"></span>';
                $artistHtml .= '</div>';
                echo $artistHtml;		
            ?>
</div>
<div id="trendingLyrics">
  <h2 class="sub-header">Trending Lyrics on SongAbout</h2>
  8- 10 constantly updated songs </div>
<div id="topLyrics">
  <h2 class="sub-header">Top Lyrics</h2>
</div>
<div id="popSongs">
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
		//$topSongObj->updateDailyData();
		$topSongs = $topSongObj->fetchAllSongs(1, 12, 'All', '', '', '  day_rating DESC');
                    $songCount = 0;
                    foreach ($topSongs as &$song) {	
                                    //clean the string as much as possible removing of characters such as ? and encoding the rest.
                                    $songHtml .= '<tr>
									<td>'.($songCount + 1).'</td>';
							//		$songHtml .= '<td><a id="songPlayerCoverImgPlayer" data-width="600" data-bop-link href="http://www.bop.fm/embed/' . $song->artist_name .'/'.$song->song_title.'">'.$song->artist_name.' - '.$song->song_title.'</a></td>'; 
$songHtml .= '<td><a href="/artist/' . str_replace("+","-",urlencode(preg_replace('~[\\\\/:*?"<>,|]~',"",$song->artist_name))) . '/song/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'()<>,|]~","",$song->song_title))) . '">' . stripslashes($song->song_title) . '</a>';
                                    $songHtml .= '<p class="songItemTitleFootnote">' . stripslashes($song->artist_name) . "</p></td></tr>";
									$songCount++;
				        if($songCount >= 12) {
                            break;
                    	}
					}
                echo $songHtml;
		?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="styles/jquery.lazyload.min.js"></script> 
<script src="bootstrap/js/bootstrap.js"></script> 
<script>
		$(document).ready(function() {
			var winWidth = $(window).width();
			var winHeight = $(window).height();
			ReSizer(winWidth);
			
			$(window).scroll(sticky_relocate);
    		sticky_relocate();
			$("img.lazy").lazyload({		
				effect: "fadeIn",
				skip_invisible: false
			});
			$("div.lazy").lazyload({		
				effect: "fadeIn",
				skip_invisible: false
			});
			$(window).resize(function() {
				var nw = $(window).width();
				var nh = $(window).height();
				ReSizer(nw);
			});
        }); //end doc.ready
		function sticky_relocate() {
			if($(window).scrollTop() > 20) {
				$("#mainNav").addClass("navbar-fixed-top");
				$("body").addClass("scrollBody");
			}
			else {
				$("#mainNav").removeClass("navbar-fixed-top");
				$("body").removeClass("scrollBody");
			}
			var p = $("#search").position();
			$("#searchForm #button").css("top", p.top);
			$("#hidden").css("right", p.right);
			var currRight = parseInt($("#hidden").css("right"), 10);
			$("#searchForm #button").css("right", currRight );
		}
		function ReSizer(width) {
			if(width > 768) {
				var sw = width - $("#logoPic").width() - $("#logoText").width() - $("#quickNav").width() - $("#memberNav").width() - 100;
				if(sw > 200)
					$("#searchForm").css("width", sw);
				else
					$("#searchForm").css("width", "100%");
			} //endif
			else {
				$("#searchForm").css("width", "100%");
				$("#searchForm form").css("float", "right");
				$("#searchForm form").css("clear", "both");
				$("#search").css("float", "left");
				
			}
			var p = $("#search").position();
			$("#searchForm #button").css("top", p.top);
			$("#hidden").css("right", p.right);
			var currRight = parseInt($("#hidden").css("right"), 10);
			$("#searchForm #button").css("right", currRight );
			var string = "dimensions: ";
	//		cropImg(".artistImg img");
		}
		function cropImg(attribute) {
			if(attribute = ".artistImg img") {
				$(".artistImg").height($(".artistImg").width());
				$(".albumImg").height($(".albumImg").width());
			}
			$(attribute).each(function(i) {
				var name = $(this).attr("name");
				var w = $(this).width();
				if (name == "width") {
					$(this).animate({
					height: w
				}, 50, function(){
					width: "auto"
				});
				}
			});
		}
	</script>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';
?>