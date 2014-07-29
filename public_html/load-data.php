<?php

if (!isset($_GET['page'])) exit;
if (!isset($_GET['category'])) exit;
if (!isset($_GET['query'])) exit;

$page = $_GET['page'];
$category = $_GET['category'];
$currentSearchString = $_GET['query'];

$array = array();
$resultHtml = '';

//set the url first
switch ($category) {
	case 'ablums':
		$url = 'http://ws.audioscrobbler.com/2.0/?method=album.search&album=' . $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=30&page=' . $page;
		break;
	case 'songs':
		$url = 'http://ws.audioscrobbler.com/2.0/?method=track.search&track='. $currentSearchString .'&api_key=2b79d5275013b55624522f2e3278c4e9&format=json&limit=30&page=' . $page;
		break;
	default:
		break;
}

if($category == "songs")
{
	$songSearchResults=getCurlData($url);
	$songSearchResultsJSON = json_decode($songSearchResults);

	$totalNum = $songSearchResultsJSON->results->{'opensearch:totalResults'};

	if($page > $totalNum / 30)
		break;

	foreach ($songSearchResultsJSON->results->trackmatches->track as &$songSearchResultItem) {
	
		$artistname = $songSearchResultItem->artist;
		$artistname = '"'. $artistname . '"';
			
		$artistname =  json_decode($artistname);

		$resultHtml .= '<div class="left suggestedArtistItem">';

		$resultHtml .= '<div class="songItemTitle left">';
		$resultHtml .= '<a href="./song-detail.php?songName=' .$songSearchResultItem->name. '&artistName='. $artistname . '">';
		$resultHtml .= $songSearchResultItem->name . '</a><br>';
		$resultHtml .= '<span class="songItemTitleFootnote">'. $artistname .'</span></br>';	
		$resultHtml .= "</div>";
		$resultHtml .= "</div>";
	}
}

if($category == "ablums")
{
	$albumSearchResults = getCurlData($url);
	$albumSearchResultsJSON = json_decode($albumSearchResults);

	$totalNum = $albumSearchResultsJSON->results->{'opensearch:totalResults'};

	if($page > $totalNum / 30)
		break;

	foreach ($albumSearchResultsJSON->results->albummatches->album as &$artistSearchAlbumResultItem) 
	{
		$artistname = $artistSearchAlbumResultItem->artist;
		$artistname = json_decode('"' . $artistname . '"');

		$resultHtml .= '<div class="albumItem left">';	
		$resultHtml .= '<div class="albumItemImg">';
		if($artistSearchAlbumResultItem->image[2]->{'#text'} != "") 
		{
			$resultHtml .= '<img src="' . $artistSearchAlbumResultItem->image[2]->{'#text'} . '" height="125" width="125">';
		}
		else
		{
			$resultHtml .= '<img src="' . $artistSearchAlbumResultItem->image[1]->{'#text'} . '" height="125" width="125">';
		}
		$resultHtml .= '</div>'; 
		$resultHtml .= '<span class="albumItemTitleFootnote"><strong><a href="./album-detail.php?albumName=' . $artistSearchAlbumResultItem->name .'&artistName=' . $artistname .'">'. $artistSearchAlbumResultItem->name .'</a></strong><br>' . $artistname . "</span>";
		$resultHtml .= '</div>';
	}			
}



array_push($array, $resultHtml);

echo json_encode($array);


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
?>